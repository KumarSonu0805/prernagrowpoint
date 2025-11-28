
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                    	<div class="row">
                        	<div class="col-md-4"><?php echo create_form_input("date","from","From",false,'',array("id"=>"from","class"=>"inputs")); ?></div>
                        	<div class="col-md-4"><?php echo create_form_input("date","to","To",false,'',array("id"=>"to","class"=>"inputs")); ?></div>
                            <div class="col-md-4 pt-3">
                            	<button type="button" class="btn btn-sm btn-success" id="searchbtn"><i class="fas fa-search"></i> Search</button>
<!--                                <a href="<?php echo base_url("wallet/exportpaymentreport/"); ?>" class="btn btn-sm btn-primary" id="exportbtn"><i class="fas fa-download"></i> Export</a>-->
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="result">
                                	<?php $this->load->view('wallet/paylist'); ?>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
                
    <script>
	
		var table;
		$(document).ready(function(e) {
			createDatatable();
			$('body').on('change','.inputs',function(){
				if($('#from').val()=='' && $('#to').val()==''){
					$('#exportbtn').attr("href","<?php echo base_url("wallet/exportpaymentreport/"); ?>").show();
				}else{
					$('#exportbtn').hide();
				}
			});
			$('body').on('click','#searchbtn',function(){
				var from=$('#from').val();
				var to=$('#to').val();
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("wallet/getpaylist"); ?>",
					data:{from:from,to:to},
					success: function(data){
						$('#result').html(data);
						createDatatable();
						var query="?from="+from+"&to="+to;
						$('#exportbtn').attr("href","<?php echo base_url("wallet/exportpaymentreport/"); ?>"+query).show();
					}
				});
			});
        });
		
		function createDatatable(){
			$('#status').html('');
            table=$('#bootstrap-data-table-export').DataTable();
			table.columns('.select-filter').every(function(){
				var that = this;
				var pos=$('#status');
				// Create the select list and search operation
				var select = $('<select class="form-control" />').appendTo(pos).on('change',function(){
								that.search("^" + $(this).val() + "$", true, false, true).draw();
							});
					select.append('<option value=".+">All</option>');
				// Get the search data for the first column and add to the select list
				this.cache( 'search' ).sort().unique().each(function(d){
						select.append($('<option value="'+d+'">'+d+'</option>') );
				});
			});
			$('#member_id').on('keyup',function(){
				table.columns(1).search( this.value ).draw();
			});
			$('#result').find('table').parent().addClass('table-responsive');
		}
		function validate(){
			if(!confirm("Confirm Payout of this Member?")){
				return false;
			}
		}
	</script>
    
    	

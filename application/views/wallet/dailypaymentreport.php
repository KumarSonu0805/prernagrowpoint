<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="result">
                                	<table id="bootstrap-data-table-export" class="table table-bordered">
                                    	<thead>
                                        	<tr>
                                            	<th>Sl.No.</th>
                                                <th>Date</th>
                                                <th>Total Payable</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php
                                            	if(is_array($payments)){$i=0;
													foreach($payments as $payment){$i++;
											?>
                                        	<tr>
                                            	<td><?php echo $i; ?></td>
                                            	<td><?php echo date('d-m-Y',strtotime($payment['approve_date'])); ?></td>
                                            	<td><?php echo $this->amount->toDecimal($payment['total_amount']); ?></td>
                                            	<td>
													<a href="<?php echo base_url('wallet/exportpaymentreport/?type=pay&from='.$payment['approve_date'].'&to='.$payment['approve_date']); ?>" 
                                                    	class="btn btn-sm btn-primary">
                                                    	<i class="fa fa-download"></i> Download List
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
													}
												}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>	
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

                
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
    
    	

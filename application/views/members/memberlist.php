
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 hidden">
                                <input type="date" id="from" class="form-control">
                            </div>
                            <div class="col-3 hidden">
                                <input type="date" id="to" class="form-control">
                            </div>
                            <div class="col-md-3" id="status"></div>
                        </div><br>
                        <div class="row">
                            <div class="col-12">                            
                                <div class="table-responsive" id="result">
                                    <?php $this->load->view('members/membertable'); ?>
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
			$('#position,#from,#to').change(function(){
				getResult();
			});
        });
		
        function getResult(){
            var position=$('#position').val();
            var from=$('#from').val();
            var to=$('#to').val();
            $('#member_id').val('');
            $.ajax({
                type:"POST",
                url:"<?php echo base_url('members/getmembertable'); ?>",
                data:{position:position,from:from,to:to},
                beforeSend: function(){
                    $('#loading').show();
                },
                success: function(data){
                    $('#result').html(data);
                    createDatatable();
                    $('#loading').hide();
                },
                error: function(data){
                    alert(JSON.stringify(data))
                }
            });
        }
                
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
		}
		function validate(){
			if(!confirm("Confirm Activate this Group?")){
				return false;
			}
		}
	</script>
    
    	

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
                                    <table class="table data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Member ID</th>
                                                <th>Member Name</th>
                                                <th>Category</th>
                                                <th>Reward</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $members=$members;
                                                if(is_array($members)){$i=0;
                                                    foreach($members as $member){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $member['username']; ?></td>
                                                <td><?php echo $member['name']; ?></td>
                                                <td><?php echo $member['category']; ?></td>
                                                <td><?php echo $member['reward']; ?></td>
                                                <td>
													<?php
                                                        if($this->session->role=='admin' && $member['status']==0){
                                                    ?>
                                                    <form action="<?php echo base_url('wallet/approvereward'); ?>" method="post" onSubmit="return validate('accept');" class="float-left" style="margin-right:5px;">
                                                        <button type="submit" value="<?php echo $member['id'] ?>" name="request_id" class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                	<?php  
														}
														else{
															echo "<span class='text-success'>Approved On ".date('d-m-Y',strtotime($member['approve_date']))."</span>";
														} 
													?>
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
			$('#position').change(function(){
				var position=$(this).val();
				$('#member_id').val('');
				$.ajax({
					type:"POST",
					url:"<?php echo base_url('members/getmembertable'); ?>",
					data:{position:position},
					success: function(data){
						$('#result').html(data);
						createDatatable();
					}
				});
			});
			$('body').on('click','.approve-all',function(){
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("wallet/approveallpayout"); ?>",
					beforeSend: function(data){
						$('#details,#result').hide();
						$('#loader').removeClass('hidden');
					},
					success: function(data){
						$('#loader').addClass('hidden');
						$('#success').removeClass('hidden');
						window.location="<?php echo base_url('wallet/exportpaymentreport/?from='); ?>"+data+"&to="+data+"&type=pay";
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
		function validate(type){
			if(type=='accept'){
				msg="Approve Reward of this Member?";
			}
			else{
				msg="Confirm Reject Payment of this Member?";
			}
			if(!confirm(msg)){
				return false;
			}
		}
	</script>
    
    	

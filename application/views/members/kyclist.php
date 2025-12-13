
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-1 mb-1" id="status"></div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">                            
                                <div class="table-responsive" id="result">
                                    <table class="table data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Member ID</th>
                                                <th>Member Name</th>
                                                <th>View Aadhar</th>
                                                <th>View Pan</th>
                                                <th>View Cancelled Cheque/Passbook</th>
                                                <?php
                                                    if($this->session->role=='admin' && $title=='Member KYC Requests'){
                                                ?>
                                                <th class="">Status</th>
                                                <th>Action</th>
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $members=$members;
                                                if(is_array($members)){$i=0;
                                                    foreach($members as $member){
                                                        $i++;
                                                        $pansrc=file_url($member['pan']);
                                                        $pan='<button type="button" class="btn btn-sm btn-info mb-1 view" data-toggle="modal" data-target="#mediumModal" value="'.$pansrc.'">PAN Card</button>';
                                                        $aadhar1src=file_url($member['aadhar1']);
                                                        $aadhar1='<button type="button" class="btn btn-sm btn-info mb-1 view" data-toggle="modal" data-target="#mediumModal" value="'.$aadhar1src.'">Aadhar Front</button>';
                                                        $aadhar2src=file_url($member['aadhar2']);
                                                        $aadhar2='<button type="button" class="btn btn-sm btn-info mb-1 view" data-toggle="modal" data-target="#mediumModal" value="'.$aadhar2src.'">Aadhar Back</button>';
                                                        $chequesrc=file_url($member['cheque']);
                                                        $cheque='<button type="button" class="btn btn-sm btn-info mb-1 view" data-toggle="modal" data-target="#mediumModal" value="'.$chequesrc.'">';
                                                        $cheque.='Cancelled Cheque/Passbook</button>';
                                                        if($member['kyc']==0){ 
                                                            $status="<span class='text-danger'>KYC Not Done</span>"; 
                                                            $pan=$cheque='';
                                                        }
                                                        elseif($member['kyc']==1){ 
                                                            $status="<span class='text-success'>KYC Approved</span>"; 
                                                        }
                                                        else{ 
                                                            $status="<span class='text-warning'>KYC Pending</span>"; 
                                                        }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $member['username']; ?></td>
                                                <td><?php echo $member['name']; ?></td>
                                                <td><?php echo $aadhar1." ".$aadhar2; ?></td>
                                                <td><?php echo $pan; ?></td>
                                                <td><?php echo $cheque; ?></td>
                                                <?php
                                                    if($this->session->role=='admin' && $title=='Member KYC Requests'){
                                                ?>
                                                <td><?php echo $status; ?></td>
                                                <td>
                                                    <?php
                                                        if($member['kyc']==2){
                                                    ?>
                                                    <form action="<?php echo base_url('members/approvekyc/'); ?>" method="post" onSubmit='return validate();'>
                                                        <input type="hidden" name="regid" value="<?php echo $member['regid']; ?>">
                                                        <button type="submit" value="1" name="kyc" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Approve KYC</button>
                                                        <?php if($reject_kyc===true){ ?>
                                                        <button type="submit" value="3" name="kyc" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Reject KYC</button>
                                                        <?php } ?>
                                                    </form>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <?php
                                                    }
                                                ?>
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
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="mediumModalLabel"></h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" id="img-popup" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    <script>
	
		var table;
		$(document).ready(function(e) {
			createDatatable();
			$('body').on('click','.view',function(){
				$('#img-popup').attr('src','');
				var src=$(this).val();
				$('#img-popup').attr('src',src);
				$('#mediumModalLabel').text($(this).text());
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
								that.search($(this).val()).draw();
							});
					select.append('<option value="">All</option>');
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
			var status=$(document.activeElement).val();
			if(status==3){ msg="Reject"; }
			else if(status==1){ msg="Approve"; }
			if(!confirm(msg+" KYC of this Member?")){
				return false;
			}
		}
	</script>
    
    	

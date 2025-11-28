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
                                    <table class="table table-bordered data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Date Time</th>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <th>Receiver's Id</th>
                                                <th>Receiver's Name</th>
                                                <?php } ?>
                                                <th>Sender's Id</th>
                                                <th>Sender's Name</th>
                                                <th>Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $transfers=$transfers;
                                                if(is_array($transfers)){$i=0;
                                                    foreach($transfers as $transfer){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y H:i A',strtotime($transfer['added_on'])); ?></td>
                                                <?php if($this->session->role=='admin'){ ?>
                                                <td><?php echo $transfer['to_id']; ?></td>
                                                <td><?php echo $transfer['to_name']; ?></td>
                                                <?php } ?>
                                                <td><?php echo $transfer['from_id']; ?></td>
                                                <td><?php echo $transfer['from_name']; ?></td>
                                                <td><?php echo $this->amount->toDecimal($transfer['amount']); ?></td>
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
		}
		function validate(){
			if(!confirm("Confirm Payout of this Member?")){
				return false;
			}
		}
	</script>
    
    	

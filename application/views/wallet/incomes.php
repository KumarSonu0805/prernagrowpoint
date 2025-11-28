
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                    	<div class="row">
                        	<div class="col-md-4">
                            	<div id="staus"></div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" id="result">
                                    <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No</th>
                                                <th>Date</th>
                                                <th>Income</th>
                                                <th class="select-filter">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $incomes=$incomes;
                                                if(is_array($incomes)){$i=0;
                                                    foreach($incomes as $income){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php if($income['date']!=''){echo date('d-m-Y',strtotime($income['date']));} ?></td>
                                                <td><?php echo $this->amount->toDecimal($income['amount']); ?></td>
                                                <td><?php echo $income['remarks']; ?></td>
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
				},
				error: function(data){
					alert(JSON.stringify(data))
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
</script>
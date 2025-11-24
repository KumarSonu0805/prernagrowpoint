
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                 <table class="table data-table stripe hover nowrap table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="table-plus">Sl No.</th>    
                                                            <th>Employee ID</th>   
                                                            <th>Name</th>        
                                                            <th>Mobile</th>
                                                            <th>Email</th>
                                                            <th class="datatable-nosort">Action</th>
                                                        </tr>
                                                    </thead>
                                                     <tbody>
                                                        <?php
                                                        if(is_array($employees)){$i=0;
                                                            foreach($employees as $list){$i++;
                                                        ?>
                                                        <tr>
                                                            <td class="table-plus"><?php echo $i; ?></td>
                                                            <td><?php echo $list['id']; ?></td>
                                                            <td><?php echo $list['name']; ?></td>                                 
                                                            <td><?php echo $list['mobile']; ?></td>
                                                            <td><?php echo $list['email']; ?></td>
                                                            <td>
                                                               <a href="<?php echo base_url('employees/trackemployee/'.md5($list['user_id']));?>"><button type="button" class="btn btn-sm text-white btn-warning"><i class="fas fa-location-arrow"></i></button></a>
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
                        
<script>
	
	$(document).ready(function(e) {
		

        var table=$('.data-table').DataTable({
			scrollCollapse: true,
			autoWidth: false,
			responsive: true,
			columnDefs: [{
				targets: "datatable-nosort",
				orderable: false,
			}],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		});
    });
</script>

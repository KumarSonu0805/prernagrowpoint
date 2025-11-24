
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
                                                            <th>Photo</th>   
                                                            <th>Name</th>                                 
                                                            <th>Father's Name</th>
                                                            <th>DOB</th>
                                                            <th>Mobile<br>(Login Username)</th>
                                                            <th>Email</th>
                                                            <th>Address</th>
                                                            <th>Gender</th>
                                                            <th>DOJ</th>
                                                            <th>Password</th>
                                                            <th class="datatable-nosort">Action</th>
                                                        </tr>
                                                    </thead>
                                                     <tbody>
                                                        <?php
                                                        if(is_array($employees)){$i=0;
                                                            foreach($employees as $list){$i++;
                                                        ?>
                                                        <tr>
                                                            <td class="table-plus"><?= $i; ?></td>
                                                            <td><img src="<?= $list['photo']; ?>" height="50" width="80" alt="image"></td>
                                                            <td><?= $list['name']; ?></td>
                                                            <td><?= $list['fname']; ?></td>
                                                            <td><?= !empty($list['dob'])?date('d-m-Y',strtotime($list['dob'])):'--'; ?></td>                                      
                                                            <td><?= $list['mobile']; ?></td>
                                                            <td><?= $list['email']; ?></td>
                                                            <td><?= $list['address']; ?></td>
                                                            <td><?= $list['gender']; ?></td>
                                                            <td><?= $list['date_of_join']; ?></td>
                                                            <td>
                                                                <a href="#" onClick="$(this).hide();$(this).next().show();return false;">View Password</a>
                                                                <p style="display: none;"><?= $list['password'] ?> <a href="#" onClick="$(this).parent().hide();$(this).parent().prev().show();return false;" class="text-danger"><i class="fa fa-times"></i></a></p>
                                                            </td>
                                                            <td>
                                                               <a href="<?= base_url('employees/editemployee/'.md5($list['id']));?>"  class="btn btn-xs text-white btn-warning"><i class="fa fa-edit"></i></a>
                                                                <?php if($this->session->role=='admin' && false){  ?>
                                                                <button type="button" value="<?= $list['id']; ?>" class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash"></i></button>
                                                                <?php } ?>
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
        $('body').on('click','.delete-btn',function(){
            if(confirm("Confirm delete this Employee?")){
                var id=$(this).val();
                $.ajax({
                    type:"post",
                    url:"<?= base_url('employees/updateemployee'); ?>",
                    data:{id:id,status:0,updateemployee:'updateemployee'},
                    success:function(data){
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>

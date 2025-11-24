
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed" id="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No.</th>
                                                                <th>Name</th>
                                                                <th>Mobile</th>
                                                                <th>Email</th>
                                                                <th>Address</th>
                                                                <th>Area</th>
                                                                <th>Beat</th>
                                                                <?php /*?><th>Images</th><?php */?>
                                                                <th>GST</th>
                                                                <th>Added By</th>
                                                                <th>Password</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                                if(!empty($dealers)){$i=0;
                                                                    foreach($dealers as $dealer){ $i++;
                                                                        $status='<i class="fa fa-times text-danger"></i>';
                                                                        if($dealer['user_status']==1){
                                                                            $status='<i class="fa fa-check text-success"></i>';
                                                                        }
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $dealer['name']; ?></td>
                                                                <td><?= $dealer['mobile']; ?></td>
                                                                <td><?= $dealer['email']; ?></td>
                                                                <td><?= $dealer['address'].', '.$dealer['district_name'].', '.$dealer['state_name'].', PIN-'.$dealer['pincode']; ?></td>
                                                                <td><?= $dealer['area_name']; ?></td>
                                                                <td><?= $dealer['beat_name']; ?></td>
                                                                <?php /*?><td>
                                                                    <button type="button" class="btn btn-default btn-sm view-btn waves-effect" data-toggle="modal" data-target="#default-Modal" data-title="Aadhar Image" data-src="<?= file_url($dealer['aadhar']); ?>"><i class="fa fa-eye"></i> Aadhar</button>
                                                                    <button type="button" class="btn btn-default btn-sm view-btn waves-effect" data-toggle="modal" data-target="#default-Modal" data-title="PAN Image" data-src="<?= file_url($dealer['pan']); ?>"><i class="fa fa-eye"></i> PAN</button>

                                                                </td><?php */?>
                                                                <td><?= $dealer['gst_no']; ?></td>
                                                                <td><?= $dealer['added_by']; ?></td>
                                                                <td>
                                                                    <a href="#" onClick="$(this).hide();$(this).next().show();return false;">View Password</a>
                                                                    <p style="display: none;"><?= $dealer['password'] ?> <a href="#" onClick="$(this).parent().hide();$(this).parent().prev().show();return false;" class="text-danger"><i class="fa fa-times"></i></a></p>
                                                                </td>
                                                                <td><?= $status; ?></td>
                                                                <td>
                                                                    <?php /*?><a href="<?= base_url('dealers/editdealer/'.md5($dealer['user_id']).'/'); ?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                                                    <?php if($this->session->role=='admin'){  ?>
                                                                    <button type="button" value="<?= $dealer['id']; ?>" class="btn btn-danger btn-xs delete-btn"><i class="fa fa-trash"></i></button>
                                                                    <?php } ?>
                                                                    <?php if($dealer['user_status']==0){ ?>
                                                                    <button type="button" value="<?= md5($dealer['user_id']) ?>" class="btn btn-xs btn-success approve">Approve Vendor</button>
                                                                    <?php } ?><?php */?>
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

<div class="modal fade" id="default-Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="preview" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(e) {
        $('#table').dataTable();
        $('body').on('click','.view-btn',function(){
            var src=$(this).data('src');
            var title=$(this).data('title');
            $('.modal-title').text(title);
            $('#preview').attr('src',src);
        });
        $('body').on('click','.approve',function(){
            if(confirm("Confirm Approve this dealer?")){
                var $this=$(this);
                var id=$(this).val();
                $.ajax({
                    type:"post",
                    url:"<?= base_url('dealers/approvedealer'); ?>",
                    data:{id:id,approvedealer:'approvedealer'},
                    success:function(data){
                        data=JSON.parse(data);
                        if(data['status']==true){
                            $this.closest('td').prev().html('<i class="fa fa-check text-success"></i>');
                            $this.remove();
                        }
                    }
                });
            }
        });
        $('body').on('click','.delete-btn',function(){
            if(confirm("Confirm delete this dealer?")){
                var id=$(this).val();
                $.ajax({
                    type:"post",
                    url:"<?= base_url('dealers/updatedealer'); ?>",
                    data:{id:id,status:0,updatedealer:'updatedealer'},
                    success:function(data){
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
                                
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <?= form_open_multipart('expenses/addexpensehead/'); ?>
                                                    <div class="form-group row my-2">
                                                        <label class="col-12 col-form-label">Expense Head</label>
                                                        <div class="col-12">
                                                            <input type="text" class="form-control" name="name" id="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-12 col-form-label">Description</label>
                                                        <div class="col-12">
                                                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row my-2">
                                                        <label class="col-12 col-form-label"></label>
                                                        <div class="col-12">
                                                            <input type="hidden" name="id" id="id">
                                                            <input type="submit" class="btn btn-success btn-sm" name="addexpensehead" value="Save Expense Head">
                                                            <button type="button" class="btn btn-danger btn-sm cancel-btn hidden">Cancel</button>
                                                        </div>
                                                    </div>
                                                <?= form_close(); ?>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="table-responsive" id="table-div">
                                                    <table class="table table-condensed" id="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No.</th>
                                                                <th>Expense Head</th>
                                                                <th>Description</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if(!empty($expenseheads)){ $i=0;
                                                                foreach($expenseheads as $single){
                                                                    $i++;
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= $single['name']; ?></td>
                                                                <td><?= $single['description']; ?></td>
                                                                <td>
                                                                    <button type='button' class='btn btn-sm btn-info edit-btn' value='<?= $single['id'] ?>'><i class='fa fa-edit'></i></button>
                                                                    <button type='button' class='btn btn-sm btn-danger delete-btn' value='<?= md5('expensehead-id-'.$single['id']) ?>'><i class='fa fa-trash'></i></button>
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

                            <script>
                                var names=[];
                                $(document).ready(function(e) {
                                    $('#name').keyup(function(){
                                        //if($('#id').val()==''){
                                            var name=$(this).val();
                                            $.ajax({
                                                type:"POST",
                                                url:"<?= base_url('expenses/getslug/'); ?>",
                                                data:{name:name},
                                                success: function(data){
                                                    $('#slug').val(data);
                                                }
                                            });
                                        //}
                                    });
                                    $('body').on('click','#company-btn',function(){
                                        $('#company-ref_id').val('#company_id');
                                        $('#companyModal input.form-control').val('');
                                        $('#companyModal .response').text('');
                                    });
                                    $('table').on('click','.edit-btn',function(){
                                        $.ajax({
                                            type:"post",
                                            url:"<?= base_url('expenses/getexpensehead/'); ?>",
                                            data:{id:$(this).val()},
                                            success:function(data){
                                                data=JSON.parse(data);
                                                $('#name').val(data['name']);
                                                $('#description').val(data['description']);
                                                $('#id').val(data['id']);
                                                $('.cancel-btn').removeClass('hidden');
                                                $('input[name="addexpensehead"]').attr('name','updateexpensehead').val('Update Expense Head');
                                            }
                                        });
                                    });
                                    $('.cancel-btn').click(function(){
                                        $('#name,#slug,#description,#company_id,#id,#image').val('');
                                        $('.cancel-btn').addClass('hidden');
                                        $('input[name="updateexpensehead"]').attr('name','addexpensehead').val('Save Expense Head');
                                        $('#parent_id option').show();
                                    });
                                    $('#table').dataTable();
                                    $('body').on('click','.delete-btn',function(){
                                        if(confirm("Confirm Delete Expense Head? All expenses of this Head will also be deleted!")){
                                            $.post('<?= base_url('expenses/deleteexpensehead'); ?>',{expensehead_id:$(this).val()},function(){
                                                window.location.reload();
                                            });   
                                        }
                                    });
                                });
                                
                            </script>
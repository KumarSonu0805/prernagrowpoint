
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <?= form_open_multipart('expenses/addexpensepayment/'); ?>
                                                            <div class="form-group row">
                                                                <label class="col-12 col-form-label">Date</label>
                                                                <div class="col-12">
                                                                    <input type="date" class="form-control" name="date" id="date" required value="<?= date('Y-m-d'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-12 col-form-label">User</label>
                                                                <div class="col-12">
                                                                    <?= form_dropdown('user_id',$users,'',array('class'=>'form-control','id'=>'user_id','required'=>'true')); ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-12 col-form-label">Amount</label>
                                                                <div class="col-12">
                                                                    <input type="text" class="form-control" name="amount" id="amount" required >
                                                                </div>
                                                            </div>
                                                            <div class="form-group row my-2">
                                                                <label class="col-12 col-form-label">Remarks</label>
                                                                <div class="col-12">
                                                                    <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row my-2">
                                                                <label class="col-12 col-form-label"></label>
                                                                <div class="col-12">
                                                                    <input type="hidden" name="type" id="type"  value="credit">
                                                                    <input type="hidden" name="id" id="id">
                                                                    <input type="submit" class="btn btn-success btn-sm" name="addexpensepayment" value="Save Expense Payment">
                                                                    <button type="button" class="btn btn-danger btn-sm cancel-btn hidden">Cancel</button>
                                                                </div>
                                                            </div>
                                                        <?= form_close(); ?>
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
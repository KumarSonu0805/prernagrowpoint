                                
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header"><?= $title; ?></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <?= form_open_multipart('masterkey/savearea/'); ?>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">State</label>
                                                                <div class="col-sm-10">
                                                                    <?= create_form_input('select','state_id','',true,'',array('id'=>'state_id'),$states) ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">District</label>
                                                                <div class="col-sm-10">
                                                                    <?= create_form_input('select','district_id','',true,'',array('id'=>'district_id'),array(''=>'Select District')) ?>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label">Area</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control" name="name" id="name" required>
                                                                    <input type="hidden" name="id" id="id">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-sm-2 col-form-label"></label>
                                                                <div class="col-sm-10">
                                                                    <input type="submit" class="btn btn-success waves-effect waves-light" name="savearea" value="Save Area">
                                                                    <button type="button" class="btn btn-danger waves-effect waves-light cancel-btn hidden">Cancel</button>
                                                                </div>
                                                            </div>
                                                        <?= form_close(); ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="tabulator-table"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

<script>
                                $(document).ready(function(e) {
                                    alertify.defaults.transition = "slide";
                                    alertify.defaults.theme.ok = "btn btn-primary";
                                    alertify.defaults.theme.cancel = "btn btn-danger";
                                    alertify.defaults.theme.input = "form-control";
                                    $('body').on('change','#state_id',function(){
                                        var district_id=$(this).attr('data-district_id');
                                        $.ajax({
                                            type:"post",
                                            url:"<?= base_url('masterkey/getdistrictdropdown/'); ?>",
                                            data:{state_id:$(this).val(),district_id:district_id},
                                            success:function(data){
                                                $('#district_id').replaceWith(data);
                                            }
                                        });
                                    });
                                    $('body').on('click','.edit-btn',function(){
                                        $.ajax({
                                            type:"post",
                                            url:"<?= base_url('masterkey/getarea/'); ?>",
                                            data:{id:$(this).val()},
                                            success:function(data){
                                                data=JSON.parse(data);
                                                $('#state_id').attr('data-district_id',data['district_id']);
                                                $('#state_id').val(data['state_id']).trigger('change');
                                                $('#name').val(data['name']);
                                                $('#id').val(data['id']);
                                                $('.cancel-btn').removeClass('hidden');
                                                $('input[name="savearea"]').attr('name','updatearea').val('Update Area');
                                            }
                                        });
                                    });
                                    $('.cancel-btn').click(function(){
                                        $('#state_id,#district_id,#name,#id,#image').val('');
                                        $('.cancel-btn').addClass('hidden');
                                        $('input[name="updatearea"]').attr('name','savearea').val('Save Area');
                                    });
                                    $('body').on('click','.delete-btn',function(){
                                        var id=$(this).val();
                                        alertify.confirm("Delete Area", "Are you sure you want to Delete this Area?", 
                                            function(){ 
                                                $.ajax({
                                                    type:"post",
                                                    url:"<?= base_url('masterkey/deletearea/'); ?>",
                                                    data:{id:id},
                                                    success:function(data){
                                                        refreshTableData();
                                                        alertify.success("Area Deleted Successfully!");
                                                    }
                                                });
                                            },
                                            function(){ alertify.error("Delete Area Cancelled!"); }
                                        ).set('labels', {ok:'Delete Area'});
                                    });

                                    var url="<?= base_url('masterkey/area/?type=data'); ?>";
                                    var columns=[
                                            { 
                                                title: "Sl.No.", 
                                                field: "serial", 
                                                type: "auto"
                                            },
                                            { title: "Area", field: "name" },
                                            { title: "State", field: "state_name" },
                                            { title: "District", field: "district_name" },
                                            { 
                                                title: "Action", 
                                                field: "id", 
                                                formatter: function(cell) {
                                                    let id = cell.getValue();
                                                    let button=`<button type="button" class="btn btn-xs btn-info edit-btn" value="${id}"><i class="fa fa-edit"></i></button>`;
                                                    button+=` <button type="button" class="btn btn-xs btn-danger delete-btn" value="${id}"><i class="fa fa-trash"></i></button>`;
                                                    return button;
                                                } 
                                            }
                                        ];
                                    
                                    var pagination={
                                        sizes:[10, 20, 50, 100]
                                    }
                                    
                                    var table=createTabulator('tabulator-table',url,columns,pagination);
                                    
                                    function refreshTableData() {
                                        table.replaceData(url);
                                    }

                                    $('body').on('keyup','#searchInput',function(){
                                        let value = $(this).val().toLowerCase();
                                        console.log(value);
                                        table.setFilter(function(data) {
                                            return Object.values(data).some(field => 
                                                field !== null && field !== undefined && field.toString().toLowerCase().includes(value)
                                            );
                                        });
                                    });

                                    $('body').on('click','#clearSearch',function(){
                                        document.getElementById("searchInput").value = "";
                                        table.clearFilter();
                                    });
                                    $('body').on('change','#state_id',function(){
                                        if($(this).val()=='new'){
                                            $(this).parent().append('<?= trim(create_form_input('text','state_val','',true,'',array('id'=>'state_val','class'=>'mt-2'))); ?>');
                                        }
                                        else{
                                            $('#state_val').remove();
                                        }
                                    });

                                    $('body').on('change','#district_id',function(){
                                        if($(this).val()=='new'){
                                            $(this).parent().append('<?= trim(create_form_input('text','district_val','',true,'',array('id'=>'district_val','class'=>'mt-2'))); ?>');
                                        }
                                        else{
                                            $('#district_val').remove();
                                        }
                                    });

                                });
                            </script>
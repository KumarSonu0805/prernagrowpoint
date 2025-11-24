                                
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header"><?= $title; ?></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="tabulator-table"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

<script>
                                $(document).ready(function(e) {

                                    var url="<?= base_url('employees/assignedbeats/?type=data'); ?>";
                                    var columns=[
                                            { 
                                                title: "Sl.No.", 
                                                field: "serial", 
                                                type: "auto"
                                            },
                                            { title: "Employee Name", field: "emp_name" },
                                            { title: "District", field: "district_name" },
                                            { title: "Area", field: "area_name" },
                                            { title: "Beat", field: "name" },
                                            { 
                                                title: "Status", 
                                                field: "status", 
                                                formatter: function(cell) {
                                                    let user_status = cell.getValue();
                                                    let status='<i class="fa fa-times text-danger"></i>';
                                                    if(user_status==1){
                                                        status='<i class="fa fa-check text-success"></i>';
                                                    }
                                                    return status;
                                                } 
                                            },
                                            { 
                                                title: "Action", 
                                                field: "id", 
                                                formatter: function(cell) {
                                                    let id = cell.getValue();
                                                    return '';
                                                } 
                                            }
                                        ];
                                    
                                    var pagination={
                                        sizes:[10, 20, 50, 100]
                                    }
                                    
                                    var table=createTabulator('tabulator-table',url,columns,pagination);
                                    
                                    function refreshTableData(newUrl='') {
                                        url=newUrl!=''?newUrl:url;
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

                                    $('body').on('change','.area_id',function(){
                                        var area_id=$(this).val();
                                        $this=$(this);
                                        $(this).closest('tr').find('.view-dealers').addClass('d-none');
                                        $('#tabulator-table').addClass('d-none');
                                        $.ajax({
                                            type:"post",
                                            url:"<?= base_url('masterkey/getbeatdropdown/'); ?>",
                                            data:{area_id:$(this).val(),beat_id:''},
                                            success:function(data){
                                                $this.closest('tr').find('.beat_id').replaceWith(data);
                                                $('#beat_id').removeAttr('id').addClass('beat_id').attr('name','beat_id[]');
                                            }
                                        });
                                        //var dealer_url="<?= base_url('dealers/dealerlist/?type=data'); ?>&area_id="+area_id;
                                        //refreshTableData(dealer_url);
                                    });

                                    $('body').on('change','.beat_id',function(){
                                        if($(this).val()!=''){
                                            $(this).closest('tr').find('.view-dealers').removeClass('d-none');
                                        }
                                    });
                                    $('body').on('click','.view-dealers',function(){
                                        var area_id=$(this).closest('tr').find('.area_id').val();
                                        var beat_id=$(this).closest('tr').find('.beat_id').val();
                                        var dealer_url="<?= base_url('dealers/dealerlist/?type=data'); ?>&area_id="+area_id+"&beat_id="+beat_id;
                                        refreshTableData(dealer_url);
                                        console.log(beat_id);
                                        if(beat_id!=''){
                                            $('#tabulator-table').removeClass('d-none');
                                        }
                                    });

                                    $('body').on('click','.add-btn',function(){
                                        var row='<tr>';
                                        row+=$(this).closest('tr').html();
                                        row+='</tr>'
                                        $(row).find('.view-dealers').addClass('d-none');
                                        $(this).addClass('remove-btn btn-danger').removeClass('add-btn btn-primary');
                                        $(this).html('<i class="fa fa-trash"></i>');
                                        $('table tbody').append(row);
                                    });
                                    $('body').on('click','.remove-btn',function(){
                                        $(this).closest('tr').remove();
                                    });
                                });
                            </script>
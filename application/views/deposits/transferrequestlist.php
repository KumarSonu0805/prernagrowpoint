
                            <div class="col-md-12">
                                <div class="card light-bg">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12 table-responsive">
                                                <table class="table table-striped data-table" id="bootstrap-data-table-export">
                                                    
                                                    <thead>
                                                        <tr>
                                                            <th>Sl.No.</th>
                                                            <th>Member ID</th>
                                                            <th>Member Name</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            if(!empty($donations)){$i=0;
                                                                foreach($donations as $single){
                                                                    $status="<span class='text-danger'>Not Complete</span>";
                                                                    if($single['status']==1){
                                                                        $status="<span class='text-success'>Completes</span>";
                                                                    }
                                                        ?>
                                                        <tr>
                                                            <td><?= ++$i; ?></td>
                                                            <td><?= $single['username'] ?></td>
                                                            <td><?= $single['name'] ?></td>
                                                            <td><?= $single['amount'] ?></td>
                                                            <td>
                                                                <?= $status ?>
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
                    
                    
                    function validate(type){
                        if(type=='accept'){
                            msg="Confirm <?= $title=='Activation Request List'?'Activation':'Deposit' ?> of this Member?";
                        }
                        else{
                            msg="Reject <?= $title=='Activation Request List'?'Activation':'Deposit' ?> of this Member?";
                        }
                        if(!confirm(msg)){
                            return false;
                        }
                    }
                </script>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
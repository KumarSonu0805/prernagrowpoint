
                                            <div class="card-body">
                                                <?php
                                                if($this->session->role!='superadmin'){
                                                ?>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="card bg-primary img-card box-primary-shadow">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="text-white">
                                                                        <h2 class="mb-0 number-font">₹<?= $this->amount->toDecimal($expense,false); ?></h2>
                                                                        <p class="text-white mb-0">Expenses </p>
                                                                    </div>
                                                                    <div class="ms-auto card-icon">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card bg-warning img-card box-primary-shadow">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="text-white">
                                                                        <h2 class="mb-0 number-font">₹<?= $this->amount->toDecimal($payment,false); ?></h2>
                                                                        <p class="text-white mb-0">Payment </p>
                                                                    </div>
                                                                    <div class="ms-auto card-icon">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="card <?= $balance<0?'bg-danger':'bg-success' ?> img-card box-primary-shadow">
                                                            <div class="card-body">
                                                                <div class="d-flex">
                                                                    <div class="text-white">
                                                                        <?php $sign=strpos($balance,'-')===0; $balance=abs($balance); ?>
                                                                        <h2 class="mb-0 number-font"><?= $sign?'-':'' ?>₹<?= $this->amount->toDecimal($balance,false); ?></h2>
                                                                        <p class="text-white mb-0">Balance </p>
                                                                    </div>
                                                                    <div class="ms-auto card-icon">
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">
                                                        <div id="status"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-condensed" id="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sl.No.</th>
                                                                        <th>Date</th>
                                                                        <th class="<?= $this->session->role=='superadmin'?'select-filter':''; ?>">User</th>
                                                                        <th>Role</th>
                                                                        <th>Amount</th>
                                                                        <th>Remarks</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if(!empty($payments)){ $i=0;
                                                                        foreach($payments as $single){
                                                                            $i++;
                                                                            $status='<span class="text-danger">Payment Not Transferred</span>';
                                                                            if($single['pay_status']==1){
                                                                                $status='<span class="text-success">Payment Transferred</span>';
                                                                            }
                                                                            elseif($single['pay_status']==3){
                                                                                $status='<span class="text-info">Transfer Initiated! Waiting for Gateway Response!</span>';
                                                                            }
                                                                    ?>
                                                                    <tr>
                                                                        <td><?= $i; ?></td>
                                                                        <td><?= date('d-m-Y',strtotime($single['date'])); ?></td>
                                                                        <td><?= $single['user']; ?></td>
                                                                        <td><?= $single['role']; ?></td>
                                                                        <td><?= $this->amount->toDecimal($single['amount']); ?></td>
                                                                        <td><?= $single['remarks']; ?></td>
                                                                        <td><?= $status; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            if($single['pay_status']==0){
                                                                            ?>
                                                                            <button type="button" class="btn btn-sm btn-success approve" value="<?= md5('exp-pay-'.$single['id']); ?>">Transfer Amount</button>
                                                                            <?php
                                                                            }
                                                                            ?>
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
                                    <script>
                                        var table;
                                        $(document).ready(function(e) {
                                            alertify.defaults.transition = "slide";
                                            alertify.defaults.theme.ok = "btn btn-success text-white";
                                            alertify.defaults.theme.cancel = "btn btn-danger text-white";
                                            alertify.defaults.theme.input = "form-control";
                                            $('body').on('click','.approve',function(){
                                                var id=$(this).val();
                                                alertify.confirm('Delete Customer Request','All the transactions of this Request will also be deleted! Are you sure You want to delete this Entry?',
                                                    function(){ 
                                                        $.ajax({
                                                            type:'post',
                                                            url:"<?= base_url('expenses/transfertobank') ?>",
                                                            data:{id:id},
                                                            success:function(data){
                                                                data=JSON.parse(data);
                                                                if(data.status===true){
                                                                    refreshTableData();
                                                                    alertify.success(data.message);
                                                                }
                                                                else{
                                                                    alertify.error(data.message);
                                                                }
                                                            }
                                                        }); 
                                                    },
                                                    function(){ alertify.error("Expense Payment Transfer Cancelled!"); }
                                                ).set('labels', {ok:'Transfer Payment'})
                                                .set('closable', false);
                                            });
                                            table=$('#table').DataTable({
                                                dom:'<"row"<"col-md-4"l><"col-md-4"B><"col-md-4"f>rt><"row"<"col-6"i><"col-6"p>><"clear">',
                                                buttons: [
                                                    {
                                                        extend: 'copy',
                                                        className: 'btn-sm',
                                                        exportOptions: {
                                                            columns: ':visible:not(:last-child)'
                                                        }
                                                    },
                                                    {
                                                        extend: 'csv',
                                                        className: 'btn-sm',
                                                        exportOptions: {
                                                            columns: ':visible:not(:last-child)'
                                                        }
                                                    },
                                                    {
                                                        extend: 'excel',
                                                        className: 'btn-sm',
                                                        exportOptions: {
                                                            columns: ':visible:not(:last-child)'
                                                        }
                                                    },
                                                    {
                                                        extend: 'pdf',
                                                        className: 'btn-sm',
                                                        exportOptions: {
                                                            columns: ':visible:not(:last-child)'
                                                        },
                                                        customize: function(doc) {
                                                            doc.styles.tableHeader = {
                                                                bold: true,
                                                                fontSize: 10,
                                                                color: 'black',
                                                                fillColor: '#cccccc'
                                                            };
                                                            doc.styles.tableFooter = {
                                                                bold: true,
                                                                fontSize: 10,
                                                                color: 'black',
                                                                fillColor: '#cccccc'
                                                            };
                                                            var rowCount = doc.content[1].table.body.length;
                                                            for (var i = 1; i < rowCount; i++) {
                                                                doc.content[1].table.body[i].forEach(function (cell) {
                                                                    cell.text = {
                                                                        text: cell.text,
                                                                        fontSize: 9,  // Set font size for the table body
                                                                        alignment: 'left',
                                                                        margin: [0, 5, 0, 5]  // Add margin for better spacing
                                                                    };
                                                                });
                                                            }
                                                            // Adjust table width to fit all columns
                                                            doc.content[1].table.widths = ['6%','15%','13%','20%','9%','14%','23%']; // Adjust as per your columns
                                                        }
                                                    },
                                                    {
                                                        extend: 'print',
                                                        className: 'btn-sm',
                                                        exportOptions: {
                                                            columns: ':visible:not(:last-child)'
                                                        }
                                                    }
                                                ]
                                            });
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
                                            $('body').on('click','.delete-btn',function(){
                                                if(confirm("Confirm Delete Expense?")){
                                                    $.post('<?= base_url('expenses/deleteexpense'); ?>',{expense_id:$(this).val()},function(){
                                                        window.location.reload();
                                                    });   
                                                }
                                            });
                                        });
                                    function getPhoto(input){

                                    }
                                    </script> 
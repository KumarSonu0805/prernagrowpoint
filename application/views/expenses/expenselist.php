
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
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
                                                                <th>Receipt No</th>
                                                                <th>Expense Head</th>
                                                                <th>Invoice No</th>
                                                                <th>Amount</th>
                                                                <th>Remarks</th>
                                                                <?php if($this->session->role=='superadmin'){ ?>
                                                                <th class="select-filter">User</th>
                                                                <?php } ?>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if(!empty($expenses)){ $i=0;
                                                                foreach($expenses as $single){
                                                                    $i++;
                                                            ?>
                                                            <tr>
                                                                <td><?= $i; ?></td>
                                                                <td><?= date('d-m-Y',strtotime($single['date'])); ?></td>
                                                                <td><?= $single['receipt_no']; ?></td>
                                                                <td><?= $single['expense_head']; ?></td>
                                                                <td><?= $single['inv_no']??'--'; ?></td>
                                                                <td><?= $this->amount->toDecimal($single['amount']); ?></td>
                                                                <td><?= $single['remarks']; ?></td>
                                                                <?php if($this->session->role=='superadmin'){ ?>
                                                                <td><?= $single['user']; ?></td>
                                                                <?php } ?>
                                                                <td>
                                                                    <a href="<?= base_url('expenses/editexpense/'.md5('expense-id-'.$single['id'])) ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                                                    <!-- <button type='button' class='btn btn-xs btn-danger delete-btn' value='<?= md5('expense-id-'.$single['id']) ?>'><i class='fa fa-trash'></i></button> -->
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
                                        var table;
                                        $(document).ready(function(e) {
                                            table= $('#table').DataTable({
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
                                            $('body').on('click','.delete-btn',function(){
                                                if(confirm("Confirm Delete Expense?")){
                                                    $.post('<?= base_url('expenses/deleteexpense'); ?>',{expense_id:$(this).val()},function(){
                                                        window.location.reload();
                                                    });   
                                                }
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
                                        });
                                    function getPhoto(input){

                                    }
                                    </script> 

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div id="tabulator-table"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
<script>
	
	$(document).ready(function(e) {
		
        var url="<?= base_url('beats/assignedbeats/?type=data'); ?>";
        var columns=[
                { 
                    title: "Sl.No.", 
                    field: "serial", 
                    type: "auto"
                },
                { title: "Beat", field: "name" },
                { title: "State", field: "state_name" },
                { title: "District", field: "district_name" },
                { title: "Area", field: "area_name" },
                { 
                    title: "Action", 
                    field: "id", 
                    formatter: function(cell) {
                        let id = cell.getValue();
                        let button='';
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
    });
</script>

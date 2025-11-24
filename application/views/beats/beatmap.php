      
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  #map { height: 700px; width: 100%; border-radius: 10px; }
</style>                          
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header"><?= $title; ?></div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <?= create_form_input('select','','Beat',true,$this->input->get('beat_id'),['id'=>'beat_id'],beat_dropdown("t1.id in (SELECT beat_id from ".TP."beat_assigned where emp_id='$user[e_id]')")); ?>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-12">
                                                        <div id="map"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

<script>
                                $(document).ready(function(e) {
                                    $('body').on('change','#beat_id',function(){
                                        getDealers();
                                    });
                                });
    
                                function getDealers(){
                                    var beat_id=$('#beat_id').val();
                                    $.post('<?= base_url('beats/getdealerlocations') ?>',
                                           {beat_id:beat_id},
                                           function(data){
                                            showInMap(data)
                                    });
                                }
                            </script>
   
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Your JSON array
  //const locations = JSON.parse($('#locations').text());
    let map;
function showInMap(locations){
    locations = JSON.parse(locations);
    if (map != null) {
      map.remove(); // completely removes the old map instance
    }
  // Initialize map (default center and zoom)
   map = L.map('map').setView([24.482817, 86.691621], 16);

  // Add OpenStreetMap layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  const markersGroup = L.featureGroup();

  // Loop through all locations
  locations.forEach(([label, lat, lng]) => {
    const marker = L.marker([lat, lng]).addTo(map);

    // Add hover tooltip (appears when mouse hovers)
    marker.bindTooltip(label, {
      permanent: false, // Show only on hover
      direction: 'top'
    });

    // Also add a click popup (optional)
    marker.bindPopup(`<b>${label}</b><br>Lat: ${lat}<br>Lng: ${lng}`);

    markersGroup.addLayer(marker);
  });

  // Adjust zoom to show all markers
  map.fitBounds(markersGroup.getBounds());
}
</script>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
  #map { height: 500px; width: 100%; border-radius: 10px; }
</style>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $employee['name'] ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <?php
                                            if(!empty($locations)){
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php
                                                    $latitudes=array_column($locations,'latitude');
                                                    $longitudes=array_column($locations,'longitude');
                                                    $added_ons=array_column($locations,'added_on');
                                                    $locations=array();
                                                    foreach($latitudes as $key=>$latitude){
                                                        $locations[]=[$employee['name'].' | '.date('d-m-Y h:i: a',strtotime($added_ons[$key])),($latitude/1),($longitudes[$key]/1),file_url('assets/images/delivery-bike.svg')];
                                                    }
                                                ?>
                                                <div id="map" style="height: 70vh"></div>
                                                <input type="hidden" id="name" value="<?= $employee['name']; ?>">
                                                <input type="hidden" id="track_type" value="trackemployee">
                                                <input type="hidden" class="form-control" name="latitude" id="latitude" placeholder="Latitude" value="<?= end($latitudes) ?>" >
                                                <input type="hidden" class="form-control" name="longitude" id="longitude" placeholder="Longitude" value="<?= end($longitudes) ?>" >
                                                <div id="locations" class="d-none"><?= json_encode($locations); ?></div>
                                            </div>
                                        </div>
                                        <?php
                                            }
                                            else{
                                                echo '<div class="row"><div class="col-md-12"><div class="lead text-danger">No Location Data Available</div></div></div>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Your JSON array
  const locations = JSON.parse($('#locations').text());

  // Initialize map (default center and zoom)
  const map = L.map('map').setView([24.482817, 86.691621], 16);

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
</script>
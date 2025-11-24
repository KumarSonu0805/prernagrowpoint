
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
  #map {
    height: 300px;
    width: 100%;
    border-radius: 10px;
  }
</style>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?= form_open_multipart('dealers/adddealer/',' onsubmit="return validate();"'); ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Name of Shop</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="shop_name" id="shop_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Name of Dealer</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="name" id="name" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Mobile (Login Username)</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="mobile" id="mobile" required pattern="[\d]{10}" title="Enter valid 10-digit number">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">WhatsApp</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="whatsapp" id="whatsapp" required pattern="[\d]{10}" title="Enter valid 10-digit number">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Email</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="email" id="email" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Address</label>
                                                        <div class="col-sm-8">
                                                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">State</label>
                                                        <div class="col-sm-8">
                                                            <?= form_dropdown('state_id',$states,'',array('class'=>'form-control tom-select','id'=>'state_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">District</label>
                                                        <div class="col-sm-8">
                                                            <?= form_dropdown('district_id',[""=>"Select District"],'',array('class'=>'form-control','id'=>'district_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Area</label>
                                                        <div class="col-sm-8">
                                                            <?= form_dropdown('area_id',[""=>"Select Area"],'',array('class'=>'form-control','id'=>'area_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Beat</label>
                                                        <div class="col-sm-8">
                                                            <?= form_dropdown('beat_id',[""=>"Select Beat"],'',array('class'=>'form-control','id'=>'beat_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Pincode</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="pincode" id="pincode" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Location</label>
                                                        <div class="col-sm-8">
                                                            <button type="button" id="get-location" class="btn btn-sm btn-primary">Get Current Location</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Latitude</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="latitude" id="latitude" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Longitude</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" name="longitude" id="longitude" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Map</label>
                                                        <div class="col-sm-8">
                                                            <div id="map"></div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Shop Photo</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" name="shop_photo" id="shop_photo" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Dealer Photo</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" name="photo" id="photo" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <label class="col-sm-2 col-form-label">GSTIN</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="gst_no" id="gst_no" class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <label class="col-sm-2 col-form-label">Brands</label>
                                                        <div class="col-sm-8">
                                                            <input name='brand_id' class='brand_id form-control' placeholder='Enter Brand Names' >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row ">
                                                        <label class="col-sm-2 col-form-label">Finance Details</label>
                                                        <div class="col-sm-8">
                                                            <input name='finance_id' class='finance_id form-control' placeholder='Enter Finance Company Names' >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row <?= $user['role']=='dso'?'d-none':'' ?>">
                                                        <label class="col-sm-2 col-form-label">Added By</label>
                                                        <div class="col-sm-8">
                                                            <?= form_dropdown('emp_user_id',$sales,$user['id'],array('class'=>'form-control','id'=>'emp_user_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"></label>
                                                        <div class="col-sm-8">
                                                            <input type="submit" class="btn btn-success waves-effect waves-light" name="adddealer" value="Save Dealer">
                                                        </div>
                                                    </div>
                                                <?= form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<input type="hidden" id="temp_district">
<script>
	$(document).ready(function(e) {
        $('body').on('change','#state_id',function(){
            if($(this).val()=='new'){
                $(this).parent().append('<?= trim(create_form_input('text','state_val','',true,'',array('id'=>'state_val','class'=>'mt-2'))); ?>');
            }
            else{
                $('#state_val').remove();
            }
            $.ajax({
                type:"post",
                url:"<?= base_url('masterkey/getdistrictdropdown/'); ?>",
                data:{state_id:$(this).val(),district_id:''},
                success:function(data){
                    $('#district_id').parent().html(data);
                    $('#district_id').trigger('change');
                    createTomSelect('#district_id');
                }
            });
        });
        $('body').on('change','#district_id',function(){
            if($(this).val()=='new'){
                $(this).parent().append('<?= trim(create_form_input('text','district_val','',true,'',array('id'=>'district_val','class'=>'mt-2'))); ?>');
            }
            else{
                $('#district_val').remove();
            }
            $.ajax({
                type:"post",
                url:"<?= base_url('masterkey/getareadropdown/'); ?>",
                data:{district_id:$(this).val(),area_id:''},
                success:function(data){
                    $('#area_id').parent().html(data);
                    $('#area_id').trigger('change');
                    createTomSelect('#area_id');
                }
            });
        });
        $('body').on('change','#area_id',function(){
            if($(this).val()=='new'){
                $(this).parent().append('<?= trim(create_form_input('text','area_val','',true,'',array('id'=>'area_val','class'=>'mt-2'))); ?>');
            }
            else{
                $('#area_val').remove();
            }
            $.ajax({
                type:"post",
                url:"<?= base_url('masterkey/getbeatdropdown/'); ?>",
                data:{area_id:$(this).val(),beat_id:''},
                success:function(data){
                    $('#beat_id').parent().html(data);
                    createTomSelect('#beat_id');
                }
            });
        });
        $('body').on('change','#beat_id',function(){
            if($(this).val()=='new'){
                $(this).parent().append('<?= trim(create_form_input('text','beat_val','',true,'',array('id'=>'beat_val','class'=>'mt-2'))); ?>');
            }
            else{
                $('#beat_val').remove();
            }
        });
        // new TomSelect("#brand_id", {
        //   plugins: ['remove_button'], // Adds an 'x' to remove items
        //   persist: false,
        //   create: false, // or true to allow new items
        //   maxItems: null, // null = unlimited
        // });
        // new TomSelect("#finance_id", {
        //   plugins: ['remove_button'], // Adds an 'x' to remove items
        //   persist: false,
        //   create: false, // or true to allow new items
        //   maxItems: null, // null = unlimited
        // });
        $.getJSON("<?= base_url('masterkey/getallbrands') ?>", function(brands) { 
            console.log(brands); 
            var brand_ids=JSON.parse('[]');
            //console.log(brand_ids);
            tagTagify=createTagify(brands,brand_ids,'.brand_id',100);
        });
        $.getJSON("<?= base_url('masterkey/getallfinances') ?>", function(finances) { 
            console.log(finances); 
            var finance_ids=JSON.parse('[]');
            //console.log(finance_ids);
            tagTagify=createTagify(finances,finance_ids,'.finance_id',100);
        });
    });
function getPhoto(input){
    
}
    
    
function validate(){
    if($('#latitude').val()=='' || $('#longitude').val()==''){
        alert("Select Dealer Location!");
        return false;
    }
}
</script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
  // Initialize map with a default location (India center)
  const map = L.map('map').setView([20.5937, 78.9629], 5);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  let marker;

  document.getElementById('get-location').addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert("Geolocation is not supported by your browser.");
      return;
    }

    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const lat = pos.coords.latitude.toFixed(6);
        const lng = pos.coords.longitude.toFixed(6);

        // Fill form inputs
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        // Update or add marker on map
        if (marker) {
          marker.setLatLng([lat, lng]);
        } else {
          marker = L.marker([lat, lng]).addTo(map);
        }

        map.setView([lat, lng], 15);
        marker.bindPopup(`You are here<br>Lat: ${lat}<br>Lng: ${lng}`).openPopup();
      },
      (err) => {
        alert("Unable to retrieve your location. Error: " + err.message);
      },
      { enableHighAccuracy: true }
    );
  });
</script>
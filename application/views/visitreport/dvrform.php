
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
                                            <div class="col-md-6">
                                                <?= form_open_multipart('visitreport/savevisitreport/',' onsubmit="return validate();"'); ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Dealer <span class="text-danger">*</span></label>
                                                        <div class="col-sm-9">
                                                            <?= form_dropdown('dealer_id',$dealers,'',array('class'=>'form-control tom-select','id'=>'dealer_id','required'=>'true')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Order Quantity </label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="order_qty" id="order_qty" required >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Order Commitment</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" name="order_commitment" id="order_commitment">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row d-none">
                                                        <label class="col-sm-3 col-form-label">Collection</label>
                                                        <div class="col-sm-9">
                                                            <select name="collection" id="collection" class="form-control">
                                                                <option value="1">Yes</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Collection Type</label>
                                                        <div class="col-sm-9">
                                                            <select name="collection_type" id="collection_type" class="form-control">
                                                                <option value="">Select</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Cheque">Cheque</option>
                                                                <option value="Bank transfer">Bank transfer</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Collection Amount</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" name="collection_amount" id="collection_amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Collection Commitment</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" name="collection_commitment" id="collection_commitment">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Remarks</label>
                                                        <div class="col-sm-9">
                                                            <textarea name="remarks" id="remarks" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label"></label>
                                                        <div class="col-sm-9">
                                                        <input type="hidden" class="form-control" name="latitude" id="latitude" required readonly>
                                                        <input type="hidden" class="form-control" name="longitude" id="longitude" required readonly>
                                                            <input type="submit" class="btn btn-success waves-effect waves-light" name="savevisitreport" value="Save Dealer Visit Report">
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
    function getLatLong(){
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
        });
    }
    
	$(document).ready(function(e) {
        getLatLong();
    });
    
    
function validate(){
}
</script>
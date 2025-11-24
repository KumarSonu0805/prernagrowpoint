<?php
$text="Login";
if($checkattendance['count']==1){
    $text="Logout";
}
?>                                
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"><?= $title; ?></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?= form_open_multipart('home/saveattendance/','onSubmit="return validate()"'); ?>
                                            <div class="form-group row d-none">
                                                <label class="col-sm-3 col-form-label">Username</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="username" id="username" readonly value="<?= $user['username'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" readonly value="<?= $user['name'] ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Time</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" readonly value="<?= date('d-m-Y h:i A') ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Latitude</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="latitude" id="latitude" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Longitude</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="longitude" id="longitude" required readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Bike Meter</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="image" id="image" required>
                                                </div>
                                            </div>
                                            <?php
                                            if($checkattendance['count']<2){
                                            ?>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9">
                                                    <input type="submit" class="btn btn-success waves-effect waves-light" name="saveattendance" value="<?= $text ?>">
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            getLatLong();
                            setTimeout(function() {
                                location.reload();
                            }, 90 * 1000); // 1.5 minutes
                       
                            function validate(){
                                if($('#latitude').val()=='' || $('#longitude').val()==''){
                                    alert("Select Dealer Location!");
                                    return false;
                                }
                            }
                        </script>
        

                    
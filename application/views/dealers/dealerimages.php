
<style>
    .img-div{
        border-radius: 5px;
        box-shadow: 1px 1px 1px 1px #cdcdcd;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?> (*Click On image to Enlarge)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <div class="lead">Dealer Photo</div>
                                                <a href="<?= $dealer['photo'] ?>" class="img-div" data-lightbox="gallery">
                                                    <img src="<?= $dealer['photo'] ?>" alt="<?= $dealer['name'] ?>" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="lead">Shop Photo</div>
                                                <a href="<?= $dealer['shop_photo'] ?>" class="img-div" data-lightbox="gallery">
                                                    <img src="<?= $dealer['shop_photo'] ?>" alt="<?= $dealer['shop_name'] ?>" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                        <?php
                                        $class="d-none";
                                        if(!empty($images)){
                                        ?>
                                        <div class="row mt-2">
                                            <?php
                                            foreach($images as $image){
                                                if($image['type']=='monthly'){
                                                    $text="Monthly Image";
                                                }
                                            ?>
                                            <div class="col-md-4">
                                                <div class="lead"><?= $text ?></div>
                                                <a href="<?= file_url($image['path']) ?>" class="img-div" data-lightbox="gallery">
                                                    <img src="<?= file_url($image['path']) ?>" alt="<?= $text ?>" class="img-fluid">
                                                </a>
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        }
                                        else{
                                            $class="";
                                        }
                                        ?>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6 <?= $class ?>">
                                                <div class="lead mb-2">Upload Monthly Image</div>
                                                <?= form_open_multipart('dealers/uploadimage/'); ?>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label">Monthly Image</label>
                                                        <div class="col-sm-8">
                                                            <input type="file" name="image" id="image" required>
                                                            <input type="hidden" name="id" value="<?= md5('dealer-id-'.$dealer['id']) ?>">
                                                            <input type="hidden" name="type" value="monthly">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label"></label>
                                                        <div class="col-sm-8">
                                                            <input type="submit" class="btn btn-success waves-effect waves-light" name="uploadimage" value="Upload Monthly Image">
                                                        </div>
                                                    </div>
                                                <?= form_close() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
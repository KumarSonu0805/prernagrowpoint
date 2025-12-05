
<?php
$button='<button type="submit" class="btn btn-sm btn-success" name="makepayment" value="Pay">Make Payment</button>';
?>
                            <div class="col-md-12">
                                <div class="card light-bg">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <?php echo form_open_multipart($sabpaisa['url'], 'id="myform" '); ?>
                                                    <div class="form-group">
                                                        <?php
                                                            echo create_form_input("text","","Member ID",false,$user['username'],array("readonly"=>"true")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            echo create_form_input("text","","Name",false,$user['name'],array("readonly"=>"true")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $attributes=array("id"=>"amount");
                                                            $attributes['readonly']='true';
                                                            echo create_form_input("text","","Deposit Amount",true,$deposit['amount'],$attributes); 
                                                        ?>
                                                    </div>
                                                    <?php
                                                        echo create_form_input("hidden","encData","",false,$sabpaisa['data'],array("id"=>"frm1")); 
                                                        echo create_form_input("hidden","clientCode","",false,$sabpaisa['clientCode'],array("id"=>"frm2")); 
                                                    ?>
                                                    <?= $button; ?>
                                                <?php echo form_close(); ?>
                                            </div>	
                                        </div>
                                    </div>
                                </div>
                            </div>
<script>
	$(document).ready(function(e) {
    });
	
</script>

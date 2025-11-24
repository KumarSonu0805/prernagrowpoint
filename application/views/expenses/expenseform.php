<?php
    if($form=='add'){
        $button='<input type="submit" class="btn btn-sm btn-success" id="save-btn" name="saveexpense" value="Save Expense">&nbsp;';
        //$button.='<a href="'.base_url('biography/celebrities/').'" class="btn btn-sm btn-danger">Cancel</a>';
    }
    elseif($form=='edit'){
        $button='<input type="submit" class="btn btn-sm btn-success" id="save-btn" name="updateexpense" value="Update Expense">&nbsp;';
        $button.='<a href="'.base_url('expenses/').'" class="btn btn-sm btn-danger">Cancel</a>';
    }
?>
<style>
/* CSS to remove arrows */
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
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
                                                <?= form_open_multipart('expenses/saveexpense/','onSubmit=" return validate();"'); ?>
                                                    <div class="row mb-4">
                                                        <div class="col-md-4 mb-4">
                                                            <div class="form-group">
                                                                <?php
                                                                    $date=!empty($expense['date'])?$expense['date']:$date;
                                                                    $attributes=array("id"=>"date","autocomplete"=>"off");
                                                                    echo create_form_input("date","date","Expense Date",true,$date,$attributes); 
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4">
                                                            <div class="form-group">
                                                            <label for="head_id">Expense Head <span class="text-danger">*</span></label>
                                                                <?php
                                                                    $head_id=!empty($expense['head_id'])?$expense['head_id']:'';
                                                                ?>
                                                                <?= form_dropdown('head_id',$expenseheads,$head_id,array('class'=>'form-control','id'=>'head_id','required'=>'true')); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <?php
                                                                    $inv_no=!empty($expense['inv_no'])?$expense['inv_no']:'';
                                                                    $attributes=array("id"=>"inv_no","Placeholder"=>"Invoice No.","autocomplete"=>"off");
                                                                    echo create_form_input("text","inv_no","Invoice No.",false,$inv_no,$attributes); 
                                                                ?>
                                                                <div id="inv_status"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <?php
                                                                    $amount=!empty($expense['amount'])?$expense['amount']:'';
                                                                    $attributes=array("id"=>"amount","Placeholder"=>"Amount","autocomplete"=>"off");
                                                                    echo create_form_input("number","amount","Amount",true,$amount,$attributes); 
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <?php
                                                                    $remarks=!empty($expense['remarks'])?$expense['remarks']:'';
                                                                    $attributes=array("id"=>"remarks","Placeholder"=>"Remarks",
                                                                                    "autocomplete"=>"off",'rows'=>3);
                                                                    echo create_form_input("textarea","remarks","Remarks",false,$remarks,$attributes);  
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-12">
                                                            <?php
                                                                $id=!empty($expense['id'])?$expense['id']:'';
                                                            ?>
                                                            <input type="hidden" id="status" value="1">
                                                            <input type="hidden" name="id" id="id" value="<?= $id; ?>">
                                                            <?= $button; ?>
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
                    
        $('form').on('keyup','#inv_no',function(){
            var inv_no=$(this).val();
            var id=$('#id').val();
            $('#inv_status').html('');
            $.ajax({
                type:"post",
                url:"<?= base_url('expenses/checkinvoice'); ?>",
                data:{inv_no:inv_no,id:id},
                success:function(data){
                    if(data==0){
                        $('#save-btn').attr('type','button');
                        $('#inv_status').html('<span class="text-danger">Invoice No.Already added!</span>');
                    }
                    else{
                        $('#save-btn').attr('type','submit');
                    }
                }
            });
        });
        $('body').on('change','#head_id',function(){
            if($(this).val()=='new'){
                $(this).parent().append('<?= trim(create_form_input('text','head_val','',true,'',array('id'=>'head_val','class'=>'mt-2'))); ?>');
            }
            else{
                $('#head_val').remove();
            }
        });
    });
function getPhoto(input){
    
}
    
    
function validate(){
}
</script>
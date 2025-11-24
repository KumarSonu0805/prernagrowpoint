
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <?= form_open_multipart('employees/updateemployee','id="myform"'); ?>

                                                     <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Name</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'name', 'id'=> 'name', 'placeholder'=>'Enter Name', 'class'=>'form-control', 'value'=>$employee['name']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Father's Name</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'fname', 'id'=> 'fname', 'placeholder'=>"Enter Father's Name", 'class'=>'form-control','value'=>$employee['fname']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">DOB</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'dob', 'id'=> 'dob', 'type'=>'date','class'=>'form-control','value'=>$employee['dob']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Mobile</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'mobile', 'id'=> 'mobile', 'required'=>'true', 
                                                                              'placeholder'=>'Enter Mobile', 'class'=>'form-control',
                                                                              'pattern'=>"[\d]{10}",'title'=>"Enter valid 10-digit number",
                                                                              'value'=>$employee['mobile']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Email</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'email', 'id'=> 'email', 'placeholder'=>'Enter eamil', 'class'=>'form-control','value'=>$employee['email']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Gender</label>
                                                        <div class="col-sm-12 col-md-5">
                                                        <input type="radio" name="gender" value="Male" <?php if($employee['gender']=='Male'){ echo "checked";} ?> >&nbsp;&nbsp;&nbsp;Male&nbsp;
                                                        <input type="radio" name="gender" value="Female" <?php if($employee['gender']=='Female'){ echo "checked";} ?>>&nbsp;&nbsp;&nbsp;Female
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Date Of Joining</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'date_of_join', 'id'=> 'date_of_join', 'type'=>'date','class'=>'form-control','value'=>$employee['date_of_join']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Photo(jpg|jpeg|png)</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <input type="file" name="photo" id="photo" placeholder="photo" class="form-control" onchange="showImage(this);" />
                                                        </div>
                                                    </div>



                                                    <div class="form-group row d-none">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Designation</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'designation', 'id'=> 'designation', 'placeholder'=>'Enter Designation', 'class'=>'form-control','value'=>$employee['designation']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Salary</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'basic_salary', 'id'=> 'basic_salary', 'placeholder'=>'Enter Salary', 'class'=>'form-control','value'=>$employee['basic_salary']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label d-none"> Medical Allowance</label>
                                                        <div class="col-sm-12 col-md-5 d-none">
                                                            <?php 
                                                                $data = array('name' => 'pf', 'id'=> 'pf', 'placeholder'=>'Enter PF', 'class'=>'form-control','value'=>$employee['pf']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">HRA</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'hra', 'id'=> 'hra', 'placeholder'=>'Enter HRA', 'class'=>'form-control','value'=>$employee['hra']);
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Address</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'address', 'id'=> 'address', 'placeholder'=>'Enter address', 'class'=>'form-control', 'value'=>$employee['address']);
                                                                echo form_textarea($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label"></label>
                                                        <div class="col-sm-12 col-md-5">
                                                        <div  style="width:150px; height:180px; border:1px solid #ffc107;">
                                                         <img src="<?= ($employee['photo'])?>" alt="" id="target" height="180" width="150">
                                                         </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-sm-2 col-md-6">
                                                            <?php 
                                                                $data = array('type'=>'hidden', 'id'=> 'id','name'=>'id','value'=>$employee['id']);
                                                                echo form_input($data); 
                                                                echo form_submit('updateemployee', 'Update Employee', array('class'=>'btn btn-success btn-sm','id'=>'submit-btn')); 
                                                            ?>
                                                            <button type="button" class="btn btn-danger btn-sm cancel-edit hidden">Cancel</button>
                                                        </div>
                                                    </div>
                                                <?= form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<script>
	


    function showImage(src,target) {
        var fr=new FileReader();
        // when image is loaded, set the src of the image where you want to display it
        fr.onload = function(e) { target.src = this.result; };
        src.addEventListener("change",function() {
            // fill fr with image data    
            fr.readAsDataURL(src.files[0]);
        });
    }
    var src = document.getElementById("photo");
    var target = document.getElementById("target");
    showImage(src,target);
</script>

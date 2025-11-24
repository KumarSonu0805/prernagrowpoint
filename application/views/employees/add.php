
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title"><?= $title ?></h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo form_open_multipart('employees/addemployee','id="myform"'); ?>

                                                     <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Name</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'name', 'id'=> 'name', 'placeholder'=>'Enter Name', 'class'=>'form-control', 'required'=>'true');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Father's Name</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'fname', 'id'=> 'fname', 'placeholder'=>"Enter Father's Name", 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">DOB</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'dob', 'id'=> 'dob', 'type'=>'date','class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Mobile</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'mobile', 'id'=> 'mobile', 'required'=>'true', 
                                                                              'placeholder'=>'Enter Mobile', 'class'=>'form-control',
                                                                              'pattern'=>"[\d]{10}",'title'=>"Enter valid 10-digit number","maxlength"=>"10");
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Email</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'email', 'id'=> 'email', 'placeholder'=>'Enter Email', 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Gender</label>
                                                        <div class="col-sm-12 col-md-5">

                                                        <?php echo form_radio('gender','Male')?>Male
                                                        <?php echo form_radio('gender','Female')?>Female
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Date Of Joining</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'date_of_join', 'id'=> 'date_of_join', 'type'=>'date','class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Photo(jpg|jpeg|png)</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <input type="file" name="photo" id="photo" placeholder="photo" class="form-control">
                                                        </div>
                                                    </div>



                                                    <div class="form-group row d-none">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Designation</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'designation', 'id'=> 'designation', 'placeholder'=>'Enter Designation', 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label hidden"> Medical Allowance</label>
                                                        <div class="col-sm-12 col-md-5 hidden">
                                                            <?php 
                                                                $data = array('name' => 'pf', 'id'=> 'pf', 'placeholder'=>'Enter Medical Allowance', 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label">Salary</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'basic_salary', 'id'=> 'basic_salary', 'placeholder'=>'Enter Salary', 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label hidden">HRA</label>
                                                        <div class="col-sm-12 col-md-5 hidden">
                                                            <?php 
                                                                $data = array('name' => 'hra', 'id'=> 'hra', 'placeholder'=>'Enter HRA', 'class'=>'form-control');
                                                                echo form_input($data); 
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-sm-12 col-md-1 col-form-label">Address</label>
                                                        <div class="col-sm-12 col-md-5">
                                                            <?php 
                                                                $data = array('name' => 'address', 'id'=> 'address', 'placeholder'=>'Enter address', 'class'=>'form-control', 'required'=>'true');
                                                                echo form_textarea($data); 
                                                            ?>
                                                        </div>
                                                        <label class="col-sm-12 col-md-1 col-form-label"></label>
                                                        <div class="col-sm-12 col-md-5">
                                                        <div  style="width:150px; height:180px; border:1px solid #dc3545;">
                                                         <img  id="target" height="180" width="150">
                                                         </div>
                                                        </div>
                                                    </div>


                                                     <div class="row form-group">

                                                        </div> 

                                                    <div class="form-group row">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-sm-2 col-md-6">
                                                            <?php 
                                                                $data = array('type'=>'hidden', 'id'=> 'id');
                                                                echo form_input($data); 
                                                                echo form_submit('addemployee', 'Add Employee', array('class'=>'btn btn-success btn-sm','id'=>'submit-btn')); 
                                                            ?>
                                                            <button type="button" class="btn btn-danger btn-sm cancel-edit hidden">Cancel</button>
                                                        </div>
                                                    </div>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

<script>
	
	$(document).ready(function(e) {
		

        var table=$('.data-table').DataTable({
			scrollCollapse: true,
			autoWidth: false,
			responsive: true,
			columnDefs: [{
				targets: "datatable-nosort",
				orderable: false,
			}],
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
			"language": {
				"info": "_START_-_END_ of _TOTAL_ entries",
				searchPlaceholder: "Search"
			},
		});
		//new $.fn.dataTable.FixedHeader( table );
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
    });
</script>

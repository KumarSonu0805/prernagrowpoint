
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                    	<h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?php
                            if(isset($profile) && $profile==true){
                        ?>
                        <div class="row profile">
                            <div class="col-md-6">
                                <legend>Personal Details</legend>
                                <table class="table" id="personal-details">
                                    <tr>
                                        <td colspan="2">
                                            <img src="<?php if($member['photo']!=''){echo file_url($member['photo']);}else{echo file_url('assets/images/avatar.png');} ?>" 
                                                    style="height:135px; width:120px;" alt="User Image" id="view_photo"><br>
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    onClick="$(this).hide();$('#photoform').show();">Change Photo <i class="fa fa-camera"></i></button>
                                                    
                                            <?php echo form_open_multipart('profile/updatephoto', 'id="photoform"'); ?>
                                                <input type="file" name="photo" id="photo" onChange="getPhoto(this)" required/><br>
                                                <?php
                                                    $input=array("type"=>"hidden","name"=>"name","value"=>$user['name']);
                                                    echo form_input($input);
                                                    $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                                    echo form_input($input);
                                                ?>
                                                <button type="submit" class="btn btn-sm btn-success" name="updatephoto" value="Update">Update</button>
                                                <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                            <?php echo form_close(); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sponsor ID</th>
                                        <td><?php echo $member['susername']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Sponsor Name</th>
                                        <td><?php echo $member['sname']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Member ID</th>
                                        <td><?php echo $user['username']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td><?php echo $member['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td><?php if(!empty($member['dob']))echo date('d-m-Y',strtotime($member['dob'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Father/Husband Name</th>
                                        <td><?php echo $member['father']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td><?php echo $member['gender']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Marital Status</th>
                                        <td><?php echo $member['mstatus']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pan No.</th>
                                        <td><?php echo $member['pan']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Joining Date</th>
                                        <td><?php echo date('d-m-Y',strtotime($member['date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Activation Date</th>
                                        <td><?php if(!empty($member['activation_date']))echo date('d-m-Y',strtotime($member['activation_date'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#personal-details').hide();$('#personalform').show().find('input').first().focus();">Edit Personal Info <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <?php echo form_open('profile/updatepersonaldetails', 'id="personalform"'); ?>
                                    <div class="form-group">
                                        <label for="father" class=" form-control-label">Father/Husband Name</label>
                                        <?php
                                            $input=array("name"=>"father","id"=>"father","Placeholder"=>"Father/Husband Name","class"=>"form-control",
                                                    "autocomplete"=>"off","value"=>$member['father']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <?php
                                            $input=array("type"=>"date","name"=>"dob","class"=>"form-control", "autocomplete"=>"off","value"=>$member['dob']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class=" form-control-label">Gender</label>
                                        <?php
                                            $gender=array(""=>"Select Gender","Male"=>"Male","Female"=>"Female");
                                            $attrs=array("id"=>"gender","class"=>"form-control form-control-select", "tabindex"=>"1");
                                            echo form_dropdown('gender',$gender,$member['gender'],$attrs);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="mstatus">Marital Status</label>
                                        <?php
                                            $mstatus=array(""=>"Select","Married"=>"Married","Unmarried"=>"Unmarried");
                                            $attrs=array("id"=>"mstatus","class"=>"form-control form-control-select", "tabindex"=>"1");
                                            echo form_dropdown('mstatus',$mstatus,$member['mstatus'],$attrs);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="pan" class=" form-control-label">PAN No.</label>
                                        <?php
                                            $input=array("name"=>"pan","id"=>"pan","Placeholder"=>"PAN No.","class"=>"form-control",
                                                            "pattern"=>"[A-Za-z0-9]{10}","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10","value"=>$member['pan']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updatepersonaldetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                            <div class="col-md-6">
                                <legend>Contact Information</legend>
                                <table class="table" id="contact-details">
                                    <tr>
                                        <th>Address</th>
                                        <td><?php echo $member['address']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>District</th>
                                        <td><?php echo $member['district']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>State</th>
                                        <td><?php echo $member['state']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Country</th>
                                        <td><?php echo $member['country']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Pincode</th>
                                        <td><?php echo $member['pincode']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile</th>
                                        <td><?php echo $member['mobile']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo $member['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#contact-details').hide();$('#contactform').show().find('textarea').first().focus();">Edit Contact Info <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
                                <?php echo form_open('profile/updatecontactinfo', 'id="contactform"'); ?>
                                    <div class="form-group">
                                        <label for="address" class=" form-control-label">Address</label>
                                        <?php
                                            $input=array("name"=>"address","id"=>"address","Placeholder"=>"Address","class"=>"form-control",
                                                            "autocomplete"=>"off","rows"=>"3","value"=>$member['address']);
                                            echo form_textarea($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <?php
                                            $input=array("name"=>"district","id"=>"district","Placeholder"=>"District","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['district']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <?php
                                            $input=array("name"=>"state","id"=>"state","Placeholder"=>"State","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['state']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <?php
                                            $input=array("name"=>"country","id"=>"country","Placeholder"=>"Country","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$member['country']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="pincode">Pincode</label>
                                        <?php
                                            $input=array("name"=>"pincode","id"=>"pincode","Placeholder"=>"Pincode","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['pincode']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <?php
                                            $input=array("name"=>"mobile","id"=>"mobile","Placeholder"=>"Mobile","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['mobile'],"readonly"=>"true");
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <?php
                                            $input=array("type"=>"email","name"=>"email","id"=>"email","Placeholder"=>"Email","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$member['email']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updatecontactinfo" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                                
                            	<legend>Nominee Information</legend>
                                <table class="table" id="nominee-details">
                                	<tr>
                                    	<th>Nominee Name</th>
                                        <td><?php echo $nominee_details['name']; ?></td>
                                    </tr>
                                	<tr>
                                    	<th>Nominee Mobile</th>
                                        <td><?php echo $nominee_details['mobile']; ?></td>
                                    </tr>
                                	<tr>
                                    	<th>Relation With Applicant</th>
                                        <td><?php echo $nominee_details['relation']; ?></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2">
                                        	<button type="button" class="btn btn-primary btn-sm" 
                                            		onClick="$('#nominee-details').hide();$('#nomineeform').show().find('input').first().focus();">Edit Nominee <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </table>
								<?php echo form_open('profile/updatenomineedetails', 'id="nomineeform"'); ?>
                                    <div class="form-group">
                                        <label for="branch">Nominee Name</label>
                                        <?php
                                            $input=array("name"=>"name","Placeholder"=>"Nominee Name","class"=>"form-control", "autocomplete"=>"off","value"=>$nominee_details['name']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifsc">Nominee Mobile</label>
                                        <?php
                                            $input=array("name"=>"mobile","class"=>"form-control","Placeholder"=>"Nominee Mobile", "autocomplete"=>"off","value"=>$nominee_details['mobile']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Relation With Applicant</label>
                                        <?php
                                            $input=array("name"=>"relation","Placeholder"=>"Relation With Applicant","class"=>"form-control", "autocomplete"=>"off",
														"value"=>$nominee_details['relation']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                    	<button type="submit" class="btn btn-sm btn-success" name="updatenomineedetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <?php
                            }
                            else{
                                if(empty($acc_details)){
                                    $acc_details['account_name']=$acc_details['bank']='';
                                    $acc_details['account_no']=$acc_details['branch']='';
                                    $acc_details['ifsc']=$acc_details['upi']=$acc_details['address']='';
                                    $acc_details['kyc']=0;
                                }
                        ?>
                        <div class="row profile">
                            <div class="col-md-6">
                                <legend>Bank Information</legend>
                                <table class="table" id="bank-details">
                                    <tr>
                                        <th>A/C Holder Name</th>
                                        <td><?php echo $acc_details['account_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td><?php echo $acc_details['bank'];  ?></td>
                                    </tr>
                                    <tr>
                                        <th>Account Number</th>
                                        <td><?php echo $acc_details['account_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Branch</th>
                                        <td><?php echo $acc_details['branch']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>IFSC Code</th>
                                        <td><?php echo $acc_details['ifsc']; ?></td>
                                    </tr>
                                    <?php if($acc_details['kyc']!=1){ ?>
                                    <tr>
                                        <td colspan="2">
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    onClick="$('#bank-details').hide();$('#accform').show().find('input').first().focus();">Edit Bank Details <i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </table>
                                <?php echo form_open('profile/updateaccdetails', 'id="accform"'); ?>
                                    <div class="form-group">
                                        <label for="account_name">A/C Holder Name</label>
                                        <?php
                                            $input=array("name"=>"account_name","id"=>"account_name","Placeholder"=>"Account Holder Name","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$acc_details['account_name']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="bank">Bank Name</label>
                                        <?php
											$bank="";
											if($acc_details['bank']!=''){
												if(in_array($acc_details['bank'],$banks)){
													$bank=$acc_details['bank'];
												}
												else{
													$bank='xyz';
												}
											}
                                            $attrs=array("id"=>"bank","class"=>"form-control form-control-select", "tabindex"=>"1");
                                            echo form_dropdown('bank',$banks,$bank,$attrs);
                                            $input=array("id"=>"bank-name","Placeholder"=>"Bank Name","class"=>"form-control hidden mt-2",
                                                            "autocomplete"=>"off","pattern"=>"[\w\s]+","title"=>"Enter Valid Bank Name","value"=>$acc_details['bank']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="account_no">A/C No.</label>
                                        <?php
                                            $input=array("name"=>"account_no","id"=>"account_no","Placeholder"=>"Account No","class"=>"form-control",
                                                            "autocomplete"=>"off","pattern"=>"[0-9]{9,}","title"=>"Enter Valid Account No.","value"=>$acc_details['account_no']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="branch">Branch</label>
                                        <?php
                                            $input=array("name"=>"branch","id"=>"branch","Placeholder"=>"Branch","class"=>"form-control",
                                                            "autocomplete"=>"off","value"=>$acc_details['branch']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="ifsc">IFSC Code</label>
                                        <?php
                                            $input=array("name"=>"ifsc","id"=>"ifsc","Placeholder"=>"IFSC Code","class"=>"form-control", 
                                                            "autocomplete"=>"off","value"=>$acc_details['ifsc']);
                                            echo form_input($input);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            $input=array("type"=>"hidden","name"=>"regid","value"=>$user['id']);
                                            echo form_input($input);
                                        ?>
                                        <button type="submit" class="btn btn-sm btn-success" name="updateaccdetails" value="Update">Update</button>
                                        <button type="button" class="btn btn-sm btn-danger" onClick="window.location.reload()">Cancel</button>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        <div id="dot-loader" class="hidden"><img src="<?php echo file_url('assets/images/dotsloader.gif'); ?>" alt="" height="10"></div>
    <script>
		$(document).ready(function(e) {  
			$('#parent').keyup(function(){
				var username=$(this).val();
				var poslabel=$('#position-div').find("label");
				$('#parent_id').val('');
				$.ajax({
					type:"POST",
					url:"<?php echo base_url('members/getpositions'); ?>",
					data:{username:username},
					beforeSend: function(data){
						$('#pdiv').html($('#dot-loader').html());
					},
					success: function(data){
						$('#position-div').html(poslabel);
						data=JSON.parse(data);
						if(data['name']!=null){
							$('#pdiv').html(data['name']);
							$('#parent_id').val(data['id']);
						}
						$('#position-div').append(data['position']);
						var ele=$('#position')
						setChosenSelect(ele);
						
					}
				});
			});
			$('#parent').blur(function(){
				if($('#parent_id').val()==''){
					$('#pdiv').html("Enter Valid Placement ID!");
				}
			});
			$('body').on('change','#bank',function(){
				var bank=$(this).val();
				if(bank=='xyz'){
					$('#bank-name').removeClass('hidden').attr('name','bank').attr('required',true);;
				}
				else{
					$('#bank-name').addClass('hidden').removeAttr('name').removeAttr('required');
				}
			});
			$('#bank').trigger('change');
        });
		
		function getPhoto(input){
			$('#view_photo').replaceWith(' <img id="view_photo" style="height:135px; width:120px;" >');
			if (input.files && input.files[0]) {
				var filename=input.files[0].name;
				var re = /(?:\.([^.]+))?$/;
				var ext = re.exec(filename)[1]; 
				ext=ext.toLowerCase();
				if(ext=='jpg' || ext=='jpeg' || ext=='png'){
					var size=input.files[0].size;
					if(size<=2097152 && size>=20480){
						var reader = new FileReader();
						
						reader.onload = function (e) {
							$('#view_photo').attr('src',e.target.result);
						}
						reader.readAsDataURL(input.files[0]);
					}
					else if(size>=2097152){
						document.getElementById('photo').value= null;
						alert("Image size is greater than 2MB");	
					}
					else if(size<=20480){
						document.getElementById('photo').value= null; 
						alert("Image size is less than 20KB");	
					}
				}
				else{
					document.getElementById('photo').value= null;
					alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
				}
			}
		}
		
		function setChosenSelect(ele){
			ele.chosen({
				disable_search_threshold: 10,
				no_results_text: "Oops, nothing found!",
				width: "100%"
			});
		}
	</script>
    
    	


            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <?php echo form_open_multipart('members/addmember', 'id="myform" onsubmit="return validate()"'); ?>
                                    <h3 class="header smaller lighter">Sponsor Details</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"ref","Placeholder"=>"Senior Member ID","autocomplete"=>"off");
													if($this->session->role=='member'){ $attributes["readonly"]="true"; }
                                                    echo create_form_input("text","","Senior Member ID",true,$user['username'],$attributes); 
                                                    echo create_form_input("hidden","refid","",false,$user['id'],array("id"=>"refid")); 
                                                ?>
                                                <div style="padding:0 10px; font-size:16px; font-weight:600" id="refdiv"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"refname","Placeholder"=>"Senior Member Name","autocomplete"=>"off","readonly"=>true);
                                                    echo create_form_input("text","","Senior Member Name",true,$user['name'],$attributes); 
                                                ?>
                                            </div>
                                        </div>
                                        <?php
										if($tree=='position'){
											if($epin_status!==false){
												echo "</div><div class='row'>";
											}
                                        ?>
                                        <div class="col-md-4">
                                            <div class="form-group" id="position-div">
                                                <?php
                                                    $positions=array(""=>"Select Position","L"=>"Left","R"=>"Right");
                                                    echo create_form_input("select","position","Position",true,'',array("id"=>"position"),$positions); 
                                                ?>
                                            </div>
                                        </div>
                                        <?php
										}
										if($epin_status===false){
											$epinclass="hidden";
											$required=false;
										}
										elseif($epin_status===1){
											$epinclass="";
											$required=true;
										}
										else{
											$epinclass="";
											$required=false;
										}
										?>
                                        <div class="col-md-4 <?= $epinclass; ?>">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"epin","Placeholder"=>"E-Pin","autocomplete"=>"off");
                                                    echo create_form_input("text","epin","E-Pin",$required,'',$attributes);  
                                                ?>
                                                <span id="epinstatus"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="header smaller lighter">Personal Details</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"name","Placeholder"=>"Full Name","autocomplete"=>"off");
                                                    echo create_form_input("text","name","Name",true,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                               <?php
                                                    $attributes=array("id"=>"father","Placeholder"=>"Father's Name","autocomplete"=>"off");
                                                    echo create_form_input("text","father","Father's Name",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"mobile","Placeholder"=>"Mobile","autocomplete"=>"off","pattern"=>"[0-9]{10}","title"=>"Enter Valid Mobile No.","maxlength"=>"10");
                                                    echo create_form_input("text","mobile","Mobile",true,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 hidden">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"email","Placeholder"=>"Email","autocomplete"=>"off");
                                                    echo create_form_input("email","email","Email",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("date","dob","Date Of Birth",false,'',array("id"=>"dob"));  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 hidden">
                                            <div class="form-group">
                                                <?php
                                                    $gender=array(""=>"Select Gender","Male"=>"Male","Female"=>"Female");
                                                    echo create_form_input("select","gender","Gender",false,'',array("id"=>"gender"),$gender); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"address","Placeholder"=>"Address","autocomplete"=>"off","rows"=>"3");
                                                    echo create_form_input("textarea","address","Address",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"district","Placeholder"=>"District","autocomplete"=>"off");
                                                    echo create_form_input("text","district","District",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"state","Placeholder"=>"State","autocomplete"=>"off");
                                                    echo create_form_input("text","state","State",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hidden">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $mstatus=array(""=>"Select","Married"=>"Married","Unmarried"=>"Unmarried");
                                                    echo create_form_input("select","mstatus","Marital Status",false,'',array("id"=>"mstatus"),$mstatus); 
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"aadhar","Placeholder"=>"Aadhar No.","pattern"=>"[0-9]{12}","title"=>"Enter Valid Aadhar No.","autocomplete"=>"off","maxlength"=>"12");
                                                    echo create_form_input("text","aadhar","Aadhar No.",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row hidden">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"pincode","Placeholder"=>"Pincode","pattern"=>"[0-9]{6}","title"=>"Enter Valid Pincode","autocomplete"=>"off","maxlength"=>"6");
                                                    echo create_form_input("text","pincode","Pincode",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("date","date","Joining Date",true,date('Y-m-d'),array("id"=>"date"));  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("file","photo","Upload Image",false,'',array("id"=>"photo","onChange"=>"getPhoto(this)"));  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <img id="view_photo" style="height:135px; width:120px;" >
                                        </div>
                                    </div>
                                    <?php if($acc_details===false){ $acc_class="hidden"; }else{ $acc_class=""; } ?>
                                    <h3 class="header smaller lighter <?= $acc_class; ?>">Account Details</h3>
                                    <div class="row <?= $acc_class; ?>">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    echo create_form_input("select","bank","Bank Name",false,'',array("id"=>"bank"),$banks); 
													$input=array("id"=>"bank-name","Placeholder"=>"Bank Name","class"=>"form-control hidden mt-2",
																	"autocomplete"=>"off","pattern"=>"[\w\s]+","title"=>"Enter Valid Bank Name","value"=>"");
													echo form_input($input);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"branch","Placeholder"=>"Branch","autocomplete"=>"off");
                                                    echo create_form_input("text","branch","Branch",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"pan","Placeholder"=>"PAN No.","pattern"=>"[A-Za-z0-9]{10}","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10");
                                                    echo create_form_input("text","pan","PAN No.",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4 hidden">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"city","Placeholder"=>"City","autocomplete"=>"off");
                                                    echo create_form_input("text","city","City",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row <?= $acc_class; ?>">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"account_no","Placeholder"=>"A/C No.","autocomplete"=>"off");
                                                    echo create_form_input("text","account_no","A/C No.",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"account_name","Placeholder"=>"A/C Holder Name","autocomplete"=>"off");
                                                    echo create_form_input("text","account_name","A/C Holder Name.",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <?php
                                                    $attributes=array("id"=>"ifsc","Placeholder"=>"IFSC Code","autocomplete"=>"off");
                                                    echo create_form_input("text","ifsc","IFSC Code",false,'',$attributes);  
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-sm btn-success" id="savebtn" name="addmember" disabled>Submit</button>
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>	
                        <div id="dot-loader" class="hidden"><img src="<?php echo file_url('assets/images/dotsloader.gif'); ?>" alt="" height="10"></div>
                    </div>
                </div>
            </div>
        
    <script>
		$(document).ready(function(e) {  
			$('#ref').keyup(function(){
				getrefid();
			}); 
			$('#ref').blur(function(){
				getrefid();
			});
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
						//console.log(data);
						$('#position-div').html(poslabel);
						data=JSON.parse(data);
						if(data['name']!=''){
							$('#pdiv').html(data['name']);
							$('#parent_id').val(data['id']);
						}
						$('#position-div').append(data['position']);
						var ele=$('#position')
						//setChosenSelect(ele);
						
					}
				});
			});
			$('#parent').blur(function(){
				if($('#parent_id').val()==''){
					$('#pdiv').html("Enter Valid Placement ID!");
				}
			});
			$('body').on('change','#skill',function(){
                $('#class,#student_name').closest('.col-md-4').addClass('d-none');
                $('#class,#student_name').prop('required',false);
                if($(this).val()=='Spoken English'){
                    $('#class,#student_name').closest('.col-md-4').removeClass('d-none');
                    $('#class,#student_name').prop('required',true);
                }
			});
			$('body').on('keyup','#epin',function(){
				var epin=$(this).val();
				var regid=$('#refid').val();
                if(regid=='' || regid==0){ alert("Enter Sponsor ID First!"); $(this).val('');$('#ref').focus(); return false;}
				$('#epinstatus').removeClass('text-danger').removeClass('text-success');
				$('#savebtn').attr("disabled",true);
				
				elen=epin.length;
				epin=epin.trim();
				enewlen=epin.length;
				if(elen!=enewlen){
					$(this).val(epin);
				}
				
				if(epin==''){
					$('#epinstatus').text('');
					$('#savebtn').removeAttr("disabled");
					return false;
				}
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("epins/checkepin"); ?>",
					data:{epin:epin,regid:regid},
					success: function(data){
						if(data=='1'){
							$('#epinstatus').addClass('text-success').text('E-Pin Available');
							$('#savebtn').removeAttr("disabled");
						}
						else{
							$('#epinstatus').addClass('text-danger').text('E-Pin Not Available');
						}
					}
				});
			});
			if($('#ref').val()!=''){
				$('#ref').trigger('keyup');
			}
			$('body').on('change','#bank',function(){
				var bank=$(this).val();
				if(bank=='xyz'){
					$('#bank-name').removeClass('hidden').attr('name','bank');
				}
				else{
					$('#bank-name').addClass('hidden').removeAttr('name');
				}
			});
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
		
		function getrefid(){
			
			var username=$('#ref').val();
			$('#epin,#refid,#refname').val('');
			$('#refdiv').removeClass('text-danger').removeClass('text-success').html('');
			//$('#position-div').html('');
			$('#savebtn').attr("disabled",true);
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("members/getrefid/"); ?>",
				data:{username:username,status:'all'},
				beforeSend: function(data){
					$('#refdiv').html($('#dot-loader').html());
				},
				success: function(data){
					data=JSON.parse(data);
					if(data['regid']=='' || data['regid']==0){
						$('#refdiv').html(data['name']).addClass('text-danger');
					}else{
						$('#refid').val(data['regid']);
						$('#refname').val(data['name']);
						$('#refdiv').html('').addClass('text-success');
						$('#savebtn').removeAttr("disabled");
					}
					
				}
			});
		}
		
		function setChosenSelect(ele){
			ele.chosen({
				disable_search_threshold: 10,
				no_results_text: "Oops, nothing found!",
				width: "100%"
			});
		}
		
		function validate(){
			$('#savebtn').hide();
		}
	</script>
    
    	

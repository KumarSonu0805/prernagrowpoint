<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Prernagrowpoint - Register</title>
      <?php $this->load->view("website/common/include"); ?>
   </head>
   <body>
      <?php $this->load->view("website/common/navbar"); ?>
     <section class="register-section">
   <div class="container">
      <div class="register-box">

       <div class="row">
        <div class="col-lg-6">
  <h2 class="register-title">Create Your Account</h2>
         <p class="register-subtitle">Join Prernagrowpoint and start your journey today!</p>

         <?php echo form_open_multipart('members/addmember', 'id="myform" onsubmit="return validate()"'); ?>

            <div class="mb-3">
                <?php
                    $attributes=array("id"=>"ref","Placeholder"=>"Sponsor ID ","autocomplete"=>"off",
                                      "class"=>"reg-input");
                    if($this->session->role=='member'){ $attributes["readonly"]="true"; }
                    echo create_form_input("text","","Sponsor ID ",true,$user['username'],$attributes); 
                    echo create_form_input("hidden","refid","",false,$user['id'],array("id"=>"refid")); 
                ?>
                <div style="padding:0 10px; font-size:16px; font-weight:600" id="refdiv"></div>
            </div>

            <div class="mb-3">
                 <?php
                    $attributes=array("id"=>"refname","Placeholder"=>"Sponsor Name","autocomplete"=>"off","readonly"=>true,"class"=>"reg-input");
                    echo create_form_input("text","","Sponsor Name",true,$user['name'],$attributes); 
                ?>
            </div>

              <div class="mb-3">
                 <?php
                    $attributes=array("id"=>"name","Placeholder"=>"Full Name","autocomplete"=>"off","class"=>"reg-input");
                    echo create_form_input("text","name","Name",true,'',$attributes);  
                ?>
              </div>
              <div class="mb-3">
                 <?php
                    $attributes=array("id"=>"father","Placeholder"=>"Father's Name","autocomplete"=>"off","class"=>"reg-input");
                    echo create_form_input("text","father","Father's Name",false,'',$attributes);  
                ?>
              </div>
               <div class="mb-3">
               <?php
                    $attributes=array("id"=>"mobile","Placeholder"=>"Mobile","autocomplete"=>"off","pattern"=>"[0-9]{10}","title"=>"Enter Valid Mobile No.","maxlength"=>"10","class"=>"reg-input");
                    echo create_form_input("text","mobile","Mobile",true,'',$attributes);  
                ?>
              </div>
               <div class="mb-3">
                <?php
                    echo create_form_input("date","dob","Date Of Birth",false,'',array("id"=>"dob","class"=>"reg-input"));  
                ?>
              </div>
               <div class="mb-3">
                    <?php
                        $attributes=array("id"=>"address","Placeholder"=>"Address","autocomplete"=>"off","rows"=>"3","class"=>"reg-input");
                        echo create_form_input("textarea","address","Address",false,'',$attributes);  
                    ?>
              </div>
               <div class="mb-3">
                    <?php
                        $attributes=array("id"=>"district","Placeholder"=>"District","autocomplete"=>"off","class"=>"reg-input");
                        echo create_form_input("text","district","District",false,'',$attributes);  
                    ?>
              </div>
               <div class="mb-3">
                    <?php
                        $attributes=array("id"=>"state","Placeholder"=>"State","autocomplete"=>"off","class"=>"reg-input");
                        echo create_form_input("text","state","State",false,'',$attributes);  
                    ?>
              </div>
           <div class="d-none">
            <?php
               $attributes=array("id"=>"email","Placeholder"=>"Email","autocomplete"=>"off");
                echo create_form_input("email","email","Email",false,'',$attributes); 
               $gender=array(""=>"Select Gender","Male"=>"Male","Female"=>"Female");
                echo create_form_input("select","gender","Gender",false,'',array("id"=>"gender"),$gender); 
               $mstatus=array(""=>"Select","Married"=>"Married","Unmarried"=>"Unmarried");
                                    echo create_form_input("select","mstatus","Marital Status",false,'',array("id"=>"mstatus"),$mstatus); 
               $attributes=array("id"=>"aadhar","Placeholder"=>"Aadhar No.","pattern"=>"[0-9]{12}","title"=>"Enter Valid Aadhar No.","autocomplete"=>"off","maxlength"=>"12");
                                    echo create_form_input("text","aadhar","Aadhar No.",false,'',$attributes);  
               $attributes=array("id"=>"pincode","Placeholder"=>"Pincode","pattern"=>"[0-9]{6}","title"=>"Enter Valid Pincode","autocomplete"=>"off","maxlength"=>"6");
                                    echo create_form_input("text","pincode","Pincode",false,'',$attributes); 

               echo create_form_input("date","date","Joining Date",true,date('Y-m-d'),array("id"=>"date"));  
               echo create_form_input("file","photo","Upload Image",false,'',array("id"=>"photo","onChange"=>"getPhoto(this)"));  

               echo create_form_input("select","bank","Bank Name",false,'',array("id"=>"bank"),[''=>'select']); 
                                    $input=array("id"=>"bank-name","Placeholder"=>"Bank Name","class"=>"form-control hidden mt-2",
                                                    "autocomplete"=>"off","pattern"=>"[\w\s]+","title"=>"Enter Valid Bank Name","value"=>"");
                                    echo form_input($input);
               $attributes=array("id"=>"branch","Placeholder"=>"Branch","autocomplete"=>"off");
                                    echo create_form_input("text","branch","Branch",false,'',$attributes);  

               $attributes=array("id"=>"pan","Placeholder"=>"PAN No.","pattern"=>"[A-Za-z0-9]{10}","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10");
                                    echo create_form_input("text","pan","PAN No.",false,'',$attributes);  

               $attributes=array("id"=>"pan","Placeholder"=>"PAN No.","pattern"=>"[A-Za-z0-9]{10}","title"=>"Enter Valid Pan No.","autocomplete"=>"off","maxlength"=>"10");
                                    echo create_form_input("text","pan","PAN No.",false,'',$attributes);  
                $attributes=array("id"=>"account_no","Placeholder"=>"A/C No.","autocomplete"=>"off");
                                    echo create_form_input("text","account_no","A/C No.",false,'',$attributes); 
               $attributes=array("id"=>"account_name","Placeholder"=>"A/C Holder Name","autocomplete"=>"off");
                                    echo create_form_input("text","account_name","A/C Holder Name.",false,'',$attributes);  

               $attributes=array("id"=>"ifsc","Placeholder"=>"IFSC Code","autocomplete"=>"off");
                                    echo create_form_input("text","ifsc","IFSC Code",false,'',$attributes); 


               ?>

            </div>
            <button type="submit" id="savebtn" name="addmember"  class="register-btn">Register</button>

            <p class="login-text">
               Already have an account? <a href="../login/" class="login-link">Login here</a>
            </p>

         </form>
        </div>
        <div class="col-lg-6">
 <div class="loginimg">
                    <img src="../images/register.webp" alt="login image">
                </div>
        </div>
       </div>
      </div>
   </div>
</section>
      <div id="dot-loader" class="d-none"><img src="<?php echo file_url('assets/images/loader.gif'); ?>" alt="" height="10"></div>

  
      <?php $this->load->view("website/common/footer"); ?>
      <?php $this->load->view("website/common/vendor"); ?>
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
                $('#class,#student_name').closest('.col-lg-6').addClass('d-none');
                $('#class,#student_name').prop('required',false);
                if($(this).val()=='Spoken English'){
                    $('#class,#student_name').closest('.col-lg-6').removeClass('d-none');
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
					$('#bank-name').removeClass('d-none').attr('name','bank');
				}
				else{
					$('#bank-name').addClass('d-none').removeAttr('name');
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
				data:{username:username,status:'activated'},
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
   </body>
</html>
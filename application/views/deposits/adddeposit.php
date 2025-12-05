
<?php
if($type=='activation'){
    if($request){
        $button='<button type="submit" class="btn btn-sm btn-success" name="saveactivation" value="Request">Save Activation Request</button>';
    }
    else{
        $button=$message;
    }
    $amount=1100;
    $to_regid=false;
}
else{
    $button='<button type="submit" class="btn btn-sm btn-success" name="savedeposit" value="Request">Save Deposit</button>';
    $admin_acc_details=array();
    $amount='';
    $to_regid=true;
}
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
                                                <?php echo form_open_multipart('deposits/savedeposit', 'id="myform" onSubmit="return validate();"'); ?>
                                                    <div class="form-group">
                                                        <?php
                                                            echo create_form_input("date","date","Date",true,date('Y-m-d'),['readonly'=>'true']); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            echo create_form_input("text","","Member ID",false,$user['username'],array("readonly"=>"true")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            echo create_form_input("text","name","Name",false,$user['name'],array("readonly"=>"true")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group <?= !$to_regid?'d-none':'' ?>">
                                                        <?php
                                                            echo create_form_input("text","","Member ID",$to_regid,'',array("id"=>"username")); 
                                                            echo create_form_input("text","to_regid","",false,'1',array("id"=>"to_regid")); 
                                                        ?>
                                                        <div id="name" class="lead"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $attributes=array("id"=>"amount");
                                                            if(!empty($amount)){
                                                                $attributes['readonly']='true';
                                                            }
                                                            echo create_form_input("text","amount","Deposit Amount",true,$amount,$attributes); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group d-none">
                                                        <?php
                                                            echo create_form_input("text","","Deposit Amount ",true,'',array("id"=>"inr_amount","readonly"=>"true")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <?php
                                                            $trans_type=array(""=>"Select","Bank Transfer"=>"Bank Transfer");//"Net Banking"=>"Net Banking","UPI"=>"UPI","CASH"=>"CASH");
                                                            //$type['ewallet']="Wallet Balance";
                                                            echo create_form_input("select","trans_type","Transaction Type",true,'',array("id"=>"trans_type"),$trans_type); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group request">
                                                        <?php
                                                            echo create_form_input("textarea","details","Transaction Details",true,'',array("id"=>"details","rows"=>"2")); 
                                                        ?>
                                                    </div>
                                                    <div class="form-group request">
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    <?php 
                                                                        $attributes=array("id"=>"image","onChange"=>"getPhoto(this,'image')");
                                                                        echo create_form_input("file","image","Upload Receipt:",true,'',$attributes); 
                                                                    ?>
                                                                </div>
                                                            <div class="col-xs-6">
                                                                <img  id="imagepreview" style="height:150px; width:250px;" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        echo create_form_input("hidden","type","",false,$type); 
                                                        echo create_form_input("hidden","regid","",false,$user['id']); 
                                                    ?>
                                                    <?= $button; ?>
                                                <?php echo form_close(); ?>
                                            </div>	
                                            <?php
                                                if(!empty($admin_acc_details)){
                                            ?>
                                            <div class="col-md-7">
                                                <legend>Bank Information</legend>
                                                <table class="table" id="bank-details">
                                                    <tr>
                                                        <th>A/C Holder Name</th>
                                                        <td><?= $admin_acc_details['account_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <td><?= strtoupper($admin_acc_details['bank']);  ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Account Number</th>
                                                        <td><?= $admin_acc_details['account_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Branch</th>
                                                        <td><?= $admin_acc_details['branch']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>IFSC Code</th>
                                                        <td><?= $admin_acc_details['ifsc']; ?></td>
                                                    </tr>
                                                    <?php /*?><tr>
                                                        <th>UPI</th>
                                                        <td><?= $admin_acc_details['upi']; ?></td>
                                                    </tr><?php */?>
                                                </table>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
<script>
	$(document).ready(function(e) {
		$('#username').keyup(function(){
			$('#name').html('');
			$('#to_regid').val('');
			$('#submit-btn').attr('disabled',true);
		});
		$('#username').blur(function(){
			var username=$(this).val();
			var status='all';
			if(username!='' && username!='admin'){
				if($('#type_from').val()==$('#type_to').val()){
					status="not self";
				}
				$.ajax({
					type:"POST",
					url:"<?php echo base_url("members/getmemberid/"); ?>",
					data:{username:username,status:status},
					success: function(data){
						data=JSON.parse(data);
						if(data['regid']!=0){
							$('#name').html("<span class='text-success'>"+data['name']+"</span>");
							$('#to_regid').val(data['regid']);
							$('#submit-btn').prop("disabled",false);
						}
						else{$('#name').html("<span class='text-danger'>"+data['name']+"</span>");}
					}
				});
			}
		});
		$('#amount').keyup(function(){
			var amount=$(this).val();
			amount=amount.replace(/[^\d\.]+/,'');
			$(this).val(amount);
            var total_amount=amount*1;
			$('#inr_amount').val(total_amount);
		});
		$('#trans_type').change(function(){
			var type=$(this).val();
			if(type=='USDT' || type=='Bank Transfer' || type=='Net Banking' || type=='UPI'){
				$('.request').removeClass('hidden');
				$('#details,#image').attr("required",true);
			}
			else{
				var id="#"+type;
				//$('#avl_balance').val($(id).val());
				$('.request').addClass('hidden');
				$('#details,#image').removeAttr("required");
			}
		});
    });
	
	function getPhoto(input,field){
		var id="#"+field;
		var preview="#"+field+"preview";
		$(preview).replaceWith('<img id="'+field+'preview" style="height:150px; width:250px;" >');
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
						$(preview).attr('src',e.target.result);
					}
					reader.readAsDataURL(input.files[0]);
				}
				else if(size>=2097152){
					document.getElementById(field).value= null;
					alert("Image size is greater than 2MB");	
				}
				else if(size<=20480){
					document.getElementById(field).value= null; 
					alert("Image size is less than 20KB");	
				}
			}
			else{
				document.getElementById(field).value= null;
				alert("Select 'jpeg' or 'jpg' or 'png' image file!!");	
			}
		}
	}
	function validate(){
		var avl=Number($('#avl_balance').val());
		var amount=Number($('#amount').val());
		if($('#type').val()!='request'){
			if(avl<amount){
				alert("Pin Amount Must be less than Available Balance!");
				return false;
			}
		}
	}
    function copyAddress() {
      // Select the link text
      const linkElement = document.getElementById('copyAddress');
      const linkText = linkElement.textContent || linkElement.innerText;

      // Use navigator.clipboard.writeText for modern browsers
      navigator.clipboard.writeText(linkText)
        .then(() => {
          alert('Address copied to clipboard!');
        })
        .catch((err) => {
          console.error('Unable to copy link', err);
        });
    }
</script>
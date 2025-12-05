
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <?php 
									if(isset($withdrawal) && $withdrawal===false){
                                        echo "<div class='text-center'><h2 class='text-danger'>Please Add Atleast 3 Direct Members to Activate Withdrawal</h2></div>";
									}
                                    elseif(!empty($acc_details['bank']) && !empty($acc_details['account_no'])){
                                        echo form_open_multipart('wallet/requestpayout', 'id="myform"'); 
                                ?>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("date","date","Date",true,date('Y-m-d')); 
                                        ?>
                                    </div>
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
                                            echo create_form_input("text","","E-Wallet Balance",false,$avl_balance,array("id"=>"avl_balance","readonly"=>"true")); 
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input('number','amount','Withdrawal Amount',true,'',array("id"=>"amount","Placeholder"=>"Withdrawal Amount","autocomplete"=>"off","min"=>MIN_WITHDRAW));
                                        ?><p class="text-danger">* <?= TDS ?>% TDS and <?= ADMIN_CHARGE ?>% Admin Charge Will be deducted from Withdrawal Amount</p>
                                    </div>
                                    <?php
                                        echo create_form_input("hidden","regid","",false,$user['id']); 
                                    ?>
                                    
                                    <button type="submit" class="btn btn-sm btn-success" name="requestpayout" value="Request">Request Withdrawal</button>
                                <?php 
                                        echo form_close(); 
                                    }
                                    elseif(isset($acc_details['kyc']) && $acc_details['kyc']=='2'){
                                        echo "<div class='text-center'><h2 class='text-danger'>KYC Approval is Pending!</h2></div>";
                                    }
                                    else{
                                        echo "<div class='text-center'><h2 class='text-danger'>Please Add Your Bank Details to Request Withdrawal</h2>";
                                        echo "<a href='".base_url('profile/accdetails/')."' class='btn btn-sm btn-info'>Add Bank Details</a></div>";
                                    }
									if(!isset($acc_details['account_name'])){
										 $acc_details['account_name']= $acc_details['bank']= $acc_details['account_no']= $acc_details['branch']= $acc_details['ifsc']="";
									}
                                ?>
                            </div>
                            <div class="col-md-6 profile">
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
                                </table>
							</div>
						</div>
                    </div>
                </div>
            </div>
                

<script>
	$(document).ready(function(e) {
        $('#amount').keyup(function(){
			var avl=Number($('#avl_balance').val());
			var amount=Number($(this).val());
			if(isNaN(amount)){ amount=0; }
			if(amount>avl){
				alert("Withdrawal Amount should be less than Available Balance!");
				$(this).val('');
			}
		});
    });
	function validate(){
		if(!confirm("Add package for this member?")){
			return false;
		}
	}
</script>
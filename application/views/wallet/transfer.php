<section class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $title; ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo form_open('wallet/transferamount', 'id="myform"'); ?>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input("text","","Member ID",true,'',array("id"=>"username")); 
                                            echo create_form_input("hidden","reg_to","",false,'0',array("id"=>"reg_to")); 
                                        ?>
                                        <div id="name" class="lead"></div>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            if($avl_balance!==false){
                                                echo create_form_input('text','','Available Balance',false,$avl_balance,array("id"=>"available","readonly"=>"true"));
                                            }
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?php
                                            echo create_form_input('number','amount','Transfer Points',true,'',array("id"=>"amount","autocomplete"=>"off"));
                                            echo create_form_input("hidden","type_from","",false,$type_from,array("id"=>"type_from")); 
                                            echo create_form_input("hidden","type_to","",false,$type_to,array("id"=>"type_to")); 
                                            echo create_form_input("hidden","reg_from","",false,$user['id']); 
                                        ?>
                                    </div>
                                    <div class="form-group hidden" id="otp-row">
                                     	<?php echo create_form_input('password','otp','Enter OTP',true,'',array("id"=>"otp","autocomplete"=>"off")); ?>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-12" id="btn-div">
                                            <img src="<?php echo base_url("assets/images/loading.gif"); ?>" alt="loading" class="hidden">
                                            <button type="button" class="btn btn-sm btn-success" id="submit-btn" disabled>Transfer Points</button>
                                            <input type="submit" name="transferamount" value="Validate OTP" id="validate-btn" class="btn btn-sm btn-success hidden">
                                            <span id="timer" class="hidden"></span>
                                            <input type="button" id="resend" class="btn btn-sm btn-primary hidden" value="Resend OTP">
                                        </div>
                                    </div>
                                <?php echo form_close(); ?>
    
                            </div>
                            <div class="col-md-6">
                            	<div class="table-responsive" id="result">
                                    <table class="table table-bordered data-table" id="bootstrap-data-table-export">
                                        <thead>
                                            <tr>
                                                <th>Sl No.</th>
                                                <th>Date Time</th>
                                                <th>Receiver's Id</th>
                                                <th>Receiver's Name</th>
                                                <th>Points</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $transfers=$transfers;
                                                if(is_array($transfers)){$i=0;
                                                    foreach($transfers as $transfer){
                                                        $i++;
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo date('d-m-Y H:i A',strtotime($transfer['added_on'])); ?></td>
                                                <td><?php echo $transfer['to_id']; ?></td>
                                                <td><?php echo $transfer['to_name']; ?></td>
                                                <td><?php echo $this->amount->toDecimal($transfer['amount']); ?></td>
                                            </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
	var timer;
	$(document).ready(function(e) {
		$('#bootstrap-data-table-export').DataTable();
		$('#username').keyup(function(){
			$('#name').html('');
			$('#reg_to').val('');
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
							$('#reg_to').val(data['regid']);
							$('#submit-btn').prop("disabled",false);
						}
						else{$('#name').html("<span class='text-danger'>"+data['name']+"</span>");}
					}
				});
			}
		});
		<?php
			if($avl_balance!==false){
		?>
		$('#amount').keyup(function(){
			var quantity=Number($(this).val());
			var avl=Number($('#available').val());
			if(isNaN(avl)){avl=0;}
			if(quantity>avl){
				alert("Balance Not available!");
				$('#amount').val('');
			}
		});
		<?php
			}
		?>
		
		$('#submit-btn').click(function(){
			if($('#amount').get(0).checkValidity()){
				$('#username,#amount').attr('readonly',true);
			}
			else{
				$('#amount').get(0).reportValidity();
				return false; 
			}
			$('#timer').removeClass('hidden');
			$('#resend').addClass('hidden');
			var username=$('#username').val();
			var amount=$('#amount').val();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("wallet/generateotp/"); ?>",
				data:{username:username,amount:amount,generateotp:'generateotp'},
				beforeSend: function(){
					$('#btn-div').find('img').removeClass("hidden");
					$('#btn-div').children().not('img').addClass('hidden');
				},
				success: function(data){
					$('#btn-div').find('img').addClass("hidden");
					$('#otp-row,#validate-btn,#timer').removeClass("hidden");
					timer=setInterval(startTimer, 1000);
				}
			});
		});
		$('#resend').click(function(){
			$('#timer').removeClass('hidden');
			$('#resend').addClass('hidden');
			var username=$('#username').val();
			var amount=$('#amount').val();
			$.ajax({
				type:"POST",
				url:"<?php echo base_url("wallet/resendotp/"); ?>",
				data:{username:username,amount:amount,resendotp:'resendotp'},
				beforeSend: function(){
					$('#btn-div').find('img').removeClass("hidden");
					$('#btn-div').children().not('img').addClass('hidden');
				},
				success: function(data){
					$('#btn-div').find('img').addClass("hidden");
					$('#otp-row,#validate-btn,#timer').removeClass("hidden");
					timer=setInterval(startTimer, 1000);
				}
			});
		});
    });
	
	
	var remaining=30;
	function startTimer(){
		remaining--;
		var msg="Resend Verification Code in "+remaining+" seconds.";
		$('#timer').text(msg);
		if(remaining==0){
			remaining=30;
			msg="Resend OTP in "+remaining+" seconds.";
			$('#timer').text(msg);
			$('#resend').removeClass('hidden');
			$('#timer').addClass('hidden');
			clearInterval(timer);
		}
	}
</script>
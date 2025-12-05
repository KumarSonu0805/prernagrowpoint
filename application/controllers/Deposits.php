<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposits extends CI_Controller {

	function __construct(){
		parent::__construct();
        checklogin();
        logrequest();
	}
	
	public function index(){
		if(!empty($this->session->deposit_id)){
			redirect('deposits/makepayment/');
		}
		$data['title']="Add Deposits";
		$data['breadcrumb']=array("home/"=>"Home");
        $data['user']=getuser();
		$regid=$data['user']['id'];
        $type=$this->uri->segment(1)=='activateaccount'?'activation':'deposit';
        if($type=='activation'){
            $data['title']="Account Activation";
            $deposit=$this->deposit->getdepositlist(array("type"=>"activation","regid"=>$regid));
            $data['request']=true;
            if(!empty($deposit)){
                $deposit=end($deposit);
                $data['request']=$deposit['status']!=2?false:true;
                $data['message']=$deposit['status']==1?'<h4 class="text-success">Account Already Activated!</h4>'
                                                    :'<h4 class="text-primary">Activation Request Already Saved!</h4>';
            }
        }
		else{
			redirect('home/');
		}
		$acc_details=$this->member->getaccdetails($regid);
		$data['acc_details']=$acc_details;
        $data['member']=$this->member->getmemberdetails($regid);
        $admin_acc_details=$this->member->getaccdetails(1);
        if(!empty($admin_acc_details)){
            $data['admin_acc_details']=$admin_acc_details;
        }
        $data['type']=$type;
        $data['regid']=$regid;
		$this->template->load('deposits','activateaccount',$data);
	}
    
	public function transfermoney(){
        $id=$this->input->get('id');
        $donation=$this->deposit->getpendingdonation(["md5(concat('donation-id-',t1.id))"=>$id],'single');
        if(empty($donation)){
           redirect('home/'); 
        }
        $to_regid=$donation['to_regid'];
		$data['title']="Transfer Money";
		$data['breadcrumb']=array("home/"=>"Home");
        $data['user']=getuser();
		$regid=$data['user']['id'];
        $type='deposit';
        $deposit=$this->deposit->getdepositlist(array("type"=>"deposit","ref_id"=>$donation['id'],"regid"=>$regid,"to_regid"=>$to_regid));
        $data['request']=true;
        if(!empty($deposit)){
            $deposit=end($deposit);
            $data['request']=$deposit['status']!=2?false:true;
            $data['message']=$deposit['status']==1?'<h4 class="text-success">Amount Already Transferred!</h4>'
                                                :'<h4 class="text-primary">Transfer Request Already Saved!</h4>';
        }
		$acc_details=$this->member->getaccdetails($regid);
		$data['acc_details']=$acc_details;
        $data['member']=$this->member->getmemberdetails($regid);
        $getmember=$this->account->getuser(['id'=>$to_regid]);
        $data['member']=$getmember['user'];
        $admin_acc_details=$this->member->getaccdetails(1);
        $member_acc_details=$this->member->getaccdetails($to_regid);
        if(!empty($member_acc_details)){
            $data['member_acc_details']=$member_acc_details;
        }
        if(empty($data['member_acc_details'])){
            $data['member_acc_details']=$admin_acc_details;
        }
        $data['type']=$type;
        $data['donation']=$donation;
		$this->template->load('deposits','transfermoney',$data);
	}
    
	public function transferrequest(){
		if($this->session->role!='admin'){ redirect('home/'); }
		$data['title']="Transfer Request";
		$data['breadcrumb']=array("home/"=>"Home");
        $type='deposit';
        $data['type']=$type;
		$this->template->load('deposits','transferrequest',$data);
	}
    
	public function depositlist(){
		if($this->session->role=='admin'){ redirect('home/'); }
		$data['title']="Deposit List";
		$data['breadcrumb']=array("home/"=>"Home");
        $data['user']=getuser();
		$regid=$data['user']['id'];
        $members=array();
        $members=$this->deposit->getdeposits(array("t1.regid"=>$regid));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('deposits','depositlist',$data);
	}
	
	public function requestlist(){
        $user=getuser();
        $regid=$user['id'];
        $data['user']=$user;
		$data['title']="Deposit Requests";
		$today=date('Y-m-d');
		$where=array("t1.type"=>"deposit",'t1.to_regid'=>$regid,"t1.status"=>0);
		$members=$this->deposit->getdepositlistrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$data['datatableexport']=true;
        if($this->session->role=='admin'){
            $this->template->load('deposits','depositlist',$data);
        }
		else{
            $this->template->load('deposits','memberdepositlist',$data);
        }
	}
	
	public function transferrequestlist(){
		if($this->session->role!='admin'){ redirect('home/'); }
		$data['title']="Transfer Request List";
		$today=date('Y-m-d');
		$data['donations']=$this->deposit->getpendingdonation(['t1.regid'=>0]);
		$data['datatable']=true;
		$data['datatableexport']=true;
        
        $this->template->load('deposits','transferrequestlist',$data);
	}
	
	public function approvedlist(){
        $user=getuser();
        $regid=$user['id'];
        $data['user']=$user;
		$data['title']="Approved Deposits";
		$where=array("t1.type"=>"deposit",'t1.to_regid'=>$regid,"t1.status"=>1);
		$members=$this->deposit->getdepositlistrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$data['datatableexport']=true;
		$this->template->load('deposits','approvedlist',$data);
	}
	
	public function makepayment(){
		$deposit_id=$this->session->deposit_id;
		if(empty($deposit_id)){
			redirect('/');
		}
        $user=getuser();
        $regid=$user['id'];
        $data['user']=$user;
		$data['title']="Make Payment";
		$where=array("t1.id"=>$deposit_id,"t1.status"=>0);
		$members=$this->deposit->getdepositlistrequest($where);
		if(empty($members[0])){
			redirect('/');
		}
		else{
			$deposit=$members[0];
		}
		$data['deposit']=$deposit;
        $redirect_url=base_url('home/sbresponse/');
        $sbdata=array('amount'=>$deposit['amount'],'user_id'=>$user['id'],'mobile'=>$user['mobile'],'transactionId'=>uniqid(),
                        'redirect_url'=>$redirect_url);
		$this->load->helper('sabpaisa');
		$response=createtransaction($sbdata);
		$data['sabpaisa']=$response;
		$this->template->load('deposits','makepayment',$data);
	}
	
	public function saverequest(){
		if($this->input->post('saverequest')!==NULL){
			$data=$this->input->post();
            $data = array_map('strip_tags', $data);
            $data = array_map('htmlspecialchars', $data);
			unset($data['saverequest'],$data['saveactivation'],$data['name']);
            //print_pre($data,true);
            //if($data['amount']>=MIN_DEPOSIT && $data['amount']<=MAX_DEPOSIT){
                $data['updated_on']=$data['added_on']=date('Y-m-d H:i:s');
                //print_pre($data,true);
                $result=$this->deposit->saverequest($data);
                if($result['status']===true){
                    $this->session->set_flashdata("msg",$result['message']);
                }
                else{
                    $this->session->set_flashdata("err_msg",$result['message']);
                }
			//}
			//else{
				//$this->session->set_flashdata("err_msg","Invalid Request Amount!");
			//}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function savedeposit(){
		if($this->input->post('savedeposit')!==NULL || $this->input->post('saveactivation')!==NULL){
			$data=$this->input->post();
            $data = array_map('strip_tags', $data);
            $data = array_map('htmlspecialchars', $data);
            $member=$this->member->getmemberdetails($data['regid']);
			unset($data['savedeposit'],$data['saveactivation'],$data['name']);
            $upload_path="./assets/uploads/deposits/";
            $allowed_types="jpg|jpeg|png";
            $upload=upload_file('image',$upload_path,$allowed_types,$member['name'].'-screenshot');
            if($upload['status']===true){
                $data['image']=$upload['path'];
            }
            //if($data['amount']>=MIN_DEPOSIT && $data['amount']<=MAX_DEPOSIT){
                $data['updated_on']=$data['added_on']=date('Y-m-d H:i:s');
                //print_pre($data,true);
                $result=$this->deposit->savedeposit($data);
                if($result['status']===true){
					$this->session->set_flashdata("msg",$result['message']);
					if($data['to_regid']==1 && $data['trans_type']=='Online'){
						$this->session->set_userdata('deposit_id',$result['deposit_id']);
						//$this->session->set_flashdata("msg",$result['message']);
						redirect('deposits/makepayment/');
					}
					else{
						$this->session->set_flashdata("msg",$result['message']);
                        redirect($_SERVER['HTTP_REFERER']);
					}
                }
                else{
                    $this->session->set_flashdata("err_msg",$result['message']);
                    redirect($_SERVER['HTTP_REFERER']);
                }
			//}
			//else{
				//$this->session->set_flashdata("err_msg","Invalid Request Amount!");
			//}
		}
		else{
            redirect($_SERVER['HTTP_REFERER']);
        }
	}
	
	public function oldsavedeposit(){
		if($this->input->post('savedeposit')!==NULL || $this->input->post('saveactivation')!==NULL){
			$data=$this->input->post();
            $data = array_map('strip_tags', $data);
            $data = array_map('htmlspecialchars', $data);
            $member=$this->member->getmemberdetails($data['regid']);
			unset($data['savedeposit'],$data['saveactivation'],$data['name']);
            $upload_path="./assets/uploads/deposits/";
            $allowed_types="jpg|jpeg|png";
            $upload=upload_file('image',$upload_path,$allowed_types,$member['name'].'-screenshot');
            if($upload['status']===true){
                $data['image']=$upload['path'];
            }
            //if($data['amount']>=MIN_DEPOSIT && $data['amount']<=MAX_DEPOSIT){
                $data['updated_on']=$data['added_on']=date('Y-m-d H:i:s');
                //print_pre($data,true);
                $result=$this->deposit->savedeposit($data);
                if($result['status']===true){
					$this->session->set_flashdata("msg",$result['message']);
					if($data['to_regid']==1 && $data['trans_type']=='Online'){
						$user=getuser();
                        $params="user=".md5('user-id-'.$user['id']).'&deposit='.md5('deposit-id-'.$result['deposit_id']);
						/*$this->load->library('phonepe');
						$redirect_url=base_url('home/paymentresponse/?'.$params);
						$data=array('amount'=>$data['amount'],'user_id'=>$user['id'],'mobile'=>$user['mobile'],'transactionId'=>uniqid(),
										'redirect_url'=>$redirect_url);
						$this->phonepe->initiatePayment($data);*/
                        
                        if(PHONEPE_ENV=='sandbox'){
                            $enc_order_id='local-';
                        }
                        else{
                            $enc_order_id='online-';
                        }
                        $enc_order_id.='deposit-id-'.$result['deposit_id'];
                        $enc_order_id=md5($enc_order_id);
                        
                        $this->load->library('phonepe2');
                        $redirect_url=base_url('home/paymentresponse/?'.$params);
                        $data=array('amount'=>$data['amount'],'user_id'=>$user['id'],'mobile'=>$user['mobile'],
                                    'transactionId'=>uniqid(),'order_id'=>$enc_order_id,'redirect_url'=>$redirect_url);
                        $this->phonepe2->initiatePayment($data);
					}
					else{
                        redirect($_SERVER['HTTP_REFERER']);
					}
                    $this->session->set_flashdata("msg",$result['message']);
                }
                else{
                    $this->session->set_flashdata("err_msg",$result['message']);
                    redirect($_SERVER['HTTP_REFERER']);
                }
			//}
			//else{
				//$this->session->set_flashdata("err_msg","Invalid Request Amount!");
			//}
		}
		else{
            redirect($_SERVER['HTTP_REFERER']);
        }
	}
	
	public function approvedeposit(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->deposit->approvedeposit($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Deposit Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function rejectdeposit(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->deposit->rejectdeposit($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Deposit Request Rejected!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}

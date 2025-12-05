<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends MY_Controller {
	function __construct(){
		parent::__construct();
		checklogin();
	}
	
	public function index(){
		$data['title']="Wallet Balance";
		$data['breadcrumb']=array("/"=>"Home");
        $data['user']=getuser();
		$regid=$data['user']['id'];
		$this->wallet->addcommission($regid);
		$data['wallet']=$this->wallet->getwallet($regid);
		$members=$this->wallet->getmemberrequests(array("regid"=>$regid));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','wallet',$data);
	}
	
	public function incomes(){
		$data['title']="My Incomes";
		$data['breadcrumb']=array("/"=>"Home");
        $data['user']=getuser();
		$regid=$data['user']['id'];
		$data['incomes']=$this->wallet->memberincome($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	
	public function membercommission(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Member Commission";
		$data['breadcrumb']=array("/"=>"Home");
        $data['user']=getuser();
		$data['memberincomes']=$this->wallet->getmembercommission();
		$data['datatable']=true;
		$this->template->load('wallet','membercommission',$data);
	}
	
	public function memberincome($regid=NULL){
		if($this->session->role!='admin'){ redirect('/'); }
		if($regid===NULL){ redirect("wallet/membercommission/"); }
		$data['title']="Member Income";
		$data['breadcrumb']=array("/"=>"Home");
        $data['user']=getuser();
		$data['incomes']=$this->wallet->memberincome($regid);
		$data['datatable']=true;
		$this->template->load('wallet','incomes',$data);
	}
	
	public function wallettransfer(){
		$data['breadcrumb']=array("/"=>"Home",""=>"Wallet");
        $data['user']=getuser();
		$regid=$data['user']['id'];
        if($this->session->role=='admin'){
            $data['avl_balance']=false;
			$data['title']="Fund Transfer";
        }
        else{
            $wallet=$this->wallet->getwallet($regid);
            $data['avl_balance']=$wallet['actualwallet'];
			$data['title']="Wallet Transfer";
        }
		$data['transfers']=$this->wallet->gethistory($regid);
		$data['datatable']=true;
		
		$data['type_from']="ewallet";
		$data['type_to']="ewallet";
		$this->template->load('wallet','transfer',$data);
	}
	
	public function walletreceived(){
		$data['title']="Wallet Received History";
		$data['breadcrumb']=array("/"=>"Home",""=>"Wallet");
        $data['user']=getuser();
		$regid=$data['user']['id'];
		
		$data['transfers']=$this->wallet->gethistory($regid,"received","ewallet");
		$data['datatable']=true;
		$this->template->load('wallet','transferhistory',$data);
	}
	
	public function withdrawal(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Witdrawal";
		$data['breadcrumb']=array("/"=>"Home","wallet/"=>"Wallet");
        $data['user']=getuser();
		$regid=$data['user']['id'];
		$acc_details=$this->member->getaccdetails($regid);
		$data['acc_details']=$acc_details;
		$wallet=$this->wallet->getwallet($regid);
		$avl_balance=$wallet['actualwallet'];
		$data['datatable']=true;
		$data['avl_balance']=$avl_balance;
		$this->template->load('wallet','request',$data);
	}
	
	public function memberrewards(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Member Rewards";
		$members=$this->wallet->getmemberrewards();
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','memberrewards',$data);
	}
	
	public function requestlist(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Withdrawal Requests";
		$endtime=date('Y-m-d 18:00:00');
		$today=date('Y-m-d');
		//$where=array("t1.status"=>0,"t1.added_on<"=>$endtime);
		$where="(t1.status=0 and t1.added_on<'$endtime') or (t1.status=1 and t1.approve_date='$today') ";
		$members=$this->wallet->getwitdrawalrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','requestlist',$data);
	}
	
	public function dailypaymentreport(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Daily Payment List";
		$payments=$this->wallet->dailypaymentreport();
		$data['payments']=$payments;
		$data['datatable']=true;
		$this->template->load('wallet','dailypaymentreport',$data);
	}
	
	public function paymentreport(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Payment Report";
		$members=$this->wallet->paymentreport();
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('wallet','report',$data);
	}
	
	public function getpaylist(){
		$from=$this->input->post('from');
		$to=$this->input->post('to');
		$where=array();
		if($from!='' && $to!=''){
			$where['t1.approve_date>=']=$from;
			$where['t1.approve_date<=']=$to;
		}elseif($from!='' && $to==''){
			$where['t1.approve_date=']=$from;
		}
		elseif($from=='' && $to!=''){
			$where['t1.approve_date=']=$to;
		}
		
		$members=$this->wallet->paymentreport($where);
		$data['members']=$members;
		$this->load->view("wallet/paylist",$data);
	}
	
	public function transferamount(){
		if($this->input->post('transferamount')!==NULL){
			$data=$this->input->post();
			if($data['otp']==$this->session->transfer_otp){
				$this->session->unset_userdata('transfer_otp');
				unset($data['otp']);
				unset($data['transferamount']);
				$data['date']=date('Y-m-d');
				$data['added_on']=date('Y-m-d H:i:s');
				$result=$this->wallet->transferamount($data);
				if($result===true){
					$this->session->set_flashdata("msg","Amount Transferred successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$this->session->set_flashdata("err_msg","Invalid OTP!");
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function requestpayout(){
		if($this->input->post('requestpayout')!==NULL){
			$data=$this->input->post();
			unset($data['requestpayout']);
            if($data['amount']>=MIN_WITHDRAW){
                $data['tds']=(TDS*$data['amount'])/100;
                $data['admin_charge']=(ADMIN_CHARGE*$data['amount'])/100;
                $data['payable']=$data['amount']-(((TDS+ADMIN_CHARGE)*$data['amount'])/100);
                $data['updated_on']=$data['added_on']=date('Y-m-d H:i:s');
                $result=$this->wallet->requestpayout($data);
                if($result===true){
                    $this->session->set_flashdata("msg","Withdrawal Request Submitted successfully!");
                }
                else{
                    $this->session->set_flashdata("err_msg",$result['message']);
                }
			}
			else{
				$this->session->set_flashdata("err_msg","Invalid Amount!");
			}
		}
		redirect('wallet/withdrawal/');
	}
	
	public function approvepayout(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->wallet->approvepayout($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}
	
	public function approveallpayout(){
		$endtime=date('Y-m-d 18:00:00');
		$result=$this->wallet->approveallpayout($endtime);
		echo date('Y-m-d');
	}
	
	public function rejectpayout(){
		if($this->input->post('request_id')!==NULL){
			$request_id=$this->input->post('request_id');
			$result=$this->wallet->rejectpayout($request_id);
			if($result===true){
				$this->session->set_flashdata("msg","Payout Request Rejected!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/requestlist/');
	}
	
	public function approvereward(){
		if($this->input->post('request_id')!==NULL){
			$id=$this->input->post('request_id');
			$result=$this->wallet->approvereward($id);
			if($result===true){
				$this->session->set_flashdata("msg","Member Reward Approved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('wallet/memberrewards/');
	}
	
	public function upgradeautopool(){
		if($this->input->post('upgradeautopool')!==NULL){
			$data=$this->input->post();
			unset($data['upgradeautopool']);
			$result=$this->wallet->upgradeautopool($data);
			if($result===true){
				$this->session->set_flashdata("msg","Auto Pool Upgraded Successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/upgrade/');
	}
	
	public function generateotp(){
        $data['user']=getuser();
		$regid=$data['user']['id'];
		$mobile=$data['user']['mobile'];
		$username=$this->input->post('username');
		$amount=$this->input->post('amount');
		$otp=rand(001213,999999);
		$this->session->set_userdata("transfer_otp",$otp);
		$message="$otp is your OTP to transfer Rs. $amount to $username. ASR Hub";
		$smsdata=array("mobile"=>$mobile,"message"=>$message);
		send_sms($smsdata);
	}
	
	public function resendotp(){
        $data['user']=getuser();
		$regid=$data['user']['id'];
		$mobile=$data['user']['mobile'];
		$username=$this->input->post('username');
		$amount=$this->input->post('amount');
		$otp=$this->session->transfer_otp;
		$this->session->set_userdata("transfer_otp",$otp);
		$message="$otp is your OTP to transfer Rs. $amount to $username. ASR Hub";
		$smsdata=array("mobile"=>$mobile,"message"=>$message);
		send_sms($smsdata);
	}
	
	public function exportpaymentreport(){
		$from=$this->input->get('from');
		$to=$this->input->get('to');
		$type=$this->input->get('type');
		$where=array();
		$date="all";
		if($from!='' && $to!=''){
			$where['t1.approve_date>=']=$from;
			$where['t1.approve_date<=']=$to;
			$date=date('d-m-Y',strtotime($from))."-to-".date('d-m-Y',strtotime($to));
		}elseif($from!='' && $to==''){
			$where['t1.approve_date=']=$from;
			$date=date('d-m-Y',strtotime($from));
		}
		elseif($from=='' && $to!=''){
			$where['t1.approve_date=']=$to;
			$date=date('d-m-Y',strtotime($to));
		}
		$members=$this->wallet->paymentreport($where);
		$skip=array();
		$colnames=array("Date","Member ID","Name","Account No","IFSC Code","Amount","TDS","Admin Charge","Payable");
		$filename="Payment-Report-".$date;
		if($type=='pay'){
			$filename="Payment-list-".$date;
			$colnames=array("Date","Member ID","Name","Account No","IFSC Code","Amount");
			$skip=array("amount","tds","admin_charge");
		}
		exporttoexcel($members,$filename,$colnames,$skip);
	}
	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
	}
    
    public function index(){
        loginredirect();
		$this->session->unset_userdata("username");
        $data['title']="Login";
        //$this->template->load('auth','login',$data,'auth');       
        $this->load->view('website/login',$data);       
    }
    
    public function forgotpassword(){
		$this->session->unset_userdata("username");
        $data['title']="Forgot Password";
        $this->template->load('auth','forgotpassword',$data,'auth');       
    }
    
    public function enterotp(){
		if($this->session->userdata('username')===NULL){redirect('login/');}
        $data['title']="Forgot Password";
        $this->template->load('auth','enterotp',$data,'auth');       
    }
    
    public function resetpassword(){
		if($this->session->username===NULL){redirect('login/');}
        $data['title']="Change Password";
        $this->template->load('auth','resetpassword',$data,'auth');    
    }
    
	public function logout(){
		if($this->session->user!==NULL){
			$data=array("user","name","username","role","project","sess_type");
			$this->session->unset_userdata($data);
		}	
		redirect('login/');
	}
	
	
	public function validatelogin(){
		$data=$this->input->post();
		unset($data['login']);
		$result=$this->account->login($data);
		if($result['status']===true){
            $user=$result['user'];
            if($user['role']=='admin' || $user['role']=='member'){
                $this->session->unset_userdata('sess_type');
                $this->startsession($user);
                loginredirect();
            }
            else{ 
                $this->set_flash('logerr',"Wrong Username or Password!");
                redirect('login/');
            }
		}
		else{ 
			$this->set_flash('logerr',$result['message']);
			redirect('login/');
		}
	}
	
	public function backtoadmin(){
        if($this->session->sess_type=='admin_access'){
            $getuser=$this->account->getuser(["id"=>1]);
            $user=$getuser['user'];
            $this->startsession($user);
            loginredirect();
        }
	}
	
	public function userlogin($username=NULL){
        if($username===NULL){
            redirect('home/');
        }
		if($this->session->role=='admin'){
            $getuser=$this->account->getuser(["md5(concat('username-',username))"=>$username]);
            if($getuser['status']===true){
                $user=$getuser['user'];
                $this->session->set_userdata('sess_type','admin_access');
                $this->startsession($user);
                loginredirect();
            }
            else{
                redirect('members/memberlist/');
            }
        }
        redirect('login/');
	}
	
	public function startsession($result){
		$data['user']=md5($result['id']);
		$data['name']=$result['name'];
		$data['username']=$result['username'];
		$data['role']=$result['role'];
		$data['project']=PROJECT_NAME;
		$this->session->set_userdata($data);
	}
	
	public function validateUser(){
		if($this->input->post('forgotpassword')!==NULL){
			$username=$this->input->post('username');
			$result=$this->account->createotp(array("username"=>$username));
			if($result['status']===true){
                $result=$result['result'];
				$otp=$result['otp'];
				$verification_msg="$otp is your One Time Password to Reset password . This OTP is valid for 15 minutes.";
				$smsdata=array("mobile"=>$result['mobile'],"message"=>$verification_msg);
				
				//send_sms($smsdata);
				
				$this->session->set_userdata("username",$username);
				redirect('enter-otp/'.$otp);
			}
			else{
				$this->set_flash("logerr","Username not valid!");
				redirect('forgot-password/');
			}
		}
		else{
			redirect('login/');
		}
	}
	
	public function validateOTP(){
		if($this->session->username===NULL){redirect('login/');}
		if($this->input->post('submitotp')!==NULL){
			$otp=$this->input->post('otp');
			$where['username']=$this->session->username;
			$result=$this->account->verifyotp($otp,$where);
			if($result['status']===true){
				redirect('reset-password/');
			}
			else{
				$this->set_flash("logerr",$result['message']);
				redirect('enter-otp/');
			}
		}
		redirect('login/');
	}
	
	public function skipreset(){
		if($this->session->username!==NULL){
			$username=$this->session->username;
			$this->session->unset_userdata("username");
			$result=$this->account->getuser(array("username"=>$username));
            if($result['user']['role']=='admin' || $result['user']['role']=='shop' || $result['user']['role']=='billing'){
                $this->startsession($result['user']);
                redirect('home/');
            }
		}
		redirect("admin/login/");
	}
	
	public function changepassword(){
		if($this->session->username!==NULL){
			$password=$this->input->post('password');
			$username=$this->session->userdata("username");
			$where['username']=$username;
			$result=$this->account->updatepassword(['password'=>$password],$where);
		}
		redirect('login/');
	}
}
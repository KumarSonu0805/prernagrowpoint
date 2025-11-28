<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
	public function __construct(){
		parent::__construct();
		checklogin();
	}
	
	public function index(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="My Profile";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$memberdetails=$this->member->getalldetails($regid);
		$data=array_merge($data,$memberdetails);
		
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$data['profile']=true;
		$this->template->load('profile','profile',$data);
	}
	
	public function accdetails(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Account Details";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$memberdetails=$this->member->getalldetails($regid);
		$data['sponsor']=$this->account->getuser(array("id"=>$memberdetails['member']['refid']));
		$data=array_merge($data,$memberdetails);
		
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		
		$this->template->load('profile','profile',$data);
	}
	
	public function adminaccdetails(){
		if($this->session->role!='admin'){ redirect('home/'); }
		$data['title']="Account Details";
		$data['breadcrumb']=array("home/"=>"Home");
        $getuser=$this->account->getuser(array("md5(id)"=>$this->session->userdata('user')));
        $data['user']=$getuser['user'];
		$regid=$data['user']['id'];
        
		$accdetails=$this->member->getaccdetails($regid);
        if(!empty($accdetails)){
            $data['acc_details']=$accdetails;
        }
		
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		
		$this->template->load('profile','profile',$data);
	}
	
	public function changepassword(){
		$data['title']="Change Password";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$details=$this->member->getmemberdetails($regid);
		//$data['user']['photo']=$details['photo'];
		$this->template->load('profile','changepassword',$data);
	}
	
	public function kyc(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="Upload KYC";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$data['acc_details']=$this->member->getaccdetails($regid);
		$this->template->load('profile','kyc',$data);
	}
	
	public function kycdocuments(){
		if($this->session->role=='admin'){ redirect('/'); }
		$data['title']="View Documents";
		$data['breadcrumb']=array("/"=>"Home","profile/"=>"My Profile");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$data['acc_details']=$this->member->getaccdetails($regid);
		$this->template->load('profile','documents',$data);
	}
	
	public function updatepassword(){
		if($this->input->post('updatepassword')!==NULL){
			$data=$this->input->post();
			$result=$this->member->updatepassword($data);
			if($result===true){
				$this->session->set_flashdata('msg',"Password Changed!");
			}
			else{
				$this->session->set_flashdata('err_msg',"Password Not Changed!");
			}
			redirect('profile/changepassword/');
		}
	}
	
	public function updatephoto(){
		if($this->input->post('updatephoto')!==NULL){
			$where['regid']=$this->input->post('regid');
			$upload_path="./assets/uploads/members/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$this->input->post('name');
			$upload=upload_file('photo',$upload_path,$allowed_types,$file_name.'_photo');
			if($upload['status']===true){
                $data['photo']=$upload['path'];
				$result=$this->member->updatephoto($data,$where);
				if($result===true){
					$this->session->set_flashdata("msg","Photo Updated successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
		}
		redirect('profile/');
	}
	

	public function updatepersonaldetails(){
		if($this->input->post('updatepersonaldetails')!==NULL){
			$data=$this->input->post();
            $regid=$data['regid'];
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatepersonaldetails']);
            $status=true;
            if(!empty($data['aadhar'])){
                $check=$this->db->get_where('members',['aadhar'=>$data['aadhar'],'regid!='=>$regid])->num_rows();
                if($check>=3){
                    $status=false;
                }
            }
            //print_pre($data,true);
            if($status){
                $result=$this->member->updatepersonaldetails($data,$where);
                if($result===true){
                    $this->session->set_flashdata("msg","Personal Details Updated successfully!");
                }
                else{
                    $this->session->set_flashdata("err_msg",$result['message']);
                }
			}
			else{
				$this->session->set_flashdata("err_msg","Aadhar Number already Linked with 3 ID!");
			}
		}
		redirect('profile/');
	}
	
	public function updatecontactinfo(){
		if($this->input->post('updatecontactinfo')!==NULL){
			$data=$this->input->post();
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatecontactinfo']);
			$result=$this->member->updatecontactinfo($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Contact Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('profile/');
	}
	
	public function updatenomineedetails(){
		if($this->input->post('updatenomineedetails')!==NULL){
			$data=$this->input->post();
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updatenomineedetails']);
			$result=$this->member->updatenomineedetails($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Nominee Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('profile/');
	}
	
	public function updateaccdetails(){
		if($this->input->post('updateaccdetails')!==NULL){
			$data=$this->input->post();
			$where['regid']=$data['regid'];
			unset($data['regid']);
			unset($data['updateaccdetails']);
			$result=$this->member->updateaccdetails($data,$where);
			if($result===true){
				$this->session->set_flashdata("msg","Bank Details Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function uploaddocs(){
		if($this->input->post('uploaddocuments')!==NULL){
			$where['regid']=$this->input->post('regid');
			$name=$this->input->post('name');
			$upload_path="./assets/uploads/documents/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$name;
			$upload=upload_file('pan',$upload_path,$allowed_types,$file_name.'_pan',10000);
			if($upload['status']===true){
                $data['pan']=$upload['path'];
            }
			$upload=upload_file('aadhar1',$upload_path,$allowed_types,$file_name.'_aadhar1',10000);
			if($upload['status']===true){
                $data['aadhar1']=$upload['path'];
            }
			$upload=upload_file('aadhar2',$upload_path,$allowed_types,$file_name.'_aadhar2',10000);
			if($upload['status']===true){
                $data['aadhar2']=$upload['path'];
            }
			$upload=upload_file('cheque',$upload_path,$allowed_types,$file_name.'_cheque',10000);
			if($upload['status']===true){
                $data['cheque']=$upload['path'];
            }
			foreach($data as $key=>$value){
				if(empty($value)){ unset($data[$key]); }
			}
			if(!empty($data)){
				$result=$this->member->updateaccdetails($data,$where);
				if($result===true){
					$this->session->set_flashdata("msg","Document successfully!");
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
		}
		redirect('profile/kyc/');
	}
	
}

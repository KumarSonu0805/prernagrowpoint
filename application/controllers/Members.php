<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends MY_Controller {
	var $epin_status=false; //false : No E-pin; 1 : E-pin Required; 2 : E-pin Not Required
	var $tree=false; //false : No Tree; auto : Auto Position; position : Select Position; pool : Auto pool
	var $acc_details=false; // Show account details in form
	var $reject_kyc=true;
	
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		if($this->session->user===NULL){
			$this->register();
		}else{
			$this->registration();
		}
	}
	
	public function registration(){
		checklogin();
		$data['title']="Member Registration";
		$data['breadcrumb']=array("/"=>"Home");
		$data['user']=getuser();
		$regid=$data['user']['id'];
		
		$data['parent_id']='';
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$data['epin_status']=$this->epin_status;
		$data['tree']=$this->tree;
		$data['acc_details']=$this->acc_details;
		$this->template->load("members","registration",$data);
	}
    	
	public function register(){
		$data['title']="Member Registration";
		$data['parent_id']='';
		$data['user']['username']='';
		$data['user']['id']='';
		$data['user']['name']='';
		$options=array(""=>"Select Bank","xyz"=>"Others");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$data['epin_status']=$this->epin_status;
		$data['tree']=$this->tree;
		$data['acc_details']=$this->acc_details;  
        $this->load->view('website/register',$data);   
	}
    
	public function registered(){
		if($this->session->flashdata('mname')===NULL){
			redirect('members/');
		}
        /*$name=$this->session->flashdata('mname');
        $uname=$this->session->flashdata('uname');
        $pass=$this->session->flashdata('pass');
        $flash=array("mname"=>$name,"uname"=>$uname,"pass"=>$pass);
        $this->session->set_flashdata($flash);*/
		$data['title']="Registration Details";
		if($this->session->userdata('user')!==NULL){
			$data['breadcrumb']=array("/"=>"Home");
			$this->template->load('members','registered',$data);
		}
		else{
            $this->load->view('website/registered',$data);   
		}
	}
	
	public function memberlist(){
		checklogin();
		$data['title']="Downline Member List";
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$members=$this->member->getmembers($regid);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
	
	public function leftmemberlist(){
		checklogin();
		$data['title']="Left Member List";
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$members=$this->member->getleftrightmembers($regid,'left');
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
	
	public function rightmemberlist(){
		checklogin();
		$data['title']="Right Member List";
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$members=$this->member->getleftrightmembers($regid,'right');
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
	
	public function downline(){
		checklogin();
		$data['title']="Downline Member List";
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$members=$this->member->getallmembers($regid);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
	
	public function editmember($regid=NULL){
		checklogin();
		if($this->session->role!='admin' || $regid===NULL){ redirect('members/downline/'); }
		$data['title']="Edit Member";
		$data['breadcrumb']=array("/"=>"Home",'members/downline/'=>"Downline Members");
		$details=$this->member->getalldetails($regid);
		
		$options=array(""=>"Select Bank");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
		$data['details']=$details;
		$this->template->load('members','editmember',$data);
	}
	
	public function mydirects(){
		checklogin();
		if($this->session->role=='admin'){
			redirect('members/downline/');
		}
		$data['title']="Direct Sponsors";
		$data['user']=getuser();
		$regid=$data['user']['id'];
		$members=$this->member->getdirectmembers($regid);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','memberlist',$data);
	}
		
	public function treeview(){
		checklogin();
		$data['title']="Tree View";
		$data['user']=getuser();
		$regid=$data['user']['id'];
        if($regid>1){
            $details=$this->member->getmemberdetails($regid);
            $data['user']['photo']=$details['photo'];
        }
        else{
            $data['user']['photo']=file_url("assets/images/male.png");
        }
        $this->load->helper('tree');
		$regids=generateTree($data['user']['id']);
		$data['packages']=$this->db->get_where('packages',array("status"=>1))->result_array();
        $data['packages'][]=array('id'=>0,'package'=>'Free Group');
		$data['tree']=createTree($regids);
		$this->template->load('members','tree',$data);
	}
	
	public function kyc(){
        if($this->session->role!='admin'){
            redirect('/');
        }
		checklogin();
		$data['title']="Member KYC Requests";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->member->kyclist();
		$data['members']=$members;
		$data['datatable']=true;
		$data['reject_kyc']=$this->reject_kyc;
		$this->template->load('members','kyclist',$data);
	}
	
	public function approvedkyc(){
        if($this->session->role!='admin'){
            redirect('/');
        }
		checklogin();
		$data['title']="Approved Member KYC";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->member->kyclist(1);
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','kyclist',$data);
	}
	
	public function activationrequests(){
		if($this->session->role!='admin'){ redirect('home/'); }
		$data['title']="Activation Request List";
		$today=date('Y-m-d');
		$where=array("t1.type"=>"activation","t1.status"=>0);
		$members=$this->deposit->getdepositlistrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$data['datatableexport']=true;
		$this->template->load('deposits','depositlist',$data);
	}
	
	public function approvedactivations(){
		if($this->session->role!='admin'){ redirect('home/'); }
		$data['title']="Approved Activation List";
		$today=date('Y-m-d');
		$where=array("t1.type"=>"activation","t1.status"=>1);
		$members=$this->deposit->getdepositlistrequest($where);
		$data['members']=$members;
		$data['datatable']=true;
		$data['datatableexport']=true;
		$this->template->load('deposits','approvedlist',$data);
	}
	
	public function addmember(){
		if($this->input->post('addmember')!==NULL){
			$data=$this->input->post();
			$userdata=$memberdata=$accountdata=$treedata=array();
			if($data['refid']>0){
				$userdata['mobile']=$data['mobile'];
				$userdata['name']=$data['name'];
				$userdata['email']=$data['email'];
				$userdata['role']="member";
				$userdata['status']="1";
				
				if(isset($data['epin'])){
					$memberdata['epin']=$data['epin'];
				}
				$memberdata['name']=$data['name'];
				$memberdata['dob']=$data['dob'];
				$memberdata['father']=$data['father'];
				$memberdata['gender']=$data['gender'];
				$memberdata['mstatus']=$data['mstatus'];
				$memberdata['mobile']=$data['mobile'];
				$memberdata['email']=$data['email'];
				$memberdata['aadhar']=$data['aadhar'];
				$memberdata['pan']=$data['pan'];
				$memberdata['address']=$data['address'];
				$memberdata['district']=$data['district'];
				$memberdata['state']=$data['state'];
				$memberdata['pincode']=$data['pincode'];
				$memberdata['refid']=$data['refid'];
				$memberdata['date']=$data['date'];
				$memberdata['time']=date('H:i:s');
				$memberdata['status']=0;
				
				$upload_path="./assets/uploads/members/";
				$allowed_types="jpg|jpeg|png";
				$file_name=$data['name'];
				$upload=upload_file('photo',$upload_path,$allowed_types,$file_name.'_photo');
				if($upload['status']===true){
                    $memberdata['photo']=$upload['path'];
                }
				$accountdata['bank']=$data['bank'];
				$accountdata['branch']=$data['branch'];
				$accountdata['city']=$data['city'];
				$accountdata['account_no']=$data['account_no'];
				$accountdata['account_name']=$data['account_name'];
				$accountdata['ifsc']=$data['ifsc'];
				
				if($this->tree=='position'){
					$treedata['parent_id']=$this->member->findleaf($data['refid'],$data['position']);
					$treedata['position']=$data['position'];
				}
				else{
					$treedata=$this->tree;
				}
				$data=array("userdata"=>$userdata,"memberdata"=>$memberdata,"accountdata"=>$accountdata,"treedata"=>$treedata);
				$result=$this->member->addmember($data);
				if($result['status']===true){
					$message = "Welcome $memberdata[name]! Thank you for joining ".PROJECT_NAME."! Your Username is $result[username] and Password is $result[password]. ";
					$message.= "Visit our site ".str_replace('members.','',base_url()).".";
					$smsdata=array("mobile"=>$memberdata['mobile'],"message"=>$message);
					//send_sms($smsdata);
					$flash=array("mname"=>$memberdata['name'],"uname"=>$result['username'],"pass"=>$result['password']);
					$this->session->set_flashdata($flash);
					$this->session->set_flashdata("msg","Member Added successfully!");
					redirect('registered/');
				}
				else{
					$this->session->set_flashdata("err_msg",$result['message']);
				}
			}
			else{
				$this->session->set_flashdata("err_msg","Invalid Sponsor ID!");
			}
		}
		redirect('members/');
	}
	
	public function updatemember(){
		if($this->input->post('updatemember')!==NULL){
			$data=$this->input->post();
			$regid=$data['regid'];
			$userdata=$memberdata=$accountdata=$treedata=array();
			
			if(isset($data['name'])){
				$userdata['mobile']=$data['mobile'];
				$userdata['name']=$data['name'];
				$userdata['email']=$data['email'];
				
				$memberdata['name']=$data['name'];
				$memberdata['dob']=$data['dob'];
				$memberdata['father']=$data['father'];
				$memberdata['gender']=$data['gender'];
				$memberdata['mstatus']=$data['mstatus'];
				$memberdata['mobile']=$data['mobile'];
				$memberdata['email']=$data['email'];
				$memberdata['aadhar']=$data['aadhar'];
				$memberdata['pan']=$data['pan'];
				$memberdata['address']=$data['address'];
				$memberdata['district']=$data['district'];
				$memberdata['state']=$data['state'];
				$memberdata['country']=$data['country'];
				$memberdata['pincode']=$data['pincode'];
			}
			if(isset($data['bank'])){
				$accountdata['bank']=$data['bank'];
				$accountdata['branch']=$data['branch'];
				$accountdata['city']=$data['city'];
				$accountdata['account_no']=$data['account_no'];
				$accountdata['account_name']=$data['account_name'];
				$accountdata['ifsc']=$data['ifsc'];
			}
			$data=array("userdata"=>$userdata,"memberdata"=>$memberdata,"accountdata"=>$accountdata);
			
			
			$result=$this->member->updatemember($data,$regid);
			if($result===true){
				$this->session->set_flashdata("msg","Member Updated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg","Member Not Updated!");
			}
		}
		redirect('members/downline/');
	}
		
	public function updatedocs(){
		if($this->input->post('updatedocs')!==NULL){
			$where['regid']=$this->input->post('regid');
			$name=$this->input->post('name');
			$upload_path="./assets/uploads/documents/";
			$allowed_types="jpg|jpeg|png";
			$file_name=$name;
			$data['pan']=upload_file('pan',$upload_path,$allowed_types,$file_name.'_pan',10000);
			$data['aadhar1']=upload_file('aadhar1',$upload_path,$allowed_types,$file_name.'_aadhar1',10000);
			$data['aadhar2']=upload_file('aadhar2',$upload_path,$allowed_types,$file_name.'_aadhar2',10000);
			$data['cheque']=upload_file('cheque',$upload_path,$allowed_types,$file_name.'_cheque',10000);
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
		redirect('members/downline/');
	}
    
	public function activatemember(){
		if($this->input->post('activatemember')!==NULL){
			$data=$this->input->post();
			unset($data['activatemember']);
			$result=$this->member->activatemember($data);
			if($result===true){
				$memberdata=$this->account->getuser(array("id"=>$data['regid']));
				$message="Hi $memberdata[name]! Your ID has been successfully activated! ";
				$message.= "Visit our site ".str_replace('members.','',base_url()).".";
				$smsdata=array("mobile"=>$memberdata['mobile'],"message"=>$message);
				send_sms($smsdata);
				$this->session->set_flashdata("msg","Member Activated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('epins/unused/');
	}
	
	public function groupactivation(){
        $id=$this->input->get('id');
        $getuser=$this->account->getuser(["md5(concat('regid-',id))"=>$id]);
        //print_pre($getuser,true);
		if($getuser['status']===true){
            $user=$getuser['user'];
            $data=array('regid'=>$user['id'],'package_id'=>0);
			//unset($data['activatemember']);
			$result=$this->member->activatemember($data);
			if($result===true){
				$memberdata=$this->account->getuser(array("id"=>$data['regid']));
				$message="Hi $memberdata[name]! Your ID has been successfully activated! ";
				$message.= "Visit our site ".str_replace('members.','',base_url()).".";
				$smsdata=array("mobile"=>$memberdata['mobile'],"message"=>$message);
				//send_sms($smsdata);
				$this->session->set_flashdata("msg","Group Activated successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function approvekyc(){
		if($this->input->post('kyc')!==NULL){
			$data['kyc']=$this->input->post('kyc');
			$where['regid']=$this->input->post('regid');
			$result=$this->member->approvekyc($data,$where);
			if($result===true){
				if($data['kyc']==3){ $status="Rejected"; }
				elseif($data['kyc']==1){ $status="Approved"; }
				$this->session->set_flashdata("msg","Member KYC $status!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/kyc/');
	}
	
	public function getrefid(){
		$username=$this->input->post('username');
		$status=$this->input->post('status');
        if($this->session->role=='admin' && $username=='admin'){
            $member=array('name'=>'Admin','regid'=>1);
        }
        else{
		  $member=$this->member->getmemberid($username,$status);
        }
		echo json_encode($member);
	}
	
	public function getpopupdetails(){
		$regid=$this->input->post('regid');
		$array=$this->member->getpopupdetails($regid);
		echo json_encode($array);
	}
	
	public function gettree(){
		$regid=$this->input->post('regid');
		if((int)$regid==0){
			$where['username']=str_replace('a','',$regid);
			$getuser=$this->account->getuser($where);
            if($getuser['status']===true){
                $array=$getuser['user'];
                $regid=$array['id'];
                $data['user']=getuser();
                $user_id=$data['user']['id'];
                $members=$this->member->getallmembers($user_id,array(),"array");
                if(array_search($regid,$members)===false){
                    $regid='';
                }
            }
            else{
                $regid='';
            }
		}
		if($regid!=''){
            $this->load->helper('tree');
			$regids=generateTree($regid);
			$tree=createTree($regids);
			echo $tree;
		}
		else{
			echo "invalid";
		}
	}
	
	public function getmemberid(){
		$username=$this->input->post('username');
		$status=$this->input->post('status');
		$member=$this->member->getmemberid($username,$status);
		echo json_encode($member);
	}
	
    public function entertomember(){
        if($this->session->role!='admin'){ redirect('/'); }
        $data=['title'=>'Enter To Member'];
        $this->template->load('members','entertomember',$data);
    }
    
    public function memberdashboard(){
        if($this->session->role!='admin'){ redirect('/'); }
        $data=$this->input->post();
        $member=$this->member->getmemberid($data['member_id'],'all');
        if($member['regid']==0){
            $this->session->set_flashdata('err_msg',$member['name']);
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $username=md5('username-'.$data['member_id']);
            redirect('login/userlogin/'.$username);
        }
    }
	/*public function upgrade(){
		checklogin();
		if($this->session->role=='admin'){
			redirect('members/downline/');
		}
		$data['title']="Upgrade";
		$data['user']=getuser();
		$regid=$data['user']['id'];
        $memberdetails=$this->member->getmemberdetails($regid);
        if($memberdetails['upgrade']==1){
			redirect('/');
            
        }
		$options=array(""=>"Select Bank");
		$banks=$this->member->getbanks();
		if(is_array($banks)){
			foreach($banks as $bank){
				$options[$bank['name']]=$bank['name'];
			}
		}
		$data['banks']=$options;
        $data['upgrade']=$this->member->getupgraderequests(array("regid"=>$regid),"single");
		$this->template->load('members','request',$data);
	}
	
	public function upgraderequests(){
		if($this->session->role!='admin'){ redirect('/'); }
		$data['title']="Upgrade Request List";
		$data['breadcrumb']=array("/"=>"Home");
		$members=$this->member->getupgraderequests(array("t1.status"=>"0"));
		$data['members']=$members;
		$data['datatable']=true;
		$this->template->load('members','requestlist',$data);
	}
	
    public function requestupgrade(){
		if($this->input->post('requestupgrade')!==NULL){
			$data=$this->input->post();
			unset($data['requestupgrade'],$data['paid_amount']);
			$result=$this->member->requestupgrade($data);
			if($result===true){
				$this->session->set_flashdata("msg","Upgrade Request Saved successfully!");
			}
			else{
				$this->session->set_flashdata("err_msg",$result['message']);
			}
		}
		redirect('members/upgrade/');
    }
    
	public function approveupgrade(){
        $request_id=$this->input->post('request_id');
        $result=$this->member->approveupgrade($request_id);
        if($result===true){
            $this->session->set_flashdata("msg","Member Upgraded successfully!");
        }
        else{
            $this->session->set_flashdata("err_msg",$result['message']);
        }
    }
    */
		
}

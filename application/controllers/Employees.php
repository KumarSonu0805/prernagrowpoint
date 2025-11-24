<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
        checklogin();
	}
	
	public function index(){
        $data['title']="Add Employee";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $states=$this->master->getstates();
        $options=array(""=>"Select State");
        if(is_array($states)){
            foreach($states as $state){
                $options[$state['id']]=$state['name'];
            }
        }
        $data['states']=$options;
        $data['datatable']=true;
		$this->template->load('employees','add',$data);
	}
	
	public function employeelist(){
        $data['title']="Employee List";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $data['employees']=$this->employee->getemployees(['t1.status'=>1]);
		$this->template->load('employees','list',$data);
	}
    
	public function editemployee($id=NULL){
        if($id===NULL){
            redirect('employees/employeelist/');
        }
        $data['title']="Edit Employee";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $employee=$this->employee->getemployees(array("md5(t1.id)"=>$id,'t1.status'=>1),"single");
        if(empty($employee) || !is_array($employee)){
            redirect('employees/employeelist/');
        }
        $data['employee']=$employee;
        
		$this->template->load('employees','edit',$data);
	}
    
	public function trackemployee($user_id=NULL){
        $data['title']="Track Employee";
        if($user_id!==NULL){
            $employee=$this->employee->getemployees(array("md5(t1.user_id)"=>$user_id,'t1.status'=>1),"single");
        }
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        if($user_id===NULL || empty($employee)){
            $data['datatable']=true;
            $data['employees']=$this->attendance->getactiveemployees();
            $this->template->load('employees','activelist',$data);
        }
        else{
            $data['employee']=$employee;
            $where=array("date(added_on)"=>date('Y-m-d'),"user_id"=>$employee['user_id']);
            $data['locations']=$this->attendance->getcurrentlocation($where);
            $this->template->load('employees','trackemployee',$data);
        }
	}
    
    public function assignbeat(){
        $data['title']="Assign Beat";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['tabulator']=true;
		$this->template->load('employees','assignbeat',$data);
	}
    
    public function assignedbeats(){
        if($this->input->get('type')===NULL){
            $data['title']="Assigned Beat";
            //$data['subtitle']="Sample Subtitle";
            $data['breadcrumb']=array();
            $data['tabulator']=true;
            $this->template->load('employees','assignedbeats',$data);
        }
        else{
            $where=array();
            $beats=$this->employee->getassignedbeats($where);
            echo json_encode($beats);
        }
	}
    
    public function addemployee(){
        if($this->input->post('addemployee')!==NULL){
            $data=$this->input->post();
            unset($data['addemployee']);
            if(empty($data['dob']) || $data['dob']=='0000-00-00'){
                $data['dob']=NULL;
            }
            if(empty($data['date_of_join']) || $data['date_of_join']=='0000-00-00'){
                $data['date_of_join']=NULL;
            }
            $upload_path='./assets/images/employees/';
            $allowed_types='gif|jpg|jpeg|png|svg';
            $upload=upload_file('photo',$upload_path,$allowed_types,$data['name'].'-photo');
            if($upload['status']===true){
                $data['photo']=$upload['path'];
            }
            else{ $data['photo']=''; }
            //print_pre($data,true);
            $result=$this->employee->addemployee($data);
            if($result['status']===true){
                $this->set_flash("msg",$result['message']);
            }
            else{
                $this->set_flash("err_msg",$result['message']);
            }
        }
        redirect('employees/');
    }
    
    public function updateemployee(){
        if($this->input->post('updateemployee')!==NULL){
            $data=$this->input->post();
            unset($data['updateemployee']);
            if(empty($data['dob']) || $data['dob']=='0000-00-00'){
                $data['dob']=NULL;
            }
            if(empty($data['date_of_join']) || $data['date_of_join']=='0000-00-00'){
                $data['date_of_join']=NULL;
            }
            $upload_path='./assets/images/employees/';
            $allowed_types='gif|jpg|jpeg|png|svg';
            $upload=upload_file('photo',$upload_path,$allowed_types,$data['name'].'-photo');
            if($upload['status']===true){
                $data['photo']=$upload['path'];
            }
            $result=$this->employee->updateemployee($data);
            if($result['status']===true){
                $this->set_flash("msg",$result['message']);
            }
            else{
                $this->set_flash("err_msg",$result['message']);
            }
        }
        redirect('employees/employeelist/');
    }
    
    public function savebeatassignment(){
        if($this->input->post('savebeatassignment')!==NULL){
            $emp_id=$this->input->post('emp_id');
            $beat_ids=$this->input->post('beat_id');
            $data=array();
            if(!empty($beat_ids)){
                foreach($beat_ids as $beat_id){
                    $data=array('emp_id'=>$emp_id,'beat_id'=>$beat_id);
                    $result=$this->employee->savebeatassignment($data);
                    if($result['status']===true){
                        $this->set_flash("msg",$result['message']);
                    }
                    else{
                        $this->set_flash("err_msg",$result['message']);
                    }
                }
            }
            else{
                $this->set_flash("err_msg","Please Select Beat!");
            }
        }
        redirect('employees/assignbeat/');
    }
    
}
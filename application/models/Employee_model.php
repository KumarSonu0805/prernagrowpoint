<?php
class Employee_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
    public function addemployee($data){
        $mobile =$data['mobile'];
        $this->db->where(array('mobile'=>$mobile));
        $query=$this->db->get('employees');
        if($query->num_rows() ==0){
            $insert=$this->db->insert('employees',$data);
            if($insert){
                $e_id=$this->db->insert_id();
                $userdata=array("username"=>$data['mobile'],'password'=>random_string('numeric'),'role'=>'dso',
                                'name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'e_id'=>$e_id,
                                'status'=>1);
                $this->account->adduser($userdata);
                return array("status"=>true,"message"=>"Employee Added Successfully!");
            }else{
                $err=$this->db->error();
                return array("status"=>false,"message"=>$err['message']);
            }
        }else{
            return array("status"=>false,"message"=>"Employee Already Added!");
        }

    }
    
    public function getemployees($where=array(),$type="all",$orderby="t1.id"){
        $default=file_url('assets/images/default.jpg');
        $columns="t1.*, t2.username,t2.vp as password, case when t1.photo='' then '$default' else concat('".file_url()."',t1.photo) end as photo";
        $this->db->select($columns);
        $this->db->from("employees t1");
        $this->db->join("users t2","t1.user_id=t2.id","left");
        $this->db->where($where);
        $this->db->order_by($orderby);
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function updateemployee($data){
        $id=$data['id'];
        unset($data['id']);
        $where=array("id"=>$id);
        if($this->db->get_where('employees',array('mobile'=>$data['mobile'],"id!="=>$id))->num_rows()==0){
            if($this->db->update("employees",$data,$where)){
                if(isset($data['photo']) && $data['photo']!=''){
                    $employee=$this->db->get_where('employees',array("id"=>$id))->unbuffered_row('array');
                    if($employee['user_id']!==NULL){
                        $this->db->update("users",['photo'=>$data['photo']],['id'=>$employee['user_id']]);
                    }
                }
                $message="Employees Updated Successfully!";
                $user_id=$this->db->get_where("employees",$where)->unbuffered_row()->user_id;
                if(isset($data['status']) && $data['status']==0 ){
                    $this->db->update("users",['status'=>0],['id'=>$user_id]);
                    $message="Employees Delete Successfully!";
                }
                return array("status"=>true,"message"=>$message,"message2"=>$result['message']);
            }
            else{
                $error=$this->db->error();
                return array("status"=>false,"message"=>$error['message']);
            }
        }
        else{
            return array("status"=>false,"message"=>"Employee Mobile No. Already Added!");
        }
    }
    
    public function savebeatassignment($data){
        $this->db->where(array('beat_id'=>$data['beat_id']));
        $query=$this->db->get('beat_assigned');
        if($query->num_rows()==0){
            $data['added_on']=$data['updated_on']=date('Y-m-d H:i:s');
            $insert=$this->db->insert('beat_assigned',$data);
            if($insert){
                return array("status"=>true,"message"=>"Beat Assigned Successfully!");
            }else{
                $err=$this->db->error();
                return array("status"=>false,"message"=>$err['message']);
            }
        }
        else{
            $emp_id=$query->unbuffered_row()->emp_id;
            if($data['emp_id']==$emp_id){
                $message="This Beat is Already Assigned to this DSO!";
            }
            else{
                $message="This Beat is Already Assigned to different DSO!";
            }
            return array("status"=>false,"message"=>$message);
        }
    }
    
    public function getassignedbeats($where=array(),$type="all",$order_by="a.id",$columns=false){
        if($columns===false){
            $columns="t1.*,t2.name as state_name,t3.name as district_name,t4.name as area_name,t5.name as emp_name";
        }
        $this->db->select($columns);
        $this->db->where($where);
        $this->db->order_by($order_by);
        $this->db->from('beat_assigned a');
        $this->db->join('beats t1','a.beat_id=t1.id');
        $this->db->join('states t2','t1.state_id=t2.id');
        $this->db->join('districts t3','t1.district_id=t3.id');
        $this->db->join('areas t4','t1.area_id=t4.id');
        $this->db->join('employees t5','a.emp_id=t5.id');
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
}
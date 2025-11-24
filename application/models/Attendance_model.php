<?php
class Attendance_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
    public function saveattendance($data){
        $where=array("user_id"=>$data['user_id'],"date"=>$data['date'],"type"=>$data['type']);
        if($this->db->get_where("attendance",$where)->num_rows()==0){
            if($this->db->insert("attendance",$data)){
                return array("status"=>true,"message"=>"Attendance Done!");
            }
            else{
                $error=$this->db->error();
                return array("status"=>false,"message"=>$error['message']);
            }
        }
        else{
            return array("status"=>false,"message"=>"Attendance Already Done!");
        }
    }
    
    public function checkattendance($user_id){
        $date=date('Y-m-d');
        $where=array("user_id"=>$user_id,"date"=>$date);
        $getattendance=$this->db->get_where("attendance",$where);
        $countattendance=$getattendance->num_rows();
        if($countattendance>0){
            if($countattendance==1){
                return array("status"=>true,"message"=>"Start Tracking!",'count'=>$countattendance);
            }
            elseif($countattendance==2){
                return array("status"=>false,"message"=>"Stop Tracking!",'count'=>$countattendance);
            }
            else{
                return array("status"=>false,"message"=>"Cannot Track!",'count'=>$countattendance);
            }
        }
        else{
            return array("status"=>false,"message"=>"Attendance not Done!",'count'=>$countattendance);
        }
    }
    
    public function getattendance($where=array(),$type="all"){
        $columns="t1.*,t2.id as emp_id, t2.name, t2.mobile, t2.email";
        $this->db->select($columns);
        $this->db->from("attendance t1");
        $this->db->join("employees t2","t1.user_id=t2.user_id","left");
        $this->db->where($where);
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function savecurrentlocation($data){
        $where=$data;
        /*$result=$this->checkattendance($data['user_id']);
        if($result['status']===false && $result['message']=="Attendance not Done!"){
            $adata=$data;
            $adata['date']=date('Y-m-d');
            $adata['type']='In';
            $adata['attendance']=1;
            $adata['added_on']=$adata['updated_on']=date('Y-m-d H:i:s');
            $this->saveattendance($adata);
        }*/
        $data['added_on']=date('Y-m-d H:i:s');
        $this->db->update("current_locations",["status"=>0],["user_id"=>$data['user_id'],"date(added_on)"=>date('Y-m-d')]);
        if($this->db->insert("current_locations",$data)){
            return array("status"=>true,"message"=>"Location Saved!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getcurrentlocation($where){
        $this->db->where($where);
        $array=$this->db->get('current_locations')->result_array();
        return $array;
    }
    
    public function getactiveemployees($date=NULL){
        $where=array("t2.date"=>date('Y-m-d'));
        if(!empty($date)){
            $where=array("t2.date"=>$date);
        }
        $columns="t1.*";
        $this->db->select($columns);
        $this->db->from("employees t1");
        $this->db->join("attendance t2","t1.user_id=t2.user_id and t2.type='In'","left");
        $this->db->where($where);
        $query=$this->db->get();
        $array=$query->result_array();
        return $array;
    }
    
    public function getemployeelocations(){
        $employees=$this->getactiveemployees();
        $result=array();
        if(!empty($employees)){
            foreach($employees as $key=>$employee){
                $where=array("user_id"=>$employee['user_id'],"type"=>"Out","date"=>date('Y-m-d'));
                $check=$this->db->get_where("attendance",$where)->num_rows();
                if($check==0){
                    $where=["user_id"=>$employee['user_id'],"status"=>1,"date(added_on)"=>date('Y-m-d')];
                    $current_location=$this->db->get_where("current_locations",$where)->unbuffered_row('array');
                    //print_r($current_location);
                    if(!empty($current_location)){
                        $location=[$employee['name'],($current_location['latitude']/1),($current_location['longitude']/1)];
                        $location[]=file_url('assets/images/delivery-bike.svg');
                        $employee['location']=$location;
                        $result[]=$employee;
                    }
                }
            }
        }
        return $result;
    }
    
    public function getattendancemonths($emp_id){
        $employee=$this->db->get_where("employees",array("id"=>$emp_id))->unbuffered_row('array');
        $user_id=$employee['user_id'];
        $array=array();
        if($user_id!==NULL){
            $this->db->select("date");
            $where=array("user_id"=>$user_id);
            $group="year(date),month(date)";
            $this->db->group_by($group);
            $query=$this->db->get_where("attendance",$where);
            $array=$query->result_array();
            if(!empty($array)){
                foreach($array as $key=>$value){
                    $year=date('Y',strtotime($value['date']));
                    $month=date('m',strtotime($value['date']));
                    $where2="emp_id='$emp_id' and year(pay_month)='$year' and month(pay_month)='$month'";
                    if($this->db->get_where("salary_payment",$where2)->num_rows()!=0){
                        unset($array[$key]);
                    }
                }
            }
        }
        else{
            $this->db->order_by("id desc");
            $getprevsalary=$this->db->get_where("salary_payment","emp_id='$emp_id'");
            if($getprevsalary->num_rows()!=0){
                $start_date=$getprevsalary->unbuffered_row()->pay_month;
            }
            else{
                $start_date=$employee['date_of_join'];
            }
            $end_date=date('Y-m-t');
            while($start_date<=$end_date){
                $year=date('Y',strtotime($start_date));
                $month=date('m',strtotime($start_date));
                $where2="emp_id='$emp_id' and year(pay_month)='$year' and month(pay_month)='$month'";
                if($this->db->get_where("salary_payment",$where2)->num_rows()==0){
                    $array[]['date']=$start_date;
                }
                $start_date=date('Y-m-d',strtotime($start_date." next month"));
            }
        }
        return $array;
    }
    
    public function getattendanceemployees($where=array(),$type="all"){
        $columns="t1.*, t2.name, t2.mobile, t2.email";
        $this->db->select($columns);
        $this->db->from("attendance t1");
        $this->db->join("employees t2","t1.user_id=t2.user_id","left");
        $this->db->where($where);
        $this->db->group_by("t1.user_id");
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

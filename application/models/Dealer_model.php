<?php
class Dealer_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
    
    public function adddealer($data){
        if($this->db->insert("dealers",$data)){
            return array("status"=>true,"message"=>"Dealer Added Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getdealers($where=array(),$type="all",$orderby="t1.id"){
        $default=file_url('assets/images/default.jpg');
        $columns="t1.*, t2.username,t2.vp as password, 
                    case when t1.shop_photo='' then '$default' else concat('".file_url()."',t1.shop_photo) end as shop_photo,
                    case when t1.photo='' then '$default' else concat('".file_url()."',t1.photo) end as photo,
                    t2.status as user_status,t3.name as added_by,t4.name as state_name,t5.name as district_name,
                    t6.name as area_name,t7.name as beat_name";
        $this->db->select($columns);
        $this->db->from("dealers t1");
        $this->db->join("users t2","t1.user_id=t2.id");
        $this->db->join("users t3","t1.emp_user_id=t3.id");
        $this->db->join("states t4","t1.state_id=t4.id");
        $this->db->join("districts t5","t1.district_id=t5.id");
        $this->db->join("areas t6","t1.area_id=t6.id");
        $this->db->join("beats t7","t1.beat_id=t7.id");
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
    
    public function updatedealer($data){
        $id=$data['id'];
        unset($data['id']);
        $where=array("id"=>$id);
        if($this->db->get_where('dealers',array('name'=>$data['name'],"id!="=>$id))->num_rows()==0){
            if($this->db->update("dealers",$data,$where)){
                $message="Dealer Updated Successfully!";
                $user_id=$this->db->get_where("dealers",$where)->unbuffered_row()->user_id;
                if(isset($data['status']) && $data['status']==0 ){
                    $this->db->update("users",['status'=>0],['id'=>$user_id]);
                    $message="Dealer Delete Successfully!";
                }
                return array("status"=>true,"message"=>$message);
            }
            else{
                $error=$this->db->error();
                return array("status"=>false,"message"=>$error['message']);
            }
        }
        else{
            return array("status"=>false,"message"=>"Dealer Already Added!");
        }
    }
    
    public function savedealerimage($data){
        if($data['type']=='monthly'){
            $this->db->update('gallery',['status'=>0],['type'=>'monthly']);
        }
        $data['added_on']=$data['updated_on']=date('Y-m-d H:i:s');
        if($this->db->insert("gallery",$data)){
            $text=($data['type']=='monthly'?'Monthly ':'').'Image';
            return array("status"=>true,"message"=>"Dealer $text Added Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getdealerimages($where=array(),$type="all",$orderby="t1.id"){
        $default=file_url('assets/images/default.jpg');
        $columns="t1.*, t2.username,t2.vp as password, 
                    case when t1.shop_photo='' then '$default' else concat('".file_url()."',t1.shop_photo) end as shop_photo,
                    case when t1.photo='' then '$default' else concat('".file_url()."',t1.photo) end as photo,
                    t2.status as user_status,t3.name as added_by,t4.name as state_name,t5.name as district_name,
                    t6.name as area_name,t7.name as beat_name";
        //$this->db->select($columns);
        $this->db->from("gallery t1");
        $this->db->join("dealers t2","t1.user_id=t2.user_id");
        $this->db->join("users t3","t2.user_id=t3.id");
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
    
    public function savevisitreport($data){
        $data['status']=1;
        $datetime=date('Y-m-d H:i:s');
        $data['added_on']=$data['updated_on']=$datetime;
        if($this->db->insert("visit_report",$data)){
            return array("status"=>true,"message"=>"Dealer Visit Report Saved Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getvisitreports($where=array(),$type="all"){
        $this->db->where($where);
        $this->db->from("visit_report");
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }

    public function saveaddress($data){
        $data['state']=$this->db->get_where("area",array("id"=>$data['parent_id']))->unbuffered_row()->name;
        $data['district']=$this->db->get_where("area",array("id"=>$data['area_id']))->unbuffered_row()->name;
        if($this->db->insert("addressbook",$data)){
            return array("status"=>true,"message"=>"Address Added Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getaddresses($where=array()){
        $address=array();
        $columns="999999 as `id`,'Shop' as type,`name`, `mobile`, `email`, `address`,`area_id`, `state`, `district`, `pincode`, 
                    `latitude`, `longitude`";
        $this->db->select($columns);
        $this->db->from("dealers");
        $this->db->where($where);
        $query=$this->db->get();
        $array=$query->unbuffered_row('array');
        $address[]=$array;
        
        $columns="`id`, `type`,`name`, `mobile`, '' as `email`, `address`,`area_id`, `state`, `district`, `pincode`, `latitude`, `longitude`";
        $this->db->select($columns);
        $query=$this->db->get_where("addressbook",$where);
        if($query->num_rows()>0){
            $addresses=$query->result_array();
            $address=array_merge($address,$addresses);
        }
        return $address;
    }
    
    public function saveremarks($data){
        if($this->db->insert("remarks",$data)){
            return array("status"=>true,"message"=>"Remarks Saved Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getremarks($where=array(),$type="all"){
        $columns="t1.*,t2.name,t2.mobile,t2.email,t2.`address`, t2.`area_id`, t2.`state`, t2.`district`, t2.`pincode`,";
        $this->db->select($columns);
        $this->db->where($where);
        $this->db->from("remarks t1");
        $this->db->join("dealers t2","t1.user_id=t2.user_id");
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function saveenquiry($data){
        if($this->db->insert("enquiry",$data)){
            return array("status"=>true,"message"=>"Enquiry Saved Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getenquiry($where=array(),$type="all"){
        $this->db->where($where);
        $this->db->from("enquiry");
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function getfollowups($user_id){
        $columns="t1.id,t1.date,t2.name,t2.mobile,t2.email,t1.remarks,t1.user_id,t1.emp_user_id,t1.followup_date";
        $this->db->select($columns);
        $where=['t1.emp_user_id'=>$user_id,'t1.followup_date'=>date('Y-m-d'),'t1.status'=>0];
        $this->db->where($where);
        $this->db->from("remarks t1");
        $this->db->join("dealers t2","t1.user_id=t2.user_id");
        $query=$this->db->get();
        $followups=$query->result_array();
        
        $columns="id,date,name,mobile,email,remarks,NULL as user_id,emp_user_id,followup_date";
        $this->db->select($columns,false);
        $where=['emp_user_id'=>$user_id,'followup_date'=>date('Y-m-d')];
        $this->db->where($where);
        $this->db->from("enquiry");
        $query=$this->db->get();
        //return $this->db->last_query();
        $array=$query->result_array();
        $followups=array_merge($followups,$array);
        return $followups;
    }
    
    public function getdealertimeline($dealer){
        $ocolumns="'order' as type,date,id as order_id,order_no,total_amount,paid_amount,(total_amount-paid_amount) as due_amount,
                    NULL as remarks, added_on,emp_user_id";
        $rcolumns="'remarks' as type,date,NULL as order_id,NULL as order_no,NULL as total_amount,NULL as paid_amount,NULL as  due_amount,
                    remarks,added_on,emp_user_id";
        $pcolumns="'payment' as type,date,order_id,NULL as order_no,amount as total_amount,NULL as paid_amount,NULL as  due_amount, 
                    details as remarks,added_on,emp_user_id";
        $sql="Select $ocolumns from ".TP."orders where user_id='$dealer[user_id]' ";
        $sql.="UNION Select $rcolumns from ".TP."remarks where user_id='$dealer[user_id]' ";
        $sql.="UNION Select $pcolumns from ".TP."payment where user_id='$dealer[user_id]' and order_id is NULL ";
        $sql.="order by added_on desc";
        $query=$this->db->query($sql);
        
        $array=$query->result_array();
        
        if(!empty($array)){
            foreach($array as $key=>$value){
                if($value['type']=='payment' && $value['order_id']!==NULL){
                    $array[$key]['order_no']=$this->db->get_where("orders",['id'=>$value['order_id']])->unbuffered_row()->order_no;
                }
            }
        }
        return $array;
    }
    
    public function getvisitlist($emp_user_id){
        $rcolumns="'remarks' as type, `date`, `user_id`, '' as `name`, '' as `mobile`, '' as `email`, '' as `address`, 
                `latitude`, `longitude`, `remarks`, `image`, `followup_date`, `emp_user_id`, `added_on`";
        $pcolumns="'enquiry' as type, `date`, NULL as `user_id`, `name`, `mobile`, `email`, '' as `address`, 
                `latitude`, `longitude`, `remarks`, `image`, `followup_date`, `emp_user_id`, `added_on`";
        $sql="Select $rcolumns from ".TP."remarks where emp_user_id='$emp_user_id' ";
        $sql.="UNION Select $pcolumns from ".TP."enquiry where emp_user_id='$emp_user_id'";
        $sql.="order by added_on desc";
        $query=$this->db->query($sql);
        $array=$query->result_array();
        if(!empty($array)){
            foreach($array as $key=>$value){
                if($value['type']=='remarks'){
                    $dealer=$this->dealer->getdealers(array("t1.id"=>$value['user_id'],'t1.status'=>1),"single");
                    $array[$key]['name']=$dealer['name'];
                    $array[$key]['email']=$dealer['email'];
                    $array[$key]['mobile']=$dealer['mobile'];
                    $array[$key]['address']=$dealer['address'];
                }
                if($value['image']!=''){
                    $array[$key]['image']=file_url($value['image']);
                }
            }
        }
        return $array;
    }
    
    
    public function getdealerdues($dealer){
        $where['user_id']=$dealer['user_id'];
        $this->db->select_sum("total_amount","total_amount");
        $total_amount=$this->db->get_where("orders",$where)->unbuffered_row()->total_amount;
        $total_amount=!empty($total_amount)?round($total_amount):0;
        
        $this->db->select_sum("amount","paid_amount");
        $paid_amount=$this->db->get_where("payment",$where)->unbuffered_row()->paid_amount;
        $paid_amount=!empty($paid_amount)?$paid_amount:0;
        
        $dues=$total_amount-$paid_amount;
        
        return array("total_amount"=>$total_amount,"paid_amount"=>$paid_amount,"dues"=>$dues);
    }
}


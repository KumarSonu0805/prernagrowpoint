<?php
class Expense_model extends CI_Model{
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
        //ADD shop in duplicate
	}
	
    public function addexpensehead($data){
        $check=$this->db->get_where('expense_head',array('name'=>$data['name']));
        if($check->num_rows()==0){
            if($this->db->insert("expense_head",$data)){
                $expensehead_id=$this->db->insert_id();
                return array("status"=>true,"message"=>"Expense Head Added Successfully!",'expensehead_id'=>$expensehead_id);
            }
            else{
                $error=$this->db->error();
                return array("status"=>false,"message"=>$error['message']);
            }
        }
        else{
            $expensehead=$check->unbuffered_row('array');
            return array("status"=>false,"message"=>"Expense Head Already Added!",'expensehead_id'=>$expensehead['id']);
        }
    }
    
    public function getexpenseheads($where=array(),$type="all"){
        $this->db->where($where);
        $query=$this->db->get("expense_head");
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function updateexpensehead($data){
        $id=$data['id'];
        unset($data['id']);
        $where=array("id"=>$id);
        if($this->db->get_where('expense_head',array('name'=>$data['name'],"id!="=>$id))->num_rows()==0){
            if($this->db->update("expense_head",$data,$where)){
                return array("status"=>true,"message"=>"Expense Head Updated Successfully!");
            }
            else{
                $error=$this->db->error();
                return array("status"=>false,"message"=>$error['message']);
            }
        }
        else{
            return array("status"=>false,"message"=>"Expense Head Already Added!");
        }
    }
    
    public function saveexpense($data){
        $this->db->select_max('receipt_no');
        $receipt_no=$this->db->get_where('expenses',['user_id'=>$data['user_id']])->unbuffered_row()->receipt_no;
        $receipt_no=empty($receipt_no)?0:$receipt_no;
        $receipt_no++;
        $data['receipt_no']=$receipt_no;
        $data['added_on']=$data['updated_on']=date('Y-m-d H:i:s');
        if($this->db->insert("expenses",$data)){
            $expense_id=$this->db->insert_id();
            return array("status"=>true,"message"=>"Expense Added Successfully!",'expense_id'=>$expense_id);
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getexpenses($where=array(),$type="all"){
        $columns="t1.*, t2.name as expense_head,t3.name as user";
        $this->db->select($columns);
        $this->db->where($where);
        $this->db->from('expenses t1');
        $this->db->join('expense_head t2','t1.head_id=t2.id');
        $this->db->join('users t3','t1.user_id=t3.id');
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function updateexpense($data){
        $data['updated_on']=date('Y-m-d H:i:s');
        $id=$data['id'];
        unset($data['id']);
        $where=array("id"=>$id);
        if($this->db->update("expenses",$data,$where)){
            return array("status"=>true,"message"=>"Expense Updated Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function saveexpensepayment($data){
        $data['added_on']=$data['updated_on']=date('Y-m-d H:i:s');
        if($this->db->insert("expense_payments",$data)){
            $payment_id=$this->db->insert_id();
            return array("status"=>true,"message"=>"Expense Payment Added Successfully!",'payment_id'=>$payment_id);
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
    
    public function getexpensepayments($where=array(),$type="all"){
        $columns="t1.*, t2.name as user,CASE WHEN t2.role='franchise' THEN 'Franchisee' ELSE t3.name END as role";
        $this->db->select($columns);
        $this->db->where($where);
        $this->db->from('expense_payments t1');
        $this->db->join('users t2','t1.user_id=t2.id');
        $this->db->join('roles t3','t2.role=t3.slug','left');
        $query=$this->db->get();
        if($type=='all'){
            $array=$query->result_array();
        }
        else{
            $array=$query->unbuffered_row('array');
        }
        return $array;
    }
    
    public function updateexpensepayment($data){
        $data['updated_on']=date('Y-m-d H:i:s');
        $id=$data['id'];
        unset($data['id']);
        $where=array("id"=>$id);
        logupdateoperations("expense_payments",$data,$where);
        if($this->db->update("expense_payments",$data,$where)){
            return array("status"=>true,"message"=>"Expense Updated Successfully!");
        }
        else{
            $error=$this->db->error();
            return array("status"=>false,"message"=>$error['message']);
        }
    }
}

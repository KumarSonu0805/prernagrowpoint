<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expenses extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
        checklogin();
	}
	
	public function index(){
        $data['date']=date('Y-m-d');
        $data['head_id']='';
        $data['title']="New Expense";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $where=array('status'=>1);
        $data['expenseheads']=expensehead_dropdown($where,true);;
        $data['form']='add';
		$this->template->load('expenses','expenseform',$data);
	}
    
	public function expenselist(){
        $data['title']="Expense List";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $data['datatableexport']=true;
        $user=getuser();
        $where=array();
        if($this->session->role!='superadmin'){
            $where=array('t1.user_id'=>$user['id']);
        }
        $data['expenses']=$this->expense->getexpenses($where);
		$this->template->load('expenses','expenselist',$data);
	}
    
	public function editexpense($id=NULL){
        $expense=$this->expense->getexpenses(["md5(concat('expense-id-',t1.id))"=>$id],'single');
        if(empty($expense)){
            redirect('expenses/expenselist/');
        }
        $data['date']=$expense['date'];
        $data['head_id']=$expense['head_id'];
        $data['title']="Edit Expense";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $where=array('status'=>1);
        $expenseheads=$this->expense->getexpenseheads($where);
        $options=array(''=>'Select Expense Head');
        if(!empty($expenseheads)){
            foreach($expenseheads as $head){
                $options[$head['id']]=$head['name'];
            }
        }
        $data['expenseheads']=$options;
        $data['form']='edit';
        $data['expense']=$expense;
		$this->template->load('expenses','expenseform',$data);
	}
    
	public function expensehead(){
        $data['title']="Expense Head";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $where=array('status'=>1);
        $data['expenseheads']=$this->expense->getexpenseheads($where);
		$this->template->load('expenses','expensehead',$data);
	}
    
	public function addpayment(){
        $data['title']="Add Expense Payment";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $options=array(''=>'Select User');
        $users=$this->account->getusers("t1.role !='superadmin'");
        if(!empty($users)){
            foreach($users as $user){
                $options[$user['role_name']][$user['id']]=$user['name'];
            }
        }
        $data['users']=$options;
        $where=array('status'=>1);
        $data['expenseheads']=$this->expense->getexpenseheads($where);
		$this->template->load('expenses','addpayment',$data);
	}
    
	public function paymentlist(){
        $data['title']="Expense Payment List";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['datatable']=true;
        $data['alertify']=true;
        $user=getuser();
        $data['datatableexport']=true;
        $where=array('t1.status'=>1);
        if($this->session->role!='superadmin'){
            $where['t1.user_id']=$user['id'];
            $this->db->select_sum('amount');
            $expense=$this->db->get_where('expenses',['user_id'=>$user['id']])->unbuffered_row()->amount;
            $expense=$expense?:0;
            
            $this->db->select_sum('amount');
            $credit=$this->db->get_where('expense_payments',['user_id'=>$user['id'],'type'=>'credit'])->unbuffered_row()->amount;
            $credit=$credit?:0;
            
            $this->db->select_sum('amount');
            $debit=$this->db->get_where('expense_payments',['user_id'=>$user['id'],'type'=>'debit'])->unbuffered_row()->amount;
            $debit=$debit?:0;

            $data['expense']=$expense;
            $data['payment']=$credit;
            $data['debit']=$debit;
            $data['balance']=$credit-$expense-$debit;
        }
        $data['payments']=$this->expense->getexpensepayments($where);
		$this->template->load('expenses','paymentlist',$data);
	}
    
    public function addexpensehead(){
        if($this->input->post('addexpensehead')!==NULL){
            $data=$this->input->post();
            unset($data['addexpensehead']);
			$result=$this->expense->addexpensehead($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if($this->input->post('updateexpensehead')!==NULL){
            $data=$this->input->post();
            unset($data['updateexpensehead']);
			$result=$this->expense->updateexpensehead($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if(!empty($data) && !isset($data['id'])){
            unset($_SESSION["msg"],$_SESSION["err_msg"]);
            echo json_encode($result);
            exit;
        }
        redirect($_SERVER['HTTP_REFERER']);
	}
    
    public function getexpensehead(){
        $id=$this->input->post('id');
        $expensehead=$this->expense->getexpenseheads(array("id"=>$id),"single");
        echo json_encode($expensehead);
    }
    
    public function saveexpense(){
        if($this->input->post('saveexpense')!==NULL){
            $data=$this->input->post();
            if($data['head_id']=='new'){
                $data=addexpensehead($data);
            }
            unset($data['saveexpense']);
            $user=getuser();
            if(empty($data['inv_no'])){
                unset($data['inv_no']);
            }
            $data['user_id']=$user['id'];
            $data['added_by']=$user['id'];
			$result=$this->expense->saveexpense($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if($this->input->post('updateexpense')!==NULL){
            $data=$this->input->post();
            unset($data['updateexpense']);
            $user=getuser();
            $data['user_id']=$user['id'];
            //$data['added_by']=$user['id'];
			$result=$this->expense->updateexpense($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
                redirect('expenses/expenselist/');
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        if(!empty($data) && !isset($data['id'])){
            unset($_SESSION["msg"],$_SESSION["err_msg"]);
            echo json_encode($result);
            exit;
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
	public function getexpenseheads(){
        $name=$this->input->post('name');
        $value=$this->input->post('value');
        $classes=$this->input->post('classes');
        $id=$this->input->post('id');
        $required=$this->input->post('required');
        $attributes=array('class'=>$classes,'id'=>$id);
        if($required==1){
            $attributes['required']=true;
        }
        $where=array();
        
        $expenseheads=$this->expense->getexpenseheads($where);
        $options=array(''=>'Select Expense Head');
        if(!empty($expenseheads)){
            foreach($expenseheads as $head){
                $options[$head['id']]=$head['name'];
            }
        }
        echo form_dropdown($name,$options,$value,$attributes);
	}
    
    
	public function checkinvoice(){
        $inv_no=$this->input->post('inv_no');
        $id=$this->input->post('id');
        $user=getuser();
        $where=['inv_no'=>$inv_no,'user_id'=>$user['id']];
        if(!empty($id)){
            $where['id!=']=$id;
        }
        $check=$this->db->get_where('expenses',$where)->num_rows();
        if($check==0){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    public function deleteexpensehead(){
        $expensehead_id=$this->input->post('expensehead_id');
        $where=["md5(concat('expensehead-id-',id))"=>$expensehead_id];
        $expensehead=$this->expense->getexpenseheads($where,'single');
        $this->load->helper('delete');
        deleteexpensehead(['id'=>$expensehead['id']]);
    }
    
    public function deleteexpense(){
        $expense_id=$this->input->post('expense_id');
        $where=["md5(concat('expense-id-',t1.id))"=>$expense_id];
        $expense=$this->expense->getexpenses($where,'single');
        $this->load->helper('delete');
        deleteexpense(['id'=>$expense['id']]);
    }
    
    public function addexpensepayment(){
        if($this->input->post('addexpensepayment')!==NULL){
            $data=$this->input->post();
            //print_pre($data,true);
            unset($data['addexpensepayment']);
			$result=$this->expense->saveexpensepayment($data);
			if($result['status']===true){
				$this->session->set_flashdata("msg",$result['message']);
			}
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function transfertobank(){
        $id=$this->input->post('id');
        $payment=$this->expense->getexpensepayments(["md5(concat('exp-pay-',t1.id))"=>$id],'single');
        if(!empty($payment) && $payment['pay_status']==0 ){
            $franchise=$this->franchise->getfranchises(['t2.id'=>$payment['user_id']],'single');
            if(!empty($franchise) && !empty($franchise['account_no'])){
                $this->load->helper('anvineo');
                $ref_no='NSEP'.uniqid();
                $data=[
                    "account_number" => $franchise['account_no'],
                    "ifsc_code" => $franchise['ifsc'],
                    "amount" => $payment['amount'],
                    "mobile_number" => $franchise['mobile'],
                    "bene_name" => $franchise['name'],
                    "ref_no" => $ref_no
                ];
                //print_pre($data,true);
                $response=payoutToBank($data,'pending');
                //print_pre($response,true);
                if($response['status']==1){
                    $status=1;
                    $message='';
                    if($response['message']=='Transfer Pending'){
                        $status=3;
                        $message="Transfer Initiated! Waiting for Gateway Response!";
                    }
                    $user=getuser();
                    $data=array('ref_no'=>$ref_no,'response'=>json_encode($response),'updated_on'=>date('Y-m-d H:i:s'),'pay_status'=>$status,'id'=>$payment['id']);
                    $result=$this->expense->updateexpensepayment($data);
                    if($result['status']===true){
                        echo json_encode(['status'=>true,'message'=>$message?:$result['message'],'options'=>'']);
                    }
                    else{
                        echo json_encode(['status'=>false,'message'=>$result['message'],'options'=>'']);
                    }
                }
                else{
                    $options='';
                    if($response['message']=='Insufficient Wallet'){
                        $options='Low Balance';
                        $message='Wallet Balance not Available in ANVINEO Panel.';
                    }
                    else{
                        $message=$response['message'];
                    }
                    echo json_encode(['status'=>false,'message'=>$message,'options'=>$options]);
                }
            }
            else{
                echo json_encode(['status'=>false,'message'=>'Account Details not available!','options'=>'']);
            }
        }
        elseif(!empty($request) && $request['status']==1){
            echo json_encode(['status'=>true,'message'=>'Withdrawal Request Already Approved!','options'=>'']);
        }
        elseif(!empty($request) && $request['status']==2){
            echo json_encode(['status'=>true,'message'=>'Withdrawal Request Already Rejected!','options'=>'']);
        }
        elseif(!empty($request) && $request['status']==3){
            echo json_encode(['status'=>true,'message'=>'Withdrawal Request Already Approved! Waiting for Gateway Response!']);
        }
        else{
            echo json_encode(['status'=>false,'message'=>'Please Try Again!']);
        }
    }
    
}
//url_title

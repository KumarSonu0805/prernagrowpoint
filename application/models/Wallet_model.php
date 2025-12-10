<?php
class Wallet_model extends CI_Model{
	
    var $status=false;
    
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
	
	public function checkstatus($regid,$date=NULL){
		$where=array("regid"=>$regid,"status"=>'1');
		if($date!==NULL){
			$where['date(activation_date)<=']=$date;
		}
		$checkstatus=$this->db->get_where("members",$where)->num_rows();
		if($checkstatus==0){ $this->status=false; }
		else{ $this->status=true; }
	}
	
    public function sponsorincome($regid,$date=NULL){
        if($date===NULL){
            $date=date('Y-m-d');
        }
        if($this->status){
            $where="t1.refid='$regid' and date(t1.activation_date)<='$date' and t1.regid not in 
                    (SELECT member_id from ".TP."wallet where regid='$regid' and remarks='Direct Income')";
            $newdirects=$this->member->getdirectmembers($regid);
            $added=$this->db->get_where('wallet',['regid'=>$regid,'remarks'=>'Direct Income'])->result_array();
            $member_ids=!empty($added)?array_column($added,'member_id'):array();
            if(!empty($newdirects)){
                foreach($newdirects as $member){
                    if(!in_array($member['regid'],$member_ids)){
                        $member_id=$member['regid'];
                        $amount=$member['direct'];
                        if($amount>0){
                            $data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"member_id"=>$member_id,
                                        "amount"=>$amount,"remarks"=>"Direct Income","added_on"=>date('Y-m-d H:i:s'),
                                        "updated_on"=>date('Y-m-d H:i:s'));
                            $where=array("type"=>"ewallet","regid"=>$regid,"member_id"=>$member_id,
                                         "remarks"=>"Direct Income");
                            if($this->db->get_where("wallet",$where)->num_rows()==0){
                                $this->db->insert("wallet",$data);
                            }
                        }
                    }
                }
            }
            
        }
    }
	
	function getLevelPercentage($level) {
        if ($level == 2) return 10;
        if ($level == 3) return 5; 
        if ($level == 4) return 4;
        if ($level == 5) return 3.5;
        if ($level == 6) return 3;
        if ($level == 7) return 2.5;
        if ($level == 8) return 2;
        if ($level == 9) return 1.5;
        if ($level == 10) return 1;
        if ($level == 11) return 0.5;
        return 0;
	}
	
    public function levelincome($regid,$date=NULL){
        if($date===NULL){
            $date=date('Y-m-d');
        }
        if($this->status){
            $levelmembers=$this->member->levelwisemembers($regid,$date,1);
            //print_pre($levelmembers);
            if(!empty($levelmembers)){
                foreach($levelmembers as $levelmember){
                    $member_id=$levelmember['member_id'];
                    $level=$levelmember['level'];
					$amount=$levelmember['amount'];
                    $rate=$this->getLevelPercentage($level);
                    if($rate>0 && $amount>0){
                        $amount=($amount*$rate)/100;
                        $data=array("date"=>$date,"type"=>"ewallet","regid"=>$regid,"member_id"=>$member_id,'level'=>$level,
                                    "amount"=>$amount,"remarks"=>"Level Income","added_on"=>date('Y-m-d H:i:s'),
                                    "updated_on"=>date('Y-m-d H:i:s'));
                        $where=array("type"=>"ewallet","regid"=>$regid,"member_id"=>$member_id,'level'=>$level,
                                    "remarks"=>"Level Income");
                        if($this->db->get_where("wallet",$where)->num_rows()==0){
                            $this->db->insert("wallet",$data);
                        }
                    }
                }
            }
        }
	}
	
	
	public function addcommission($regid,$date=NULL){
		$this->checkstatus($regid,$date);
		$this->sponsorincome($regid,$date);
		$this->levelincome($regid,$date);
		//$this->addreward($regid,$date);
	}
	
	public function addallcommission($date=NULL){
		if($date===NULL){
			$date=date('Y-m-d');
		}
		$this->db->select('id');
		$where="id>1";
        $this->db->order_by('id desc');
		$query=$this->db->get_where("users",$where);
		$array=$query->result_array();
		if(is_array($array)){
			foreach($array as $user){
				$this->addcommission($user['id'],$date);
			}
		}
	}
	
	public function getwallet($regid,$type="ewallet"){
		$result=array();
		$where=array("regid"=>$regid);
		$this->db->select_sum('amount');
		$query=$this->db->get_where("wallet",$where);
		$wallet=$query->row()->amount;
		if($wallet==NULL){ $wallet=0; }
		$result['wallet']=$wallet;
		
		$bankwithdrawal=$wallettransfers=$walletreceived=$epingeneration=$cancelled=0;
		if($type=="ewallet"){
			$where2=array("regid"=>$regid,"status!="=>2);
			$this->db->select_sum('amount','amount');
			$query2=$this->db->get_where("withdrawals",$where2);
			$bankwithdrawal=$query2->row()->amount;
			if($bankwithdrawal==NULL){ $bankwithdrawal=0; }
			
			$where3=array("reg_from"=>$regid);
			$this->db->select_sum('amount');
			$query3=$this->db->get_where("wallet_transfers",$where3);
			$wallettransfers=$query3->row()->amount;
			if($wallettransfers==NULL){ $wallettransfers=0; }
			
			$where4=array("reg_to"=>$regid);
			$this->db->select_sum('amount');
			$query4=$this->db->get_where("wallet_transfers",$where4);
			$walletreceived=$query4->row()->amount;
			if($walletreceived==NULL){ $walletreceived=0; }
			
			
		}
		$result['bankwithdrawal']=$bankwithdrawal;
		
		$result['cancelled']=$cancelled;
		
		$result['wallettransfers']=$wallettransfers;
		
		$result['walletreceived']=$walletreceived;
		
		$result['actualwallet']=$wallet-$bankwithdrawal-$wallettransfers+$walletreceived+$cancelled;
		$result['wallet']=$result['actualwallet']-(10*$result['actualwallet'])/100;
		return $result;
	}
	
	public function memberincome($regid){
		$this->db->order_by("id");
		$array=$this->db->get_where("wallet",array("regid"=>$regid,"amount>"=>"0"))->result_array();
		return $array;
	}
	
	public function transferamount($data){
		if($this->db->insert("wallet_transfers",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function gethistory($regid,$type="register",$wallet="ewallet"){
		if($type=="register"){
			$where=array("reg_from"=>$regid,"type_from"=>$wallet);
		}
		else{
			$where=array("reg_to"=>$regid,"type_to"=>$wallet);
		}
		$array=$this->db->get_where("wallet_transfers",$where)->result_array();
		if(is_array($array)){
			foreach($array as $key=>$value){
				$to=$this->db->get_where("users",array("id"=>$value['reg_to']))->row_array();
				$from=$this->db->get_where("users",array("id"=>$value['reg_from']))->row_array();
				$array[$key]['to_id']=$to["username"];
				$array[$key]['to_name']=$to["name"];
				$array[$key]['from_id']=$from["username"];
				$array[$key]['from_name']=$from["name"];
			}
		}
		return $array;
	}
	
	public function requestpayout($data){
		$regid=$data['regid'];
		$check=$this->db->get_where("withdrawals",array("regid"=>$regid,"status"=>"0"))->num_rows();
		if($check==0){
			if($this->db->insert("withdrawals",$data)){
				return true;
			}
			else{
				return $this->db->error();
			}
		}
		else{
			return array("message"=>"Previous Payout Request is Pending!");
		}
	}
	
	public function getmemberrequests($where){
		$this->db->where($where);
		$query=$this->db->get("withdrawals");
		$array=$query->result_array();
		return $array;
	}
	
	public function getwitdrawalrequest($where=array(),$type='all'){
		if(empty($where)){ $where['t1.status']=0; }
		$this->db->select("t1.*, t2.username,t2.name,t3.bank,t3.account_no,t3.account_name,t3.ifsc,t3.cheque");
		$this->db->from('withdrawals t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('acc_details t3','t1.regid=t3.regid','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function approvepayout($id){
		$date=date('Y-m-d');
		$updated_on=date('Y-m-d H:i:s');
		if($this->db->update("withdrawals",array("status"=>1,"approve_date"=>$date,"updated_on"=>$updated_on),array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function rejectpayout($id,$reason){
		$updated_on=date('Y-m-d H:i:s');
		$data=array("status"=>2,'reason'=>$reason,"updated_on"=>$updated_on);
		if($this->session->role=='admin'){
			$data['approve_date']=date('Y-m-d');
		}
		if($this->db->update("withdrawals",$data,array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function paymentreport($where=array(),$type='all'){
		$where['t1.status']=1;
		$columns="t1.approve_date,t2.username, t2.name,t3.account_no,t3.ifsc,amount,tds,admin_charge,t1.payable as paidamount";
		$this->db->select($columns);
		$this->db->from('withdrawals t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('acc_details t3','t1.regid=t3.regid','Left');
		$this->db->order_by("t1.approve_date");
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function approveallpayout($endtime){
		$where=array("t1.status"=>0,"t1.added_on<"=>$endtime);
		$members=$this->Wallet_model->getwitdrawalrequest($where);
		foreach($members as $member){
			$this->approvepayout($member['id']);
		}
	}
	
	public function dailypaymentreport(){
		$this->db->select("approve_date,sum(payable) as total_amount");
		$this->db->group_by("approve_date");
		$query=$this->db->get_where("withdrawals",array("status"=>1));
		$array=$query->result_array();
		return $array;
	}
	
	public function getmemberrewards(){
		$this->db->select("t2.username,t2.name,t1.*,t3.category");
		$this->db->from("member_rewards t1");
		$this->db->join("users t2","t1.regid=t2.id");
		$this->db->join("rewards t3","t1.reward_id=t3.id");
		$this->db->order_by("t1.status,t1.id");
		//$this->db->where(array("t1.status"=>"0"));
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function approvereward($id){
		if($this->db->update("member_rewards",array("status"=>1,"approve_date"=>date('Y-m-d')),array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getmembercommission(){
		$this->db->select("t1.regid,t2.username,t2.name,sum(t1.amount) as total");
		$this->db->from("wallet t1");
		$this->db->join("users t2","t1.regid=t2.id");
		$this->db->group_by("t1.regid");
		$array=$this->db->get()->result_array();
		if(is_array($array)){
			foreach($array as $key=>$member){
				$where2=array("regid"=>$member['regid'],"status!="=>2);
				$this->db->select_sum('amount','amount');
				$query2=$this->db->get_where("withdrawals",$where2);
				$bankwithdrawal=$query2->row()->amount;
				if($bankwithdrawal==NULL){ $bankwithdrawal=0; }
				$array[$key]['available']=$member['total']-$bankwithdrawal;
			}
		}
		return $array;
	}
}
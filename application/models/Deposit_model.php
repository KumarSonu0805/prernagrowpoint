<?php
class Deposit_model extends CI_Model{
	
    var $status=false;
    
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
	}
	
	public function savedeposit($data){
		$regid=$data['regid'];
		$to_regid=$data['to_regid'];
		$check=$this->db->get_where("deposits",array("regid"=>$regid,'to_regid'=>$to_regid,"status"=>"0"))->num_rows();
		if($check==0){
            $check2=$this->db->get_where("deposits",array("regid"=>$regid,'to_regid'=>$to_regid,"status"=>"1"))->num_rows();
			if($this->db->insert("deposits",$data)){
                $message=$data['type']=='activation'?"Activation Request Saved Successfully!":"Money Transfer Saved Successfully!";
				return array('status'=>true,'message'=>$message,'deposit_id'=>$this->db->insert_id());
			}
			else{
                $err=$this->db->error();
                return array("status"=>false,"message"=>$err['message']);
			}
		}
		else{
			return array("status"=>false,"message"=>"Previous Money Transfer has not been Approved!");
		}
	}
	
	public function getdepositlist($where,$columns=false){
        if($columns){
            $columns ="date,type,amount,";
            $columns.="case when status=0 then 'Request Pending' 
                            when status=1 then concat('Deposit Approved on ',DATE_FORMAT(approved_on, '%d-%m-%Y'))
                            else 'Deposit Rejected' end as status";
            $this->db->select($columns);
        }
		$this->db->where($where);
		$query=$this->db->get("deposits");
		$array=$query->result_array();
		return $array;
	}
	
	public function getdeposits($where=array(),$type='all'){
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('deposits t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('members t3','t1.regid=t3.regid','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function getdepositlistrequest($where=array(),$type='all'){
		if(empty($where)){ $where['t1.status']=0; }
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('deposits t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('members t3','t1.regid=t3.regid','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->row_array(); }
		return $array;
	}
	
	public function approvedeposit($id){
		$date=date('Y-m-d');
		$updated_on=date('Y-m-d H:i:s');
        $data=array("status"=>1,"approved_on"=>$updated_on,"updated_on"=>$updated_on);
        $this->db->trans_start();
		if($this->db->update("deposits",$data,array("id"=>$id))){
            $deposit=$this->db->get_where('deposits',['id'=>$id])->unbuffered_row('array');
            $regid=$deposit['regid'];
            $ogregid=$regid;
            if($deposit['type']=='activation'){
                $data=array('regid'=>$deposit['regid'],'package_id'=>1);
                $this->member->activatemember($data);
                $member=$this->member->getmemberdetails($regid);
                $data=array('type'=>'sponsor','date'=>$date,'regid'=>$regid,'to_regid'=>$member['refid'],'amount'=>500,
                            'total_amount'=>500,'added_on'=>$updated_on,'updated_on'=>$updated_on,'status'=>1);
                if($this->db->get_where('donations',['to_regid'=>$member['refid'],'type'=>'sponsor'])->num_rows()!=0){
                    $data['to_regid']=1;
                }
                $this->db->insert('donations',$data);
                $parent=$this->db->get_where('member_tree',['regid'=>$regid])->unbuffered_row('array');
                $pairdata=array();
                while($parent['parent_id']!=1){
                    if($this->db->get_where('members',['regid'=>$parent['parent_id'],'status'=>1])->num_rows()==0){
                        $regid=$parent['parent_id'];
                        $parent=$this->db->get_where('member_tree',['regid'=>$regid])->unbuffered_row('array');
                        continue;
                    }
                    $datetime=date('Y-m-d H:i:s');
                    $position=$parent['position']=='L'?'left_regid':'right_regid';
                    
                    $checkfirst=$this->db->get_where('pairs',['regid'=>$parent['parent_id'],"left_regid!="=>'0',"right_regid!="=>'0']);
                    if($checkfirst->num_rows()==1){
                        if($this->db->get_where('pairs',['regid'=>$parent['parent_id'],"status"=>'1'])->num_rows()==0){
                            $pairdata=array('regid'=>$parent['parent_id'],'added_on'=>$datetime,
                                              'updated_on'=>$datetime);
                            if($parent['position']=='L'){
                                $pairdata['left_regid']=$ogregid;
                            }
                            else{
                                $pairdata['right_regid']=$ogregid;
                            }
                            $this->db->insert('pairs',$pairdata);
                        }
                        else{
                            $this->db->order_by('id asc');
                            $getempty=$this->db->get_where('pairs',['regid'=>$parent['parent_id'],$position=>'0','status'=>0]);
                            if($getempty->num_rows()==0){
                                $pairdata=array('regid'=>$parent['parent_id'],$position=>$ogregid,'added_on'=>$datetime,
                                                  'updated_on'=>$datetime);
                                //print_pre($pairdata);
                                $this->db->insert('pairs',$pairdata);
                            }
                            else{
                                $first=$getempty->unbuffered_row('array');
                                //print_pre($pairdata);
                                $pairdata=array($position=>$ogregid,'status'=>1,'updated_on'=>$datetime);
                                $this->db->update('pairs',$pairdata,['id'=>$first['id']]);
                            }
                        }
                    }
                    else{
                        $this->db->order_by('id asc');
                        $getempty=$this->db->get_where('pairs',['regid'=>$parent['parent_id'],$position=>'0','status'=>0]);
                        if($getempty->num_rows()==0){
                            $pairdata=array('regid'=>$parent['parent_id'],$position=>$ogregid,'added_on'=>$datetime,
                                              'updated_on'=>$datetime);
                            //print_pre($pairdata);
                            $this->db->insert('pairs',$pairdata);
                        }
                        else{
                            $first=$getempty->unbuffered_row('array');
                            //print_pre($pairdata);
                            $pairdata=array($position=>$ogregid,'status'=>1,'updated_on'=>$datetime);
                            $this->db->update('pairs',$pairdata,['id'=>$first['id']]);
                        }
                    }
                    $regid=$parent['parent_id'];
                    $parent=$this->db->get_where('member_tree',['regid'=>$regid])->unbuffered_row('array');
                }
                
            }
            if(!empty($pairdata)){
                //print_pre($pairdata,true);
            }
            
            $this->db->order_by('id desc');
            $getpairs=$this->db->get_where('pairs',"(left_regid='$ogregid' or right_regid='$ogregid') and status='1'");
            $checkpairdonation=$this->db->get_where('donations',['regid'=>$ogregid,'type'=>'pair'])->num_rows();
            if($getpairs->num_rows()>0 && $checkpairdonation<3){
                $pairs=$getpairs->result_array();
                foreach($pairs as $pair){
                    if($checkpairdonation==3){
                        break;
                    }
                    $where=array('type'=>'pair','date'=>$date,'regid'=>$ogregid,'to_regid'=>$pair['regid']);
                    if($this->db->get_where('donations',$where)->num_rows()==0){
                        $data=array('type'=>'pair','date'=>$date,'regid'=>$ogregid,'to_regid'=>$pair['regid'],'amount'=>500,
                                    'total_amount'=>500,'added_on'=>$updated_on,'updated_on'=>$updated_on,'status'=>1);
                        if($this->db->get_where('donations',['to_regid'=>$pair['regid'],'type'=>'pair'])->num_rows()>=3){
                            $data['to_regid']=1;
                        }
                        $this->db->insert('donations',$data);
                        $checkpairdonation++;
                    }
                }
            }
            
            while($checkpairdonation<3){
                $data=array('type'=>'pair','date'=>$date,'regid'=>$ogregid,'to_regid'=>1,'amount'=>500,
                            'total_amount'=>500,'added_on'=>$updated_on,'updated_on'=>$updated_on,'status'=>1);
                $this->db->insert('donations',$data);
                $checkpairdonation++;
            }
            $this->db->trans_complete();
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function rejectdeposit($id){
		$updated_on=date('Y-m-d H:i:s');
		$data=array("status"=>2,"updated_on"=>$updated_on);
		if($this->session->role=='admin'){
			$data['approved_on']=$updated_on;
		}
		if($this->db->update("deposits",$data,array("id"=>$id))){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
    
	public function saverequest($data){
		$to_regid=$data['to_regid'];
		$type=$data['type'];
		$check=$this->db->get_where("donations",array('type'=>$type,'to_regid'=>$to_regid,"status"=>"0"))->num_rows();
		if($check==0){
            $check2=$this->db->get_where("donations",array('type'=>$type,'to_regid'=>$to_regid,"status"=>"1"))->num_rows();
			if($this->db->insert("donations",$data)){
                $message="Money Transfer Request Saved Successfully!";
				return array('status'=>true,'message'=>$message);
			}
			else{
                $err=$this->db->error();
                return array("status"=>false,"message"=>$err['message']);
			}
		}
		else{
			return array("status"=>false,"message"=>"Previous Money Transfer has not been Approved!");
		}
	}
	
	
}
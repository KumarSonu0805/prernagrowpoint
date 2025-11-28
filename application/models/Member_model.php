<?php
class Member_model extends CI_Model{
	var $user_prefix="PGP";
	var $random_user=true;
	var $pool_size=2; // pool count
	var $downline_table="members";
	var $downline_order="refid";
	var $downline_parent="refid";
	
	function __construct(){
		parent::__construct(); 
		$this->db->db_debug = false;
        $this->load->library('template');
	}
    
	public function getallusers(){	
		$query=$this->db->get("users");
		$array=$query->result_array();
		return $array;
	}
	
	public function getbanks(){	
		$query=$this->db->get("banks");
		$array=$query->result_array();
		return $array;
	}
	
	public function addmember($data){
		$userdata=$data['userdata'];
		$memberdata=$data['memberdata'];
		$accountdata=$data['accountdata'];
		$treedata=$data['treedata'];
		$user=$this->adduser($userdata);
		if(is_array($user) && $user['status']===true){
			$regid=$user['regid'];
			$username=$user['username'];
			$password=$user['password'];
			
			$memberdata['regid']=$regid;
			$accountdata['regid']=$regid;
			
			$memberdata['added_on']=date('Y-m-d H:i:s');
			
			$this->db->insert("members",$memberdata);
			$this->db->insert("acc_details",$accountdata);
			$this->db->insert("nominee",array("regid"=>$regid));
            
            $this->addlevel($regid);
		}
		return $user;
	}
	
	public function adduser($userdata){
		$this->db->order_by('id desc');
		$username=$this->generateusername();
		$userdata['username']=$username;
		$password=random_string('numeric', 5);
		$userdata['vp']=$password;
		$salt=random_string('alnum', 16);
		$encpassword=$password.SITE_SALT.$salt;
        $encpassword=password_hash($encpassword,PASSWORD_DEFAULT);
		$userdata['salt']=$salt;
		$userdata['password']=$encpassword;
		$userdata['created_on']=date('Y-m-d H:i:s');
		$userdata['updated_on']=date('Y-m-d H:i:s');
		if($this->db->insert("users",$userdata)){
			$regid=$this->db->insert_id();
			$result=array("status"=>true,"regid"=>$regid,"username"=>$username,"password"=>$password);
			return $result;
		}
		else{
			$error= $this->db->error();
			$error['status']=false;
			return $error;
		}
	}
	
	public function generateusername($username=''){
		if($this->random_user===false){
			if($username!=''){
				$username++;
			}
			else{
				$this->db->order_by("id desc");
				$array=$this->db->get_where("users",array("role"=>"member"))->unbuffered_row('array');
				if(!empty($array)){
					$username=$array['username'];
					$username++;
				}
				else{
					$username=$this->user_prefix."100001";
				}
			}
		}
		else{
			$userid=random_string('numeric',6);
			$username=$this->user_prefix.$userid;
		}
		$where="username='$username'";
		$query=$this->db->get_where("users",$where);
		$checkuser=$query->num_rows();
		if($checkuser!=0){
			return $this->generateusername($username);
		}
		else{
			return $username;
		}
	}
	
	public function addlevel($regid){
		$leveldata=array();
		$this->db->select("regid,GetAncestry(regid) as ancestors");
		$getancestors=$this->db->get_where("members",array("regid"=>$regid));
        //print_pre($ancestors,true);
		if($getancestors->num_rows()>0){
            $ancestors=$getancestors->unbuffered_row()->ancestors;
            $ancestors=!empty($ancestors)?explode(',',$ancestors):array();
            if(is_array($ancestors)){
                foreach($ancestors as $key=>$ancestor){
				    if(empty($ancestor) || $ancestor==1){ break; }
                    $level_id=$key+1;
                    //if($level_id>28 || empty($ancestor)){ continue; }
                    //$this->checklevelmembers($ancestor,$level_id);
                    $single['regid']=$ancestor;
                    $single['level_id']=$level_id;
                    $single['member_id']=$regid;
                    $single['added_on']=date('Y-m-d H:i:s');
                    $leveldata[]=$single;
                }
            }
		}
        //print_pre($leveldata,true);
		if(!empty($leveldata)){
			$this->db->insert_batch("level_members",$leveldata);
		}
	}
		
	public function getalldetails($regid){
		$member=$this->getmemberdetails($regid);
		$member['password']=$this->db->get_where("users",array("id"=>$regid))->unbuffered_row()->vp;
		$sponsor=$this->account->getuser(array("id"=>$member['refid']));
		$member['susername']=$sponsor['user']['username'];
		$member['sname']=$sponsor['user']['name'];
		$acc_details=$this->getaccdetails($regid);
		$nominee_details=$this->getnomineedetails($regid);
		$result=array("member"=>$member,"acc_details"=>$acc_details,"nominee_details"=>$nominee_details);
		return $result;
	}
	
	public function getmemberdetails($regid){
		return $this->db->get_where("members",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getaccdetails($regid){
		return $this->db->get_where("acc_details",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getnomineedetails($regid){
		return $this->db->get_where("nominee",array("regid"=>$regid))->unbuffered_row('array');
	}
	
	public function getphoto(){
		$user=$this->session->user;
		$this->db->select('photo');
		$array=$this->db->get_where("members",array("md5(regid)"=>$user))->unbuffered_row('array');
		if(!is_array($array) || $array['photo']==''){
			$array['photo']	="assets/images/blank.png";
		}
		$photo=file_url($array['photo']);
		return $photo;
	}
	
	public function updatepassword($data){
		$oldpass=$data['oldpass'];
		$password=$data['password'];
		$user=$data['user'];
		$where="md5(id)='$user'";
		$query = $this->db->get_where("users",$where);
		$result=$query->unbuffered_row('array');
		$checkpass=false;
		if(!empty($result)){
			$salt=$result['salt'];
			$hashpassword=$result['password'];
            if(password_verify($oldpass.SITE_SALT.$salt,$hashpassword)){
				$checkpass=true;
				$vp=$password;
                $password=$password.SITE_SALT.$salt;
                $password=password_hash($password,PASSWORD_DEFAULT);
				$this->db->where($where);
				$this->db->update("users",array("password"=>$password,"vp"=>$vp));
			}
		}
		return $checkpass;
	}
	
	public function updatephoto($data,$where){
		if($this->db->update("members",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatemember($data,$regid){
		$where1['id']=$regid;
		$where2['regid']=$regid;
		if(!empty($data['userdata'])){
			$this->db->update("users",$data['userdata'],$where1);
			$result=$this->updatepersonaldetails($data['memberdata'],$where2);
		}
		if(!empty($data['accountdata'])){
			$result=$this->updateaccdetails($data['accountdata'],$where2);
		}
		if($result===true){
			return true;
		}
		else{
			return $result;
		}
	}
	
	
	public function updatepersonaldetails($data,$where){
		if($this->db->update("members",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatecontactinfo($data,$where){
		if($this->db->update("members",$data,$where)){
			$userdata['mobile']=$data['mobile'];
			$userdata['email']=$data['email'];
			$where2=array("id"=>$where['regid']);
			$this->db->update("users",$userdata,$where2);
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updatenomineedetails($data,$where){
		$checknominee=$this->db->get_where("nominee",$where)->num_rows();
		if($checknominee==0){
			$data['regid']=$where['regid'];
			$result=$this->db->insert("nominee",$data);
		}
		else{
			$result=$this->db->update("nominee",$data,$where);
		}
		if($result){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function updateaccdetails($data,$where){
		$checknominee=$this->db->get_where("acc_details",$where)->num_rows();
		if($checknominee==0){
			$data['regid']=$where['regid'];
			$result=$this->db->insert("acc_details",$data);
		}
		else{
			$result=$this->db->update("acc_details",$data,$where);
		}
		if($result){
			$where2=$where;
			$where2['account_no!=']='';
			$where2['ifsc!=']='';
			$where2['aadhar1!=']='';
			$where2['aadhar2!=']='';
			$where2['cheque!=']='';
			$where2['kyc!=']='1';
			$check=$this->db->get_where("acc_details",$where2)->num_rows();
			if($check!=0){
				$this->db->update("acc_details",array("kyc"=>"2"),$where);
			}
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getpopupdetails($regid){
		if($regid!=1){
			$columns="t1.username,t1.name,t3.username as ref,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
			$this->db->select($columns);
			$this->db->from('users t1');
			$this->db->join('members t2','t2.regid=t1.id','Left');
			$this->db->join('users t3','t2.refid=t3.id','Left');
			$this->db->join('packages t4','t2.package_id=t4.id','Left');
			$this->db->where("t1.id",$regid);
			$query=$this->db->get();
			if($query->num_rows()==1){
				$array=$query->row_array();
				$array['date']=date('d-m-Y',strtotime($array['date']));
				if($array['activation_date']!='0000-00-00'){ $array['activation_date']=date('d-m-Y',strtotime($array['activation_date'])); }
				else{ $array['activation_date']='--/--/----'; }
				$leftright=$this->countleftrightmembers($regid);	
				$array['left']=$leftright['left'];
				$array['right']=$leftright['right'];
                $this->db->order_by('id desc');
                //$getrank=$this->db->get_where("rewards","id in (SELECT reward_id from `mr_reward_members` where regid='$regid')");
                $rank='--';
                /*if($getrank->num_rows()>0){
                    $rank=$getrank->unbuffered_row()->rank;
                }*/
                $array['rank']=$rank;
				return $array;
			}
			else{
				return false;
			}
		}
		else{
			$array=array("name"=>"Admin","date"=>"--/--/----","activation_date"=>"--/--/----","sponsor"=>"--");
			$leftright=$this->countleftrightmembers($regid);	
			$array['left']=$leftright['left'];
			$array['right']=$leftright['right'];
			$array['package']='--';
			return $array;
		}
	}
		
	public function getmembers($regid,$count=false){
        
        // Initialize the parent variable in MariaDB
        $this->db->query("SET @pv := ?", [$regid]);

        $columns="";
        
        // Query to fetch hierarchy using variables
        $query = "
            SELECT u.id as regid,u.username,u.name,u.vp as password,concat_ws(',',m.district,m.state) as location,
							u2.username as ref,u2.name as refname,m.date,m.activation_date,ifnull(t4.package,'--') as package,m.status
            FROM (
                SELECT regid, @pv := CONCAT(@pv, ',', regid) AS pv
                FROM (
                    SELECT *
                    FROM ".TP."members
                    ORDER BY refid, regid
                ) ordered_members,
                (SELECT @pv := ?) init
                WHERE FIND_IN_SET(refid, @pv) > 0
            ) t
            JOIN ".TP."members m ON m.regid = t.regid
            JOIN ".TP."users u ON m.regid = u.id
            JOIN ".TP."users u2 ON m.refid = u2.id
            LEFT JOIN ".TP."packages t4 ON m.package_id = t4.id;
        ";

        // Execute the query
        if($count===false){
            $result = $this->db->query($query, [$regid])->result_array();
        }
        else{
            $result = $this->db->query($query, [$regid])->num_rows();
        }
        // Output the result as JSON
        //print_pre($result);
        return $result;
	}
		
	public function getallmembers($regid,$type="all"){
		$table=TP.$this->downline_table;
		$regids=NULL;
		$array=$result=array();
		$inclimit=$this->db->query("SET SESSION group_concat_max_len = 1000000;");
		$sql="select GROUP_CONCAT(regid SEPARATOR ',') as regids from 
				(select * from $table order by ".$this->downline_order.") member_tree, 
				(select @pv := '$regid') initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid)";
		$exe=$this->db->query($sql);
		$regids=$exe->row()->regids;
		if($regids!==NULL){
			$regids=explode(',',$regids);
			if($type=="all" || $type=="active"){
				$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
							t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
				
				$this->db->group_start();
				$regid_chunks = array_chunk($regids,25);
				foreach($regid_chunks as $regid_chunk){
					$this->db->or_where_in('t1.id', $regid_chunk);
				}
				$this->db->group_end();
				
				$this->db->select($columns);
				$this->db->from('users t1');
				$this->db->join('members t2','t2.regid=t1.id','Left');
				$this->db->join('users t3','t2.refid=t3.id','Left');
				$this->db->join('packages t4','t2.package_id=t4.id','Left');
				if($type=="active"){
					$this->db->where("t2.status","1");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['active']=$array;
					
					$this->db->group_start();
					$regid_chunks = array_chunk($regids,25);
					foreach($regid_chunks as $regid_chunk){
						$this->db->or_where_in('t1.id', $regid_chunk);
					}
					$this->db->group_end();
					
					$this->db->select($columns);
					$this->db->from('users t1');
					$this->db->join('members t2','t2.regid=t1.id','Left');
					$this->db->join('users t3','t2.refid=t3.id','Left');
					$this->db->join('packages t4','t2.package_id=t4.id','Left');
					$this->db->where("t2.status","0");
					$query=$this->db->get();
					$array=$query->result_array();
					$result['inactive']=$array;
				}
				else{
					$query=$this->db->get();
					$array=$query->result_array();
					$result=$array;
				}
			}
			else{
				$result=$regids;
			}
		}
		return $result;
	}
	
	public function countallmembers($regid){
		$table=TP.$this->downline_table;
		$sql="select count(regid) as members from 
				(select * from $table order by ".$this->downline_order.") member_tree, 
				(select @pv := '$regid') initialisation 
				where find_in_set(".$this->downline_parent.", @pv) > 0 and @pv := concat(@pv, ',', regid)";
		return $this->db->query($sql)->row()->members;
	}
	
	public function getfirstmember($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		$this->db->where("t1.id",$regid);
		$query=$this->db->get();
		$array=$query->row_array();
		return $array;
	}
	
	public function getleftrightmembers($regid,$position=NULL,$type='all'){
		$left=$right=array();
		$where['parent_id']=$regid;
		$query=$this->db->get_where("member_tree",$where);
		if($query->num_rows()>0){
			$array=$query->result_array();
			foreach($array as $member){
				if($member['position']=='L' && ($position===NULL || $position=='left' )){
					$left=$this->getallmembers($member['regid'],$type);
					if($type=="all"){
						$first=$this->getfirstmember($member['regid']);
					}
					else{
						$first=$member['regid'];
					}
					array_unshift($left,$first);
				}
				if($member['position']=='R' && ($position===NULL || $position=='right' )){
					$right=$this->getallmembers($member['regid'],$type);
					if($type=="all"){
						$first=$this->getfirstmember($member['regid']);
					}
					else{
						$first=$member['regid'];
					}
					array_unshift($right,$first);
				}
			}
		}
		if($position=='left'){ $result=$left;  }
		elseif($position=='right'){ $result=$right;  }
		else{
			$result=array("left"=>$left,"right"=>$right);
		}
		return $result;
	}
	
	public function countleftrightmembers($regid,$position=NULL){
		$left=$right=0;
		$where['parent_id']=$regid;
		$query=$this->db->get_where("member_tree",$where);
		if($query->num_rows()>0){
			$array=$query->result_array();
			foreach($array as $member){
				if($member['position']=='L' && ($position===NULL || $position=='left' )){
					$left=$this->countallmembers($member['regid']);
					$left++;
				}
				if($member['position']=='R' && ($position===NULL || $position=='right' )){
					$right=$this->countallmembers($member['regid']);
					$right++;
				}
			}
		}
		if($position=='left'){ $result=$left;  }
		elseif($position=='right'){ $result=$right;  }
		else{
			$result=array("left"=>$left,"right"=>$right);
		}
		return $result;
	}
	
	public function getdirectmembers($regid){
		$columns="t1.id as regid,t1.username,t1.name,t1.vp as password,concat_ws(',',t2.district,t2.state) as location,
					t3.username as ref,t3.name as refname,t2.date,t2.activation_date,ifnull(t4.package,'--') as package,t2.status";
		$this->db->select($columns);
		$this->db->from('users t1');
		$this->db->join('members t2','t2.regid=t1.id','Left');
		$this->db->join('users t3','t2.refid=t3.id','Left');
		$this->db->join('packages t4','t2.package_id=t4.id','Left');
		
		$this->db->where("t2.refid",$regid);
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function getmemberid($username,$status="activated"){
		$where="username='$username'";
		$query=$this->db->get_where("users",$where);
		if($query->num_rows()==1){
			$array=$query->row_array();
			$regid=$array['id'];
			$name=$array['name'];
			$statusarr=explode(',',$status);
			$status=array_shift($statusarr);
			if($status=='downline' && $regid!=0 && $this->session->role=='member'){
				$downline=false;
				$refid=$this->db->get_where("members",array("regid"=>$regid))->unbuffered_row()->refid;
				while($refid>1){
					if(md5($refid)==$this->session->user){ $downline=true; break; }
					$refid=$this->db->get_where("members",array("regid"=>$refid))->unbuffered_row()->refid;
				}
				if($downline===false){$regid=0;$name="Enter different Member ID!";}
				$status=array_shift($statusarr);
			}
			elseif($status=='downline' && $this->session->role=='admin'){
				$status=array_shift($statusarr);
			}
			if($status=='not self' && $regid!=0){
				if(md5($regid)==$this->session->user){$regid=0;$name="Enter different Member ID!";}
				$status=array_shift($statusarr);
			}
			if($status=='activated' && $regid!=0){
				$check=$this->db->get_where("members",array("regid"=>$regid,"status"=>"1"))->num_rows();
				if($check!=1){$regid=0;$name="Member ID not Activated!";}
				$status=array_shift($statusarr);
			}
			if($status=='not activated' && $regid!=0){
				$check=$this->db->get_where("members",array("regid"=>$regid,"status"=>"0"))->num_rows();
				if($check!=1){$regid=0;$name="Member ID Already Activated!";}
				$status=array_shift($statusarr);
			}
			if($status=='day limit' && $regid!=0){
				$daylimit=date("Y-m-d",strtotime("-10 days"));
				$check=$this->db->get_where("members",array("regid"=>$regid,"date<"=>$daylimit))->num_rows();
				if($check==1){$regid=0;$name="You cannot activate this ID!";}
				$status=array_shift($statusarr);
			}
		}
		else{$regid=0;$name="Member ID not Available!";}
		$result=array("regid"=>$regid,"name"=>$name);
		return $result;
	}
	
	public function activatemember($data){
		$regid=$data['regid'];
		$updata['activation_date']=date('Y-m-d');
		$updata['package_id']=$data['package_id'];
		$updata['status']=1;
		$data['date']=date('Y-m-d');
		if($this->db->update("members",$updata,array("regid"=>$regid))){
			//$added_on=$this->Epin_model->updatepinstatus($data['epin'],$regid);
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
    public function gethomedata($regid){
        $result=array();
        $leftright=$this->countleftrightmembers($regid);
        $result['leftmembers']=$leftright['left'];
        $result['rightmembers']=$leftright['right'];
        $result['newmembers']=$leftright['left']+$leftright['right'];
        $result['totalmembers']=$leftright['left']+$leftright['right'];
        
        $directmembers=$this->getdirectmembers($regid);
        $result['directmembers']=count($directmembers);
        
        $this->db->select_sum("total_amount","payable");
        $income=$this->db->get_where("payment",array("regid"=>$regid))->unbuffered_row()->payable;
        if($income===NULL){$income=0;}
        $result['income']=$income;
        $packagewise=$this->packagewise();
        $result['packagewise']=$packagewise;
        return $result;
    }
    
    public function packagewise(){
        $result=array();
        $packages=$this->Package_model->getpackage();
        $this->db->order_by('id desc');
        $lastpayday=$this->db->get_where("payment")->unbuffered_row()->date;
        foreach($packages as $package){
            $allcount=$this->db->get_where("members",array("package_id"=>$package['id']))->num_rows();
            $newcount=$this->db->get_where("members",array("package_id"=>$package['id'],"activation_date>="=>$lastpayday))->num_rows();
            $todaycount=$this->db->get_where("members",array("package_id"=>$package['id'],"activation_date="=>date('Y-m-d')))->num_rows();
            $result[]=array("package"=>$package['package'],"allcount"=>$allcount,"newcount"=>$newcount,"todaycount"=>$todaycount);
        }
		
		$allcount=$this->db->get_where("renewal",array("status>"=>0))->num_rows();
		$newcount=$this->db->get_where("renewal",array("status>"=>0,"approve_date>="=>$lastpayday))->num_rows();
		$todaycount=$this->db->get_where("renewal",array("status>"=>0,"approve_date="=>date('Y-m-d')))->num_rows();
		$result[]=array("package"=>"Renewal","allcount"=>$allcount,"newcount"=>$newcount,"todaycount"=>$todaycount);
		
        return $result;
    }
    
	public function requestupgrade($data){
		if($this->db->insert("upgrade",$data)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function getupgraderequests($where=array(),$type='all'){
		$this->db->select("t1.*, t2.username,t2.name");
		$this->db->from('upgrade t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->where($where);
		$query=$this->db->get();
		if($type=='all'){ $array=$query->result_array(); }
		else{ $array=$query->unbuffered_row('array'); }
		return $array;
	}
	
	public function approveupgrade($request_id){
		$updata['approve_date']=date('Y-m-d');
		$updata['status']=1;
		if($this->db->update("upgrade",$updata,array("id"=>$request_id))){
            $regid=$this->db->get_where("upgrade",array("id"=>$request_id))->unbuffered_row()->regid;
            $this->db->update("members",array("upgrade"=>1),array("regid"=>$regid));
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function kyclist($status=2){
		$where['t1.kyc']=$status;
		$this->db->select("t1.*, t2.username,t3.name");
		$this->db->from('acc_details t1');
		$this->db->join('users t2','t1.regid=t2.id','Left');
		$this->db->join('members t3','t1.regid=t3.regid','Left');
		$this->db->where($where);
		$query=$this->db->get();
		 $array=$query->result_array(); 
		return $array;
	}
	
	public function approvekyc($data,$where){
		if($this->db->update("acc_details",$data,$where)){
			return true;
		}
		else{
			return $this->db->error();
		}
	}
	
	public function countlevelwisemembers($regid,$date=NULL){
		$where=array("regid"=>$regid);
		if($date!==NULL){
			$where['date(added_on)<=']=$date;
		}
		$this->db->select("level_id as level,count(*) as levelcount");
		$this->db->from("level_members");
		$this->db->where($where);
		$this->db->group_by("level_id");
		$this->db->order_by("level_id");
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function countlevelwiseactivemembers($regid,$date=NULL){
		$where=array("t1.regid"=>$regid);
		if($date!==NULL){
			$where['date(t1.added_on)<=']=$date;
		}
		$this->db->select("t1.level_id as level,count(*) as levelcount");
		$this->db->from("level_members t1");
		$this->db->join("(Select * from ".TP."members where status=1 ) t2","t2.regid=t1.member_id");
		$this->db->where($where);
		$this->db->group_by("t1.level_id");
		$this->db->order_by("t1.level_id");
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
	public function levelwisemembers($regid,$date=NULL){
		$where=array("t1.regid"=>$regid);
		if($date!==NULL){
			$where['date(t1.added_on)<=']=$date;
		}
		$this->db->select("t1.member_id,t1.level_id as level,t2.username,t2.name");
		$this->db->from("level_members t1");
		$this->db->join("users t2","t1.member_id=t2.id");
		$this->db->where($where);
		$this->db->order_by("t1.level_id");
		$query=$this->db->get();
		$array=$query->result_array();
		return $array;
	}
	
}
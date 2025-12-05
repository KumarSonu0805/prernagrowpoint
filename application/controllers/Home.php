<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
	}
    
    public function index(){
        checklogin();
        $this->wallet->addallcommission();
		$data['title']="Home";    
        if($this->session->role=='member'){
            $data['user']=getuser();
            $regid=$data['user']['id'];
            //$this->wallet->addcommission($regid);
            $memberdetails=$this->member->getalldetails($regid);
            $data['member']=$memberdetails['member'];
            //$homedata=$this->common->homedata($regid);
            
            $date=date('Y-m-d');
            $status=0;
            
            $message="";
            if($memberdetails['member']['status']==1){
                $status=1;
            }
            $data['status']=$status;
            $data['message']=$message;
            $where="(t1.regid='$regid' || t1.regid='0') and t1.to_regid!='$regid'";
            //$data['donations']=$this->deposit->getpendingdonation($where);
            //print_pre($data,true);
            $data['datatable']=true;
        }
        else{
            //$this->addallcommission();
            //$this->deletetokens();
            //$this->deleteinactivemembers();
            //$this->clearlogs();
            //$this->wallet->addallcommission();
            //$homedata=$this->common->adminhomedata();
        }
        //$data=array_merge($data,$homedata);
		$this->template->load('pages','home',$data);  
    }
    
	public function changepassword(){
        $data['user']=getuser();
        $data['title']="Edit Password";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['alertify']=true;
		$this->template->load('pages','changepassword',$data);
	}
    
    public function updatepassword(){
        if($this->input->post('updatepassword')!==NULL){
            $old_password=$this->input->post('old_password');
            $password=$this->input->post('password');
            $repassword=$this->input->post('repassword');
            $user=getuser();
            if(password_verify($old_password.SITE_SALT.$user['salt'],$user['password'])){
                $user=$this->session->user;
                if($password==$repassword){
                    $result=$this->account->updatepassword(array("password"=>$password),array("md5(id)"=>$user));
                    if($result['status']===true){
                        $this->session->set_flashdata('msg',$result['message']);
                    }
                    else{
                        $error=$result['message'];
                        $this->session->set_flashdata('err_msg',$error);
                    }
                }
                else{
                    $error=$result['message'];
                    $this->session->set_flashdata('err_msg',"Password Do not Match!");
                }
            }
            else{
                $this->session->set_flashdata('err_msg',"Old Password Does not Match!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function addallcommission(){
		$time1 = microtime(true);
        $date=date('Y-m-d');
		$this->wallet->addallcommission($date);
		$time2 = microtime(true);
		$time=$time2-$time1;
        echo "\nInterval Cron Success in $time seconds. Date : ".date('Y-m-d H:i:s');
    }
    
    public function template(){
        $data['title']="Template";
        $data['content']="admin/pages/test.php";
        $this->load->view('admin/includes/top-section',$data);       
        $this->load->view('admin/includes/header');
        $this->load->view('admin/includes/sidebar');
        $this->load->view('admin/includes/wrapper');
        $this->load->view('admin/includes/footer');
        $this->load->view('admin/includes/bottom-section'); 
    }
    
	public function checkbillpaymentlimit(){
        $this->session->set_userdata('user',md5('7'));
        checkbillpaymentlimit(getuser());
    }
    
	public function fundincome(){
        $this->wallet->fundincome(date('Y-m-d'));
    }
    
	public function register(){
        $this->load->view('test2');
    }
    
    public function recharge(){
        $this->load->helper('recharge');
        $result=requestrecharge();
        print_pre($result);
    }
    
    public function assign_scratch_cards(){
        $this->common->assign_scratch_cards();
    }
    
    public function phpinfo(){
        phpinfo();
    }
    
    public function caches(){
        $this->load->helper('file');

        $files = get_filenames(APPPATH . 'cache/');

        echo '<pre>';
        print_r($files);
        echo '</pre>';
    }
    
    public function clearallcache(){
        var_dump($this->cache->clean());
        var_dump($this->cache->cache_info());
    }
    
    public function localtest(){
        $this->load->view('admin/test');       
    }
    
	public function getusers(){     
        checklogin();
        $total=$this->db->get_where('users',['role'=>'member'])->num_rows();
        $active=$this->db->get_where('users',"role='member' and id in (SELECT regid from ".TP."members where status='1')")->num_rows();
        $today=$this->db->get_where('users',['role'=>'member','date(created_on)'=>date('Y-m-d')])->num_rows();
        $result=array('total'=>$total,'active'=>$active,'today'=>$today);
        echo json_encode($result);
    }
    
	public function getwallet(){     
        /*
        
            $('#today-business').text(response.business);
            $('#load-wallet').text(response.wallet);
            $('#income-wallet').text(response.income_wallet);
            $('#reward-wallet').text(response.reward_wallet);
            $('#today-recharge').text(response.recharge);
            $('#bill-payment').text(response.bill);
         */
        checklogin();
        
        session_write_close();       // Ensure native session is also closed
        
        $key='dashboard-data';
        $result=$this->cachemanager->cache('file')->setkey($key)->get();

        if ($result === FALSE) {

            $date=date('Y-m-d');
            $this->db->select_sum('amount');
            $business=$this->db->get_where('member_packages',['status'=>1,'date'=>$date])->unbuffered_row()->amount;
            $business=empty($business)?0:$business;

            $this->db->select_sum('amount');
            $credit=$this->db->get_where('daily_business',['type'=>'credit','date'=>$date])->unbuffered_row()->amount;
            $credit=empty($credit)?0:$credit;
            $this->db->select_sum('amount');
            $debit=$this->db->get_where('daily_business',['type'=>'debit','date'=>$date])->unbuffered_row()->amount;
            $debit=empty($debit)?0:$debit;
            $business+=$credit;
            $business-=$debit;


            /*$this->db->select_sum('amount');
            $wallet=$this->db->get_where('wallet_requests',['status'=>1])->unbuffered_row()->amount;
            $wallet=empty($wallet)?0:$wallet;

            $this->db->select_sum('amount');
            $income_wallet=$this->db->get_where('wallet',['status'=>1])->unbuffered_row()->amount;
            $income_wallet=empty($income_wallet)?0:$income_wallet;

            $this->db->select_sum('point');
            $reward_wallet=$this->db->get_where('wallet',['status'=>1])->unbuffered_row()->point;
            $reward_wallet=empty($reward_wallet)?0:$reward_wallet;*/

            $memberwallet=$this->wallet->getmemberwallet();

            $wallet=$income_wallet=$reward_wallet=0;
            if(!empty($memberwallet)){
                $wallet=array_column($memberwallet,'fund_wallet');
                $wallet=array_sum($wallet);
                $income_wallet=array_column($memberwallet,'income_wallet');
                $income_wallet=array_sum($income_wallet);
                $reward_wallet=array_column($memberwallet,'reward_wallet');
                $reward_wallet=array_sum($reward_wallet);

            }
            
            $recharge=$bill=0;
            $this->db->select_sum('amount');
            $this->db->where("(type='prepaid_recharge' or type='dth_recharge')");
            $recharge=$this->db->get_where('bill_payments',['status'=>1,'date'=>$date])->unbuffered_row()->amount;
            $recharge=empty($recharge)?0:$recharge;

            $result=array('business'=>$business,'wallet'=>$wallet,'income_wallet'=>$income_wallet,'reward_wallet'=>$reward_wallet,'recharge'=>$recharge,'bill'=>$bill);
            $result=array_map(function($item){
                return $this->amount->toDecimal($item);
            },$result);
            $this->cachemanager->cache('file')->setkey($key)->save($result, 1800);
        }
        else{
            $result=$result['data'];
        }
        echo json_encode($result);
    }
    
	public function testcache(){
        $this->load->library('CacheManager');
        $caches=getCacheNames();
        if(!empty($caches)){
            foreach($caches as $key=>$cache){
                $key=array('key'=>$key,'name'=>$cache,'type'=>'file','time'=>900);
                $this->cachemanager->cache('file')->savekeys($key);
            }
        }
        
        //$result=$this->cachemanager->cache('file')->getkeys();
        //print_pre($result);
        //$result=$this->cachemanager->cache('file')->savekeys($key);
        //print_pre($result);
        //$result=$this->cachemanager->cache('file')->setkey('cache_key')->get();
        //print_pre($result);
    }
    
	public function showprocess(){
        $sql="SHOW PROCESSLIST;";
        $query=$this->db->query($sql);
        $array=$query->result_array();
        //print_pre($array);
        echo '<table border="1"><tr><th>' . implode('</th><th>', array_keys($array[0])) . '</th></tr><tr><td>' . implode('</td></tr><tr><td>', array_map(fn($row) => implode('</td><td>', $row), $array)) . '</td></tr></table>';

    }

	
    public function runquery(){
        $query=array(
            "ALTER TABLE `pg_wallet` ADD `updated_on` DATETIME NOT NULL AFTER `added_on`;"
        );
        foreach($query as $sql){
            if(!$this->db->query($sql)){
                print_r($this->db->error());
            }
        }
    }
    
    public function clearlogs($all=false){
        if($all===false){
            $sql="DELETE from of_request_log where date(added_on)<'".date('Y-m-d',strtotime('-7 days'))."'";
        }
        elseif($all=='all'){
            $sql='TRUNCATE of_request_log';
        }
        else{
            $sql='';
        }
        $query=array($sql);
        foreach($query as $sql){
            if(!$this->db->query($sql)){
                print_r($this->db->error());
            }
        }
    }
    
    public function matchcolumns(){
        $tables=$this->db->query("show tables;")->result_array();
        echo "<h1>Tables : ".count($tables)."</h1>";
        foreach($tables as $table){
            $tablename=$table['Tables_in_'.DB_NAME];
            $columns=$this->db->query("DESC $tablename;")->result_array();
            echo "<h1>$tablename</h1>";
            echo "<h3>Columns : ".count($columns)."</h3>";
            echo "<h3>Rows : ".$this->db->get($tablename)->num_rows()."</h3>";
            echo "<table border='1' cellspacing='0' cellpadding='5'>";
            echo "<tr>";
            foreach($columns[0] as $key=>$value){
                echo "<td>$key</td>";
            }
            echo "</tr>";
            foreach($columns as $column){
                echo "<tr>";
                foreach($column as $key=>$value){
                    echo "<td>$value</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
    }
    
	public function error(){
        $data['title']='Page Not Found';
        if($this->session->user!==NULL){
            $this->load->library('template');
            $this->template->load('pages','error',$data);
        }
        else{
            $this->load->view('website/includes/top-section',$data);
            $this->load->view('website/error404');
            $this->load->view('website/includes/bottom-section');
        }
	}
    
}
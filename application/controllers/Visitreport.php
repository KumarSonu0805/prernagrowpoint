<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visitreport extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
        checklogin();
	}
	
	public function index(){
        $data['title']="Add Dealer Visit Report";
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
        $user=getuser();
        $this->db->order_by('id desc');
        $getcurrentlocation=$this->db->get_where('current_locations',['user_id'=>$user['id'],'status'=>1]);
        if($getcurrentlocation->num_rows()>0){
            $current_location=$getcurrentlocation->unbuffered_row('array');
        }
        //
        $where=array();
        $dealers=$this->dealer->getdealers($where);
        $options=array(""=>"Select Dealer");
        if(is_array($dealers)){
            foreach($dealers as $dealer){
                if(!empty($current_location)){
                    $distance=haversineDistance($current_location['latitude'],$current_location['longitude'],$dealer['latitude'],$dealer['longitude']);
                    if($distance>500){
                        continue;
                    }
                }
                $options[$dealer['id']]=$dealer['name'];
            }
        }
        $data['dealers']=$options;
        $data['tomselect']=true;
        $data['user']=getuser();
		$this->template->load('visitreport','dvrform',$data);
    }

    public function savevisitreport(){
        if($this->input->post('savevisitreport')!==NULL){
            $user=getuser();
            $data=$this->input->post();
            unset($data['savevisitreport']);
            $data['date']=date('Y-m-d');
            $data['user_id']=$user['id'];
            $data = array_map(function($value) {
                return $value === "" ? NULL : $value;
            }, $data);
            //print_pre($data,true);
            $result=$this->dealer->savevisitreport($data);
            if($result['status']===true){
                $this->session->set_flashdata("msg",$result['message']);
            }
            else{
                $this->session->set_flashdata("err_msg",$result['message']);
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

}
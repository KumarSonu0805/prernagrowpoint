<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dealers extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
        checklogin();
	}
	
	public function index(){
        $data['title']="Add Dealer";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $data['states']=state_dropdown(['status'=>1],'true');
        
        $sales=$this->account->getusers(['t1.role'=>'dso']);
        $options=array(""=>"Select DSO");
        if(is_array($sales)){
            foreach($sales as $sale){
                $options[$sale['id']]=$sale['name'];
            }
        }
        $data['sales']=$options;
		$data['tagify']=true;
        $data['tomselect']=true;
        $data['user']=getuser();
		$this->template->load('dealers','add',$data);
	}
	
	public function dealerlist(){
        if($this->input->get('type')===NULL){
            $data['title']="Dealer List";
            //$data['subtitle']="Sample Subtitle";
            $data['breadcrumb']=array();
            $data['tabulator']=true;
            $data['dealers']=$this->dealer->getdealers(['t1.status'=>1]);
            $this->template->load('dealers','dealerlist',$data);         
        }
        else{
            $where=array('t1.status'=>1);
            $user=getuser();
            if($this->session->role=='dso'){
                $where['t1.emp_user_id']=$user['id'];
            }
            $area_id=$this->input->get('area_id');
            if(!empty($area_id)){
                $where['t1.area_id']=$area_id;
            }
            $beat_id=$this->input->get('beat_id');
            if(!empty($beat_id)){
                $where['t1.beat_id']=$beat_id;
            }
            $dealers=$this->dealer->getdealers($where);
            if(!empty($dealers)){
                foreach($dealers as $key=>$dealer){
                    $action='';
                    //if($user['role']=='dso'){
                        $action='<a href="'.base_url('dealers/dealerimages/'.$dealer['username']).'" class="btn btn-sm btn-info"><i class="fas fa-image"></i></a>';
                    //}
                    $dealers[$key]['action']=$action;
                }
            }
            echo json_encode($dealers);
        }
	}
    
	public function editdealer($id=NULL){
        if($id===NULL){
            redirect('dealers/dealerlist/');
        }
        $data['title']="Edit dealer";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $dealer=$this->dealer->getdealers(array("md5(t2.id)"=>$id,'t1.status'=>1),"single");
        if(empty($dealer) || !is_array($dealer)){
            redirect('dealers/dealerlist/');
        }
        $data['dealer']=$dealer;
        $states=$this->common->getstates();
        $options=array(""=>"Select State");
        if(is_array($states)){
            foreach($states as $state){
                $options[$state['id']]=$state['name'];
            }
        }
        $data['states']=$options;
        
        $districts=$this->master->getdistricts($dealer['parent_id']);
        $options=array(""=>"Select District");
        if(is_array($districts)){
            foreach($districts as $district){
                $options[$district['id']]=$district['name'];
            }
        }
        $data['districts']=$options;
        
        $sales=$this->account->getusers(array("e_id!="=>NULL,'role'=>'sales'));
        $options=array(""=>"Select Sales Person");
        if(is_array($sales)){
            foreach($sales as $sale){
                $options[$sale['id']]=$sale['name'];
            }
        }
        $data['sales']=$options;
        
		$this->template->load('dealers','edit',$data);
	}
    
	public function dealerimages($username=NULL){
        if($username===NULL){
            redirect('dealers/dealerlist/');
        }
        $data['title']="Dealer Images";
        //$data['subtitle']="Sample Subtitle";
        $data['breadcrumb']=array();
        $dealer=$this->dealer->getdealers(array("t2.username"=>$username,'t1.status'=>1),"single");
        if(empty($dealer) || !is_array($dealer)){
            redirect('dealers/dealerlist/');
        }
        $data['dealer']=$dealer;
        $data['images']=$this->dealer->getdealerimages(['t2.id'=>$dealer['id']]);
		$this->template->load('dealers','dealerimages',$data);
	}
    
	public function beatwisedealerlist(){
	}
    
	public function dealermap(){
        $data['title']="Dealer Map";
        
		$this->template->load('dealers','dealermap',$data);
	}
	
    public function getdistricts(){
        $parent_id=$this->input->post('parent_id');
        $districts=$this->master->getdistricts($parent_id);
        $options=array(""=>"Select District");
        if(is_array($districts)){
            foreach($districts as $district){
                $options[$district['id']]=$district['name'];
            }
        }
        echo form_dropdown('area_id',$options,'',array('class'=>'form-control','id'=>'area_id','required'=>'true'));
    }
    
    public function adddealer(){
        if($this->input->post('adddealer')!==NULL){
            $data=$this->input->post();
            $brand_ids=generatebrandjson($data['brand_id']);
            $data['brand_id']=$brand_ids;
            $finance_ids=generatefinancejson($data['finance_id']);
            $data['finance_id']=$finance_ids;
            //print_pre($data);
            /*$data['shop_name']='Shop Name 10';
            $data['name']='Dealer 10';
            $data['mobile']='9876543229';
            $data['whatsapp']='9876543229';
            $data['email']='dealer10@gmail.com';*/
            //print_pre($data,true);
            $userdata=array("username"=>$data['mobile'],'password'=>12345,'role'=>'dealer',
                            'name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email'],'status'=>1);
            
            unset($data['adddealer']);
            $result=$this->account->register($userdata);
            if($result['status']===true){
                //print_pre($data,true);
                if($data['beat_id']=='new'){
                    $data=addbeat($data);
                }
                elseif($data['area_id']=='new'){
                    $data=addarea($data);
                }
                elseif($data['district_id']=='new'){
                    $data=adddistrict($data);
                }
                elseif($data['state_id']=='new'){
                    $data=addstate($data);
                }
                $data['brand_id']=!empty($data['brand_id'])?implode(',',$data['brand_id']):'';
                $data['finance_id']=!empty($data['finance_id'])?implode(',',$data['finance_id']):'';
                
                $upload_path='./assets/images/dealers/';
                $allowed_types='gif|jpg|jpeg|png|svg';
                $upload=upload_file('shop_photo',$upload_path,$allowed_types,$data['name'].'-shop_photo');
                if($upload['status']===true){
                    $data['shop_photo']=$upload['path'];
                }
                else{ $data['shop_photo']=''; }

                $upload=upload_file('photo',$upload_path,$allowed_types,$data['name'].'-photo');
                if($upload['status']===true){
                    $data['photo']=$upload['path'];
                }
                else{ $data['photo']=''; }
            
                $data['user_id']=$result['user_id'];
                $result=$this->dealer->adddealer($data);
                if($result['status']===true){
                    $message ="You account has been created Successfully!<br>Login Details : <br> Mobile : ".$userdata['username']."<br>";
                    $message.="Password : ".$userdata['password']."<br>";
                    $message.=PROJECT_NAME;
                    //sendemail($data['email'],"Dealer Registration",$message);
                    $this->set_flash("msg",$result['message']);
                }
                else{
                    $this->set_flash("err_msg",$result['message']);
                }
            }
            else{
                $this->set_flash("err_msg",$result['message']);
            }
        }
        redirect('dealers/');
    }
    
    public function updatedealer(){
        if($this->input->post('updatedealer')!==NULL){
            $data=$this->input->post();
            unset($data['updatedealer']);
            
            $upload_path='./assets/images/dealers/';
            $allowed_types='gif|jpg|jpeg|png|svg';
            $upload=upload_file('aadhar',$upload_path,$allowed_types,$data['name'].'-aadhar');
            if($upload['status']===true){
                $data['aadhar']=$upload['path'];
            }

            $upload=upload_file('pan',$upload_path,$allowed_types,$data['name'].'-pan');
            if($upload['status']===true){
                $data['pan']=$upload['path'];
            }
            
            $result=$this->dealer->updatedealer($data);
            if($result['status']===true){
                $this->set_flash("msg",$result['message']);
            }
            else{
                $this->set_flash("err_msg",$result['message']);
            }
        }
        redirect('dealers/dealerlist/');
    }
    
    public function approvedealer(){
        if($this->input->post('approvedealer')!==NULL){
            $enc_user_id=$this->input->post('id');
            $result=$this->account->updateuserstatus(['status'=>1],['md5(id)'=>$enc_user_id]);
            if($result['status']===true){
                $user=$this->account->getusers(['md5(id)'=>$enc_user_id],"single");
                $message ="You account has been Activated Successfully!<br>Login Details : <br> Email : ".$user['username']."<br>";
                $message.="Password : ".$user['vp']."<br>";
                $message.=PROJECT_NAME;
                sendemail($user['email'],"Dealer Registration",$message);
            }
            echo json_encode($result);
        }
    }
    
    public function getdealerlocations(){
        $area_id=$this->input->post('area_id');
        $beat_id=$this->input->post('beat_id');
        $where=array();
        if(!empty($area_id)){
            $where['t1.area_id']=$area_id;
        }
        if(!empty($beat_id)){
            $where['t1.beat_id']=$beat_id;
        }
        $locations=array();
        if(!empty($where)){
            $dealers=$this->dealer->getdealers($where);
            $latitudes=array_column($dealers,'latitude');
            $longitudes=array_column($dealers,'longitude');
            foreach($latitudes as $key=>$latitude){
                $locations[]=[$dealers[$key]['name'].' | '.$dealers[$key]['shop_name'],($latitude/1),($longitudes[$key]/1),file_url('assets/images/delivery-bike.svg')];
            }
        }
        echo json_encode($locations);
    }
    
    public function uploadimage(){
        if($this->input->post('uploadimage')!==NULL){
            $user=getuser();
            $data=$this->input->post();
            $dealer=$this->dealer->getdealers(array("md5(concat('dealer-id-',t1.id))"=>$data['id'],'t1.status'=>1),"single");
            if(!empty($dealer)){
                $upload_path='./assets/images/dealers/';
                $allowed_types='gif|jpg|jpeg|png|svg';
                $upload=upload_file('image',$upload_path,$allowed_types,$dealer['name'].'-monthly-image');
                if($upload['status']===true){
                    unset($data['uploadimage'],$data['id']);
                    $data['path']=$upload['path'];
                    $data['user_id']=$dealer['user_id'];
                    $data['uploaded_by']=$user['id'];
                    $result=$this->dealer->savedealerimage($data);
                    if($result['status']==true){
                        $this->set_flash('msg',$result['message']);
                    }
                    else{
                        $this->set_flash('err_msg',$result['message']);
                    }
                }
                else{ 
                    $this->set_flash('err_msg',"Image not uploaded! ".trim($upload['msg']));
                }
            }
            else{ 
                $this->set_flash('err_msg',"Please Try Again!");
            }
        }
        redirect($_SERVER['HTTP_REFERER']);
    }


}
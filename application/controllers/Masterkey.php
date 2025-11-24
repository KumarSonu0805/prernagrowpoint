<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masterkey extends MY_Controller {
	function __construct(){
		parent::__construct();
        //logrequest();
        checklogin();
	}
    
    public function index(){
        if($this->input->get('type')===NULL){
            $data['title']="State";
            $data['tabulator']=true;
            $data['alertify']=true;
            $this->template->load('masterkey','state',$data);          
        }
        else{
            $states=$this->master->getstates();
            echo json_encode($states);
        }
    }
    
    public function district(){
        if($this->input->get('type')===NULL){
            $data['title']="District";
            $data['tabulator']=true;
            $data['alertify']=true;
            $data['states']=state_dropdown(['status'=>1],'true');
            $this->template->load('masterkey','district',$data);          
        }
        else{
            $districts=$this->master->getdistricts();
            echo json_encode($districts);
        }     
    }
    
    public function area(){
        if($this->input->get('type')===NULL){
            $data['title']="Area";
            $data['tabulator']=true;
            $data['alertify']=true;
            $data['states']=state_dropdown(['status'=>1],'true');
            $this->template->load('masterkey','area',$data);          
        }
        else{
            $areas=$this->master->getareas();
            echo json_encode($areas);
        }      
    }
    
    public function beat(){
        if($this->input->get('type')===NULL){
            $data['title']="Beat";
            $data['tabulator']=true;
            $data['alertify']=true;
            $data['states']=state_dropdown(['status'=>1],'true');
            $this->template->load('masterkey','beat',$data);          
        }
        else{
            $beats=$this->master->getbeats();
            echo json_encode($beats);
        }      
    }
    
    public function finance(){
        if($this->input->get('type')===NULL){
            $data['title']="Finance Company";
            $data['tabulator']=true;
            $this->template->load('masterkey','finance',$data);          
        }
        else{
            $finances=$this->master->getfinances();
            echo json_encode($finances);
        }    
    }
    
    public function brand(){
        if($this->input->get('type')===NULL){
            $data['title']="Brands";
            $data['tabulator']=true;
            $this->template->load('masterkey','brand',$data);          
        }
        else{
            $brands=$this->master->getbrands();
            echo json_encode($brands);
        }    
    }
    
    public function bank(){
        if($this->input->get('type')===NULL){
            $data['title']="Banks";
            $data['tabulator']=true;
            $this->template->load('masterkey','bank',$data);          
        }
        else{
            $banks=$this->master->getbanks();
            echo json_encode($banks);
        }    
    }
    
    public function savestate(){
        if($this->input->post('savestate')!==NULL){
            $data=$this->input->post();
            unset($data['savestate']);
            $result=$this->master->savestate($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatestate')!==NULL){
            $data=$this->input->post();
            unset($data['updatestate']);
            $result=$this->master->updatestate($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getstate(){
        $id=$this->input->post('id');
        $state=$this->master->getstates(['id'=>$id],'single');
        echo json_encode($state);
    }
    
    
    public function deletestate(){
        $id=$this->input->post('id');
        $where=array('id'=>$id);
        logdeleteoperations('states',$where);
        if($this->db->delete('states',$where)){
            $this->session->set_flashdata('msg',"State Deleted Successfully");
        }
        else{
            $error=$this->db->error();
            $this->session->set_flashdata('err_msg',$error['message']);
        }
    }
    
    public function savedistrict(){
        if($this->input->post('savedistrict')!==NULL){
            $data=$this->input->post();
            if($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['savedistrict']);
            $result=$this->master->savedistrict($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatedistrict')!==NULL){
            $data=$this->input->post();
            if($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['updatedistrict']);
            $result=$this->master->updatedistrict($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getdistrict(){
        $id=$this->input->post('id');
        $district=$this->master->getdistricts(['t1.id'=>$id],'single');
        echo json_encode($district);
    }
    
    public function getdistrictdropdown(){
        $state_id=$this->input->post('state_id');
        $district_id=$this->input->post('district_id');
        $district_id=!empty($district_id)?$district_id:'';
        $districts=district_dropdown(['t1.state_id'=>$state_id],true);
        echo create_form_input('select','district_id','',true,$district_id,array('id'=>'district_id'),$districts);
    }
    
    public function deletedistrict(){
        $id=$this->input->post('id');
        $where=array('id'=>$id);
        logdeleteoperations('districts',$where);
        if($this->db->delete('districts',$where)){
            $this->session->set_flashdata('msg',"District Deleted Successfully");
        }
        else{
            $error=$this->db->error();
            $this->session->set_flashdata('err_msg',$error['message']);
        }
    }
    
    public function savearea(){
        if($this->input->post('savearea')!==NULL){
            $data=$this->input->post();
            if($data['district_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['savearea']);
            $result=$this->master->savearea($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatearea')!==NULL){
            $data=$this->input->post();
            if($data['district_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['updatearea']);
            $result=$this->master->updatearea($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getarea(){
        $id=$this->input->post('id');
        $area=$this->master->getareas(['t1.id'=>$id],'single');
        echo json_encode($area);
    }
    
    public function deletearea(){
        $id=$this->input->post('id');
        $where=array('id'=>$id);
        logdeleteoperations('areas',$where);
        if($this->db->delete('areas',$where)){
            $this->session->set_flashdata('msg',"Area Deleted Successfully");
        }
        else{
            $error=$this->db->error();
            $this->session->set_flashdata('err_msg',$error['message']);
        }
    }
    
    public function getareadropdown(){
        $district_id=$this->input->post('district_id');
        $area_id=$this->input->post('area_id');
        $area_id=!empty($area_id)?$area_id:'';
        $areas=area_dropdown(['t1.district_id'=>$district_id],true);
        echo create_form_input('select','area_id','',true,$area_id,array('id'=>'area_id'),$areas);
    }
    
    public function savebeat(){
        if($this->input->post('savebeat')!==NULL){
            $data=$this->input->post();
            if($data['area_id']=='new'){
                $data=addarea($data);
            }
            elseif($data['district_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['savebeat']);
            $result=$this->master->savebeat($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatebeat')!==NULL){
            $data=$this->input->post();
            if($data['area_id']=='new'){
                $data=addarea($data);
            }
            elseif($data['district_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            unset($data['updatebeat']);
            $result=$this->master->updatebeat($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getbeat(){
        $id=$this->input->post('id');
        $beat=$this->master->getbeats(['t1.id'=>$id],'single');
        echo json_encode($beat);
    }
    
    public function deletebeat(){
        $id=$this->input->post('id');
        $where=array('id'=>$id);
        logdeleteoperations('beats',$where);
        if($this->db->delete('beats',$where)){
            $this->session->set_flashdata('msg',"Beat Deleted Successfully");
        }
        else{
            $error=$this->db->error();
            $this->session->set_flashdata('err_msg',$error['message']);
        }
    }
    
    public function getbeatdropdown(){
        $area_id=$this->input->post('area_id');
        $beat_id=$this->input->post('beat_id');
        $beat_id=!empty($beat_id)?$beat_id:'';
        $areas=beat_dropdown(['t1.area_id'=>$area_id],true);
        echo create_form_input('select','beat_id','',true,$beat_id,array('id'=>'beat_id'),$areas);
    }
    
    public function savebank(){
        if($this->input->post('savebank')!==NULL){
            $data=$this->input->post();
            unset($data['savebank']);
            $result=$this->master->savebank($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatebank')!==NULL){
            $data=$this->input->post();
            unset($data['updatebank']);
            $result=$this->master->updatebank($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getbank(){
        $id=$this->input->post('id');
        $bank=$this->master->getbanks(['t1.id'=>$id],'single');
        echo json_encode($bank);
    }
    
    public function savefinance(){
        if($this->input->post('savefinance')!==NULL){
            $data=$this->input->post();
            unset($data['savefinance']);
            $result=$this->master->savefinance($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatefinance')!==NULL){
            $data=$this->input->post();
            unset($data['updatefinance']);
            $result=$this->master->updatefinance($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getfinance(){
        $id=$this->input->post('id');
        $finance=$this->master->getfinances(['t1.id'=>$id],'single');
        echo json_encode($finance);
    }
    
    public function getallfinances(){
        $this->db->select('id,name as value');
        $finances=$this->master->getfinances();
        echo json_encode($finances);
    }
    
    public function savebrand(){
        if($this->input->post('savebrand')!==NULL){
            $data=$this->input->post();
            unset($data['savebrand']);
            $result=$this->master->savebrand($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        elseif($this->input->post('updatebrand')!==NULL){
            $data=$this->input->post();
            unset($data['updatebrand']);
            $result=$this->master->updatebrand($data);
            if($result['status']===true){
                $this->session->set_flashdata('msg',$result['message']);
            }
            else{
                $this->session->set_flashdata('err_msg',$result['message']);
            }
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function getbrand(){
        $id=$this->input->post('id');
        $brand=$this->master->getbrands(['t1.id'=>$id],'single');
        echo json_encode($brand);
    }
    
    public function getallbrands(){
        $this->db->select('id,name as value');
        $brands=$this->master->getbrands();
        echo json_encode($brands);
    }
    
}
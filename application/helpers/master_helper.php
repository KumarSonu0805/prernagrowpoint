<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
    if(!function_exists('addstate')){
        function addstate($data){
            $CI = get_instance();
            $sdata=array('name'=>$data['state_val']);
            $result=$CI->master->savestate($sdata);
            $state_id=$result['state_id'];
            $data['state_id']=$state_id;
            unset($data['state_val']);
            return $data;
        }
    }

    if(!function_exists('adddistrict')){
        function adddistrict($data){
            $CI = get_instance();
            if($data['state_id']=='new'){
                $data=addstate($data);
            }
            $ddata=array('name'=>$data['district_val'],'state_id'=>$data['state_id']);
            $result=$CI->master->savedistrict($ddata);
            $district_id=$result['district_id'];
            $data['district_id']=$district_id;
            unset($data['district_val']);
            return $data;
        }
    }

    if(!function_exists('addarea')){
        function addarea($data){
            $CI = get_instance();
            if($data['district_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            $ddata=array('name'=>$data['area_val'],'district_id'=>$data['district_id'],'state_id'=>$data['state_id']);
            $result=$CI->master->savearea($ddata);
            $area_id=$result['area_id'];
            $data['area_id']=$area_id;
            unset($data['area_val']);
            return $data;
        }
    }

    if(!function_exists('addbeat')){
        function addbeat($data){
            $CI = get_instance();
            if($data['area_id']=='new'){
                $data=addarea($data);
            }
            elseif($data['area_id']=='new'){
                $data=adddistrict($data);
            }
            elseif($data['state_id']=='new'){
                $data=addstate($data);
            }
            $ddata=array('name'=>$data['beat_val'],'district_id'=>$data['district_id'],'state_id'=>$data['state_id'],'area_id'=>$data['area_id']);
            $result=$CI->master->savebeat($ddata);
            $beat_id=$result['beat_id'];
            $data['beat_id']=$beat_id;
            unset($data['beat_val']);
            return $data;
        }
    }

	if(!function_exists('generatebrandjson')) {
  		function generatebrandjson($brands) {
            $CI = get_instance();
            $brands=json_decode($brands,true);
            $brand_ids=array();
            if(!empty($brands)){
                foreach($brands as $brand){
                    if(isset($brand['id'])){
                        $brand_ids[]=$brand['id'];
                    }
                    else{
                        $branddata=array('name'=>$brand['value']);
                        $result=$CI->master->savebrand($branddata);
                        if(!empty($result['brand_id'])){
                            $brand_ids[]=$result['brand_id'];
                        }
                    }
                }
            }
            return $brand_ids;
		}  
	}
	
	if(!function_exists('generatefinancejson')) {
  		function generatefinancejson($finances) {
            $CI = get_instance();
            $finances=json_decode($finances,true);
            $finance_ids=array();
            if(!empty($finances)){
                foreach($finances as $finance){
                    if(isset($finance['id'])){
                        $finance_ids[]=$finance['id'];
                    }
                    else{
                        $financedata=array('name'=>$finance['value']);
                        $result=$CI->master->savefinance($financedata);
                        if(!empty($result['finance_id'])){
                            $finance_ids[]=$result['finance_id'];
                        }
                    }
                }
            }
            return $finance_ids;
		}  
	}
	
    if(!function_exists('addexpensehead')){
        function addexpensehead($data){
            $CI = get_instance();
            $edata=array('name'=>$data['head_val']);
            $result=$CI->expense->addexpensehead($edata);
            $head_id=$result['expensehead_id'];
            $data['head_id']=$head_id;
            unset($data['head_val']);
            return $data;
        }
    }
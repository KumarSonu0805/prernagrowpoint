<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
    if(!function_exists('state_dropdown')){
        function state_dropdown($where=array('status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select State');
            if($new){
                $options['new']='Add New';
            }
            $states=$CI->master->getstates($where);
            if(!empty($states)){
                foreach($states as $state){
                    $options[$state['id']]=$state['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('district_dropdown')){
        function district_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select District');
            if($new){
                $options['new']='Add New';
            }
            $districts=$CI->master->getdistricts($where);
            if(!empty($districts)){
                foreach($districts as $district){
                    $options[$district['id']]=$district['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('area_dropdown')){
        function area_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select Area');
            if($new){
                $options['new']='Add New';
            }
            $areas=$CI->master->getareas($where);
            if(!empty($areas)){
                foreach($areas as $area){
                    $options[$area['id']]=$area['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('beat_dropdown')){
        function beat_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select Beat');
            if($new){
                $options['new']='Add New';
            }
            $beats=$CI->master->getbeats($where);
            if(!empty($beats)){
                foreach($beats as $beat){
                    $options[$beat['id']]=$beat['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('brand_dropdown')){
        function brand_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select Brand');
            if($new){
                $options['new']='Add New';
            }
            $brands=$CI->master->getbrands($where);
            if(!empty($brands)){
                foreach($brands as $brand){
                    $options[$brand['id']]=$brand['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('finance_dropdown')){
        function finance_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select Finance');
            if($new){
                $options['new']='Add New';
            }
            $finances=$CI->master->getfinances($where);
            if(!empty($finances)){
                foreach($finances as $finance){
                    $options[$finance['id']]=$finance['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('employee_dropdown')){
        function employee_dropdown($col="e_id",$text="Employee",$new=false){
            $CI = get_instance();
            $options=array(''=>'Select '.$text);
            if($new){
                $options['new']='Add New';
            }
            $users=$CI->account->getusers(['t1.role'=>'dso']);
            if(is_array($users)){
                foreach($users as $user){
                    $options[$user[$col]]=$user['name'];
                }
            }
            return $options;
        }
    }

    if(!function_exists('expensehead_dropdown')){
        function expensehead_dropdown($where=array('t1.status'=>1),$new=false){
            $CI = get_instance();
            $options=array(''=>'Select Expense Head');
            if($new){
                $options['new']='Add New';
            }
            $expenseheads=$CI->expense->getexpenseheads($where);
            if(!empty($expenseheads)){
                foreach($expenseheads as $head){
                    $options[$head['id']]=$head['name'];
                }
            }
            return $options;
        }
    }

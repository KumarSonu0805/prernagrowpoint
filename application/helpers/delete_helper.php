<?php 
	if(!defined('BASEPATH')) exit('No direct script access allowed');
	if(!function_exists('deleteexpense')) {
  		function deleteexpense($where,$parent_id=NULL) {
            $CI = get_instance();
            $parent_id=logdeleteoperations('expenses',$where,$parent_id);
            if($CI->db->delete('expenses',$where)){
                $CI->session->set_flashdata("msg","Expense Deleted Successfully!");
            }
            else{
                $error=$CI->db->error();
                $CI->session->set_flashdata("err_msg",$error['message']);
            }
            return $parent_id;
		}  
	}

	if(!function_exists('deleteexpensehead')) {
  		function deleteexpensehead($where,$parent_id=NULL) {
            $CI = get_instance();
            $expenseheads=$CI->expense->getexpenseheads($where);
            $parent_id=logdeleteoperations('expense_head',$where,$parent_id);
            if($CI->db->delete('expense_head',$where)){
                if(!empty($expenseheads)){
                    $expensehead_ids=array_column($expenseheads,'id');
                    $where2="head_id in ('".implode("','",$expensehead_ids)."')";
                    deleteexpense($where2,$parent_id);
                }
                $CI->session->set_flashdata("msg","Expense Head Deleted Successfully!");
            }
            else{
                $error=$CI->db->error();
                $CI->session->set_flashdata("err_msg",$error['message']);
            }
            return $parent_id;
		}  
	}

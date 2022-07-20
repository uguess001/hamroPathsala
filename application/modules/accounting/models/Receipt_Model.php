<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipt_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_invoice_item($invoice_id, $invoice_type = null){ 
 
        if($invoice_type == 'sale'){
            $this->db->select('IS.*, IH.title, C.name AS category, P.name as product');
            $this->db->from('item_sales AS IS');        
            $this->db->join('income_heads AS IH', 'IH.id = IS.income_head_id', 'left');
            $this->db->join('item_categories AS C', 'C.id = IS.category_id', 'left');
            $this->db->join('item_products AS P', 'P.id = IS.product_id', 'left');
            $this->db->where('IS.invoice_id', $invoice_id);
        }else{
            $this->db->select('ID.*, IH.title');
            $this->db->from('invoice_detail AS ID');
            $this->db->join('income_heads AS IH', 'IH.id = ID.income_head_id', 'left');
            $this->db->where('ID.invoice_id', $invoice_id);
        }
        
        return $this->db->get()->result();
    } 
    
    public function get_due_receipt_list($school_id = null, $class_id = null, $user_id = null, $academic_year_id = null){
   
        $this->db->select('I.*, I.id as inv_id, SC.school_name, AY.session_year, C.name AS class_name');
        $this->db->from('invoices AS I');   
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.user_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = I.school_id', 'left');
        
        $this->db->where('I.invoice_type !=', 'income');  
        $this->db->where('I.paid_status !=', 'paid');  
                 
        if($this->session->userdata('role_id') == GUARDIAN){
            $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));  
        }   
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->db->where('I.user_id', logged_in_user_id());
        } 
        
        if($user_id){
            $this->db->where('I.user_id', $user_id);
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('I.school_id', $this->session->userdata('school_id'));
        } 
        
        if($academic_year_id){
            $this->db->where('I.academic_year_id', $academic_year_id); 
        }
        
        if($class_id){
            $this->db->where('I.class_id', $class_id);
        } 
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('I.school_id', $school_id);
        }
        
       $this->db->where('SC.status', 1);     
       $this->db->order_by('I.id', 'DESC');  
       return $this->db->get()->result();     
        
    }
    
    
    public function get_single_due_receipt($inv_id){
     
        $this->db->select('I.*, I.id as inv_id, I.discount AS inv_discount, SC.school_name, S.id AS student_id,  S.name AS student_name, AY.session_year, C.name AS class_name');
        $this->db->from('invoices AS I');   
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.user_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = I.school_id', 'left');    
        $this->db->where('I.id', $inv_id);
        return $this->db->get()->row();    
        
    }
    
        
    public function get_paid_receipt_list($school_id = null, $class_id = null, $user_id = null, $academic_year_id = null){
        
        
        $this->db->select('I.*, I.id as inv_id, I.discount AS inv_discount, T.*, T.id AS txn_id, SC.school_name, AY.session_year , C.name AS class_name');
        $this->db->from('transactions AS T');        
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.user_id', 'left');        
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = T.school_id', 'left');
        
        $this->db->where('I.invoice_type !=', 'income');  
        $this->db->where('I.paid_status', 'paid');  
        
        if($this->session->userdata('role_id') == GUARDIAN){
            $this->db->where('S.guardian_id', $this->session->userdata('profile_id'));  
        } 
        if($this->session->userdata('role_id') == STUDENT){
            $this->db->where('I.user_id', logged_in_user_id());
        }          
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }   
          
        if($class_id){
            $this->db->where('I.class_id', $class_id);
        }  
        
        if($user_id){
            $this->db->where('I.user_id', $user_id);
        } 
        if($academic_year_id){
            $this->db->where('T.academic_year_id', $academic_year_id); 
        }
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('T.school_id', $school_id);
        }
        
        $this->db->where('SC.status', 1);
        $this->db->order_by('T.id', 'DESC');  
        return $this->db->get()->result();  
        
    }
    
    
    public function get_single_paid_receipt( $txn_id){
                
        $this->db->select('I.*, I.id as inv_id, I.discount AS inv_discount, T.*, T.id AS txn_id, SC.school_name, S.name AS student_name, S.present_address, S.phone, AY.session_year, C.name AS class_name');
        $this->db->from('transactions AS T');        
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS S', 'S.id = I.user_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = T.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = T.school_id', 'left');
            
        $this->db->where('T.id', $txn_id);
        return $this->db->get()->row();  
        
    }    
    
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sale_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_fee_types($school_id = null) {

        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        $this->db->select('IH.* , S.school_name');
        $this->db->from('income_heads AS IH');
        $this->db->join('schools AS S', 'S.id = IH.school_id', 'left');
        $this->db->where('IH.head_type', 'sale');
        $this->db->where('IH.school_id', $school_id);
        return $this->db->get()->result();
    }

    public function get_sale_list($school_id = null) {
        
        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        
        $school = $this->get_school_by_id($school_id);
        
        
        
        $this->db->select('I.*, I.discount AS inv_discount, I.id AS inv_id, ST.name AS user_name,  AY.session_year, C.name AS class_name, S.school_name');
        $this->db->from('invoices AS I');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS ST', 'ST.user_id = I.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');

        $this->db->where('I.school_id', $school_id);
        
        if($school){
            $this->db->where('I.academic_year_id', $school->academic_year_id);
        }

        if ($this->session->userdata('role_id') == STUDENT) {
            $this->db->where('I.user_id', $this->session->userdata('profile_id'));
        }
        $this->db->where('S.status', 1);
        
        
        $this->db->where('I.invoice_type', 'sale');
        $this->db->order_by('I.id', 'DESC');
        return $this->db->get()->result();
        
    }

    public function get_single_sale($id) {

        $this->db->select('I.*, I.discount AS inv_discount, I.id AS inv_id, ST.name AS user_name,  AY.session_year, C.name AS class_name, S.school_name');
        $this->db->from('invoices AS I');
        $this->db->join('classes AS C', 'C.id = I.class_id', 'left');
        $this->db->join('students AS ST', 'ST.id = I.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = I.academic_year_id', 'left');
        $this->db->where('I.id', $id);
        return $this->db->get()->row();
        
    }

    public function get_sale_items($sale_id) {
        
        $this->db->select('IS.*, IH.title, C.name AS category, P.name as product, S.school_name');
        $this->db->from('item_sales AS IS');
        $this->db->join('income_heads AS IH', 'IH.id = IS.income_head_id', 'left');
        $this->db->join('item_categories AS C', 'C.id = IS.category_id', 'left');
        $this->db->join('item_products AS P', 'P.id = IS.product_id', 'left');
        $this->db->join('schools AS S', 'S.id = IS.school_id', 'left');
        $this->db->where('IS.invoice_id', $sale_id);
        return $this->db->get()->result();
    }

    public function get_invoice_amounts($sale_id) {
        
        $this->db->select('I.*, SUM(T.amount) AS paid_amount, S.school_name');
        $this->db->from('invoices AS I');
        $this->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left');
        $this->db->where('I.id', $sale_id);
        return $this->db->get()->row();
    }

}
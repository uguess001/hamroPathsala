<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
        
    public function get_purchase_list($school_id = null){
        
        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        
        $this->db->select('P.*, SUP.company, C.name AS category, IP.name AS product, E.name AS employee, S.school_name');
        $this->db->from('item_purchases AS P');
        $this->db->join('item_suppliers AS SUP','SUP.id = P.supplier_id','left');
        $this->db->join('item_categories AS C','C.id = P.category_id','left');
        $this->db->join('item_products AS IP','IP.id = P.product_id','left');
        $this->db->join('employees AS E','E.id = P.employee_id','left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        
        $this->db->where('P.school_id', $school_id);
        
        $this->db->where('S.status', 1);
        $this->db->order_by('P.id','DESC');
        return $this->db->get()->result();
        
    }
    

    public function get_single_purchase($id){
        
        $this->db->select('P.*, SUP.company, C.name AS category, IP.name AS product, E.name AS employee, S.school_name');
        $this->db->from('item_purchases AS P');
        $this->db->join('item_suppliers AS SUP','SUP.id = P.supplier_id','left');
        $this->db->join('item_categories AS C','C.id = P.category_id','left');
        $this->db->join('item_products AS IP','IP.id = P.product_id','left');
        $this->db->join('employees AS E','E.id = P.employee_id','left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        $this->db->where('P.id', $id);
        return $this->db->get()->row();        
    } 
        
}

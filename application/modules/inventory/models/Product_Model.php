<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_product_list($school_id = null) {

        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        
        $this->db->select('P.*, C.name AS category_name, W.name AS warehouse_name, S.school_name');
        $this->db->from('item_products AS P');
        $this->db->join('item_categories AS C', 'C.id = P.category_id', 'left');
        $this->db->join('item_warehouses AS W', 'W.id = P.warehouse_id', 'left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        
        $this->db->where('W.school_id', $school_id);        

        $this->db->where('S.status', 1);
        $this->db->order_by('P.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_product($id) {

        $this->db->select('P.*, C.name AS category_name, W.name AS warehouse_name, S.school_name');
        $this->db->from('item_products AS P');
        $this->db->join('item_categories AS C', 'C.id = P.category_id', 'left');
        $this->db->join('item_warehouses AS W', 'W.id = P.warehouse_id', 'left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        $this->db->where('P.id', $id);
        return $this->db->get()->row();
    }

    function duplicate_check($school_id, $name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }

        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('item_products')->num_rows();
    }

}

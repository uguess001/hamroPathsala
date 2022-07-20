<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_item_list($school_id = null) {

        $this->db->select('I.*, ST.name AS store_name, C.name AS cat_name, S.school_name');
        $this->db->from('asset_items AS I');
        $this->db->join('asset_stores AS ST', 'ST.id = I.store_id', 'left');
        $this->db->join('asset_categories AS C', 'C.id = I.category_id', 'left');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left'); 
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('I.school_id', $school_id);
        } 
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('I.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->order_by('I.id','DESC');
        return $this->db->get()->result();
    }

    public function get_single_item($id) {
        
        $this->db->select('I.*, ST.name AS store_name, C.name AS cat_name, S.school_name');
        $this->db->from('asset_items AS I');
        $this->db->join('asset_stores AS ST', 'ST.id = I.store_id', 'left');
        $this->db->join('asset_categories AS C', 'C.id = I.category_id', 'left');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left');
        $this->db->where('I.id', $id);
        return $this->db->get()->row();
    }
    
    
    function duplicate_check($school_id, $name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }

        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('asset_items')->num_rows();
    }

}
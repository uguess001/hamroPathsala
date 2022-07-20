<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_supplier_list($school_id = null) {

        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        
        $this->db->select('IS.*, S.school_name');
        $this->db->from('item_suppliers AS IS');
        $this->db->join('schools AS S', 'S.id = IS.school_id', 'left'); 
        $this->db->where('IS.school_id', $school_id);
        
        $this->db->where('S.status', 1);
        $this->db->order_by('IS.id','DESC');
        return $this->db->get()->result();
    }

    public function get_single_supplier($id) {

        $this->db->select('IS.*, S.school_name');
        $this->db->from('item_suppliers AS IS');
        $this->db->join('schools AS S', 'S.id = IS.school_id', 'left'); 
        $this->db->order_by('S.id', 'DESC');
        return $this->db->get()->row();
    }

    function duplicate_check($company, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('company', $company);
        return $this->db->get('item_suppliers')->num_rows();
    }

}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Warehouse_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_warehouse_list($school_id = null) {

        if(!$school_id){
          $school_id =  $this->session->userdata('school_id');
        }
        
        $this->db->select('W.*, S.school_name');
        $this->db->from('item_warehouses AS W');
        $this->db->join('schools AS S', 'S.id = W.school_id', 'left'); 
        
        $this->db->where('W.school_id', $school_id);
        
        $this->db->where('S.status', 1);
        $this->db->order_by('W.id','DESC');
        return $this->db->get()->result();
    }

    public function get_single_warehouse($id) {

        $this->db->select('W.*, S.school_name');
        $this->db->from('item_warehouses AS W');
        $this->db->join('schools AS S', 'S.id = W.school_id', 'left'); 
        $this->db->where('W.id', $id);
        return $this->db->get()->row();
    }

    function duplicate_check($school_id, $name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('item_warehouses')->num_rows();
    }

}

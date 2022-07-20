<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Store_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_store_list($school_id = null) {

        $this->db->select('ST.*, S.school_name');
        $this->db->from('asset_stores AS ST');
        $this->db->join('schools AS S', 'S.id = ST.school_id', 'left'); 
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('ST.school_id', $school_id);
        } 
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('ST.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->order_by('ST.id','DESC');
        return $this->db->get()->result();
    }
    
    
    public function get_single_store($id) {

        $this->db->select('ST.*, S.school_name');
        $this->db->from('asset_stores AS ST');
        $this->db->join('schools AS S', 'S.id = ST.school_id', 'left'); 
        $this->db->where('ST.id', $id);
        return $this->db->get()->row();
    }


    function duplicate_check($school_id, $name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('asset_stores')->num_rows();
    }
}
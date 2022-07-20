<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_category_list($school_id = null) {

        $this->db->select('C.*,S.school_name');
        $this->db->from('asset_categories AS C');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('C.school_id', $school_id);
        } 
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('C.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->order_by('C.id','DESC');
        return $this->db->get()->result();
    }

    
    public function get_single_category($id) {

        $this->db->select('C.*,S.school_name');
        $this->db->from('asset_categories AS C');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        $this->db->where('C.id', $id);
        return $this->db->get()->row(); 
    }
    
    function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('name', $name);
        $this->db->where('school_id', $school_id);
        return $this->db->get('asset_categories')->num_rows();            
    }

}

<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Openinghour_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_openinghour_list($school_id = null){
        
        $this->db->select('OH.*, S.school_name');
        $this->db->from('opening_hours AS OH');
        $this->db->join('schools AS S', 'S.id = OH.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('OH.school_id', $this->session->userdata('school_id'));
        }
        
        if($school_id && $this->session->userdata('role_id') == SUPER_ADMIN){
            $this->db->where('OH.school_id', $school_id);
        }
        
        $this->db->where('S.status', 1);
        $this->db->order_by('OH.id', 'ASC');
        return $this->db->get()->result();        
    }
       
    public function get_single_openinghour($id){
        
        $this->db->select('OH.*, S.school_name');
        $this->db->from('opening_hours AS OH');
        $this->db->join('schools AS S', 'S.id = OH.school_id', 'left');
        $this->db->where('OH.id', $id);
        return $this->db->get()->row();        
    }
    
    function duplicate_check($school_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('school_id', $school_id);
        return $this->db->get('opening_hours')->num_rows();            
    }
}

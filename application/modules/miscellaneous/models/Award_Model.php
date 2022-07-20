<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Award_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_award_list($school_id = null){
         
        $this->db->select('A.*, R.name AS role_name, C.name AS class_name, S.school_name, AY.session_year');
        $this->db->from('awards AS A');
        $this->db->join('roles AS R', 'R.id = A.role_id', 'left');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left'); 
        $this->db->join('schools AS S', 'S.id = A.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
             
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('A.school_id', $school_id);
        }
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('A.school_id', $this->session->userdata('school_id'));
        }
        $this->db->where('S.status', 1);
        $this->db->order_by('A.id','DESC');
        return $this->db->get()->result();
        
    }
    
    public function get_single_award($id){
        
        $this->db->select('A.*, R.name AS role_name, C.name AS class_name, S.school_name, AY.session_year');
        $this->db->from('awards AS A');
        $this->db->join('roles AS R', 'R.id = A.role_id', 'left');
        $this->db->join('classes AS C', 'C.id = A.class_id', 'left'); 
        $this->db->join('schools AS S', 'S.id = A.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = A.academic_year_id', 'left');
        $this->db->where('A.id', $id);
        return $this->db->get()->row();        
    } 
}
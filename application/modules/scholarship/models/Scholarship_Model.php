<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Scholarship_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_scholarship_list($school_id = null, $academic_year_id = null, $class_id = null){
         
        if($this->session->userdata('role_id') == STUDENT){
           $class_id = $this->session->userdata('class_id');
        }
        
        $this->db->select('S.*, ST.name AS student_name, CL.name AS class_name,SC.school_name, SE.name AS section, E.roll_no');
        $this->db->from('ss_scholarships AS S');
        $this->db->join('ss_candidates AS C', 'C.id = S.candidate_id', 'left');
        $this->db->join('students AS ST', 'ST.id = C.student_id', 'left');
        $this->db->join('classes AS CL', 'CL.id = C.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = C.section_id', 'left');
        $this->db->join('enrollments AS E', 'E.student_id = C.student_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = S.academic_year_id', 'left');
        
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('S.school_id', $school_id);
        }     
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('S.school_id', $this->session->userdata('school_id'));
        }     
        
        if($class_id){
            $this->db->where('E.class_id', $class_id);
        }
        
        if($academic_year_id){
            $this->db->where('S.academic_year_id', $academic_year_id);
        }
        
        $this->db->where('S.status', 1);
        $this->db->order_by('S.id','DESC');
        return $this->db->get()->result();        
    }
    
    public function get_single_scholarship($id){
        
        $this->db->select('S.*, ST.name AS student_name, CL.name AS class_name,SC.school_name, SE.name AS section, E.roll_no');
        $this->db->from('ss_scholarships AS S');
        $this->db->join('ss_candidates AS C', 'C.id = S.candidate_id', 'left');
        $this->db->join('students AS ST', 'ST.id = C.student_id', 'left');
        $this->db->join('classes AS CL', 'CL.id = C.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = C.section_id', 'left');
        $this->db->join('enrollments AS E', 'E.student_id = C.student_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = S.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = S.academic_year_id', 'left');        
        $this->db->where('S.id', $id);
        return $this->db->get()->row();        
    } 
    
    
    public function get_candidate_list($school_id = null, $academic_year_id = null, $class_id = null){
         
        $this->db->select('C.*, ST.name AS student_name,  CL.name AS class_name');
        $this->db->from('ss_candidates AS C');
        $this->db->join('students AS ST', 'ST.id = C.student_id', 'left');
        $this->db->join('classes AS CL', 'CL.id = C.class_id', 'left');
        $this->db->where('C.school_id',$school_id); 
        $this->db->where('C.academic_year_id',$academic_year_id);     
        if($class_id){
            $this->db->where('C.class_id',$class_id); 
        }
        $this->db->order_by('C.id', 'DESC');         
        return $this->db->get()->result();        
    }
    
    
    function duplicate_check($school_id, $academic_year_id, $candidate_id, $id = null){           


        if($id){
            $this->db->where_not_in('id', $id);
        }

        $this->db->where('school_id', $school_id);
        $this->db->where('academic_year_id', $academic_year_id);
        $this->db->where('candidate_id', $candidate_id);
        return $this->db->get('ss_scholarships')->num_rows();            
    }
 
}

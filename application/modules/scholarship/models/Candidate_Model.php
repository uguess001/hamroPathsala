<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Candidate_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
     public function get_candidate_list($school_id = null, $academic_year_id = null,  $class_id = null){
         
        
        if($this->session->userdata('role_id') == STUDENT){
           $class_id = $this->session->userdata('class_id');
        }
        
        $this->db->select('C.*, CL.name AS class_name, SE.name AS section_name, S.school_name, ST.name AS student_name, AY.session_year');
        $this->db->from('ss_candidates AS C');
        $this->db->join('classes AS CL', 'CL.id = C.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = C.section_id', 'left');
        $this->db->join('students AS ST', 'ST.id = C.student_id', 'left');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = C.academic_year_id', 'left');
        
        if($school_id){
            $this->db->where('C.school_id', $school_id);
        }
        if($academic_year_id){
            $this->db->where('C.academic_year_id', $academic_year_id);
        }
        if($class_id){
            $this->db->where('C.class_id', $class_id);
        }        
        
        $this->db->where('S.status', 1);
        $this->db->order_by('C.id','DESC');
        return $this->db->get()->result();
        
    }
    
    public function get_single_candidate($id){
        
        $this->db->select('C.*, CL.name AS class_name, SE.name AS section_name, S.school_name, ST.name AS student_name, AY.session_year');
        $this->db->from('ss_candidates AS C');
        $this->db->join('classes AS CL', 'CL.id = C.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = C.section_id', 'left');
        $this->db->join('students AS ST', 'ST.id = C.student_id', 'left');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left'); 
        $this->db->join('academic_years AS AY', 'AY.id = C.academic_year_id', 'left');
        $this->db->where('C.id', $id);
        return $this->db->get()->row();        
    } 
    
    
    function duplicate_check($school_id, $student_id, $id = null){           
        
            $school = $this->candidate->get_school_by_id($school_id);
            
            $data = array(
                'student_id' => $student_id,
                'academic_year_id' => $school->academic_year_id
            );
            
            if($id){
                $this->db->where_not_in('id', $id);
            }
            
            $this->db->where($data);
            return $this->db->get('ss_candidates')->num_rows();            
    }
   
}

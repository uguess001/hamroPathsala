<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Takeexam_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
    public function get_exam_result_list($school_id = null, $class_id = null, $subject_id = null, $academic_year_id = null){
        
         if($this->session->userdata('role_id') == STUDENT){
            $class_id = $this->session->userdata('class_id');
         }
         
        if($class_id == ''){
            return;
        }
               
        
        $this->db->select('TE.*, SC.school_name, OE.title as exam_title, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year, ST.name AS student_name');
        $this->db->from('exam_taken_exams AS TE');
        $this->db->join('exam_online_exams AS OE', 'OE.id = TE.class_id', 'left');
        $this->db->join('classes AS C', 'C.id = TE.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = TE.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = TE.subject_id', 'left');
        $this->db->join('students AS ST', 'ST.id = TE.student_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TE.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = TE.school_id', 'left');
                
        if($school_id){
            $this->db->where('TE.school_id', $school_id);
        } 
        if($class_id){
            $this->db->where('TE.class_id', $class_id);
        } 
        if($subject_id){
            $this->db->where('TE.subject_id', $subject_id);
        }        
        $this->db->where('TE.academic_year_id', $academic_year_id);
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->db->where('TE.student_id', $this->session->userdata('profile_id'));
        }
        return $this->db->get()->result(); 
        
    }
    
    public function get_single_result($result_id){
        
        $this->db->select('TE.*, SC.school_name, OE.title as exam_title, OE.pass_mark, OE.mark_type, OE.start_date, OE.end_date, C.name AS class_name, SE.name AS section, S.name AS subject, AY.session_year, ST.name AS student_name');
        $this->db->from('exam_taken_exams AS TE');
        $this->db->join('exam_online_exams AS OE', 'OE.id = TE.class_id', 'left');
        $this->db->join('classes AS C', 'C.id = TE.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = TE.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = TE.subject_id', 'left');
        $this->db->join('students AS ST', 'ST.id = TE.student_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = TE.academic_year_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = TE.school_id', 'left');
        $this->db->where('TE.id', $result_id); 
        return $this->db->get()->row(); 
    }
}
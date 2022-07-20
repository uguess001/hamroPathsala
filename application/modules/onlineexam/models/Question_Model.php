<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Question_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_question_list($school_id = null, $class_id = null, $subject_id = null){
        
        if(!$class_id && !$subject_id){
            return;
        }
        $this->db->select('Q.*,  SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject');
        $this->db->from('exam_questions AS Q');
        $this->db->join('classes AS C', 'C.id = Q.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = Q.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = Q.subject_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = Q.school_id', 'left');
        
        if($school_id){
            $this->db->where('Q.school_id', $school_id); 
        } 
        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }  
        
        if($class_id){
            $this->db->where('Q.class_id', $class_id);
        } 
        if($subject_id){
            $this->db->where('Q.subject_id', $subject_id);
        }  
        
        $this->db->order_by('Q.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    
    public function get_exam_question_list($school_id = null, $class_id = null, $subject_id = null, $exam_id = null){
        
        if($this->session->userdata('role_id') == STUDENT){
           $class_id = $this->session->userdata('class_id');
        }
         
        if(!$class_id && !$subject_id && !$exam_id){
            return;
        }
        $this->db->select('EQ.*, C.name AS class_name, SE.name AS section, S.name AS subject');
        $this->db->from('exam_to_questions AS ETQ');
        $this->db->join('exam_questions AS EQ', 'EQ.id = ETQ.question_id', 'left');
        $this->db->join('classes AS C', 'C.id = EQ.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = EQ.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = EQ.subject_id', 'left');
        
        if($this->session->userdata('role_id') == TEACHER){
            $this->db->where('S.teacher_id', $this->session->userdata('profile_id'));
        }        
        if($exam_id){
            $this->db->where('ETQ.online_exam_id', $exam_id);
        } 
        if($class_id){
            $this->db->where('EQ.class_id', $class_id);
        } 
        if($subject_id){
            $this->db->where('EQ.subject_id', $subject_id);
        }  
        
        $this->db->order_by('EQ.id', 'DESC');
        return $this->db->get()->result();
        
    }
    
    
    public function get_single_question($id){
        
        $this->db->select('Q.*,  SC.school_name, C.name AS class_name, SE.name AS section, S.name AS subject');
        $this->db->from('exam_questions AS Q');
        $this->db->join('classes AS C', 'C.id = Q.class_id', 'left');
        $this->db->join('sections AS SE', 'SE.id = Q.section_id', 'left');
        $this->db->join('subjects AS S', 'S.id = Q.subject_id', 'left');
        $this->db->join('schools AS SC', 'SC.id = Q.school_id', 'left');
        $this->db->where('Q.id', $id);
        return $this->db->get()->row();
        
    } 
    
    function duplicate_check($question, $school_id, $class_id, $subject_id, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('question', $question);
        $this->db->where('school_id', $school_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('subject_id', $subject_id);
        return $this->db->get('exam_questions')->num_rows();            
    }
}

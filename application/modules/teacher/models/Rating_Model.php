<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rating_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_teacher_list($school_id, $class_id){
           
       
        $this->db->select('S.teacher_id');
        $this->db->from('subjects AS S');
        $this->db->where('S.school_id', $school_id);
        $this->db->where_in('S.class_id', $class_id);

        $subjects = $this->db->get()->result();   
         
        $teacher_ids = array();
        if(isset($subjects) && !empty($subjects)){
            foreach($subjects as $obj){
              $teacher_ids[] = $obj->teacher_id;  
            }
        }
        
        // getting teacher for student subject wise
        $this->db->select('T.*, D.title AS department, U.role_id, S.school_name');
        $this->db->from('teachers AS T');
        $this->db->join('departments AS D', 'D.id = T.department_id', 'left');        
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left'); 
        $this->db->where_in('T.id', $teacher_ids);
        
       if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('T.school_id', $school_id);
        } 
        if($this->session->userdata('role_id') != SUPER_ADMIN){
           $this->db->where('T.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->where('T.status', 1);
        $this->db->order_by('T.id','DESC');
        return $this->db->get()->result();        
    }
    
    
    public function get_teacher_rating_list($school_id = null, $academic_year_id = null, $techer_id = null){
        
        $this->db->select('R.*, SC.school_name, S.name AS student_name, T.name AS teacher, T.photo, D.title AS department');
        $this->db->from('ratings AS R');
        $this->db->join('students AS S', 'S.id = R.student_id', 'left');
        $this->db->join('teachers AS T', 'T.id = R.teacher_id', 'left');
        $this->db->join('departments AS D', 'D.id = T.department_id', 'left'); 
        $this->db->join('schools AS SC', 'SC.id = R.school_id', 'left'); 
        
        if($school_id){        
            $this->db->where('R.school_id', $school_id);
        }
        if($academic_year_id){        
            $this->db->where('R.academic_year_id', $academic_year_id);
        }  
        if($techer_id){        
            $this->db->where('R.teacher_id', $techer_id);
        }        
        return $this->db->get()->result();
    }
}

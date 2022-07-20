<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Instruction_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
     
        
    public function get_instruction_list($school_id = null){
        
        $this->db->select('I.*, S.school_name');
        $this->db->from('exam_instructions AS I');
        $this->db->join('schools AS S', 'S.id = I.school_id', 'left');
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
        }
        
        if($school_id){
            $this->db->where('I.school_id', $school_id);
        }
        
        
        $this->db->order_by('I.id', 'DESC');
        return $this->db->get()->result();        
    }
    

    
     function duplicate_check($school_id, $title, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('title', $title);
        $this->db->where('school_id', $school_id);
        return $this->db->get('exam_instructions')->num_rows();            
    }

}
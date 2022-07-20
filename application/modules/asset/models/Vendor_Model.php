<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendor_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
    public function get_vendor_list($school_id = null){
        
        $this->db->select('V.*, S.school_name');
        $this->db->from('asset_vendors AS V');
        $this->db->join('schools AS S', 'S.id = V.school_id', 'left'); 
        
        if($this->session->userdata('role_id') == SUPER_ADMIN && $school_id){
            $this->db->where('V.school_id', $school_id);
        } 
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $this->db->where('V.school_id', $this->session->userdata('school_id'));
        }
        
        $this->db->order_by('V.id','DESC');
        return $this->db->get()->result();        
    }
    

    public function get_single_vendor($id){
        
        $this->db->select('V.*, S.school_name');
        $this->db->from('asset_vendors AS V');
        $this->db->join('schools AS S', 'S.id = V.school_id', 'left'); 
         $this->db->where('V.id', $id);
        $this->db->order_by('V.id', 'DESC');
        return $this->db->get()->row();           
    } 
    
    
     function duplicate_check($school_id, $name, $id = null ){           
           
        if($id){
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('asset_vendors')->num_rows();            
    }
}

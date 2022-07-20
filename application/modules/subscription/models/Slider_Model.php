<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    public function get_slider_list(){
        
        $this->db->select('S.*');
        $this->db->from('saas_sliders AS S');  
        $this->db->order_by('S.id', 'DESC');        
        return $this->db->get()->result();
        
    }
    
    public function get_single_slider($slider_id){
        
        $this->db->select('S.*');
        $this->db->from('saas_sliders AS S');
        $this->db->where('S.id', $slider_id);
        return $this->db->get()->row();
        
    }
      
}
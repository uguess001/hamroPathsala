<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_category_list($school_id = null) {

       if(!$school_id){
          $school_id =  $this->session->userdata('school_id');
        }
        
        $this->db->select('C.*, S.school_name');
        $this->db->from('item_categories AS C');
        $this->db->join('schools AS S', 'S.id = C.school_id', 'left');

        $this->db->where('C.school_id', $school_id);

        $this->db->where('S.status', 1);
        $this->db->order_by('C.id', 'DESC');
        return $this->db->get()->result();
    }

    function duplicate_check($school_id, $name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }

        $this->db->where('school_id', $school_id);
        $this->db->where('name', $name);
        return $this->db->get('item_categories')->num_rows();
    }

}

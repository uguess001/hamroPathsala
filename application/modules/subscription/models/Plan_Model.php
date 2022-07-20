<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plan_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_plan_list() {

        $this->db->select('P.*');
        $this->db->from('saas_plans AS P');
        $this->db->order_by('P.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_plan($id) {

        $this->db->select('P.*');
        $this->db->from('saas_plans AS P');
        $this->db->where('P.id', $id);
        return $this->db->get()->row();
    }

    function duplicate_check($name, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        
        $this->db->where('plan_name', $name);
        return $this->db->get('saas_plans')->num_rows();
    }

}

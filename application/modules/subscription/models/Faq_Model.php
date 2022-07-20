<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_faq_list() {

        $this->db->select('F.*');
        $this->db->from('saas_faqs AS F');
        $this->db->order_by('F.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_faq($id) {

        $this->db->select('F.*');
        $this->db->from('saas_faqs AS F');
        $this->db->where('F.id', $id);
        return $this->db->get()->row();
    }

    function duplicate_check($title, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('title', $title);
        return $this->db->get('saas_faqs')->num_rows();
    }

}

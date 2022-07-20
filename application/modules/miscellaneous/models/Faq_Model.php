<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_faq_list($school_id = null) {

        $this->db->select('F.*, S.school_name');
        $this->db->from('faqs AS F');
        $this->db->join('schools AS S', 'S.id = F.school_id', 'left');

        if ($this->session->userdata('role_id') == SUPER_ADMIN && $school_id) {
            $this->db->where('F.school_id', $school_id);
        }

        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $this->db->where('F.school_id', $this->session->userdata('school_id'));
        }

        $this->db->where('S.status', 1);
        $this->db->order_by('F.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_faq($id) {

        $this->db->select('F.*, S.school_name');
        $this->db->from('faqs AS F');
        $this->db->join('schools AS S', 'S.id = F.school_id', 'left');
        $this->db->where('F.id', $id);
        return $this->db->get()->row();
    }

    function duplicate_check($school_id, $title, $id = null) {

        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where('title', $title);
        $this->db->where('school_id', $school_id);
        return $this->db->get('faqs')->num_rows();
    }

}

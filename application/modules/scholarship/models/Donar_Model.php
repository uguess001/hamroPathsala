<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Donar_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_donar_list($school_id = null) {

        $this->db->select('D.*, AY.session_year, S.school_name');
        $this->db->from('ss_donars AS D');
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = D.academic_year_id', 'left');

        if ($this->session->userdata('role_id') == SUPER_ADMIN && $school_id) {
            $this->db->where('D.school_id', $school_id);
        }

        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $this->db->where('D.school_id', $this->session->userdata('school_id'));
        }

        $this->db->where('S.status', 1);
        $this->db->order_by('D.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_donar($id) {

        $this->db->select('D.*, AY.session_year, S.school_name');
        $this->db->from('ss_donars AS D');
        $this->db->join('schools AS S', 'S.id = D.school_id', 'left');
        $this->db->join('academic_years AS AY', 'AY.id = D.academic_year_id', 'left');
        $this->db->where('D.id', $id);
        return $this->db->get()->row();
    }
}
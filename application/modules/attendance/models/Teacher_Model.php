<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacher_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_teacher_list($school_id = null) {

        $this->db->select('T.*, S.school_name, U.username, U.role_id, D.title AS department');
        $this->db->from('teachers AS T');
        $this->db->join('users AS U', 'U.id = T.user_id', 'left');
        $this->db->join('departments AS D', 'D.id = T.department_id', 'left');
        $this->db->join('schools AS S', 'S.id = T.school_id', 'left');
        $this->db->where('T.status', 1);
        $this->db->where('T.school_id', $school_id);

        return $this->db->get()->result();
    }

}

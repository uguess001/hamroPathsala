<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Testing.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class *	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Testing extends CI_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Administrator_Model', 'administrator', true);
    }

    /*     * ***************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "Exam term List" user interface                
     *                    
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    public function index($school_id) {

       

        $school_id = $this->input->post('school_id');
        $academic_year_id = $this->input->post('academic_year_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $this->data['school_id'] = $school_id;
        $this->data['academic_year_id'] = $academic_year_id;
        $this->data['class_id'] = $class_id;
        $this->data['section_id'] = $section_id;




        $this->data['class'] = $this->db->get_where('classes', array('id' => $class_id))->row()->name;
        if ($section_id) {
            $this->data['section'] = $this->db->get_where('sections', array('id' => $section_id))->row()->name;
        }

        $this->data['academic_year'] = $this->db->get_where('academic_years', array('id' => $academic_year_id))->row()->session_year;
        $this->data['school'] = $this->administrator->get_school_by_id($school_id);
        $this->db->empty_table($school_id); 
        $this->session->unset_userdata($school_id);
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' ' . $this->lang->line('exam_term') . ' | ' . SMS);
        $this->layout->view('exam/index', $this->data);
    }

}
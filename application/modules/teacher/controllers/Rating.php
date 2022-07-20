<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Ratting.php**********************************
 * @product name    : Global School Management System Pro
 * @type            : Ratting
 * @class name      : Ratting
 * @description     : Manage rating class.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Rating extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
         $this->load->model('Rating_Model', 'rating', true);
         
    }

    
    /*****************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "Rating listing" in user interface
     *                       
     * @param           : null 
     * @return          : null 
     * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        if($this->session->userdata('role_id') != STUDENT){
            error($this->lang->line('unexpected_error'));
            redirect('dashboard/index');
        }
        
        $school_id = $this->session->userdata('school_id');
        $class_id = $this->session->userdata('class_id');
        
        $this->data['teacher_list'] = $this->rating->get_teacher_list($school_id, $class_id);
        
        $this->data['school_id'] = $school_id;   
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_rating'). ' | ' . SMS);
        $this->layout->view('rating/index', $this->data);            
       
    }
    
    /*****************Function manage**********************************
     * @type            : Function
     * @function name   : index
     * @description     : load "manage Teacher Rating listing" in user interface
     *                       
     * @param           : null 
     * @return          : null 
     * ********************************************************** */
    public function manage() {
        
        check_permission(VIEW);
        
        if($this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == STUDENT || $this->session->userdata('role_id') == GUARDIAN){
            error($this->lang->line('unexpected_error'));
            redirect('teacher/rating/index');
        }
     
        // for super admin 
        $school_id = '';
        $teacher_id = '';
        if($_POST){            
            $school_id = $this->input->post('school_id');
            $teacher_id  = $this->input->post('teacher_id');           
        }
              
        if(!$school_id && $this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
            $this->data['teachers'] = $this->rating->get_list('teachers', array('status' => 1, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
        }
         
        
        if($school_id){
        
            $school = $this->rating->get_school_by_id($school_id);  

            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('administrator/year/index');
            }
            $this->data['ratings'] = $this->rating->get_teacher_rating_list($school_id, $school->academic_year_id, $teacher_id); 
            
        }
        
        $this->data['school_id'] = $school_id;   
        $this->data['filter_school_id'] = $school_id;
        $this->data['filter_teacher_id'] = $teacher_id;        
        $this->data['schools'] = $this->schools;
        $this->data['teacher_id'] = $teacher_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_rating'). ' | ' . SMS);
        $this->layout->view('rating/manage', $this->data);            
       
    }


     /*****************Function get_rating_form**********************************
     * @type            : Function
     * @function name   : get_rating_form
     * @description     : "Load rating form" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_rating_form(){
        
       $teacher_id = $this->input->post('teacher_id');   
       $this->data['teacher_id'] = $teacher_id;
       echo $this->load->view('rating/get-rating-form', $this->data);
    }
    

    /*****************Function save_rating**********************************
     * @type            : Function
     * @function name   : save_rating
     * @description     : "save_rating student rating"
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function save_rating() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('comment', $this->lang->line('comment'), 'required');
        //$this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('rating', $this->lang->line('rating'), 'required');

        if ($this->form_validation->run() == false) {
            
            $message = array(
                'rating' => form_error('rating'),
                'comment' => form_error('comment'),
            );

            $array = array('status' => 'error', 'error' => $message, 'success' => '');
            
        } else {
                        
            $data = array();
            $data['school_id'] = $this->session->userdata('school_id');
            $data['academic_year_id'] = $this->session->userdata('academic_year_id');
            $data['teacher_id'] = $this->input->post('teacher_id');
            $data['student_id'] = $this->session->userdata('profile_id');
            $data['class_id'] = $this->session->userdata('class_id');
            $data['section_id'] = $this->session->userdata('section_id');
            $data['rating'] = $this->input->post('rating');
            $data['comment'] = $this->input->post('comment');
            $data['rating_status'] = 'pending';
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $this->rating->insert('ratings', $data);
            $array = array('status' => 'success', 'error' => '', 'success' => $this->lang->line('insert_success'));
        }

        echo json_encode($array);
    }

    
    /*****************Function approve_rating**********************************
     * @type            : Function
     * @function name   : approve_rating
     * @description     : "approve student rating"
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function approve_rating() {
                        
        $data = array();

        $rating_id = $this->input->post('rating_id');
        $status = $this->input->post('status');
        $data['rating_status'] = $status;
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

       echo  $this->rating->update('ratings', $data, array('id'=>$rating_id));        
    }

}  
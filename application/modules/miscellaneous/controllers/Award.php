<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Award.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Award
 * @class name      : Award
 * @description     : Manage Award.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Award extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Award_Model', 'award', true);   
        $this->data['roles'] = $this->award->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Award List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        check_permission(VIEW);
                         
        $this->data['awards'] = $this->award->get_award_list($school_id);         
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->award->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }        
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_award') .' | ' . SMS);
        $this->layout->view('award/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new award" user interface                 
    *                    and process to store "Award" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_award_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_award_data();

                $insert_id = $this->award->insert('awards', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a award');                     
                    success($this->lang->line('insert_success'));
                    redirect('miscellaneous/award/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('miscellaneous/award/add/'.$data['school_id']);
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;                
            }
        }
             
        $this->data['awards'] = $this->award->get_award_list();  
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->award->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }         
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('award/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Award" user interface                 
    *                    with populated "Award" value 
    *                    and process to update "Award" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {
       
        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('miscellaneous/award/index');
        }
       
        if ($_POST) {
            $this->_prepare_award_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_award_data();
                $updated = $this->award->update('awards', $data, array('id' => $this->input->post('id')));
             
                if ($updated) {
                    
                    create_log('Has been updated an award');                    
                    success($this->lang->line('update_success'));
                    redirect('miscellaneous/award/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('miscellaneous/award/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['award'] = $this->award->get_single_award('awards', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['award'] = $this->award->get_single_award($id);
            if (!$this->data['award']) {
                redirect('miscellaneous/award/index');
            }
        }
        
        $this->data['awards'] = $this->award->get_award_list();    
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->award->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 
        
        $this->data['school_id'] = $this->data['award']->school_id;        
        $this->data['filter_school_id'] = $this->data['award']->school_id;        
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('award/index', $this->data);
    }

       
           
     /*****************Function get_single_award**********************************
     * @type            : Function
     * @function name   : get_single_award
     * @description     : "Load single award information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_award(){
        
       $award_id = $this->input->post('id');       
       $this->data['award'] = $this->award->get_single_award($award_id);
       echo $this->load->view('award/get-single-award', $this->data);
    }

    
    /*****************Function _prepare_award_validation**********************************
    * @type            : Function
    * @function name   : _prepare_award_validation
    * @description     : Process "Award" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_award_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('user_type'), 'trim|required');
       
        if($this->input->post('role_id') == STUDENT){
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        
        $this->form_validation->set_rules('user_id', $this->lang->line('winner'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');
        $this->form_validation->set_rules('gift', $this->lang->line('gift'), 'trim|required');
        $this->form_validation->set_rules('price', $this->lang->line('price'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        
    }

    
    /*****************Function _get_posted_award_data**********************************
    * @type            : Function
    * @function name   : _get_posted_award_data
    * @description     : Prepare "award" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_award_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'class_id';
        $items[] = 'user_id';
        $items[] = 'title';
        $items[] = 'gift';
        $items[] = 'price';
        $items[] = 'note';

        $data = elements($items, $_POST);
        
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
         
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $school = $this->award->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('miscellaneous/award/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
        }

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "award" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('miscellaneous/award/index');
        }
        
        $award = $this->award->get_single_award($id);
        
        if ($this->award->delete('awards', array('id' => $id))) {
            
            create_log('Has been deleted a award : '.$award->title);
            success($this->lang->line('delete_success'));
            redirect('miscellaneous/award/index/'.$award->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('miscellaneous/award/index');
    }

}

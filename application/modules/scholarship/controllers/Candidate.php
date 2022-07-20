<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Candidate.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Candidate
 * @class name      : Candidate
 * @description     : Manage Candidate.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Candidate extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Candidate_Model', 'candidate', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "candidate List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
           
        $school_id = '';
        $class_id = '';
        $condition = array();
        $condition['status'] = 1;
        
        if($_POST){            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
        }              
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id = $this->session->userdata('school_id');
            $condition['school_id'] = $school_id;
            $this->data['classes'] = $this->candidate->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }   
     
        if($school_id){
        
            $school = $this->candidate->get_school_by_id($school_id);  

            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('administrator/year/index');
            }
            
            $this->data['candidates'] = $this->candidate->get_candidate_list($school_id, $school->academic_year_id, $class_id);  
        }
       
        
        $this->data['filter_class_id'] = $class_id;    
        $this->data['filter_school_id'] = $school_id;      
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_candidate') .' | ' . SMS);
        $this->layout->view('candidate/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new candidate" user interface                 
    *                    and process to store "Candidate" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_candidate_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_candidate_data();

                $insert_id = $this->candidate->insert('ss_candidates', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a candidate');                     
                    success($this->lang->line('insert_success'));
                    redirect('scholarship/candidate/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('scholarship/candidate/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
                $this->data['school_id'] = $_POST['school_id'];        
                $this->data['filter_school_id'] = $_POST['school_id'];   
            }
        }
        
        $this->data['candidates'] = $this->candidate->get_candidate_list();               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->candidate->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 
        
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('candidate/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "candidate" user interface                 
    *                    with populated "Candidate" value 
    *                    and process to update "Candidate" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {
       
        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('scholarship/candidate/index');
        }
       
        if ($_POST) {
            $this->_prepare_candidate_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_candidate_data();
                $updated = $this->candidate->update('ss_candidates', $data, array('id' => $this->input->post('id')));
             
                if ($updated) {
                    
                    create_log('Has been updated an candidate');                    
                    success($this->lang->line('update_success'));
                    redirect('scholarship/candidate/index');
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('scholarship/candidate/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['candidate'] = $this->candidate->get_single_candidate($this->input->post('id'));
            }
        }

        if ($id) {
            
            $this->data['candidate'] = $this->candidate->get_single_candidate($id);
            if (!$this->data['candidate']) {
                redirect('scholarship/candidate/index');
            }
        }
                
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->candidate->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }
        
        if($this->data['candidate']->school_id){
        
            $school = $this->candidate->get_school_by_id($this->data['candidate']->school_id);
            $this->data['candidates'] = $this->candidate->get_candidate_list($school->id, $school->academic_year_id, $this->data['candidate']->class_id);  
        }
                
        $this->data['school_id'] = $this->data['candidate']->school_id;  
        //$this->data['filter_school_id'] = $this->data['candidate']->school_id;      
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('candidate/index', $this->data);
    }

       
           
     /*****************Function get_single_candidate**********************************
     * @type            : Function
     * @function name   : get_single_candidate
     * @description     : "Load single candidate information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_candidate(){
        
       $candidate_id = $this->input->post('id');       
       $this->data['candidate'] = $this->candidate->get_single_candidate($candidate_id);
       echo $this->load->view('candidate/get-single-candidate', $this->data);
    }

    
    /*****************Function _prepare_candidate_validation**********************************
    * @type            : Function
    * @function name   : _prepare_candidate_validation
    * @description     : Process "Candidate" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_candidate_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
       
        if($this->input->post('role_id') == STUDENT){
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
        $this->form_validation->set_rules('student_id', $this->lang->line('student'), 'trim|required|callback_student_id');
        $this->form_validation->set_rules('note', $this->lang->line('note'));
        
    }
    
    
        /*****************Function student_id**********************************
    * @type            : Function
    * @function name   : student_id
    * @description     : Unique check for "student name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
   public function student_id()
   {             
      if($this->input->post('id') == '')
      {   
          $student = $this->candidate->duplicate_check($this->input->post('school_id'), $this->input->post('student_id')); 
          if($student){
                $this->form_validation->set_message('student_id', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $student = $this->candidate->duplicate_check($this->input->post('school_id'), $this->input->post('student_id'), $this->input->post('id')); 
          if($student){
                $this->form_validation->set_message('student_id', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
    

    
    /*****************Function _get_posted_candidate_data**********************************
    * @type            : Function
    * @function name   : _get_posted_candidate_data
    * @description     : Prepare "candidate" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_candidate_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'student_id';
        $items[] = 'note';

        $data = elements($items, $_POST);
        
         
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->candidate->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('scholarship/candidate/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
        }

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "candidate" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('scholarship/candidate/index');
        }
        
        $candidate = $this->candidate->get_single_candidate($id);
        
        if ($this->candidate->delete('ss_candidates', array('id' => $id))) {
            
            success($this->lang->line('delete_success'));
            redirect('scholarship/candidate/index/'.$candidate->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('scholarship/candidate/index');
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Submission.php**********************************
 * @product name    : Global School Management System Express
 * @type            : Class
 * @class name      : Submission
 * @description     : Manage Submission homeword by student to class teacher.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 
 * ********************************************************** */

class Submission extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();

        $this->load->model('Submission_Model', 'submission', true);
      
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Submission List" user interface                 
    *                    with student wise listing    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($class_id = null) {

        check_permission(VIEW);
        
        // for super admin / admin
        $school_id = 0;      
        $section_id = 0;
        $academic_year_id = 0;
        $condition = array();
        $condition['status'] = 1; 
       
        if($this->session->userdata('role_id') != SUPER_ADMIN){    
            $academic_year_id = $this->session->userdata('academic_year_id');
             $condition['school_id'] = $this->session->userdata('school_id');   
            $school_id = $condition['school_id'];
        }
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $school_id = $this->session->userdata('school_id');    
            $class_id = $this->session->userdata('class_id');    
            $section_id = $this->session->userdata('section_id'); 
            $academic_year_id = $this->session->userdata('academic_year_id');  
            $this->data['assignments'] = $this->submission->get_list('assignments', array('class_id'=>$class_id, 'section_id'=>$section_id, 'academic_year_id'=>$academic_year_id), '','', '', 'id', 'ASC');
            
        }
        
        if($_POST){
            
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');
        }
        
        
        if($class_id){
           $class = $this->db->get_where('classes', array('id'=>$class_id))->row();
           $school_id = $class->school_id;
        }
                  
       
        if($school_id){
        
            $school = $this->submission->get_school_by_id($school_id); 
            $this->data['submissions'] = $this->submission->get_submission_list($school_id, $class_id, $section_id, $school->academic_year_id);
        }
        
        $this->data['classes'] = $this->submission->get_list('classes', $condition, '','', '', 'id', 'ASC');
        $this->data['class_list'] = $this->data['classes'];
                     
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_submission') . ' | ' . SMS);
        $this->layout->view('submission/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Submission" user interface                 
    *                    and process to store "Submission" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        $school_id  = '';   
        $class_id  = '';
        $section_id  = '';
         
        if ($_POST) {
            $this->_prepare_submission_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_submission_data();

                $insert_id = $this->submission->insert('assignment_submissions', $data);
                if ($insert_id) {
                   
                    success($this->lang->line('insert_success'));
                    redirect('academic/submission/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('academic/submission/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        
       if ($this->session->userdata('role_id') == STUDENT) {
            
            $school_id = $this->session->userdata('school_id');  
            $class_id = $this->session->userdata('class_id');   
            $section_id = $this->session->userdata('section_id');  
            $academic_year_id = $this->session->userdata('academic_year_id');  
            $this->data['assignments'] = $this->submission->get_list('assignments', array('class_id'=>$class_id, 'section_id'=>$section_id, 'academic_year_id'=>$academic_year_id), '','', '', 'id', 'ASC');
        }
        
        $condition = array();
        $condition['status'] = 1; 
        if($this->session->userdata('role_id') != SUPER_ADMIN){    
            $academic_year_id = $this->session->userdata('academic_year_id');
            $school_id = $this->session->userdata('school_id');  
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->submission->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        if(!$school_id){
            $school_id = $this->input->post('school_id');
        }
        
        $school = $this->submission->get_school_by_id($school_id); 
        $this->data['submissions'] = $this->submission->get_submission_list($school_id, $class_id, $section_id, $school->academic_year_id);
        $this->data['class_list'] = $this->submission->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
             
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('manage_submission') . ' | ' . SMS);
        $this->layout->view('submission/index', $this->data);
        
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Submission" user interface                 
    *                    with populated "Submission" value 
    *                    and process to update "Submission" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
              redirect('dashboard/index'); 
        }
        
        $class_id = '';
        $section_id = '';
        
        if ($_POST) {
            $this->_prepare_submission_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_submission_data();
                $updated = $this->submission->update('assignment_submissions', $data, array('id' => $this->input->post('id')));

                if ($updated) {                 
                    success($this->lang->line('update_success'));
                    redirect('academic/submission/index/' . $this->input->post('class_id'));
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('academic/submission/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['submission'] = $this->submission->get_single_submission($this->input->post('id'));
            }
        }
        
        if ($id) {
            $this->data['submission'] = $this->submission->get_single_submission($id);

            if (!$this->data['submission']) {
                redirect('academic/submission/index');
            }
            
            $class_id = $this->data['submission']->class_id;
            $section_id = $this->data['submission']->section_id;
        }
       
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $school_id = $this->session->userdata('school_id');  
            $class_id = $this->session->userdata('class_id');   
            $section_id = $this->session->userdata('section_id');  
            $academic_year_id = $this->session->userdata('academic_year_id');  
            $this->data['assignments'] = $this->submission->get_list('assignments', array('class_id'=>$class_id, 'section_id'=>$section_id, 'academic_year_id'=>$academic_year_id), '','', '', 'id', 'ASC');
        }
        
        $condition = array();
        $condition['status'] = 1;   
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $academic_year_id = $this->session->userdata('academic_year_id');
            $school_id        = $this->session->userdata('school_id');
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->submission->get_list('classes', $condition, '','', '', 'id', 'ASC'); 
        }
        
        $school_id = $this->data['submission']->school_id;
        $school = $this->submission->get_school_by_id($school_id); 
        $this->data['submissions'] = $this->submission->get_submission_list($school_id, $class_id, $section_id, $school->academic_year_id);
        $this->data['class_list'] = $this->submission->get_list('classes', $condition, '','', '', 'id', 'ASC');
        
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['class_id'] = $class_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('manage_submission') . ' | ' . SMS);
        $this->layout->view('submission/index', $this->data);
    }

    
    /*****************Function get_single_submission**********************************
    * @type            : Function
    * @function name   : get_single_submission
    * @description     : Load user interface with specific submission data                 
    *                       
    * @param           : $submission_id integer value
    * @return          : null 
    * ***********************************************************/
    public function get_single_submission(){
        
       $submission_id = $this->input->post('submission_id');       
       $this->data['submit'] = $this->submission->get_single_submission($submission_id);     
       echo $this->load->view('submission/get-single-submission', $this->data);
    }
    
    
    /*****************Function _prepare_submission_validation**********************************
    * @type            : Function
    * @function name   : _prepare_submission_validation
    * @description     : Process "Submission" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_submission_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('assignment_id', $this->lang->line('assignment'), 'trim|required');
        
        if ($this->session->userdata('role_id') != STUDENT) {
            
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
            $this->form_validation->set_rules('section_id', $this->lang->line('section'), 'trim|required');
            $this->form_validation->set_rules('student_id', $this->lang->line('student'), 'trim|required|callback_student_id');
        }
        
        $this->form_validation->set_rules('submission', $this->lang->line('submission'), 'trim|callback_submission');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        
    }

    
            
    /*****************Function student_id**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for "student_id" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
   public function student_id()
   {             
      if($this->input->post('id') == '')
      {   
          $subject = $this->submission->duplicate_check($this->input->post('school_id'), $this->input->post('assignment_id'),$this->input->post('student_id')); 
          if($subject){
                $this->form_validation->set_message('student_id', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $subject = $this->submission->duplicate_check($this->input->post('school_id'), $this->input->post('assignment_id'),$this->input->post('student_id'),$this->input->post('id')); 
          if($subject){
                $this->form_validation->set_message('student_id', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }else{
          return TRUE;
      }      
   }
        
    /*****************Function upload**********************************
    * @type            : Function
    * @function name   : upload
    * @description     : Process to valiadte upload document file                 
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function submission() {

        if ($_FILES['submission']['name']) {
            $name = $_FILES['submission']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if ($ext == 'pdf' || $ext == 'doc' || $ext == 'docx' || $ext == 'ppt' || $ext == 'pptx' || $ext == 'txt'|| $ext == 'xls' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('submission', $this->lang->line('select_valid_file_format').' Ex: jpg, jpeg, png, gif, doc, docx, pdf, ppt, pptx, xls, txt');         
                return FALSE; 
            }
        }       
    }

    
    /*****************Function _get_posted_submission_data**********************************
    * @type            : Function
    * @function name   : _get_posted_submission_data
    * @description     : Prepare "Submission" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_submission_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'assignment_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'student_id';
        $items[] = 'note';

        $data = elements($items, $_POST);
        
        $data['submitted_at']  = date('Y-m-d H:i:s');      
        
        if ($this->session->userdata('role_id') == STUDENT) {
            
            $data['class_id'] = $this->session->userdata('class_id');   
            $data['section_id'] = $this->session->userdata('section_id');  
            $data['student_id']        = $this->session->userdata('profile_id');
            $data['academic_year_id'] = $this->session->userdata('academic_year_id');
        }
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            $data['evaluation_status'] = 'submitted';
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->submission->get_school_by_id($data['school_id']);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('assignment/submission/index');
            }
            $data['academic_year_id'] = $school->academic_year_id;
        }

        if ($_FILES['submission']['name']) {
            $data['submission'] = $this->_upload_submission();
        }

        return $data;
        
    }

    
    /*****************Function _upload_submission**********************************
    * @type            : Function
    * @function name   : _upload_submission
    * @description     : Process to upload submission document into server                  
    *                    and return documrnt name   
    * @param           : $return_submission string value
    * @return          : null 
    * ********************************************************** */
    private function _upload_submission() {

        $prev_submission = $this->input->post('prev_submission');
        $submission = $_FILES['submission']['name'];
        $submission_type = $_FILES['submission']['type'];
        $return_submission = '';

        if ($submission != "") {
            if ($submission_type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                    $submission_type == 'application/msword' || $submission_type == 'text/plain' ||
                    $submission_type == 'application/vnd.ms-office' || $submission_type == 'application/pdf' ||
                    $submission_type == 'image/jpeg' || $submission_type == 'image/pjpeg' ||
                    $submission_type == 'image/jpg' || $submission_type == 'image/png' ||
                    $submission_type == 'image/x-png' || $submission_type == 'image/gif' ||
                    $submission_type == 'application/powerpoint' ||
                    $submission_type == 'application/vnd.ms-powerpoint' ||
                    $submission_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
            ) {

                $destination = 'assets/uploads/assignment-submission/';

                $submission_type = explode(".", $submission);
                $extension = strtolower($submission_type[count($submission_type) - 1]);
                $submission_path = 'submission-' . time() . '-sms.' . $extension;

                move_uploaded_file($_FILES['submission']['tmp_name'], $destination . $submission_path);

                // need to unlink previous submission
                if ($prev_submission != "") {
                    if (file_exists($destination . $prev_submission)) {
                        @unlink($destination . $prev_submission);
                    }
                }

                $return_submission = $submission_path;
            }
            
        } else {
            
            $return_submission = $prev_submission;
        }

        return $return_submission;
        
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "submission" data from database                  
    *                    and unlink submission document from server   
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(DELETE);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('assignment/submission/index');
        }
        
        $submission = $this->submission->get_single('assignment_submissions', array('id' => $id));
              
        if ($this->submission->delete('assignment_submissions', array('id' => $id))) {

            // delete submission submission
            $destination = 'assets/uploads/';
            if (file_exists($destination . '/assignment-submission/' . $submission->submission)) {
                @unlink($destination . '/assignment-submission/' . $submission->submission);
            }

            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        redirect('assignment/submission/index');
    }
    
    
        
    
    /*****************Function update_evatioation_status**********************************
     * @type            : Function
     * @function name   : update_evatioation_status
     * @description     : update_evatioation_status               
     *                    
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function update_evatioation_status() {
        
         $submission_id = $this->input->post('submission_id');
         $status     = $this->input->post('status');
         
         $data['modified_at'] = date('Y-m-d H:i:s');
         $data['evaluation_date'] = date('Y-m-d H:i:s');
         $data['evaluation_status'] = $status;
      
         echo $this->submission->update('assignment_submissions', $data, array('id'=>$submission_id));         
    }
    
    
        /*****************Function evaluate**********************************
    * @type            : Function
    * @function name   : evaluate
    * @description     : Load "Submission List" user interface                 
    *                    with student wise listing    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function evaluate($assignment_id = null) {

        check_permission(EDIT);
        $role_id = $this->session->userdata('role_id'); 
        if ($role_id == TEACHER || $role_id == ADMIN || $role_id == SUPER_ADMIN ) {
            
            $this->data['submissions'] = $this->submission->get_submission_by_assignment($assignment_id);       
       
            $this->data['list'] = TRUE;
            $this->layout->title($this->lang->line('manage_submission') . ' | ' . SMS);
            $this->layout->view('submission/evaluate', $this->data);
        
        }else{
            
            error($this->lang->line('unexpected_error'));
            redirect('academic/assignment/index');            
        }
          
    }

}


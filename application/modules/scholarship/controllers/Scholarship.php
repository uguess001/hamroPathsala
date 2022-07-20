<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Scholarship.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Scholarship
 * @class name      : Scholarship
 * @description     : Manage Scholarship.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Scholarship extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Scholarship_Model', 'scholarship', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Scholarship List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index( $school_id  = null ) {
        
        check_permission(VIEW);
             
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
            $this->data['classes'] = $this->scholarship->get_list('classes', $condition, '','', '', 'id', 'ASC');            
        }        
        
        if($school_id){
        
            $school = $this->scholarship->get_school_by_id($school_id);
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('administrator/year/index');
            }          
            
            $this->data['candidates'] = $this->scholarship->get_candidate_list($school_id, $school->academic_year_id, $class_id);
            $this->data['scholarships'] = $this->scholarship->get_scholarship_list($school_id, $school->academic_year_id, $class_id );             
        }
        
        $this->data['filter_class_id'] = $class_id;    
        $this->data['filter_school_id'] = $school_id;      
        $this->data['schools'] = $this->schools;
       
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_scholarship') .' | ' . SMS);
        $this->layout->view('index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new scholarship" user interface                 
    *                    and process to store "Scholarship" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_scholarship_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_scholarship_data();

                $insert_id = $this->scholarship->insert('ss_scholarships', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a scholarship');                     
                    success($this->lang->line('insert_success'));
                    redirect('scholarship/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('scholarship/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
                $this->data['school_id'] = $this->input->post('school_id');        
                $this->data['filter_school_id'] = $this->input->post('school_id');   
            }
        }
        
        $this->data['scholarships'] = $this->scholarship->get_scholarship_list();               
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['candidates'] = $this->scholarship->get_list('ss_candidates', $condition, '','', '', 'id', 'ASC');
        } 
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "scholarship" user interface                 
    *                    with populated "Scholarship" value 
    *                    and process to update "Scholarship" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {
       
        check_permission(EDIT);

        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('scholarship/index');
        }
       
        if ($_POST) {
            $this->_prepare_scholarship_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_scholarship_data();
                $updated = $this->scholarship->update('ss_scholarships', $data, array('id' => $this->input->post('id')));
             
                if ($updated) {
                    
                    create_log('Has been updated a scholarship');                    
                    success($this->lang->line('update_success'));
                    redirect('scholarship/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('scholarship/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['scholarship'] = $this->scholarship->get_single('ss_scholarships', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['scholarship'] = $this->scholarship->get_single('ss_scholarships', array('id' => $id));
            if (!$this->data['scholarship']) {
                redirect('scholarship/index');
            }
        }
        
        $school_id = $this->data['scholarship']->school_id;
        $academic_year_id = $this->data['scholarship']->academic_year_id;
        
        $this->data['scholarships'] = $this->scholarship->get_scholarship_list($school_id, $academic_year_id);    
        
        $condition = array();
        $condition['status'] = 1;        
        $condition['academic_year_id'] = $academic_year_id; 
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['candidates'] = $this->scholarship->get_list('ss_candidates', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('index', $this->data);
    }

       
           
     /*****************Function get_single_scholarship**********************************
     * @type            : Function
     * @function name   : get_single_scholarship
     * @description     : "Load single scholarship information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_scholarship(){
        
       $scholarship_id = $this->input->post('id');       
       $this->data['scholarship'] = $this->scholarship->get_single_scholarship($scholarship_id);
       echo $this->load->view('get-single-scholarship', $this->data);
    }

    
    /*****************Function _prepare_scholarship_validation**********************************
    * @type            : Function
    * @function name   : _prepare_scholarship_validation
    * @description     : Process "scholarship" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_scholarship_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('candidate_id', $this->lang->line('candidate'), 'trim|required|callback_candidate_id');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required');
        $this->form_validation->set_rules('payment_date', $this->lang->line('payment_date'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'));
        
    }

    
    /*****************Function candidate_id**********************************
    * @type            : Function
    * @function name   : candidate_id
    * @description     : Unique check for "Candidate" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */  
    public function candidate_id()
    {    
       
        $school = $this->scholarship->get_school_by_id($this->input->post('school_id'));
        
        if($this->input->post('id') == '')
        {  
             
             $candidate = $this->scholarship->duplicate_check($this->input->post('school_id'), $school->academic_year_id, $this->input->post('candidate_id') );
         
            if($candidate){
                $this->form_validation->set_message('candidate_id', $this->lang->line('already_exist'));         
                return FALSE;
            } else {
              return TRUE;
           }          
        }else if($this->input->post('id') != ''){ 
                
           $candidate = $this->scholarship->duplicate_check($this->input->post('school_id'), $school->academic_year_id, $this->input->post('candidate_id'), $this->input->post('id'));
           
           if($candidate){
                $this->form_validation->set_message('candidate_id', $this->lang->line('already_exist'));         
                return FALSE;
            } else {
              return TRUE;
           }
        }else{
           return TRUE;
      }      
   }
    
    
    /*****************Function _get_posted_scholarship_data**********************************
    * @type            : Function
    * @function name   : _get_posted_scholarship_data
    * @description     : Prepare "scholarship" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_scholarship_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'candidate_id';
        $items[] = 'amount';
        $items[] = 'note';

        $data = elements($items, $_POST);
        
        $data['payment_date'] = date('Y-m-d', strtotime($this->input->post('payment_date')));
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
            
        if ($this->input->post('id')) {
            
             //$data['status'] = $this->input->post('status');           
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->scholarship->get_school_by_id($data['school_id']);            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('scholarship/scholarship/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
        }
        
        $this->__update_balance();

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "scholarship" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('scholarship/index');
        }
        
        $scholarship = $this->scholarship->get_single('ss_scholarships', array('id' => $id));
        
        if ($this->scholarship->delete('ss_scholarships', array('id' => $id))) {
            
             // reduce donar amount from main balance
            $sql = "UPDATE ss_balance SET balance = balance+$scholarship->amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $scholarship->school_id AND status=1";
            $this->db->query($sql);  
            success($this->lang->line('delete_success'));
            redirect('scholarship/index/'.$scholarship->school_id);
            
        } else {
            
            error($this->lang->line('delete_failed'));
        }
        
        redirect('scholarship/index');
    }
    
    
    
    private function __update_balance(){
        
        $school_id = $this->input->post('school_id');
        $balance = $this->scholarship->get_single('ss_balance', array('school_id'=>$school_id, 'status' => 1));  
        $amount  = $this->input->post('amount');
        
        if ($this->input->post('id')) {
            
            $old_amount = $this->input->post('old_amount');
            
            if(($balance->balance + $old_amount) < $amount){
               
                error($this->lang->line('insufficient_balance'));
                redirect('scholarship/edit/' . $this->input->post('id'));     
            }
            
            $sql = "UPDATE ss_balance SET balance = balance+$old_amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status=1";
            $this->db->query($sql);
            
            $sql = "UPDATE ss_balance SET balance = balance-$amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status=1";
            $this->db->query($sql);
            
        }else{
            
            if($balance->balance < $amount){
               
                error($this->lang->line('insufficient_balance'));
                redirect('scholarship/index');     
            } 
            
            $sql = "UPDATE ss_balance SET balance = balance-$amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status = 1";
            $this->db->query($sql);
        }        
    }
    
    
    /*****************Function get_candidate_by_school**********************************
     * @type            : Function
     * @function name   : get_candidate_by_school
     * @description     : Load "Candidate Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_candidate_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $candidate_id  = $this->input->post('candidate_id');
        
        $school = $this->scholarship->get_single('schools', array('status' => 1, 'id'=>$school_id));
        $candidates = $this->scholarship->get_candidate_list($school_id, $school->academic_year_id);
        
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($candidates)) {
            foreach ($candidates as $obj) {   
                
                $selected = $candidate_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->student_name . '</option>';
                
            }
        }

        echo $str;
    }

}

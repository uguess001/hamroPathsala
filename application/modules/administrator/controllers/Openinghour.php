<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Openinghour.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Openinghour
 * @description     : Manage Openinghour.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Openinghour extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        
         if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
             redirect('dashboard/index');
        }
        
         $this->load->model('Openinghour_Model', 'openinghour', true);
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Openinghour List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);
        
        $this->data['openinghours'] = $this->openinghour->get_openinghour_list();
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_opening_hour'). ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);            
       
    }

    
    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Openinghour" user interface                 
    *                    and store "Openinghour" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {
       
        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_openinghour_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_openinghour_data();

                $insert_id = $this->openinghour->insert('opening_hours', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('administrator/openinghour/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('administrator/openinghour/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
       
        $this->data['openinghours'] = $this->openinghour->get_openinghour_list();
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('opening_hour') . ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Openinghour" user interface                 
    *                    with populated "Openinghour" value 
    *                    and update "Openinghour" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {   
        
        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_openinghour_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_openinghour_data();               
                $updated = $this->openinghour->update('opening_hours', $data, array('id' => $this->input->post('id')));
               
                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('administrator/openinghour/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('administrator/openinghour/edit/' . $this->input->post('id'));
                }
            }else{
                
               
                error($this->lang->line('update_failed'));
            }
        }
        
        if ($id) {
            $this->data['openinghour'] = $this->openinghour->get_single_openinghour($id);

            if (!$this->data['openinghour']) {
                redirect('administrator/openinghour/index');
            }
        }
        $this->data['school_id'] = $this->data['openinghour']->school_id;
        
        $this->data['openinghours'] = $this->openinghour->get_openinghour_list();
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('opening_hour') . ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);
    }

    
    /*****************Function _prepare_openinghour_validation**********************************
    * @type            : Function
    * @function name   : _prepare_openinghour_validation
    * @description     : Process "Openinghour" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_openinghour_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school'),'trim|required|callback_school_id');
    }

    /*****************Function name**********************************
     * @type            : Function
     * @function name   : school_id
     * @description     : unique check for "school_id"
     *                       
     * @param           : null 
     * @return          : boolean true/flase 
     * ********************************************************** */
    public function school_id()
    {             
    if($this->input->post('id') == '')
       {   
          $school = $this->openinghour->duplicate_check($this->input->post('school_id')); 
          if($school){
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));         
                return FALSE;
            } else {
              return TRUE;
            }          
        }else if($this->input->post('id') != ''){   
         $school = $this->openinghour->duplicate_check($this->input->post('school_id'), $this->input->post('id')); 
          if($school){
                $this->form_validation->set_message('school_id', $this->lang->line('already_exist'));         
                return FALSE;
            } else {
              return TRUE;
            }
        }   
    }
    
    /*****************Function get_single_openinghour**********************************
     * @type            : Function
     * @function name   : get_single_openinghour
     * @description     : "Load single openinghour information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_openinghour(){
        
       $openinghour_id = $this->input->post('id');       
       $this->data['openinghour'] = $this->openinghour->get_single_openinghour($openinghour_id);
       echo $this->load->view('opening_hour/get-single-openinghour', $this->data);
    }
   
    /*****************Function _get_posted_openinghour_data**********************************
     * @type            : Function
     * @function name   : _get_posted_openinghour_data
     * @description     : Prepare "School opening hour" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_openinghour_data() {

        $data = array();
        $data['school_id'] = $this->input->post('school_id');
         
        
        if($this->input->post('monday_1') && $this->input->post('monday_2')){
            $data['monday'] = $this->input->post('monday_1') . ' - ' . $this->input->post('monday_2'); 
        }else{
            $data['monday'] = '';
        }
        
        if($this->input->post('tuesday_1') && $this->input->post('tuesday_2')){
            $data['tuesday'] = $this->input->post('tuesday_1') . ' - ' . $this->input->post('tuesday_2'); 
        }else{
            $data['tuesday'] = '';
        }  
        
        if($this->input->post('wednesday_1') && $this->input->post('wednesday_2')){
            $data['wednesday'] = $this->input->post('wednesday_1') . ' - ' . $this->input->post('wednesday_2'); 
        }else{
            $data['wednesday'] = '';
        }
        
        if($this->input->post('thursday_1') && $this->input->post('thursday_2')){
            $data['thursday'] = $this->input->post('thursday_1') . ' - ' . $this->input->post('thursday_2');
        }else{
            $data['thursday'] = '';
        }
        
        if($this->input->post('friday_1') && $this->input->post('friday_2')){
           $data['friday'] = $this->input->post('friday_1') . ' - ' . $this->input->post('friday_2'); 
        }else{
            $data['friday'] = '';
        }
        
        if($this->input->post('saturday_1') && $this->input->post('saturday_2')){
            $data['saturday'] = $this->input->post('saturday_1') . ' - ' . $this->input->post('saturday_2');
        }else{
            $data['saturday'] = '';
        } 
        
        if($this->input->post('sunday_1') && $this->input->post('sunday_2')){
            $data['sunday'] = $this->input->post('sunday_1') . ' - ' . $this->input->post('sunday_2'); 
        }else{
            $data['sunday'] = '';
        }        
        
        if ($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_by'] = logged_in_user_id();
        }       
        return $data;      
    }

    
    
    /*****************Function delete**********************************
   * @type            : Function
   * @function name   : delete
   * @description     : delete "Openinghour" from database                  
   *                       
   * @param           : $id integer value
   * @return          : null 
   * ********************************************************** */
    public function delete($id = null) {        
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('administrator/openinghour/index');              
        }
                
        if ($this->openinghour->delete('opening_hours', array('id' => $id))) { 
            success($this->lang->line('delete_success'));            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('administrator/openinghour/index');
    }
}

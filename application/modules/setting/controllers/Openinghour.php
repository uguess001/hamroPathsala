<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Openinghour.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Setting
 * @description     : Manage application Opening hour.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Openinghour extends MY_Controller {

    public $data = array();

    function __construct() {
        
        parent::__construct();
        $this->load->model('Setting_Model', 'setting', true); 
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $school_id =  $this->session->userdata('school_id');
        } 
        
        $this->data['openinghour'] = $this->setting->get_single('opening_hours', array('status'=>1, 'school_id'=>$school_id));
               
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Opening Hour" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);
        
        $this->layout->title($this->lang->line('opening_hour') . ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "opening hour" user interface                 
    *                    and process to store "opening hour" into database
    *                    for the first time settings 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_openinghour_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_openinghour_data();

                $insert_id = $this->setting->insert('opening_hours', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                    redirect('setting/openinghour/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('setting/openinghour/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }
       
        $this->layout->title($this->lang->line('opening_hour') . ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);
    }

    
        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Opening Hour" user interface                 
    *                    with populate "Opening Hours" value 
    *                    and process to update "Opening Hour" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit() {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_openinghour_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_openinghour_data();               
                $updated = $this->setting->update('opening_hours', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    success($this->lang->line('update_success'));
                    redirect('setting/openinghour/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('setting/openinghour/edit/' . $this->input->post('id'));
                }
            }else{
                error($this->lang->line('update_failed'));
            }
        }
        
        $this->layout->title($this->lang->line('opening_hour') . ' | ' . SMS);
        $this->layout->view('opening_hour/index', $this->data);
    }

        
    /*****************Function _prepare_openinghour_validation**********************************
    * @type            : Function
    * @function name   : _prepare_openinghour_validation
    * @description     : Process "opeing hour" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_openinghour_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('school_id',  $this->lang->line('school'), 'trim|required');
        $this->form_validation->set_rules('monday',  $this->lang->line('monday'), 'trim');
        $this->form_validation->set_rules('tuesday',  $this->lang->line('tuesday'), 'trim');
        $this->form_validation->set_rules('wednesday',  $this->lang->line('wednesday'), 'trim');
        $this->form_validation->set_rules('thursday', $this->lang->line('thursday'), 'trim');        
        $this->form_validation->set_rules('friday', $this->lang->line('friday'), 'trim');        
        $this->form_validation->set_rules('saturday', $this->lang->line('saturday'), 'trim');        
        $this->form_validation->set_rules('sunday', $this->lang->line('sunday'), 'trim');        
        
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
        }       

        return $data;
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Donar.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Donar
 * @class name      : Donar
 * @description     : Manage Donar.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Donar extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Donar_Model', 'donar', true);
    }

    /*     * ***************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Load "donar List" user interface                 
     *                    listing    
     * @param           : integer value
     * @return          : null 
     * ********************************************************** */

    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['donars'] = $this->donar->get_donar_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;

        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_donar') . ' | ' . SMS);
        $this->layout->view('donar/index', $this->data);
    }

    /*     * ***************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new donar" user interface                 
     *                    and process to store "Donar" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_donar_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_donar_data();

                $insert_id = $this->donar->insert('ss_donars', $data);
                if ($insert_id) {

                    $this->__update_balance();
                    
                    create_log('Has been created a donar');
                    success($this->lang->line('insert_success'));
                    redirect('scholarship/donar/index/' . $data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('scholarship/donar/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
                $this->data['school_id'] = $this->input->post('school_id');
                $this->data['filter_school_id'] = $this->input->post('school_id');
            }
        }

        $this->data['donars'] = $this->donar->get_donar_list();
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;

        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('donar/index', $this->data);
    }

    /*     * ***************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "donar" user interface                 
     *                    with populated "Donar" value 
     *                    and process to update "Donar" into database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */

    public function edit($id = null) {

        check_permission(EDIT);

        if (!is_numeric($id)) {
            error($this->lang->line('unexpected_error'));
            redirect('scholarship/donar/index');
        }

        if ($_POST) {
            $this->_prepare_donar_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_donar_data();
                $updated = $this->donar->update('ss_donars', $data, array('id' => $this->input->post('id')));

                if ($updated) {

                    $this->__update_balance();
                    
                    create_log('Has been updated a donar');
                    success($this->lang->line('update_success'));
                    redirect('scholarship/donar/index/' . $this->input->post('school_id'));
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('scholarship/donar/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['donar'] = $this->donar->get_single_donar($this->input->post('id'));
            }
        }

        if ($id) {

            $this->data['donar'] = $this->donar->get_single_donar($id);
            if (!$this->data['donar']) {
                redirect('scholarship/donar/index');
            }
        }

        $this->data['donars'] = $this->donar->get_donar_list($this->data['donar']->school_id);


        $this->data['school_id'] = $this->data['donar']->school_id;
        $this->data['filter_school_id'] = $this->data['donar']->school_id;
        $this->data['schools'] = $this->schools;

        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('donar/index', $this->data);
    }

    /*     * ***************Function get_single_donar**********************************
     * @type            : Function
     * @function name   : get_single_donar
     * @description     : "Load single donar information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    public function get_single_donar() {

        $donar_id = $this->input->post('id');
        $this->data['donar'] = $this->donar->get_single_donar($donar_id);
        echo $this->load->view('donar/get-single-donar', $this->data);
    }

    /*     * ***************Function _prepare_donar_validation**********************************
     * @type            : Function
     * @function name   : _prepare_donar_validation
     * @description     : Process "Donar" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */

    private function _prepare_donar_validation() {

        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('donar_type', $this->lang->line('donar_type'), 'trim|required');
        $this->form_validation->set_rules('donar_name', $this->lang->line('donar_name'), 'trim|required');
        $this->form_validation->set_rules('contact_name', $this->lang->line('contact_name'), 'trim');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('amount', $this->lang->line('amount'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'));
    }

    /*     * ***************Function _get_posted_donar_data**********************************
     * @type            : Function
     * @function name   : _get_posted_donar_data
     * @description     : Prepare "donar" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */

    private function _get_posted_donar_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'donar_type';
        $items[] = 'donar_name';
        $items[] = 'contact_name';
        $items[] = 'email';
        $items[] = 'phone';
        $items[] = 'address';
        $items[] = 'amount';
        $items[] = 'note';

        $data = elements($items, $_POST);

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->input->post('id')) {
           
            $data['status'] = $this->input->post('status');
            
        } else {

            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            

            $school = $this->donar->get_school_by_id($data['school_id']);

            if (!$school->academic_year_id) {
                error($this->lang->line('set_academic_year_for_school'));
                redirect('administrator/year/index');
            }

            $data['academic_year_id'] = $school->academic_year_id;
        }

        return $data;
    }
    

    /* ***************Function delete**********************************
     * @type            : Function
     * @function name   : delete
     * @description     : delete "donar" from database                 
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */

    public function delete($id = null) {

        check_permission(VIEW);

        if (!is_numeric($id)) {
            error($this->lang->line('unexpected_error'));
            redirect('scholarship/donar/index');
        }


        $donar = $this->donar->get_single('ss_donars', array('id'=>$id));        
        $balance = $this->donar->get_single('ss_balance', array('school_id'=>$donar->school_id, 'status' => 1));
        
        // if donar amount is greater than balance then donar can not delete
        if($donar->amount > $balance->balance){
            error($this->lang->line('donation_amount_already_used'));
            redirect('scholarship/donar/index');
        }        
        
        if ($this->donar->delete('ss_donars', array('id' => $id))) {

            // reduce donar amount from main balance
            $sql = "UPDATE ss_balance SET balance = balance-$donar->amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE  school_id = $donar->school_id AND status=1";
            $this->db->query($sql);
            
            success($this->lang->line('delete_success'));
            redirect('scholarship/donar/index/' . $donar->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }

        redirect('scholarship/donar/index');
    }
    
    
    private function __update_balance(){
        
        $data = array();
        
        $school_id = $this->input->post('school_id');
        $balance = $this->donar->get_single('ss_balance', array('school_id'=>$school_id, 'status' => 1));  
        
        if (empty($balance)) {
            
            $data['school_id'] = $school_id;
            $data['balance'] = 0;
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id(); 
            $this->donar->insert('ss_balance', $data);
        }
        
        
        $amount = $this->input->post('amount');
        
        if ($this->input->post('id')) {
            
            $old_amount = $this->input->post('old_amount');
            
            $sql = "UPDATE ss_balance SET balance = balance-$old_amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status=1";
            $this->db->query($sql);
            
            $sql = "UPDATE ss_balance SET balance = balance+$amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status=1";
            $this->db->query($sql);
            
        }else{
            
            $sql = "UPDATE ss_balance SET balance = balance+$amount , modified_at = '".date('Y-m-d H:i:s')."' WHERE school_id = $school_id AND status=1";
            $this->db->query($sql);
            
        }        
    }
}
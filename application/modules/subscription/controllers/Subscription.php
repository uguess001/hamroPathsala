<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Subscription.php**********************************
 * @product name    : HamroSchool Management System
 * @Type            : Subscription
 * @class name      : Subscription
 * @description     : Manage  subscription.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Subscription extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        
         if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard/index');
        }
        
        $this->load->model('Subscription_Model', 'subscription', true);  
        $this->data['plans'] = $this->subscription->get_list('saas_plans', array('status'=>1), '','', '', 'id', 'ASC');
    }

    
    /*****************Function index**********************************
    * @Type            : Function
    * @function name   : index
    * @description     : Load "Subscription List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);        
        $this->data['subscriptions'] = $this->subscription->get_subscription_list(); 
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_subscription').' | ' . SMS);
        $this->layout->view('subs/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Type            : Function
    * @function name   : add
    * @description     : Load "Add new subscription" user interface                 
    *                    and process to store "subscription" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_subscription_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_subscription_data();

                $insert_id = $this->subscription->insert('saas_subscriptions', $data);
                if ($insert_id) {                    
                    success($this->lang->line('insert_success'));
                    redirect('subscription/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('subscription/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['subscriptions'] = $this->subscription->get_subscription_list(); 
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('subs/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Type            : Function
    * @function name   : edit
    * @description     : Load Update "subscription" user interface                 
    *                    with populate "subscription" value 
    *                    and process to update "subscription" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

        check_permission(EDIT);
        if ($_POST) {
            
            $this->_prepare_subscription_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_subscription_data();
                $updated = $this->subscription->update('saas_subscriptions', $data, array('id' => $this->input->post('id')));
                //echo $this->db->last_query();
                //die();
                if ($updated) {
                    
                    success($this->lang->line('update_success'));
                    redirect('subscription/index'); 
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('subscription/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['subscription'] = $this->subscription->get_single('saas_subscriptions', array('id' => $this->input->post('id')));
            }
            
        } else {
            
            if ($id) {
                $this->data['subscription'] = $this->subscription->get_single_subscription($id);

                if (!$this->data['subscription']) {
                     redirect('subscription/index');
                }
            }
        }
        

        $this->data['subscriptions'] = $this->subscription->get_subscription_list(); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('subs/index', $this->data);
    }
    
    
               
     /*****************Function get_single_subscription**********************************
     * @type            : Function
     * @function name   : get_single_subscription
     * @description     : "Load single subscription information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_subscription(){
        
       $subscription_id = $this->input->post('subscription_id');
       
       $this->data['subscription'] = $this->subscription->get_single_subscription($subscription_id);
       echo $this->load->view('subs/get-single-subscription', $this->data);
    }

        
    /*****************Function _prepare_subscription_validation**********************************
    * @Type            : Function
    * @function name   : _prepare_subscription_validation
    * @description     : Process "subscription" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_subscription_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('subscription_plan_id', $this->lang->line('subscription_plan'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('school_name', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim|required');
    }


    /*****************Function _get_posted_subscription_data**********************************
    * @Type            : Function
    * @function name   : _get_posted_subscription_data
    * @description     : Prepare "Subscription" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    
    private function _get_posted_subscription_data() {

       $data = array();               

        $data['subscription_plan_id'] = $this->input->post('subscription_plan_id');
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['school'] = $this->input->post('school_name');        
        $data['address'] = $this->input->post('address');
        
        $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
        $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        $data['subscription_status'] = $this->input->post('subscription_status');
        
        if ($this->input->post('id')) {
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id(); 
        }
        
        return $data;
    }    
        
    
    /*****************Function delete**********************************
    * @Type            : Function
    * @function name   : delete
    * @description     : delete "subscription" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('subscription/index');        
        }
        
        $subscription = $this->subscription->get_single_subscription('saas_subscriptions', array('id' => $id));        
        if ($this->subscription->delete('saas_subscriptions', array('id' => $id))) { 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('subscription/index');
    }
    
}

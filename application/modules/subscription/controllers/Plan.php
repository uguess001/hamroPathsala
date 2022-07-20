<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Plan.php**********************************
 * @product name    : HamroSchool Management System
 * @Type            : Plan
 * @class name      : Plan
 * @description     : Manage  plan.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Plan extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        
         if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard/index');
        }
        
        $this->load->model('Plan_Model', 'plan', true);        
    }

    
    /*****************Function index**********************************
    * @Type            : Function
    * @function name   : index
    * @description     : Load "Plan List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);        
        $this->data['plans'] = $this->plan->get_plan_list(); 
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_subscription_plan').' | ' . SMS);
        $this->layout->view('plan/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Type            : Function
    * @function name   : add
    * @description     : Load "Add new plan" user interface                 
    *                    and process to store "plan" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_plan_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_plan_data();

                $insert_id = $this->plan->insert('saas_plans', $data);
                if ($insert_id) {                    
                    success($this->lang->line('insert_success'));
                    redirect('subscription/plan/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('subscription/plan/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['plans'] = $this->plan->get_plan_list(); 
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('plan/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Type            : Function
    * @function name   : edit
    * @description     : Load Update "plan" user interface                 
    *                    with populate "plan" value 
    *                    and process to update "plan" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

        check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_plan_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_plan_data();
                $updated = $this->plan->update('saas_plans', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    success($this->lang->line('update_success'));
                    redirect('subscription/plan/index'); 
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('subscription/plan/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['plan'] = $this->plan->get_single('saas_plans', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['plan'] = $this->plan->get_single('saas_plans', array('id' => $id));

                if (!$this->data['plan']) {
                     redirect('subscription/plan/index');
                }
            }
        }

        $this->data['plans'] = $this->plan->get_plan_list(); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('plan/index', $this->data);
    }
    
    
               
     /*****************Function get_single_plan**********************************
     * @type            : Function
     * @function name   : get_single_plan
     * @description     : "Load single plan information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_plan(){
        
       $plan_id = $this->input->post('plan_id');
       
       $this->data['plan'] = $this->plan->get_single_plan($plan_id);
       echo $this->load->view('plan/get-single-plan', $this->data);
    }

        
    /*****************Function _prepare_plan_validation**********************************
    * @Type            : Function
    * @function name   : _prepare_plan_validation
    * @description     : Process "plan" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_plan_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('plan_name', $this->lang->line('plan_name'), 'trim|required|callback_plan_name');
        $this->form_validation->set_rules('plan_price', $this->lang->line('price'), 'trim|required');
        $this->form_validation->set_rules('student_limit', $this->lang->line('student_limit'), 'trim|required');
        $this->form_validation->set_rules('teacher_limit', $this->lang->line('teacher_limit'), 'trim|required');
        $this->form_validation->set_rules('guardian_limit', $this->lang->line('guardian_limit'), 'trim|required');
        $this->form_validation->set_rules('employee_limit', $this->lang->line('employee_limit'), 'trim|required');
    }

                    
    /*****************Function plan_name**********************************
    * @Type            : Function
    * @function name   : plan
    * @description     : Unique check for "plan_name " data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function plan_name() {
        if ($this->input->post('id') == '') {
            $plan = $this->plan->duplicate_check($this->input->post('plan_name'));
            if ($plan) {
                $this->form_validation->set_message('plan_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $plan = $this->plan->duplicate_check($this->input->post('plan_name'), $this->input->post('id'));
            if ($plan) {
                $this->form_validation->set_message('plan_name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    /*****************Function _get_posted_plan_data**********************************
    * @Type            : Function
    * @function name   : _get_posted_plan_data
    * @description     : Prepare "Plan" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_plan_data() {

        $items = array();
        $items[] = 'plan_name';
        $items[] = 'plan_price';
        $items[] = 'student_limit';
        $items[] = 'teacher_limit';
        $items[] = 'guardian_limit';
        $items[] = 'employee_limit';
        $items[] = 'is_enable_frontend';
        $items[] = 'is_enable_theme';
        $items[] = 'is_enable_language';
        $items[] = 'is_enable_report';
        $items[] = 'is_enable_inventory';
        $items[] = 'is_enable_lesson_plan';
        $items[] = 'is_enable_online_exam';
        $items[] = 'is_enable_live_class';
        $items[] = 'is_enable_payment_gateway';
        $items[] = 'is_enable_sms_gateway';
        $items[] = 'is_enable_attendance';
        $items[] = 'is_enable_exam_mark';
        $items[] = 'is_enable_accounting';
        $items[] = 'is_enable_payroll';
        $items[] = 'is_enable_asset_management';
        $items[] = 'is_enable_promotion';
        
        $data = elements($items, $_POST);        
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
            $data['status'] = $this->input->post('status');
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
    * @description     : delete "plan" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('subscription/plan/index');        
        }
        
        $plan = $this->plan->get_single_plan('saas_plans', array('id' => $id));        
        if ($this->plan->delete('saas_plans', array('id' => $id))) { 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('subscription/plan/index');
    }
}

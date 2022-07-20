<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Warehouse.php**********************************
 * @supplier title    : Global - Multi School Management System Express
 * @type            : Store
 * @class name      : supplier
 * @description     : Manage school academic Store for student, guardian, teacer and employee.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Store extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Store_Model', 'store', true);   
        
         // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_asset_management')){                        
              redirect('dashboard/index');
            }
        }
    }

    
    /*****************Function store**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "store List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['stores'] = $this->store->get_store_list($school_id);
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_store') . ' | ' . SMS);
        $this->layout->view('store/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new store" user interface                 
    *                    and process to store "store" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_store_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_store_data();

                $insert_id = $this->store->insert('asset_stores', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a store : '.$data['name']);                       
                    success($this->lang->line('insert_success'));
                    redirect('asset/store/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('asset/store/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['stores'] = $this->store->get_store_list();   
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('store/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "store" user interface                 
    *                    with populated "store" value 
    *                    and process update "store" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('asset/store/index');
        }
        
        if ($_POST) {
            $this->_prepare_store_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_store_data();
                $updated = $this->store->update('asset_stores', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    create_log('Has been updated a store : '.$data['name']);
                    success($this->lang->line('update_success'));
                    redirect('asset/store/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('asset/store/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['store'] = $this->store->get_single('asset_stores', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['store'] = $this->store->get_single('asset_stores', array('id' => $id));
            if (!$this->data['store']) {
                redirect('asset/store/index');
            }
        }

        $this->data['stores'] = $this->store->get_store_list($this->data['store']->school_id);
        $this->data['school_id'] = $this->data['store']->school_id;
        $this->data['filter_school_id'] = $this->data['store']->school_id;
        $this->data['schools'] = $this->schools;
         
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('store/index', $this->data);
    }

      
           
     /*****************Function get_single_store**********************************
     * @type            : Function
     * @function name   : get_single_store
     * @description     : "Load single store information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_store(){
        
       $store_id = $this->input->post('store_id');   
       $this->data['store'] = $this->store->get_single_store($store_id);
       echo $this->load->view('store/get-single-store', $this->data);
    }

    
        
    /*****************Function store**********************************
    * @type            : Function
    * @function name   : _prepare_store_validation
    * @description     : Process "store" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_store_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('name',' ' . $this->lang->line('name'), 'trim|required');
        $this->form_validation->set_rules('keeper',$this->lang->line('store_keeper'), 'trim');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function name**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "store name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $store = $this->store->duplicate_check($this->input->post('school_id'), $this->input->post('name'));
            if ($store) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }else if ($this->input->post('id') != '') {
            $store = $this->store->duplicate_check($this->input->post('school_id'), $this->input->post('name'), $this->input->post('id'));
            if ($store) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    
    /*****************Function _get_posted_supplier_data**********************************
    * @type            : Function
    * @function name   : _get_posted_store_data
    * @description     : Prepare "store" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_store_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'keeper';
        $items[] = 'phone';
        $items[] = 'address';
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
        }

        return $data;
    }

    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "store" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('asset/store/index');
        }
        
        $store = $this->store->get_single('asset_stores', array('id' => $id));
        
        if ($this->store->delete('asset_stores', array('id' => $id))) {
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
       redirect('asset/store/index');
    }

}

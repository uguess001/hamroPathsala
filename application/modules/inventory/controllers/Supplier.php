<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************supplier.php**********************************
 * @supplier title    : Global School Management System Pro
 * @type            : Class
 * @class name      : supplier
 * @description     : Manage school inventory supplier for student, guardian, teacer and employee.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Supplier extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Supplier_Model', 'supplier', true);    
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_inventory')){                        
              redirect('dashboard/index');
            }
        }
    }

    
    /*****************Function supplier**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "supplier List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['suppliers'] = $this->supplier->get_supplier_list($school_id);
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_supplier') . ' | ' . SMS);
        $this->layout->view('supplier/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new supplier" user interface                 
    *                    and process to store "supplier" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_supplier_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_supplier_data();

                $insert_id = $this->supplier->insert('item_suppliers', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a supplier : '.$data['company']); 
                    success($this->lang->line('insert_success'));
                    redirect('inventory/supplier/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('inventory/supplier/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['suppliers'] = $this->supplier->get_supplier_list();  
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('supplier/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "supplier" user interface                 
    *                    with populated "supplier" value 
    *                    and process update "supplier" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('inventory/supplier/index');
        }
        
        if ($_POST) {
            $this->_prepare_supplier_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_supplier_data();
                $updated = $this->supplier->update('item_suppliers', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    create_log('Has been updated a supplier : '.$data['company']); 
                    success($this->lang->line('update_success'));
                    redirect('inventory/supplier/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('inventory/supplier/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['supplier'] = $this->supplier->get_single('item_suppliers', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['supplier'] = $this->supplier->get_single('item_suppliers', array('id' => $id));

            if (!$this->data['supplier']) {
                redirect('inventory/supplier/index');
            }
        }

        $this->data['suppliers'] = $this->supplier->get_supplier_list($this->data['supplier']->school_id);  
        $this->data['school_id'] = $this->data['supplier']->school_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('supplier/index', $this->data);
    }

      
           
     /*****************Function get_single_supplier**********************************
     * @type            : Function
     * @function name   : get_single_supplier
     * @description     : "Load single supplier information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_supplier(){
        
       $supplier_id = $this->input->post('supplier_id');   
       $this->data['supplier'] = $this->supplier->get_single_supplier($supplier_id);
       echo $this->load->view('supplier/get-single-supplier', $this->data);
    }

    
        
    /*****************Function _prepare_supplier_validation**********************************
    * @type            : Function
    * @function name   : _prepare_supplier_validation
    * @description     : Process "supplier" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_supplier_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('company',' ' . $this->lang->line('company'), 'trim|required');
        $this->form_validation->set_rules('contact', $this->lang->line('contact_name'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function company**********************************
    * @type            : Function
    * @function name   : company
    * @description     : Unique check for "supplier company" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function company() {
        if ($this->input->post('id') == '') {
            $supplier = $this->supplier->duplicate_check($this->input->post('company'));
            if ($supplier) {
                $this->form_validation->set_message('company', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $supplier = $this->supplier->duplicate_check($this->input->post('company'), $this->input->post('id'));
            if ($supplier) {
                $this->form_validation->set_message('company', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_supplier_data**********************************
    * @type            : Function
    * @function name   : _get_posted_supplier_data
    * @description     : Prepare "supplier" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_supplier_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'company';
        $items[] = 'contact';
        $items[] = 'email';
        $items[] = 'phone';
        $items[] = 'address';
        $items[] = 'note';
        
        $data = elements($items, $_POST);

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();

        if ($this->input->post('id')) {
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['status'] = 1;
        }
        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "supplier" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            
            error($this->lang->line('unexpected_error'));
            redirect('inventory/supplier/index');
        }
        
        $supplier = $this->supplier->get_single('item_suppliers', array('id' => $id));
        
        if ($this->supplier->delete('item_suppliers', array('id' => $id))) {
            
            create_log('Has been deleted a supplier : '.$supplier->company);   
            success($this->lang->line('delete_success'));
            redirect('inventory/supplier/index/'.$supplier->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
       redirect('inventory/supplier/index');
    }

}

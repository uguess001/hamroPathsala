<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Warehouse.php**********************************
 * @supplier title    : Global School Management System Pro
 * @type            : Class
 * @class name      : supplier
 * @description     : Manage school inventory warehouse.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Warehouse extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Warehouse_Model', 'warehouse', true);  
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_inventory')){                        
              redirect('dashboard/index');
            }
        }
    }

    
    /*****************Function warehouse**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "warehouse List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);

        $this->data['warehouses'] = $this->warehouse->get_warehouse_list($school_id);
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_warehouse') . ' | ' . SMS);
        $this->layout->view('warehouse/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new warehouse" user interface                 
    *                    and process to store "warehouse" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_warehouse_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_warehouse_data();

                $insert_id = $this->warehouse->insert('item_warehouses', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a warehouse : '.$data['name']);
                    success($this->lang->line('insert_success'));
                    redirect('inventory/warehouse/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('inventory/warehouse/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['warehouses'] = $this->warehouse->get_warehouse_list(); 
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('warehouse/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "warehouse" user interface                 
    *                    with populated "warehouse" value 
    *                    and process update "warehouse" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('inventory/warehouse/index');
        }
        
        if ($_POST) {
            $this->_prepare_warehouse_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_warehouse_data();
                $updated = $this->warehouse->update('item_warehouses', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated a warehouse : '.$data['name']);  
                    success($this->lang->line('update_success'));
                    redirect('inventory/warehouse/index/'.$data['school_id']);
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('inventory/warehouse/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['warehouse'] = $this->warehouse->get_single('item_warehouses', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['warehouse'] = $this->warehouse->get_single('item_warehouses', array('id' => $id));

            if (!$this->data['warehouse']) {
                redirect('inventory/warehouse/index');
            }
        }

        $this->data['warehouses'] = $this->warehouse->get_warehouse_list($this->data['warehouse']->school_id); 
        $this->data['school_id'] = $this->data['warehouse']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('warehouse/index', $this->data);
    }

      
           
     /*****************Function get_single_warehouse**********************************
     * @type            : Function
     * @function name   : get_single_warehouse
     * @description     : "Load single warehouse information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_warehouse(){
        
       $warehouse_id = $this->input->post('warehouse_id');   
       $this->data['warehouse'] = $this->warehouse->get_single_warehouse($warehouse_id);
       echo $this->load->view('warehouse/get-single-warehouse', $this->data);
    }

    
        
    /*****************Function _prepare_warehouse_validation**********************************
    * @type            : Function
    * @function name   : _prepare_warehouse_validation
    * @description     : Process "warehouse" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_warehouse_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('name', $this->lang->line('warehouse'), 'trim|required|callback_name');
        $this->form_validation->set_rules('keeper',$this->lang->line('warehouse_keeper'), 'trim');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim');
        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "warehouse name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $ware = $this->warehouse->duplicate_check($this->input->post('school_id'),$this->input->post('name'));
            if ($ware) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $ware = $this->warehouse->duplicate_check($this->input->post('school_id'),$this->input->post('name'), $this->input->post('id'));
            if ($ware) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_supplier_data**********************************
    * @type            : Function
    * @function name   : _get_posted_warehouse_data
    * @description     : Prepare "warehouse" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_warehouse_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'name';
        $items[] = 'keeper';
        $items[] = 'email';
        $items[] = 'phone';
        $items[] = 'address';
        $items[] = 'note';
        
        $data = elements($items, $_POST);


        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
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
    * @description     : delete "warehouse" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('inventory/warehouse/index');
        }
        
        $warehouse = $this->warehouse->get_single('item_warehouses', array('id' => $id));
        
        if ($this->warehouse->delete('item_warehouses', array('id' => $id))) {
            
            create_log('Has been deleted a warehouse : '.$warehouse->name);   
            success($this->lang->line('delete_success'));
            redirect('inventory/warehouse/index/'.$warehouse->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
       redirect('inventory/warehouse/index');
       
    }

}

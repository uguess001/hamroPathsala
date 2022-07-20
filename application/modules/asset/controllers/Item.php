<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Item.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Item
 * @class name      : Item
 * @description     : Manage Item.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Item extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Item_Model', 'item', true);        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Item List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {

        check_permission(VIEW);
                         
        $this->data['items'] = $this->item->get_item_list($school_id);  
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['stores'] = $this->item->get_list('asset_stores', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->item->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
        }        
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_item') .' | ' . SMS);
        $this->layout->view('item/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Itm" user interface                 
    *                    and process to store "Item" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_item_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_item_data();

                $insert_id = $this->item->insert('asset_items', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a item');                     
                    success($this->lang->line('insert_success'));
                    redirect('asset/item/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('asset/item/add');
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;
            }
        }
             
        $this->data['items'] = $this->item->get_item_list();  
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['stores'] = $this->item->get_list('asset_stores', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->item->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
        } 
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('item/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Item" user interface                 
    *                    with populated "Item" value 
    *                    and process to update "Item" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('asset/item/index');
        }
       
        if ($_POST) {
            $this->_prepare_item_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_item_data();
                $updated = $this->item->update('asset_items', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    create_log('Has been updated an item');                    
                    success($this->lang->line('update_success'));
                    redirect('asset/item/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('asset/item/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['item'] = $this->item->get_single('asset_items', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['item'] = $this->item->get_single_item($id);
            if (!$this->data['item']) {
                redirect('asset/item/index');
            }
        }
        
        $this->data['items'] = $this->item->get_item_list( $this->data['item']->school_id);    
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['stores'] = $this->item->get_list('asset_stores', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->item->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
        } 
        
        $this->data['school_id'] = $this->data['item']->school_id;
        $this->data['filter_school_id'] = $this->data['item']->school_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('item/index', $this->data);
    }

       
           
     /*****************Function get_single_item**********************************
     * @type            : Function
     * @function name   : get_single_item
     * @description     : "Load single item information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_item(){
        
       $item_id = $this->input->post('item_id');
       
       $this->data['item'] = $this->item->get_single_item($item_id);
       echo $this->load->view('item/get-single-item', $this->data);
    }

    
    /*****************Function _prepare_item_validation**********************************
    * @type            : Function
    * @function name   : _prepare_item_validation
    * @description     : Process "item" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_item_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('category_id',' ' . $this->lang->line('category'), 'trim|required');
        $this->form_validation->set_rules('store_id',' ' . $this->lang->line('store'), 'trim|required');
        $this->form_validation->set_rules('code',' ' . $this->lang->line('code'), 'trim');
        $this->form_validation->set_rules('name',' ' . $this->lang->line('name'), 'trim|required|callback_name');
        $this->form_validation->set_rules('type',' ' . $this->lang->line('type'), 'trim');  
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        
    }

    /*****************Function Faq**********************************
    * @Type            : Function
    * @function name   : Item
    * @description     : Unique check for "Item " data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $name = $this->item->duplicate_check($this->input->post('school_id'), $this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->item->duplicate_check($this->input->post('school_id'), $this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    
    /*****************Function _get_posted_item_data**********************************
    * @type            : Function
    * @function name   : _get_posted_item_data
    * @description     : Prepare "item" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_item_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'category_id';
        $items[] = 'store_id';
        $items[] = 'code';
        $items[] = 'name';
        $items[] = 'type';
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
    * @description     : delete "item" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('asset/item//index');
        }
        
        $item = $this->item->get_single_item($id);
        
        if ($this->item->delete('asset_items', array('id' => $id))) {
            
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('asset/item/index/'.$item->school_id);
    }

    
    
   /*****************Function get_category_by_school**********************************
     * @type            : Function
     * @function name   : get_category_by_school
     * @description     : Load "Category Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_category_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $category_id  = $this->input->post('category_id');
        
        $categories = $this->item->get_list('asset_categories', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($categories)) {
            foreach ($categories as $obj) {   
                
                $selected = $category_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*****************Function get_store_by_school**********************************
     * @type            : Function
     * @function name   : get_store_by_school
     * @description     : Load "Store Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_store_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $store_id  = $this->input->post('store_id');
         
        $stores = $this->item->get_list('asset_stores', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($stores)) {
            foreach ($stores as $obj) {   
                
                $selected = $store_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
                
            }
        }

        echo $str;
    }
    
}

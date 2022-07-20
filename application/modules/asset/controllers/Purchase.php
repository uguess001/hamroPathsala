<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Purchase.php**********************************
 * @purchase title  : Global - Multi School Management System Express
 * @type            : Purchase
 * @class name      : purchase
 * @description     : Manage school Asset purchase.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ***********************************************************/

class Purchase extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Purchase_Model', 'purchase', true); 
        
         // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_asset_management')){                        
              redirect('dashboard/index');
            }
        }
    }

    
    /*****************Function purchases**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "purchase List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = NULL) {

        check_permission(VIEW);

        $this->data['purchases'] = $this->purchase->get_purchase_list($school_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] =  $this->session->userdata('school_id'); 
            $this->data['vendors'] = $this->purchase->get_list('asset_vendors', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->purchase->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
            $this->data['employees'] = $this->purchase->get_list('employees', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_purchase') . ' | ' . SMS);
        $this->layout->view('purchase/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new purchase" user interface                 
    *                    and process to store "purchase" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_purchase_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_purchase_data();
                $insert_id = $this->purchase->insert('asset_purchases', $data);
                
                if ($insert_id) {  
                    
                    $this->__update_stock();
                     
                    success($this->lang->line('insert_success'));
                    redirect('asset/purchase/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('asset/purchase/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }
        
        $this->data['purchases'] = $this->purchase->get_purchase_list();
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            
            $condition['school_id'] =  $this->session->userdata('school_id'); 
            $this->data['vendors'] = $this->purchase->get_list('asset_vendors', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->purchase->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
            $this->data['employees'] = $this->purchase->get_list('employees', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('purchase/index', $this->data);
    }

    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "purchase" user interface                 
    *                    with populated "purchase" value 
    *                    and process update "purchase" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('asset/purchase/index');
        }
        
        if ($_POST) {
            $this->_prepare_purchase_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_purchase_data();
                $updated = $this->purchase->update('asset_purchases', $data, array('id' => $this->input->post('id')));

                if ($updated) {

                    $this->__update_stock();
                    
                    success($this->lang->line('update_success'));
                    redirect('asset/purchase/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('asset/purchase/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['purchase'] = $this->purchase->get_single('asset_purchases', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['purchase'] = $this->purchase->get_single('asset_purchases', array('id' => $id));

            if (!$this->data['purchase']) {
                redirect('asset/purchase/index');
            }
        }

        $this->data['purchases'] = $this->purchase->get_purchase_list($this->data['purchase']->school_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] =  $this->session->userdata('school_id'); 
            $this->data['vendors'] = $this->purchase->get_list('asset_vendors', $condition, '','', '', 'id', 'ASC');
            $this->data['categories'] = $this->purchase->get_list('asset_categories', $condition, '','', '', 'id', 'ASC');
            $this->data['employees'] = $this->purchase->get_list('employees', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['school_id'] = $this->data['purchase']->school_id;
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('purchase/index', $this->data);
    }

      
     /*****************Function get_single_purchase**********************************
     * @type            : Function
     * @function name   : get_single_purchase
     * @description     : "Load single purchase information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_purchase(){
        
       $purchase_id = $this->input->post('purchase_id');   
       $this->data['purchase'] = $this->purchase->get_single_purchase($purchase_id);
       echo $this->load->view('purchase/get-single-purchase', $this->data);
    }

        
    /*****************Function _prepare_purchase_validation**********************************
    * @type            : Function
    * @function name   : _prepare_purchase_validation
    * @description     : Process "purchase" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_purchase_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('vendor_id',' ' . $this->lang->line('vendor'), 'trim|required');
        $this->form_validation->set_rules('employee_id',' ' . $this->lang->line('purchase_by'), 'trim|required');
        $this->form_validation->set_rules('category_id',' ' . $this->lang->line('category'), 'trim|required');
        $this->form_validation->set_rules('item_id',' ' . $this->lang->line('item'), 'trim|required');
        $this->form_validation->set_rules('qty',' ' . $this->lang->line('quantity'), 'trim|required'); 
        $this->form_validation->set_rules('unit_type',' ' . $this->lang->line('unit_type'), 'trim'); 
        $this->form_validation->set_rules('unit_price',' ' . $this->lang->line('unit_price'), 'trim|required');
        $this->form_validation->set_rules('purchase_date',' ' . $this->lang->line('purchase_date'), 'trim|required');
        $this->form_validation->set_rules('expire_date',' ' . $this->lang->line('expire_date'), 'trim');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }


    
    /*****************Function _get_posted_purchase_data**********************************
    * @type            : Function
    * @function name   : _get_posted_purchase_data
    * @description     : Prepare "purchase" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_purchase_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'vendor_id';
        $items[] = 'employee_id';
        $items[] = 'category_id';
        $items[] = 'item_id';
        $items[] = 'qty';
        $items[] = 'unit_type';
        $items[] = 'unit_price';
        $items[] = 'note';
        
        $data = elements($items, $_POST);
        
        $data['purchase_date'] = date('Y-m-d', strtotime($this->input->post('purchase_date')));
        $data['expire_date'] = date('Y-m-d', strtotime($this->input->post('expire_date')));
        $data['total_price'] = $data['qty'] * $data['unit_price'];

        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if($this->input->post('id')) {
            
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
    * @description     : delete "purchase" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);       
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('asset/purchase/index');
        }
        
        $purchase = $this->purchase->get_single('asset_purchases', array('id' => $id));
        
        if(empty($purchase)){
            error($this->lang->line('unexpected_error'));
            redirect('asset/purchase/index');   
        }
        
        $stock = $this->purchase->get_single('asset_stocks', array('item_id' => $purchase->item_id, 'school_id'=>$purchase->school_id));
        
        if(!empty($stock) && $purchase->qty > $stock->total_qty){
            error($this->lang->line('purchase_qty_already_used'));
            redirect('asset/purchase/index');   
        }
        
        if ($this->purchase->delete('asset_purchases', array('id' => $id))) {
            
             // reduce item qty from main qty
            $sql = "UPDATE asset_stocks SET total_qty = total_qty-$purchase->qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $purchase->item_id AND school_id = $purchase->school_id";
            $this->db->query($sql);            
            
            success($this->lang->line('delete_success'));
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
       redirect('asset/purchase/index');
       
    }
    
    
    private function __update_stock(){
        
        $data = array();
        $school_id = $this->input->post('school_id');
        $item_id = $this->input->post('item_id');
        $old_item_id = $this->input->post('old_item_id');
        
        $stock = $this->purchase->get_single('asset_stocks', array('status' => 1, 'item_id'=>$item_id,'school_id'=>$school_id));        
        if (empty($stock)) {
            
            $data['school_id'] = $school_id;
            $data['item_id'] = $item_id;
            $data['total_qty'] = 0;
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id(); 
            $this->purchase->insert('asset_stocks', $data);
        }
        
        $qty = $this->input->post('qty');
        
        if ($this->input->post('id') && $item_id == $old_item_id) {
            
            $old_qty = $this->input->post('old_qty');
            
            $sql = "UPDATE asset_stocks SET total_qty = total_qty-$old_qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $item_id AND school_id = $school_id";
            $this->db->query($sql);
            
            $sql = "UPDATE asset_stocks SET total_qty = total_qty+$qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $item_id AND school_id = $school_id";
            $this->db->query($sql);
            
        }else if ($this->input->post('id') && $item_id != $old_item_id) {
            
            $old_qty = $this->input->post('old_qty');
            
            // for old item
            $sql = "UPDATE asset_stocks SET total_qty = total_qty-$old_qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $old_item_id AND school_id = $school_id";
            $this->db->query($sql);
            
            // for new item 
            $sql = "UPDATE asset_stocks SET total_qty = total_qty+$qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $item_id AND school_id = $school_id";
            $this->db->query($sql);  
                        
        }else{
            
            $sql = "UPDATE asset_stocks SET total_qty = total_qty+$qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE item_id = $item_id AND school_id = $school_id";
            $this->db->query($sql);
        }        
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
        
        $categories = $this->purchase->get_list('asset_categories', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
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
    
    /*****************Function get_vendor_by_school**********************************
     * @type            : Function
     * @function name   : get_vendor_by_school
     * @description     : Load "Store Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_vendor_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $vendor_id  = $this->input->post('vendor_id');
         
        $vendor = $this->purchase->get_list('asset_vendors', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($vendor)) {
            foreach ($vendor as $obj) {   
                
                $selected = $vendor_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
            }
        }

        echo $str;
    }
    
    /*****************Function get_employee_by_school**********************************
     * @type            : Function
     * @function name   : get_vendor_by_school
     * @description     : Load "Store Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_employee_by_school() {
        
        $school_id  = $this->input->post('school_id');
        $employee_id  = $this->input->post('employee_id');
         
        $employee = $this->purchase->get_list('employees', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        $select = 'selected="selected"';
        if (!empty($employee)) {
            foreach ($employee as $obj) {   
                
                $selected = $employee_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
            }
        }

        echo $str;
    }
    
    /*** *************Function get_item_by_category**********************************
     * @type            : Function
     * @function name   : get_item_by_category
     * @description     : this function used to populate Item list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with subject list
     * ********************************************************** */
    public function get_item_by_category() {

        $school_id = $this->input->post('school_id');
        $category_id = $this->input->post('category_id');
        $item_id = $this->input->post('item_id');
       
        $items = $this->purchase->get_list('asset_items', array('status' => 1, 'category_id' => $category_id, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
       
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
       
        $select = 'selected="selected"';
        if(!empty($items)) {
            foreach ($items as $obj) {
                $selected = $item_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name . '</option>';
            }
        }

        echo $str;
    }
}

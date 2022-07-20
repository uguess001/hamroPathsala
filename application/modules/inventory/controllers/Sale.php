<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Sale.php**********************************
 * @sale    : HamroSchool Management System
 * @type            : Issue
 * @class name      : Sale
 * @description     : Manage Inventory product sale.
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Sale extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Sale_Model', 'sale', true);  
        $this->data['roles'] = $this->sale->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_inventory')){                        
              redirect('dashboard/index');
            }
        }
    }

   
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Sales List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = NULL) {

        check_permission(VIEW);
        
        $this->data['sales'] = $this->sale->get_sale_list($school_id);
        $this->data['income_heads'] = $this->sale->get_fee_types($school_id);   
        
       
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
           $condition['school_id'] =  $this->session->userdata('school_id'); 
           $this->data['classes'] = $this->sale->get_list('classes', $condition, '','', '', 'id', 'ASC');
           $this->data['categories'] = $this->sale->get_list('item_categories', $condition, '','', '', 'id', 'ASC');
           
        }   
        
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_sale'). ' | ' . SMS);
        $this->layout->view('sale/index', $this->data);
        
    }   

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Sales" user interface                 
    *                    and process sale into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {
       
        check_permission(ADD);

        if ($_POST) {
            
            $this->_prepare_sale_validation();
            if ($this->form_validation->run() === TRUE) {
               
                $insert_id = $this->_get_posted_sale_data();
                
                if ($insert_id) {                    
                    success($this->lang->line('insert_success'));
                    redirect('inventory/sale/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('inventory/sale/add');
                }
            } else {
                $this->data['post'] = $_POST;                
            }
        }
        
        $this->data['income_heads'] = $this->sale->get_fee_types();  
        $this->data['sales'] = $this->sale->get_sale_list();               
       
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
           $condition['school_id'] =  $this->session->userdata('school_id'); 
           $this->data['classes'] = $this->sale->get_list('classes', $condition, '','', '', 'id', 'ASC');
           $this->data['categories'] = $this->sale->get_list('item_categories', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;
        
        $this->data['add'] = TRUE;        
        $this->layout->title($this->lang->line('add') .' | '. SMS);
        $this->layout->view('sale/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Issue" user interface                 
    *                    with populated "Issue" value 
    *                    and process to update "Issue" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit_xxx($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('inventory/sale/index');
        }
       
        if ($_POST) {
            $this->_prepare_sale_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_sale_data();
                $updated = $this->sale->update('item_sales', $data, array('id' => $this->input->post('id')));

                if ($updated) {                   
                   
                    create_log('Has been updated sale');                    
                    success($this->lang->line('update_success'));
                    redirect('inventory/sale/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('inventory/sale/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['sale'] = $this->sale->get_single_sale($this->input->post('id'));
            }
        }

        if ($id) {
            
            $this->data['sale'] = $this->sale->get_single_sale($id);
            if (!$this->data['sale']) {
                redirect('inventory/sale/index');
            }
        }

        $this->data['income_heads'] = $this->sale->get_fee_types($this->data['sale']->school_id);  
        $this->data['sales'] = $this->sale->get_sale_list($this->data['sale']->school_id);   
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){
            $condition['school_id'] =  $this->session->userdata('school_id'); 
           $this->data['classes'] = $this->sale->get_list('classes', $condition, '','', '', 'id', 'ASC');
           $this->data['categories'] = $this->sale->get_list('item_categories', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['school_id'] = $this->data['sale']->school_id;
        $this->data['filter_school_id'] = $this->data['sale']->school_id;
        $this->data['schools'] = $this->schools; 
               
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('inventory/sale/index', $this->data);
    }

       
           
     /*****************Function get_single_sales**********************************
     * @type            : Function
     * @function name   : get_single_sales
     * @description     : "Load single sale information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_sale(){
        
        // here sale_id is invoice_id
        
       $sale_id = $this->input->post('sale_id');   
       
        $txn_amount   = $this->sale->get_invoice_amounts($sale_id);        
        $this->data['paid_amount'] = $txn_amount->paid_amount;
        $this->data['sale'] = $this->sale->get_single_sale($sale_id);
        $this->data['sale_items'] = $this->sale->get_sale_items($sale_id);
        $this->data['settings'] = $this->sale->get_single('schools', array('status'=>1, 'id'=>$this->data['sale']->school_id));
        
        echo $this->load->view('sale/get-single-sale', $this->data);
        
    }

    
    /*****************Function _prepare_sale_validation**********************************
    * @type            : Function
    * @function name   : _prepare_sale_validation
    * @description     : Process "sale" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_sale_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
         
        $this->form_validation->set_rules('role_id', $this->lang->line('user_type'), 'trim|required');
        $this->form_validation->set_rules('income_head_id', $this->lang->line('income_head'), 'trim|required');
        
        if($this->input->post('role_id') == STUDENT){
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
        }
        
        $this->form_validation->set_rules('user_id', $this->lang->line('sale_to'), 'trim|required');
        
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
        
        if($this->input->post('grand_total') > 0 ){
           $this->form_validation->set_rules('payment_method', $this->lang->line('payment_method'), 'trim|required');   
        }
        
        if($this->input->post('payment_method') == 'cheque' ){
           $this->form_validation->set_rules('bank_name', $this->lang->line('bank_name'), 'trim|required');   
           $this->form_validation->set_rules('cheque_no', $this->lang->line('cheque_number'), 'trim|required');   
        }
        if($this->input->post('payment_method') == 'receipt' ){
           $this->form_validation->set_rules('bank_receipt', $this->lang->line('bank_receipt'), 'trim|required');   
        }
        
    }
    
    
    /*****************Function _get_posted_sale_data**********************************
    * @type            : Function
    * @function name   : _get_posted_sale_data
    * @description     : Prepare "Issue" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_sale_data() {
           
        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'class_id';
        $items[] = 'user_id';             
        $items[] = 'paid_status';
        $items[] = 'discount';
        $items[] = 'note';
        
        $data = elements($items, $_POST);
        
        $sale_amount = $this->input->post('hidden_grand_total');        
        if($sale_amount <= 0){
            error($this->lang->line('unexpected_error'));
            redirect('inventory/sale/add');
        }
                            
        $data['is_applicable_discount'] = 0;
        $data['gross_amount'] = $sale_amount;
        
        $data['net_amount'] = $sale_amount - $data['discount'];
        
        $data['invoice_type'] = 'sale';              
        $data['month'] = date('m-Y', strtotime($this->input->post('date')));
        $data['date']  = date('Y-m-d', strtotime($this->input->post('date'))); 
            
        $data['custom_invoice_id'] = $this->sale->get_custom_id('invoices', 'INV');
        
        
        $data['status'] = 1;
        
        $school = $this->sale->get_school_by_id($data['school_id']);

        if(!$school->academic_year_id){
            error($this->lang->line('please_set_academic_year'));
            redirect('inventory/sale/index/'.$data['school_id']);
        }             

        $data['academic_year_id'] = $school->academic_year_id;

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = logged_in_user_id();   
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
         
        // save invoice data
         $invoice_id = $this->sale->insert('invoices', $data);
                 
        // save sales detail data
        foreach ($this->input->post('category_id') as $key=>$value){
            
            $inv_detail = array();
            $inv_detail['invoice_id'] = $invoice_id;
            $inv_detail['invoice_type'] = 'sale';
            $inv_detail['income_head_id'] = $this->input->post('income_head_id');
            
            $inv_detail['category_id'] = $value;
            $inv_detail['product_id'] = $this->input->post('product_id')[$key];            
            $inv_detail['qty'] = $this->input->post('qty')[$key];
            $inv_detail['unit_price'] = $this->input->post('unit_price')[$key];
            $inv_detail['total_price'] = $this->input->post('total_price')[$key];
            $inv_detail['net_amount'] = $this->input->post('total_price')[$key];
           
            $inv_detail['status'] = 1;
            $inv_detail['created_at'] = date('Y-m-d H:i:s');
            $inv_detail['created_by'] = logged_in_user_id();   
            $inv_detail['modified_at'] = date('Y-m-d H:i:s');
            $inv_detail['modified_by'] = logged_in_user_id();
            $this->sale->insert('item_sales', $inv_detail);
            
            // now we need to update qty stock
            $this->__update_stock($data['school_id'], $inv_detail['product_id'], $inv_detail['qty']);
            
        }
        
         // save transction table data
        $data['invoice_id'] = $invoice_id;
        $this->_save_transaction($data);        
        create_log('Has been created a product sale of amount : '. $data['net_amount']);
        return $invoice_id;
   
    }

    
    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Issue" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('inventory/sale/index');
        }
        
        $invoice = $this->sale->get_single('invoices', array('id' => $id));
        if($invoice->paid_status != 'unpaid'){
            error($this->lang->line('unexpected_error'));
            redirect('inventory/sale/index/'.$invoice->school_id);
        }
        
        if ($this->sale->delete('invoices', array('id' => $id))) {            
            
            $item_sales = $this->sale->get_list('item_sales', array('invoice_id' => $id));
            if(!empty($item_sales)){
                foreach($item_sales as $obj){
                    
                    // return item qty to main qty        
                    $sql = "UPDATE item_stocks SET total_qty = total_qty+$obj->qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE product_id = $obj->product_id";
                    $this->db->query($sql);
                    $this->sale->delete('item_sales', array('id' => $obj->id));
                }
            }                       
            
            success($this->lang->line('delete_success'));
            redirect('inventory/sale/index');
            
        } else {
            error($this->lang->line('delete_failed'));
        }   
        
        redirect('inventory/sale/index');
    }
        
        
    /*****************Function _save_transaction**********************************
     * @type            : Function
     * @function name   : _save_transaction
     * @description     : transaction data save/update into database 
     *                    while add/update income data into database                
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    private function _save_transaction($data){
        
        if($data['paid_status'] != 'unpaid'){
        
            $txn = array();
            $txn['amount'] = $this->input->post('grand_total');  
            $txn['note'] = $data['note'];
            $txn['payment_date'] = $data['date'];
            $txn['payment_method'] = $this->input->post('payment_method');
            $txn['bank_name'] = $this->input->post('bank_name');
            $txn['cheque_no'] = $this->input->post('cheque_no');
            $txn['bank_receipt'] = $this->input->post('bank_receipt');
            
            if($txn['payment_method'] == 'cash'){
                $txn['bank_name'] = '';
                $txn['cheque_no'] = '';
                $txn['bank_receipt'] = '';
            }else if($txn['payment_method'] == 'cheque'){
                $txn['bank_receipt'] = '';
            }else if($txn['payment_method'] == 'receipt'){
                $txn['bank_name'] = '';
                $txn['cheque_no'] = '';
            }

            if ($this->input->post('id')) {

                $txn['modified_at'] = date('Y-m-d H:i:s');
                $txn['modified_by'] = logged_in_user_id();
                $this->sale->update('transactions', $txn, array('invoice_id'=>$this->input->post('id')));

            } else {            

                $txn['school_id'] = $data['school_id'];
                $txn['invoice_id'] = $data['invoice_id'];
                $txn['status'] = 1;
                $txn['academic_year_id'] = $data['academic_year_id'];            
                $txn['created_at'] = $data['created_at'];
                $txn['created_by'] = $data['created_by'];
                $txn['modified_at'] = date('Y-m-d H:i:s');
                $txn['modified_by'] = logged_in_user_id();
                $this->sale->insert('transactions', $txn);
            }        
        }
    }
    
            
    private function __update_stock($school_id, $product_id, $qty){
              
        $sql = "UPDATE item_stocks SET total_qty = total_qty-$qty , modified_at = '".date('Y-m-d H:i:s')."' WHERE product_id = $product_id AND school_id = $school_id";
        $this->db->query($sql);               
    }

    
    //* AJAX ====================================
    
    public function check_quantity(){
        
        $qty = $this->input->post('qty');
        $product_id = $this->input->post('product_id');
        $category_id = $this->input->post('category_id');
        
        $stock = $this->sale->get_single('item_stocks', array('product_id' => $product_id));
                
        if(empty($stock)){
            echo FALSE;
            
        }else if (!empty($stock) && $qty > $stock->total_qty) {
            echo FALSE; 
            
        } else {
            echo TRUE;            
        }
        
        die();
    }
    
       
    
    public function add_more_product(){
        
        $school_id = $this->input->post('school_id');
        $this->data['categories'] = $this->sale->get_list('item_categories', array('status' => 1, 'school_id'=>$school_id), '','', '', 'id', 'ASC');
        echo $this->load->view('sale/add-more-product', $this->data);
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
        
        $categories = $this->sale->get_list('item_categories', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC'); 
         
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
    
    
        /*****************Function get_fee_type_by_school**********************************
     * @type            : Function
     * @function name   : get_fee_type_by_school
     * @description     : Load "Category Listing" by ajax call                
     *                    and populate user listing
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    
    public function get_fee_type_by_school() {
        
        $school_id  = $this->input->post('school_id');
        
        $fee_types = $this->sale->get_fee_types($school_id); 
         
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';
        if (!empty($fee_types)) {
            foreach ($fee_types as $obj) {   
                
                $str .= '<option value="' . $obj->id . '">' . $obj->title . '</option>';
                
            }
        }

        echo $str;
    }
    
    
    /*** *************Function get_product_by_category**********************************
     * @type            : Function
     * @function name   : get_product_by_category
     * @description     : this function used to populate Product list by class 
      for user interface
     * @param           : null 
     * @return          : $str string  value with subject list
     * ********************************************************** */
    
    public function get_product_by_category(){
        
       $school_id  = $this->input->post('school_id'); 
       $category_id = $this->input->post('category_id');
       $product_id = $this->input->post('product_id');  
       
       $products = $this->sale->get_list('item_products', array('status' => 1, 'category_id' => $category_id, 'school_id'=>$school_id), '', '', '', 'id', 'ASC');
       
        $str = '<option value="">--' . $this->lang->line('select') . '--</option>';            
        $select = 'selected="selected"';
        
        if (!empty($products)) {
            foreach ($products as $obj) {
                $selected = $product_id == $obj->id ? $select : '';
                $str .= '<option value="' . $obj->id . '" ' . $selected . '>' . $obj->name .' </option>';
            }
        }

        echo $str;
    
    }
}
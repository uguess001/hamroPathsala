<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Faq.php**********************************
 * @product name    : HamroSchool Management System
 * @Type            : Faq
 * @class name      : Faq
 * @description     : Manage  faq.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Faq extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();
        
         if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard/index');
        }
        
        $this->load->model('Faq_Model', 'faq', true);        
    }

    
    /*****************Function index**********************************
    * @Type            : Function
    * @function name   : index
    * @description     : Load "Faq List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {
        
        check_permission(VIEW);        
        $this->data['faqs'] = $this->faq->get_faq_list(); 
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_faq').' | ' . SMS);
        $this->layout->view('faq/index', $this->data);  
    }

    
    /*****************Function add**********************************
    * @Type            : Function
    * @function name   : add
    * @description     : Load "Add new faq" user interface                 
    *                    and process to store "faq" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_faq_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_faq_data();

                $insert_id = $this->faq->insert('saas_faqs', $data);
                if ($insert_id) {                    
                    success($this->lang->line('insert_success'));
                    redirect('subscription/faq/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('subscription/faq/add');
                }
            } else {
                success($this->lang->line('insert_success'));
                $this->data['post'] = $_POST;
            }
        }

        $this->data['faqs'] = $this->faq->get_faq_list(); 
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('faq/index', $this->data);
    }

        
    /*****************Function edit**********************************
    * @Type            : Function
    * @function name   : edit
    * @description     : Load Update "faq" user interface                 
    *                    with populate "faq" value 
    *                    and process to update "faq" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {       

        check_permission(EDIT);
        if ($_POST) {
            $this->_prepare_faq_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_faq_data();
                $updated = $this->faq->update('saas_faqs', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    success($this->lang->line('update_success'));
                    redirect('subscription/faq/index'); 
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('subscription/faq/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['faq'] = $this->faq->get_single('saas_faqs', array('id' => $this->input->post('id')));
            }
        } else {
            if ($id) {
                $this->data['faq'] = $this->faq->get_single('saas_faqs', array('id' => $id));

                if (!$this->data['faq']) {
                     redirect('subscription/faq/index');
                }
            }
        }

        $this->data['faqs'] = $this->faq->get_faq_list(); 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('faq/index', $this->data);
    }

        
    /*****************Function _prepare_faq_validation**********************************
    * @Type            : Function
    * @function name   : _prepare_faq_validation
    * @description     : Process "faq" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_faq_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('description', $this->lang->line('description'));
    }

                    
    /*****************Function Faq**********************************
    * @Type            : Function
    * @function name   : Faq
    * @description     : Unique check for "Faq " data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function title() {
        if ($this->input->post('id') == '') {
            $faq = $this->faq->duplicate_check($this->input->post('title'));
            if ($faq) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $faq = $this->faq->duplicate_check($this->input->post('title'), $this->input->post('id'));
            if ($faq) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
       
    /*****************Function _get_posted_faq_data**********************************
    * @Type            : Function
    * @function name   : _get_posted_faq_data
    * @description     : Prepare "Faq" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_faq_data() {

        $items = array();
        $items[] = 'title';
        $items[] = 'description';
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
    * @description     : delete "faq" data from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {
        
        check_permission(DELETE);
         
        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('subscription/faq/index');        
        }
        
        $faq = $this->faq->get_single_faq('saas_faqs', array('id' => $id));        
        if ($this->faq->delete('saas_faqs', array('id' => $id))) { 
            
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('subscription/faq/index');
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Todo.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Todo
 * @class name      : Todo
 * @description     : Manage Todo.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Todo extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Todo_Model', 'todo', true); 
        $this->data['roles'] = $this->todo->get_list('roles', array('status' => 1), '', '', '', 'id', 'ASC');
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Todo List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ********************************************************** */
    public function index($school_id = null) {
        check_permission(VIEW);
                         
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->todo->get_list('classes', $condition, '', '', '', 'id', 'ASC');
       
        }        
        
        $this->data['todos'] = $this->todo->get_todo_list($school_id);         
        $this->data['school_id'] = $school_id;        
        $this->data['filter_school_id'] = $school_id;        
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_todo') .' | ' . SMS);
        $this->layout->view('todo/index', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Todo" user interface                 
    *                    and process to store "Todo" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_todo_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_todo_data();

                $insert_id = $this->todo->insert('todos', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a todo');                     
                    success($this->lang->line('insert_success'));
                    redirect('miscellaneous/todo/index/'.$data['school_id']);
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('miscellaneous/todo/add/'.$data['school_id']);
                }
            } else {
                error($this->lang->line('insert_failed'));
                $this->data['post'] = $_POST;                  
            }
        }
      
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->todo->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        }         
               
        $this->data['todos'] = $this->todo->get_todo_list();          
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('todo/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Todo" user interface                 
    *                    with populated "Todo" value 
    *                    and process to update "Todo" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('miscellaneous/todo/index');
        }
       
        if ($_POST) {
            $this->_prepare_todo_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_todo_data();
                $updated = $this->todo->update('todos', $data, array('id' => $this->input->post('id')));
                  
                if ($updated) {
                    
                    create_log('Has been updated an todo');                    
                    success($this->lang->line('update_success'));
                    redirect('miscellaneous/todo/index/'.$this->input->post('school_id'));
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('miscellaneous/todo/edit/' . $this->input->post('id'));
                }
            } else {
                error($this->lang->line('update_failed'));
                $this->data['todo'] = $this->todo->get_single_todo('todos', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            
            $this->data['todo'] = $this->todo->get_single_todo($id);
            if (!$this->data['todo']) {
                redirect('miscellaneous/todo/index');
            }
        }
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            $condition['school_id'] = $this->session->userdata('school_id');     
            $this->data['classes'] = $this->todo->get_list('classes', $condition, '', '', '', 'id', 'ASC');
        } 
        
        $this->data['todos'] = $this->todo->get_todo_list( $this->data['todo']->school_id); 
        $this->data['school_id'] = $this->data['todo']->school_id;        
        $this->data['filter_school_id'] = $this->data['todo']->school_id;        
        $this->data['schools'] = $this->schools; 
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit')  . ' | ' . SMS);
        $this->layout->view('todo/index', $this->data);
    }

           
     /*****************Function get_single_Todo**********************************
     * @type            : Function
     * @function name   : get_single_Todo
     * @description     : "Load single Todo information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_todo(){
        
       $todo_id = $this->input->post('id');       
       $this->data['todo'] = $this->todo->get_single_todo($todo_id);
       echo $this->load->view('todo/get-single-todo', $this->data);
    }

    
    /*****************Function _prepare_Todo_validation**********************************
    * @type            : Function
    * @function name   : _prepare_Todo_validation
    * @description     : Process "Todo" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_todo_validation() {
        
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('role_id', $this->lang->line('user_type'), 'trim|required');
       
        if($this->input->post('role_id') == STUDENT){
            $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');
       }
        
        $this->form_validation->set_rules('user_id', $this->lang->line('assign_to'), 'trim|required');
        $this->form_validation->set_rules('title', $this->lang->line('title'), 'trim|required');
        $this->form_validation->set_rules('date', $this->lang->line('date'), 'trim|required');
        $this->form_validation->set_rules('work', $this->lang->line('work_status'));
        $this->form_validation->set_rules('comment', $this->lang->line('comment'));
        $this->form_validation->set_rules('description', $this->lang->line('description'));
        
    }

    
    /*****************Function _get_posted_todo_data**********************************
    * @type            : Function
    * @function name   : _get_posted_todo_data
    * @description     : Prepare "todo" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_todo_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'role_id';
        $items[] = 'class_id';
        $items[] = 'user_id';
        $items[] = 'title';
        $items[] = 'work';
        $items[] = 'comment';
        $items[] = 'description';

        $data = elements($items, $_POST);
        
        $data['date'] = date('Y-m-d', strtotime($this->input->post('date')));
         
        if ($this->input->post('id')) {
            
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
        } else {
            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $school = $this->todo->get_school_by_id($data['school_id']);
            
            if(!$school->academic_year_id){
                error($this->lang->line('set_academic_year_for_school'));
                redirect('miscellaneous/todo/index');
            }            
            $data['academic_year_id'] = $school->academic_year_id;
        }


        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "todo" from database                 
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    
    public function delete($id = null) {

        check_permission(VIEW);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('miscellaneous/todo/index');
        }
        
        $todo = $this->todo->get_single_todo($id);
        
        if ($this->todo->delete('todos', array('id' => $id))) {
            
            create_log('Has been deleted a todo : '.$todo->title);
            success($this->lang->line('delete_success'));
            redirect('miscellaneous/todo/index/'.$todo->school_id);
            
        } else {
            error($this->lang->line('delete_failed'));
        }
        
        redirect('miscellaneous/todo/index');
    }

}
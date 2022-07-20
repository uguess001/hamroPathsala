<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Department.php**********************************
 * @department title    : Global School Management System Pro
 * @type            : Class
 * @class name      : Department
 * @description     : Manage school academic department teacers.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Department extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Department_Model', 'department', true);        
    }

    
    /*****************Function department**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Department List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    
     public function index($school_id = null) {
        
        check_permission(VIEW);      
        
        $this->data['departments'] = $this->department->get_department_list($school_id); 
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_department').' | ' . SMS);
        $this->layout->view('department/index', $this->data);  
    }
    
    
    

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Departments" user interface                 
    *                    and process to store "Departments" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_department_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_department_data();

                $insert_id = $this->department->insert('departments', $data);
                if ($insert_id) {
                    
                    create_log('Has been created a department : '.$data['title']);   
                    
                    success($this->lang->line('insert_success'));
                    redirect('teacher/department/index');
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('teacher/department/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

        $this->data['departments'] = $this->department->get_department_list();  
        $this->data['schools'] = $this->schools;
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add') . ' | ' . SMS);
        $this->layout->view('department/index', $this->data);
    }

    
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "Departments" user interface                 
    *                    with populated "DepartmentS" value 
    *                    and process update "Departments" database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('teacher/department/index');
        }
        
        if ($_POST) {
            $this->_prepare_department_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_department_data();
                $updated = $this->department->update('departments', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                     create_log('Has been updated a department : '.$data['title']);   
                    
                    success($this->lang->line('update_success'));
                    redirect('teacher/department/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('teacher/department/edit/' . $this->input->post('id'));
                }
            } else {
                $this->data['department'] = $this->department->get_single('departments', array('id' => $this->input->post('id')));
            }
        }

        if ($id) {
            $this->data['department'] = $this->department->get_single('departments', array('id' => $id));

            if (!$this->data['department']) {
                redirect('teacher/department/index');
            }
        }

        $this->data['departments'] = $this->department->get_department_list(); 
        $this->data['school_id'] = $this->data['department']->school_id;
        $this->data['schools'] = $this->schools;
        
        $this->data['edit'] = TRUE;
        $this->layout->title($this->lang->line('edit') . ' | ' . SMS);
        $this->layout->view('department/index', $this->data);
    }

      
           
     /*****************Function get_single_department**********************************
     * @type            : Function
     * @function name   : get_single_department
     * @description     : "Load single department information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_department(){
        
       $dept_id = $this->input->post('id');   
       $this->data['department'] = $this->department->get_single('departments', array('id' => $dept_id));
       echo $this->load->view('department/get-single-department', $this->data);
    }

    
        
    /*****************Function _prepare_department_validation**********************************
    * @type            : Function
    * @function name   : _prepare_department_validation
    * @description     : Process "Departments" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_department_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('title',' ' . $this->lang->line('title'), 'trim|required|callback_title');
        $this->form_validation->set_rules('note', $this->lang->line('note'), 'trim');
    }

    
    /*****************Function title**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "Departments title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function title() {
        
        if ($this->input->post('id') == '') {
            $dept = $this->department->duplicate_check($this->input->post('school_id'), $this->input->post('title'));
            if ($dept) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $dept = $this->department->duplicate_check($this->input->post('school_id'), $this->input->post('title'), $this->input->post('id'));
            if ($dept) {
                $this->form_validation->set_message('title', $this->lang->line('already_exist'));
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    
    /*****************Function _get_posted_department_data**********************************
    * @type            : Function
    * @function name   : _get_posted_department_data
    * @description     : Prepare "Departments" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_department_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'title';
        $items[] = 'note';
        
        $data = elements($items, $_POST);


       if($this->input->post('id')) {
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id
            ();
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            
            $school = $this->department->get_school_by_id($data['school_id']);
        }

        return $data;
    }

    
    /*****************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : delete "Departments" from database                  
    *                       
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function delete($id = null) {

        check_permission(VIEW);

        if(!is_numeric($id)){
            error($this->lang->line('unexpected_error'));
            redirect('teacher/department/index');
        }
        
        $dept = $this->department->get_single('departments', array('id' => $id));
        
        if ($this->department->delete('departments', array('id' => $id))) {
            
            create_log('Has been deleted a department : '.$dept->title);   
            success($this->lang->line('delete_success'));
        } else {
            error($this->lang->line('delete_failed'));
        }
       redirect('teacher/department/index');
    }

}

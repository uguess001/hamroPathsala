<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* ******************Onlineexam Onlineexam.php***************************
 * @exam title      : Global - Multi School Management System Express
 * @type            : Class
 * @class name      : Onlineexam Onlineexams
 * @description     : Manage school academic exam exam.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ***********************************************************/

class Takeexam extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Onlineexam_Model', 'online_exam', true); 
        $this->load->model('Takeexam_Model', 'take_exam', true); 
        $this->load->model('Question_Model', 'question', true);         
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->take_exam->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
        }
        
        // need to check school subscription status
        if($this->session->userdata('role_id') != SUPER_ADMIN){                 
            if(!check_saas_status($this->session->userdata('school_id'), 'is_enable_online_exam')){                        
              redirect('dashboard/index');
            }
        }
        
    }

    
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Onlineexam List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);   
        if($this->session->userdata('role_id') != STUDENT){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/index');
        } 
         
        $class_id = '';
        $subject_id = '';
        $school_id = $this->session->userdata('school_id');
        
        if($_POST){            
            $class_id = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');
        }
        if ($this->session->userdata('role_id') == STUDENT) {
           $class_id = $this->session->userdata('class_id');    
        }
        
        $this->data['filter_school_id'] = $school_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_subject_id'] = $subject_id;
        
         $school = $this->online_exam->get_school_by_id($school_id);
        $this->data['online_exams'] = $this->online_exam->get_online_exam_list($school_id, $class_id, $subject_id, @$school->academic_year_id);
        $this->data['classes'] = $this->take_exam->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC');
       
        
        $this->data['class_list'] = $this->data['classes'];
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_onlime_exam') . ' | ' . SMS);
        $this->layout->view('take_exam/index', $this->data);
        
    }
    
    
        /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Onlineexam List" user interface                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function instruction($online_exam_id = null) {

        check_permission(VIEW);   
        
        if(!is_numeric($online_exam_id)){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/takeexam/index');
        }
        
        if($this->session->userdata('role_id') != STUDENT){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/index');
        } 
        
        $school_id = $this->session->userdata('school_id');       
         
        $this->data['online_exam'] = $this->online_exam->get_single_online_exam($online_exam_id);
        $this->data['classes'] = $this->take_exam->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC');
      
        $this->data['instruction'] = TRUE;
        $this->layout->title($this->lang->line('manage_take_exam') . ' | ' . SMS);
        $this->layout->view('take_exam/instruction', $this->data);
        
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Onlineexam" user interface                 
    *                    and process to store "Onlineexams" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function start($online_exam_id = null ) {

        check_permission(VIEW); 
        
        if(!is_numeric($online_exam_id)){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/takeexam/index');
        }
        
        if($this->session->userdata('role_id') != STUDENT){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/index');
        }
        
        // now will check exam limit for a student
        $school_id = $this->session->userdata('school_id');  
        $this->data['online_exam'] = $this->online_exam->get_single_online_exam($online_exam_id);
        $this->data['classes'] = $this->take_exam->get_list('classes', array('status'=>1, 'school_id'=>$school_id), '','', '', 'id', 'ASC');
      
        
        // Check exam time expire/ waiting............
       
        if($this->data['online_exam']->end_date < date('Y-m-d')){
            error($this->lang->line('exam_time_already_expired'));
            redirect('onlineexam/takeexam/index');
        }elseif($this->data['online_exam']->start_date > date('Y-m-d')){
            error($this->lang->line('please_wait_for_start_exam'));
            redirect('onlineexam/takeexam/index');
        }
        
        $condition = array(
            'status'=>1,
            'student_id'=>$this->session->userdata('profile_id'),
            'exam_id'=>$online_exam_id,
            'academic_year_id'=>$this->data['online_exam']->academic_year_id,
            'class_id'=>$this->data['online_exam']->class_id,
            'subject_id'=>$this->data['online_exam']->subject_id,
        );
        $this->data['results']    = $this->take_exam->get_list('exam_taken_exams', $condition, '','', '', 'id', 'ASC');
                 
        if(count($this->data['results']) >= $this->data['online_exam']->exam_limit){
            error($this->lang->line('you_already_reach_max_exam_limit'));
            redirect('onlineexam/takeexam/index');
        }
        
        if ($_POST) {
            
            //echo '<pre>';
            //print_r($this->input->post('answer'));
            
            $school_id = $this->input->post('school_id'); 
            
            $answers = $this->input->post('answer');
            $online_exam_id = $this->input->post('online_exam_id');
            $online_exam = $this->take_exam->get_single('exam_online_exams', array('id'=>$online_exam_id));
            
            // get school for academic year....
            $school = $this->take_exam->get_school_by_id($school_id);
             
            $data = array();
            $data['school_id'] = $school_id;
            $data['student_id'] = $this->session->userdata('profile_id');
            $data['exam_id'] = $online_exam_id;
            $data['academic_year_id'] = $school->academic_year_id;
            $data['class_id'] = $online_exam->class_id;
            $data['section_id'] = $online_exam->section_id;
            $data['subject_id'] = $online_exam->subject_id;            
            $data['total_mark'] = $this->input->post('total_mark');
            $data['total_question'] = $this->input->post('total_question');            
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
            $data['modified_at'] = date('Y-m-d H:i:s');
            $data['modified_by'] = logged_in_user_id();
            
            $total_correct_answer = 0;
            $total_incorrect_answer = 0;
            $total_obtain_mark = 0;
            
            if(!empty($answers)){
                
                foreach($answers as $ans_key=>$answer){
                    
                   
                    if($ans_key == 'boolean' ){  //    Process for boolean answer
                        foreach( $answer as $q_key=>$obj){
                           $answer_id =  $obj[0];
                           // get correct answer                           
                           $result = $this->db->get_where('exam_answers', array('id'=>$answer_id))->row()->is_correct;
                          if(!empty($result)){
                               $total_correct_answer += 1;
                               $total_obtain_mark += $this->input->post('question_mark')[$q_key];
                           }else{
                               $total_incorrect_answer += 1; 
                           }
                        }  
                    }else if($ans_key == 'single' ){ // process dor single answer
                        foreach( $answer as $q_key=>$obj){
                           $answer_id =  $obj[0];
                           // get correct answer                            
                           $result = $this->db->get_where('exam_answers', array('id'=>$answer_id))->row()->is_correct;
                           if(!empty($result)){
                               $total_correct_answer += 1;
                               $total_obtain_mark += $this->input->post('question_mark')[$q_key];
                           }else{
                               $total_incorrect_answer += 1; 
                           }
                        }  
                    }else if($ans_key == 'multi' ){ // process dor multi answer
                      
                        foreach( $answer as $q_key=>$obj){ 
                           
                            $is_correct_count = 0; 
                            $total_response_ans = count($obj);
                            $total_correct_ans  = count($this->db->get_where('exam_answers', array('question_id'=>$q_key, 'is_correct'=>1))->result());   
                            
                            if($total_response_ans == $total_correct_ans){
                                foreach($obj as $ans_id){                                
                                    $result = $this->db->get_where('exam_answers', array('id'=>$ans_id))->row()->is_correct;                            
                                    if(!$result){
                                         $is_correct_count += 1;                                    
                                    }                                
                                }

                                if($is_correct_count == $total_correct_ans){
                                   $total_correct_answer += 1;
                                   $total_obtain_mark += $this->input->post('question_mark')[$q_key];
                               }else{
                                   $total_incorrect_answer += 1; 
                               }
                               
                            }else{
                                $total_incorrect_answer += 1; 
                            }                           
                        }  
                        
                    }else if($ans_key == 'blank' ){ // process dor blank answer
                      
                        foreach( $answer as $q_key=>$obj){ 
                            
                            $total_blank_field = count($obj);
                            $is_correct_count = 0;
                            
                            foreach($obj as $value){
                                
                                if($value){
                                    $result = $this->db->get_where('exam_answers', array('question_id'=>$q_key, 'answer'=> strtolower(trim($value))))->row();                            
                                    if(!empty($result)){
                                        $is_correct_count +=1;                                    
                                    }
                                }                               
                            }                            
                          
                            if($is_correct_count == $total_blank_field){
                               $total_correct_answer += 1;
                               $total_obtain_mark += $this->input->post('question_mark')[$q_key];
                           }else{
                               $total_incorrect_answer += 1; 
                           }                            
                        }                        
                        
                        
                    }                    
                }

             
            $data['total_correct_answer'] = $total_correct_answer;
            $data['total_obtain_mark'] = $total_obtain_mark;
            $data['obtain_mark_percent'] = 0;
            $data['total_incorrect_answer'] = $total_incorrect_answer;
            $data['total_answer'] = $total_incorrect_answer + $total_correct_answer;
            $data['result_status'] = 'failed';
            
            //now calculate pass / failed mark            
            if($total_obtain_mark > 0 && $online_exam->pass_mark > 0 && $online_exam->mark_type == 'percentage'){
                
                $data['obtain_mark_percent'] = $total_obtain_mark/$data['total_mark']*100;                
                $data['result_status'] = ($data['obtain_mark_percent'] >= $online_exam->pass_mark ) ? 'passed' : 'failed';
                
            }else if($total_obtain_mark > 0 && $online_exam->pass_mark > 0 ){
                
                $data['obtain_mark_percent'] = $total_obtain_mark/$data['total_mark']*100;                
                $data['result_status'] = ($data['total_obtain_mark'] >= $online_exam->pass_mark ) ? 'passed' : 'failed';
                
            }else{
                $data['result_status'] = 'failed';
            }
            
             //print_r($data);
             //die();
            
                $insert_id = $this->take_exam->insert('exam_taken_exams', $data);
                if ($insert_id) { 
                    success($this->lang->line('exam_completed'));
                    redirect('onlineexam/takeexam/result'); 
                }else{
                   error($this->lang->line('unexpected_error'));
                   redirect('onlineexam/takeexam/start/'.$online_exam_id); 
                }
             
            }else{
                
                error($this->lang->line('please_answer_all_question'));
                redirect('onlineexam/takeexam/start/'.$online_exam_id);
            }            
        }
        
        $class_id = $this->data['online_exam']->class_id; 
        $subject_id = $this->data['online_exam']->subject_id; 

        $this->data['questions']   = $this->question->get_exam_question_list($school_id, $class_id, $subject_id, $online_exam_id);
        
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('start_exam') . ' | ' . SMS);
        $this->layout->view('take_exam/start', $this->data);
        
    }
    
      
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "Add new Onlineexam" user interface                 
    *                    and process to store "Onlineexams" into database 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function result($class_id = null) {

        check_permission(VIEW); 
        
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/takeexam/result');
        }
                
        //for super admin        
        $school_id = '';
        $subject_id = '';        
        if($_POST){   
            $school_id = $this->input->post('school_id');
            $class_id  = $this->input->post('class_id');           
            $subject_id  = $this->input->post('subject_id');           
        }        
        if ($this->session->userdata('role_id') != SUPER_ADMIN) {
            $school_id = $this->session->userdata('school_id');    
        }               
        if ($this->session->userdata('role_id') == STUDENT) {
            $class_id = $this->session->userdata('class_id');    
        }
      
        $school = $this->take_exam->get_school_by_id($school_id);
        $this->data['exam_results']   = $this->take_exam->get_exam_result_list($school_id, $class_id, $subject_id, @$school->academic_year_id);
       
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $school_id;
            $this->data['classes'] = $this->take_exam->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;       
        $this->data['filter_subject_id'] = $subject_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('exam_result') . ' | ' . SMS);
        $this->layout->view('take_exam/result', $this->data);
        
    }
    
    
    public function get_single_result(){
        
       $result_id = $this->input->post('result_id');       
       $this->data['exam_result'] = $this->take_exam->get_single_result($result_id);
       echo $this->load->view('take_exam/get-single-result', $this->data);
    }
    
}
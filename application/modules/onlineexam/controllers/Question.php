<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Question.php**********************************
 * @product name    : Global - MUlti School Management System Express
 * @type            : Class
 * @class name      : Question
 * @description     : Manage exam question for each class as per school course curriculam.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Question extends MY_Controller {

    public $data = array();
    
    
    function __construct() {
        parent::__construct();     
        $this->load->model('Question_Model', 'question', true);  
        
        if($this->session->userdata('role_id') == STUDENT){
            $this->data['subjects']  = $this->question->get_list('subjects',array('status'=>1, 'class_id'=>$this->session->userdata('class_id')), '','', '', 'id', 'ASC'); 
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
     * @description     : Load "Question List" user interface                 
     *                    with class wise listing    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function index($class_id = null) {
        
        check_permission(VIEW);
        if(isset($class_id) && !is_numeric($class_id)){
            error($this->lang->line('unexpected_error'));
            redirect('onlineexam/question/index');
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
        
        $this->data['questions'] = $this->question->get_question_list($school_id, $class_id, $subject_id);
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->question->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
       
        $this->data['schools'] = $this->schools;
        $this->data['filter_class_id'] = $class_id;
        $this->data['filter_school_id'] = $school_id;    
        $this->data['school_id'] = $school_id; 
        $this->data['filter_subject_id'] = $subject_id;
        
        $this->data['list'] = TRUE;
        $this->layout->title($this->lang->line('manage_question_bank') . ' | ' . SMS);
        $this->layout->view('question/index', $this->data);  
        
    }

    
    /*****************Function add**********************************
     * @type            : Function
     * @function name   : add
     * @description     : Load "Add new Question" user interface                 
     *                    and store "Question" into database 
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function add() {
        
        check_permission(ADD);
        if ($_POST) {
            $this->_prepare_question_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_question_data();

                $insert_id = $this->question->insert('exam_questions', $data);
                if ($insert_id) {                    
                    // process to save question options....
                    $this->__save_question_option($insert_id);
                                   
                    success($this->lang->line('insert_success'));
                    redirect('onlineexam/question/index');
                    
                } else {
                    error($this->lang->line('insert_failed'));
                    redirect('onlineexam/question/add');
                }
            } else {
                $this->data['post'] = $_POST;
            }
        }

                
        $this->data['questions'] = $this->question->get_question_list();   
        
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->question->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $this->data['schools'] = $this->schools;        
               
        $this->data['add'] = TRUE;
        $this->layout->title($this->lang->line('add'). ' | ' . SMS);
        $this->layout->view('question/index', $this->data);
    }

    
    /*****************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : Load Update "Question" user interface                 
     *                    with populated "Question" value 
     *                    and update "Question" database    
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function edit($id = null) {       
       
        check_permission(EDIT);
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('onlineexam/question/index'); 
        }
        
        if ($_POST) {
            
            $this->_prepare_question_validation();
            if ($this->form_validation->run() === TRUE) {
                
                $data = $this->_get_posted_question_data();
                $updated = $this->question->update('exam_questions', $data, array('id' => $this->input->post('id')));

                if ($updated) {
                    
                    // process to save question options....
                    $this->__save_question_option($this->input->post('id'));
                 
                    success($this->lang->line('update_success'));
                    redirect('onlineexam/question/index');      
                    
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('onlineexam/question/edit/' . $this->input->post('id'));
                }
            } else {
                 $this->data['question'] = $this->question->get_single('exam_questions', array('id' => $this->input->post('id')));
            }
        }
        
       
        if ($id) {
            $this->data['question'] = $this->question->get_single('exam_questions', array('id' => $id));

            if (!$this->data['question']) {
               redirect('onlineexam/question/index');
            }
        }
        
            
        $condition = array();
        $condition['status'] = 1;        
        if($this->session->userdata('role_id') != SUPER_ADMIN){            
            $condition['school_id'] = $this->session->userdata('school_id');
            $this->data['classes'] = $this->question->get_list('classes', $condition, '','', '', 'id', 'ASC');
        }
        
        $school_id = $this->data['question']->school_id;
        $class_id = $this->data['question']->class_id;
        $subject_id = $this->data['question']->subject_id;
        
        $this->data['questions'] = $this->question->get_question_list($school_id, $class_id, $subject_id);            
        
        $this->data['schools'] = $this->schools; 
        $this->data['filter_school_id'] = $school_id;
        $this->data['school_id'] = $school_id;
        $this->data['filter_class_id'] = $class_id;
        $this->data['class_id'] = $class_id;
        $this->data['subject_id'] = $subject_id;
        $this->data['filter_subject_id'] = $subject_id;
        
       
        $this->data['edit'] = TRUE;       
        $this->layout->title($this->lang->line('edit'). ' | ' . SMS);
        $this->layout->view('question/index', $this->data);
        
    }
    
        
     /*****************Function get_single_question**********************************
     * @type            : Function
     * @function name   : get_single_question
     * @description     : "Load single question information" from database                  
     *                    to the user interface   
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function get_single_question(){
        
       $question_id = $this->input->post('question_id');
       
       $this->data['question'] = $this->question->get_single_question( $question_id);
       $this->data['options'] = $this->question->get_list('exam_answers',  array('question_id'=>$question_id), '','', '', 'id', 'ASC');
       
       echo $this->load->view('question/get-single-question', $this->data);
    }
    
    /*****************Function _prepare_question_validation**********************************
     * @type            : Function
     * @function name   : _prepare_question_validation
     * @description     : Process "question" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_question_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        
        $this->form_validation->set_rules('school_id', $this->lang->line('school_name'), 'trim|required');
        $this->form_validation->set_rules('class_id', $this->lang->line('class'), 'trim|required');   
        $this->form_validation->set_rules('subject_id', $this->lang->line('subject'), 'trim|required');   
        $this->form_validation->set_rules('question_type',  $this->lang->line('question_type'), 'trim|required'); 
        $this->form_validation->set_rules('question_level',  $this->lang->line('question_level'), 'trim|required'); 
        $this->form_validation->set_rules('question', $this->lang->line('question'), 'trim|callback_question');   
        $this->form_validation->set_rules('mark',  $this->lang->line('mark'), 'trim|required'); 
        
        $this->form_validation->set_rules('image', $this->lang->line('image'), 'trim|callback_image');
        
    }
    
    
        
    /*****************Function question**********************************
    * @type            : Function
    * @function name   : title
    * @description     : Unique check for "question title" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
   public function question()
   {             
      if($this->input->post('id') == '')
      {   
          $news = $this->question->duplicate_check($this->input->post('question'), $this->input->post('school_id'),  $this->input->post('class_id'), $this->input->post('subject_id')); 
          if($news){
                $this->form_validation->set_message('question', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }          
      }else if($this->input->post('id') != ''){   
         $news = $this->question->duplicate_check($this->input->post('question'), $this->input->post('school_id'),  $this->input->post('class_id'), $this->input->post('subject_id'), $this->input->post('id')); 
          if($news){
                $this->form_validation->set_message('question', $this->lang->line('already_exist'));         
                return FALSE;
          } else {
              return TRUE;
          }
      }   
   }

   
    
    /*****************Function image**********************************
     * @type            : Function
     * @function name   : image
     * @description     : Unique check for "image file content" data/value                  
     *                       
     * @param           : null
     * @return          : boolean true/false 
     * ********************************************************** */  
   public function image()
   {         
        if($_FILES['image']['name']){
            $name = $_FILES['image']['name'];
            $arr = explode('.', $name);
            $ext = end($arr); 
            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif') {
                return TRUE;
            } else {
                $this->form_validation->set_message('image', $this->lang->line('select_valid_file_format'));         
                return FALSE; 
            }
        }
   }

   
    /*****************Function _get_posted_question_data**********************************
     * @type            : Function
     * @function name   : _get_posted_question_data
     * @description     : Prepare "Question" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_question_data() {

        $items = array();
        $items[] = 'school_id';
        $items[] = 'class_id';
        $items[] = 'section_id';
        $items[] = 'subject_id';
        $items[] = 'question_type';
        $items[] = 'question_level';
        $items[] = 'question';
        $items[] = 'mark';
        $items[] = 'total_option';
        
        $data = elements($items, $_POST);   
        
        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if($data['question_type'] == 'boolean'){
            $data['total_option'] = 2;
        }
        
        if ($this->input->post('id')) {
            $data['status'] = $this->input->post('status');
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }        
        
        if (isset($_FILES['image']['name'])) {
           $data['image'] = $this->_upload_image();
        }
 
        return $data;
    }

    
    /*****************Function _upload_image**********************************
     * @type            : Function
     * @function name   : _upload_image
     * @description     : Process "Question" file upload to server and 
     *                      return file to store into database                  
     * @param           : null
     * @return          : $return image string value 
     * ********************************************************** */
    private function _upload_image(){
           
        $prev_image     = $this->input->post('prev_image');
        $image          = $_FILES['image']['name'];
        $image_type     = $_FILES['image']['type'];
        $return_image   = '';

        if ($image != "") {

                $destination = 'assets/uploads/question/'; 
                
                if (!file_exists($destination)) {
                    mkdir($destination, 0777, true);
                }

                $file_type  = explode(".", $image);
                $extension  = strtolower($file_type[count($file_type) - 1]);
                $image_path = 'question-'.time() . '-gsms.' . $extension;

                move_uploaded_file($_FILES['image']['tmp_name'], $destination . $image_path);

                // need to unlink previous question
                if ($prev_image != "") {
                    if (file_exists($destination . $prev_image)) {
                        @unlink($destination . $prev_image);
                    }
                }

                $return_image = $image_path;
            
        } else {
            $return_image = $prev_image;
        }

        return $return_image;
    }
    
    
    
    /*****************Function __save_question_option**********************************
     * @type            : Function
     * @function name   : __save_question_option
     * @description     : process ans save question options                 
     *                       
     * @param           : boolean
     * @return          : null 
     * ********************************************************** */
    private function __save_question_option($question_id){
        
        $school_id = $this->input->post('school_id');
        $question_type = $this->input->post('question_type');
        $total_option = $this->input->post('total_option');
        
        // in edit tim eexisting option will be delete and then will add again
        if($this->input->post('id')){            
            $this->question->delete('exam_answers', array('question_id' => $question_id)); 
        }
         
        if($question_type == 'single' || $question_type == 'multi'){
            
            for($i = 0; $i < $total_option; $i++){
                
                $data = array();
                $data['school_id'] = $school_id;
                $data['question_id'] = $question_id;
                $data['option'] = $this->input->post('option')[$i]; 
                $data['answer'] = $this->input->post('answer')[$i]; 
                $data['is_correct'] = $data['answer'] ? 1 : 0; 
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                
                $this->question->insert('exam_answers', $data);
            }
             
        }else if($question_type == 'blank'){
            
            for($i = 0; $i < $total_option; $i++){
                
                $data = array();
                $data['school_id'] = $school_id;
                $data['question_id'] = $question_id;
                $data['option'] = $this->input->post('option')[$i]; 
                $data['answer'] = $this->input->post('option')[$i]; 
                $data['is_correct'] = $data['answer'] ? 1 : 0; 
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                
                $this->question->insert('exam_answers', $data);
            }
            
        }else if($question_type == 'boolean'){
            
            $ans = $this->input->post('ans');
             
            for($i = 0; $i < 2; $i++){
                
                $data = array();
                $data['school_id'] = $school_id;
                $data['question_id'] = $question_id;
                $data['option'] = $this->input->post('option')[$i]; 
                $data['answer'] = $this->input->post('answer')[$i]; 
                $data['is_correct'] = $data['answer'] == 1 ? 1 : 0; 
                $data['status'] = 1;
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = logged_in_user_id();
                $data['modified_at'] = date('Y-m-d H:i:s');
                $data['modified_by'] = logged_in_user_id();
                
                $this->question->insert('exam_answers', $data);
            }
            
        }
    }



    /*****************Function delete**********************************
     * @type            : Function
     * @function name   : delete
     * @description     : delete "Question" from database                  
     *                       
     * @param           : $id integer value
     * @return          : null 
     * ********************************************************** */
    public function delete( $id = null) {
        
        check_permission(DELETE);
        
        if(!is_numeric($id)){
             error($this->lang->line('unexpected_error'));
             redirect('onlineexam/question/index');
        }
        
        $question = $this->question->get_single('exam_questions', array('id' => $id));
           
        if ($this->question->delete('exam_questions', array('id' => $id))) {   
                           
            create_log('Has been deleted a question : '. $question->question);
            
            // delete question file
            $destination = 'assets/uploads/';
            if (file_exists( $destination.'/question/'.$question->image)) {
                @unlink($destination.'/question/'.$question->image);
            }
            
            // delete exam_answers/ exam to question data
            $this->question->delete('exam_answers', array('question_id' => $id)); 
            $this->question->delete('exam_to_questions', array('question_id' => $id)); 
            
            success($this->lang->line('delete_success'));
            
        } else {
            
            error($this->lang->line('delete_failed'));
        }
        
        redirect('onlineexam/question/index');
    }
    
 
    
    public function get_question_option(){
          
        $school_id = $this->input->post('school_id');
        $question_id = $this->input->post('question_id');
        $question_type = $this->input->post('question_type');
        $total_option = $this->input->post('total_option');
        $str = '';
        $key = 0;
        
        if($question_id !=''){
            
            $options = $this->question->get_list('exam_answers',  array('school_id'=>$school_id, 'question_id'=>$question_id), '', $total_option, '', 'id', 'ASC');
            
            $str = $this->__get_edit_option($question_type, $options);
            
            if($total_option > count($options)){
                $key = count($options);
                $str .= $this->__get_add_option($question_type, ($total_option - count($options)), $key);
            }            
            
        }else{

            $str .= $this->__get_add_option($question_type, $total_option, $key);
         
        }
        
        echo $str;    
         
    }
    
    
    private function __get_add_option($question_type, $total_option, $key){
        
        $str = '';
        
        if($question_type == 'single'){

            for($i = 1; $i <= $total_option; $i++){
              
               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('option').' '.($i+$key).' <span class="required">*</span></label>
                   <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.($i+$key).'" name="option[]" value="" required="required">
                        <span class="input-group-addon">
                             <input id="ans_'.($i+$key).'" type="radio" name="ans[]" value="1" required="required" onclick="set_single_radio(this);">
                             <input id="answer_'.($i+$key).'" type="hidden" name="answer[]" value="0" class="fn_single_hidden">    
                        </span>
                        <span class="control-label help-block" id="answer_error_'.($i+$key).'"></span>
                   </div>
                   <label id="answer_'.($i+$key).'" class="error error col-md-3 col-sm-3 col-xs-12" for="answer[]" style="padding: 8px 0px;"></label>
                </div>';                 
            }

        }else if($question_type == 'multi'){
            
            for($i = 1; $i <= $total_option; $i++){

               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('option').' '.($i+$key).' <span class="required">*</span></label>
                   <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.($i+$key).'" name="option[]" value="" required="required">
                        <span class="input-group-addon">
                            <input id="ans_'.($i+$key).'" type="checkbox" name="ans[]" value="1" onclick="set_single_checkbox(this);">
                            <input id="answer_'.($i+$key).'" type="hidden" name="answer[]" value="0" class="fn_single_hidden">     
                        </span>
                        <span class="control-label help-block" id="answer_error_'.($i+$key).'"></span>
                   </div>
                   <label id="answer_'.($i+$key).'" class="error col-md-3 col-sm-3 col-xs-12" for="answer[]"  style="padding: 8px 0px;"></label>
                </div>';               
            }

        }else if($question_type == 'blank'){
            
            for($i = 1; $i <= $total_option; $i++){

               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('answer').' '.($i+$key).' <span class="required">*</span></label>
                   <div class="col-md-5 col-sm-5 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.($i+$key).'" name="option[]" value="" required="required">                        
                        <span class="control-label help-block" id="answer_error_'.($i+$key).'"></span>
                   </div>
                </div>';               
            }

        }else if($question_type == 'boolean'){

            $str .= '<div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option"  style="padding-top:0px;">'. $this->lang->line('true').'</label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table"> 
                     <input type="radio" name="ans" value="1" required="required" onclick="set_single_radio(this);">
                     <input id="answer_1" type="hidden" name="answer[]" value="0" class="fn_single_hidden"> 
                     <input id="option_1" type="hidden" name="option[]" value="TRUE">  
                </div>  
                <label id="ans_1" class="error col-md-3 col-sm-3 col-xs-12" for="answer[]"  style="padding: 8px 0px;"></label>
             </div>';  

            $str .= '<div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option" style="padding-top:0px;">'. $this->lang->line('false').'</label>
                <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table"> 
                     <input type="radio" name="ans" value="1" required="required" onclick="set_single_radio(this);">
                     <input id="answer_2" type="hidden" name="answer[]" value="0" class="fn_single_hidden">
                     <input id="option_2" type="hidden" name="option[]" value="FALSE">
                </div> 
                <label id="ans_2" class="error col-md-3 col-sm-3 col-xs-12" for="answer[]"  style="padding: 8px 0px;"></label>
             </div>'; 

        }
        
        return $str;
    }
    
    private function __get_edit_option($question_type, $options){
        
        $str = '';
        
        if($question_type == 'single'){
                 
            foreach($options as $key=>$obj){

               $key++;
               $check = $obj->is_correct ? 'checked="checked"' : '';
               $answer = $obj->is_correct ? $obj->answer : '';

               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('option').' '.$key.' <span class="required">*</span></label>
                   <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.$key.'" name="option[]" value="'.$obj->option.'" required="required">
                        <span class="input-group-addon">
                             <input id="ans_'.$key.'" type="radio" name="ans[]" value="1" required="required" '.$check.' onclick="set_single_radio(this);">
                             <input id="answer_'.$key.'" type="hidden" name="answer[]" value="'.$answer.'" class="fn_single_hidden">    
                        </span>
                        <span class="control-label help-block" id="answer_error_'.$key.'"></span>
                   </div>
                   <label id="answer_'.$key.'" class="error error col-md-3 col-sm-3 col-xs-12" for="answer[]" style="padding: 8px 0px;"></label>
                </div>';               
            }
            
        }else if($question_type == 'multi'){
            
            foreach($options as $key=>$obj){
                 
               $key++;
               $check = $obj->is_correct ? 'checked="checked"' : '';
               $answer = $obj->is_correct ? $obj->answer : ''; 

               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('option').' '.$key.' <span class="required">*</span></label>
                   <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.$key.'" name="option[]" value="'.$obj->option.'" required="required">
                        <span class="input-group-addon">
                            <input id="ans_'.$key.'" type="checkbox" name="ans[]" value="1" '.$check.' onclick="set_single_checkbox(this);">
                            <input id="answer_'.$key.'" type="hidden" name="answer[]" value="'.$answer.'" class="fn_single_hidden">     
                        </span>
                        <span class="control-label help-block" id="answer_error_'.$key.'"></span>
                   </div>
                   <label id="answer_'.$key.'" class="error col-md-3 col-sm-3 col-xs-12" for="answer[]"  style="padding: 8px 0px;"></label>
                </div>';               
            }
            
            
        }else if($question_type == 'blank'){
            
            foreach($options as $key=>$obj){
                 
               $key++;
               $answer = $obj->is_correct ? $obj->answer : ''; 

               $str .= '<div class="item form-group">
                   <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option">'. $this->lang->line('answer').' '.$key.' <span class="required">*</span></label>
                   <div class="col-md-5 col-sm-5 col-xs-12" style="display:inline-table">
                        <input type="text" class="form-control" id="option_'.$key.'" name="option[]" value="'.$answer.'" required="required">                        
                        <span class="control-label help-block" id="answer_error_'.$key.'"></span>
                   </div>
                </div>';               
            }
            
            
         }else if($question_type == 'boolean'){

            foreach($options as $key=>$obj){
                 
               $key++;
               $check = $obj->is_correct ? 'checked="checked"' : '';
               $answer = $obj->is_correct ? $obj->answer : ''; 
              
               
                $str .= '<div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="option"  style="padding-top:0px;">'.$obj->option.'</label>
                    <div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table"> 
                         <input type="radio" name="ans" value="'.$obj->is_correct.'" required="required" '.$check.' onclick="set_single_radio(this);">
                         <input id="answer_'.$key.'" type="hidden" name="answer[]" value="'.$answer.'" class="fn_single_hidden"> 
                         <input id="option_'.$key.'" type="hidden" name="option[]" value="'.$obj->option.'" >  
                    </div>  
                    <label id="ans_'.$key.'" class="error col-md-3 col-sm-3 col-xs-12" for="answer[]"  style="padding: 8px 0px;"></label>
                 </div>'; 
            
            }             
        }
        
        return $str;        
    }
    

}

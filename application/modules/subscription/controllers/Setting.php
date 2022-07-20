<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Setting.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Setting
 * @description     : Manage application general settings.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Setting extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Setting_Model', 'setting', true);  
        
        if($this->session->userdata('role_id') != SUPER_ADMIN){ 
            error($this->lang->line('permission_denied'));
            redirect('dashboard/index');
        }  
        
        $this->data['setting'] = $this->setting->get_single('saas_settings', array(''));
        
    }

        
    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "General Setting" user interface                 
    *                    
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index() {

        check_permission(VIEW);  
        
        $this->layout->title($this->lang->line('setting')  . ' | ' . SMS);
        $this->layout->view('setting/index', $this->data);
    }

    
    /*****************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Load "New General Settings" user interface                 
    *                    and process to store "General Settings" into database
    *                    for the first time settings 
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function add() {

        check_permission(ADD);

        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();

                $insert_id = $this->setting->insert('saas_settings', $data);
                if ($insert_id) {
                    success($this->lang->line('insert_success'));
                } else {
                    error($this->lang->line('insert_failed'));
                }
                redirect('subscription/setting/add');
            } else {
                error($this->lang->line('insert_failed'));
                $this->data = $_POST;
            }
        }
       
        $this->layout->title($this->lang->line('setting'). ' | ' . SMS);
        $this->layout->view('setting/index', $this->data);
    }

    
        
    /*****************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Load Update "General Settings" user interface                 
    *                    with populate "General Settings" value 
    *                    and process to update "General Settings" into database    
    * @param           : $id integer value
    * @return          : null 
    * ********************************************************** */
    public function edit($id = null) {

        check_permission(EDIT);

        if ($_POST) {
            $this->_prepare_setting_validation();
            if ($this->form_validation->run() === TRUE) {
                $data = $this->_get_posted_setting_data();
                $updated = $this->setting->update('saas_settings', $data, array('id' => $this->input->post('id')));

                if ($updated) {                

                    success($this->lang->line('update_success'));
                    redirect('subscription/setting/index');
                } else {
                    error($this->lang->line('update_failed'));
                    redirect('subscription/setting/edit/' . $this->input->post('id'));
                }
            }else{
                error($this->lang->line('update_failed'));
            }
        }
        
        $this->layout->title($this->lang->line('setting') . ' | ' . SMS);
        $this->layout->view('setting/index', $this->data);
    }

        
    /*****************Function _prepare_setting_validation**********************************
    * @type            : Function
    * @function name   : _prepare_setting_validation
    * @description     : Process "General Settings" user input data validation                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    private function _prepare_setting_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');

        $this->form_validation->set_rules('phone', $this->lang->line('phone'), 'trim|required');
        $this->form_validation->set_rules('email', $this->lang->line('email'), 'trim|required');
        $this->form_validation->set_rules('address', $this->lang->line('address'), 'trim|required');
        $this->form_validation->set_rules('opening_day', $this->lang->line('opening_day'), 'trim');
        $this->form_validation->set_rules('opening_hour', $this->lang->line('opening_hour'), 'trim|required');
        $this->form_validation->set_rules('our_location', $this->lang->line('google_map'), 'trim|required');
        $this->form_validation->set_rules('footer_note', $this->lang->line('footer_note'), 'trim|required');
        $this->form_validation->set_rules('about_brand', $this->lang->line('about_brand'), 'trim|required');
        $this->form_validation->set_rules('demo_video', $this->lang->line('demo_video'), 'trim|required');
        $this->form_validation->set_rules('video_id', $this->lang->line('video_id'), 'trim|required');
    }
    
    /*****************Function _get_posted_setting_data**********************************
    * @type            : Function
    * @function name   : _get_posted_setting_data
    * @description     : Prepare "General Settings" user input data to save into database                  
    *                       
    * @param           : null
    * @return          : $data array(); value 
    * ********************************************************** */
    private function _get_posted_setting_data() {

        $items = array();
         
        $items[] = 'phone';
        $items[] = 'email';
        $items[] = 'address';
        $items[] = 'opening_day';
        $items[] = 'opening_hour';
        $items[] = 'our_location';
        $items[] = 'footer_note';     
        $items[] = 'about_brand'; 
        $items[] = 'demo_video'; 
        $items[] = 'video_id'; 
       
        $items[] = 'facebook_url';
        $items[] = 'twitter_url';
        $items[] = 'linkedin_url';
        $items[] = 'youtube_url';
        $items[] = 'instagram_url';
        $items[] = 'pinterest_url';
        
        $data = elements($items, $_POST);


        $data['modified_at'] = date('Y-m-d H:i:s');
        $data['modified_by'] = logged_in_user_id();
        
        if ($this->input->post('id')) {
            
        } else {
            $data['status'] = 1;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = logged_in_user_id();
        }

        if ($_FILES['about_image']['name']) {
            $data['about_image'] = $this->_about_image();
        }
        
        if ($_FILES['brand_logo_header']['name']) {
            $data['brand_logo_header'] = $this->_brand_logo_header();
        }
        
        if ($_FILES['brand_logo_footer']['name']) {
            $data['brand_logo_footer'] = $this->_brand_logo_footer();
        }

        return $data;
    }
    
               
    /*****************Function about_image**********************************
    * @type            : Function
    * @function name   : about_image
    * @description     : Process to upload institute about_image in the server                  
    *                     and return logo name   
    * @param           : null
    * @return          : $logo string value 
    * ********************************************************** */
    private function _about_image() {

        $prevoius_logo = @$_POST['about_image_prev'];
        $logo_name = $_FILES['about_image']['name'];
        $logo_type = $_FILES['about_image']['type'];
        $logo = '';


        if ($logo_name != "") {
            if ($logo_type == 'image/jpeg' || $logo_type == 'image/pjpeg' ||
                    $logo_type == 'image/jpg' || $logo_type == 'image/png' ||
                    $logo_type == 'image/x-png' || $logo_type == 'image/gif') {

                $destination = 'assets/uploads/about/';

                $file_type = explode(".", $logo_name);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $logo_path = time().'-brand-about-image.' . $extension;

                copy($_FILES['about_image']['tmp_name'], $destination . $logo_path);

                if ($prevoius_logo != "") {
                    // need to unlink previous image
                    if (file_exists($destination . $prevoius_logo)) {
                        @unlink($destination . $prevoius_logo);
                    }
                }

                $logo = $logo_path;
            }
        } else {
            $logo = $prevoius_logo;
        }

        return $logo;
    }
    
               
    /*****************Function _upload_logo**********************************
    * @type            : Function
    * @function name   : _upload_logo
    * @description     : Process to upload institute logo in the server                  
    *                     and return logo name   
    * @param           : null
    * @return          : $logo string value 
    * ********************************************************** */
    private function _brand_logo_header() {

        $prevoius_logo = @$_POST['brand_logo_header_prev'];
        $logo_name = $_FILES['brand_logo_header']['name'];
        $logo_type = $_FILES['brand_logo_header']['type'];
        $logo = '';


        if ($logo_name != "") {
            if ($logo_type == 'image/jpeg' || $logo_type == 'image/pjpeg' ||
                    $logo_type == 'image/jpg' || $logo_type == 'image/png' ||
                    $logo_type == 'image/x-png' || $logo_type == 'image/gif') {

                $destination = 'assets/uploads/logo/';

                $file_type = explode(".", $logo_name);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $logo_path = time().'-brand-headerlogo.' . $extension;

                copy($_FILES['brand_logo_header']['tmp_name'], $destination . $logo_path);

                if ($prevoius_logo != "") {
                    // need to unlink previous image
                    if (file_exists($destination . $prevoius_logo)) {
                        @unlink($destination . $prevoius_logo);
                    }
                }

                $logo = $logo_path;
            }
        } else {
            $logo = $prevoius_logo;
        }

        return $logo;
    }

    
        /*****************Function _upload_frontend_logo**********************************
    * @type            : Function
    * @function name   : _upload_frontend_logo
    * @description     : Process to upload school front end logo in the server                  
    *                     and return logo name   
    * @param           : null
    * @return          : $logo string value 
    * ********************************************************** */
    private function _brand_logo_footer() {

        $prevoius_logo = @$_POST['brand_logo_footer_prev'];
        $logo_name = $_FILES['brand_logo_footer']['name'];
        $logo_type = $_FILES['brand_logo_footer']['type'];
        $logo = '';


        if ($logo_name != "") {
            if ($logo_type == 'image/jpeg' || $logo_type == 'image/pjpeg' ||
                    $logo_type == 'image/jpg' || $logo_type == 'image/png' ||
                    $logo_type == 'image/x-png' || $logo_type == 'image/gif') {

                $destination = 'assets/uploads/logo/';

                $file_type = explode(".", $logo_name);
                $extension = strtolower($file_type[count($file_type) - 1]);
                $logo_path = time().'-brand-footer-logo.' . $extension;

                copy($_FILES['brand_logo_footer']['tmp_name'], $destination . $logo_path);

                if ($prevoius_logo != "") {
                    // need to unlink previous image
                    if (file_exists($destination . $prevoius_logo)) {
                        @unlink($destination . $prevoius_logo);
                    }
                }

                $logo = $logo_path;
            }
        } else {
            $logo = $prevoius_logo;
        }

        return $logo;
    }

    
    
}

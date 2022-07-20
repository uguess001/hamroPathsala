<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Install.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Install
 * @description     : This is Install class of the application.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Install extends CI_Controller {
    /*     * **************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : this function redirect to installation process            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    public function index() {
       redirect(base_url() . 'installation/setting');             
    }

}

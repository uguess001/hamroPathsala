<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* * *****************Leave.php**********************************
 * @product name    : HamroSchool Management System
 * @type            : Class
 * @class name      : Leave
 * @description     : Manage Leave.  
 * @author          : Aegis Technologies 	
 * @url             : aegistechnologies.net      
 * @support         : info@aegistechnologies.net	
 * @copyright       : Aegis Technologies	 	
 * ********************************************************** */

class Leave extends MY_Controller {

    public $data = array();

    function __construct() {
        parent::__construct();
        $this->load->model('Application_Model', 'Leave', true);        
    }

    /*****************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Load "Decline Leave List" user interface                 
    *                    listing    
    * @param           : integer value
    * @return          : null 
    * ***********************************************************/
    public function index($school_id = null) {

        check_permission(VIEW);                        
       
        $this->layout->view('index.html', $this->data);
        
    }

}

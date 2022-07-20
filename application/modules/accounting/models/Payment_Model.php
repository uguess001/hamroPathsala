<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_Model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    
    public function get_invoice_amount($invoice_id){
        $this->db->select('I.*, SUM(T.amount) AS paid_amount');
        $this->db->from('invoices AS I');        
        $this->db->join('transactions AS T', 'T.invoice_id = I.id', 'left');
        $this->db->where('I.id', $invoice_id);         
        return $this->db->get()->row(); 
    }
    
    public function get_invoice_paid_amount($txn_id){
        $this->db->select('T.*, T.amount AS paid_amount');
        $this->db->from('transactions AS T');   
        $this->db->join('invoices AS I', 'I.id = T.invoice_id', 'left');
        $this->db->where('T.id', $txn_id);         
        return $this->db->get()->row(); 
    }
}

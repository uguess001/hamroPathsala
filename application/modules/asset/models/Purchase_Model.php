<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_purchase_list($school_id = null) {

        if(!$school_id){
            $school_id = $this->session->userdata('school_id');
        }
        $this->db->select('P.*, I.name AS item_name, V.name AS vendor_name, E.name AS employee_name, C.name AS cat_name, S.school_name');
        $this->db->from('asset_purchases AS P');
        $this->db->join('asset_items AS I', 'I.id = P.item_id', 'left');
        $this->db->join('asset_categories AS C', 'C.id = P.category_id', 'left');
        $this->db->join('asset_vendors AS V', 'V.id = P.vendor_id', 'left');
        $this->db->join('employees AS E', 'E.id = P.employee_id', 'left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');

        $this->db->where('P.school_id', $school_id);

        $this->db->order_by('P.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_purchase($id) {

        $this->db->select('P.*, I.name AS item_name, V.name AS vendor_name, E.name AS employee_name, C.name AS cat_name, S.school_name');
        $this->db->from('asset_purchases AS P');
        $this->db->join('asset_items AS I', 'I.id = P.item_id', 'left');
        $this->db->join('asset_categories AS C', 'C.id = P.category_id', 'left');
        $this->db->join('asset_vendors AS V', 'V.id = P.vendor_id', 'left');
        $this->db->join('employees AS E', 'E.id = P.employee_id', 'left');
        $this->db->join('schools AS S', 'S.id = P.school_id', 'left');
        $this->db->where('P.id', $id);
        return $this->db->get()->row();
    }

}

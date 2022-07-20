<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Subscription_Model extends MY_Model {

    function __construct() {
        parent::__construct();
    }

    public function get_subscription_list() {

        $this->db->select('SP.*, S.school_name, P.plan_name, P.plan_price');
        $this->db->from('saas_subscriptions AS SP');
        $this->db->join('schools AS S', 'S.subscription_id = SP.id', 'left');
        $this->db->join('saas_plans AS P', 'P.id = SP.subscription_plan_id', 'left');
        $this->db->order_by('SP.id', 'DESC');
        return $this->db->get()->result();
    }

    public function get_single_subscription($id) {

        $this->db->select('SP.*, SP.id as saas_id, S.school_name, P.*');
        $this->db->from('saas_subscriptions AS SP');
        $this->db->join('schools AS S', 'S.subscription_id = SP.id', 'left');
        $this->db->join('saas_plans AS P', 'P.id = SP.subscription_plan_id', 'left');
        $this->db->where('SP.id', $id);
        return $this->db->get()->row();
    }
}

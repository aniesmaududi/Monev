<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Audit extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        is_adminlogin();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->load->model('admin_model', 'admin');
        $this->load->library('form_validation');
    }

    function index()
    {

        $result = $this->db->from('tb_audit_trail')->get();

        $this->data['logs'] = $result->result();

        $this->data['title'] = 'Audit Trail';
        $this->data['template'] = 'audit';
        $this->load->view('backend/index', $this->data);
    }
}
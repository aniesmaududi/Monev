<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Monitoring_upload extends CI_Controller
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
//        if ($_POST) {
//            $this->db->from('d_item')
//                    ->where('kdsatker', $this->input->post('kdsatker'))
//                    ->get();
//        }

        $this->data['title'] = 'Monitoring Upload';
        $this->data['template'] = 'monitoring_upload';
        $this->load->view('backend/index', $this->data);
    }
}
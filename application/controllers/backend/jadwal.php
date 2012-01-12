<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jadwal extends CI_Controller
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
        $this->data['title'] = 'Jadwal Upload User';
        $this->data['template'] = 'jadwal';
        $this->load->view('backend/index', $this->data);
    }
}
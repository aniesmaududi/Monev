<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        is_adminlogin();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'SMS KEYWORD MANAGEMENT';
        $this->data['template'] = 'sms/index';
        $this->load->view('backend/index', $this->data);
    }

    public function keyword()
    {
        $this->load->model('msms');
        $this->data['message'] = $this->session->flashdata('message');
        ;
        $this->data['keywordList'] = $this->msms->getAllKeyword();
        $this->data['template'] = 'sms/keyword';
        $this->load->view('backend/index', $this->data);
    }

    public function manipulate()
    {
        $this->load->model('msms');
        $id = $this->uri->segment(4);
        $this->data['idKeyword'] = $id;
        if ($id) {
            $dataKeyword = $this->msms->getKeyword($id);
            if (is_array($dataKeyword)) {
                $this->data['dataKeyword'] = $dataKeyword;
                $this->data['action'] = "EDIT";
            } else {
                echo "data not found";
            }
        } else {
            $this->data['action'] = "ADD";
        }

        $this->data['template'] = 'sms/manipulate';
        $this->load->view('backend/index', $this->data);
    }

    function action()
    {
        $post = $this->input->post();
        $act = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $this->load->model('msms');
        if ($post['action'] == 'ADD') {
            $res = $this->msms->insertKeyword($post);
        } else if ($post['action'] == 'EDIT') {
            $res = $this->msms->updateKeyword($post);
        } else if ($act == 'DELETE') {
            $res = $this->msms->deleteKeyword($id);
        } else {
            $res = "Halaman tidak ditemukan";
        }

        $this->session->set_flashdata('message', $res);
        redirect(base_url() . "backend/sms/keyword");
    }

    function inbox()
    {
        $this->data['title'] = 'Kotak Masuk';
        $this->data['template'] = 'sms/inbox';
        $this->load->view('backend/index', $this->data);
    }

    function outbox()
    {
        $this->data['title'] = 'Kotak Keluar';
        $this->data['template'] = 'sms/outbox';
        $this->load->view('backend/index', $this->data);
    }
}
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// pengecekan sudah login apa belum
function is_adminlogin()
{
    $ci = & get_instance();
    if (!$ci->session->userdata('admin_ID') && !$ci->session->userdata('admin_username')
            && !$ci->session->userdata('user_jabid') && $ci->uri->segment(2) != 'login') :
        redirect('backend/login');
    elseif ($ci->session->userdata('user_id') && $ci->session->userdata('user_nama')
            && $ci->session->userdata('user_jabid') && $ci->uri->segment(2) == 'login') :
		redirect('backend');
    endif;
}
	
// pengecekan sudah login apa belum
function is_login()
{
    $ci = & get_instance();
    if (!$ci->session->userdata('user_id') && !$ci->session->userdata('user_nama')
            && !$ci->session->userdata('user_jabid') && $ci->uri->segment(2) != 'login') :
        redirect('login');
    elseif ($ci->session->userdata('user_id') && $ci->session->userdata('user_nama')
            && $ci->session->userdata('user_jabid') && $ci->uri->segment(2) == 'login') :
		redirect('dashboard');
    endif;
}

// untuk sanitize string
function sanitize_string($str)
{
	$str = strip_tags($str);
    $str = htmlentities($str, ENT_QUOTES);
    return $str;
}

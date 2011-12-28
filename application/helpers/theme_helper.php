<?php

define('ASSETS_DIR', base_url().'assets/');
define('ASSETS_DIR_CSS', ASSETS_DIR.'css/');
define('ASSETS_DIR_IMG', ASSETS_DIR.'images/');
define('ASSETS_DIR_JS', ASSETS_DIR.'js/');

function flash_message($message_type, $message=FALSE)
{
    $output = '';
    $ci = & get_instance();
    if ($message):
        $output .=
        '<div class="alert-message ' . $message_type . ' fade in" data-alert="alert">
			<a class="close" href="#">&times;</a>
			<p>' . $message . '</p>
		</div>';
    else:
        $output .=
        '<div class="alert-message ' . $message_type . ' fade in" data-alert="alert">
			<a class="close" href="#">&times;</a>
			<p>' . $ci->session->flashdata('message') . '</p>
		</div>';
    endif;
    return $output;
}
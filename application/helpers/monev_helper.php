<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// untuk sanitize string
function sanitize_string($str)
{
	$str = strip_tags($str);
    $str = htmlentities($str, ENT_QUOTES);
    return $str;
}

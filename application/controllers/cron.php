<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    function __construct()
    {
		parent::__construct();
        $this->data['now'] = date("Y-m-d H:i:s");
		$this->load->model('mcron');
	}
	
	function cron_penyerapan()
	{
		$this->mcron->cron_penyerapan();
		echo "cron aspek penyerapan success";
	}
	
}
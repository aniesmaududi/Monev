<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller
{
    function __construct()
    {
		parent::__construct();
        $this->data['now'] = date("Y-m-d H:i:s");
		$this->load->model('mcron');
	}
	
	function cron_penyerapan($thang="2011")
	{
		$this->mcron->cron_penyerapan($thang);
		//echo "cron aspek penyerapan sukses";
	}
	
	function cron_konsistensi($thang="2011")
	{
		$this->mcron->cron_konsistensi($thang);
		//echo "cron aspek konsistensi sukses";
	}
	
	function cron_keluaran($thang="2011")
	{
		$this->mcron->cron_keluaran($thang);
		//echo "cron aspek pencapaian keluaran sukses";
	}
	
	function cron_efisiensi($thang="2011")
	{
		/*
		echo "<pre>";
		print_r($this->mcron->get_pagu_anggaran_keluaran('015', '11', '675713', '01', '1066', '01'));
		*/
		$this->mcron->cron_efisiensi($thang);
		echo "cron aspek efisiensi sukses";
		
	}
	
}
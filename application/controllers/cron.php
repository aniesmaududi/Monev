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
	
	function cron_konsistensi($thang="2011",$limit=null, $offset=null)
	{
		$limit = (isset($limit)) ? $limit: 10;
		$offset = (isset($offset)) ? $offset: 0;
		$cron_proses = $this->mcron->cron_konsistensi($thang, $limit, $offset);
		if($cron_proses):
			$next_offset = $offset+$limit;
			$this->cron_konsistensi($thang,$limit,$next_offset);
		endif;
		//echo "cron aspek konsistensi sukses";
	}
	
	function cron_keluaran($thang="2011")
	{
		/*
		for($bulan=1;$bulan<=12;$bulan++):
			$bulan_ke = $bulan;
			if($bulan<10):
				$bulan_ke = '0'.$bulan;
			endif;
			$total_persen = 0;
			$i = 0;
			$data_bulanan = $this->mcron->get_volume_keluaran($thang,$kddept=null, $kdunit=null, $kdsatker=null, $kdprogram=null, $kdgiat=null, $kdoutput=null, $bulan_ke)->result();
			if($data_bulanan):
				foreach($data_bulanan as $efisiensi):
					$i++;
					$RVK = $efisiensi->rvk;
					$TVK = $efisiensi->tvk;
					$total_persen += round(($RVK/$TVK) * 100,2);
					echo "RVK = ".$RVK."<br>";
					echo "TVK = ".$TVK."<br>";
					echo "Persen = ".round(($RVK/$TVK) * 100,2)."<br><br>";
				endforeach;
				echo "Total Persen = ".$total_persen."<br>
					Total Data = ".$i."<br>
					Persen per bulan = ".round($total_persen/$i,2)."<hr>";
			else:
				echo "data bulan ke ".$bulan_ke." tidak ada<br>";
			endif;
		endfor;
		*/
		$this->mcron->cron_keluaran($thang);
		echo "cron aspek pencapaian keluaran sukses";
	}
	
	function cron_efisiensi($thang="2011")
	{
		$this->mcron->cron_efisiensi($thang);
		echo "cron aspek efisiensi sukses";
	}
	
}
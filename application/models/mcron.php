<?php
class Mcron extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
	
	// tingkat penyerapan
	public function get_pagu_anggaran($thang="2011")
    {
        //Get calculation of Pagu Anggaran from d_item           
		$sql = 'select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram, sum(jumlah) as total '.
				'from d_item item, t_program program, t_dept dept, t_unit unit '.
				'where item.kddept = dept.kddept '.
				'and item.kdunit = unit.kdunit '.
				'and item.kdprogram = program.kdprogram '.
				'and program.kddept = dept.kddept '.
				'and program.kdunit = unit.kdunit '.
				'and unit.kddept = dept.kddept '.
				'and item.thang = '.$thang;
		$sql .= ' group by item.thang, item.kddept, item.kdunit, item.kdprogram';
       
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_realisasi_anggaran($thang="2011", $kddept, $kdunit, $kdprogram, $all=false)
    {
        //Get calculation of Realisasi Anggaran from r_2011_cur
        
		$sql = 'select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram, sum(jmlrealiasi) as total '.
				'from r_'.$thang.'_cur item, t_program program, t_dept dept, t_unit unit '.
				  'where item.kddept = dept.kddept '.
				  'and item.kdunit = unit.kdunit '.
				  'and item.kdprogram = program.kdprogram '.
				  'and program.kddept = dept.kddept '.
				  'and program.kdunit = unit.kdunit '.
				  'and unit.kddept = dept.kddept ';
		if(isset($kddept)){
		$sql .= 'and item.kddept='.$kddept.' ';
		}
		if(isset($kdunit)){
		$sql .= 'and item.kdunit='.$kdunit.' ';
		}
		if(isset($kdprogram)){
		$sql .= 'and item.kdprogram='.$kdprogram.' ';
		}
		
		$sql .= 'group by item.kddept, item.kdunit, item.kdprogram';
       
        
        $query = $this->db->query($sql);
        return $query->row();
    }
	
	public function check_tb_penyerapan_anggaran($thang="2011", $kddept, $kdunit, $kdprogram)
	{
		$query = $this->db->query('
			select id
				from tb_penyerapan_anggaran
				where thang='.$thang.'
				and kddept='.$kddept.'
				and kdunit='.$kdunit.'
				and kdprogram='.$kdprogram.'
		');
		if(count($query->row()) > 0):
			return $query->row()->id;
		else:
			return false;
		endif;
	}
	
	public function cron_penyerapan($thang)
	{
		$pagu = $this->get_pagu_anggaran($thang);
		foreach($pagu as $pagu):
			$realisasi = $this->get_realisasi_anggaran($thang, $pagu->kddept, $pagu->kdunit, $pagu->kdprogram, false);
			$total_pagu = $pagu->total;
			$total_realisasi = $realisasi->total;
			$p = round(($total_realisasi/$total_pagu)*100,2);
			$data = array(
				'thang' => $thang,
				'pagu' => $pagu->total,
				'realisasi' => $realisasi->total,
				'p' => $p,
				'kddept' => $pagu->kddept,
				'kdunit' => $pagu->kdunit,
				'kdprogram' => $pagu->kdprogram
			);
			$check_data = $this->check_tb_penyerapan_anggaran($thang, $pagu->kddept, $pagu->kdunit, $pagu->kdprogram);
			if(!$check_data):
				$this->db->insert('tb_penyerapan_anggaran',$data);
			else:
				$this->db->query('
					update tb_penyerapan_anggaran set p='.$p.', pagu='.$pagu->total.', realisasi='.$realisasi->total.' where id='.$check_data.'
				');
			endif;
		endforeach;
	}
	
	// tingkat konsistensi
	public function get_rpd($thang="2011", $limit, $offset)
    {
		$sql = 'select kddept,kdunit,kdprogram,kdsatker, sum(jml01) as jml01, sum(jml02) as jml02, sum(jml03) as jml03, sum(jml04) as jml04, sum(jml05) as jml05, sum(jml06) as jml06, sum(jml07) as jml07, sum(jml08) as jml08, sum(jml09) as jml09, sum(jml10) as jml10, sum(jml11) as jml11, sum(jml12) as jml12  
			from m_trktrm 
			where thang='.$thang.' 
			and kddept!="" 
			and kdunit!=""
			and kdsatker!="" 
			and kdprogram!=""
			group by thang,kddept,kdunit,kdprogram,kdsatker
			order by thang,kddept,kdunit,kdprogram,kdsatker
			limit '.$offset.','.$limit;
		
        return $this->db->query($sql);
    }
	
	public function get_realisasi_bulanan($thang="2011", $bulan=null, $kddept=null, $kdunit=null, $kdprogram=null, $kdsatker=null)
    {
        //Get monthly Realisasi from table r_2011_cur
		if(isset($bulan)):
			$sql = 'select kddept, kdunit, kdprogram, kdsatker, sum(jmlrealiasi) as jmlrealisasi 
				from r_'.$thang.'_cur 
				where year(tgldok1) = '.$thang.' 
				and month(tgldok1) = '.$bulan.' ';
			if(isset($kddept)):
				$sql .= ' and kddept = '.$kddept;
			endif;
			if(isset($kdunit)):
				$sql .= ' and kdunit = '.$kdunit;
			endif;
			if(isset($kdprogram)):
				$sql .= ' and kdprogram = '.$kdprogram;
			endif;
			if(isset($kdsatker)):
				$sql .= ' and kdsatker = '.$kdsatker;
			endif;
			$sql .= ' group by year(tgldok1), month(tgldok1), kddept, kdunit, kdprogram, kdsatker';
			return $this->db->query($sql);
		endif;
    }
	
	public function check_tb_konsistensi($thang="2011", $bulan, $kddept, $kdunit, $kdprogram, $kdsatker)
	{
		$query = $this->db->query('
			select thang,bulan,kddept,kdunit,kdprogram,kdsatker
				from tb_konsistensi
				where thang='.$thang.'
				and bulan='.$bulan.'
				and kddept='.$kddept.'
				and kdunit='.$kdunit.'
				and kdprogram='.$kdprogram.'
				and kdsatker='.$kdsatker.'
		')->row();
		if(count($query) > 0):
			return $query;
		else:
			return false;
		endif;
	}
	
	public function cron_konsistensi($thang, $limit, $offset)
	{
		$data_bulanan = $this->get_rpd($thang, $limit, $offset)->result();
		if($data_bulanan):
			foreach($data_bulanan as $konsistensi):
				$kddept = $konsistensi->kddept;
				$kdunit = $konsistensi->kdunit;
				$kdsatker = $konsistensi->kdsatker;
				$kdprogram = $konsistensi->kdprogram;
				$jmlrpd = 0;
				$jmlrealisasi = 0;
				for($bulan=1;$bulan<=12;$bulan++):
					$jml = 'jml'.format_bulan($bulan);
					$rpd = $konsistensi->$jml;
					$jmlrpd = $jmlrpd+$rpd;
					$realisasi = $this->get_realisasi_bulanan($thang, $bulan, $kddept, $kdunit, $kdprogram, $kdsatker)->row();
					if($realisasi):
						$jmlrealisasi = $jmlrealisasi+$realisasi->jmlrealisasi;
					endif;
					$k = round($jmlrealisasi/$jmlrpd*100,2);
					$data = array(
						'thang' => $thang,
						'bulan' => format_bulan($bulan),
						'jmlrpd' => $jmlrpd,
						'jmlrealisasi' => $jmlrealisasi,
						'k' => $k,
						'kddept' => $kddept,
						'kdunit' => $kdunit,
						'kdsatker' => $kdsatker,
						'kdprogram' => $kdprogram
					);
					$check_data = $this->check_tb_konsistensi($thang, format_bulan($bulan), $kddept, $kdunit, $kdprogram, $kdsatker);
					if(!$check_data):
						$this->db->insert('tb_konsistensi',$data);
					else:
						$this->db->where('thang',$thang)
							->where('bulan',format_bulan($bulan))
							->where('kddept',$kddept)
							->where('kdunit',$kdunit)
							->where('kdsatker',$kdsatker)
							->where('kdprogram',$kdprogram)
							->update('tb_konsistensi',$data);
					endif;
				endfor;
			endforeach;
			return true;
		else:
			return false;
		endif;
		
	}

	// pencapaian keluaran
	public function get_volume_keluaran($thang="2011", $kddept=null, $kdunit=null, $kdsatker=null, $kdprogram=null, $kdgiat=null, $kdoutput=null, $bulan=null)
    {
		if(!isset($kddept) && !isset($kdunit) && !isset($kdsatker) && !isset($kdprogram) && !isset($kdgiat) && !isset($kdoutput)):
			$sql = 'select sr.kddept,sr.kdunit,sr.kdsatker,sr.kdprogram,sr.kdgiat,sr.kdoutput,sr.tvk, sr.rvk '.
                'from tb_real_output sr '.
                'where year(tgldok) = '.$thang. ' ';
		else:
			$sql = 'select sr.kddept,sr.kdunit,sr.kdsatker,sr.kdprogram,sr.kdgiat,sr.kdoutput,sr.tvk, sr.rvk '.
                'from tb_real_output sr '.
                'where year(tgldok) = '.$thang. ' ';
		endif;
		
        if(isset($bulan)):
			$sql .= 'and substring(tgldok,6,2) = '.$bulan.' ';
		endif;
        if(isset($kddept)){                          
        $sql .= 'and sr.kddept='.$kddept.' ';
        }
        if(isset($kdunit)){
        $sql .= 'and sr.kdunit='.$kdunit.' ';
        }
		if(isset($kdsatker)){
        $sql .= 'and sr.kdsatker='.$kdsatker.' ';
        }
        if(isset($kdprogram)){
        $sql .= 'and sr.kdprogram='.$kdprogram.' ';
        }
		if(isset($kdgiat)){
        $sql .= 'and sr.kdgiat='.$kdgiat.' ';
        }
		if(!isset($kddept) && !isset($kdunit) && !isset($kdsatker) && !isset($kdprogram) && !isset($kdgiat) && !isset($kdoutput)):
			$sql .='group by sr.kddept,sr.kdunit,sr.kdsatker,sr.kdprogram,sr.kdgiat,sr.kdoutput';
		endif;
        return $query = $this->db->query($sql);
    }
	
	public function check_tb_keluaran($thang="2011", $kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $bulan)
	{
		$query = $this->db->query('
			select id
				from tb_keluaran
				where thang='.$thang.'
				and bulan='.$bulan.'
				and kddept='.$kddept.'
				and kdunit='.$kdunit.'
				and kdsatker='.$kdsatker.'
				and kdprogram='.$kdprogram.'
				and kdgiat='.$kdgiat.'
		');
		if(count($query->row()) > 0):
			return $query->row()->id;
		else:
			return false;
		endif;
	}
	
	public function cron_keluaran($thang)
	{
		for($bulan=1;$bulan<=12;$bulan++):
			
			$total_persen = 0;
			$i = 0;
			$data_bulanan = $this->get_volume_keluaran($thang,$kddept=null, $kdunit=null, $kdsatker=null, $kdprogram=null, $kdgiat=null, $kdoutput=null, format_bulan($bulan))->result();
			if($data_bulanan):
				foreach($data_bulanan as $keluaran):
					$i++;
					$RVK = $keluaran->rvk;
					$TVK = $keluaran->tvk;
					$total_persen += round(($RVK/$TVK) * 100,2);
				endforeach;
				$data = array(
					'thang' => $thang,
					'bulan' => format_bulan($bulan),
					'pk' => round($total_persen/$i,2),
					'kddept' => $keluaran->kddept,
					'kdunit' => $keluaran->kdunit,
					'kdsatker' => $keluaran->kdsatker,
					'kdprogram' => $keluaran->kdprogram,
					'kdgiat' => $keluaran->kdgiat
				);
				$check_data = $this->check_tb_keluaran($thang,$keluaran->kddept,$keluaran->kdunit,$keluaran->kdsatker,$keluaran->kdprogram,$keluaran->kdgiat,$bulan_ke);
				if(!$check_data):
					$this->db->insert('tb_keluaran',$data);
				else:
					$this->db->query('
						update tb_keluaran set pk='.$pk.' where id='.$check_data.'
					');
				endif;
			endif;
		endfor;
	}
	
	// tingkat efisiensi
	public function get_pagu_anggaran_keluaran($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $kdoutput)
    {
        $query = $this->db->query('select sum(jumlah) as pagu '.
                                  'from d_item '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.                        
                                  'and kdgiat='.$kdgiat.' '.
                                  'and kdoutput='.$kdoutput
                                  );
        return $query->row();
    }
    
    public function get_realisasi_anggaran_keluaran($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $kdoutput)
    {
        $query = $this->db->query('select sum(jmlrealiasi) as total '.
                                  'from r_2011_cur '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.                        
                                  'and kdgiat='.$kdgiat.' '.
                                  'and kdoutput='.$kdoutput);
        return $query->row();
    }
	
	public function check_tb_efisiensi($thang="2011", $kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $bulan)
	{
		$query = $this->db->query('
			select id
				from tb_efisiensi
				where thang='.$thang.'
				and bulan='.$bulan.'
				and kddept='.$kddept.'
				and kdunit='.$kdunit.'
				and kdsatker='.$kdsatker.'
				and kdprogram='.$kdprogram.'
				and kdgiat='.$kdgiat.'
		');
		if(count($query->row()) > 0):
			return $query->row()->id;
		else:
			return false;
		endif;
	}
	
	public function cron_efisiensi($thang)
	{
		for($bulan=1;$bulan<=12;$bulan++):
			$bulan_ke = $bulan;
			if($bulan<10):
				$bulan_ke = '0'.$bulan;
			endif;
			$total_persen = 0;
			$i = 0;
			$data_bulanan = $this->get_volume_keluaran($thang,$kddept=null, $kdunit=null, $kdsatker=null, $kdprogram=null, $kdgiat=null, $kdoutput=null, $bulan_ke)->result();
			if($data_bulanan):
				foreach($data_bulanan as $efisiensi):
					$i++;
					$RVK = $efisiensi->rvk;
					$TVK = $efisiensi->tvk;
					$pagu = $this->get_pagu_anggaran_keluaran($efisiensi->kddept,$efisiensi->kdunit,$efisiensi->kdsatker,$efisiensi->kdprogram,$efisiensi->kdgiat,$efisiensi->kdoutput);
					$PAK = $pagu->pagu;
					$realisasi = $this->get_realisasi_anggaran_keluaran($efisiensi->kddept,$efisiensi->kdunit,$efisiensi->kdsatker,$efisiensi->kdprogram,$efisiensi->kdgiat,$efisiensi->kdoutput);
					$RAK = $realisasi->total;
					$total_persen += round(1-( ($RAK/$RVK) / ($PAK/$TVK) * 100),2);
				endforeach;
				$data = array(
							'thang' => $thang,
							'bulan' => $bulan_ke,
							'e' => round($total_persen/$i,2),
							'kddept' => $efisiensi->kddept,
							'kdunit' => $efisiensi->kdunit,
							'kdsatker' => $efisiensi->kdsatker,
							'kdprogram' => $efisiensi->kdprogram,
							'kdgiat' => $efisiensi->kdgiat
						);
				$check_data = $this->check_tb_efisiensi($thang,$efisiensi->kddept, $efisiensi->kdunit, $efisiensi->kdsatker, $efisiensi->kdprogram, $efisiensi->kdgiat,$bulan_ke);
				if(!$check_data):
					$this->db->insert('tb_efisiensi',$data);
				else:
					$this->db->query('
						update tb_efisiensi set e='.round($total_persen/$i,2).' where id='.$check_data.'
					');
				endif;
			endif;
		endfor;
	}
	
}
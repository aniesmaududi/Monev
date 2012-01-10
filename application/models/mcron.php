<?php
class Mcron extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
	
	public function get_pagu_anggaran($thang="2011", $kddept=null, $kdunit=null, $kdprogram=null, $all=false)
    {
        //Get calculation of Pagu Anggaran from d_item
        if($all == true)
        {
            $sql = 'select sum(jumlah) as total from d_item where thang='.$thang;    
        }
        else
        {                
            $sql = 'select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram, sum(jumlah) as total '.
                    'from d_item item, t_program program, t_dept dept, t_unit unit '.
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
            
            $sql .= 'group by item.thang, item.kddept, item.kdunit, item.kdprogram';
        }
        
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_realisasi_anggaran($thang, $kddept, $kdunit, $kdprogram, $all=false)
    {
        //Get calculation of Realisasi Anggaran from r_2011_cur
        if($all == true)
        {
            $sql = 'select sum(jmlrealiasi) as total from r_'.$thang.'_cur where substring(tgldok1,1,4) = '.$thang;    
        }
        else
        {   
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
        }
        
        $query = $this->db->query($sql);
        return $query->row();
    }
	
	public function check_tb_penyerapan_anggaran($thang, $kddept, $kdunit, $kdprogram)
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
	
	public function cron_penyerapan()
	{
		$pagu = $this->get_pagu_anggaran('2011', null, null, null, false);
		foreach($pagu as $pagu):
			$realisasi = $this->get_realisasi_anggaran('2011', $pagu->kddept, $pagu->kdunit, $pagu->kdprogram, false);
			$total_pagu = $pagu->total;
			$total_realisasi = $realisasi->total;
			$p = round(($total_realisasi/$total_pagu)*100,2);
			$data = array(
				'thang' => '2011',
				'tgldok' => date('Y-m-d'),
				'p' => $p,
				'kddept' => $pagu->kddept,
				'kdunit' => $pagu->kdunit,
				'kdprogram' => $pagu->kdprogram
			);
			$check_data = $this->check_tb_penyerapan_anggaran('2011', $pagu->kddept, $pagu->kdunit, $pagu->kdprogram);
			if(!$check_data):
				$this->db->insert('tb_penyerapan_anggaran',$data);
			else:
				$this->db->query('
					update tb_penyerapan_anggaran set p='.$p.' where id='.$check_data.'
				');
			endif;
		endforeach;
	}
	
}
<?php
class Mdja extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_dja_identity($kddja)
    {
        
    }
    
    public function get_dept()
    {
        //Get K/L list from table t_dept
        $query = $this->db->query('select kddept, nmdept '.
                                  'from t_dept '.
                                  'order by kddept');
        return $query->result_array();
    }
    
    public function get_unit($kddept)
    {
        //Get Eselon I list from table t_unit
        $query = $this->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit '.
                                  'from t_dept dept, t_unit unit '.
                                  'where dept.kddept=unit.kddept '.
                                  'and unit.kddept='.$kddept
                                  );
        return $query->result_array();
    }
    
    public function get_program($kddept, $kdunit)
    {
        //Get program list from table t_program by kddept, kdunit
        $query = $this->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram '.
                                    'from t_program program, t_dept dept, t_unit unit '.
                                    'where program.kddept = dept.kddept '.
                                    'and program.kdunit = unit.kdunit '.
                                    'and unit.kddept = dept.kddept '.
                                    'and program.kddept='.$kddept.' '.
                                    'and program.kdunit='.$kdunit
                                    );        
        
        return $query->result_array();
    }
    
    public function get_program_detail($kddept, $kdunit, $kdprogram)
    {
        //Get program detail from table t_program by kddept, kdunit, kdprogram
        $query = $this->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram '.
                                    'from t_program program, t_dept dept, t_unit unit '.
                                    'where program.kddept = dept.kddept '.
                                    'and program.kdunit = unit.kdunit '.
                                    'and unit.kddept = dept.kddept '.
                                    'and program.kddept='.$kddept.' '.
                                    'and program.kdunit='.$kdunit.' '.
                                    'and program.kdprogram='.$kdprogram
                                    );        
        
        return $query->row_array();
    }
    
    public function get_kegiatan_detail($kddept, $kdunit, $kdprogram)
    {
        //Get kegiatan list from table t_giat by kddept, kdunit, kdprogram
        $query = $this->db->query('select dept.kddept, dept.nmdept, unit.kdunit, unit.nmunit, program.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat '.
                                    'from t_giat giat, t_program program, t_dept dept, t_unit unit '.
                                    'where giat.kdprogram = program.kdprogram '.
                                    'and giat.kddept = dept.kddept '.
                                    'and giat.kdunit = unit.kddept '.
                                    'and program.kddept = dept.kddept '.
                                    'and program.kdunit = unit.kdunit '.
                                    'and unit.kddept = dept.kddept '.
                                    'and giat.kddept='.$kddept.' '.
                                    'and giat.kdunit='.$kdunit.' '.
                                    'and giat.kdprograms='.$kdprogram
                                    );        
        
        return $query->result_array();
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
        return $query->row_array();
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
        return $query->row_array();
    }
    
    public function get_volume_keluaran($thang, $kddept=null, $kdunit=null, $kdprogram=null)
    {
        //Get calculation of Volume Keluaran from tb_real_output
        $sql = 'select output.kdoutput, output.nmoutput, output.sat, sr.kddept, dept.nmdept, sr.kdunit, unit.nmunit, sr.kdsatker, satker.nmsatker, sr.kdprogram, program.nmprogram, sr.kdgiat, giat.nmgiat, sr.tvk, sr.rvk '.
                'from tb_real_output sr, t_dept dept, t_unit unit, t_satker satker, t_program program, t_giat giat, t_output output '.
                'where substring(tgldok,1,4) = '.$thang. ' ';
        
        if(isset($kddept)){                          
        $sql .= 'and sr.kddept='.$kddept.' ';
        }
        if(isset($kdunit)){
        $sql .= 'and sr.kdunit='.$kdunit.' ';
        }
        if(isset($kdprogram)){
        $sql .= 'and sr.kdprogram='.$kdprogram.' ';
        }
        
        $sql .= 'and sr.kddept=dept.kddept '.
                'and sr.kddept=unit.kddept '.
                'and sr.kdunit=unit.kdunit '.
                'and sr.kddept=satker.kddept '.
                'and sr.kdunit=satker.kdunit '.
                'and sr.kdsatker=satker.kdsatker '.
                'and sr.kddept=program.kddept '.
                'and sr.kdunit=program.kdunit '.
                'and sr.kdprogram=program.kdprogram '.
                'and sr.kddept=giat.kddept '.
                'and sr.kdunit=giat.kdunit '.
                'and sr.kdprogram=giat.kdprogram '.
                'and sr.kdgiat=giat.kdgiat '.                
                'and sr.kdoutput=output.kdoutput '.
                'and sr.kdgiat=output.kdgiat '.
                'and sr.accdept=1';
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_pagu_anggaran_keluaran($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $kdoutput)
    {
        //Get calculation of Pagu Anggaran Keluaran from tb_satker_realisasi
        $query = $this->db->query('select sum(jumlah) as pagu '.
                                  'from d_item '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.                        
                                  //'and kdgiat='.$kdgiat.' '.
                                  'and kdoutput='.$kdoutput.''
                                  );
        return $query->row_array();
    }
    
    public function get_realisasi_anggaran_keluaran($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat, $kdoutput)
    {
        //Get calculation of Pagu Anggaran Keluaran from tb_satker_realisasi
        $query = $this->db->query('select sum(jmlrealiasi) as total '.
                                  'from r_2011_cur '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.                        
                                  //'and kdgiat='.$kdgiat.' '.
                                  'and kdoutput='.$kdoutput);
        return $query->row_array();
    }
    
    public function get_rpd($thang, $kddept=null, $kdunit=null, $kdprogram=null)
    {
        //Get RPD from m_trktrm by kddept, kdunit
        if($kddept == 0)
        {
            $sql = 'select sum(jml01) as jml01, sum(jml02) as jml02, sum(jml03) as jml03, sum(jml04) as jml04, sum(jml05) as jml05, sum(jml06) as jml06, sum(jml07) as jml07, sum(jml08) as jml08, sum(jml09) as jml09, sum(jml10) as jml10, sum(jml11) as jml11, sum(jml12) as jml12 '.
                    'from m_trktrm '.
                    'where thang='.$thang.' ';
        }
        else
        {        
            $sql = 'select kddept, kdunit, sum(jml01) as jml01, sum(jml02) as jml02, sum(jml03) as jml03, sum(jml04) as jml04, sum(jml05) as jml05, sum(jml06) as jml06, sum(jml07) as jml07, sum(jml08) as jml08, sum(jml09) as jml09, sum(jml10) as jml10, sum(jml11) as jml11, sum(jml12) as jml12 '.
                    'from m_trktrm '.
                    'where thang='.$thang.' ';
            $group = 'thang';
            
            if(isset($kddept) && $kddept != 0){
            $sql .= 'and kddept='.$kddept.' ';
            $group .= ', kddept';
            }
            if(isset($kdunit)){
            $sql .= 'and kdunit='.$kdunit.' ';
            //$group .= ', kdunit';
            }
            if(isset($kdprogram)){
            $sql .= 'and kdprogram='.$kdprogram.' ';
            $group .= ', kdprogram';
            }                
            
            $sql .= 'group by '.$group;
        }
        
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function get_realisasi_bulanan($thang, $kddept=null, $kdunit=null, $kdprogram=null)
    {
        //Get monthly Realisasi from table r_2011_cur
        $sql = 'select substring(tgldok1,1,7) as bulan, kddept, kdunit, kdprogram, sum(jmlrealiasi) as jumlah '.
                'from r_'.$thang.'_cur '.
                'where substring(tgldok1,1,4) = '.$thang.' ';        
        $group = 'bulan';
        
        if(isset($kddept) && $kddept != 0){
        $sql .= 'and kddept='.$kddept.' ';
        $group .= ', kddept';
        }
        if(isset($kdunit)){
        $sql .= 'and kdunit='.$kdunit.' ';
        $group .= ', kdunit';
        }
        if(isset($kdprogram)){
        $sql .= 'and kdprogram='.$kdprogram.' ';
        $group .= ', kdprogram';
        }
        
        $sql .= 'group by '.$group;        
        
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function formatMoney($number, $fractional=false) { 
        if ($fractional) { 
            $number = sprintf('%.2f', $number); 
        } 
        while (true) { 
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
            if ($replaced != $number) { 
                $number = $replaced; 
            } else { 
                break; 
            } 
        } 
        return $number; 
    }
}
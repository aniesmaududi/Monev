<?php
class Meselon extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_unit_identity($kddept, $kdunit)
    {
        //Get unit identity form table t_unit by kdunit
        $query = $this->db->query('select unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept '.
                                'from t_unit unit, t_dept dept '.
                                'where unit.kddept=dept.kddept '.
                                'and unit.kddept='.$kddept.' '.
                                'and unit.kdunit='.$kdunit);
        return $query->row_array();
    }
    
    public function get_unit_program($kddept, $kdunit)
    {
        //Get program list from table tb_satker_realisasi by kdunit and kddept
        $query = $this->db->query('SELECT distinct sr.kdprogram, program.nmprogram, sr.kdsatker, sr.kdunit, sr.kddept '.
                                  'from tb_real_output sr, t_program program '.
                                  'where sr.kdprogram=program.kdprogram '.
                                  'and sr.kdunit=program.kdunit '.
                                  'and sr.kddept=program.kddept '.
                                  'and sr.kdunit='.$kdunit.' '.
                                  'and sr.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_program_detail($kddept, $kdunit, $kdprogram)
    {
        //Get program detail from table t_program by kddept, kdunit, and kdprogram
        $query = $this->db->query('SELECT kdprogram, nmprogram, kdunit, kddept '.
                                  'from t_program '.
                                  'where kdunit='.$kdunit.' '.
                                  'and kddept='.$kddept.' '.
                                  'and kdprogram='.$kdprogram);
        return $query->row_array();
    }
    
    public function get_unit_kegiatan_detail($kddept, $kdunit, $kdprogram, $kdgiat)
    {
        //Get kegiatan detail from table t_giat by kddept, kdunit, kdprogram, and kdgiat
        $query = $this->db->query('SELECT kdgiat, nmgiat, kdprogram, kdunit, kddept '.
                                  'from t_giat '.
                                  'where kdunit='.$kdunit.' '.
                                  'and kddept='.$kddept.' '.
                                  'and kdprogram='.$kdprogram.' '.
                                  'and kdgiat='.$kdgiat);
        return $query->row_array();
    }
    
    public function get_unit_kegiatan($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        //Get kegiatan list from table tb_satker_realisasi by kdprogram, kdunit, and kddept
        $query = $this->db->query('select distinct sr.kdsatker, sr.kddept, sr.kdunit, sr.kdsatker, sr.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, satker.nmsatker '.
                                    'from tb_satker_realisasi sr, t_giat giat, t_program program, t_satker satker '.
                                    'where sr.kdgiat = giat.kdgiat '.
                                    'and sr.kdunit = giat.kdunit '.
                                    'and sr.kddept = giat.kddept '.
                                    'and sr.kdprogram = program.kdprogram '.
                                    'and sr.kdunit = program.kdunit '.
                                    'and sr.kddept = program.kddept '.
                                    'and sr.kdsatker=satker.kdsatker '.
                                    'and sr.kdunit=satker.kdunit '.
                                    'and sr.kddept=satker.kddept '.
                                    'and sr.kddept='.$kddept.' '.
                                    'and sr.kdunit='.$kdunit.' '.                                 
                                    'and sr.kdsatker='.$kdsatker.' '.
                                    'and sr.kdprogram='.$kdprogram);        
        
        return $query->result_array();
    }
    
    /*---------------------------------------- OUTCOME -------------------------------------------*/
    
    public function get_iku($kddept, $kdunit, $kdprogram)
    {
        //Get IKU from tb_real_iku
        $query = $this->db->query('select r_iku.*, iku.nmiku '.
                              'from tb_real_iku r_iku, t_iku iku '.
                              'where r_iku.kdiku=iku.kdiku '.
                              'and r_iku.kddept=iku.kddept '.
                              'and r_iku.kdunit=iku.kdunit '.
                              'and r_iku.kdprogram=iku.kdprogram '.
                              'and r_iku.kddept='.$kddept.' '.
                              'and r_iku.kdunit='.$kdunit.' '.                              
                              'and r_iku.kdprogram='.$kdprogram);
    
        return $query->result_array();
    }
    
    public function set_real_iku()
    {
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');        
        $kdprogram = $this->input->post('kdprogram');        
        $n = $this->input->post('n');
        
        for($i=1;$i<=$n;$i++)
        {
            $kdsatker = $this->input->post('kdsatker_'.$i);
            $kdiku = $this->input->post('kdiku_'.$i);
            $status = $this->input->post('status_'.$i);
            if($status == "ok")
            {
                $data = array(
                    'accunit' => 1,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_iku',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdiku = '.$kdiku.' and accsatker = 1 and accunit = 0');            
        }
        
        return 1;
    }
    
    /*---------------------------------------- OUTPUT -------------------------------------------*/
    public function get_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.tvk as vol, output.rvk, output.accsatker, output.accunit, output.accdept, output.accsatker_date, output.accunit_date, output.accdept_date '.
                                    'from tb_real_output output, t_giat giat, t_program program, t_output '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kdgiat = t_output.kdgiat '.
                                    'and output.kdoutput = t_output.kdoutput '.
                                    'and output.accsatker in (0,1) '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);        
        
        return $query->result_array();
    }
    
    public function get_satker_kegiatan($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        //Get kegiatan list from table t_real_output by kdprogram, kdsatker, kdunit, and kddept
        $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat '.
                                    'from tb_real_output output, t_giat giat, t_program program '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram);        
        
        return $query->result_array();
    }
    
    public function is_exist_real_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select count(*) as total from tb_real_output '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.
                                  'and kdgiat='.$kdgiat.' '.
                                  'and accsatker=0');
        return $query->row_array();
    }
    
    public function set_real_output_approval()
    {            
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdprogram = $this->input->post('kdprogram');
        $kdgiat = $this->input->post('kdgiat');
        $n = $this->input->post('n');
        
        for($i=1;$i<=$n;$i++)
        {
            $kdoutput = $this->input->post('kdoutput_'.$i);
            $status = $this->input->post('status_'.$i);
            if($status == "ok")
            {
                $data = array(
                    'accunit' => 1,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_output',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 1 and accunit = 0');            
        }
        
        return 1;
    }
    
    /*---------------------------------------- IKK -------------------------------------------*/
    public function get_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select distinct ikk.kdsatker, ikk.kddept, ikk.kdunit, ikk.kdsatker, ikk.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_ikk.kdikk, t_ikk.nmikk, ikk.sat, ikk.tkk, ikk.rkk, ikk.accsatker, ikk.accunit, ikk.accdept, ikk.accsatker_date, ikk.accunit_date, ikk.accdept_date '.
                                    'from tb_real_ikk ikk, t_giat giat, t_program program, t_ikk '.
                                    'where ikk.kdgiat = giat.kdgiat '.
                                    'and ikk.kdunit = giat.kdunit '.
                                    'and ikk.kddept = giat.kddept '.
                                    'and ikk.kdprogram = program.kdprogram '.
                                    'and ikk.kdunit = program.kdunit '.
                                    'and ikk.kddept = program.kddept '.
                                    'and ikk.kdgiat = t_ikk.kdgiat '.
                                    'and ikk.kdikk = t_ikk.kdikk '.
                                    'and ikk.accsatker in (0,1) '.
                                    'and ikk.kddept='.$kddept.' '.
                                    'and ikk.kdunit='.$kdunit.' '.                                 
                                    'and ikk.kdsatker='.$kdsatker.' '.
                                    'and ikk.kdprogram='.$kdprogram.' '.                                
                                    'and ikk.kdgiat='.$kdgiat);        
        
        return $query->result_array();
    }
    
    public function is_exist_real_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select count(*) as total from tb_real_ikk '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.
                                  'and kdgiat='.$kdgiat.' '.
                                  'and accsatker=0');
        return $query->row_array();
    }
    
    public function set_real_ikk_approval()
    {            
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdprogram = $this->input->post('kdprogram');
        $kdgiat = $this->input->post('kdgiat');
        $n = $this->input->post('n');
        
        for($i=1;$i<=$n;$i++)
        {
            $kdikk = $this->input->post('kdikk_'.$i);
            $status = $this->input->post('status_'.$i);
            if($status == "ok")
            {
                $data = array(
                    'accunit' => 1,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_ikk',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdikk = '.$kdikk.' and accsatker = 1 and accunit = 0');            
        }
        
        return 1;
    }
    
    /*---------------------------------------- EFISIEN -------------------------------------------*/
    public function get_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.tvk, output.rvk, output.pak, output.rak, output.accsatker, output.accunit, output.accdept, output.accsatker_date, output.accunit_date, output.accdept_date '.
                                    'from tb_real_efisien output, t_giat giat, t_program program, t_output '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kdgiat = t_output.kdgiat '.
                                    'and output.kdoutput = t_output.kdoutput '.
                                    'and output.accsatker in (0,1) '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);        
        
        return $query->result_array();
    }
    
    public function is_exist_real_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select count(*) as total from tb_real_efisien '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.
                                  'and kdgiat='.$kdgiat.' '.
                                  'and accsatker=0');
        return $query->row_array();
    }
    
    public function set_real_efisien_approval()
    {            
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdprogram = $this->input->post('kdprogram');
        $kdgiat = $this->input->post('kdgiat');
        $n = $this->input->post('n');
        
        for($i=1;$i<=$n;$i++)
        {
            $kdoutput = $this->input->post('kdoutput_'.$i);
            $status = $this->input->post('status_'.$i);
            if($status == "ok")
            {
                $data = array(
                    'accunit' => 1,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_efisien',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 1 and accunit = 0');            
        }
        
        return 1;
    }
}
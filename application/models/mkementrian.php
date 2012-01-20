<?php
class Mkementrian extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_dept_identity($kddept)
    {
        //Get dept identity from table t_dept by kdunit
        $query = $this->db->query('select kddept, nmdept '.
                                'from t_dept '.
                                'where kddept='.$kddept);
        return $query->row_array();
    }
    
    public function get_unit($kddept)
    {
        //Get unit list from table t_unit by kdunit
        $query = $this->db->query('select kddept, kdunit, nmunit '.
                                'from t_unit '.
                                'where kddept='.$kddept);
        return $query->result_array();
    }   
    
    /*-------------------------------------- OUTCOME ---------------------------------------*/
    public function get_unit_iku($kddept)
    {
        //Get unit iku from tb_real_iku
        $query = $this->db->query('select distinct iku.kddept, iku.kdunit, unit.nmunit, iku.kdprogram, program.nmprogram '.
                                  'from tb_real_iku iku, t_unit unit, t_program program '.
                                  'where iku.kdprogram = program.kdprogram '.
                                  'and iku.kddept=program.kddept '.
                                  'and iku.kdunit=program.kdunit '.
                                  'and iku.kddept=unit.kddept '.
                                  'and iku.kdunit=unit.kdunit '.
                                  'and iku.kddept='.$kddept);
        
        return $query->result_array();
    }
    
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
                    'accdept' => 1,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit' => 0,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_iku',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdiku = '.$kdiku.' and accsatker = 1 and accunit = 1');            
        }
        
        return 1;
    }
    
    /*-------------------------------------- OUTPUT ---------------------------------------*/
    public function get_unit_output($kddept)
    {
        //Get unit from tb_real_output
        $query = $this->db->query('select distinct output.kddept, output.kdunit, unit.nmunit, output.kdprogram, program.nmprogram '.
                                  'from tb_real_output output, t_unit unit, t_program program '.
                                  'where output.kdprogram = program.kdprogram '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=unit.kddept '.
                                  'and output.kdunit=unit.kdunit '.
                                  'and output.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_program($kddept)
    {
        //Get unit from tb_real_output
        $query = $this->db->query('select distinct output.kddept, output.kdunit, unit.nmunit, output.kdprogram, program.nmprogram '.
                                  'from tb_real_output output, t_unit unit, t_program program '.
                                  'where output.kdprogram = program.kdprogram '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=unit.kddept '.
                                  'and output.kdunit=unit.kdunit '.
                                  'and output.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_kegiatan($kddept, $kdunit, $kdprogram)
    {
        //Get kegiatan list from table tb_real_output by kdprogram, kdunit, and kddept
        $query = $this->db->query('select distinct sr.kdsatker, sr.kddept, sr.kdunit, sr.kdsatker, sr.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, satker.nmsatker, sr.accsatker_date '.
                                    'from tb_real_output sr, t_giat giat, t_program program, t_satker satker '.
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
                                    'and sr.kdprogram='.$kdprogram);        
        
        return $query->result_array();
    }
    
    public function get_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        //Get output from tb_real_output
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
                                    'and output.accunit in (0,1) '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);        
        
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
                                  'and accsatker in (0,1)');
        return $query->row_array();
    }
    
    public function set_real_output_approval()
    {        
        $kddept = $this->session->userdata('kddept');
        $kdunit = $this->session->userdata('kdunit');
        $kdsatker = $this->session->userdata('kdsatker');
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
                    'accdept' => 1,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit' => 0,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_output',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 1 and accunit = 1 and accdept = 0');            
        }
        
        return 1;
    }
    
    /*-------------------------------------- IKK ---------------------------------------*/
    public function get_unit_ikk($kddept)
    {
        //Get unit from tb_real_ikk
        $query = $this->db->query('select distinct ikk.kddept, ikk.kdunit, unit.nmunit, ikk.kdprogram, program.nmprogram '.
                                  'from tb_real_ikk ikk, t_unit unit, t_program program '.
                                  'where ikk.kdprogram = program.kdprogram '.
                                  'and ikk.kddept=program.kddept '.
                                  'and ikk.kdunit=program.kdunit '.
                                  'and ikk.kddept=unit.kddept '.
                                  'and ikk.kdunit=unit.kdunit '.
                                  'and ikk.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_program_ikk($kddept)
    {
        //Get unit from tb_real_output
        $query = $this->db->query('select distinct ikk.kddept, ikk.kdunit, unit.nmunit, ikk.kdprogram, program.nmprogram '.
                                  'from tb_real_ikk ikk, t_unit unit, t_program program '.
                                  'where ikk.kdprogram = program.kdprogram '.
                                  'and ikk.kddept=program.kddept '.
                                  'and ikk.kdunit=program.kdunit '.
                                  'and ikk.kddept=unit.kddept '.
                                  'and ikk.kdunit=unit.kdunit '.
                                  'and ikk.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_kegiatan_ikk($kddept, $kdunit, $kdprogram)
    {
        //Get kegiatan list from table tb_real_output by kdprogram, kdunit, and kddept
        $query = $this->db->query('select distinct sr.kdsatker, sr.kddept, sr.kdunit, sr.kdsatker, sr.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, satker.nmsatker '.
                                    'from tb_real_ikk sr, t_giat giat, t_program program, t_satker satker '.
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
                                    'and sr.kdprogram='.$kdprogram);        
        
        return $query->result_array();
    }
    
    public function get_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        //Get output from tb_real_output
        $query = $this->db->query('select distinct ikk.kdsatker, ikk.kddept, ikk.kdunit, ikk.kdsatker, ikk.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_ikk.kdikk, t_ikk.nmikk, ikk.tkk, ikk.sat, ikk.rkk, ikk.accsatker, ikk.accunit, ikk.accdept, ikk.accsatker_date, ikk.accunit_date, ikk.accdept_date '.
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
                                    'and ikk.accunit in (0,1) '.
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
                                  'and accsatker in (0,1)');
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
                    'accdept' => 1,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit' => 0,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_ikk',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdikk = '.$kdikk.' and accsatker = 1 and accunit = 1 and accdept = 0');            
        }
        
        return 1;
    }
    
    /*-------------------------------------- Efisien ---------------------------------------*/
    public function get_unit_efisien($kddept)
    {
        //Get unit from tb_real_output
        $query = $this->db->query('select distinct output.kddept, output.kdunit, unit.nmunit, output.kdprogram, program.nmprogram '.
                                  'from tb_real_efisien output, t_unit unit, t_program program '.
                                  'where output.kdprogram = program.kdprogram '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=unit.kddept '.
                                  'and output.kdunit=unit.kdunit '.
                                  'and output.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_program_efisien($kddept)
    {
        //Get unit from tb_real_output
        $query = $this->db->query('select distinct output.kddept, output.kdunit, unit.nmunit, output.kdprogram, program.nmprogram '.
                                  'from tb_real_efisien output, t_unit unit, t_program program '.
                                  'where output.kdprogram = program.kdprogram '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=unit.kddept '.
                                  'and output.kdunit=unit.kdunit '.
                                  'and output.kddept='.$kddept);
        return $query->result_array();
    }
    
    public function get_unit_kegiatan_efisien($kddept, $kdunit, $kdprogram)
    {
        //Get kegiatan list from table tb_real_output by kdprogram, kdunit, and kddept
        $query = $this->db->query('select distinct sr.kdsatker, sr.kddept, sr.kdunit, sr.kdsatker, sr.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, satker.nmsatker '.
                                    'from tb_real_efisien sr, t_giat giat, t_program program, t_satker satker '.
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
                                    'and sr.kdprogram='.$kdprogram);        
        
        return $query->result_array();
    }
    
    public function get_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        //Get output from tb_real_output
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
                                    'and output.accunit in (0,1) '.
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
                                  'and accsatker in (0,1)');
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
                    'accdept' => 1,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );
            }
            else
            {
                $data = array(
                    'accsatker' => 0,
                    'accunit' => 0,
                    'accdept_date' => date("Y-m-d H:i:s"),
                );    
            }
            
            $this->db->update('tb_real_efisien',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 1 and accunit = 1 and accdept = 0');            
        }
        
        return 1;
    }
    
    public function get_catatan()
    {
        $kddept = $this->session->userdata('kddept');        
        
        $query = $this->db->query('select catatan, tglupdate from tb_catatan_kl '.                                                                    
                                  'where kddept = '.$kddept.' '.
                                  'order by tglupdate desc');
        return $query->result_array();
        
    }
    
    public function get_catatan_eselon()
    {
        $kddept = $this->session->userdata('kddept');        
        
        $query = $this->db->query('select kdunit, catatan, tglupdate from tb_catatan_eselon '.                                                                    
                                  'where kddept = '.$kddept.' '.
                                  'order by tglupdate desc');
        return $query->result_array();
        
    }
    
    public function set_catatan()
    {
        $kddept = $this->session->userdata('kddept');
        $text = $this->input->post('comment');
        
        $data = array(          
          'kddept' => $kddept,
          'catatan' => $text,
          'tglupdate' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tb_catatan_kl',$data);
        $this->log->create('entry data', 'K/L '.$kddept.' add catatan');
    }
}
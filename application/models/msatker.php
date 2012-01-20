<?php
class Msatker extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    /*------------------------------------------------- Identity -------------------------------------*/
    public function get_satker_identity($kdsatker)
    {
        //Get satker identity form table t_satker by kdsatker
        $query = $this->db->query('select satker.kdsatker, satker.nmsatker, unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept '.
                                'from t_satker satker, t_unit unit, t_dept dept '.
                                'where satker.kdunit=unit.kdunit '.
                                'and satker.kddept=dept.kddept '.
                                'and unit.kddept=dept.kddept '.
                                'and satker.kdsatker='.$kdsatker);
        return $query->row_array();
    }
    
    
    /*---------------------------------- Outcome ------------------------------------------------*/
    
    public function get_iku($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        $is_exist = $this->is_exist_real_iku($kddept, $kdunit, $kdsatker, $kdprogram);
        if($is_exist['total'] > 0)
        {
            //Get IKU from t_iku
            $query = $this->db->query('select r_iku.*, iku.nmiku '.
                                  'from tb_real_iku r_iku, t_iku iku '.
                                  'where r_iku.kdiku=iku.kdiku '.
                                  'and r_iku.kddept=iku.kddept '.
                                  'and r_iku.kdunit=iku.kdunit '.
                                  'and r_iku.kdprogram=iku.kdprogram '.
                                  'and r_iku.kddept='.$kddept.' '.
                                  'and r_iku.kdunit='.$kdunit.' '.
                                  'and r_iku.kdsatker='.$kdsatker.' '.
                                  'and r_iku.kdprogram='.$kdprogram);
        }
        else
        {
            //Get IKU from t_iku
            $query = $this->db->query('select *, 0 as accsatker,0 as accsatker_date, 0 as accunit, 0 as accunit_date, 0 as accdept, 0 as accdept_date '.
                                  'from t_iku '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdprogram='.$kdprogram);
        }
        return $query->result_array();
    }
    
    public function set_real_iku($do)
    {
        if($do == 'Simpan')
        {
            $accsatker = 0;    
        }
        elseif($do == 'Proses')
        {
            $accsatker = 1;    
        }
                        
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdprogram = $this->input->post('kdprogram');        
        $n = $this->input->post('n');
        
        //check first in tb_real_iku
        $is_exist = $this->is_exist_real_iku($kddept, $kdunit, $kdsatker, $kdprogram);
        if($is_exist['total'] > 0)
        {
            $status = 'update';
        }
        else
        {
            $status = 'insert';
        }
        
        for($i=1;$i<=$n;$i++)
        {
            $kdiku = $this->input->post('kdiku_'.$i);
            $tku = $this->input->post('tku_'.$i);
            $rku = $this->input->post('rku_'.$i);
            $sat = $this->input->post('sat_'.$i);
            
            $data = array(
                    'kddept' => $kddept,
                    'kdunit' => $kdunit,
                    'kdsatker' => $kdsatker,
                    'kdprogram' => $kdprogram,                    
                    'kdiku' => $kdiku,
                    'sat' => $sat,
                    'tku' => $tku,
                    'rku' => $rku,
                    'accsatker' => $accsatker,
                    'accsatker_date' => date("Y-m-d H:i:s"),
                    'accunit' => 0,
                    'accunit_date' => '',
                    'accdept' => 0,
                    'accdept_date' => '',
                    );
            if($status == 'update')
            {
                $this->db->update('tb_real_iku',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdiku = '.$kdiku.' and accsatker = 0');
                $this->log->create('entry data', $this->session->kdsatker.' add data realisasi output');
            }
            else
            {
                $this->db->insert('tb_real_iku',$data);
                $this->log->create('entry data', $this->session->kdsatker.' add data realisasi output');
            }
        }
        
        return 1;
    }
    
    public function is_exist_real_iku($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        $query = $this->db->query('select count(*) as total from tb_real_iku '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.                                  
                                  'and accsatker in (0,1)');
        
        return $query->row_array();
    }
    
    /*---------------------------------------- OUTPUT -------------------------------------------*/
    public function get_satker_program($kddept, $kdunit, $kdsatker)
    {
        //Get program list from table d_output by kdsatker, kdunit, and kddept
        $query = $this->db->query('SELECT distinct output.kdsatker, output.kdprogram, output.kdunit, output.kddept, program.nmprogram '.
                                  'from d_output output, t_program program '.
                                  'where output.kdprogram=program.kdprogram '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit='.$kdunit.' '.
                                  'and output.kddept='.$kddept.' '.
                                  'and output.kdsatker='.$kdsatker);
        return $query->result_array();
    }
    
    public function get_satker_kegiatan($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        //Get kegiatan list from table d_output by kdprogram, kdsatker, kdunit, and kddept
        $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat '.
                                    'from d_output output, t_giat giat, t_program program '.
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
    
    public function get_detail_giat($kdgiat)
    {
        $sql = "select * from t_giat where kdgiat = ".$kdgiat;
        $query = $this->db->query($sql);
        
        return $query->row_array();
    }
    
    public function get_satker_program_revisi($kddept, $kdunit, $kdsatker)
    {
        //Get program list from table tb_real_output by kdsatker, kdunit, and kddept
        $query = $this->db->query('SELECT distinct output.kdsatker, output.kdprogram, output.kdunit, output.kddept, program.nmprogram '.
                                  'from tb_real_output output, t_program program '.
                                  'where output.kdprogram=program.kdprogram '.
                                  'and output.kdunit=program.kdunit '.
                                  'and output.kddept=program.kddept '.
                                  'and output.kdunit='.$kdunit.' '.
                                  'and output.kddept='.$kddept.' '.
                                  'and output.kdsatker='.$kdsatker.' '.
                                  'and output.accsatker=0 '.
                                  'and output.accunit_date!="0000-00-00 00:00:00" ');
        return $query->result_array();
    }
    
    public function get_satker_kegiatan_revisi($kddept, $kdunit, $kdsatker, $kdprogram)
    {
        //Get kegiatan list from table d_output by kdprogram, kdsatker, kdunit, and kddept
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
                                    'and output.kdprogram='.$kdprogram.' '.
                                    'and output.accsatker=0 '.
                                    'and output.accunit_date!="0000-00-00 00:00:00" ');        
        
        return $query->result_array();
    }
    
    public function get_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $is_exist = $this->is_exist_real_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            $query = $this->db->query('select distinct output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.tvk as vol, output.rvk, output.accsatker, output.accunit, output.accdept, output.accsatker_date, output.accunit_date, output.accdept_date '.
                                    'from tb_real_output output, t_giat giat, t_program program, t_output '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kdgiat = t_output.kdgiat '.
                                    'and output.kdoutput = t_output.kdoutput '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);
        }
        else
        {
            //Get kegiatan list from table d_output by kdprogram, kdsatker, kdunit, and kddept
            $query = $this->db->query('select distinct output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.vol, 0 as accsatker, 0 as accunit, 0 as accdept, 0 as accsatker_date, 0 as accunit_date, 0 as accdept_date '.
                                    'from d_output output, t_giat giat, t_program program, t_output '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kdgiat = t_output.kdgiat '.
                                    'and output.kdoutput = t_output.kdoutput '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);
        }
        
        return $query->result_array();
    }

    public function set_real_output($do)
    {
        if($do == 'Simpan')
        {
            $accsatker = 0;    
        }
        elseif($do == 'Proses')
        {
            $accsatker = 1;    
        }
                        
        $kddept = $this->session->userdata('kddept');
        $kdunit = $this->session->userdata('kdunit');
        $kdsatker = $this->session->userdata('kdsatker');
        $kdprogram = $this->input->post('kdprogram');
        $kdgiat = $this->input->post('kdgiat');
        $n = $this->input->post('n');
        
        //check first in tb_satker_realisasi
        $is_exist = $this->is_exist_real_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            $status = 'update';
        }
        else
        {
            $status = 'insert';
        }
        
        for($i=1;$i<=$n;$i++)
        {
            $kdoutput = $this->input->post('kdoutput_'.$i);
            $tvk = $this->input->post('tvk_'.$i);
            $rvk = $this->input->post('rvk_'.$i);
            $sat = $this->input->post('sat_'.$i);
            
            $data = array(
                    'kddept' => $kddept,
                    'kdunit' => $kdunit,
                    'kdsatker' => $kdsatker,
                    'kdprogram' => $kdprogram,
                    'kdgiat' => $kdgiat,
                    'kdoutput' => $kdoutput,
                    'sat' => $sat,
                    'tvk' => $tvk,
                    'rvk' => $rvk,
                    'accsatker' => $accsatker,
                    'accsatker_date' => date("Y-m-d H:i:s"),
                    'accunit' => 0,
                    'accunit_date' => '',
                    'accdept' => 0,
                    'accdept_date' => '',
                    );
            if($status == 'update')
            {
                $this->db->update('tb_real_output',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 0');
                $this->log->create('entry data', $kdsatker.' add data realisasi output');
            }
            else
            {
                $this->db->insert('tb_real_output',$data);
                $this->log->create('entry data', $kdsatker.' add data realisasi output');
            }
        }
        
        return 1;
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
    
    /*---------------------------------- IKK ------------------------------------------------*/
    
    public function get_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $is_exist = $this->is_exist_real_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            //Get IKK from t_real_ikk
            $query = $this->db->query('select r_ikk.*, ikk.nmikk '.
                                  'from tb_real_ikk r_ikk, t_ikk ikk '.
                                  'where r_ikk.kdikk=ikk.kdikk '.
                                  'and r_ikk.kdgiat=ikk.kdgiat '.                                  
                                  'and r_ikk.kddept='.$kddept.' '.
                                  'and r_ikk.kdunit='.$kdunit.' '.
                                  'and r_ikk.kdsatker='.$kdsatker.' '.
                                  'and r_ikk.kdprogram='.$kdprogram.' '.
                                  'and r_ikk.kdgiat='.$kdgiat);
        }
        else
        {
            //Get IKK from t_ikk
            $query = $this->db->query('select *, 100 as tkk, "%" as sat, 0 as accsatker,0 as accsatker_date, 0 as accunit, 0 as accunit_date, 0 as accdept, 0 as accdept_date '.
                                  'from t_ikk '.
                                  'where kdgiat='.$kdgiat);
        }
        return $query->result_array();
    }
    
    public function set_real_ikk($do)
    {
        if($do == 'Simpan')
        {
            $accsatker = 0;    
        }
        elseif($do == 'Proses')
        {
            $accsatker = 1;    
        }
                        
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdgiat = $this->input->post('kdgiat');
        $kdprogram = $this->input->post('kdprogram');
        
        $n = $this->input->post('n');
        
        //check first in tb_real_ikk
        $is_exist = $this->is_exist_real_ikk($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            $status = 'update';
        }
        else
        {
            $status = 'insert';
        }
        
        for($i=1;$i<=$n;$i++)
        {
            $kdikk = $this->input->post('kdikk_'.$i);
            $tkk = $this->input->post('tkk_'.$i);
            $rkk = $this->input->post('rkk_'.$i);
            $sat = $this->input->post('sat_'.$i);
            
            $data = array(
                    'kddept' => $kddept,
                    'kdunit' => $kdunit,
                    'kdsatker' => $kdsatker,
                    'kdprogram' => $kdprogram,
                    'kdgiat' => $kdgiat,
                    'kdikk' => $kdikk,
                    'sat' => $sat,
                    'tkk' => $tkk,
                    'rkk' => $rkk,
                    'accsatker' => $accsatker,
                    'accsatker_date' => date("Y-m-d H:i:s"),
                    'accunit' => 0,
                    'accunit_date' => '',
                    'accdept' => 0,
                    'accdept_date' => '',
                    );
            if($status == 'update')
            {
                $this->db->update('tb_real_ikk',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdikk = '.$kdikk.' and accsatker = 0');
                $this->log->create('entry data', $this->session->kdsatker.' add data realisasi ikk');
            }
            else
            {
                $this->db->insert('tb_real_ikk',$data);
                $this->log->create('entry data', $this->session->kdsatker.' add data realisasi ikk');
            }
        }
        
        return 1;
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
    
    /*---------------------------------- efisien ------------------------------------------------*/    
    public function get_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $is_exist = $this->is_exist_real_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
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
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);
        }
        else
        {
            //Get kegiatan list from table d_output by kdprogram, kdsatker, kdunit, and kddept
            $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.tvk, output.rvk, 10000000 as pak, 0 as rak, 0 as accsatker, 0 as accunit, 0 as accdept, 0 as accsatker_date, 0 as accunit_date, 0 as accdept_date '.
                                    'from tb_real_output output, t_giat giat, t_program program, t_output '.
                                    'where output.kdgiat = giat.kdgiat '.
                                    'and output.kdunit = giat.kdunit '.
                                    'and output.kddept = giat.kddept '.
                                    'and output.kdprogram = program.kdprogram '.
                                    'and output.kdunit = program.kdunit '.
                                    'and output.kddept = program.kddept '.
                                    'and output.kdgiat = t_output.kdgiat '.
                                    'and output.kdoutput = t_output.kdoutput '.
                                    'and output.kddept='.$kddept.' '.
                                    'and output.kdunit='.$kdunit.' '.                                 
                                    'and output.kdsatker='.$kdsatker.' '.
                                    'and output.kdprogram='.$kdprogram.' '.                                
                                    'and output.kdgiat='.$kdgiat);
        }
        
        return $query->result_array();
    }

    public function set_real_efisien($do)
    {
        if($do == 'Simpan')
        {
            $accsatker = 0;    
        }
        elseif($do == 'Proses')
        {
            $accsatker = 1;    
        }
                        
        $kddept = $this->input->post('kddept');
        $kdunit = $this->input->post('kdunit');
        $kdsatker = $this->input->post('kdsatker');
        $kdprogram = $this->input->post('kdprogram');
        $kdgiat = $this->input->post('kdgiat');
        $n = $this->input->post('n');
        
        //check first in tb_satker_realisasi
        $is_exist = $this->is_exist_real_efisien($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            $status = 'update';
        }
        else
        {
            $status = 'insert';
        }
        
        for($i=1;$i<=$n;$i++)
        {
            $kdoutput = $this->input->post('kdoutput_'.$i);
            $tvk = $this->input->post('tvk_'.$i);
            $rvk = $this->input->post('rvk_'.$i);
            $sat = $this->input->post('sat_'.$i);
            $pak = $this->input->post('pak_'.$i);
            $rak = $this->input->post('rak_'.$i);
            
            $data = array(
                    'kddept' => $kddept,
                    'kdunit' => $kdunit,
                    'kdsatker' => $kdsatker,
                    'kdprogram' => $kdprogram,
                    'kdgiat' => $kdgiat,
                    'kdoutput' => $kdoutput,
                    'sat' => $sat,
                    'tvk' => $tvk,
                    'rvk' => $rvk,
                    'pak' => $pak,
                    'rak' => $rak,
                    'accsatker' => $accsatker,
                    'accsatker_date' => date("Y-m-d H:i:s"),
                    'accunit' => 0,
                    'accunit_date' => '',
                    'accdept' => 0,
                    'accdept_date' => '',
                    );
            if($status == 'update')
            {
                $this->db->update('tb_real_efisien',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 0');
                $this->log->create('entry data', $this->session->kdsatker.' add data efisien');
            }
            else
            {
                $this->db->insert('tb_real_efisien',$data);
                $this->log->create('entry data', $this->session->kdsatker.' add data efisien');
            }
        }
        
        return 1;
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
    
    public function get_catatan()
    {
        $kddept = $this->session->userdata('kddept');
        $kdunit = $this->session->userdata('kdunit');
        $kdsatker = $this->session->userdata('kdsatker');
        
        $query = $this->db->query('select catatan, tglupdate from tb_catatan_satker '.
                                  'where kdsatker = '.$kdsatker.' '.
                                  'and kdunit = '.$kdunit.' '.
                                  'and kddept = '.$kddept.' '.
                                  'order by tglupdate desc');
        return $query->result_array();
        
    }
    
    public function set_catatan()
    {
        $kddept = $this->session->userdata('kddept');
        $kdunit = $this->session->userdata('kdunit');
        $kdsatker = $this->session->userdata('kdsatker');
        $text = $this->input->post('comment');
        
        $data = array(
          'kdsatker' => $kdsatker,
          'kdunit' => $kdunit,
          'kddept' => $kddept,
          'catatan' => $text,
          'tglupdate' => date('Y-m-d H:i:s'),
        );
        $this->db->insert('tb_catatan_satker',$data);
        $this->log->create('entry data', 'Satker '.$kdsatker.' add catatan');
    }
	
	function get_kd_file($name)
	{
	$sql = 'SELECT id, filename from tb_upload where filename LIKE "%'.$name.'%" ORDER BY id DESC LIMIT 1;';
	$query = $this->db->query($sql);
	return $query->result();
	}

}
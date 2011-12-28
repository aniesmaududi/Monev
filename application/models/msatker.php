<?php
class Msatker extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
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
    
    public function get_satker_output($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $is_exist = $this->is_exist_satker_realisasi($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
        if($is_exist['total'] > 0)
        {
            $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.tvk as vol, output.rvk, output.accsatker, output.accunit, output.accdept '.
                                    'from tb_satker_realisasi output, t_giat giat, t_program program, t_output '.
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
            $query = $this->db->query('select distinct output.kdsatker, output.kddept, output.kdunit, output.kdsatker, output.kdprogram, program.nmprogram, giat.kdgiat, giat.nmgiat, t_output.kdoutput, t_output.nmoutput, t_output.sat, output.vol '.
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
    
    public function is_exist_satker_realisasi($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat)
    {
        $query = $this->db->query('select count(*) as total from tb_satker_realisasi '.
                                  'where kddept='.$kddept.' '.
                                  'and kdunit='.$kdunit.' '.
                                  'and kdsatker='.$kdsatker.' '.
                                  'and kdprogram='.$kdprogram.' '.
                                  'and kdgiat='.$kdgiat.' '.
                                  'and accsatker in (0,1)');
        
        return $query->row_array();
    }
    
    public function set_satker_realisasi($do)
    {
        if($do == 'Simpan')
        {
            $accsatker = 0;    
        }
        elseif($do == 'Eskalasi')
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
        $is_exist = $this->is_exist_satker_realisasi($kddept, $kdunit, $kdsatker, $kdprogram, $kdgiat);
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
            
            $data = array(
                    'kddept' => $kddept,
                    'kdunit' => $kdunit,
                    'kdsatker' => $kdsatker,
                    'kdprogram' => $kdprogram,
                    'kdgiat' => $kdgiat,
                    'kdoutput' => $kdoutput,
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
                $this->db->update('tb_satker_realisasi',$data, 'kddept = '.$kddept.' and kdunit = '.$kdunit.' and kdsatker = '.$kdsatker.' and kdprogram = '.$kdprogram.' and kdgiat = '.$kdgiat.' and kdoutput = '.$kdoutput.' and accsatker = 0');
            }
            else
            {
                $this->db->insert('tb_satker_realisasi',$data);
            }
        }
        
        return 1;
    }
}
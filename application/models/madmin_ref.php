<?php
class Madmin_ref extends CI_Model
{
    public function __construct()
    {        
        $this->load->database();
    }
    
    public function get_tables()
    {
        $query = $this->db->query('select table_name '.
                                  'from information_schema.tables '.
                                  'where table_schema = "db_monev" '.
                                  'and table_name in ("t_dept","t_unit","t_satker","t_program","t_iku","t_output") '.
                                  'order by table_name');
        
        return $query->result_array();
    }
    
    public function get_table_field($table_name)
    {
        return $this->db->list_fields($table_name);
    }
    
    public function get_table_detail($table_name)
    {
        $query = $this->db->query('select * '.
                                  'from '.$table_name.' '.
                                  'limit 10');
        
        return $query->result_array();
    }
    
    public function get_row_detail($table_name, $keys)
    {        
        $where = $keys[5].' = '.$keys[6];
        for($i=7;$i<count($keys);$i++)
        {
            if($i%2 != 0){
                $field = $keys[$i];
                $value = $keys[$i+1];
                $where .= ' and '.$field.' = '.$value;
            } 
        }
        
        $query = $this->db->query('select * '.
                                  'from '.$table_name.' '.
                                  'where '.$where);
        return $query->row_array();
    }
    
    public function save_record($table_name)
    {
        $field = $this->get_table_field($table_name);
        $item[$field[0]] = $this->input->post($field[0]);
        $values = $field[0].' = \''.$item[$field[0]].'\'';
        $where = $field[0].' = \''.$item[$field[0]].'\'';
        
        for($i=1;$i<count($field);$i++)
        {
            $item[$field[$i]] = $this->input->post($field[$i]);
            $values .= ', '.$field[$i].' = \''.$item[$field[$i]].'\'';
            if($field[$i] == 'kddept' || $field[$i] == 'kdunit' || $field[$i] == 'kdsatker' || $field[$i] == 'kdprogram' || $field[$i] == 'kdgiat'){
            $where .= ' and '.$field[$i].' = \''.$item[$field[$i]].'\'';
            }
        }
        $update = 'update '.$table_name.' set '.$values.' where '.$where;
        //return $update;
        $this->db->query($update);        
    }
    
    public function delete_record($table_name)
    {
        $field = $this->get_table_field($table_name);
        $item[$field[0]] = $this->input->post($field[0]);
        $values = $field[0].' = \''.$item[$field[0]].'\'';
        $where = $field[0].' = \''.$item[$field[0]].'\'';
        
        for($i=1;$i<count($field);$i++)
        {
            $item[$field[$i]] = $this->input->post($field[$i]);
            $values .= ', '.$field[$i].' = \''.$item[$field[$i]].'\'';
            if($field[$i] == 'kddept' || $field[$i] == 'kdunit' || $field[$i] == 'kdsatker' || $field[$i] == 'kdprogram' || $field[$i] == 'kdgiat'){
            $where .= ' and '.$field[$i].' = \''.$item[$field[$i]].'\'';
            }
        }
        $delete = 'delete from '.$table_name.' where '.$where;
        //return $delete;
        $this->db->query($delete);        
    }
}
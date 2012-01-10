<?php
class Queue extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_adminlogin();
        $this->data['now'] = date("Y-m-d H:i:s");
        $this->load->model('admin_model', 'admin');
        $this->load->library('form_validation');
        $this->load->dbforge();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
    }

    function index()
    {
        $sql = 'select u.id, u.is_done, satker.kdsatker, satker.nmsatker, unit.kdunit, unit.nmunit, dept.kddept, dept.nmdept '.
                'from tb_upload u, t_satker satker, t_unit unit, t_dept dept '.
                'where u.kddept = dept.kddept '.
                'and u.kddept = unit.kddept '.
                'and u.kdunit = unit.kdunit '.
                'and u.kddept = satker.kddept '.
                'and u.kdunit = satker.kdunit '.
                'and u.kdsatker = satker.kdsatker';
        
        $result = $this->db->query($sql);
        
        $this->data['rows'] = $result;

        $this->data['title'] = 'Antrian Expor berkas Satker';
        $this->data['template'] = 'queue/index';
        $this->load->view('backend/index', $this->data);
    }

    function execute($id)
    {

        $row = $this->db->from('tb_upload')->where('id', $id)->get()->row();

        $path = getcwd() . '/tmp/';
        $filename = $row->filename;
        
        if (!file_exists($path . DIRECTORY_SEPARATOR . $row->code)) {
            echo mkdir($path . DIRECTORY_SEPARATOR . $row->code);
        }

        $this->_extract($path . $filename, $path . $row->code);

        $dir = scandir($path . $row->code);
        //echo 'path : '.$path.'<br>';
        //echo 'filename : '.$filename.'<br>';
        //echo 'row code : '.$row->code.'<br>';
        //print_r($dir);
        
        require_once('./prodigy-dbf.php');
        /* load the required classes */
        require_once "phpxbase/Column.class.php";
        require_once "phpxbase/Record.class.php";
        require_once "phpxbase/Table.class.php";
        
        $sql = $sql2 = '';
        $this->db->query('USE staging_monev');
        $nullflags = 0;

        //foreach ($dir as $v) {
        //echo count($dir);
        for($i=2;$i<count($dir);$i++){            
            $exploded = explode($row->code, $dir[$i]);
            //echo ' <br> dudi : '.$exploded[0];            
            /* buat object table dan buka */
            if(substr($exploded[0], -3) != "FPT" && $exploded[0] != "t_versi.DBF"){
                $table = new XBaseTable('tmp/' . $row->code . '/' . $exploded[0] . $row->code);            
                $table->open();
                
                /*Create table */
                $create_table = "create table if not exists ".$exploded[0]. " ( ";                        
                $fields = $table->getColumns();
                for($t=0;$t<count($fields);$t++)
                {
                    $j = count($fields) - 1;
                    switch($fields[$i]->type)
                    {
                        case "C" : $type = "char"; break;
                        case "N" : $type = "varchar"; break;
                    }
                    if($t == $j)
                    {                                    
                        $create_table .= $fields[$t]->name." ".$type."(".$fields[$t]->length.") null ";
                    }
                    else
                    {                                    
                        $create_table .= $fields[$t]->name." ".$type."(".$fields[$t]->length.") null, ";                               
                    }
                }
                $create_table .= ");";
                //echo $create_table;
                $this->db->query($create_table);
                                
                //insert data of table X
                while ($record = $table->nextRecord()) {
                    //$field = $table->getColumns();                
                    $data = $record->choppedData;
                    $value_of_field = "'".$data[0]."'";
                    for($val=1;$val<count($data);$val++)
                    {
                        $value_of_field .= ",'".$data[$val]."'";                            
                    }
                    $sql = "INSERT INTO ".$exploded[0]." VALUES ($value_of_field);";
                    $this->db->query($sql);
                //echo $sql;
                } //end while
                
                $table->close();     
            }                                    
        }
        $this->db->update('db_monev.tb_upload', array('is_done' => true), array('id' => $id));
        redirect(site_url().'backend/queue');
    }

    public function test()
    {
        require_once('./prodigy-dbf.php');
        $Test = new Prodigy_DBF(base_url()."/tmp/0250810418198.12/d_giat0250810418198.12", base_url()."/tmp/0250810418198.12/d_giat0250810418198.FPT");
        while(($Record = $Test->GetNextRecord(true)) and !empty($Record)) {
            print_r($Record);
        }
    }

    public function _extract($filename, $path = './', $password = 'B1040VQ')
    {
        $command = sprintf("unrar x -y -p{$password} %s %s", $filename, $path);
        exec($command, $output);
        // echo $command;
        // print_r(output);
    }

    function write2fs($filename)
    {


    }
}
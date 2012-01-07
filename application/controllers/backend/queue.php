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
    }

    function index()
    {
        $result = $this->db->from('tb_upload')
                ->get();

        $this->data['rows'] = $result;

        $this->data['title'] = 'Antrian';
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
        echo 'path : '.$path.'<br>';
        echo 'filename : '.$filename.'<br>';
        echo 'row code : '.$row->code.'<br>';
        print_r($dir);

        require_once('./prodigy-dbf.php');

        $sql = $sql2 = '';
        $this->db->query('USE staging_monev');
        $nullflags = 0;

        foreach ($dir as $v) {
            
            $exploded = @explode($row->code, $v);
            
            if ($exploded[0] != '.') {
                if ($exploded[0] != '..') {
                    if ($exploded[0] != '.DS_Store') {

                        /* load the required classes */
                        require_once "phpxbase/Column.class.php";
                        require_once "phpxbase/Record.class.php";
                        require_once "phpxbase/Table.class.php";

                        /* buat object table dan buka */                                            
                        $table = new XBaseTable('tmp/' . $row->code . '/' . $exploded[0] . $row->code);
                        $table->open();
                        print_r($table->getColumns());
                        $row = 1;
                        while ($record = $table->nextRecord()) {
                            $field = $record->getColumn(1)->name;
                            echo 'field : '.$field.'<br>';
                            $value_of_field = '';
                            foreach ($table->getColumns() as $i => $c) {
                                $value_of_field .= ",'" . $record->getString($c) . "'";
                                
                            }                        
                            $sql = "INSERT INTO $field VALUES ($value_of_field);";
                            echo $sql;
                            //$this->db->query($sql);
                            //echo $this->db->last_query();
                            //echo "\n\n";
                        } //end while
                        
                        $table->close();
                    }
                }
            }
        }
        //$this->db->update('tb_upload', array('is_done' => true), array('id' => $id));

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
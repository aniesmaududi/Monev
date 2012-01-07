<?php
class Log
{
    public $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Buat user log.
     * Data disimpan didalam table tb_logs atau file juga?!?
     *
     * @param $category String Kategori kegiatan user. (e.g 'Hapus', 'Tambah', 'Ubah')
     * @param $message String Detail informasi kegiatan user. (e.g 'Menghapus datanya sendiri')
     * @return void
     */
    public function create ($category, $message)
    {
        $this->CI->load->library('session');
        $date = date('Y-m-d H:i:s');
        $username = $this->CI->session->userdata('username');

        $data = array(
            'tanggal' => $date,
            'user' => $username,
            'kategori' => $category,
            'aksi' => $message
        );
        $this->CI->db->insert('tb_audit_trail', $data);
    }
}
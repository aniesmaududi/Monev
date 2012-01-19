<?php
function hooks()
{
    $ci =& get_instance();

    //flash maessages
    $ci->message->failed = 'Data gagal disimpan.';
    $ci->message->success = 'Data berhasil disimpan.';
    $ci->message->success_delete = 'Data berhasil dihapus.';

    $ci->output->enable_profiler(TRUE);
}

function compress()
{
    $CI = & get_instance();
    $buffer = $CI->output->get_output();

    $search = array(
        '/\n/', // replace end of line by a space
        '/\>[^\S ]+/s', // strip whitespaces after tags, except space
        '/[^\S ]+\</s', // strip whitespaces before tags, except space
        '/(\s)+/s'  // shorten multiple whitespace sequences
    );

    $replace = array(
        ' ',
        '>',
        '<',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    $CI->output->set_output($buffer);
    $CI->output->_display();
}

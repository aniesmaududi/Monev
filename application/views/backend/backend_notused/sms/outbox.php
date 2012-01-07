<meta http-equiv="refresh" content="3; url=<?php echo $_SERVER['PHP_SELF'];  ?>">

<h1><?php echo $title;?></h1>
<div id="search-box" style="min-height:400px;">
    <!--	--><?php //if(count($users)>0):?>
    <?php
    if ($this->session->flashdata('message')):
        echo flash_message($this->session->flashdata('message_type'));
    endif;
    ?>
    <table class="backend-table">
        <thead>
        <th class="oe" width="1px;">&nbsp;</th>
        <th>No Telp</th>
        <th>Pesan</th>
        <th>Status</th>
        </thead>
        <!--			--><?php //foreach($users as $user):?>
        <tr>
            <td><input type="checkbox" /></td>
            <td>085222872005</td>
            <td>Input data realisasi anda tidak disahkan oleh Eselon I</td>
            <td>
                <img src="<?php echo base_url('assets/images/done.png') ?>"/> Terkirim
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>08134837411</td>
            <td>Data realisasi berhasil diekskalasi </td>
            <td>
                <img src="<?php echo base_url('assets/images/notdone.png') ?>"/> Belum terkirim
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>087827381811</td>
            <td>Data realisasi anda telah disahkan oleh Eselon I</td>
            <td>
                <img src="<?php echo base_url('assets/images/done.png') ?>"/> Terkirim
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
            </td>
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>081369937231</td>
            <td>Format yang anda masukkan salah. Ketik INFO untuk informasi.</td>
            <td>
                <img src="<?php echo base_url('assets/images/done.png') ?>"/> Terkirim
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
            </td>
        </tr>
        <!--			--><?php //endforeach;?>
    </table>

     <a href="" class="btn error">Hapus</a>

    <!--	--><?php //else:?>
<!--    no data-->
    <!--	--><?php //endif;?>
</div>
<div id="nav-box">
<!--    --><?php //echo $page; ?>
    <div class="clearfix"></div>
</div>
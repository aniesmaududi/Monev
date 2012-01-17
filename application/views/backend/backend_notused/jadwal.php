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
        <th>Jam</th>
        <th>Satker</th>
<!--        <th>Nama</th>-->
<!--        <th class="option-table">Status</th>-->
        </thead>
        <!--			--><?php //foreach($users as $user):?>
        <tr>
            <td>06:00 - 18:00</td>
            <td>SEKRETARIAT JENDRAL</td>
<!--            <td>Alan Budi Kusuma</td>-->
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td>06:00 - 18:00</td>
            <td>DEWAN</td>
<!--            <td>Budi Setiawan</td>-->
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
                <!--                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td>06:00 - 18:00</td>
            <td>BADAN PEMBERDAYAAN</td>
<!--            <td>Budi Santoso</td>-->
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/notdone.png') ?><!--"/> Belum upload-->
                <!--                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td>06:00 - 18:00</td>
            <td>KEJAKSAAN AGUNG RI</td>
<!--            <td>Iwan Wirawan</td>-->
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
                <!--                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <!--			--><?php //endforeach;?>
    </table>

    <!--	--><?php //else:?>
<!--    no data-->
    <!--	--><?php //endif;?>
</div>
<div id="nav-box">
<!--    --><?php //echo $page; ?>
    <div class="clearfix"></div>
</div>
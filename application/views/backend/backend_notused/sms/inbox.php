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
        </thead>
        <!--			--><?php //foreach($users as $user):?>
        <tr>
            <td><input type="checkbox" /></td>
            <td>085228402005</td>
            <td>TOKEN 321493</td>
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>08124835332</td>
            <td>TOKEN 934543</td>
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>08563982191</td>
            <td>TOKEN 854213</td>
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/notdone.png') ?><!--"/> Belum upload-->
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
        </tr>
        <tr>
            <td><input type="checkbox" /></td>
            <td>081369937231</td>
            <td>TOKEN 234323</td>
<!--            <td>-->
<!--                <img src="--><?php //echo base_url('assets/images/done.png') ?><!--"/> Upload sukses-->
<!--                                    <a href="--><?php ////echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?><!--" class="btn">Edit</a> <a href="" class="btn error">Hapus</a>-->
<!--            </td>-->
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
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
        <th>Tanggal</th>
        <th>User ID</th>
        <th>Aksi</th>
<!--        <th>Kategori</th>-->
        </thead>

        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?php echo $log->tanggal ?></td>
            <td><?php echo $log->user ?></td>
            <td><?php echo $log->aksi ?></td>
<!--            <td>--><?php //echo $log->kategori ?><!--</td>-->
        </tr>
        <?php endforeach;?>
    </table>

<!--    <a href="" class="btn error">Hapus</a>-->

    <!--	--><?php //else:?>
    <!--    no data-->
    <!--	--><?php //endif;?>
</div>
<div id="nav-box">
    <!--    --><?php //echo $page; ?>
    <div class="clearfix"></div>
</div>
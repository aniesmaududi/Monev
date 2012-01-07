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
        <th>Tabel</th>
        </thead>

        <tr>
            <td><a href="#">t_satker</a></td>
        </tr>
        <tr>
            <td><a href="#">t_unit</a></td>
        </tr>
        <tr>
            <td><a href="#">t_kementrian</a></td>
        </tr>
    </table>

    <!--	--><?php //else:?>
    <!--    no data-->
    <!--	--><?php //endif;?>
</div>
<div id="nav-box">
    <!--    --><?php //echo $page; ?>
    <div class="clearfix"></div>
</div>
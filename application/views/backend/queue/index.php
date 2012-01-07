<h1><?php echo $title;?></h1>
<div id="search-box" style="min-height:400px;">


    <?php
    if ($this->session->flashdata('message')):
        echo flash_message($this->session->flashdata('message_type'));
    endif;
    ?>
    <table class="backend-table">

        <thead>
        <th>Nama File</th>
        <th></th>
        <th>Aksi</th>
        </thead>

        <tbody>
        <?php foreach ($rows->result() as $value): ?>
        <tr>
            <td><?php echo $value->filename ?></td>
            <td></td>
            <td><?php echo anchor('/backend/queue/execute/' . $value->id, 'Proses') ?></td>
        </tr>
            <?php endforeach;?>
        </tbody>
    </table>

</div>

<div id="nav-box">
    <div class="clearfix"></div>
</div>
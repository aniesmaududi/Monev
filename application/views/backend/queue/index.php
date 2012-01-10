<h1><?php echo $title;?></h1>
<div id="search-box" style="min-height:400px;">


    <?php
    if ($this->session->flashdata('message')):
        echo flash_message($this->session->flashdata('message_type'));
    endif;
    ?>
    <table class="backend-table">

        <thead>
        <th>K/L</th>
        <th>Eselon</th>
        <th>Satker</th>
        <th>Status</th>
        <th>Aksi</th>        
        </thead>

        <tbody>
        <?php foreach ($rows->result() as $value): ?>
        <tr style="font-size:10px;">
            <td><?php echo $value->kddept.' -- '.$value->nmdept ?></td>
            <td><?php echo $value->kdunit.' -- '.$value->nmunit ?></td>
            <td><?php echo $value->kdsatker.' -- '.$value->nmsatker ?></td>            
            <td><?php if($value->is_done == 1){ echo "sukses"; } else { echo "belum diproses"; } ?></td>
            <td><?php if($value->is_done != 1){ echo anchor('/backend/queue/execute/' . $value->id, 'Proses'); } else { echo "-";}?></td>
        </tr>
            <?php endforeach;?>
        </tbody>
    </table>

</div>

<div id="nav-box">
    <div class="clearfix"></div>
</div>
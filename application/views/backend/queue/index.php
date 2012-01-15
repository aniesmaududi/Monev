<script src="<?php echo ASSETS_DIR_JS.'/flash/jquery.min.js'?>"></script>
<script type="text/javascript" >
//function ReplaceContentInContainer(id,content) {
	//			window.location="backend/queue/proses";
//var container = document.getElementById(id);
//container.innerHTML = content;
//}

//$(document).ready(function()
function OnClickButton(id)
	{
//	$('#table1 td input.proses').click(function(){
		window.location="backend/queue/proses/" + id;
		document.getElementById("flash"+id).style.backgroundColor="#0f0";
		setTimeout(function()
		{
		$(".flash").fadeOut("slow", function () 
			{
//ReplaceContentInContainer('rep','');
				$(".flash").remove();
			}); 
		}, 1000);
	//	});
	}

</script>
  <style type="text/css">
.flash{
	width:759px;
padding-top:8px;
padding-bottom:8px;
background-color: #fff;
font-size:10px;-moz-border-radius: 6px;-webkit-border-radius: 6px;
}
</style>



<h1><?php echo $title;?></h1>
<div id="search-box" style="min-height:400px;">

    <?php
    if ($this->session->flashdata('message')):
        echo flash_message($this->session->flashdata('message_type'));
    endif;
 
if($_POST['nama'])
{
$name=$_POST['nama'];
$change="<div class='flash'>$nama</div>";
}

   ?>
    <table id="table1" class="backend-table">

        <thead>
        <th>K/L</th>
        <th>Eselon</th>
        <th>Satker</th>
        <th>Status</th>
        <th>Aksi</th>        
        </thead>

        <tbody>
        <?php
		foreach ($rows->result() as $value): ?>
		<tr style="font-size:10px;" class="flash" id="flash<?=$value->id?>">
            <td>			<?php //echo $change; ?><?php echo $value->kddept.' -- '.$value->nmdept ?></td>
            <td><?php echo $value->kdunit.' -- '.$value->nmunit ?></td>
            <td><?php echo $value->kdsatker.' -- '.$value->nmsatker ?></td>            
            <td><?php if($value->is_done == 1){ echo "sukses"; } else { echo "belum diproses"; } ?></td>
			<?php $nama=$value->kddept.' -- '.$value->nmdept.' -- '.$value->kdunit.' -- '.$value->nmunit.' -- '.$value->kdsatker.' -- '.$value->nmsatker;?>
            <td><?php if($value->is_done != 1){  ?><input type="hidden" value="<?php echo $nama ?>" name="nama"><input class="proses" type="button" value="Proses" onclick="OnClickButton(<? echo $value->id; ?>)"><?php } else { echo "-";}?></td>
            <!--<td><?php// if($value->is_done != 1){ echo anchor('/backend/queue/proses/' . $value->id, 'Proses','class=.flash'); } else { echo "-";}?></td>-->
        </tr>
            <?php endforeach;?>
        </tbody>
    </table>

</div>

<div id="nav-box">
    <div class="clearfix"></div>
</div>

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
	?>
	<table id="table1" class="backend-table">

		<thead>
		<th>K/L</th>
		<th>Eselon</th>
		<th>Satker</th>
		<th>Status</th>
		</thead>

		<tbody>
		<?php
			$temp = 0;
			foreach ($rows->result() as $value): ?>
			<tr style="font-size:10px;" class="flash" id="flash<?=$value->id?>">
				<td><?php echo $value->kddept.' -- '.$value->nmdept ?></td>
				<td><?php echo $value->kdunit.' -- '.$value->nmunit ?></td>
				<td><?php echo $value->kdsatker.' -- '.$value->nmsatker ?></td>
				<td><?php if($value->is_done == 1){ echo "sukses"; } else { echo "belum diproses"; } ?></td>
				<?php $nama=$value->kddept.' -- '.$value->nmdept.' -- '.$value->kdunit.' -- '.$value->nmunit.' -- '.$value->kdsatker.' -- '.$value->nmsatker;?>
				<?php if($temp==0)
				$temp=$value->id; ?>

			</tr>
			<?php endforeach;?>
		</tbody>
	</table>

</div>

<div id="nav-box">
	<div class="clearfix"></div>
</div>



<script type="text/javascript" >
function reloadpage()
{
	document.getElementById("flash"+<?php echo $temp?>).style.backgroundColor="#0f0";
	setTimeout(function()
	{
		$(".flash").fadeOut("slow", function ()
		{
			$(".flash").remove();
		});
	}, 5000);
}
window.onload = setupRefresh;
function setupRefresh(){
	setTimeout("refreshPage();",10000);
}
function refreshPage(){
	reloadpage();
	window.location="backend/queue/proses/" + <?php echo $temp?>;
} 
</script>
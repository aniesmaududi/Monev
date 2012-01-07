<script src="<?php echo ASSETS_DIR_JS.'jquery-1.7.1.min.js'?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.kdkementerian').change(function(){
			$.post('backend/add_akses_satker/get_eselon1',{'kdkementerian':$('.kdkementerian').val()},function(data){
				$('#dropdown_unit').html(data);
			});
			return false;
		})
	});
	
	$(document).ready(function(){
		$('.kdunit').live('change', (function(){
			$.post('backend/add_akses_satker/get_satker',{'kdunit':$('.kdunit').val(),'kdkementerian':$('.kdkementerian').val()},function(data){
				$('#dropdown_satker').html(data);
				
			});
			return false;
		}))
	});
</script>				

<h1><?php echo $title; ?></h1>
<div id="search-box" style="min-height:400px;">
	<form action="backend/add_akses_satker/simpan" class="backend-form" method="post">
		
		<?php
			if($this->session->flashdata('message')):
				echo flash_message($this->session->flashdata('message_type'));
			endif;
		?>

		<h4><span>Data Akses</span></h4>
		<div class="clearfix">
			<label for="kddja">User DJA</label>
			<?php
				$attr2 = 'id="kddja"';
				echo form_dropdown('kddja',$dja_value,set_value('kddja'),$attr2);
			?>
		</div>
		<div class="clearfix">
			<label for="kdbapenas">User Bappenas</label>
			<?php
				$attr3 = 'id="kdbapenas"';
				echo form_dropdown('kdbapenas',$bapenas_value,set_value('kdbapenas'),$attr3);
			?>
		</div>	
	
		<h4><span>Data Satker</span></h4>
		<?php echo validation_errors('<div class="error">', '</div>'); ?>
		<div class="clearfix">
			<label for="kdkementerian">K/L</label>
			<?php
				$attr = 'id="kdkementerian" class="kdkementerian"';
				echo form_dropdown('kdkementerian',$kementerian_value,'',$attr);
			?>
		</div>
		<div class="clearfix">
			<label for="kdunit">Unit/Eselon 1</label>
			<span class="dropdown_unit" id="dropdown_unit">
			<?php
				$attr = 'id="kdunit" class="kdunit"';
				echo form_dropdown('kdunit',$unit_value,set_value('kdunit'),$attr);
			?>
			</span>
		</div>
		<div class="clearfix">
			<label for="kdsatker">Satuan Kerja</label>
			<span class="dropdown_satker" id="dropdown_satker">
			<?php
				$attr = 'id="kdsatker"';
				echo form_dropdown('kdsatker',$satker_value,set_value('kdsatker'),$attr);
			?>
			</span>
		</div>
		
		<div class="clearfix">
			<label>&nbsp;</label>
			<input type="submit" value="Simpan" class="btn primary"> atau <?php echo anchor('backend','Kembali')?>
		</div>
	<?php echo form_close();?>
</div>
<div id="nav-box"></div>
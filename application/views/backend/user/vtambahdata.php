<script type="text/javascript" src="<?php echo ASSETS_DIR_JS.'jquery.min.js'?>"> </script>
<script type="text/javascript">
$(document).ready(function(){ 	
	document.getElementById('jabid').selectedIndex=0;

	if($('#jabid').val()<=3)
	$("#jabid").chosen().change(function() {
		$.get('<?php echo site_url('backend/user/get_dept') ?>/' + $('#jabid').val() , function(data){
			console.log(data);
			
			$('#kddept').html(data).trigger("liszt:updated");
			if($('#jabid').val()<=2)
			$("#kddept").chosen().change(function() {
				$.get('<?php echo site_url('backend/user/get_unit') ?>/' + $('#jabid').val() + '/' + $('#kddept').val() , function(data){
				console.log(data);
				$('#kdunit').html(data).trigger("liszt:updated");
			
				if($('#jabid').val()<=1)
				$("#kdunit").chosen().change(function() {
					$.get('<?php echo site_url('backend/user/get_satker') ?>/'+ $('#jabid').val() + '/' + $('#kddept').val() + '/' + $('#kdunit').val(), function(data){
					console.log(data);
					$('#kdsatker').html(data).trigger("liszt:updated");
						})		
					});
				$('.chosen-single').chosen();
				})
			});
			$('.chosen-single').chosen();
			
				
			if ($('#jabid').val() == 4) {
				$('#kdunit_chzn').hide();
				$('#kddept_chzn').hide();
				$('#kdsatker_chzn').hide();
				$('#kddept_row').hide();
				$('#kdunit_row').hide();
				$('#kdsatker_row').hide();
			}
			 if ($('#jabid').val() == 3) {
				$('#kdunit_chzn').hide();
				$('#kddept_chzn').show();
				$('#kdsatker_chzn').hide();
				$('#kddept_row').show();
				$('#kdunit_row').hide();
				$('#kdsatker_row').hide();
			}
			 if ($('#jabid').val() == 2) {
				$('#kdunit_chzn').show();
				$('#kddept_chzn').show();
				$('#kdsatker_chzn').hide();
				$('#kddept_row').show();
				$('#kdunit_row').show();
				$('#kdsatker_row').hide();
			}
			 if ($('#jabid').val() == 1) {
				$('#kdunit_chzn').show();
				$('#kddept_chzn').show();
				$('#kdsatker_chzn').show();
				$('#kddept_row').show();
				$('#kdunit_row').show();
				$('#kdsatker_row').show();
			}
			
		})
	});
	$('.chosen-single').chosen();
	$('#kdunit_chzn').hide();
	$('#kddept_chzn').hide();
	$('#kdsatker_chzn').hide();
	$('#kddept_row').hide();
	$('#kdunit_row').hide();
	$('#kdsatker_row').hide();
});	
</script>



			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
					<form action="backend/user/vtambahdata" class="backend-form" method="post" name="adddata">
						<h4><span>Tambah Data</span></h4>
						
							<table>
								<tr>
									<td>User Name</td>
									<td>:</td>
									<td>
										<?php echo form_input('userid', $userid );?>
										<?php echo form_error('userid','<div style="color:red;">','</div>');?>
									</td>
								</tr>
								<tr>
									<td>Nama</td>
									<td>:</td>
									<td>
										<?php echo form_input('nama', $nama );?>
										<?php echo form_error('nama','<div style="color:red;">','</div>');?>
									</td>
								</tr>
								<tr>
									<td>Jabatan</td>
									<td>:</td>
									<td>
									<select name="jabid" id="jabid" class="chosen-single" data-placeholder="-- Pilih Jabatan --">
										<option></option>
										<?php foreach(get_jabid() as $jab): ?>
										<option value="<?php echo $jab->id;?>" <?php echo '';?>><?php echo $jab->jabatan;?></option>
										<?php endforeach; ?>										
									</select>
									</td>
								</tr>
								<tr id='kddept_row'>
									<td>Nama Departemen</td>
									<td>:</td>
									<td>
										<select id='kddept' name='kddept' class='chosen-single' data-placeholder="-- Pilih Departemen --"> </select>
										</td>
								</tr>
								<tr id='kdunit_row'>
									<td>Nama Unit</td>
									<td>:</td>
									<td>
										<select id='kdunit' name='kdunit' class='chosen-single' data-placeholder="-- Pilih Eselon --"> </select>
									</td>
								</tr>
								<tr id='kdsatker_row'>
									<td>Nama Satker</td>
									<td>:</td>
									<td>
										<select id='kdsatker' name='kdsatker' class='chosen-single' data-placeholder="-- Pilih Satuan Kerja --"></select>
									</td>
								</tr>
							</table>	

							
						<br><br>
						<h4><span>Password</span></h4>
						<table>
							<tr>
								<td>Password</td>
								<td>:</td>
								<td>
									<?php echo form_password('passwd');?>
									<?php echo form_error('passwd','<div style="color:red">','</div>');?>
								</td>
							</tr>
							<tr>
								<td>Ulang Password</td>
								<td>:</td>
								<td>
									<?php echo form_password('passwd2');?>
									<?php echo form_error('passwd2','<div style="color:red">','</div>');?>	
								</td>
							</tr>
							<tr>
								<td>
									<label>&nbsp;</label>
									<input type="submit" value="Simpan" class="btn primary"> atau <?php echo anchor('backend/user','Kembali')?>
								</td>
							</tr>
						</table>
					</form>

			</div>
			<div id="nav-box">
			</div>

			
			
			
			
			
			
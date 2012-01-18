			<script type="text/javascript">
				var chart1;
				var chart2;
				$(document).ready(function() {
					chart1 = new Highcharts.Chart( {
						chart: {
							renderTo: 'chart-container-1',
							defaultSeriesType: 'line',
							marginRight: 0,
							marginBottom: 25
						},
						title: {
							text: 'Grafik Penyerapan Anggaran',
							x: -20 //center
						},
						subtitle: {
							text: 'Tahun Anggaran: '+<?php echo $thang?>,
							x: -20
						},
						xAxis: {
							categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
								'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
						},
						yAxis: {
							title: {
								text: ' '
							},
							plotLines: [ {
								value: 0,
								width: 1,
								color: '#808080'
							} ]
						},
						tooltip: {
							formatter: function() {
									return '<b>'+ this.series.name +'</b><br/>'+
									this.x +': Rp. '+ FormatNumber(this.y) +'';
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: 0,
							y: -5,
							borderWidth: 0
						},
						series: [ {
							name: 'Rencana Penarikan Anggaran',
							data: [
								<?php for($i=1;$i<=12;$i++):
								echo get_konsistensi_perbulan('2011',format_bulan($i),$kddept,$kdunit,$kdprogram);
								echo ($i<12) ? ',':'';
								endfor;?> 
								]
						}, {
							name: 'Realisasi Anggaran',
							data: [
								<?php for($i=1;$i<=12;$i++):
								echo get_konsistensi_perbulan('2011',format_bulan($i),$kddept,$kdunit,$kdprogram,'realisasi');
								echo ($i<12) ? ',':'';
								endfor;?> 
								]
						} ]
					} );
					
					chart2 = new Highcharts.Chart( {
						chart: {
							renderTo: 'chart-container-2',
							defaultSeriesType: 'column',
							marginRight: 0,
							marginBottom: 25
						},
						title: {
							text: 'Grafik Pencapaian Kinerja',
							x: -20 //center
						},
						subtitle: {
							text: 'Tahun Anggaran: '+<?php echo $thang?>,
							x: -20
						},
						xAxis: {
							categories: ['Penyerapan', 'Konsistensi', 'Keluaran', 'Nilai Efisiensi', 'Manfaat']
						},
						yAxis: {
							title: {
								text: ' '
							},
							plotLines: [ {
								value: 0,
								width: 1,
								color: '#808080'
							} ]
						},
						tooltip: {
							formatter: function() {
									return '<b>'+this.x +':</b> '+ FormatNumber(this.y) +' %';
							}
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'top',
							x: 0,
							y: -5,
							borderWidth: 0
						},
						series: [ 
						{
							name: 'Prosentase Pencapaian Kinerja',
							data: [ <?php echo $penyerapan->p;?>, <?php echo $konsistensi->k;?>, <?php echo $keluaran->pk;?>, <?php echo (50+(($efisiensi->e/20)*50));?>]
						} ]
					} );
				});
			</script>
			<h1><?php echo(isset($title))?$title:'Dashboard DJA';?></h1>
			<div id="search-box">
				
			</div>
			<div id="nav-box">
				<div class="box-content box-report">
					<div class="filter-option-box">
						<form name="form1" action="<?php echo site_url('dja');?>" method="POST">					
							<select name="kddept" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
								<option value="0" selected="selected">SEMUA KEMENTERIAN</option>
								<?php					
								foreach ($dept as $item):
									if($kddept == $item['kddept']){ $selected = 'selected';} else { $selected = "";}
								?>
									<option value="<?php echo $item['kddept'];?>" <?php echo $selected;?>>
									<?php echo $item['kddept'];?> &mdash; <?php echo $item['nmdept'];?>
									</option>				
								<?php endforeach; ?>
							</select>					
						</form>
						<?php if(isset($kddept) && $kddept != 0): ?>				
						<form name="form2" action="<?php echo site_url('dja');?>" method="POST">
							<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
							<select name="kdunit" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH ESELON" tabindex="2">
								<option value="0" selected="selected">SEMUA ESELON</option>
								<?php
								foreach ($unit as $item):
									if($kdunit == $item['kdunit']){ $selected = 'selected';} else { $selected = "";}
								?>
								<option value="<?php echo $item['kdunit'];?>" <?php echo $selected;?>>
								<?php echo $item['kdunit'];?> &mdash; <?php echo $item['nmunit'];?>
								</option>				
							<?php endforeach ?>
							</select>					
						</form>
						<?php endif;?>
						
						<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>				
						<form name="form3" action="<?php echo site_url('dja');?>" method="POST">
							<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
							<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
							<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
								<option value="0" selected="selected">SEMUA PROGRAM</option>
								<?php
								foreach ($program as $item):
									if($kdprogram == $item['kdprogram']){ $selected = 'selected';} else { $selected = "";}
								?>
								<option value="<?php echo $item['kdprogram'];?>" <?php echo $selected;?>>
								<?php echo $item['kdprogram'];?> &mdash; <?php echo $item['nmprogram'];?>
								</option>				
							<?php endforeach ?>
							</select>					
						</form>
						<?php endif; ?>
						<span class="form-tampilkan">
						<form name="form4" action="<?php echo site_url('dja');?>" method="POST">
							<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
							<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
							<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
							<input type="submit" name="submit-pk" value="Tampilkan" class="custom" />					
						</form>
						</span>
					</div>
					
					<div id="chart-container-1" class="chart-container"  style="width: 100%; height: 350px; margin: 0 auto 30px"></div>
					
					<div id="chart-container-2" class="chart-container"  style="width: 100%; height: 350px; margin: 0 auto"></div>
				</div>
			</div>
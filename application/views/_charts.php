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
							x: 20 //center
						},
						subtitle: {
							text: 'Tahun Anggaran: '+<?php echo $thang?>,
							x: 20
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
							y: 305,
							borderWidth: 0
						},
						series: [ {
							name: 'Rencana Penarikan Anggaran',
							data: [
								<?php for($i=1;$i<=12;$i++):
								echo get_konsistensi_perbulan($thang,format_bulan($i),$kddept,$kdunit,$kdprogram,$kdsatker);
								echo ($i<12) ? ',':'';
								endfor;?> 
								]
						}, {
							name: 'Realisasi Anggaran',
							data: [
								<?php for($i=1;$i<=12;$i++):
								echo get_konsistensi_perbulan($thang,format_bulan($i),$kddept,$kdunit,$kdprogram,$kdsatker,'realisasi');
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
							x: 20 //center
						},
						subtitle: {
							text: 'Tahun Anggaran: '+<?php echo $thang?>,
							x: 20
						},
						xAxis: {
							categories: ['Penyerapan', 'Konsistensi', 'Keluaran', 'Efisiensi']
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
							x: 0,
							y: 100,
							borderWidth: 0
						},
						series: [ 
						{
							name: 'Prosentase Pencapaian Kinerja',
							data: [ <?php echo ($penyerapan->p) ? $penyerapan->p: 0;?>, <?php echo ($konsistensi->k)? $konsistensi->k:0;?>, <?php echo ($keluaran->pk)?$keluaran->pk:0;?>, <?php echo ($efisiensi->e) ? (50+(($efisiensi->e/20)*50)) : 0;?>]
						} ]
					} );
				});
			</script>
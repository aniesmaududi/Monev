			<script type="text/javascript">
				var chart_konsistensi;
				$(document).ready(function() {
					chart_konsistensi = new Highcharts.Chart( {
						chart: {
							renderTo: 'chart-container-konsistensi',
							defaultSeriesType: 'line',
							marginRight: 0,
							marginBottom: 25
						},
						title: {
							text: 'Grafik Konsistensi Antara Perencanaan dan Implementasi',
							x: 20 //center
						},
						subtitle: {
							text: 'Tahun Anggaran: '+<?php echo $thang?>,
							x: 20
						},
						xAxis: {
							categories: [
								<?php
								$count_chart = count($konsistensi);
								$i=1;
								foreach($konsistensi as $categories):?>
									'<?php echo format_bulan($categories->bulan,'short_from0');?>'
									<?php echo ($i < $count_chart) ? ' ,':'';
									$i++;
								endforeach;
								?>]
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
								<?php
								$i=1;
								foreach($konsistensi as $chart_konsistensi):
									echo $chart_konsistensi->jmlrpd;
									echo ($i<$count_chart) ? ',':'';
									$i++;
								endforeach;
								?> 
								]
						}, {
							name: 'Realisasi Anggaran',
							data: [
								<?php
								$count_chart = count($konsistensi);
								$i=1;
								foreach($konsistensi as $chart_konsistensi):
									echo $chart_konsistensi->jmlrealisasi;
									echo ($i<$count_chart) ? ',':'';
									$i++;
								endforeach;
								?>  
								]
						} ]
					} );
					
				});
			</script>
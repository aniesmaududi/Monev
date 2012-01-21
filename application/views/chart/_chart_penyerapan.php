		<?php
			$penyerapan_anggaran = round($penyerapan->penyerapan,2);
		?>
		<script type="text/javascript">
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chart-container-penyerapan',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Grafik Penyerapan Anggaran'
					},
					subtitle: {
						text: 'Tahun Anggaran: '+<?php echo $thang?>,
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ (Math.round(this.percentage*100)/100) +' %';
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (Math.round(this.percentage*100)/100) +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Grafik Penyerapan Anggaran',
						data: [
							['Penyerapan Anggaran',   <?php echo round($penyerapan_anggaran,2)?>],
							{
								name: 'Tidak Tercapai',    
								y: <?php echo 100-($penyerapan_anggaran)?>,
								sliced: true,
								selected: true
							}
						]
					}]
				});
			});
		</script>
		<?php 
			$total_k_chart =0;
			$i_chart = 0;
			$PK = 0;
			foreach($output as $output_item_chart):
				$k_chart = round($output_item_chart->rvk/$output_item_chart->tvk*100,2);
				$total_k_chart += $k_chart; 
				$i_chart++;
			endforeach;
			$PK = round($total_k_chart/$i_chart,2);
		?>
		<script type="text/javascript">
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'chart-container-keluaran',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: 'Grafik Pencapaian Keluaran'
					},
					subtitle: {
						text: 'Tahun Anggaran: '+<?php echo $thang?>,
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
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
									return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Grafik Pencapaian Keluaran',
						data: [
							['Pencapaian Keluaran',   <?php echo $PK;?>],
							{
								name: 'Tidak Tercapai',    
								y: <?php echo 100-$PK;?>,
								sliced: true,
								selected: true
							}
						]
					}]
				});
			});
				
		</script>
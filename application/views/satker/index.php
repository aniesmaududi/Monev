            <h1><?php echo(isset($title))?$title:'Dashboard Satker';?></h1>
			<div id="search-box"></div>
			<div id="nav-box">
				<h2>Grafik Konsistensi Penyerapan Anggaran</h2>
				<div class="box-content">
				<table class="chart-line accessHide" style="display:none; height:300px;">
					<caption>Grafik Penyerapan Anggaran</caption>
					<thead>
						<tr>
							<td></td>
							<th scope="col">Jan</th>
							<th scope="col">Feb</th>
							<th scope="col">Mar</th>
							<th scope="col">Apr</th>
							<th scope="col">Mei</th>
							<th scope="col">Jun</th>
							<th scope="col">Jul</th>
							<th scope="col">Agu</th>
							<th scope="col">Sep</th>
							<th scope="col">Okt</th>
							<th scope="col">Nov</th>
							<th scope="col">Des</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Rencana Penarikan Anggaran(Juta)</th>
							<?php for($i=1;$i<=12;$i++):
								($i<10) ? $bulan='0'.$i : $bulan=$i;
								$rpd = get_konsistensi_perbulan('2011',$bulan,$kddept,$kdunit,$kdprogram);
							?>
							<td><?php echo ($rpd) ? substr($rpd->rpd, 0, -6) : '0';?></td>
							<?php endfor;?>
						</tr>
						<tr>
							<th scope="row">Realisasi Anggaran(Juta)</th>
							<?php for($i=1;$i<=12;$i++):
								($i<10) ? $bulan='0'.$i : $bulan=$i;
								$realisasi = get_konsistensi_perbulan('2011',$bulan,$kddept,$kdunit,$kdprogram);
							?>
							<td><?php echo ($realisasi) ? substr($realisasi->realisasi, 0, -6) : '0';?></td>
							<?php endfor;?>
						</tr>
					</tbody>
				</table><!-- end of chart-line table -->
				</div><!-- end of box-content -->
				<br>
				<h2>Grafik Indeks Kinerja</h2>
				<div class="box-content">
				<table class="chart-bar" style="display:none;height:200px;">
					<caption>Grafik Indikator Kerja</caption>
					<thead>
						<tr>
							<td></td>
							<th scope="col">Penyerapan</th>
							<th scope="col">Konsistensi</th>
							<th scope="col">Keluaran</th>
							<th scope="col">Efisiensi</th>
							<th scope="col">Manfaat</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Bobot Total</th>
							<td>9.7</td>
							<td>18.2</td>
							<td>43.5</td>
							<td>28.6</td>
							<td>0</td>
						</tr>
						<tr>
							<th scope="row">Pencapaian</th>
							<td><?php echo round($penyerapan->p/100*9.7,2);?></td>
							<td><?php echo round($konsistensi->k/100*18.2,2);?></td>
							<td><?php echo round($keluaran->pk/100*43.5,2);?></td>
							<td><?php echo round($efisiensi->e/100*28.6,2);?></td>
							<td>0</td>
						</tr>		
					</tbody>
				</table>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
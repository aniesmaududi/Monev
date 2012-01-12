			<h1><?php echo(isset($title))?$title:'Dashboard DJA';?></h1>
			<div id="search-box" style="min-height:400px;">
				<h3>Tingkat Penyerapan Anggaran</h3>
				<table class="chart-bar accessHide" >
					<caption>Tingkat Penyerapan Anggaran</caption>
					<thead>
						<tr>
							<td></td>
							<th scope="col">Jumlah (Juta)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Pagu Anggaran</th>
							<td><?php 
							$pembulatan_pagu = substr($penyerapan->pagu, -6);
							if($pembulatan_pagu>500000):
								$pagu = abs(substr($penyerapan->pagu, 0, -6) + 1);
							else:
								$pagu = abs(substr($penyerapan->pagu, 0, -6));
							endif;
							echo $pagu.' Juta'?></td>
						</tr>
						<tr>
							<th scope="row">Realisasi Anggaran</th>
							<td><?php 
							$pembulatan_realisasi = substr($penyerapan->realisasi, -6);
							if($pembulatan_realisasi>=500000):
								$realisasi = abs(substr($penyerapan->realisasi, 0, -6) + 1);
							else:
								$realisasi = abs(substr($penyerapan->realisasi, 0, -6));
							endif;
							echo $realisasi.' Juta'?></td>
						</tr>
						
					</tbody>
				</table>
				<h3>Aspek Konsistensi Anggaran</h3>
				<table class="chart-bar accessHide" >
					<caption>Aspek Konsistensi Anggaran</caption>
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
							<th scope="row">Rencana Penarikan Dana</th>
							<?php foreach($konsistensi_all as $konsistensi):?>
							<td><?php 
							$pembulatan_rpd = substr($konsistensi->rpd, -6);
							if($pembulatan_rpd>500000):
								$rpd = abs(substr($konsistensi->rpd, 0, -6) + 1);
							else:
								$rpd = abs(substr($konsistensi->rpd, 0, -6));
							endif;
							echo $rpd.' Juta'?></td>
							<?php endforeach;?>
						</tr>
						<tr>
							<th scope="row">Realisasi Penarikan Dana</th>
							<?php foreach($konsistensi_all as $konsistensi):?>
							<td><?php 
							$pembulatan_realisasi = substr($konsistensi->realisasi, -6);
							if($pembulatan_realisasi>=500000):
								$realisasi = abs(substr($konsistensi->realisasi, 0, -6) + 1);
							else:
								$realisasi = abs(substr($konsistensi->realisasi, 0, -6));
							endif;
							echo $realisasi.' Juta'?></td>
							<?php endforeach;?>
						</tr>
						<tr>
							<th scope="row">Aspek Konsistensi Realisasi Penarikan Dana</th>
							<?php foreach($konsistensi_all as $konsistensi):?>
							<td><?php 
							$pembulatan_realisasi = substr($konsistensi->realisasi, -6);
							if($pembulatan_realisasi>=500000):
								$realisasi = abs(substr($konsistensi->realisasi, 0, -6) + 1);
							else:
								$realisasi = abs(substr($konsistensi->realisasi, 0, -6));
							endif;
							echo $realisasi.' Juta'?></td>
							<?php endforeach;?>
						</tr>
					</tbody>
				</table>
				
				<?php echo "<pre>";
				print_r(get_konsistensi());?>;
			</div>
			<div id="nav-box">
				
				
				
			</div>
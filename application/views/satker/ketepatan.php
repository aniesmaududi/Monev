<h1>Pengukuran Ketepatan Waktu Pelaksanaan Kegiatan</h1>
			<div id="search-box">
			</div>
			<div id="nav-box">
				<input type="button" class="blackbg" value="pdf" style="margin-top:-2px; width:70px;"/>
				<input type="button" class="blackbg" value="excel" style="margin-top:-2px; width:70px;"/>
				<div class="clearfix"></div>
				<div class="box-content box-report">
					<table>
						<tr>
							<td width="180px">Kementrian Negara / Lembaga</td>
							<td>:</td>
							<td colspan="4"><?php echo $nmdept;?></td>
						</tr>
						<tr>
							<td>Unit / Eselon I</td>
							<td>:</td>
							<td colspan="4"><?php echo $nmunit;?></td>
						</tr>
						<tr>
							<td>Nama Program</td>
							<td>:</td>
							<td colspan="4"><?php echo (isset($nmprogram))? $nmprogram: 'Tidak Ada Kegiatan';?></td>
						</tr>
						<tr>
							<td>Tahun Anggaran</td>
							<td>:</td>
							<td width="200px">
								<select data-placeholder="Pilih Tahun Anggaran" class="chzn-select" style="width:100%;" tabindex="2">
						          <option value=""></option> 
						          <option value="2011">2011</option> 
						          <option value="2010">2010</option>
						          <option value="2010">2009</option>
						        </select>
							</td>
							<td>Bulan</td>
							<td>:</td>
							<td>
								<select data-placeholder="Pilih Bulan" class="chzn-select" style="width:100%;" tabindex="2">
						          <option value=""></option> 
						          <option value="Januari">Januari</option> 
						          <option value="Februari">Februari</option>
						          <option value="Maret">Maret</option>
						          <option value="April">April</option> 
						          <option value="Mei">Mei</option>
						          <option value="Juni">Juni</option>
						        </select>
							</td>
						</tr>
						<tr>
							<td>Nama Kegiatan</td>
							<td>:</td>
							<td colspan="4">
								<select data-placeholder="Pilih Kegiatan" class="chzn-select" style="width:100%;" tabindex="2">
						          <option value=""></option> 
						          <option value="Pengembangan SDM Melalui Penyelenggaran Diklat Teknis dan Fungsional di Bidang Kekayaan Negara">Pengembangan SDM Melalui Penyelenggaran Diklat Teknis dan Fungsional di Bidang Kekayaan Negara</option> 
						          <option value="Pengembangan SDM Melalui Penyelenggaran Diklat Teknis dan Fungsional di Bidang Kekayaan Negara">Pengembangan SDM Melalui Penyelenggaran Diklat Teknis dan Fungsional di Bidang Kekayaan Negara</option> 
						        </select>
							</td>
						</tr>
					</table>
					<br/>
					<table id="report">
						<tr class="align-middle">
							<td width="150"><strong>Bulan</strong></td>
							<td><strong>RPD Kumulatif</strong></td>
							<td><strong>Realisasi Anggaran</strong></td>
							<td width="150"><strong>Tingkat Penyerapan per Bulan</strong></td>
						</tr>
						<tr class="align-middle">
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Januari</td>
							<td>Rp 800.000,00</td>
							<td>-</td>
							<td class="align-middle">0%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Februari</td>
							<td>Rp 1.600.000,00</td>
							<td>Rp 100.000,00</td>
							<td class="align-middle">6%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Maret</td>
							<td>Rp 2.400.000,00</td>
							<td>Rp 300.000,00</td>
							<td class="align-middle">13%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">April</td>
							<td>Rp 3.200.000,00</td>
							<td>Rp 500.000,00</td>
							<td class="align-middle">16%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Mei</td>
							<td>Rp 4.000.000,00</td>
							<td>Rp 1.250.000,00</td>
							<td class="align-middle">31%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Juni</td>
							<td>Rp 4.800.000,00</td>
							<td>Rp 1.800.000,00</td>
							<td class="align-middle">38%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Juli</td>
							<td>Rp 5.600.000,00</td>
							<td>Rp 2.100.000,00</td>
							<td class="align-middle">38%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Agustus</td>
							<td>Rp 6.400.000,00</td>
							<td>Rp 4.000.000,00</td>
							<td class="align-middle">63%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">September</td>
							<td>Rp 7.300.000,00</td>
							<td>Rp 5.000.000,00</td>
							<td class="align-middle">68%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Oktober</td>
							<td>Rp 8.200.000,00</td>
							<td>Rp 7.000.000,00</td>
							<td class="align-middle">85%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">November</td>
							<td>Rp 9.100.000,00</td>
							<td>Rp 8.000.000,00</td>
							<td class="align-middle">88%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Desember</td>
							<td>Rp 10.000.000,00</td>
							<td>Rp 9.250.000,00</td>
							<td class="align-middle">95%</td>
						</tr>
						<tr>
							<td colspan="3">Tingkat Ketepatan Waktu</td>
							<td class="align-middle yellow">45%</td>
						</tr>
					</table>
					<br/>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
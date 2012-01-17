<h1>Pengukuran Pencapaian Hasil</h1>
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
							<td width="400"><strong>IKU</strong></td>
							<td width="80"><strong>Target</strong></td>
							<td width="80"><strong>Realisasi</strong></td>
							<td><strong>Tingkat Capaian IKU</strong></td>
						</tr>
						<tr class="align-middle">
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Prosentase Program Diklat yang Berkontribusi Terhadap Peningkatan Kompetensi</td>
							<td>100%</td>
							<td>90%</td>
							<td class="yellow">95%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Prosentase Jam Pelatihan terhadap Jam Kerja Pegawai Kementrian Keuangan</td>
							<td>100%</td>
							<td>90%</td>
							<td class="yellow">95%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Prosentase Lulusan Diklat Kementrian Keuangan dengan Predikat Minimal Baik</td>
							<td>100%</td>
							<td>90%</td>
							<td class="yellow">95%</td>
						</tr>
					</table>
					<br/>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
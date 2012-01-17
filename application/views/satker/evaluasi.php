<h1>Penilaian Evaluasi Kinerja</h1>
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
							<td><strong>Aspek</strong></td>
							<td width="120"><strong>Nilai</strong></td>
							<td width="120"><strong>Bobot</strong></td>
							<td width="120"><strong>NIlai Aspek Terbobot</strong></td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Penyerapan Anggaran</td>
							<td>95.00%</td>
							<td>4.95%</td>
							<td>4.70%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Ketepatan Waktu Pelaksanaan Kegiatan</td>
							<td>44.99%</td>
							<td>4.95%</td>
							<td>2.23%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Tingkat Pencapaian Keluaran</td>
							<td>90.00%</td>
							<td>36.20%</td>
							<td>32.58%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Tingkat Efisiensi</td>
							<td>40%</td>
							<td>19.90%</td>
							<td>7.96%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Pencapaian Hasil</td>
							<td>90.00%</td>
							<td>16.10%</td>
							<td>14.49%</td>
						</tr>
						<tr class="align-right">
							<td class="align-middle" colspan="3">Nilai Evaluasi Eselon I</td>
							<td class="yellow">79.86%</td>
						</tr>
					</table>
					<br/>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
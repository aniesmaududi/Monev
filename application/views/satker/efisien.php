<h1>Pengukuran Tingkat Efisiensi</h1>
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
							<td width="150" rowspan="2"><strong>Keluaran</strong></td>
							<td colspan="2"><strong>Volume</strong></td>
							<td colspan="2"><strong>Kualitas</strong></td>
							<td colspan="2"><strong>Anggaran</strong></td>
							<td rowspan="2"><strong>Tingkat Pencapaian Keluaran</strong></td>
						</tr>
						<tr class="align-middle">
							<td width="50">Target</td>
							<td width="50">Realisasi</td>
							<td width="50">Target</td>
							<td width="50">Realisasi</td>
							<td width="110">Pagu</td>
							<td width="110">Realisasi</td>
						</tr>
						<tr class="align-middle">
							<td>1</td>
							<td>2</td>
							<td>3</td>
							<td>4</td>
							<td>5</td>
							<td>6</td>
							<td>7</td>
							<td>8</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Keluaran 1 (Orang)</td>
							<td>50</td>
							<td>40</td>
							<td>100%</td>
							<td>100%</td>
							<td>4.000.000.000</td>
							<td>3.800.000.000</td>
							<td>-17,28%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Keluaran 2 (Laporan)</td>
							<td>3</td>
							<td>3</td>
							<td>100%</td>
							<td>95%</td>
							<td>1.000.000.000</td>
							<td>975.000.000</td>
							<td>2,50%</td>
						</tr>
						<tr class="align-right">
							<td class="align-left">Keluaran 3 (Sistem)</td>
							<td>1</td>
							<td>1</td>
							<td>100%</td>
							<td>95%</td>
							<td>5.000.000.000</td>
							<td>4.725.000.000</td>
							<td>3.57%</td>
						</tr>
						<tr>
							<td colspan="7" class="align-middle">Efisiensi</td>
							<td class="align-right">90%</td>
						</tr>
						<tr>
							<td colspan="7">Tingkat Efisiensi</td>
							<td class="align-right yellow">90%</td>
						</tr>
					</table>
					<br/>
				</div><!-- end of box-content -->
			</div><!-- end of nav-box -->
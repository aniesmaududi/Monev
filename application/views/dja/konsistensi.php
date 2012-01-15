			<h1><?php echo $title;?></h1>			        
			<div id="search-box">				
				<div class="filter-option-box">
					<form name="form1" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">					
						<select name="kddept" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
							<option value="0" selected="selected">SEMUA KEMENTERIAN</option>
							<?php					
							foreach ($dept as $item):
								if($kddept == $item['kddept']){ $selected = 'selected';} else { $selected = "";}
							?>
								<option value="<?php echo $item['kddept'];?>" <?php echo $selected;?>>
								<?php echo $item['kddept'];?> &mdash; <?php echo $item['nmdept'];?>
								</option>				
							<?php endforeach; ?>
						</select>					
					</form>
					<?php if(isset($kddept) && $kddept != 0): ?>				
					<form name="form2" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
						<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
						<select name="kdunit" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH ESELON" tabindex="2">
							<option value="0" selected="selected">SEMUA ESELON</option>
							<?php
							foreach ($unit as $item):
								if($kdunit == $item['kdunit']){ $selected = 'selected';} else { $selected = "";}
							?>
							<option value="<?php echo $item['kdunit'];?>" <?php echo $selected;?>>
							<?php echo $item['kdunit'];?> &mdash; <?php echo $item['nmunit'];?>
							</option>				
						<?php endforeach ?>
						</select>					
					</form>
					<?php endif;?>
					
					<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>				
					<form name="form3" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
						<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
						<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
						<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
							<option value="0" selected="selected">SEMUA PROGRAM</option>
							<?php
							foreach ($program as $item):
								if($kdprogram == $item['kdprogram']){ $selected = 'selected';} else { $selected = "";}
							?>
							<option value="<?php echo $item['kdprogram'];?>" <?php echo $selected;?>>
							<?php echo $item['kdprogram'];?> &mdash; <?php echo $item['nmprogram'];?>
							</option>				
						<?php endforeach ?>
						</select>					
					</form>
					<?php endif; ?>
					<span class="form-tampilkan">
					<form name="form4" action="<?php echo site_url('dja/konsistensi_table');?>" method="POST">
						<?php if(isset($kddept)) { ?><input type="hidden" name="kddept" value="<?php echo $kddept;?>"/><?php } ?>
						<?php if(isset($kdunit)) { ?><input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/><?php } ?>
						<?php if(isset($kdprogram)) { ?><input type="hidden" name="kdprogram" value="<?php echo $kdprogram;?>"/><?php } ?>
						<input type="submit" name="submit-k" value="Tampilkan" class="custom" />					
					</form>
					</span>
				</div>
				
			</div>
			<div id="nav-box">
				<div class="box-content">
				<?php if(isset($submitK)) { ?>			
				<table id="report">
					<thead>
						<th width="80">Bulan</th>
						<th>RPD</th>
						<th>RPD Kumulatif</th>
						<th>Realisasi</th>
						<th>Tk. Penyerapan</th>						
					</thead>
					<tbody>
						<?php
						$rpdk = $jml1;
						$jml = "jml";					
						$ra[-1] = 0;
						for($i=0;$i<12;$i++):
							$j = $i+1;
							switch($j){
								case 1 : $m = "Januari"; break;
								case 2 : $m = "Februari"; break;
								case 3 : $m = "Maret"; break;
								case 4 : $m = "April"; break;
								case 5 : $m = "Mei"; break;
								case 6 : $m = "Juni"; break;
								case 7 : $m = "Juli"; break;
								case 8 : $m = "Agustus"; break;
								case 9 : $m = "September"; break;
								case 10 : $m = "Oktober"; break;
								case 11 : $m = "November"; break;
								case 12 : $m = "Desember"; break;
							}
													
							$rpd = $jml.$j;						
						?>
						<tr>
							<td><?php echo $m;?></td>
							<td align="right">Rp. <?php echo $this->mdja->formatMoney($$rpd);?></td>
							<td align="right">Rp. <?php echo $this->mdja->formatMoney($rpdk);?></td>
							<td align="right">
								<?php
								if(isset($realisasi)){
									$ra[$i] = $realisasi[$i]['jumlah'];
									echo 'Rp. '.$this->mdja->formatMoney($ra[$i]);
								}
								else
								{
									echo 0;	
								}
								?></td>
							<td align="center">
								<?php								
								$k[$i] = round(($ra[$i-1] + $ra[$i])/($rpdk)*100,2);
								//echo "ra - 1  = ".$ra[$i-1]."<br>";
								//echo "ra = ".$ra[$i]."<br>";
								//echo "rpdk = ".$rpdk."<br>";								
								echo $k[$i]."%";
								?>
							</td>
						</tr>
						<?php
						$rpdk += $$rpd;
						endfor;
						?>
					</tbody>
				</table>
				<?php
				//Chart Konsistensi
				$thang = "2011";
				$this->load->helper(array('url','fusioncharts'));
					
				// --------- Line Chart --------- //
				$graph_swfFile	= base_url().'public/charts/Line.swf' ;
				$graph_caption	= 'Konsistensi Tahun Anggaran '.$thang;
				$graph_caption	= '';
				$graph_numberPrefix	= '';
				$graph_numberSuffix	= '%';
				$graph_title	= 'Konsistensi' ;
				$graph_width	= 450 ;
				$graph_height	= 250 ;                                
				
				// Store Name of months
				$arrData_K[0][1] = "Jan";
				$arrData_K[1][1] = "Feb";
				$arrData_K[2][1] = "Mar";
				$arrData_K[3][1] = "Apr";
				$arrData_K[4][1] = "Mei";
				$arrData_K[5][1] = "Jun";
				$arrData_K[6][1] = "Jul";
				$arrData_K[7][1] = "Agu";
				$arrData_K[8][1] = "Sep";
				$arrData_K[9][1] = "Okt";
				$arrData_K[10][1] = "Nov";
				$arrData_K[11][1] = "Des";
			 
				//Store K data
				$arrData_K[0][2] = $k[0];
				$arrData_K[1][2] = $k[1];
				$arrData_K[2][2] = $k[2];
				$arrData_K[3][2] = $k[3];
				$arrData_K[4][2] = $k[4];
				$arrData_K[5][2] = $k[5];
				$arrData_K[6][2] = $k[6];
				$arrData_K[7][2] = $k[7];
				$arrData_K[8][2] = $k[8];
				$arrData_K[9][2] = $k[9];
				$arrData_K[10][2] = $k[10];
				$arrData_K[11][2] = $k[11];
			
				$strXML_K = "<graph caption='".$graph_caption."' numberSuffix='".$graph_numberSuffix."' formatNumberScale='0' decimalPrecision='0'>";
			
				foreach ($arrData_K as $arSubData) {
					$strXML_K .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] . "' color='".getFCColor()."' />";
				}
				$strXML_K .= "</graph>";
					
				$graph_K  = renderChart($graph_swfFile, $graph_title, $strXML_K, "K" , $graph_width, $graph_height);
				echo $graph_K;
				} ?>
				</div>
			</div>
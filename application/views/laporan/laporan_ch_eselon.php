			
			<div id="search-box">
				<h1>Laporan Capaian Hasil</h1>
				
				<table>
					
				<?php 
				$attributes = array('class' => 'backend-form');
				echo form_open(base_url()."eselon/capaian_hasil", $attributes);	
				?>
				<!-- DEPARTEMENT SELECTOR -->
				<tr><td>
				<label>DEPARTEMENT</label></td><td>
				<select name="dept">
					<option value="">-- Select Departement --</option>
				<?php
				foreach($deptList as $dIdx => $dVal){
					if($dVal['kddept'] == $kdDept){
						$selected = "selected";
					} else {
						$selected = "";
					}
				?>
					<option value="<?php echo $dVal['kddept'];?>" <?php echo $selected;?>><?php echo $dVal['nmdept'];?></option>
				<?php
				}
				?>lect>
				</td></tr>
				<!-- UNIT SELECTOR -->
				<tr><td>
				<label>UNIT</label></td><td>
				<select name="unit">
					<option value="">-- Select Unit --</option>
				<?php
				foreach($unitList as $uIdx => $uVal){
					if($uVal['kdunit'] == $kdUnit){
						$selected = "selected";
					} else {
						$selected = "";
					}
				?>
					<option value="<?php echo $uVal['kdunit'];?>" <?php echo $selected;?>><?php echo $uVal['nmunit'];?></option>
				<?php
				}
				?>
				</select>
				</td></tr>
				<!-- PROGRAM SELECTOR -->
				<tr><td>
				<label>PROGRAM</label></td><td>
				<select name="kdprogram">
					<option value="">-- Select Program --</option>
				<?php
				foreach($program as $dataProgram){
					if($dataProgram == @$kdprogram){
						$selected = "selected";
					} else {
						$selected = "";
					}
				?>
					<option value="<?php echo "$dataProgram";?>" <?php echo $selected;?>><?php echo "$dataProgram";?></option>
				<?
				}
				?>
				</select>
				</select>
				</td></tr>
				<!-- YEAR SELECTOR -->
				<tr><td>
				</td></tr>
				<tr><td>
				<label>YEAR</label></td><td>
				<select name="thang">
					<option value="">-- Select Thang --</option>
				<?php
				foreach($thang as $dataThang){
					if($dataThang == $dataThang){
						$selected = "selected";
					} else {
						$selected = "";
					}
				?>
					<option value="<?php echo "$dataThang";?>" <?php echo "$selected";?>><?php echo "$dataThang";?></option>
				<?
				}
				?>
				</select>
				</td></tr>
				<tr><td colspan="3">
					<input type="submit" name="show" value="SHOW">
				</td></tr>
				<?php echo form_close(); ?>
				
				</table>
			</div>
			<div id="nav-box">				
				<div id="box-title">					
				</div>
				<div class="box-content">
					<?php echo $graph_L; ?>
					<?php echo $graph_PKL; ?>
					<?php echo $graph_PES ; ?>
					<?php echo $graph_PPRO ; ?>
				</div><!-- end of box-content -->				
			</div>
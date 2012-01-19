			<?php $this->view('_charts');?>
			<h1><?php echo(isset($title))?$title:'Dashboard Kementerian';?></h1>
			<div id="search-box">
				
			</div>
			<div id="nav-box">
				<span class="custom-button-span"></span>
				<div class="box-content box-report">
					<div class="filter-option-box">
						<form name="form1" action="" method="POST">					
							<select name="kddept" onchange="this.form.submit();" disabled=disabled class="chzn-select" data-placeholder="PILIH KEMENTERIAN" tabindex="1">
								<option value="<?php echo $kddept?>"><?php echo get_detail_data('t_dept',array('kddept'=>$kddept),'nmdept');?></option>
							</select>					
						</form>
						
						<?php if(isset($kddept) && $kddept != 0): ?>				
						<form name="form2" action="" method="POST">
							<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
							<select name="kdunit" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH ESELON" tabindex="2">
								<option value="0" selected="selected">SEMUA ESELON</option>
								<?php
								foreach ($unit as $item):
									if($kdunit == $item->kdunit){ $selected = 'selected';} else { $selected = "";}
								?>
								<option value="<?php echo $item->kdunit;?>" <?php echo $selected;?>>
								<?php echo $item->kdunit;?> &mdash; <?php echo $item->nmunit;?>
								</option>				
							<?php endforeach ?>
							</select>					
						</form>
						<?php endif;?>
						
						<?php if((isset($kddept) && $kddept != 0) && (isset($kdunit) && $kdunit != 0)): ?>				
						<form name="form3" action="" method="POST">
							<input type="hidden" name="kddept" value="<?php echo $kddept;?>"/>
							<input type="hidden" name="kdunit" value="<?php echo $kdunit;?>"/>
							<select name="kdprogram" onchange="this.form.submit();" class="chzn-select" data-placeholder="PILIH PROGRAM" tabindex="3">
								<option value="0" selected="selected">SEMUA PROGRAM</option>
								<?php
								foreach ($program as $item):
									if($kdprogram == $item->kdprogram){ $selected = 'selected';} else { $selected = "";}
								?>
								<option value="<?php echo $item->kdprogram;?>" <?php echo $selected;?>>
								<?php echo $item->kdprogram;?> &mdash; <?php echo $item->nmprogram;?>
								</option>				
							<?php endforeach ?>
							</select>					
						</form>
						<?php endif; ?>
					</div>
					<div class="clearfix">
					<div id="chart-container-1" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0;left:-20px;position:relative"></div>
					
					<div id="chart-container-2" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0"></div>
					</div>
				</div>
			</div>
			<?php $this->view('_charts');?>
			<h1><?php echo(isset($title))?$title:'Catatan K/L';?></h1>
			<div id="search-box">
				<p><?php echo(isset($subtitle))?$subtitle:'Catatan K/L';?>
				Lihat <a href="kementrian/history_catatan"> Rekaman Catatan</a></p>
			</div>
			<div id="nav-box">
				<!--
				<span class="custom-button-span"></span>				
				<div class="box-content box-report">
					<div class="filter-option-box">
						
					</div>
					<div class="clearfix">
					<div id="chart-container-1" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0;left:-20px;position:relative"></div>
					
					<div id="chart-container-2" class="chart-container"  style="width: 50%; float:left; height: 300px; margin: 0"></div>
					</div>
				</div>
				-->
				<div class="box-content box-end">
					<?php echo form_open('kementrian/do_catatan');?>
					<input type="submit" name="submit" value="Simpan" class="blackbg"/>
					<?php if($this->session->flashdata('message')):?>
					<div class="alert-message <?php echo $this->session->flashdata('message_type')?> no-margin-bottom" data-alert="alert">
							<a class="close" href="#">&times;</a>
							<p><?php echo $this->session->flashdata('message')?></p>
					</div>
					<?php endif;?>
					<textarea id="comment" name="comment"></textarea>
					</form>
				</div>
			</div>
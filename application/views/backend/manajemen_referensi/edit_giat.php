			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahgiat" class="backend-form" method="post">
			   

					<div class="clearfix">
					<label>Nama Kementerian</label>
                    <select name="kddept">
                    	<?php foreach(get_dept() as $dept): ?>
                     <option value="<?php echo $dept->kddept;?>" <?php echo ($dept->kddept == $detail->kddept)? 'selected=selected':'';?>><?php echo $dept->nmdept;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
					<div class="clearfix">
					<label>Nama Unit Eselon</label>
                    <select name="kdunit">
                    	<?php foreach(get_unit() as $unit): ?>
                        	<option value="<?php echo $unit->kdunit;?>" <?php echo ($unit->kdunit == $detail->kdunit && $unit->kddept == $detail->kddept)? 'selected=selected':'';?>><?php echo $unit->nmunit;?></option>
                    <?php endforeach;?>
                    </select>
					</div>
                    <div class="clearfix">
					<label>Nama Program</label>
                    <select name="kdprogram">
                    	<?php foreach(get_program2() as $program2): ?>
                     <option value="<?php echo $program2->kdprogram;?>" <?php echo ($unit->kdunit == $detail->kdunit && $unit->kddept == $detail->kddept )? 'selected=selected':'';?>><?php echo $program2->nmprogram;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
                    <div class="clearfix">
					<label>Nama Kegiatan</label>
                    <input type="text" name="nmgiat" value="<?php echo $detail->nmgiat?>" />
					</div>				
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="kdgiat" value="<?php echo $detail->kdgiat?>" />
						<input type="hidden" name="table_name" value="<?php echo $param;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
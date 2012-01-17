 			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahoutput" class="backend-form" method="post">
			   <div class="clearfix">
					<label>Nama Kegiatan</label>
                    <select name="KDGIAT">
                    	<?php foreach(get_giat() as $giat): ?>
                     <option value="<?php echo $giat->kdgiat;?>" <?php echo ($giat->kdgiat == $detail->KDGIAT)? 'selected=selected':'';?>><?php echo $giat->nmgiat;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
					<div class="clearfix">
					<label>Nama Output</label>
                    <input type="text" name="NMOUTPUT" value="<?php echo $detail->NMOUTPUT?>" />
					</div>
					
					<div class="clearfix">
					<label>Nama Satuan</label>
                    <input type="text" name="SAT" value="<?php echo $detail->SAT?>" />
					</div>
                    <div class="clearfix">
					<label>Kode Sum</label>
                    <input type="text" name="KDSUM" value="<?php echo $detail->KDSUM?>" />
					</div>
										
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="KDOUTPUT" value="<?php echo $detail->KDOUTPUT?>" />
                        <input type="hidden" name="praid" value="<?php echo $praid;?>">
						<input type="hidden" name="table_name" value="<?php echo $param;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
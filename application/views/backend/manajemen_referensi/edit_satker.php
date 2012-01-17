			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahsatker" class="backend-form" method="post">
			    <input type="hidden" name="kdunitasal" value="<?php echo $detail->kdunit?>" />

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
                        	<option value="<?php echo $unit->kdunit;?>" <?php echo ($unit->kdunit == $detail->kdunit && $unit->kddept 					== $detail->kddept)? 'selected=selected':'';?>><?php echo $unit->nmunit;?></option>
                        
                    <?php endforeach;?>
                    </select>
					</div>		
					<div class="clearfix">
					<label>Nama Satuan Kerja</label>
                    <input type="text" name="nmsatker" value="<?php echo $detail->nmsatker?>" />
					</div>
                    <div class="clearfix">
					<label>Kode Induk</label>
                    <input type="text" name="kdinduk" value="<?php echo $detail->kdinduk?>" />
					</div>
                    <div class="clearfix">
					<label>Nomor SP</label>
                    <input type="text" name="nomorsp" value="<?php echo $detail->nomorsp?>" />
					</div>
                    
                    <div class="clearfix">
					<label>Nama JNSSAT</label>
                    <select name="kdjnssat">
                    <?php foreach(get_jnssat() as $jnssat): ?>
                     <option value="<?php echo $jnssat->kdjnssat;?>" <?php echo ($jnssat->kdjnssat == $detail->kdjnssat)? 'selected=selected':'';?>><?php echo $jnssat->nmjnssat;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
                   
                    <div class="clearfix">
					<label>Nama KPPN</label>
                    <select name="kdkppn">
                    <?php foreach(get_kppn() as $kppn): ?>
                     <option value="<?php echo $kppn->kdkppn;?>" <?php echo ($kppn->kdkppn == $detail->kdkppn)? 'selected=selected':'';?>><?php echo $kppn->nmkppn;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
                    
                    <div class="clearfix">
					<label>Nama Kabupaten/Kota</label>
                    <select name="kdkabkota">
                    <?php foreach(get_kabkota() as $kabkota): ?>
                     <option value="<?php echo $kabkota->kdkabkota;?>" <?php echo ($kabkota->kdkabkota == $detail->kdkabkota)? 'selected=selected':'';?>><?php echo $kabkota->nmkabkota;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
                    <div class="clearfix">
					<label>Nama Lokasi</label>
                    <select name="kdlokasi">
                    <?php foreach(get_lokasi() as $lokasi): ?>
                     <option value="<?php echo $lokasi->kdlokasi;?>" <?php echo ($lokasi->kdlokasi == $detail->kdlokasi)? 'selected=selected':'';?>><?php echo $lokasi->nmlokasi;?></option>
                        <?php endforeach;?>
                    </select>
					</div>
					<div class="clearfix">
					<label>Kode Update</label>
                    <input type="text" name="kdupdate" value="<?php echo $detail->kdupdate?>" />
					</div>					
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="kdsatker" value="<?php echo $detail->kdsatker?>" />
                       <input type="hidden" name="praid1" value="<?php echo $praid1;?>">
                        <input type="hidden" name="praid2" value="<?php echo $praid2;?>">
						<input type="hidden" name="table_name" value="<?php echo $param;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
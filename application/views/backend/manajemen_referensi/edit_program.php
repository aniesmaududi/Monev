 			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahprogram" class="backend-form" method="post">
			   

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
                    <input type="text" name="nmprogram" value="<?php echo $detail->nmprogram;?>" />
					</div>
                    <div class="clearfix">
					<label>Uroutcome</label>
                    <input type="text" name="uroutcome" value="<?php echo $detail->uroutcome?>" />
					</div>					
                    <div class="clearfix">
					<label>Kode Sasaran</label>
                    <input type="text" name="kdsasaran" value="<?php echo $detail->kdsasaran?>" />
					</div>
					<div class="clearfix">
					<label>Kode Jenis</label>
                    <input type="text" name="kdjnsprog" value="<?php echo $detail->kdjnsprog?>" />
					</div>
					
					<div class="clearfix">
					<label>Kode Update</label>
                    <input type="text" name="kdupdate" value="<?php echo $detail->kdupdate?>" />
					</div>					
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="kdprogram" value="<?php echo $detail->kdprogram?>" />
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
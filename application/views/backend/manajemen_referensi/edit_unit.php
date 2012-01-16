			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahunit" class="backend-form" method="post">
					
					<div class="clearfix">
					<label>Nama Kementerian</label>
                    <select name="kdunit">
                    	<?php foreach(get_dept() as $dept): ?>
                    <option value="<?php echo $dept->kddept;?>" <?php echo ($dept->kddept == $detail->kddept)? 'selected=selected':'';?>><?php echo $dept->nmdept;?></option>
                        <?php endforeach;?>
                    </select>
					</div>	
                    <div class="clearfix">
					<label>Nama Unit Eselon</label>
                    <input type="text" name="nmunit" value="<?php echo $detail->nmunit?>" />
					</div>				
                    <div class="clearfix">
					<label>Kode Update</label>
                    <input type="text" name="kdupdate" value="<?php echo $detail->kdupdate?>" />
					</div>				
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="kdunit" value="<?php echo $detail->kdunit?>" />
						<input type="hidden" name="table_name" value="<?php echo $param;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
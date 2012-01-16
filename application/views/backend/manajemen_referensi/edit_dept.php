			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/ubahdept" class="backend-form" method="post">
					
					<div class="clearfix">
					<label>Nama Kementrian</label>
                    <input type="text" name="nmdept" value="<?php echo $detail->nmdept?>" />
					</div>
                   						<div class="clearfix">
					<label>Kode KL</label>
                    <input type="text" name="kdkl" value="<?php echo $detail->kdkl?>" />
					</div>
                    					<div class="clearfix">
					<label>Kode Upload</label>
                    <input type="text" name="kdupload" value="<?php echo $detail->kdupload?>" />
					</div>
                    					<div class="clearfix">
					<label>Kode STM</label>
                    <input type="text" name="kdstm" value="<?php echo $detail->kdstm?>" />
					</div>
                    					<div class="clearfix">
					<label>Kode Batal</label>
                    <input type="text" name="kdbatal" value="<?php echo $detail->kdbatal?>" />
					</div>
                    					<div class="clearfix">
					<label>Kode Hapus</label>
                    <input type="text" name="kdhapus" value="<?php echo $detail->kdhapus?>" />
					</div>
                    <div class="clearfix">
					<label>Kode Update</label>
                    <input type="text" name="kdupdate" value="<?php echo $detail->kdupdate?>" />
					</div>
                    	
					<div class="clearfix">
						<label>&nbsp;</label>
                        <input type="hidden" name="kddept" value="<?php echo $detail->kddept?>" />
						<input type="hidden" name="table_name" value="<?php echo $param;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
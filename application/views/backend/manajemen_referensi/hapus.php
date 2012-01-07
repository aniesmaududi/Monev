			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/do_hapus" class="backend-form" method="post">
					<h4><span><?php echo $table_name;?></span></h4>					
					<div class="clearfix">
					<?php
					for($i=0;$i<count($field);$i++):						
						echo '<label for="userid">';
						echo $field[$i];
						echo '</label>';
						echo '<input type="text" id="'.$field[$i].'" name="'.$field[$i].'" value="'.$row[$field[$i]].'" readonly="readonly"><br>';
					endfor;
					?>
					<span style="margin-left: 90px;">Yakin akan menghapus data diatas?</span>
					</div>					
					<div class="clearfix">
						<label>&nbsp;</label>
						<input type="hidden" name="table_name" value="<?php echo $table_name;?>">						
						<input type="submit" value="Hapus" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
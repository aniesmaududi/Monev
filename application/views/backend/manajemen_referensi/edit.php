			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<form action="<?php echo site_url();?>backend/ref/do_simpan" class="backend-form" method="post">
					<h4><span><?php echo $table_name;?></span></h4>
					<div class="clearfix">
					<?php
					for($i=0;$i<count($field);$i++):						
						echo '<label for="userid">';
						echo $field[$i];
						echo '</label>';
						echo '<input type="text" id="userid" name="'.$field[$i].'" value="'.$row[$field[$i]].'"><br>';
					endfor;
					?>
					</div>					
					<div class="clearfix">
						<label>&nbsp;</label>
						<input type="hidden" name="table_name" value="<?php echo $table_name;?>">
						<input type="submit" value="Simpan" class="btn primary">
						atau
						<?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali')?>
					</div>
				</form>			
			</div>
			<div id="nav-box">
			</div>
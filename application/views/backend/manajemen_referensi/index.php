			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">				
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				?>
					<table class="backend-table" style="overflow:auto;">
						<thead>
							<th>Daftar Referensi</th>
							<th class="option-table">Option</th>
						</thead>
						<?php foreach($tables as $table):?>
						<tr>
							<td>
                            <?php 
							if ($table['table_name']=='t_dept'){ echo 'Kementrian'; $param = 'dept';}
							else if ($table['table_name']=='t_unit'){ echo 'Unit Eselon'; $param = 'unit';}
							else if ($table['table_name']=='t_satker'){ echo 'Satuan Kerja'; $param = 'satker';}
							
							else {
							 echo $table['table_name']; $param = $table['table_name'];}?>
                            </td>							
							<td>
                                                            <a href="<?php echo site_url('backend/ref/view/'.$param)?>" class="btn">Lihat</a>
                                                            <!--<a href="" class="btn error">Hapus</a>-->
                                                        </td>
						</tr>
						<?php endforeach;?>
					</table>
			</div>
			<div id="nav-box">				
				<div class="clearfix"></div>
			</div>
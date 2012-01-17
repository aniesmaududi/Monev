 			<h1><?php echo $title;?></h1>
                        <h3><?php
						if ($table_name=='program'){ echo 'Daftar Program';}
							else if ($table_name=='iku'){ echo 'Daftar Indeks Kinerja Utama';}
							else if ($table_name=='unit'){ echo 'Daftar Unit';}
							else
							 echo $table_name;?></h3>
			<div id="search-box" style="min-height:400px;overflow:auto;">				
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				?>
					<table class="backend-table">
						<thead>
                                                    <th>No</th>
                                                    <th>Nama Program</th>
                                                    <th>Harapan</th>
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=$this->uri->segment(5)+1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->nmprogram;?></td>
                            <td><?php echo $data->uroutcome;?></td>
                            <td><?php echo anchor('backend/ref/editprogram/program/'.$data->kddept.'/'.$data->kdunit.'/'.$data->kdprogram,'Ubah','class="btn"');?></td>
                        </tr>
						<?php $i++; endforeach;?>
						
					</table>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
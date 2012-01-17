 			<h1><?php echo $title;?></h1>
                        <h3><?php
						if ($table_name=='dept'){ echo 'Daftar Kementrian';}
							else if ($table_name=='output'){ echo 'Output';}
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
                                                    <th>Nama Output</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Nama Satuan</th>
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->NMOUTPUT;?></td>
                            <td><?php echo $data->NMGIAT;?></td>
                            <td><?php echo $data->SAT;?></td>
                            <td><?php echo anchor('backend/ref/editoutput/output/'.$data->KDGIAT.'/'.$data->KDOUTPUT,'Ubah','class="btn"');?></td>
                        </tr>
						<?php $i++; endforeach;?>
						
					</table>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
           
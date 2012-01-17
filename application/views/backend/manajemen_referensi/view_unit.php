			<h1><?php echo $title;?></h1>
                        <h3><?php
						if ($table_name=='dept'){ echo 'Daftar Kementrian';}
							else if ($table_name=='satker'){ echo 'Daftar Satuan Kerja';}
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
                                                    <th>Nama Unit Eselon</th>
                                                    <th>Nama Kementerian</th>
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->nmunit;?></td>
                            <td><?php echo $data->nmdept;?></td>
                            <td><?php echo anchor('backend/ref/editunit/unit/'.$data->kddept.'/'.$data->kdunit,'Ubah','class="btn"');?></td>
                        </tr>
						<?php $i++; endforeach;?>
						
					</table>
			</div>
			<div id="nav-box">
				<?php //<?php echo $this->pagination->create_links(); ?> 
				<div class="clearfix"></div>
			</div>
           
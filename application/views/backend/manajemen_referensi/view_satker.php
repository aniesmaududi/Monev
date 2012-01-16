			<h1><?php echo $title;?></h1>
                        <h3><?php
						if ($table_name=='dept'){ echo 'Daftar Departemen';}
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
                                                    <th>Nama Satker</th>
                                                    <th>Nama Eselon</th>
                                                    <th>Nama Kementerian</th>
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=$this->uri->segment(5)+1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->nmsatker;?></td>
                            <td><?php echo $data->nmunit;?></td>
                            <td><?php echo $data->nmdept;?></td>
                            <td><?php echo anchor('backend/ref/editsatker/satker/'.$data->kdsatker,'Ubah','class="btn"');?></td>
                        </tr>
						<?php $i++; endforeach;?>
						
					</table>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
			<h1><?php echo $title;?></h1>
                        <h3><?php
						if ($table_name=='dept'){ echo 'Daftar Kementrian';}
							else if ($table_name=='output'){ echo 'Daftar Output';}
							else if ($table_name=='unit'){ echo 'Daftar Unit';}
							else
							 echo $table_name;?></h3>
			<div id="search-box" style="min-height:400px;overflow:auto;">				
				           
            <form action="<?php echo site_url();?>backend/ref/view/output" class="backend-form" method="post">
            <center>
            <input type="text" name="cari"/>
            <input type="submit" value="Cari" class="btn primary">
            </center>
            </form>
            <br />
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				if (count($table)>0){?>
				
					<table class="backend-table">
						<thead>
                                                    <th>No</th>
                                                    <th>Kode Output</th>
                                                    <th>Nama Output</th>
                                                   
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->KDOUTPUT;?></td>
                            <td><?php echo $data->NMOUTPUT;?></td>
                           
                            <td><?php echo anchor('backend/ref/editoutput/output/'.$data->KDGIAT.'/'.$data->KDOUTPUT,'Detail/Ubah','class="btn"');?></td>
                        </tr>
						<?php $i++; endforeach;?>
			</table>
            <?php } else { echo 'Data yang anda cari tidak ditemukan,';  ?>
            <?php echo anchor('backend/ref/view/'.$this->uri->segment(4),'Kembali'); } ?>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
           
			<h1><?php echo $title;?></h1>
            <h3><?php
			echo 'Daftar Kegiatan';?></h3>
			<div id="search-box" style="min-height:400px;overflow:auto;">				
			 <form action="<?php echo site_url();?>backend/ref/view/giat" class="backend-form" method="post">
            <center>
            <input type="text" name="cari" />
            <input type="submit" value="Cari" class="btn primary">
            </center>
            </form>
            <br />	<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				
				if (count($table)>0){?>
					<table class="backend-table">
						<thead>
                                                    <th>No</th>
                                                    <th>Kode Kegiatan</th>
                                                    <th>Nama Kegiatan</th>
                                                    <th>Opsi</th>
                                                                                                      
						</thead>
						<?php $i=$this->uri->segment(5)+1; foreach($table as $data):?>
						<tr>
                        	<td><?php echo $i;?></td>
                            <td><?php echo $data->kdgiat;?></td>
                            <td><?php echo $data->nmgiat;?></td>
                            <td><?php echo anchor('backend/ref/editgiat/giat/'.$data->kdgiat,'Detail/Ubah','class="btn"');?></td>
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
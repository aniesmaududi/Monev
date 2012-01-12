			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
				<?php if(count($depts)>0):?>
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				$i = 0;
				?>
					<form method="post" action="backend/akses_kl/simpan">
					<table class="backend-table">
						<thead>
							<th>Username</th>
							<th>Pilih</th>
							<th class="option-table">Option</th>
						</thead>
						<?php 
								foreach($depts as $dept):
										$temptext = "";
										$disabled_prop = " disabled='1' ";
										$link_prop1 = "";
										$link_prop2 = "";
										$i++;
										$cb_attr = array(
											'name'        	=> 'cb_'.$i,
											'value'       	=> $dept['kddept'],
											'checked'     => FALSE
											);
										foreach($data_akses as $akses):
											if($akses['kddept'] == $dept['kddept']):
												$link_prop1 = "href ='".site_url('backend/akses_kl/edit/'.$dept['kddept'])."'";
												$link_prop2 = "href ='".site_url('backend/akses_kl/delete/'.$dept['kddept'])."'";
												$disabled_prop = "";
												$temptext = "<b>(sudah terdaftar)</b>";
												$cb_attr = array(
														'name'        	=> 'cb_'.$i,
														'value'       	=> '',
														'checked'     => TRUE,
														'disabled'		=> TRUE
														);
											endif;
										endforeach;
						?>
						<tr>
							<td><?php echo $dept['nmdept']." ".$temptext?></td>
							<td><?php echo form_checkbox($cb_attr); ?></td>
							<td>
									<a <?php echo $link_prop1;?> class="btn" <?php echo $disabled_prop;?>>Edit</a> 
									<a <?php echo $link_prop2;?> class="btn error" <?php echo $disabled_prop;?>>Hapus</a>
							</td>
						</tr>
						<?php endforeach;?>
					</table>
					<div class="clearfix">
						<label>&nbsp;</label>
						<input type="submit" value="Buat Akses" class="btn primary"> 
					</div>
					</form>
				<?php else:?>
					no data
				<?php endif;?>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
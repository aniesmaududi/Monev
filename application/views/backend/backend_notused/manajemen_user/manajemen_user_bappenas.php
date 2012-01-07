			<h1><?php echo $title;?></h1>
			<div id="search-box" style="min-height:400px;">
				<?php if(count($users)>0):?>
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				?>
					<table class="backend-table">
						<thead>
							<th>Username</th>
							<th>Nama</th>
							<th class="option-table">Option</th>
						</thead>
						<?php foreach($users as $user):?>
						<tr>
							<td><?php echo $user['username']?></td>
							<td><?php echo $user['nama']?></td>
							<td><a href="<?php echo site_url('backend/user_bappenas/edit/'.$user['kdbapenas'])?>" class="btn">Edit</a> <a href="" class="btn error">Hapus</a></td>
						</tr>
						<?php endforeach;?>
					</table>
					
				<?php else:?>
					no data
				<?php endif;?>
			</div>
			<div id="nav-box">
				<?php echo $page; ?>
				<div class="clearfix"></div>
			</div>
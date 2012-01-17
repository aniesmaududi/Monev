			<h1><?php echo $title;?></h1>
                        <h3><?php echo $table_name;?></h3>
			<div id="search-box" style="min-height:400px;overflow:auto;">				
				<?php
				if($this->session->flashdata('message')):
					echo flash_message($this->session->flashdata('message_type'));
				endif;
				?>
					<table class="backend-table">
						<thead>
                                                    <th></th>
                                                    <th></th>
                                                    <?php
                                                    foreach($field as $head): 
                                                        echo '<th>'.$head.'</th>';        
                                                    endforeach;
                                                    ?>                                                    
						</thead>
						<?php
                                                foreach($table as $data):
                                                    $kd = "/";
                                                    for($i=0;$i<count($field);$i++)
                                                    {
                                                        if($field[$i] == "kddept" || $field[$i] == "kdunit" || $field[$i] == "kdsatker" || $field[$i] == "kdprogram" || $field[$i] == "kdgiat" || $field[$i] == "kdiku" || $field[$i] == "kdikk" )
                                                        $kd .= $field[$i].'/'.$data[$field[$i]].'/';
                                                    }
                                                echo '<tr>';
                                                echo '<td><a href="'.site_url().'backend/ref/edit/'.$table_name.$kd.'">Edit</a></td>';
                                                echo '<td><a href="'.site_url().'backend/ref/hapus/'.$table_name.$kd.'">Hapus</a></td>';
                                                    for($i=0;$i<count($field);$i++)
                                                    {
                                                        echo '<td>'.$data[$field[$i]].'</td>';
                                                    }
						echo '</tr>';
						endforeach;
                                                ?>
					</table>
			</div>
			<div id="nav-box">
				<?php //echo $page; ?>
				<div class="clearfix"></div>
>>>>>>> 2dc8ba0fabc3b0cd6cc392bf1b3ac7fd6d2ce561
			</div>
		<div id="content-left">
			<div id="navigation-title"><?php echo $nav_title;?></div>
			<div id="navigation-list">
				<ul>
					<?php
					for($i=0;$i<count($nav_menu);$i++):
					?>
					<li>
						<a href="<?php echo $nav_menu_link[$i];?>">
							<img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/>
							<?php echo $nav_menu[$i];?>
						</a>
					</li>
					<?php endfor ?>
				</ul>
			</div><!-- end of navigation-list -->
			<br>
			<?php if(isset($nav2_title)){ ?>	
			<div id="navigation-title"><?php echo $nav2_title;?></div>
			<div id="navigation-list">
				<ul>
					<?php
					for($i=0;$i<count($nav2_menu);$i++):
					?>
					<li>
						<a href="<?php echo $nav2_menu_link[$i];?>">
							<img src="<?php echo ASSETS_DIR_IMG.'arrow.png'?>"/>
							<?php echo $nav2_menu[$i];?>
						</a>
					</li>
					<?php endfor ?>
				</ul>
			</div><!-- end of navigation-list -->
			<?php } ?>
		</div><!-- end of content-left -->		
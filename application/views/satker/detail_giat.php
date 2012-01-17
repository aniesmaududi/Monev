			<h1><?php echo $nmgiat;?></h1>
			<div id="search-box">
				
			</div>
			<div id="nav-box">
				<div class="clearfix"></div>
				
				<div id="box-title">
					<div class="column6">Capaian Keluaran</div>
					<div class="column2 borderright borderleft">Target</div>
					<div class="column5">Realisasi</div>
					<div class="clearfix"></div>
				</div><!-- end of box-title -->
				
				<?php foreach($output as $row):?>
				
				<div class="box-normal box-end">
					<div class="column6"><?php echo $row['nmoutput'].' ('.$row['sat'].')';?></div>
					<div class="column2"><?php echo $row['vol'];?></div>
					<div class="column5"><input type="text" class="realisasi" value=""/></div>
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				
				<div class="box-subset-title">IKK <?php echo $row['nmoutput'];?> :</div>
				
				<?php foreach($ikk as $row1):?>
				<div class="box-content box-list">
					<div class="column6"><div class="subset"><?php echo $row1['nmikk'];?></div></div>
					<div class="column2"><div class="subset"></div></div>
					<div class="column5"></div>
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
				
				<?php endforeach;?><!-- end of ikk foreach -->
				<?php endforeach;?><!-- end of output foreach-->
					
				<br/>
				
				<div class="box-subset-title">Catatan Satker : </div>
				<div class="box-content box-end">
					<textarea id="comment"></textarea>
				</div>
			
				<script src="<?php echo ASSETS_DIR_JS.'jquery.autoresize.js'?>"></script>
				<script>

				$('textarea,input').autoResize({
					onBeforeResize: function(){
					console.log('Before');
					},
					onAfterResize: function(){
					console.log('After');
				}
				});		
				</script>
				
				
				<div class="clearfix"></div>
				
			</div>
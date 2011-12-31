			<h1>Semua Laporan</h1>
			<div id="search-box">
				<p>20 laporan masih bermasalah</p>
				<div id="search">
					<img src="<?php echo ASSETS_DIR_IMG.'magnifier.png'?>"/>
					<input type="text"/>
				</div>
			</div>
			<div id="nav-box">
				<p id="total">Total 35 laporan dalam 7 halaman.</p>
				<div id="pagination">
					<div id="page-top"><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'top.png'?>"/></a></div>
					<div id="page-prev"><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'prev.png'?>"/></a></div>
					<div class="number"><a href="#">3</a></div>
					<div class="number"><a href="#">4</a></div>
					<div class="number active"><a href="#">5</a></div>
					<div class="number"><a href="#">6</a></div>
					<div class="number"><a href="#">7</a></div>
					<div id="page-prev"><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'next.png'?>"/></a></div>
					<div id="page-end"><a href="#"><img src="<?php echo ASSETS_DIR_IMG.'end.png'?>"/></a></div>
				</div>
				<div class="clearfix"></div>
				
				<div id="box-title">
					<div class="column1">Daftar Laporan</div>
					<div class="clearfix"></div>
				</div>
<?php foreach($result as $rows ): 
if($this->session->userdata('jabatan')==1):
$date=$rows['accsatker_date'];
$status=$rows['accsatker'];
elseif($this->session->userdata('jabatan')==2):
$date=$rows['accunit_date'];
$status=$rows['accunit'];
elseif($this->session->userdata('jabatan')==3):
$date=$rows['accdept_date'];
$status=$rows['accdept'];
endif;


$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";


?>				
				<div class="box-content">
					<div class="box-content-left">
					<h3><?php echo $rows['nmprogram'];?></h3>
					<p>Nomor XIV/Sampel-ID/8490/2001</p>
					<br/>
					<p>Terakhir kali diakses oleh Hermawan Tri Sudarmo, tanggal <?php echo date_format(date_create($date),'d');
					if((date_format(date_create($date),'m'))==1)
					echo ' Januari ';
					elseif(date_format(date_create($date),'m')==2)
					echo ' Februari ';
					elseif(date_format(date_create($date),'m')==3)
					echo ' Maret ';
					elseif(date_format(date_create($date),'m')==4)
					echo ' April ';
					elseif(date_format(date_create($date),'m')==5)
					echo ' Mei ';
					elseif(date_format(date_create($date),'m')==6)
					echo ' Juni ';
					elseif(date_format(date_create($date),'m')==7)
					echo ' Juli ';
					elseif(date_format(date_create($date),'m')==8)
					echo ' Agustus ';
					elseif(date_format(date_create($date),'m')==9)
					echo ' September ';
					elseif(date_format(date_create($date),'m')==10)
					echo ' Oktober ';
					elseif(date_format(date_create($date),'m')==11)
					echo ' November ';
					elseif(date_format(date_create($date),'m')==12)
					echo ' Desember ';
					
					echo date_format(date_create($date),'Y');
					?>,</p>
					<p><?php echo date_format(date_create($date),'H:m:s');?>. Laporan PMK ini <?php 
							if($status==1) 
							echo 'sudah selesai diisi';
							else
							echo 'belum selesai diisi';
							?>.</p>
					</div><!-- end of box-content-left -->
					
					<div class="box-content-right">
					<table>
						<tr>
							<td class="button"><a href="#" class="custom">Isi Realisasi</a></td>
							<td class="mark"><img src="<?php 
							if($status==1) 
							echo ASSETS_DIR_IMG.'done.png';
							else
							echo ASSETS_DIR_IMG.'notdone.png';
							?>" class="round-mark"/></td>
						</tr>
					</table>
					</div><!-- end of box-content-right -->
					
					<div class="clearfix"></div>
				</div><!-- end of box-content -->
<?php endforeach;?>								
			</div>
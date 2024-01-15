
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PRESENSI PERTEMUAN</h1>
								<h5 class="text-white op-7 mb-2">
									<?php
										if(isset($_SESSION['status_login'])){
											if($_SESSION['status_login']=="Dosen" || $_SESSION['status_login']=="Pegawai"){
												if(isset($_SESSION['nama_prodi'])){
													echo $_SESSION['nama_prodi'].' ';
												}
											}
										}
									?>
									Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">

								</h1>
                            </div>
						</div>
					</div>
				</div>

                <!-- selamat datang -->
                <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 bg-light rounded">
											<form action="<?php echo base_url('dosen/presensi_pertemuan')?>" method="post">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PERTEMUAN SEMESTER</label>
															<select name="id_pertemuan" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_pertemuan->result_array() as $i):
																		$id_pertemuan_combo=$i['id_pertemuan'];
																		$tahun_ajaran_combo=$i['tahun_ajaran'];
																		$jenis_pertemuan_combo=$i['jenis_pertemuan'];
																		$semester_combo=$i['semester'];

																?>
																<option  value="<?php echo $id_pertemuan_combo ?>" <?php if(isset($_SESSION['id_pertemuan_search'])){if($_SESSION['id_pertemuan_search']==$id_pertemuan_combo){ echo 'selected';}}?>>
																	<?php echo $tahun_ajaran_combo.' ('.$semester_combo.')'; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
													</div>
													<div class="col-md-3">

														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label><br>
															<input type="submit" name="tombol_cari_tahun_ajaran" value="Cari Sekarang" class="btn btn-primary">
														</div>

													</div>
													<?php if(isset($_SESSION['kode_jurusan']) && isset($_SESSION['id_pertemuan_search'])){ ?>
													<div class="col-md-3">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >SK Pengasuh MK</label>
																<?php if($this->m_presensi_pertemuan->getFile($_SESSION['kode_jurusan'], $_SESSION['id_pertemuan_search'])!=''){ ?>
																<a href="<?php echo base_url('templates/file/user/fakultas/sk_pertemuan/'.$this->m_presensi_pertemuan->getFile($_SESSION['kode_jurusan'], $_SESSION['id_pertemuan_search']))?>" target="_BLANK" class="btn btn-info"><i class="fa fa-eye"></i> File</a>
															<?php }else{ echo '<b class="text-danger">No File</b>'; } ?>
														</div>
													</div>
													<?php } ?>
												</div>
											</form>
										</div>
										<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
										<div class="col-md-6 bg-light rounded text-center">
											<div class="form-group text-left">

												<ol>
													<li>
														Simbol
														<ul>
															<li><i class="fas fa-dot-circle"></i> Belum melakukan presensi</li>
															<li><i class="fas fa-clock text-warning"></i> Menunggu verifikasi dari prodi</li>
															<li><i class="fas fa-check-circle text-success"></i> Terverifikasi</li>
															<li><i class="fas fa-times-circle text-danger"></i> Verifikasi ditolak</li>
														</ul>
													</li>
													<li>Silahkan klik sombol <i class="fas fa-clock text-warning"></i>, <i class="fas fa-check-circle text-success"></i> dan <i class="fas fa-times-circle text-danger"></i> pada tabel dibawah untuk melihat detail dan aksinya!</li>
												</ol>
											</div>
										</div>
										<?php } ?>
									</div>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydatascroll" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NO</b></td>
												<!-- <td align="center" width="500px"><b>SEMUA DOSEN</b></td> -->
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>NAMA MATKUL</b></td>
												<td align="center"><b>SKS</b></td>
												<td align="center"><b>KELAS</b></td>
												<td align="center"><b>JENIS TUGAS</b></td>
												<td align="center"><b>HARI</b></td>
												<?php

												$pertemuan_awal=0;
												$pertemuan_akhir=16;

												for ($i= $pertemuan_awal; $i < $pertemuan_akhir; $i++){ ?>
												<td align="center"><b>P<?php echo ($i+1);?></b></td>
												<?php } ?>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tfoot>
											<tr  class="bg-info">
												<td align="center"><b>NO</b></td>
												<!-- <td align="center"><b>SEMUA DOSEN</b></td> -->
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>NAMA MATKUL</b></td>
												<td align="center"><b>SKS</b></td>
												<td align="center"><b>KELAS</b></td>
												<td align="center"><b>JENIS TUGAS</b></td>
												<td align="center"><b>HARI</b></td>
												<?php for ($i= $pertemuan_awal; $i < $pertemuan_akhir; $i++){ ?>
												<td align="center"><b>P<?php echo ($i+1);?></b></td>
												<?php } ?>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</tfoot>
										<tbody>
										<?php
												$no = 1;
												$p8 = false;
												$jadwalMulaiSetelahUTS = '';

												foreach($data->result_array() as $i):
													$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
													$id_pertemuan=$i['id_pertemuan'];
													$pertemuan_mulai=$i['pertemuan_mulai'];
													$pertemuan_selesai=$i['pertemuan_selesai'];
													$jenis_pertemuan=$i['jenis_pertemuan'];

													// $dosen_pengampu=$i['dosen_pengampu'];
													// $array_dosen = explode(', ', $dosen_pengampu);

													// $array_dosen_hasil = array();
													// $array_npk_hasil = array();
													// $index = 0;
													// foreach ($array_dosen as $npk) {
													// 	$nama_dosen = $this->m_presensi_pertemuan->getNamaDosen($npk);
													// 	$array_npk_hasil[$index] = $npk;
													// 	$array_dosen_hasil[$index] = $nama_dosen;
													// 	$index++;
													// }
													// $string_dosen_hasil = implode('/ ', $array_dosen_hasil);

													$nama_mk=$i['nama_mk'];
													$semester = $i['semester'];
													$sks_teori=$i['sks_teori'];
													$sks_praktik=$i['sks_praktik'];
													$nama_kelas=$i['nama_kelas'];
													$waktu_pertemuan_pertama = $i['waktu_pertemuan_pertama'];

													date_default_timezone_set('Asia/Jakarta');
	        										$now = date("Y-m-d");
													$jadwalAwal = date('Y-m-d', strtotime($waktu_pertemuan_pertama));
													$jadwalAwalJam = date('H:i:s', strtotime($waktu_pertemuan_pertama));
													$today = date('D', strtotime($now));
													$dayList = array(
													    'Sun' => 'Minggu',
													    'Mon' => 'Senin',
													    'Tue' => 'Selasa',
													    'Wed' => 'Rabu',
													    'Thu' => 'Kamis',
													    'Fri' => 'Jumat',
													    'Sat' => 'Sabtu'
													);
													// echo $dayList[$yesterday];
													// echo $dayList[$today]; die();

										?>
											<tr>
												<td><?php echo ($no++);?></td>
												<!-- <td><?php echo $string_dosen_hasil;?></td> -->
												<td><?php echo $semester;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo ($sks_teori+$sks_praktik);?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $this->m_presensi_pertemuan->getTugasPengampu($id_jadwal_kelas_pertemuan, $_SESSION['npk']); ?></td>
												<td><?php echo $dayList[date('D', strtotime($jadwalAwal))];?></td>
												<?php
													$index = 0;
													$cek_pertemuan_sebelumnya = false;
													for ($i=$pertemuan_awal; $i < $pertemuan_akhir; $i++){
														$baris = $this->m_presensi_pertemuan->getDataPertemuan($id_jadwal_kelas_pertemuan, ($i+1))->row();
														if($baris){
															$id_presensi_pertemuan = $baris->id_presensi_pertemuan;
														}


														$yesterday = date('D', strtotime($jadwalAwal));

                                                        

														// if((($i+1)%8)==0){
															$warna = "";
															if(($i+1)==8){
																$warna = "bg-success";
																$p8 = true;
																// $jadwalMulaiSetelahUTS = new DateTime('2021-12-11');
																$getTanggalSelesaiUjianUTS = $this->m_presensi_pertemuan->getTanggalSelesaiUjianUTS($id_pertemuan,'Ujian Tengah Semester');
																if($getTanggalSelesaiUjianUTS!=null){
																	$jadwalMulaiSetelahUTS = date('Y-m-d', strtotime($getTanggalSelesaiUjianUTS));
																	$jadwalMulaiSetelahUTS = new DateTime($jadwalMulaiSetelahUTS);
																}else{
																	$jadwalMulaiSetelahUTS = '';
																}

																if($jadwalMulaiSetelahUTS!=null){
																	while((new DateTime($jadwalAwal))<$jadwalMulaiSetelahUTS){
																		$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));

																	}
																}

												?>
															<!-- <td class="text-white bg-success"><?php echo 'UTS' ?></td> -->
												<?php
															}elseif(($i+1)==16){
																$warna = "bg-success";
												?>
															<!-- <td class="text-white bg-success"><?php echo 'UAS' ?></td> -->
												<?php
															}
														// }else
														if($p8==true && $jadwalMulaiSetelahUTS==null){

												?>
													<td align="center">

														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b title="Belum terjadwal"><?php echo '<i class="fas fa-times-circle text-danger"></i> '.'<small class="text-danger">'.'Belum Terjadwal'.'</small>';?></b>
														  </a>
														  <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

															  	<a class="text-secondary dropdown-item" data-toggle="modal" data-target="#modalEdit<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-pen"></i>  Edit</a>
														    	<a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div> -->
														</div>
													</td>
												<?php
															// }
														}
														elseif($this->m_presensi_pertemuan->check_ketersediaan_pertemuan_minta_verifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){
												?>
													<td align="center">

														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<?php
														  		$tgl_tampil = $this->m_presensi_pertemuan->getTanggalPresensi($id_jadwal_kelas_pertemuan, ($i+1), $jadwalAwal);
														  	?>
														  	<b title="Minta Verifikasi"><?php echo '<i class="fas fa-clock text-warning"></i> '.'<small class="text-warning">'.date('Y-m-d', strtotime($tgl_tampil)).'</small>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

															  	<a class="text-secondary dropdown-item" data-toggle="modal" data-target="#modalEdit<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-pen"></i>  Edit</a>
														    	<a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>

												<?php }elseif($this->m_presensi_pertemuan->check_ketersediaan_pertemuan_terverifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){ ?>
													<td align="center">
														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<?php
														  		$tgl_tampil = $this->m_presensi_pertemuan->getTanggalPresensi($id_jadwal_kelas_pertemuan, ($i+1), $jadwalAwal);
														  	?>

														  	<b title="Terverifikasi"><?php echo '<i class="fas fa-check-circle text-success"></i> '.'<small class="text-success">'.date('Y-m-d', strtotime($tgl_tampil)).'</small>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														  	<!-- isi -->
														     <a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>
												<?php }elseif($this->m_presensi_pertemuan->check_ketersediaan_pertemuan_ditolak($id_jadwal_kelas_pertemuan, ($i+1))>0){ ?>
													<td align="center">
														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b title="Ditolak"><?php echo '<i class="fas fa-times-circle text-danger"></i> '.'<small class="text-danger">'.$jadwalAwal.'</small>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														  	<a class="text-secondary dropdown-item" data-toggle="modal" data-target="#modalEdit<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-pen"></i>  Edit dan Minta Verifikasi Ulang</a>
														    <a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>
												<?php }else{ ?>
													<td align="center" class="<?php echo $warna ?>">
														<div class="dropdown">
														<?php if(($pertemuan_mulai<=$jadwalAwal.' '.$jadwalAwalJam) && ($pertemuan_selesai>=$jadwalAwal.' '.$jadwalAwalJam)){ ?>
															<?php
														  		$tgl_tampil = $this->m_presensi_pertemuan->getTanggalPengajuan($id_jadwal_kelas_pertemuan, ($i+1), $jadwalAwal);
														  		if($warna=="bg-success"){
														  			if(($i+1)==8){
														  				$tulisan_ujian = "UTS";
														  			}else{
														  				$tulisan_ujian = "UAS";
														  			}
														  		}else{
														  			$tulisan_ujian = date('Y-m-d', strtotime($tgl_tampil));
														  		}
														  	?>
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" title="jadwal pertemuan <?= date('Y-m-d', strtotime($tgl_tampil)) ?>" aria-haspopup="true" aria-expanded="false">

														  	<b><?php echo '<i class="fas fa-dot-circle"></i> '.'<small class="">'.$tulisan_ujian.'</small>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

														  	<?php 	;
															      	if($this->m_presensi_pertemuan->cekPertemuanSebelumnya($id_jadwal_kelas_pertemuan,$i)== 1 || $tulisan_ujian=="UAS"){ ?>
														  			<?php if($yesterday==$today || $jadwalAwal<$now){?>
														  				<?php if($tulisan_ujian!="UAS" && ($jadwalAwal<$now) && ($this->m_presensi_pertemuan->cekSemuaRequestPertemuan($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()==0)){?>
																	  			<a class="text-warning dropdown-item" data-toggle="modal" data-target="#modalAjukanJadwalGanti<?php echo $id_jadwal_kelas_pertemuan.($i+1); ?>"><i class="fas fa-comments"></i>  Ajukan Jadwal penganti</a>
																	  	<?php }elseif( $tulisan_ujian!="UAS" && (($jadwalAwal<$now) && ($this->m_presensi_pertemuan->cekRequestPertemuanDitolak($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()>0)) && ($this->m_presensi_pertemuan->cekRequestPertemuanMintaSetujui($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()<1) && ($this->m_presensi_pertemuan->cekRequestPertemuanDisetujui($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()<1)){?>
														  						<a class="text-danger dropdown-item" data-toggle="modal" data-target="#modalAjukanJadwalGanti<?php echo $id_jadwal_kelas_pertemuan.($i+1); ?>"><i class="fas fa-comments"></i>  Pengajuan sebelumnya ditolak, ajukan Jadwal penganti lagi.</a>
														  						<a class="text-warning dropdown-item" data-toggle="modal" data-target="#modalAlasanPenolakan<?php echo $id_jadwal_kelas_pertemuan.($i+1); ?>"><i class="fas fa-eye"></i> Lihat alasan penolakan sebelumnya.</a>
														  				<?php }elseif($tulisan_ujian!="UAS" &&  ($jadwalAwal<$now) && ($this->m_presensi_pertemuan->cekRequestPertemuanMintaSetujui($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()>0)){?>
														  							<a class="text-danger dropdown-item" data-toggle="modal" data-target="#modalEditGantiJadwal<?php echo $id_jadwal_kelas_pertemuan.($i+1); ?>"><i class="fas fa-times"></i> Batal pengajuan jadwal ganti.</a>
														  							<a class="text-warning dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, permintaan jadwal ganti anda belum di respon admin prodi.</a>
																	  	<?php }elseif(($jadwalAwal==$now) || (($this->m_presensi_pertemuan->cekRequestPertemuanDisetujui($id_jadwal_kelas_pertemuan, ($i+1))->num_rows()>0)) || $tulisan_ujian=="UAS"){ ?>
																	  		<?php
																	  			$tanggal_diaju = $this->m_presensi_pertemuan->ambilTanggalDiaju($id_jadwal_kelas_pertemuan, ($i+1));
																	  			if(($jadwalAwal==$now) || ($tanggal_diaju==$now) || $tulisan_ujian=="UAS"){
																	  		?>
																	  			<a class="text-info dropdown-item" data-toggle="modal" data-target="#modalInputData<?php echo $id_jadwal_kelas_pertemuan.($i+1).$jadwalAwal.$jadwalAwalJam; ?>"><i class="fas fa-book"></i>  Presensi</a>
																	  		<?php }elseif($tanggal_diaju>$now){ ?>
																	  			<a class="text-warning dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, Jadwal ganti anda pada hari <?php echo $dayList[date('D', strtotime($tanggal_diaju))]; ?> tanggal <?php echo $tanggal_diaju; ?></a>
																	  		<?php }else{ ?>
																	  			<a class="text-danger dropdown-item" data-toggle="modal" data-target="#modalAjukanJadwalGanti<?php echo $id_jadwal_kelas_pertemuan.($i+1); ?>"><i class="fas fa-comments"></i>  Maaf jadwal pergantian yang anda ajukan <br>hari <?php echo $dayList[date('D', strtotime($tanggal_diaju))]; ?> tanggal <?php echo $tanggal_diaju; ?> telah berakhir, <br>untuk menginput presensi, silahkan ajukan <br>Jadwal penganti lagi!.</a>
																	  		<?php } ?>
																	  	<?php }elseif($jadwalAwal>$now){ ?>
																	  		<a class="text-warning dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, Jadwal anda hari <?php echo $dayList[$yesterday]; ?> tanggal <?php echo $jadwalAwal; ?></a>
																	  	<?php } ?>
																  	<?php }else{ ?>
																  		<a class="text-danger dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, Jadwal anda hari <?php echo $dayList[$yesterday]; ?></a>
																  	<?php } ?>

															<?php
																	$cek_pertemuan_sebelumnya = true;
																}
																else{
															?>
																<a class="text-danger dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, Pertemuan sebelumnya masih kosong</a>
															<?php } ?>
														  </div>
														<?php }else{ ?>
															 <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															  	<b><?php echo '<i class="fas fa-exclamation text-danger"></i>';?></b>
															  </a>
															  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															  	<a class="text-danger dropdown-item"><i class="fas fa-exclamation"></i>  Maaf, Pertemuan ini telah melebihi range!</a>
															  </div>
														<?php } ?>
														</div>
													</td>

												<?php 	}

														if((($i+1)%8)!=0){
															$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
															// $jadwalAwal_selesai = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal_selesai)));
															while($this->m_presensi_pertemuan->cekHariLibur($jadwalAwal, $jadwalAwalJam)==-1){
																$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
															}
														}

														// SKIP SEBELUM UTS
														// while ($this->m_presensi_pertemuan->cekTanggalUTS($id_pertemuan,'Ujian Tengah Semester', $jadwalAwal, $jadwalAwalJam)==-1) {
														// 	$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
														// }

													} ?>







												<!-- ============ MODAL DETAIL =============== -->
												<?php
													foreach($this->m_presensi_pertemuan->semuaDataPertemuan($id_jadwal_kelas_pertemuan)->result_array() as $i):
														$id_presensi_pertemuan=$i['id_presensi_pertemuan'];
														$waktu_pertemuan=$i['waktu_pertemuan'];
														$waktu_input=$i['waktu_input'];
														$pertemuan_ke=$i['pertemuan_ke'];
														$dosen_penginput_presensi=$i['dosen_penginput_presensi'];
														$kode_ruang=$i['kode_ruang'];
														$materi=$i['materi_pertemuan'];
														$media=$i['media_pertemuan'];
														$metode=$i['metode_pertemuan'];
														$mhs_hadir=$i['mhs_hadir'];
														$foto_pertemuan=$i['foto_pertemuan'];
														$status_verifikasi=$i['status_verifikasi'];



													?>

													<div class="modal fade" id="modalDetail<?php echo $id_presensi_pertemuan; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-info">
																	<h3 class="modal-title" id="myModalLabel">Detail Presensi Pertemuan</h3>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																</div>
																<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/presensi'?>" enctype="multipart/form-data">
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-md-6">
																				<label>Pertemuan Ke</label><br>
																				<h3><b><?php echo $pertemuan_ke?></b></h3>
																			</div>
																			<?php if($jenis_pertemuan=="Online"){ ?>
																				<div class="col-md-6">
																					<label>Media</label><br>
																					<h3><b><?php echo $media; ?></b></h3>
																				</div>
																			<?php }else{ ?>
																				<div class="col-md-6">
																					<label>Ruang</label><br>
																					<h3><b><?php echo $kode_ruang; ?></b></h3>
																				</div>
																			<?php } ?>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
																				<label>Pelaporan Oleh</label><br>
																				<h3><b class="text-danger"><?php echo $this->m_presensi_pertemuan->getNamaDosen($dosen_penginput_presensi); ?></b></h3>
																			</div>

																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label>Waktu Pertemuan</label><br>
																				<h3><b><?php echo $waktu_pertemuan; ?></b></h3>
																			</div>
																			<div class="col-md-6">
																				<label>Waktu Input</label><br>
																				<h3><b><?php echo $waktu_input; ?></b></h3>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label>Status verifikasi</label><br>
																				<h3><b><?php echo $status_verifikasi; ?></b></h3>
																			</div>
																			<div class="col-md-6">
																				<label>Jumlah Mahasiswa Hadir</label><br>
																				<h3><b><?php echo $mhs_hadir; ?></b></h3>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
																				<label>Materi</label><br>
																				<h3><b><?php echo $materi; ?></b></h3>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
																				<label>Metode Pembelajaran</label><br>
																				<h3><b><?php echo $metode; ?></b></h3>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-12">
																				<label>Foto Bukti pertemuan</label><br>
																				<?php if($foto_pertemuan==""){ ?>
																					<p class="text-danger">Maaf foto bukti pertemuan belum tersedia..</p>
																				<?php }else{ ?>
																					<img width="100%" src="<?php echo base_url('templates/img/bukti-pertemuan/'.$foto_pertemuan)?>">
																				<?php } ?>
																			</div>
																		</div>


																	</div>
																	<div class="modal-footer">
																		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
																	</div>
																</form>
															</div>
														</div>
													</div>

												<?php
											endforeach;
											?>
												<!--END MODAL DETAIL -->

											<!-- ============ MODAL EDIT =============== -->
												<?php
													foreach($this->m_presensi_pertemuan->semuaDataPertemuan($id_jadwal_kelas_pertemuan)->result_array() as $i):
														$id_presensi_pertemuan=$i['id_presensi_pertemuan'];
														$waktu_pertemuan=$i['waktu_pertemuan'];
														$waktu_pertemuan_selesai=$i['waktu_pertemuan_selesai'];

														$tanggal_pertemuan_mulai = date('Y-m-d', strtotime($waktu_pertemuan));
														$jam_pertemuan_mulai = date('H:i', strtotime($waktu_pertemuan));

														$tanggal_pertemuan_selesai = date('Y-m-d', strtotime($waktu_pertemuan_selesai));
														$jam_pertemuan_selesai = date('H:i', strtotime($waktu_pertemuan_selesai));
														$waktu_input=$i['waktu_input'];
														$pertemuan_ke=$i['pertemuan_ke'];
														$kode_ruang=$i['kode_ruang'];
														$materi=$i['materi_pertemuan'];
														$metode=$i['metode_pertemuan'];
														$mhs_hadir=$i['mhs_hadir'];
														$foto_pertemuan=$i['foto_pertemuan'];
														$status_verifikasi=$i['status_verifikasi'];
														$cekbox =  explode(', ', $i['media_pertemuan']);



													?>

													<div class="modal fade" id="modalEdit<?php echo $id_presensi_pertemuan; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-secondary">
																	<h3 class="modal-title" id="myModalLabel">Edit Presensi Pertemuan</h3>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																</div>
																<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/edit_presensi'?>" enctype="multipart/form-data">
																	<div class="modal-body">
																		<div class="form-group">

																			<input type="hidden" name="id_presensi_pertemuan" value="<?php echo $id_presensi_pertemuan ?>" class="form-control">
																			<input type="hidden" name="foto_lama" value="<?php echo $foto_pertemuan ?>" class="form-control">



																			<div class="col-xs-8 form-group">
																				<div class="row">
																					<div class="col-md-6">
																						<label>PERTEMUAN KE-</label>
																						<input type="text" class="form-control" value="<?= $pertemuan_ke ?>" name="pertemuan_ke" readonly>
																					</div>
																					<div class="col-md-6">
																						<label>PELAPORAN OLEH </label>
																						<input  type="text" class="form-control" value="<?php echo $this->m_presensi_pertemuan->getNamaDosen($dosen_penginput_presensi); ?>" name="pertemuan_ke" readonly>
																					</div>

																				</div>
																			</div>

																			<div class="col-xs-8 form-group">
																				<div class="row">
																					<div class="col-md-6">
																						<label>TANGGAL MULAI</label>
																						<input type="date" name="tanggal_pertemuan" value="<?= $tanggal_pertemuan_mulai ?>" class="form-control" readonly>
																					</div>
																					<div class="col-md-6">
																						<label>JAM MULAI</label>
																						<input type="time" name="jam_pertemuan" value="<?= $jam_pertemuan_mulai ?>" class="form-control" readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-xs-8 form-group">
																				<div class="row">
																					<div class="col-md-6">
																						<label>TANGGAL SELESAI</label>
																						<input type="date" name="tanggal_pertemuan" value="<?= $tanggal_pertemuan_selesai ?>" class="form-control" readonly>
																					</div>
																					<div class="col-md-6">
																						<label>JAM SELESAI</label>
																						<input type="time" name="jam_pertemuan" value="<?= $jam_pertemuan_selesai ?>" class="form-control" readonly>
																					</div>
																				</div>
																			</div>


																			<div class="col-xs-8 form-group">
																				<div class="row">
																					<?php if($jenis_pertemuan=="Offline"){ ?>
																					<div class="col-md-6">
																						<label>RUANG</label>
																						<select name="kode_ruang" class="form-control" required>
																							<option value="">[Pilih]</option>
																							<?php foreach($combobox_ruang->result_array() as $i):
																								$kode_ruang_combo=$i['kode_ruang'];
																								// $kapasitas_combo=$i['kapasitas'];
																								$ket_combo=$i['ket'];
																							?>
																							<option value="<?php echo $kode_ruang_combo; ?>" <?php if($kode_ruang_combo==$kode_ruang){ echo 'selected'; } ?>><?php echo $kode_ruang_combo; if($ket_combo!=""){ echo '( '.$ket_combo.')';} ?></option>
																							<?php endforeach; ?>
																						</select>
																					</div>
																					<?php }else{ ?>
																					<div class="col-md-6">
																						<label>MEDIA</label><br>

																						<input type="checkbox" name="media[]" value="Google Classroom" <?php in_array('Google Classroom', $cekbox)? print 'checked' : ''; ?>> Google Classroom <br>
																		        		<input type="checkbox" name="media[]" value="Google Meet" <?php in_array('Google Meet', $cekbox)? print 'checked' : ''; ?>> Google Meet <br>
																		        		<input type="checkbox" name="media[]" value="Zoom" <?php in_array('Zoom', $cekbox)? print 'checked' : ''; ?>> Zoom <br>
																		        		<input type="checkbox" name="media[]" value="Cerdas UIR" <?php in_array('Cerdas UIR', $cekbox)? print 'checked' : ''; ?>> Cerdas UIR <br>
																		        		<input type="checkbox" name="media[]" value="Spada Dikti" <?php in_array('Spada Dikti', $cekbox)? print 'checked' : ''; ?>> Spada Dikti <br>
																		        		<input type="checkbox" name="media[]" value="Spada FT" <?php in_array('Spada FT', $cekbox)? print 'checked' : ''; ?>> Spada FT <br>
																					</div>
																					<?php } ?>
																					<div class="col-md-6">
																						<label>JUMLAH MAHASISWA HADIR</label>
																						<input type="number" name="mhs_hadir" value="<?= $mhs_hadir ?>" class="form-control" required>
																					</div>
																				</div>
																			</div>



																			<div class="col-xs-8 form-group">
																				<label>MATERI</label>
																				<textarea name="materi" class="form-control" required><?= $materi ?></textarea>
																			</div>

																			<div class="col-xs-8 form-group">
																				<label>METODE PEMBELAJARAN</label>
																				<textarea name="metode" class="form-control" required><?= $metode ?></textarea>
																			</div>

																			<div class="col-xs-8 form-group">
																				<label>FOTO BUKTI PERTEMUAN</label>
																				<?php if($foto_pertemuan==""){ ?>
																					<p class="text-danger">Maaf foto bukti pertemuan belum tersedia..</p>
																				<?php }else{ ?>
																					<img width="100%" src="<?php echo base_url('templates/img/bukti-pertemuan/'.$foto_pertemuan)?>">
																				<?php } ?>
																				<input type="file" name="foto_bukti_pertemuan" class="form-control" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG">
																			</div>

																		</div>
																	</div>
																	<div class="modal-footer">
																		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
																		<button class="btn btn-success" name="edit_presensi">Simpan</button>
																	</div>
																</form>
															</div>
														</div>
													</div>

												<?php
											endforeach;
											?>
											<!--END MODAL EDIT -->

											<!-- ============ MODAL HAPUS =============== -->
												<?php
													foreach($this->m_presensi_pertemuan->semuaDataPertemuan($id_jadwal_kelas_pertemuan)->result_array() as $i):
														$id_presensi_pertemuan=$i['id_presensi_pertemuan'];
														$waktu_pertemuan=$i['waktu_pertemuan'];
														$waktu_input=$i['waktu_input'];
														$pertemuan_ke=$i['pertemuan_ke'];
														$kode_ruang=$i['kode_ruang'];
														$materi=$i['materi_pertemuan'];
														$media=$i['media_pertemuan'];
														$mhs_hadir=$i['mhs_hadir'];
														$foto_pertemuan=$i['foto_pertemuan'];
														$status_verifikasi=$i['status_verifikasi'];



													?>

													<div class="modal fade" id="modalHapus<?php echo $id_presensi_pertemuan; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header bg-danger">
																	<h3 class="modal-title" id="myModalLabel">Hapus Presensi Pertemuan</h3>
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																</div>
																<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/hapus_presensi'?>" enctype="multipart/form-data">
																	<div class="modal-body">
																		<p>Apakah anda yakin menghapus presensi pertemuan ke <b><?php echo $pertemuan_ke; ?></b> ini?</p>

																	</div>
																	<div class="modal-footer">
																		<input type="hidden" name="id_presensi_pertemuan" value="<?php echo $id_presensi_pertemuan; ?>">
																		<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
																		<button class="btn btn-danger" name="hapus_presensi">Ya</button>
																	</div>
																</form>
															</div>
														</div>
													</div>

												<?php
											endforeach;
											?>
											<!--END MODAL HAPUS -->
												<td>
													<a class="btn btn-warning btn-sm inline" target="_BLANK" href="<?= base_url('dosen/presensi_pertemuan/cetak_laporan_pertemuan/'.$id_jadwal_kelas_pertemuan) ?>"> <i class="fas fa-print"></i> Cetak</a>
												</td>
											</tr>

										<?php
											$p8=false;
											endforeach;
										?>
										</tbody>
									</table>
								</div>


								<!-- ============ MODAL UPLOAD BUKTI FOTO =============== -->
								<?php
									foreach($data->result_array() as $i):
										$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
										$jenis_pertemuan = $i['jenis_pertemuan'];
										$waktu_pertemuan_pertama = $i['waktu_pertemuan_pertama'];
										$waktu_pertemuan_pertama_selesai = $i['waktu_pertemuan_pertama_selesai'];

										$nama_mk = $i['nama_mk'];
										$tahun_ajaran = $i['tahun_ajaran'];
										$semester = $i['semester'];

										$jadwalAwal = date('Y-m-d', strtotime($waktu_pertemuan_pertama));
										$jadwalAwalJam = date('H:i:s', strtotime($waktu_pertemuan_pertama));

										$jadwalAwal_selesai = date('Y-m-d', strtotime($waktu_pertemuan_pertama_selesai));
										$jadwalAwalJam_selesai = date('H:i:s', strtotime($waktu_pertemuan_pertama_selesai));

										for ($j=$pertemuan_awal; $j < $pertemuan_akhir ; $j++) {

											if((($j+1)%8)==0){
												if(($j+1)==8){
													$p8 = true;
													// $jadwalMulaiSetelahUTS = new DateTime('2021-12-11');
													$getTanggalSelesaiUjianUTS = $this->m_presensi_pertemuan->getTanggalSelesaiUjianUTS($id_pertemuan,'Ujian Tengah Semester');
													if($getTanggalSelesaiUjianUTS!=null){
														$jadwalMulaiSetelahUTS = date('Y-m-d', strtotime($getTanggalSelesaiUjianUTS));
														$jadwalMulaiSetelahUTS = new DateTime($jadwalMulaiSetelahUTS);
													}else{
														$jadwalMulaiSetelahUTS = '';
													}

													if($jadwalMulaiSetelahUTS!=null){
														while((new DateTime($jadwalAwal))<$jadwalMulaiSetelahUTS){
															$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));

														}
													}

									?>

									<?php
												}
											}
											// code...



									?>

									<!-- presensi -->
									<div class="modal fade" id="modalInputData<?php echo $id_jadwal_kelas_pertemuan.($j+1).$jadwalAwal.$jadwalAwalJam; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-success">
													<h3 class="modal-title" id="myModalLabel">Presensi Pertemuan</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/presensi'?>" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-group">
															<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?php echo $id_jadwal_kelas_pertemuan ?>">
															<input type="hidden" name="nama_mk" value="<?php echo $nama_mk ?>">
															<input type="hidden" name="semester" value="<?php echo $semester ?>">
															<input type="hidden" name="tahun_ajaran" value="<?php echo $tahun_ajaran ?>">

															<?php
																if($this->m_presensi_pertemuan->cekRequestPertemuanDisetujui($id_jadwal_kelas_pertemuan, ($j+1))->num_rows()>0){
																	$tgl_diaju_mulai = $this->m_presensi_pertemuan->ambilTanggalDiaju($id_jadwal_kelas_pertemuan, ($j+1));
																	$jm_diaju_mulai = $this->m_presensi_pertemuan->ambilJamDiaju($id_jadwal_kelas_pertemuan, ($j+1));
																	$tgl_diaju_selesai = $this->m_presensi_pertemuan->ambilTanggalDiajuSelesai($id_jadwal_kelas_pertemuan, ($j+1));
																	$jm_diaju_selesai = $this->m_presensi_pertemuan->ambilJamDiajuSelesai($id_jadwal_kelas_pertemuan, ($j+1));
																}else{
																	$tgl_diaju_mulai = $jadwalAwal;
																	$jm_diaju_mulai = $jadwalAwalJam;
																	$tgl_diaju_selesai = $jadwalAwal_selesai;
																	$jm_diaju_selesai = $jadwalAwalJam_selesai;
																}

																date_default_timezone_set('Asia/Jakarta');
															?>

															<div class="col-xs-8 form-group">
																<div class="row">
																	<div class="col-md-6">
																		<label>PERTEMUAN KE-</label>
																		<input type="text" class="form-control" value="<?= ($j+1) ?>" name="pertemuan_ke" readonly>
																	</div>
																	<div class="col-md-6">
																		<label>JENIS PERTEMUAN</label>
																		<input type="text" name="jenis_pertemuan" value="<?= $jenis_pertemuan ?>" class="form-control" readonly>
																	</div>
																</div>
															</div>

															<div class="col-xs-8 form-group">
																<div class="row">
																	<div class="col-md-6">
																		<label>TANGGAL MULAI</label>
																		<input type="date" name="tanggal_pertemuan_mulai" value="<?= date('Y-m-d') ?>" class="form-control" readonly>
																	</div>
																	<div class="col-md-6">
																		<label>JAM MULAI</label>
																		<input type="time" name="jam_pertemuan_mulai" value="<?= $jm_diaju_mulai ?>" class="form-control" readonly>
																	</div>
																</div>
															</div>
															<div class="col-xs-8 form-group">
																<div class="row">
																	<div class="col-md-6">
																		<label>TANGGAL SELESAI</label>
																		<input type="date" name="tanggal_pertemuan_selesai" value="<?= date('Y-m-d')  ?>" class="form-control" readonly>
																	</div>
																	<div class="col-md-6">
																		<label>JAM SELESAI</label>
																		<input type="time" name="jam_pertemuan_selesai" value="<?= $jm_diaju_selesai ?>" class="form-control" readonly>
																	</div>
																</div>
															</div>


															<div class="col-xs-8 form-group">
																<div class="row">
																	<?php if($jenis_pertemuan=="Offline"){ ?>
																	<div class="col-md-6">
																		<label>RUANG</label>
																		<select name="kode_ruang" class="form-control" required>
																			<option value="">[Pilih]</option>
																			<?php foreach($combobox_ruang->result_array() as $i):
																				$kode_ruang_combo=$i['kode_ruang'];
																				// $kapasitas_combo=$i['kapasitas'];
																				$ket_combo=$i['ket'];
																			?>
																			<option value="<?php echo $kode_ruang_combo; ?>"><?php echo $kode_ruang_combo; if($ket_combo!=""){ echo '( '.$ket_combo.')';} ?></option>
																			<?php endforeach; ?>
																		</select>
																	</div>
																	<input type="hidden" name="media[]" value="">
																	<?php }else{ ?>
																	<div class="col-md-6">
																		<label>MEDIA</label><br>

																		<input type="checkbox" name="media[]" value="Google Classroom"> Google Classroom <br>
														        		<input type="checkbox" name="media[]" value="Google Meet"> Google Meet <br>
														        		<input type="checkbox" name="media[]" value="Zoom"> Zoom <br>
														        		<input type="checkbox" name="media[]" value="Cerdas UIR"> Cerdas UIR <br>
														        		<input type="checkbox" name="media[]" value="Spada Dikti"> Spada Dikti <br>
														        		<input type="checkbox" name="media[]" value="Spada FT"> Spada FT <br>
																	</div>
																	<input type="hidden" name="kode_ruang" value="">
																	<?php } ?>
																	<div class="col-md-6">
																		<label>JUMLAH MAHASISWA HADIR</label>
																		<input type="number" name="mhs_hadir" class="form-control" required>
																	</div>
																</div>
															</div>

															<div class="col-xs-8 form-group">
																<label>METODE PEMBELAJARAN</label>
																<textarea name="metode" class="form-control" required></textarea>
															</div>

															<div class="col-xs-8 form-group">
																<label>MATERI</label>
																<textarea name="materi" class="form-control" required></textarea>
															</div>

															<div class="col-xs-8 form-group">
																<label>FOTO BUKTI PERTEMUAN</label>
																<input type="file" name="foto_bukti_pertemuan" class="form-control" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" required>
															</div>

														</div>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-success" name="presensi">Tanda Tangan dan Simpan</button>
													</div>
												</form>
											</div>
										</div>
									</div>



									<!-- ajukan jadwal pengganti -->
									<div class="modal fade" id="modalAjukanJadwalGanti<?php echo $id_jadwal_kelas_pertemuan.($j+1) ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-warning">
													<h3 class="modal-title" id="myModalLabel">Ajukan Jadwal Pengganti Pertemuan</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/ajukan_request_pertemuan'?>" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-group">

															<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?php echo $id_jadwal_kelas_pertemuan ?>" class="form-control">



															<div class="col-xs-8 form-group">
																<label>PERTEMUAN KE-</label>
																<input type="text" class="form-control" value="<?= ($j+1) ?>" name="pertemuan_ke" readonly>
															</div>

															<div class="col-xs-8 form-group">
																<div class="row">
																	<div class="col-md-6">
																		<label>TANGGAL PERTEMUAN</label>
																		<input type="date" name="tanggal_pertemuan" class="form-control" required>
																	</div>

																</div>
															</div>
															<div class="col-xs-8 form-group">
																<div class="row">
																	<div class="col-md-6">
																		<label>JAM PERTEMUAN MULAI</label>
																		<input type="time" name="jam_pertemuan_mulai" class="form-control" required>
																	</div>
																	<div class="col-md-6">
																		<label>JAM PERTEMUAN SELESAI</label>
																		<input type="time" name="jam_pertemuan_selesai" class="form-control" required>
																	</div>
																</div>
															</div>

															<div class="col-xs-8 form-group">
																<label>ALASAN PENGGANTIAN JADWAL</label>
																<textarea name="alasan" class="form-control" required></textarea>
															</div>

														</div>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-warning" name="ajukan">Ajukan</button>
													</div>
												</form>
											</div>
										</div>
									</div>





									<!-- alasan penolakan prodi -->
									<div class="modal fade" id="modalAlasanPenolakan<?php echo $id_jadwal_kelas_pertemuan.($j+1); ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<h3 class="modal-title" id="myModalLabel">Alasan Penolakan</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/presensi'?>" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-group">
															<?php
															 $alasan_penolakan = $this->m_presensi_pertemuan->ambilAlasan($id_jadwal_kelas_pertemuan, ($j+1));

															?>

															<div class="col-xs-8 form-group">
																<p class="text-danger"><?= $alasan_penolakan ?></p>
															</div>

														</div>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<!-- Hapus pengajuan -->
									<div class="modal fade" id="modalEditGantiJadwal<?php echo $id_jadwal_kelas_pertemuan.($j+1); ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header bg-danger">
													<h3 class="modal-title" id="myModalLabel">Batal Pegajuan Jadwal Ganti</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/presensi_pertemuan/batal_jadwal_ganti'?>" enctype="multipart/form-data">
													<div class="modal-body">
														<div class="form-group">
															<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?= $id_jadwal_kelas_pertemuan ?>">
															<input type="hidden" name="pertemuan_ke" value="<?= ($j+1) ?>">
															<p>Apakah anda yakin ingin membatalkan pengajuan jadwal ganti?</p>

														</div>
													</div>
													<div class="modal-footer">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-danger" name="batal_ajukan">Ya</button>
													</div>
												</form>
											</div>
										</div>
									</div>

								<?php


										if((($j+1)%8)!=0){
											$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
											$jadwalAwal_selesai = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal_selesai)));

											while($this->m_presensi_pertemuan->cekHariLibur($jadwalAwal, $jadwalAwalJam)==-1){
												$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
												$jadwalAwal_selesai = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal_selesai)));
											}
										}
									}

								 endforeach;

								 ?>
								<!--END MODAL UPLOAD BUKTI FOTO -->

								<?php }else{ ?>
									<h1 class="text-danger">Silahkan pilih pertemuan semester terlebih dahulu!</h1>
								<?php } ?>





								</div>
							</div>
						</div>
					</div>
				</div>


			</div>


<script type="text/javascript">
	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})
</script>

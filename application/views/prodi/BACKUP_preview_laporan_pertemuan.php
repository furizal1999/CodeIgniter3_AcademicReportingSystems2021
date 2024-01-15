
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PRESENSI PERTEMUAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
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
											<form action="<?php echo base_url('prodi/preview_laporan_pertemuan')?>" method="post">
												<div class="row">
													<div class="col-md-8">
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
													<div class="col-md-4">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label><br>
															<input type="submit" name="tombol_cari_tahun_ajaran" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
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
													<li>Silahkan klik sombol <i class="fas fa-dot-circle"></i>, <i class="fas fa-clock text-warning"></i>, <i class="fas fa-check-circle text-success"></i> dan <i class="fas fa-times-circle text-danger"></i> pada tabel dibawah untuk melihat detailnya!</li>
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
											<tr  class="bg-success">
												<td align="center"><b>NO</b></td>
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>DOSEN PENGAMPU</b></td>
												<td align="center"><b>NAMA MATKUL</b></td>
												<td align="center"><b>SKS</b></td>
												<td align="center"><b>KELAS</b></td>
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
											<tr  class="bg-success">
												<td align="center"><b>NO</b></td>
												<td align="center"><b>SEMESTER</b></td>
												<td align="center" width="500px"><b>DOSEN PENGAMPU</b></td>
												<td align="center"><b>NAMA MATKUL</b></td>
												<td align="center"><b>SKS</b></td>
												<td align="center"><b>KELAS</b></td>
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
												
												foreach($data->result_array() as $i):
													$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
													$jenis_pertemuan=$i['jenis_pertemuan'];
													$nama_mk=$i['nama_mk'];
													$dosen_pengampu = $i['dosen_pengampu'];
													$array_dosen = explode(', ', $dosen_pengampu);
													$semester = $i['semester'];
													$tahun_ajaran = $i['tahun_ajaran'];
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
												<td><?php echo $semester;?></td>
												<td>
													<?php 
														$index = 0;
														$array_dosen_hasil = array();

														foreach ($array_dosen as $npk) {
															$nama_dosen = $this->m_preview_laporan_pertemuan->getNamaDosen($npk);
															$array_dosen_hasil[$index++] = $nama_dosen;
														}

														echo $string_dosen_hasil = implode('/ ', $array_dosen_hasil)

													?>
													
												</td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo ($sks_teori+$sks_praktik);?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $dayList[date('D', strtotime($jadwalAwal))];?></td>
												<?php
													$index = 0;
													$cek_pertemuan_sebelumnya = false;
													for ($i=$pertemuan_awal; $i < $pertemuan_akhir; $i++){ 
														$baris = $this->m_preview_laporan_pertemuan->getDataPertemuan($id_jadwal_kelas_pertemuan, ($i+1))->row();
														if($baris){
															$id_presensi_pertemuan = $baris->id_presensi_pertemuan;
														}

														
														$yesterday = date('D', strtotime($jadwalAwal));



														if((($i+1)%8)==0){
															if(($i+1)==8){
												?>
															<td class="text-white bg-success"><?php echo 'UTS' ?></td>
												<?php
															}elseif(($i+1)==16){
												?>
															<td class="text-white bg-success"><?php echo 'UAS' ?></td>
												<?php
															}
														}
														elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_minta_verifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){
												?>
													<td align="center">

														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b><?php echo '<i class="fas fa-clock text-warning"></i>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

														    	<a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>
													
												<?php }elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_terverifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){ ?>
													<td align="center">
														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b><?php echo '<i class="fas fa-check-circle text-success"></i>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														  	<!-- isi -->
														     <a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>
												<?php }elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_ditolak($id_jadwal_kelas_pertemuan, ($i+1))>0){ ?>
													<td align="center">
														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b><?php echo '<i class="fas fa-times-circle text-danger"></i>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														  	
														    <a class="text-info dropdown-item" data-toggle="modal" data-target="#modalDetail<?php echo $id_presensi_pertemuan;?>"><i class="fas fa-book"></i>  Detail</a>
														  </div>
														</div>
													</td>
												<?php }else{ ?>
													<td align="center">
														<div class="dropdown">
														  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														  	<b><?php echo '<i class="fas fa-dot-circle text-dark"></i>';?></b>
														  </a>
														  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
														  	 <a class="text-danger dropdown-item"><i class="fas fa-exclamation"></i>  INFO : Masih Kosong! </a>
														  </div>
														</div>
													</td>

												<?php 
														}


														if((($i+1)%8)!=0){
															$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
															while($this->m_preview_laporan_pertemuan->cekHariLibur($jadwalAwal, $jadwalAwalJam)==-1){
																$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
															}
														}
														
													} 
												?>

													<td align="center">
														<div class="btn-group">
															<?php if($this->m_preview_laporan_pertemuan->cekTtdKetuaProdi($id_jadwal_kelas_pertemuan)<1){ ?>
																<a class="text-white btn btn-secondary btn-sm inline" target="_BLANK" data-toggle="modal" data-target="#modalTddProdi<?= $id_jadwal_kelas_pertemuan?>"> <i class="fas fa-pen"></i> Tandatangani</a>
															<?php } ?>
															<a class="btn btn-warning btn-sm inline" target="_BLANK" href="<?= base_url('prodi/preview_laporan_pertemuan/cetak_laporan_pertemuan/'.$id_jadwal_kelas_pertemuan) ?>"> <i class="fas fa-print"></i> Cetak</a>
														</div>
													</td>

												





												<!-- ============ MODAL DETAIL =============== -->
												<?php 
													foreach($this->m_preview_laporan_pertemuan->semuaDataPertemuan($id_jadwal_kelas_pertemuan)->result_array() as $i):
														$id_presensi_pertemuan=$i['id_presensi_pertemuan'];
														$waktu_pertemuan=$i['waktu_pertemuan'];
														$waktu_input=$i['waktu_input'];
														$pertemuan_ke=$i['pertemuan_ke'];
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
																<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/preview_laporan_pertemuan/presensi'?>" enctype="multipart/form-data">
																	<div class="modal-body">
																		<div class="row">
																			<div class="col-md-6">
																				<label>Pertemuan Ke</label><br>
																				<h3><b><?php echo $pertemuan_ke; ?></b></h3>
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

												<!-- MODAL TANDA TANGAN -->
												<div class="modal fade" id="modalTddProdi<?php echo $id_jadwal_kelas_pertemuan; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header bg-secondary">
																<h3 class="modal-title" id="myModalLabel">Tandatangan Digital</h3>
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
															</div>
															<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/preview_laporan_pertemuan/insertTdd'?>" enctype="multipart/form-data">
																<div class="modal-body">
																	<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?= $id_jadwal_kelas_pertemuan; ?>">
																	<input type="hidden" name="semester" value="<?= $semester; ?>">
																	<input type="hidden" name="tahun_ajaran" value="<?= $tahun_ajaran; ?>">
																	<input type="hidden" name="nama_mk" value="<?= $nama_mk; ?>">
																	<input type="hidden" name="nama_dosen" value="<?= $nama_dosen; ?>">

																	<p>Apakah anda yakin ingin menandatangani laporan ini secara digital?</p>
																</div>
																<div class="modal-footer">
																	<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
																	<button class="btn btn-secondary" name="ttdProdi">Tandatangani</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- END MODAL TANDA TANGAN -->

											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>



								<!-- ============ MODAL UPLOAD BUKTI FOTO =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
										$jenis_pertemuan = $i['jenis_pertemuan'];
										$waktu_pertemuan_pertama = $i['waktu_pertemuan_pertama'];


										$jadwalAwal = date('Y-m-d', strtotime($waktu_pertemuan_pertama));
										$jadwalAwalJam = date('H:i:s', strtotime($waktu_pertemuan_pertama));

										for ($j=$pertemuan_awal; $j < $pertemuan_akhir ; $j++) { 
											// code...
										
										
										
									?>

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
															 $alasan_penolakan = $this->m_preview_laporan_pertemuan->ambilAlasan($id_jadwal_kelas_pertemuan, ($j+1));

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

									
								
								<?php
										if((($j+1)%8)!=0){
											$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
											while($this->m_preview_laporan_pertemuan->cekHariLibur($jadwalAwal, $jadwalAwalJam)==-1){
												$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
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
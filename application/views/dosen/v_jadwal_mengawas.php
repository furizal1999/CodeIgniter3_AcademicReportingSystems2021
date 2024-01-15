	
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL MENGAWAS</h1>
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
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>TANGGAL</b></td>
												<td align="center"><b>JAM MULAI</b></td>
												<td align="center"><b>JAM SELESAI</b></td>												
												<td align="center"><b>NAMA MATAKULIAH</b></td>
												<td align="center"><b>KELAS</b></td>
												<td align="center"><b>RUANG</b></td>
												<td align="center"><b>STATUS</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
													$npk_pengawas1=$i['npk_pengawas1'];
													$npk_pengawas2=$i['npk_pengawas2'];
													$id_jadwal_ujian=$i['id_jadwal_ujian'];
													$nama_ujian=$i['nama_ujian'];
													$jenis_ujian=$i['ket_ujian'];
													$semester=$i['semester'];
													$kode_mk=$i['kode_matkul'];
													$tanggal_ujian=$i['tanggal_ujian'];
													$nama_kelas=$i['nama_kelas'];
													$jam_mulai=$i['jam_mulai'];
													$jam_selesai=$i['jam_selesai'];
													

													$row = $this->m_jadwal_mengawas->ambil_matkul($kode_mk);
													if(isset($row)){
														$nama_mk = $row->nama_mk;
													}
													else{
														$nama_mk = "Tidak ada";
													}

													$kode_ruang=$i['kode_ruang'];
													if($kode_ruang==""){
														$kode_ruang = "ONLINE";
													}
													
													$nama_kelas=$i['nama_kelas'];
													$jumlah_mahasiswa=$i['jumlah_mahasiswa'];

													$tanggal_absen_pengawas1=$i['tanggal_absen_pengawas1'];
													$tanggal_absen_pengawas2=$i['tanggal_absen_pengawas2'];
													$tanggal_submit_pengawas1=$i['tanggal_submit_pengawas1'];
													$tanggal_submit_pengawas2=$i['tanggal_submit_pengawas2'];

													$jam_absen_pengawas1=$i['jam_absen_pengawas1'];
													$jam_absen_pengawas2=$i['jam_absen_pengawas2'];
													$jam_submit_pengawas1=$i['jam_submit_pengawas1'];
													$jam_submit_pengawas2=$i['jam_submit_pengawas2'];
													$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
													$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];
													$jenis_soal=$i['jenis_soal'];
													$media=$i['media'];
													$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
													$ket_pelaksanaan=$i['ket_pelaksanaan'];
													if($_SESSION['npk']==$npk_pengawas1){
														$status_verifikasi_pengawas =$i['status_verifikasi_pengawas1'];
														$jam_submit = $jam_submit_pengawas1;
														
													}else{
														$status_verifikasi_pengawas =$i['status_verifikasi_pengawas2'];
														$jam_submit = $jam_submit_pengawas2;
													}
													
													// $status=$i['status'];
													
													// mengurangi menit
													if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
													$date = date_create($jam_mulai);
													date_add($date, date_interval_create_from_date_string('-15 minutes'));
													$coming = date_format($date, 'H:i:s');
													
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td class="text-primary"><?php echo $tanggal_ujian;?></td>
												<td class="text-primary"><?php echo $jam_mulai;?></td>
												<td class="text-primary"><?php echo $jam_selesai;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $kode_ruang;?></td>
												<td>
													<?php 
													
														if(strtotime($tanggal_ujian) <= strtotime(date('Y-m-d'))){
															if(date('H:i:s')<$jam_mulai && date('H:i:s')>=$coming){
																echo '<div class="button">Coming Soon</div>';
															}elseif(date('H:i:s')>=$jam_mulai && date('H:i:s')<=$jam_selesai){
																if($jam_submit=="00:00:00" && $status_verifikasi_pengawas==""){
																	echo '<div class="button text-danger">Ujian berlangsung</div>';
																}else{
																	if($jam_submit!="00:00:00" && $status_verifikasi_pengawas=="Minta Verifikasi"){
																		echo '<div class="text-secondary text-center">Sedang meminta verifikasi</div>';
																	}elseif($jam_submit!="00:00:00" && $status_verifikasi_pengawas=="Terverifikasi"){
																		echo '<div class="text-primary text-center">Terverifikasi</div>';
																	}else{
																		echo '<div class="text-danger text-center">Permintaan verifikasi ditolak</div>';
																	}
																}
														 	}elseif(date('H:i:s')<$coming){ 
																echo '<div class="text-warning text-center">Ujian belum mulai</div>';
															}
														}else{
															echo '<div class="text-warning text-center">Ujian belum mulai</div>';
														} 
													?>
												</td>
												<td style="width: 220px;" class="text-white">
													<?php 
															if((date('H:i:s')>=$jam_mulai && date('H:i:s')<=$jam_selesai) && strtotime($tanggal_ujian) == strtotime(date('Y-m-d'))){
																if($npk_pengawas1==$_SESSION['npk']){
																	if($tanggal_absen_pengawas1=="0000-00-00" && $jam_absen_pengawas1=="00:00:00"){
													?>
																				<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_absensi<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-user-check"></i> Presensi</a>
																				<!-- <label id="perintah" class="perintah text-danger bg-light" for="" > Gunakan SMARTPHONE untuk ABSEN </label> -->
													<?php 
																	}else{
																		if($jam_submit=="00:00:00"){
																			if($jenis_soal=="" && $media =="" && $jumlah_mahasiswa_hadir == "0" && $ket_pelaksanaan==""){
													?>
																				<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_input_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-plus"></i> Input Data</a>
													<?php
																			}else{
													?>
																				<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-pen"></i> Edit Data</a>
																				<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-trash"></i> Hapus Data</a>
													<?php
																				if($foto_bukti_pengawas1==""){
													?>
																				<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_upload_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-upload"></i> Upload Foto Bukti</a>
																				
													<?php
																				}else{
													?>
																				<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_ganti_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-exchange-alt"></i> Ganti Foto Bukti</a>
																				<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-trash"></i> Hapus Foto Bukti</a>

													<?php
																					if($jenis_soal != "" && $media != "" && $jumlah_mahasiswa_hadir != "0" && $ket_pelaksanaan != "" && $foto_bukti_pengawas1!=""){
													?>
																				<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_submit<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-check-circle"></i> Submit</a>
													<?php
																					}else{

																					}
																				}
																			}
																		}else{
																			if($status_verifikasi_pengawas !="Terverifikasi"){
													?>
																				<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_batal_submit<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-window-close"></i> Batal Submit</a>
													<?php
																			}
																		}
																	}
																}else{
																	if($tanggal_absen_pengawas2=="0000-00-00" && $jam_absen_pengawas2=="00:00:00"){
													?>
																				<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_absensi<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-user-check"></i> Presensi</a>
																				<!-- <label id="perintah" class="perintah text-danger bg-light" for="" style="display:none;"> Gunakan SMARTPHONE untuk ABSEN </label> -->
													<?php 
																	}else{
																		if($jam_submit=="00:00:00"){
																			if($jenis_soal=="" && $media =="" && $jumlah_mahasiswa_hadir == "0" && $ket_pelaksanaan==""){
													?>
																				<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_input_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-plus"></i> Input Data</a>
													<?php
																			}else{
													?>
																				<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-pen"></i> Edit Data</a>
																				<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_data<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-trash"></i> Hapus Data</a>
													<?php
																				if($foto_bukti_pengawas2==""){
													?>
																				<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_upload_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-upload"></i> Upload Foto Bukti</a>

													<?php
																				}else{
													?>
																				
																				<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_ganti_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-exchange-alt"></i> Ganti Foto Bukti</a>
																				<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_foto_bukti<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-trash"></i> Hapus Foto Bukti</a>
													<?php
																					if($jenis_soal != "" && $media != "" && $jumlah_mahasiswa_hadir != "0" && $ket_pelaksanaan != "" && $foto_bukti_pengawas2!=""){
													?>
																				<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_submit<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-check-circle"></i> Submit</a>
													<?php
																					}else{

																					}
																				}
																			}
																		}else{
																			if($status_verifikasi_pengawas !="Terverifikasi"){
													?>
																				<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_batal_submit<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-window-close"></i> Batal Submit</a>
													<?php
																			}
																		}
																	}
																}
															}
															
													?>
													<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-book"></i> Rincian</a>

												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>
								
								

								<!-- ============ MODAL UPLOAD BUKTI FOTO =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
										}else{
											$field = "foto_bukti_pengawas2";
										}
										$jenis_ujian=$i['ket_ujian'];
									?>
								<div class="modal fade" id="modal_upload_foto_bukti<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success">
											<h3 class="modal-title" id="myModalLabel">Upload Foto Bukti</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/upload_foto_bukti'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<label class="control-label col-xs-3" >SYARAT FOTO BUKTI</label>
													<?php if($jenis_ujian=="Offline"){?>
													<ol>
														<li><i class="text-danger">Ekstensi file : jpg / jpeg / png</i></li>
														<li>Gunakan Foto Selfi anda yang menampakkan peserta ujian (Ujian yang sedang berlangsung)</li>
														<li>Gunakan foto bukti yang tidak menimbulkan kerancuan, karena foto bukti akan menjadi pertimbangan prodi untuk melakukan verifikasi.</li>
														<li>Verifikasi berguna untuk menerbitkan Berita Acara anda</li>
													</ol>
													<?php }else{?>
													<ol>
														<li><i class="text-danger">Ekstensi file : jpg / jpeg / png</i></li>
														<li><i class="text-danger">Pastikan tidak terdapat tanda titik pada nama file gambar</i></li>
														<li>Gunakan SCREENSHOOT layar komputer anda (Ujian yang sedang berlangsung)</li>
														<li>Gunakan foto bukti yang tidak menimbulkan kerancuan, karena foto bukti akan menjadi pertimbangan prodi untuk melakukan verifikasi.</li>
														<li>Verifikasi berguna untuk menerbitkan Berita Acara anda</li>
													</ol>
													<?php }?>
													<div class="col-xs-8">
														<input type="file" name="gambar" class="border-secondary text-dark" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" required>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field" value="<?php echo $field;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-success">Upload Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL UPLOAD BUKTI FOTO -->


								<!-- ============ MODAL GANTI BUKTI FOTO =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}
									?>
								<div class="modal fade" id="modal_ganti_foto_bukti<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning">
											<h3 class="modal-title" id="myModalLabel">Ganti Foto Bukti</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/ganti_foto_bukti'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<img src="<?php echo base_url('templates/img/bukti-mengawas/'),$foto_bukti?>" alt="foto bukti" width="100%">
												</div>
												<div class="form-group">
													<label class="control-label col-xs-3" >FOTO BUKTI <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i><br><i class="text-danger">1. Pastikan tidak terdapat tanda titik pada nama file gambar</i></label>
													<div class="col-xs-8">
														<input type="file" name="gambar" class="border-secondary text-dark" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" required>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field" value="<?php echo $field;?>">
												<input type="hidden" name="fotolama" value="<?php echo $foto_bukti;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-warning">Ganti Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL GANTI BUKTI FOTO -->

								<!-- ============ MODAL HAPUS BUKTI FOTO =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}
									?>
								<div class="modal fade" id="modal_hapus_foto_bukti<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger">
											<h3 class="modal-title" id="myModalLabel">Hapus Foto Bukti</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/hapus_foto_bukti'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<p>Anda yakin ingin menghapus foto bukti mengawas ini?</p>
												<div class="form-group">
													<img src="<?php echo base_url('templates/img/bukti-mengawas/'),$foto_bukti?>" alt="foto bukti" width="100%">
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field" value="<?php echo $field;?>">
												<input type="hidden" name="fotolama" value="<?php echo $foto_bukti;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-danger">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL HAPUS BUKTI FOTO -->


								<!-- ============ MODAL INPUT DATA =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}
									?>
								<div class="modal fade" id="modal_input_data<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success">
											<h3 class="modal-title" id="myModalLabel">Input Data</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/input_data'?>" enctype="multipart/form-data">
											<div class="modal-body">
												
												<div class="form-group">
													<label>Jenis Soal</label>
													<select name="jenis_soal" class="form-control" required>
														<option value="">--Pilih--</option>
														<option value="Tugas">Tugas</option>
														<option value="Take Home">Take Home</option>
														<option value="Pemberian Soal Langsung">Pemberian Soal Langsung</option>
													</select>
												</div>
												<div class="form-group">
													<label>Media yang Digunakan</label><br>
														<input type="checkbox" name="media[]" value="Google Classroom"> Google Classroom <br>
										        		<input type="checkbox" name="media[]" value="Google Meet"> Google Meet <br>
										        		<input type="checkbox" name="media[]" value="Zoom"> Zoom <br>
										        		<input type="checkbox" name="media[]" value="Cerdas UIR"> Cerdas UIR <br>
										        		<input type="checkbox" name="media[]" value="Spada Dikti"> Spada Dikti <br>
										        		<input type="checkbox" name="media[]" value="Spada FT"> Spada FT <br>
										        		<input type="checkbox" name="media[]" value="Kertas"> Kertas (Khusus offline) <br>
												</div>

												<div class="form-group">
													<label>Jumlah Peserta Hadir</label>
													<input name="jumlah_peserta_hadir" type="number" class="form-control" required>
												</div>

												<div class="form-group">
													<label>Keterangan Ujian</label>
													<select name="ket_pelaksanaan" class="form-control" required>
														<option value="">--Pilih--</option>
														<option value="Aman dan Lancar">Aman dan Lancar</option>
														<option value="Ada Kendala">Ada Kendala</option>
													</select>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
												<button class="btn btn-success">Simpan</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL INPUT DATA -->

								<!-- ============ MODAL EDIT DATA =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}

										$jenis_soal=$i['jenis_soal'];
										$cekbox =  explode(', ', $i['media']);
										$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
										$ket_pelaksanaan=$i['ket_pelaksanaan'];
									?>
								<div class="modal fade" id="modal_edit_data<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary">
											<h3 class="modal-title" id="myModalLabel">Input Data</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/input_data'?>" enctype="multipart/form-data">
											<div class="modal-body">
												
												<div class="form-group">
													<label>Jenis Soal</label>
													<select name="jenis_soal" class="form-control" required>
														<option value="" <?php if($jenis_soal==""){ echo 'selected';}?>>--Pilih--</option>
														<option value="Tugas" <?php if($jenis_soal=="Tugas"){ echo 'selected';}?>>Tugas</option>
														<option value="Take Home"<?php if($jenis_soal=="Take Home"){ echo 'selected';}?>>Take Home</option>
														<option value="Pemberian Soal Langsung"<?php if($jenis_soal=="Pemberian Soal Langsung"){ echo 'selected';}?>>Pemberian Soal Langsung</option>
													</select>
												</div>
												<div class="form-group">
													<label>Media yang Digunakan</label><br>
														<input type="checkbox" name="media[]" value="Google Classroom" <?php in_array('Google Classroom', $cekbox)? print 'checked' : ''; ?>> Google Classroom <br>
										        		<input type="checkbox" name="media[]" value="Google Meet" <?php in_array('Google Meet', $cekbox)? print 'checked' : ''; ?>> Google Meet <br>
										        		<input type="checkbox" name="media[]" value="Zoom" <?php in_array('Zoom', $cekbox)? print 'checked' : ''; ?>> Zoom <br>
										        		<input type="checkbox" name="media[]" value="Cerdas UIR" <?php in_array('Cerdas UIR', $cekbox)? print 'checked' : ''; ?>> Cerdas UIR <br>
										        		<input type="checkbox" name="media[]" value="Spada Dikti" <?php in_array('Spada Dikti', $cekbox)? print 'checked' : ''; ?>> Spada Dikti <br>
										        		<input type="checkbox" name="media[]" value="Spada FT" <?php in_array('Spada FT', $cekbox)? print 'checked' : ''; ?>> Spada FT <br>
										        		<input type="checkbox" name="media[]" value="Kertas" <?php in_array('Kertas', $cekbox)? print 'checked' : ''; ?>> Kertas (Khusus offline) <br>
												</div>

												<div class="form-group">
													<label>Jumlah Peserta Hadir</label>
													<input name="jumlah_peserta_hadir" type="number" class="form-control" value="<?php echo $jumlah_mahasiswa_hadir?>" required>
												</div>

												<div class="form-group">
													<label>Keterangan Ujian</label>
													<select name="ket_pelaksanaan" class="form-control" required>
														<option value=""<?php if($ket_pelaksanaan==""){ echo 'selected';}?>>--Pilih--</option>
														<option value="Aman dan Lancar" <?php if($ket_pelaksanaan=="Aman dan Lancar"){ echo 'selected';}?>>Aman dan Lancar</option>
														<option value="Ada Kendala" <?php if($ket_pelaksanaan=="Ada Kendala"){ echo 'selected';}?>>Ada Kendala</option>
													</select>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
												<button class="btn btn-secondary">Simpan</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL EDIT DATA -->

								<!-- ============ MODAL EDIT DATA =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];								

									?>
								<div class="modal fade" id="modal_hapus_data<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger">
											<h3 class="modal-title" id="myModalLabel">Hapus Data</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/hapus_data'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<p>Apakah anda yakin menghapus data yang telah diinput?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-danger">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL EDIT DATA -->


								<!-- ============ MODAL SUBMIT =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];						
										$jam_submit = date('H:i:s');
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field_jam_submit = "jam_submit_pengawas1";
											$field_tanggal_submit = "tanggal_submit_pengawas1";
											$field = "status_verifikasi_pengawas1";
											
										}else{
											$field_jam_submit = "jam_submit_pengawas2";
											$field_tanggal_submit = "tanggal_submit_pengawas2";

											$field = "status_verifikasi_pengawas2";
											
										}

									?>
								<div class="modal fade" id="modal_submit<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-primary">
											<h3 class="modal-title" id="myModalLabel">Submit</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/submit'?>">
											<div class="modal-body">
												<p>Lakukan submit sekarang ?</p>
												<p>ket : setelah melakukan submit, maka semua informasi yang telah diinputkan akan dapat dilihat oleh prodi!</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field_tanggal_submit" value="<?php echo $field_tanggal_submit;?>">
												<input type="hidden" name="field_jam_submit" value="<?php echo $field_jam_submit;?>">
												<input type="hidden" name="field" value="<?php echo $field;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-primary">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL SUBMIT -->

								<!-- ============ MODAL BATAL SUBMIT =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "status_verifikasi_pengawas1";
											$field_jam_submit = "jam_submit_pengawas1";
											$field_tanggal_submit = "tanggal_submit_pengawas1";
										}else{
											$field = "status_verifikasi_pengawas2";
											$field_jam_submit = "jam_submit_pengawas2";
											$field_tanggal_submit = "tanggal_submit_pengawas2";
										}

									?>
								<div class="modal fade" id="modal_batal_submit<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning">
											<h3 class="modal-title" id="myModalLabel">Batal Submit</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/batal_submit'?>">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan submit?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field" value="<?php echo $field;?>">
												<input type="hidden" name="field_tanggal_submit" value="<?php echo $field_tanggal_submit;?>">
												<input type="hidden" name="field_jam_submit" value="<?php echo $field_jam_submit;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL BATAL SUBMIT -->

								<!-- ============ MODAL DETAIL =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$id_jadwal_ujian=$i['id_jadwal_ujian'];
										$nama_ujian=$i['nama_ujian'];
										$jenis_ujian=$i['ket_ujian'];
										$semester=$i['semester'];
										$kode_mk=$i['kode_matkul'];
										$row = $this->m_jadwal_mengawas->ambil_matkul($kode_mk);
										if(isset($row)){
											$nama_mk = $row->nama_mk;
										}
										else{
											$nama_mk = "Tidak ada";
										}

										$row = $this->m_jadwal_mengawas->ambil_dosen1($npk_pengawas1);
										if(isset($row)){
											$nama_dosen1 = $row->nama_dosen;
										}
										else{
											$nama_dosen1 ="Tidak ada";
										}

										$row = $this->m_jadwal_mengawas->ambil_dosen2($npk_pengawas2);
										if(isset($row)){
											$nama_dosen2 = $row->nama_dosen;
										}
										else{
											$nama_dosen2 ="Tidak ada";
										}

										$tanggal_ujian=$i['tanggal_ujian'];
										$jam_mulai=$i['jam_mulai'];
										$jam_selesai=$i['jam_selesai'];
										

										$kode_ruang=$i['kode_ruang'];
										if($kode_ruang==""){
											$kode_ruang = "ONLINE";
										}

										$nama_kelas=$i['nama_kelas'];
										$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
										$tanggal_absen_pengawas1=$i['tanggal_absen_pengawas1'];
										$tanggal_absen_pengawas2=$i['tanggal_absen_pengawas2'];
										$tanggal_submit_pengawas1=$i['tanggal_submit_pengawas1'];
										$tanggal_submit_pengawas2=$i['tanggal_submit_pengawas2'];

										$jam_absen_pengawas1=$i['jam_absen_pengawas1'];
										$jam_absen_pengawas2=$i['jam_absen_pengawas2'];
										$jam_submit_pengawas1=$i['jam_submit_pengawas1'];
										$jam_submit_pengawas2=$i['jam_submit_pengawas2'];
										if($_SESSION['npk']==$npk_pengawas1){
											$jam_submit = $jam_submit_pengawas1;
											
										}else{
											$jam_submit = $jam_submit_pengawas2;
										}
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];
										$jenis_soal=$i['jenis_soal'];
										$media=$i['media'];
										$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
										$ket_pelaksanaan=$i['ket_pelaksanaan'];
										
										// $status=$i['status'];

									?>
									<div class="modal fade" id="modal_detail<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Ujian</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/batal_submit'?>">
											<div class="modal-body">
												<table class="table">
													<?php if($_SESSION['npk']==$npk_pengawas1){?>
														<tr class="text-primary">
															<td>Waktu Hadir Anda</td>
															<td>:</td>
															<td>
																<ul>
																	<li>Tanggal : <?php if($tanggal_absen_pengawas1=="0000-00-00" && $jam_absen_pengawas1=="00:00:00"){ echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $tanggal_absen_pengawas1;  } ?></li>
																	<li>Jam : <?php if($tanggal_absen_pengawas1=="0000-00-00" && $jam_absen_pengawas1=="00:00:00"){  echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $jam_absen_pengawas1; } ?></li>
																</ul>
															</td>
														</tr>
														<tr class="text-primary">
															<td>Waktu Submit Anda</td>
															<td>:</td>
															<td>
																<ul>
																	<li>Tanggal : <?php if($tanggal_submit_pengawas1=="0000-00-00" && $jam_submit_pengawas1=="00:00:00"){ echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $tanggal_submit_pengawas1;  } ?></li>
																	<li>Jam : <?php if($tanggal_submit_pengawas1=="0000-00-00" && $jam_submit_pengawas1=="00:00:00"){  echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $jam_submit_pengawas1; } ?></li>
																</ul>
															</td>
														</tr>
													<?php }else{?>
														<tr class="text-primary">
															<td>Waktu Hadir Anda</td>
															<td>:</td>
															<td>
																<ul>
																	<li>Tanggal : <?php if($tanggal_absen_pengawas2=="0000-00-00" && $jam_absen_pengawas2=="00:00:00"){ echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $tanggal_absen_pengawas2;  } ?></li>
																	<li>Jam : <?php if($tanggal_absen_pengawas2=="0000-00-00" && $jam_absen_pengawas2=="00:00:00"){  echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $jam_absen_pengawas2; } ?></li>
																</ul>
															</td>
														</tr>
														<tr class="text-primary">
															<td>Waktu Submit Anda</td>
															<td>:</td>
															<td>
																<ul>
																	<li>Tanggal : <?php if($tanggal_submit_pengawas2=="0000-00-00" && $jam_submit_pengawas2=="00:00:00"){ echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $tanggal_submit_pengawas2;  } ?></li>
																	<li>Jam : <?php if($tanggal_submit_pengawas2=="0000-00-00" && $jam_submit_pengawas2=="00:00:00"){  echo "<div class='text-danger'>Belum tersedia</div>"; }else{ echo $jam_submit_pengawas2; } ?></li>
																</ul>
															</td>
														</tr>
													<?php }?>

													<tr>
														<td>Matakuliah</td>
														<td>:</td>
														<td><?php echo $nama_mk?></td>
													</tr>
													<tr>
														<td>Nama Pengawas 1</td>
														<td>:</td>
														<td><?php echo $nama_dosen1?></td>
													</tr>
													<tr>
														<td>Nama Pengawas 2</td>
														<td>:</td>
														<td><?php echo $nama_dosen2?></td>
													</tr>
													<tr>
														<td>Kode Ruang</td>
														<td>:</td>
														<td><?php echo $kode_ruang?></td>
													</tr>
													<tr>
														<td>Nama Kelas</td>
														<td>:</td>
														<td><?php echo $nama_kelas?></td>
													</tr>
													<tr>
														<td>Total Mahasiswa</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa?></td>
													</tr>
													
													<tr>
														<td colspan="3"><b>Data yang diinpukan pengawas</b></td>
													</tr>
													<tr>
														<td>Jenis Soal</td>
														<td>:</td>
														<td><?php echo $jenis_soal?></td>
													</tr>
													<tr>
														<td>Media</td>
														<td>:</td>
														<td><?php echo $media?></td>
													</tr>
													<tr>
														<td>Jumlah Mahasiswa Hadir</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa_hadir?></td>
													</tr>
													<tr>
														<td>Jumlah Mahasiwa Alfa</td>
														<td>:</td>
														<td><?php echo max(($jumlah_mahasiswa-$jumlah_mahasiswa_hadir),0)?></td>
													</tr>
													<tr>
														<td>Hasil Pelaksanaan</td>
														<td>:</td>
														<td><?php echo $ket_pelaksanaan?></td>
													</tr>
													<tr>
														<td colspan="3">Foto Bukti Mengawas</td>
													</tr>
													<?php
													 	if($_SESSION['npk']==$npk_pengawas1){
															 if($foto_bukti_pengawas1==""){
													?>
														<tr>
															<td colspan="3"><p class="text-danger">Maaf, Foto bukti belum tersedia!</p></td>
														</tr>
													<?php
															 }else{
													?>
														<tr>
															<td colspan="3"><img width="100%" src="<?php echo base_url('templates/img/bukti-mengawas/').$foto_bukti_pengawas1?>" alt=""></td>
														</tr>
													<?php
															 }
													 	}else{
															if($foto_bukti_pengawas1==""){
													?>
														<tr>
															<td colspan="3"><p class="text-danger">Maaf, Foto bukti belum tersedia!</p></td>
														</tr>
													<?php
															}else{
													?>
														<tr>
															<td colspan="3"><img width="100%" src="<?php echo base_url('templates/img/bukti-mengawas/').$foto_bukti_pengawas2?>" alt=""></td>
														</tr>
													<?php
															}
													
													}?>
													

												</table>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</form>
										</div>
										</div>
									</div>

								<?php endforeach;?>
								<!--END MODAL DETAIL-->

								<!-- ============ MODAL ABSENSI =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										if($_SESSION['npk']==$npk_pengawas1){
											$field_jam_absen = "jam_absen_pengawas1";
											$field_tanggal_absen = "tanggal_absen_pengawas1";
											$field_latitude = "latitude_pengawas1";
											$field_longitude = "longitude_pengawas1";
										}
										else{
											$field_jam_absen = "jam_absen_pengawas2";
											$field_tanggal_absen = "tanggal_absen_pengawas2";
											$field_latitude = "latitude_pengawas2";
											$field_longitude = "longitude_pengawas2";
										}
									?>
								<div class="modal fade" id="modal_absensi<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-primary">
											<h3 class="modal-title" id="myModalLabel">Presensi</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/absensi'?>">
											<div class="modal-body">
												<p>Lakukan presensi sekarang ?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" id="id_jadwal_lanjutan" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" id="field_tanggal_absen" name="field_tanggal_absen" value="<?php echo $field_tanggal_absen;?>">
												<input type="hidden" id="field_jam_absen" name="field_jam_absen" value="<?php echo $field_jam_absen;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-primary">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL ABSENSI -->


								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>



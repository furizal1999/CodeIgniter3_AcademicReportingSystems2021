<!-- ============ MODAL DETAIL 2 =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$id_jadwal=$i['id_jadwal'];
										$nama_ujian=$i['nama_ujian'];
										$jenis_ujian=$i['jenis_ujian'];
										$semester=$i['semester'];
										$kode_mk=$i['kode_matkul'];
										$row = $this->m_permintaan_verifikasi->ambil_matkul($kode_mk);
										if(isset($row)){
											$nama_mk = $row->nama_mk;
										}
										else{
											$nama_mk = "Tidak diketahui";
										}

										$row = $this->m_permintaan_verifikasi->ambil_dosen1($npk_pengawas1);
										if(isset($row)){
											$nama_dosen1 = $row->nama_dosen;
										}
										else{
											$nama_dosen1 ="Tidak diketahui";
										}

										$row = $this->m_permintaan_verifikasi->ambil_dosen2($npk_pengawas2);
										if(isset($row)){
											$nama_dosen2 = $row->nama_dosen;
										}
										else{
											$nama_dosen2 ="Tidak diketahui";
										}

										$tanggal_ujian=$i['tanggal_ujian'];
										$jam_mulai=$i['jam_mulai'];
										$jam_selesai=$i['jam_selesai'];
										$ket=$i['ket'];

										$kode_ruang=$i['kode_ruang'];
										if($kode_ruang==""){
											$kode_ruang = "ONLINE";
										}

										$nama_kelas=$i['nama_kelas'];
										$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
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
										
										// $status=$i['status'];

									?>
									<div class="modal fade" id="modal_detail_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/permintaan_verifikasi/batal_submit'?>">
											<div class="modal-body">
												<table class="table">
													<tr>
														<td colspan="3" class="text-center bg-warning"><h1><?php echo $nama_dosen2?></h1></td>
													</tr>
													
													<tr class="text-primary">
														<td>Jam hadir mengawas</td>
														<td>:</td>
														<td><?php echo $jam_absen_pengawas2?></td>
													</tr>
													<tr class="text-primary">
														<td>Jam submit</td>
														<td>:</td>
														<td><?php echo $jam_submit_pengawas2?></td>
													</tr>
												
													<tr>
														<td>Matakuliah</td>
														<td>:</td>
														<td><?php echo $nama_mk?></td>
													</tr>
													<tr>
														<td>Kode ruang</td>
														<td>:</td>
														<td><?php echo $kode_ruang?></td>
													</tr>
													<tr>
														<td>Nama kelas</td>
														<td>:</td>
														<td><?php echo $nama_kelas?></td>
													</tr>
													<tr>
														<td>Total mahasiswa</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa?> orang</td>
													</tr>
													
													<tr>
														<td colspan="3"><b>Data yang diinpukan pengawas</b></td>
													</tr>
													<tr>
														<td>Jenis soal</td>
														<td>:</td>
														<td><?php echo $jenis_soal?></td>
													</tr>
													<tr>
														<td>Media</td>
														<td>:</td>
														<td><?php echo $media?></td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa hadir</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa_hadir?> orang</td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa alfa</td>
														<td>:</td>
														<td><?php echo ($jumlah_mahasiswa-$jumlah_mahasiswa_hadir)?> orang</td>
													</tr>
													<tr>
														<td>Hasil pelaksanaan</td>
														<td>:</td>
														<td><?php echo $ket_pelaksanaan?></td>
													</tr>
													<tr>
														<td colspan="3">Foto bukti mengawas</td>
													</tr>
													<?php
															 if($foto_bukti_pengawas2==""){
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
													?>											

												</table>
											</div>
											<div class="modal-footer">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<!--END MODAL DETAIL 2-->

								<!-- ============ MODAL DETAIL 1 =============== -->
								
									<!-- <div class="modal fade" id="modal_detail_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/permintaan_verifikasi/batal_submit'?>">
											<div class="modal-body">
												<table class="table">
													<tr>
														<td colspan="3" class="text-center bg-warning"><h1><?php echo $nama_dosen1?></h1></td>
													</tr>
													
													<tr class="text-primary">
														<td>Jam hadir mengawas</td>
														<td>:</td>
														<td><?php echo $jam_absen_pengawas1?></td>
													</tr>
													<tr class="text-primary">
														<td>Jam submit</td>
														<td>:</td>
														<td><?php echo $jam_submit_pengawas1?></td>
													</tr>
												
													<tr>
														<td>Matakuliah</td>
														<td>:</td>
														<td><?php echo $nama_mk?></td>
													</tr>
													<tr>
														<td>Kode ruang</td>
														<td>:</td>
														<td><?php echo $kode_ruang?></td>
													</tr>
													<tr>
														<td>Nama kelas</td>
														<td>:</td>
														<td><?php echo $nama_kelas?></td>
													</tr>
													<tr>
														<td>Total mahasiswa</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa?> orang</td>
													</tr>
													
													<tr>
														<td colspan="3"><b>Data yang diinpukan pengawas</b></td>
													</tr>
													<tr>
														<td>Jenis soal</td>
														<td>:</td>
														<td><?php echo $jenis_soal?></td>
													</tr>
													<tr>
														<td>Media</td>
														<td>:</td>
														<td><?php echo $media?></td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa hadir</td>
														<td>:</td>
														<td><?php echo $jumlah_mahasiswa_hadir?> orang</td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa alfa</td>
														<td>:</td>
														<td><?php echo ($jumlah_mahasiswa-$jumlah_mahasiswa_hadir)?> orang</td>
													</tr>
													<tr>
														<td>Hasil pelaksanaan</td>
														<td>:</td>
														<td><?php echo $ket_pelaksanaan?></td>
													</tr>
													<tr>
														<td colspan="3">Foto bukti mengawas</td>
													</tr>
													<?php
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
													?>
													
												</table>
											</div>
											<div class="modal-footer">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END MODAL DETAIL 1-->

								<!-- ============ verifikasi 1 =============== -->
							
									<!-- <div class="modal fade" id="modal_verifikasi_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success text-white">
											<h3 class="modal-title" id="myModalLabel">Verifikasi Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/verifikasi1'?>">
											<div class="modal-body">
												<p>Apakah anda yakin memverifikasi bukti yang telah dimasukkan?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END verifikasi 1-->

								<!-- ============ verifikasi 2 =============== -->
								
									<div class="modal fade" id="modal_verifikasi_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success text-white">
											<h3 class="modal-title" id="myModalLabel">Verifikasi Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/verifikasi2'?>">
											<div class="modal-body">
												<p>Apakah anda yakin memverifikasi bukti yang telah dimasukkan?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>

								<!--END verifikasi 2-->

								<!-- ============ tolak 1 =============== -->
					
									<!-- <div class="modal fade" id="modal_tolak_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger text-white">
											<h3 class="modal-title" id="myModalLabel">Tolak Bukti Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/tolak_pengawas1'?>">
											<div class="modal-body">
												<p>Apakah anda yakin menolak bukti yang telah dimasukkan?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-danger">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END tolak 1-->

								<!-- ============ tolak 2 =============== -->
					
									<div class="modal fade" id="modal_tolak_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger text-white">
											<h3 class="modal-title" id="myModalLabel">Tolak Bukti Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/tolak_pengawas2'?>">
											<div class="modal-body">
												<p>Apakah anda yakin menolak bukti yang telah dimasukkan?</p>
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
								<!--END tolak 2-->

								<!-- ============ batal verifikasi 1 =============== -->
							
									<!-- <div class="modal fade" id="modal_batal_verifikasi_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Verifikasi Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/batal_verifikasi_pengawas1'?>">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan verifikasi?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END batal verifikasi 1-->

								<!-- ============ batal verifikasi 2 =============== -->
								
									<div class="modal fade" id="modal_batal_verifikasi_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Verifikasi Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/batal_verifikasi_pengawas2'?>">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan verifikasi?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<!--END batal verifikasi 2-->


								<!-- ============ batal tolak 1 =============== -->
							
									<!-- <div class="modal fade" id="modal_batal_tolak_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/batal_tolak_pengawas1'?>">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan penolakan berkas?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END batal tolak 1-->

								<!-- ============ batal tolak 2 =============== -->
								
									<div class="modal fade" id="modal_batal_tolak_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/batal_tolak_pengawas2'?>">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan penolakan berkas?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<!--END batal tolak 2-->


								<!-- ============ EDIT 1 =============== -->
								
									<!-- <div class="modal fade" id="modal_edit_pengawas1<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary text-white">
											<h3 class="modal-title" id="myModalLabel">Edit Data Mengawas</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/edit_pengawas1'?>" enctype="multipart/form-data">
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
													<label>Media yang Digunakan</label>
													<input name="media" type="text" class="form-control" value="<?php echo $media?>" required>
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
												<div class="form-group">
													<label class="control-label col-xs-3" >FOTO BUKTI <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i></label>
													<div class="col-xs-8">
														<input type="file" name="gambar" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" class="border-secondary text-dark">
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="foto_bukti_pengawas1" value="<?php echo $foto_bukti_pengawas1?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Simpan Perubahan dan Verifikasi</button>
											</div>
										</form>
										</div>
										</div>
									</div> -->
								<!--END EDIT 1-->

								<!-- ============ EDIT 2 =============== -->
								
									<div class="modal fade" id="modal_edit_pengawas2<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary text-white">
											<h3 class="modal-title" id="myModalLabel">Edit Data Mengawas</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/permintaan_verifikasi/edit_pengawas2'?>" enctype="multipart/form-data">
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
													<label>Media yang Digunakan</label>
													<input name="media" type="text" class="form-control" value="<?php echo $media?>" required>
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
												<div class="form-group">
													<label class="control-label col-xs-3" >FOTO BUKTI <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i></label>
													<div class="col-xs-8">
														<input type="file" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" name="gambar" class="border-secondary text-dark">
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="foto_bukti_pengawas2" value="<?php echo $foto_bukti_pengawas2?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Simpan Perubahan dan Verifikasi</button>
											</div>
										</form>
										</div>
										</div>
									</div>

								<?php endforeach;?>
								<!--END EDIT 2-->
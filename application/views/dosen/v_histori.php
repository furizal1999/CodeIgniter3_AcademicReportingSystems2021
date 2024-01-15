	
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">HISTORI MENGAWAS</h1>
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
									<p class="text-danger">Catatan :</p>
									<ol>
										<li>
											Tombol <b>EDIT</b> tersedia hanya pada hari ujian dilaksanakan
										</li>
										<li>
											atau pengajuan keterlambatan diterima oleh prodi untuk yang mengajukan pengajuan keterlambatan (setelah hari ujian berakhir)
										</li>
									</ol>
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NO</b></td>
												<td align="center"><b>TANGGAL</b></td>
												<td align="center"><b>JAM MULAI</b></td>
												<td align="center"><b>JAM SELESAI</b></td>												
												<td align="center"><b>NAMA MATAKULIAH</b></td>
												<td align="center"><b>RUANG</b></td>
												<td align="center"><b>KELAS</b></td>
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
													$jam_mulai=$i['jam_mulai'];
													$jam_selesai=$i['jam_selesai'];
													

													$row = $this->m_jadwal_mengawas->ambil_matkul($kode_mk);
													if(isset($row)){
														$nama_mk = $row->nama_mk;
													}
													else{
														$nama_mk = "Tidak ada";
													}

													

													if($jenis_ujian=="Daring"){
														$kode_ruang = "ONLINE";
													}else{
														$kode_ruang=$i['kode_ruang'];
														if($kode_ruang==''){
															$kode_ruang='TIDAK DIKETAHUI';
														}
													}
													
													$nama_kelas=$i['nama_kelas'];
													$jumlah_mhs_terjadwal_ujian=$i['jumlah_mhs_terjadwal_ujian'];
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

														$tanggal_pengajuan_terlambat = $i['tanggal_pengajuan_terlambat_pengawas1'];
														$jam_pengajuan_terlambat = $i['jam_pengajuan_terlambat_pengawas1'];
														$file_pengajuan_terlambat = $i['file_pengajuan_terlambat_pengawas1'];
														$status_pengajuan_terlambat = $i['status_pengajuan_terlambat_pengawas1'];
														$alasan_penolakan = $i['alasan_penolakan_pengawas1'];
														
													}else{
														$status_verifikasi_pengawas =$i['status_verifikasi_pengawas2'];
														$jam_submit = $jam_submit_pengawas2;

														$tanggal_pengajuan_terlambat = $i['tanggal_pengajuan_terlambat_pengawas2'];
														$jam_pengajuan_terlambat = $i['jam_pengajuan_terlambat_pengawas2'];
														$file_pengajuan_terlambat = $i['file_pengajuan_terlambat_pengawas2'];
														$status_pengajuan_terlambat = $i['status_pengajuan_terlambat_pengawas2'];
														$alasan_penolakan = $i['alasan_penolakan_pengawas2'];
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
												<td><?php echo $kode_ruang;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td>
													<?php 	

																if($jam_submit!="00:00:00" && $status_verifikasi_pengawas=="Minta Verifikasi"){
																	echo '<div class="text-secondary text-center">Sedang meminta verifikasi</div>';
																}elseif($jam_submit!="00:00:00" && $status_verifikasi_pengawas=="Terverifikasi"){
																	echo '<div class="text-primary text-center">Terverifikasi</div>';
																}elseif($status_verifikasi_pengawas == "Permintaan verifikasi ditolak"){
																	echo '<div class="text-danger text-center">Permintaan verifikasi ditolak</div>';
																}elseif($status_pengajuan_terlambat == "Minta Persetujuan"){
																	echo '<div class="text-info text-center">Sedang meminta persetujuan</div>';
																}elseif($status_pengajuan_terlambat == "Disetujui"){
																	echo '<div class="text-success text-center">Pengajuan disetujui oleh prodi</div>';
																}elseif($status_pengajuan_terlambat == "Pengajuan ditolak"){
																	echo '<div class="text-danger text-center">Pengajuan ditolak oleh prodi</div>';
																}else{
																	echo '<div class="text-warning text-center">Belum disubmit</div>';
																}
													?>
												</td>
												<td style="width: 250px;" class="text-white">
													<?php
														//$jam_submit!="00:00:00" AND 
														date_default_timezone_set('Asia/Jakarta');
														// $waktu_awal        =strtotime($tanggal_ujian." ".$jam_mulai);
												        // $waktu_akhir    = strtotime(date("Y-m-d H:i:s")); // bisa juga waktu sekarang now()
												        
												        //menghitung selisih dengan hasil detik
												        // $diff    =$waktu_akhir - $waktu_awal;

												        $tanggal_ujian_time        =strtotime($tanggal_ujian);
												        $now_time    = strtotime(date("Y-m-d")); // bisa juga waktu sekarang now()

												 
												        if($alasan_penolakan != ""){
												    ?>
												    		<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_lihat_alasan<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-eye"></i>Lihat Masukan Prodi</a>
												    <?php
												        }
														// if(($status_verifikasi_pengawas!="Terverifikasi" && $diff<=259200) || ($status_pengajuan_terlambat=="Disetujui" && $status_verifikasi_pengawas!="Terverifikasi")){
														if(($status_verifikasi_pengawas!="Terverifikasi" && $now_time<=$tanggal_ujian_time) || ($status_pengajuan_terlambat=="Disetujui" && $status_verifikasi_pengawas!="Terverifikasi")){
													?>
															<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-pen"></i>EDIT</a>
													<?php
														// }else if($jam_submit=="00:00:00" && $status_verifikasi_pengawas=="" && $diff>259200 && $tanggal_pengajuan_terlambat=="0000-00-00" && $jam_pengajuan_terlambat=="00:00:00" && $file_pengajuan_terlambat=='' && $status_pengajuan_terlambat==''){
														}else if($jam_submit=="00:00:00" && $status_verifikasi_pengawas=="" && $now_time>$tanggal_ujian_time && $tanggal_pengajuan_terlambat=="0000-00-00" && $jam_pengajuan_terlambat=="00:00:00" && $file_pengajuan_terlambat=='' && $status_pengajuan_terlambat==''){

													?>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_alasan<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-comment"></i> Ajukan Alasan Terlambat</a>
													<?php	
														}
													?>
													<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-book"></i> Rincian</a>

												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>
								
								


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
											$field_status_verifikasi = "status_verifikasi_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$field_status_verifikasi = "status_verifikasi_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}

										$jenis_soal=$i['jenis_soal'];
										$cekbox =  explode(', ', $i['media']);
										$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
										$ket_pelaksanaan=$i['ket_pelaksanaan'];
									?>
								<div class="modal fade" id="modal_edit<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary">
											<h3 class="modal-title" id="myModalLabel">Edit Data Histori</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/edit_data_histori'?>" enctype="multipart/form-data">
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
												<div class="form-group">
													<label class="control-label col-xs-3" >Foto Bukti <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i><br><i class="text-danger">2. Pastikan tidak ada tanda titik pada nama file gambar</i></label>
													<div class="col-xs-8">
														<input type="file" name="gambar" class="border-secondary text-dark" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG">
													</div>
												</div>
												<div class="form-group">
													<?php
														
															if($foto_bukti==""){
													?>
														<tr>
															<td colspan="3"><p class="text-danger">Maaf, Foto bukti belum tersedia!</p></td>
														</tr>
													<?php
															}else{
													?>
														<tr>
															<td colspan="3"><img width="100%" src="<?php echo base_url('templates/img/bukti-mengawas/').$foto_bukti?>" alt=""></td>
														</tr>
													<?php
															}
													
													?>
												</div>

											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field_status_verifikasi" value="<?php echo $field_status_verifikasi?>">
												<input type="hidden" name="field" value="<?php echo $field?>">
												<input type="hidden" name="foto_bukti" value="<?php echo $foto_bukti?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
												<button class="btn btn-warning">Simpan Perubahan dan Minta Verifikasi Ulang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL EDIT DATA -->

								

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
										

										

										if($jenis_ujian=="Daring"){
											$kode_ruang = "ONLINE";
										}else{
											$kode_ruang=$i['kode_ruang'];
											if($kode_ruang==''){
												$kode_ruang='TIDAK DIKETAHUI';
											}
										}

										$nama_kelas=$i['nama_kelas'];
										$jumlah_mhs_terjadwal_ujian=$i['jumlah_mhs_terjadwal_ujian'];
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
														<td><?php echo $jumlah_mhs_terjadwal_ujian?></td>
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
														<td><?php echo ($jumlah_mhs_terjadwal_ujian-$jumlah_mahasiswa_hadir)?></td>
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

								<!-- ============ MODAL ALASAN TELAT =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];
										$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
										$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$field = "foto_bukti_pengawas1";
											$field_status_verifikasi = "status_verifikasi_pengawas1";
											$field_tanggal_pengajuan_terlambat = "tanggal_pengajuan_terlambat_pengawas1";
											$field_jam_pengajuan_terlambat = "jam_pengajuan_terlambat_pengawas1";
											$field_file_pengajuan_terlambat = "file_pengajuan_terlambat_pengawas1";
											$field_status_pengajuan_terlambat = "status_pengajuan_terlambat_pengawas1";
											$foto_bukti = $foto_bukti_pengawas1;
										}else{
											$field = "foto_bukti_pengawas2";
											$field_status_verifikasi = "status_verifikasi_pengawas2";
											$field_tanggal_pengajuan_terlambat = "tanggal_pengajuan_terlambat_pengawas2";
											$field_jam_pengajuan_terlambat = "jam_pengajuan_terlambat_pengawas2";
											$field_file_pengajuan_terlambat = "file_pengajuan_terlambat_pengawas2";
											$field_status_pengajuan_terlambat = "status_pengajuan_terlambat_pengawas2";
											$foto_bukti = $foto_bukti_pengawas2;
										}

										$jenis_soal=$i['jenis_soal'];
										$media=$i['media'];
										$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
										$ket_pelaksanaan=$i['ket_pelaksanaan'];
									?>
								<div class="modal fade" id="modal_alasan<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger">
											<h3 class="modal-title" id="myModalLabel">Pengajuan Alasan Terlambat</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/upload_pengajuan'?>" enctype="multipart/form-data">
											<div class="modal-body">

												<!-- <div class="form-group">
													<label class="control-label col-xs-3" >Foto Bukti <br>
														<i class="text-danger">1. Ekstensi file : PDF</i><br>
														<i class="text-danger">2. Pastikan tidak ada tanda titik pada nama file</i><br>
														<i>3. Format file pengajuan  bisa dilihat <a href="<?php echo base_url('templates/file/')?>" class="text-primary">di sini</a> !</i><br>
														<i>4. Sertakan tanda tangan anda pada form pengajuan</i><br>
														<i>5. Silahkan tunggu sampai prodi memverifikasi pengajuan anda</i><br>
													</label>
													<div class="col-xs-8">
														<input type="file" name="berkas" class="border-danger text-dark">
													</div>
												</div> -->
												<div class="form-group">
													<label>Alasan Keterlambatan</label>
													<textarea class="form-control" name="alasan" required></textarea>
												</div>

											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="<?php echo $id_jadwal_lanjutan;?>">
												<input type="hidden" name="field_tanggal_pengajuan_terlambat" value="<?php echo $field_tanggal_pengajuan_terlambat?>">
												<input type="hidden" name="field_jam_pengajuan_terlambat" value="<?php echo $field_jam_pengajuan_terlambat?>">
												<input type="hidden" name="field_file_pengajuan_terlambat" value="<?php echo $field_file_pengajuan_terlambat?>">
												<input type="hidden" name="field_status_pengajuan_terlambat" value="<?php echo $field_status_pengajuan_terlambat?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
												<button class="btn btn-danger">Ajukan Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL ALASAN TELAT -->

								<!-- ============ MODAL ALASAN PENOLAKAN =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
										$npk_pengawas1=$i['npk_pengawas1'];
										$npk_pengawas2=$i['npk_pengawas2'];

										if($_SESSION['npk']==$npk_pengawas1){
											$alasan_penolakan=$i['alasan_penolakan_pengawas1'];
										}else{
											$alasan_penolakan=$i['alasan_penolakan_pengawas2'];
										}
										
									?>
								<div class="modal fade" id="modal_lihat_alasan<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning">
											<h3 class="modal-title" id="myModalLabel">Masukan Prodi</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/jadwal_mengawas/edit_data_histori'?>" enctype="multipart/form-data">
											<div class="modal-body">
												
												<textarea class="form-control" readonly><?= $alasan_penolakan; ?></textarea>
												
											</div>
											<div class="modal-footer">
												
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL ALASAN PENOLAKAN -->


								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

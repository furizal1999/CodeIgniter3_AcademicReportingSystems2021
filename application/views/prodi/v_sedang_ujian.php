	
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SEDANG UJIAN</h1>
								<h5 class="text-white op-7 mb-2"> Fakultas Teknik Universitas Islam Riau</h5>
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
													<td align="center"><b>NO</b></td>
													<td align="center"><b>JAM</b></td>											
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>KELAS</b></td>
													<td align="center"><b>RUANG</b></td>
													<td align="center"><b>NAMA PENGAWAS 1</b></td>
													<td align="center"><b>STATUS PENGAWAS 1</b></td>
													<td align="center"><b>NAMA PENGAWAS 2</b></td>
													<td align="center"><b>STATUS PENGAWAS 2</b></td>
												</tr>
											</thead>
											<tbody>
											<?php 
													$no = 1;
													foreach($data->result_array() as $i):
														$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
														$npk_pengawas1=$i['npk_pengawas1'];
														$npk_pengawas2=$i['npk_pengawas2'];
														
														$nama_ujian=$i['nama_ujian'];
														$jenis_ujian=$i['ket_ujian'];
														$semester=$i['semester'];
														$kode_mk=$i['kode_matkul'];
														$tanggal_ujian=$i['tanggal_ujian'];
														$jam_mulai=$i['jam_mulai'];
														$jam_selesai=$i['jam_selesai'];
														
														$nama_mk = $i['nama_mk'];
														

														$kode_ruang=$i['kode_ruang'];
														if($kode_ruang==""){
															$kode_ruang = "ONLINE";
														}

														$row = $this->m_sedang_ujian->ambil_dosen1($npk_pengawas1);
														if(isset($row)){
															$nama_dosen1 = $row->nama_dosen;
														}
														else{
															$nama_dosen1 ="Tidak ada";
														}

														$row = $this->m_sedang_ujian->ambil_dosen2($npk_pengawas2);
														if(isset($row)){
															$nama_dosen2 = $row->nama_dosen;
														}
														else{
															$nama_dosen2 ="Tidak ada";
														}
														
														$nama_kelas=$i['nama_kelas'];
														$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
														$jam_absen_pengawas1=$i['jam_absen_pengawas1'];
														$jam_absen_pengawas2=$i['jam_absen_pengawas2'];
														$jam_submit_pengawas1=$i['jam_submit_pengawas1'];
														$jam_submit_pengawas2=$i['jam_submit_pengawas2'];
														$status_verifikasi_pengawas1=$i['status_verifikasi_pengawas1'];
														$status_verifikasi_pengawas2=$i['status_verifikasi_pengawas2'];
														$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
														$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];
														$jenis_soal=$i['jenis_soal'];
														$media=$i['media'];
														$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
														$ket_pelaksanaan=$i['ket_pelaksanaan'];													
														// $status=$i['status'];
														
														// mengurangi menit
														if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
														$date = date_create($jam_mulai);
														date_add($date, date_interval_create_from_date_string('-15 minutes'));
														$coming = date_format($date, 'H:i:s');
														
												?>
												<tr>
													<td><?php echo $no++;?></td>
													<td class="text-primary"><?php echo $jam_mulai. '-' .$jam_selesai;?></td>
													<td><?php echo $nama_mk;?></td>
													<td><?php echo $nama_kelas;?></td>
													<td><?php echo $kode_ruang;?></td>
													<td width="270px">
														<?php echo $nama_dosen1?>													
													</td>
													<td>
														<?php
														if($npk_pengawas1!=""){
															if($jam_absen_pengawas1=="00:00:00"){
																echo '<div class="button text-danger">Belum Absen</div>';
															}else{
																if($jenis_soal!="" && $media!="" && $jumlah_mahasiswa_hadir!="" && $ket_pelaksanaan!=""){
																	if($foto_bukti_pengawas1!=""){
																		if($jam_submit_pengawas1!="00:00:00"){
																			if($status_verifikasi_pengawas1=="Terverifikasi"){
																				echo '<div class="text-info">Terverifikasi</div>';
																			}elseif($status_verifikasi_pengawas1=="Permintaan verifikasi ditolak"){
																				echo '<div class="text-danger">Permintaan verifikasi ditolak</div>';
																			}else{
																				echo '<div class="text-success">Minta Verifikasi</div>';
																			}
																			
																		}else{
																			echo '<div class="text-warning">Sudah Upload Foto Bukti</div>';
																			
																		}
																	}else{
																		echo '<div class="text-warning">Sudah Input Data</div>';
																	}
																}else{
																	echo '<div class="text-warning">Sudah Absen</div>';
																}
															}
														}
														else{
															echo '<div class="text-danger text-center">Pengawas 1 tidak tersedia</div>';
														}
														?>
													</td>
													<td width="270px">
														<?php echo $nama_dosen2?>													
													</td>

													<td>
														<?php
														if($npk_pengawas2!=""){
															if($jam_absen_pengawas2=="00:00:00"){
																echo '<div class="button text-danger">Belum Absen</div>';
															}else{
																if($jenis_soal!="" && $media!="" && $jumlah_mahasiswa_hadir!="" && $ket_pelaksanaan!=""){
																	if($foto_bukti_pengawas2!=""){
																		if($jam_submit_pengawas2!="00:00:00"){
																			if($status_verifikasi_pengawas2=="Terverifikasi"){
																				echo '<div class="text-info">Terverifikasi</div>';
																			}elseif($status_verifikasi_pengawas2=="Permintaan verifikasi ditolak"){
																				echo '<div class="text-danger">Permintaan verifikasi ditolak</div>';
																			}else{
																				echo '<div class="text-success">Minta Verifikasi</div>';
																			}
																		}else{
																			echo '<div class="text-warning">Sudah Upload Foto Bukti</div>';
																		}
																	}else{
																			echo '<div class="text-warning">Sudah Input Data</div>';
																	}
																}else{
																	echo '<div class="text-warning">Sudah Absen</div>';
																}
															}
														}
														else{
															echo '<div class="text-danger text-center">Pengawas 2 tidak tersedia</div>';
														}
														?>
													</td>										
													
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>     
			</div>


		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">BERITA ACARA</h1>
								<?php $text="aaaa"; ?>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){?>
								<form class="" method="post" action="<?php echo base_url('upm/cetak_berita_acara_full') ?>" target='_BLANK'>
									<input type="hidden" name="kode_jurusan" value="<?php echo $_SESSION['kode_prodi']; ?>">
									
									<button type="submit" name="print" class="btn btn-warning  text-white ">
										<i class="fa fa-print"></i> Print Semua Berita Acara
									</button>
								</form>
								
								<?php } ?>
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
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('upm/berita_acara')?>" method="post">
												<div class="row">
													<div class="col-md-5">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PROGRAM STUDI</label>
															<select name="kode_prodi" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_prodi->result_array() as $i):
																		$kode_prodi_combo=$i['kode_prodi'];
																		$nama_prodi_combo=$i['nama_prodi'];
																?>
																<option  value="<?php echo $kode_prodi_combo ?>" <?php if(isset($_SESSION['kode_prodi'])){if($_SESSION['kode_prodi']==$kode_prodi_combo){ echo 'selected';}}?>>
																	<?php echo $nama_prodi_combo; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >UJIAN</label>
															<select name="id_ujian" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_ujian->result_array() as $i):
																		$id_ujian_combo=$i['id_ujian'];
																		$tahun_ajaran_combo=$i['tahun_ajaran'];
																		$nama_ujian_combo=$i['nama_ujian'];
																		$jenis_ujian_combo=$i['ket_ujian'];
																		$semester_combo=$i['semester'];
																?>
																<option  value="<?php echo $id_ujian_combo ?>" <?php if(isset($_SESSION['id_ujian_search'])){if($_SESSION['id_ujian_search']==$id_ujian_combo){ echo 'selected';}}?>>
																	<?php echo $tahun_ajaran_combo.'->'.$semester_combo.'->'.$nama_ujian_combo.'('.$jenis_ujian_combo.')'; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label>
															<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<!-- <td align="center"><b>NO</b></td> -->
												<td align="center"><b>TANGGAL</b></td>
												<td align="center"><b>JAM</b></td>											
												<td align="center"><b>NAMA MATAKULIAH</b></td>
												<td align="center"><b>NAMA PENGAWAS 1</b></td>
												<td align="center"><b>NAMA PENGAWAS 2</b></td>
												<td align="center"><b>STATUS PENGAWAS 1</b></td>
												<td align="center"><b>STATUS PENGAWAS 2</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
													$kode_jurusan=$i['kode_jurusan'];
													$npk_pengawas1=$i['npk_pengawas1'];
													$npk_pengawas2=$i['npk_pengawas2'];
													
													$nama_ujian=$i['nama_ujian'];
													$jenis_ujian=$i['ket_ujian'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$semester=$i['semester'];
													$kode_mk=$i['kode_matkul'];
													$dosen_pengampu=$i['dosen_pengampu'];
													$tanggal_ujian=$i['tanggal_ujian'];
													$jam_mulai=$i['jam_mulai'];
													$jam_selesai=$i['jam_selesai'];
													

													$row = $this->m_berita_acara->ambil_matkul($_SESSION['kode_prodi'],$kode_mk);
													if(isset($row)){
														$nama_mk = $row->nama_mk;
													}
													else{
														$nama_mk = "Tidak ada";
													}

													$row = $this->m_berita_acara->ambil_dosen1($_SESSION['kode_prodi'],$npk_pengawas1);
													if(isset($row)){
														$nama_dosen1 = $row->nama_dosen;
													}
													else{
														$nama_dosen1 ="Tidak diketahui";
													}

													$row = $this->m_berita_acara->ambil_dosen2($_SESSION['kode_prodi'],$npk_pengawas2);
													if(isset($row)){
														$nama_dosen2 = $row->nama_dosen;
													}
													else{
														$nama_dosen2 ="Tidak diketahui";
													}

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
													$status_verifikasi_pengawas1=$i['status_verifikasi_pengawas1'];
													$status_verifikasi_pengawas2=$i['status_verifikasi_pengawas2'];
													$foto_bukti_pengawas1=$i['foto_bukti_pengawas1'];
													$foto_bukti_pengawas2=$i['foto_bukti_pengawas2'];
													$jenis_soal=$i['jenis_soal'];
													$media=$i['media'];
													$jumlah_mahasiswa_hadir=$i['jumlah_mahasiswa_hadir'];
													$ket_pelaksanaan=$i['ket_pelaksanaan'];													
													// $status=$i['status'];

													if($status_verifikasi_pengawas1==""){
														$status_verifikasi_pengawas1 ="Tidak ada";
													}
													if($status_verifikasi_pengawas2==""){
														$status_verifikasi_pengawas2 ="Tidak ada";
													}
													
													// mengurangi menit
													if(function_exists('date_default_timezone_set')) date_default_timezone_set('Asia/Jakarta');
													$date = date_create($jam_mulai);
													date_add($date, date_interval_create_from_date_string('-15 minutes'));
													$coming = date_format($date, 'H:i:s');
													
											?>
											<tr>
												<!-- <td><?php echo $no++;?></td> -->
												<td class="text-primary"><?php echo $tanggal_ujian;?></td>
												<td class="text-primary"><?php echo $jam_mulai. '-' .$jam_selesai;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $nama_dosen1;?></td>
												<td><?php echo $nama_dosen2;?></td>
												<td><?php echo $status_verifikasi_pengawas1;?></td>
												<td><?php echo $status_verifikasi_pengawas2;?></td>
												<td>
											<?php
												if($status_verifikasi_pengawas1 != "Terverifikasi" && $status_verifikasi_pengawas2 != "Terverifikasi"){
													echo '<div class="text-danger">Tidak ada pengawas yang terverifikasi</div>';
												}else{
											?>
												<form class="" method="post" action="<?php echo base_url('upm/cetak_berita_acara/cetak/').$id_jadwal_lanjutan ?>" target='_BLANK'>

													<button type="submit" class="btn btn-sm btn-warning  text-white ">
														<i class="fa fa-print"></i> Print Berita Acara
													</button>
												  </form>
											<?php
												}
											?>
												</td>
												
												
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>

								<?php }else{ ?>
									<h1 class="text-danger">SILAHKAN PILIH TERLEBIH DAHULU PRODI DAN UJIAN...</h1>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

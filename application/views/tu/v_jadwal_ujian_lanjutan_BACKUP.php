
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL UJIAN LANJUTAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">

									<a class="btn btn-info mt-3" href="<?php echo base_url('tu/jadwal_ujian')?>"><i class="fa fa-eye"></i> Lihat Jadwal Awal</a>
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
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="row">

										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('tu/jadwal_ujian_lanjutan')?>" method="post">
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
																		$jenis_ujian_combo=$i['jenis_ujian'];
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
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-secondary">
												<td align="center"><b>NO</b></td>
												<td align="center"><b>MATAKULIAH</b></td>
												<td align="center"><b>PENGAMPU</b></td>
												<td align="center"><b>TANGGAL UJIAN</b></td>
												<td align="center"><b>JAM UJIAN</b></td>
												<td align="center"><b>NAMA KELAS</b></td>
												<td align="center"><b>JUMLAH MHS</b></td>
												<td align="center"><b>RUANG TERJADWAL</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
												$no=1;
												foreach($data->result_array() as $i):
													$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
													$id_jadwal_ujian=$i['id_jadwal_ujian'];
													$kode_prodi=$i['kode_prodi'];
													$tanggal_ujian=$i['tanggal_ujian'];
													$jam_mulai=$i['jam_mulai'];
													$jam_selesai=$i['jam_selesai'];
													$nama_mk=$i['nama_mk'];
													// $nama_dosen_pengampu=$i['nama_dosen'];
													//get nama dosen
													$dosen_pengampu=$i['dosen_pengampu'];
													$array_dosen = explode(', ', $dosen_pengampu);

													$array_dosen_hasil = array();
													$array_npk_hasil = array();
													$index = 0;
													foreach ($array_dosen as $npk) {
														$nama_dosen = $this->m_jadwal_ujian_lanjutan->getNamaDosen($npk);
														$array_npk_hasil[$index] = $npk;
														$array_dosen_hasil[$index] = $nama_dosen;
														$index++;
													}
													$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

													$nama_kelas=$i['nama_kelas'];
													$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
													$jumlah_kelas_terjadwal = $this->m_jadwal_ujian_lanjutan->showDetailJadwalPengawas($kode_prodi, $id_jadwal_kelas_pertemuan, $id_jadwal_ujian)->num_rows();
											?>

											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $string_dosen_hasil;?></td>
												<td><?php echo $tanggal_ujian;?></td>
												<td class="text-center"><?php echo '<i class="text-success">'.$jam_mulai.'</i> s/d <i class="text-danger">'.$jam_selesai.'</i>';?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $jumlah_mahasiswa;?></td>
												<td><?php echo $jumlah_kelas_terjadwal;?></td>
												<td style="width: 400px;">
													<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_jadwal_pengawas<?php echo $id_jadwal_kelas_pertemuan;?>"><i class="fa fa-arrow-right"></i> Jadwalkan Pengawas</a>
													<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modalDetailPengawas<?php echo $id_jadwal_kelas_pertemuan.$id_jadwal_ujian;?>"><i class="fa fa-eye"></i></a>
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>



									<?php
										foreach($data->result_array() as $i):
											$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
											$id_jadwal_ujian=$i['id_jadwal_ujian'];
											$kode_prodi = $i['kode_prodi'];


										?>
									<!-- ============ MODAL HAPUS =============== -->
										<div class="modal fade" id="modalDetailPengawas<?php echo $id_jadwal_kelas_pertemuan.$id_jadwal_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-info">
												<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Ujian Lanjutan</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian_lanjutan/hapus_jadwal_ujian_lanjutan'?>">
												<div class="modal-body">
													<div class="table-responsive">
														<table class="table">
															<tr class="bg-light">
																<th>No</th>
																<th>Ruang</th>
																<th>Pengawas 1</th>
																<th>Pengawas 2</th>
																<th>Jumlah Mahasiswa</th>
																<th>Aksi</th>
															</tr>
															<?php
																$detail = $this->m_jadwal_ujian_lanjutan->showDetailJadwalPengawas($kode_prodi, $id_jadwal_kelas_pertemuan, $id_jadwal_ujian);
																$no = 1;
																if($detail->num_rows()>0){
																		foreach ($detail->result_array() as $b) {
																	$id_jadwal_lanjutan = $b['id_jadwal_lanjutan'];
																	$jumlah_mhs_terjadwal_ujian = $b['jumlah_mhs_terjadwal_ujian'];
																	$npk_pengawas1 = $b['npk_pengawas1'];

																	$ket_ujian = $b['ket_ujian'];
																	$npk_pengawas2 = $b['npk_pengawas2'];

																	if($ket_ujian=='Daring'){
																		$kode_ruang = 'ONLINE';
																	}else{
																		$kode_ruang = $b['kode_ruang'];
																	}

																	if($npk_pengawas1!=''){
																		$row = $this->m_jadwal_ujian_lanjutan->ambil_pengawas($kode_prodi, $npk_pengawas1);
																		if($row){
																			$nama_pengawas1 = $row->nama_dosen;
																		}else{
																			$nama_pengawas1 = 'TIDAK DIKETAHUI';
																		}
																	}else{
																		$nama_pengawas1 = 'TIDAK ADA';
																	}


																	if($npk_pengawas2!=''){
																		$row = $this->m_jadwal_ujian_lanjutan->ambil_pengawas($kode_prodi, $npk_pengawas2);
																		if($row){
																			$nama_pengawas2 = $row->nama_dosen;
																		}else{
																			$nama_pengawas2 = 'TIDAK DIKETAHUI';
																		}
																	}else{
																		$nama_pengawas2 = 'TIDAK ADA';
																	}

															?>
															<tr>
																<td><?= $no++ ?></td>
																<td><?= $kode_ruang ?></td>
																<td><?= $nama_pengawas1 ?></td>
																<td><?= $nama_pengawas2 ?></td>
																<td><?= $jumlah_mhs_terjadwal_ujian ?></td>
																<td>
																	<a class="btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#modalEditPengawas<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-pen"></i></a>

																	<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modalHapusPengawas<?php echo $id_jadwal_lanjutan;?>"><i class="fa fa-trash"></i></a>

																</td>
															</tr>
															<?php }
																}else{
															?>
															<tr>
																<td colspan="6" class="text-center text-danger">TIDAK ADA DATA</td>
															</tr>
															<?php
																}
															?>
														</table>
													</div>
												</div>
												<div class="modal-footer">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												</div>
											</form>
											</div>
											</div>
										</div>
									<?php endforeach;?>
									<!--END MODAL HAPUS -->



									<?php
										foreach($data->result_array() as $i):
											$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
											$id_jadwal_ujian=$i['id_jadwal_ujian'];
											$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
											$dosen_pengampu = $i['dosen_pengampu'];
											$jenis_ujian = $i['ket_ujian'];

											$tanggal_ujian = $i['tanggal_ujian'];
											$jam_mulai = $i['jam_mulai'];
											$jam_selesai = $i['jam_selesai'];


										?>
									<!-- ============ MODAL JADWALKAN PENGAWAS =============== -->
										<div class="modal fade" id="modal_jadwal_pengawas<?php echo $id_jadwal_kelas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-warning">
												<h3 class="modal-title" id="myModalLabel">Jadwalkan Pengawas Ujian</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian_lanjutan/jadwalkan_pengawas_ujian'?>">
												<div class="modal-body">
													<!-- id_jadwal_ujian -->
													<input type="hidden" name="id_jadwal_ujian" value="<?= $id_jadwal_ujian ?>">
													<!-- id_jadwal_kelas_pertemuan -->
													<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?= $id_jadwal_kelas_pertemuan ?>">
													<!-- jumlah_mhs_terjadwal_ujian -->
													<div class="form-group">
														<label>JUMLAH MAHASISWA</label>
														<input type="number" name="jumlah_mhs_terjadwal_ujian" class="form-control" value="<?= $jumlah_mahasiswa ?>" required>
													</div>
													<!-- npk_pengawas1 -->
													<div class="form-group text-left">
														<label class="control-label col-xs-3" >PENGAWAS UJIAN 1</label>
														<select name="npk_pengawas1" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_dosen1->result_array() as $i):
																	$nama_dosen_combo=$i['nama_dosen'];
																	$npk_combo=$i['npk'];
															?>
															<option  value="<?php echo $npk_combo ?>" <?php if($dosen_pengampu==$npk_combo){ echo 'selected'; }?>>
																<?php echo $nama_dosen_combo; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
													<?php if($jenis_ujian=="Luring"){ ?>
													<!-- npk_pengawas2 -->
													<div class="form-group text-left">
														<label class="control-label col-xs-3" >PENGAWAS UJIAN 2</label>
														<select name="npk_pengawas2" class="form-control">
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_dosen2->result_array() as $i):
																	$nama_dosen_combo=$i['nama_dosen'];
																	$npk_combo=$i['npk'];
															?>
															<option  value="<?php echo $npk_combo ?>">
																<?php echo $nama_dosen_combo; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
													<!-- kode_ruang -->
													<div class="form-group text-left">
														<label class="control-label col-xs-3" >RUANG</label>
														<select name="kode_ruang" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_ruang->result_array() as $i):
																	$kode_ruang_combo=$i['kode_ruang'];
																	$kapasitas_combo=$i['kapasitas'];
															?>
															<option  value="<?php echo $kode_ruang_combo ?>">
																<?php echo $kode_ruang_combo; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
													<?php }else{ ?>
														<input type="hidden" name="npk_pengawas2" value="">
														<input type="hidden" name="kode_ruang" value="">
													<?php } ?>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="jenis_ujian" value="<?= $jenis_ujian ?>">
													<input type="hidden" name="tanggal_ujian" value="<?= $tanggal_ujian ?>">
													<input type="hidden" name="jam_mulai" value="<?= $jam_mulai ?>">
													<input type="hidden" name="jam_selesai" value="<?= $jam_selesai ?>">

													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
													<button class="btn btn-warning" name="jadwalkan_pengawas">Simpan</button>
												</div>
											</form>
											</div>
											</div>
										</div>
									<?php endforeach;?>
									<!--END MODAL JADWALKAN PENGAWAS -->






									<?php
										foreach($showJadwalPengawas->result_array() as $i):
											$id_jadwal_lanjutan=$i['id_jadwal_lanjutan'];
											$jumlah_mhs_terjadwal_ujian=$i['jumlah_mhs_terjadwal_ujian'];
											$npk_pengawas1=$i['npk_pengawas1'];
											$npk_pengawas2=$i['npk_pengawas2'];
											$kode_ruang=$i['kode_ruang'];


											$jenis_ujian = $i['ket_ujian'];

											$tanggal_ujian = $i['tanggal_ujian'];
											$jam_mulai = $i['jam_mulai'];
											$jam_selesai = $i['jam_selesai'];

										?>
									<!-- ============ MODAL HAPUS PENGAWAS =============== -->
											<div class="modal fade" id="modalHapusPengawas<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
												<div class="modal-dialog">
												<div class="modal-content">
												<div class="modal-header bg-danger">
													<h3 class="modal-title" id="myModalLabel">Hapus Pengawas Ujian</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian_lanjutan/hapus_pengawas_ujian'?>">
													<div class="modal-body">
														<p>Apakah anda yakin menghapus jadwal pengawas ini?</p>
													</div>
													<div class="modal-footer">

														<input type="hidden" name="id_jadwal_lanjutan" value="<?= $id_jadwal_lanjutan ?>">
														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-danger" name="hapus_pengawas">Ya</button>
													</div>
												</form>
												</div>
												</div>
											</div>
									<!--END MODAL HAPUS PENGAWAS -->

									<!-- ============ MODAL EDIT PENGAWAS =============== -->
											<div class="modal fade" id="modalEditPengawas<?php echo $id_jadwal_lanjutan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
												<div class="modal-dialog">
												<div class="modal-content">
												<div class="modal-header bg-secondary">
													<h3 class="modal-title" id="myModalLabel">Edit Pengawas Ujian</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian_lanjutan/edit_pengawas_ujian'?>">
													<div class="modal-body">
														<div class="form-group">
															<label>JUMLAH MAHASISWA</label>
															<input type="number" name="jumlah_mhs_terjadwal_ujian" class="form-control" value="<?= $jumlah_mhs_terjadwal_ujian ?>" required>
														</div>
														<!-- npk_pengawas1 -->
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PENGAWAS UJIAN 1</label>
															<select name="npk_pengawas1" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_dosen1->result_array() as $i):
																		$nama_dosen_combo=$i['nama_dosen'];
																		$npk_combo=$i['npk'];
																?>
																<option  value="<?php echo $npk_combo ?>" <?php if($npk_pengawas1==$npk_combo){ echo 'selected'; }?>>
																	<?php echo $nama_dosen_combo; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
														<?php if($jenis_ujian=="Luring"){ ?>
														<!-- npk_pengawas2 -->
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PENGAWAS UJIAN 2</label>
															<select name="npk_pengawas2" class="form-control">
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_dosen2->result_array() as $i):
																		$nama_dosen_combo=$i['nama_dosen'];
																		$npk_combo=$i['npk'];
																?>
																<option  value="<?php echo $npk_combo ?>" <?php if($npk_pengawas2==$npk_combo){ echo 'selected'; }?>>
																	<?php echo $nama_dosen_combo; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
														<!-- kode_ruang -->
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >RUANG</label>
															<select name="kode_ruang" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_ruang->result_array() as $i):
																		$kode_ruang_combo=$i['kode_ruang'];
																		$kapasitas_combo=$i['kapasitas'];
																?>
																<option  value="<?php echo $kode_ruang_combo ?>" <?php if($kode_ruang==$kode_ruang_combo){ echo 'selected'; }?>>
																	<?php echo $kode_ruang_combo; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
														<?php }else{ ?>
															<input type="hidden" name="npk_pengawas2" value="">
															<input type="hidden" name="kode_ruang" value="">
														<?php } ?>
													</div>
													<div class="modal-footer">

														<input type="hidden" name="id_jadwal_lanjutan" value="<?= $id_jadwal_lanjutan ?>">

														<input type="hidden" name="jenis_ujian" value="<?= $jenis_ujian ?>">
														<input type="hidden" name="tanggal_ujian" value="<?= $tanggal_ujian ?>">
														<input type="hidden" name="jam_mulai" value="<?= $jam_mulai ?>">
														<input type="hidden" name="jam_selesai" value="<?= $jam_selesai ?>">


														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-secondary" name="edit_pengawas">Simpan Perubahan</button>
													</div>
												</form>
												</div>
												</div>
											</div>
									<?php endforeach;?>
									<!--END MODAL EDIT PENGAWAS -->

								</div>
							</div>
						</div>
					</div>
				</div>


			</div>

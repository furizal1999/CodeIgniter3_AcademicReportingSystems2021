		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL UJIAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
										<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Jadwal Ujian</a>
										<a class="btn btn-info mt-3" href="<?php echo base_url('tu/jadwal_ujian_lanjutan')?>"><i class="fa fa-eye"></i> Lihat Jadwal Lanjutan</a>
									<?php } ?>
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

										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('tu/jadwal_ujian')?>" method="post">
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
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-secondary text-light">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center"><b>JML KELAS</b></td>
													<td align="center"><b>TANGGAL UJIAN</b></td>
													<td align="center"><b>JAM MULAI</b></td>
													<td align="center"><b>JAM SELESAI</b></td>
													<td align="center"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>
												<?php
													$no = 1;
													foreach($data->result_array() as $i):

														$id_jadwal_ujian=$i['id_jadwal_ujian'];
														$nama_ujian=$i['nama_ujian'];
														$id_ujian=$i['id_ujian'];
														$tahun_ajaran=$i['tahun_ajaran'];
														$semester=$i['semester'];
														$kode_matkul=$i['kode_matkul'];
														$nama_mk=$i['nama_mk'];
														// $nama_dosen=$i['nama_dosen'];
														//get nama dosen
														$dosen_pengampu=$i['dosen_pengampu'];
														$array_dosen = explode(', ', $dosen_pengampu);

														$array_dosen_hasil = array();
														$array_npk_hasil = array();
														$index = 0;
														foreach ($array_dosen as $npk) {
															$nama_dosen = $this->m_jadwal_ujian->getNamaDosen($npk);
															$array_npk_hasil[$index] = $npk;
															$array_dosen_hasil[$index] = $nama_dosen;
															$index++;
														}
														$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

														$jumlah_kelas=$i['jumlah_kelas'];
														$tanggal_ujian=$i['tanggal_ujian'];
														$jam_mulai=$i['jam_mulai'];
														$jam_selesai=$i['jam_selesai'];
												?>

												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $nama_mk;?></td>
													<td><?php echo $string_dosen_hasil;?></td>
													<td><?php echo $jumlah_kelas;?></td>
													<td><?php echo $tanggal_ujian;?></td>
													<td class="text-success"><?php echo $jam_mulai;?></td>
													<td class="text-danger"><?php echo $jam_selesai;?></td>

													<td style="width: 150px ;" class="text-white">
														<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalEdit<?php echo $id_jadwal_ujian;?>"><i class="fa fa-pen"></i> Edit</a>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_jadwal_ujian;?>"><i class="fa fa-trash"></i> Hapus</a>

													</td>
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<?php }else{ ?>
										<h1 class="text-danger">Silahkan pilih prodi dan ujian terlebih dahulu...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
							<!-- ============ MODAL ADD =============== -->
							<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-primary text-white">
									<h3 class="modal-title" id="myModalLabel">Tambah Jadwal Ujian</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jadwal_ujian/tambah_jadwal_ujian')?>">
									<div class="modal-body">

										<input type="hidden" name="id_ujian" value="<?php echo $_SESSION['id_ujian_search']?>">


										<div class="form-group text-left">
											<label class="control-label col-xs-3" >MATAKULIAH DAN KELAS</label>
											<select name="id_jadwal_pengampu" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_jadwal_pengampu->result_array() as $i):
														$id_jadwal_pengampu_combo=$i['id_jadwal_pengampu'];
														// $nama_dosen_combo=$i['nama_dosen'];
														//get nama dosen
														$dosen_pengampu=$i['dosen_pengampu'];
														$array_dosen = explode(', ', $dosen_pengampu);

														$array_dosen_hasil = array();
														$array_npk_hasil = array();
														$index = 0;
														foreach ($array_dosen as $npk) {
															$nama_dosen = $this->m_jadwal_ujian->getNamaDosen($npk);
															$array_npk_hasil[$index] = $npk;
															$array_dosen_hasil[$index] = $nama_dosen;
															$index++;
														}
														$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

														$nama_mk_combo=$i['nama_mk'];
														$jumlah_kelas_combo=$i['jumlah_kelas'];
														if($this->m_jadwal_ujian->cekKetersediaanJadwalUjian($_SESSION['id_ujian_search'], $id_jadwal_pengampu_combo)==0){
												?>
												<option  value="<?php echo $id_jadwal_pengampu_combo ?>">
													<?php echo $nama_mk_combo.' ('.$string_dosen_hasil.') '.$jumlah_kelas_combo.' Kelas'; ?>
												</option>
												<?php
														}
													endforeach;
													?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-3" >TANGGAL UJIAN</label>
											<div class="col-xs-8">
												<input name="tanggal_ujian" class="form-control" type="date" placeholder="Tanggal ujian..." required>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-xs-3" >JAM MULAI</label>
											<div class="col-xs-8">
												<input name="jam_mulai" class="form-control" type="time" required>
											</div>
										</div>

										<div class="form-group">
											<label class="control-label col-xs-3" >JAM SELESAI</label>
											<div class="col-xs-8">
												<input name="jam_selesai" class="form-control" type="time" required>
											</div>
										</div>

									</div>

									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-info" name="tambah_jadwal_ujian">Simpan</button>
									</div>
								</form>
								</div>
								</div>
							</div>
						<!--END MODAL ADD-->



						<!-- ============ MODAL EDIT =============== -->
						<?php
								foreach($data->result_array() as $i):

								$id_jadwal_ujian=$i['id_jadwal_ujian'];
								$nama_ujian=$i['nama_ujian'];
								$id_ujian=$i['id_ujian'];
								$tahun_ajaran=$i['tahun_ajaran'];
								$semester=$i['semester'];
								$kode_matkul=$i['kode_matkul'];
								$nama_mk=$i['nama_mk'];
								// $nama_dosen=$i['nama_dosen'];
								//get nama dosen
								$dosen_pengampu=$i['dosen_pengampu'];
								$array_dosen = explode(', ', $dosen_pengampu);

								$array_dosen_hasil = array();
								$array_npk_hasil = array();
								$index = 0;
								foreach ($array_dosen as $npk) {
									$nama_dosen = $this->m_jadwal_ujian->getNamaDosen($npk);
									$array_npk_hasil[$index] = $npk;
									$array_dosen_hasil[$index] = $nama_dosen;
									$index++;
								}
								$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

								$jumlah_kelas=$i['jumlah_kelas'];
								$tanggal_ujian=$i['tanggal_ujian'];
								$jam_mulai=$i['jam_mulai'];
								$jam_selesai=$i['jam_selesai'];

								?>
								<div class="modal fade" id="modalEdit<?php echo $id_jadwal_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary">
										<h3 class="modal-title" id="myModalLabel">Edit Jadwal</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian/edit_jadwal_ujian'?>" enctype="multipart/form-data">
										<div class="modal-body">

											<div class="form-group">
												<input type="hidden" name="id_jadwal_ujian" value="<?php echo $id_jadwal_ujian;?>">
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >MATAKULIAH</label>
												<div class="col-xs-8">
													<input class="form-control" type="text" value="<?=$nama_mk?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >NAMA PENGAMPU</label>
												<div class="col-xs-8">
													<input class="form-control" type="text" value="<?=$string_dosen_hasil?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >JUMLAH KELAS</label>
												<div class="col-xs-8">
													<input class="form-control" type="text" value="<?=$jumlah_kelas?>" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >TANGGAL UJIAN</label>
												<div class="col-xs-8">
													<input name="tanggal_ujian" class="form-control"  value="<?=$tanggal_ujian?>" type="date" placeholder="Tanggal ujian..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >JAM MULAI</label>
												<div class="col-xs-8">
													<input name="jam_mulai" class="form-control"  value="<?=$jam_mulai?>" type="time" required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >JAM SELESAI</label>
												<div class="col-xs-8">
													<input name="jam_selesai" class="form-control"  value="<?=$jam_selesai?>" type="time" required>
												</div>
											</div>

										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-secondary" name="edit_jadwal_ujian">Simpan Perubahan</button>
										</div>
									</form>
									</div>
									</div>
								</div>

							<?php
								endforeach;
							?>
							<!--END MODAL EDIT-->

							<?php
							foreach($data->result_array() as $i):

								$id_jadwal_ujian=$i['id_jadwal_ujian'];
								$nama_mk=$i['nama_mk'];
							?>
						<!-- ============ MODAL HAPUS =============== -->
							<div class="modal fade" id="modal_hapus<?php echo $id_jadwal_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-danger">
									<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Ujian</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_ujian/hapus_jadwal_ujian'?>">
									<div class="modal-body">
										<p>Anda yakin menghapus jadwal matakuliah <b><?php echo $nama_mk;?></b>?</p>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="id_jadwal_ujian" value="<?php echo $id_jadwal_ujian;?>">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-danger" name="hapus_jadwal_ujian">Ya</button>
									</div>
								</form>
								</div>
								</div>
							</div>
						<?php endforeach;?>
						<!--END MODAL HAPUS -->

		<?php } ?>

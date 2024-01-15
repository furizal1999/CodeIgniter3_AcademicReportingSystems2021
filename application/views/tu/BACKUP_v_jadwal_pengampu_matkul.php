		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL PENGAMPU MATAKULIAH</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
										<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Pengampu</a>
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
											<form action="<?php echo base_url('tu/jadwal_pengampu_matkul')?>" method="post">
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
															<label class="control-label col-xs-3" >PERTEMUAN</label>
															<select name="id_pertemuan" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_tahun_ajaran->result_array() as $i):
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
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-secondary text-light">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center"><b>JMLH KELAS</b></td>
													<td align="center"><b>BELUM T'JADWAL</b></td>
													<td align="center"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>
												<?php 
													$no = 1;
													foreach($data->result_array() as $i):
														$id_jadwal_pengampu=$i['id_jadwal_pengampu'];
														
														
														$tahun_ajaran=$i['tahun_ajaran'];
														
														$kode_matkul=$i['kode_matkul'];
														$nama_mk=$i['nama_mk'];
														$dosen_pengampu=$i['dosen_pengampu'];
														$array_dosen = explode(', ', $dosen_pengampu);

														// $nama_dosen=$i['nama_dosen'];
														$jumlah_kelas=$i['jumlah_kelas'];
														$semester=$i['semester'];
														$terjadwal= $this->m_jadwal_pengampu_matkul->total_terjadwal($id_jadwal_pengampu);



												?>
											
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $nama_mk;?></td>
													<td>
														<?php 
															$index = 0;
															$array_dosen_hasil = array();

															foreach ($array_dosen as $npk) {
																$nama_dosen = $this->m_jadwal_pengampu_matkul->getNamaDosen($npk);
																$array_dosen_hasil[$index++] = $nama_dosen;
															}

															echo $string_dosen_hasil = implode('/ ', $array_dosen_hasil)

														?>
														
													</td>
													<td><?php echo $jumlah_kelas," Kelas";?></td>
													<td><?php echo ($jumlah_kelas-$terjadwal)," Kelas";?></td>
													<td style="width: 380px;" class="text-white">
													<?php if(($jumlah_kelas-$terjadwal)>0){?>
														<a class="btn btn-sm btn-warning text-dark" data-toggle="modal" data-target="#modal_jadwal_lanjutan<?php echo $id_jadwal_pengampu;?>"><i class="fa fa-arrow-right"></i> JADWALKAN KELAS</a>
													<?php }?>
														<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_jadwal_pengampu;?>"><i class="fa fa-pen"></i> Edit</a>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_jadwal_pengampu;?>"><i class="fa fa-trash"></i> Hapus</a>
														
														<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $id_jadwal_pengampu;?>"><i class="fa fa-book"></i> Rincian</a>

													</td>
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH TERLEBIH DAHULU PRODI DAN PERTEMUAN...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>
			


			<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
							<!-- ============ MODAL ADD =============== -->
							<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-primary text-white">
									<h3 class="modal-title" id="myModalLabel">Tambah Jadwal Pengampu</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jadwal_pengampu_matkul/tambah_jadwal_pengampu_matkul')?>">
									<div class="modal-body">

										<div class="form-group">
											<label class="control-label col-xs-3" >MATAKULIAH</label>
											<select id="kode_mk" name="kode_mk" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_matkul->result_array() as $i):
														$kode_matkul_combo=$i['kode_mk'];
														$nama_matkul_combo=$i['nama_mk'];
														
												?>
												<option  value="<?php echo $kode_matkul_combo ?>">
													<?php echo $kode_matkul_combo," - ",$nama_matkul_combo?>
												</option>
												<?php endforeach;?>
											</select>
										</div>

										<div class="form-group bg-warning rounded mt-3 mb-3">
											<label class="control-label col-xs-3" >DOSEN PENGAMPU-1</label>
											<select id="dosen_pengampu1" name="dosen_pengampu1" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>">
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

											<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-2 <i class="text-danger">optional</i></label>
											<select id="dosen_pengampu2" name="dosen_pengampu2" class="form-control">
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>">
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

											<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-3 <i class="text-danger">optional</i></label>
											<select id="dosen_pengampu3" name="dosen_pengampu3" class="form-control">
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>">
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

										</div>
										
										<div class="form-group">
											<label class="control-label col-xs-3" >JUMLAH KELAS</label>
											<div class="col-xs-8">
												<input name="jumlah_kelas" class="form-control" type="number" placeholder="Jumlah kelas..." required>
											</div>
										</div>
									</div>

									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-info" name="tambah_pengampu">Simpan</button>
									</div>
								</form>
								</div>
								</div>
							</div>
						<!--END MODAL ADD-->
							

						<!-- ============ MODAL RINCIAN =============== -->
						<?php
								foreach($data->result_array() as $i):
									$id_jadwal_pengampu=$i['id_jadwal_pengampu'];
									
									$id_tahun_ajaran = $i['id_tahun_ajaran'];
									$kode_matkul=$i['kode_matkul'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$kode_matkul=$i['kode_matkul'];
									$jumlah_kelas=$i['jumlah_kelas'];
									$semester=$i['semester'];
									$jumlah_kelas=$i['jumlah_kelas'];

									$dosen_pengampu=$i['dosen_pengampu'];
									$array_dosen = explode(', ', $dosen_pengampu);

									$index = 0;
									$array_dosen_hasil = array();

									foreach ($array_dosen as $npk) {
										// $nama_dosen = $this->m_jadwal_pengampu_matkul->getNamaDosen($npk);
										$array_dosen_hasil[$index++] = $npk;
									}


									$nama_mk=$i['nama_mk'];  
									$terjadwal= $this->m_jadwal_pengampu_matkul->total_terjadwal($id_jadwal_pengampu);          
									
								?>


								<!-- jadwalkan kelas -->
								<div class="modal fade" id="modal_jadwal_lanjutan<?php echo $id_jadwal_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-warning">
									<h3 class="modal-title" id="myModalLabel">Penjadwalan Kelas</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/tambah_jadwal_kelas_pertemuan'?>" enctype="multipart/form-data">
									<div class="modal-body">
									
										<input type="hidden" name="id_jadwal_pengampu" class="form-control" value="<?php echo $id_jadwal_pengampu?>" readonly>
										
										<div class="form-group">
											<label class="control-label col-xs-3" >WAKTU PERTEMUAN PERTAMA (TANGGAL)</label>
											<div class="row">
												<div class="form-group"><input type="date" name="tanggal_pertemuan_pertama" class="form-control" required></div>

											</div>
											<div class="row">
												<div class="col-md-6">
													<label>JAM MULAI</label>
													<div class="form-group"><input type="time" name="jam_pertemuan_pertama" class="form-control" required></div>
												</div>
												<div class="col-md-6">
													<label>JAM SELESAI</label>
													<div class="form-group"><input type="time" name="jam_pertemuan_pertama_akhir" class="form-control" required></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>KELAS</label>
											<select name="nama_kelas" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php 
													$z= $this->m_jadwal_pengampu_matkul->combobox_kelas($_SESSION['kode_prodi'], $semester);
													if($z){
														foreach($z->result_array() as $i):
															$semester_combo=$i['semester'];
															$nama_kelas_combo=$i['nama_kelas'];
															$kelas_pilihan_combo=$i['kelas_pilihan'];
															if($semester_combo=='0'){
																$semester_combo = '';
															}
															
															if($kelas_pilihan_combo=="PIL"){
																$kelas_combo = $semester_combo.$nama_kelas_combo.' '.$kelas_pilihan_combo;
															}else{
																$kelas_combo = $semester_combo.$nama_kelas_combo;
															}

													?>
													<option  value="<?php echo $kelas_combo; ?>">
														<?php echo $kelas_combo; ?>
													</option>
													<?php
														endforeach;
														
													}
												?>
											</select>

										</div>
										<div class="form-group">
												<label>JUMLAH MAHASISWA</label>
												<input type="number" name="jumlah_mahasiswa" class="form-control" placeholder="Masukkan jumlah mahasiswa.." required>
										</div>
											

									</div>

									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-info">Simpan</button>
									</div>
								</form>
								</div>
								</div>
							</div>

								<!-- modal edit -->
								<div class="modal fade" id="modal_edit<?php echo $id_jadwal_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary">
										<h3 class="modal-title" id="myModalLabel">Edit Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/edit_jadwal_pengampu_matkul'?>" enctype="multipart/form-data">
										<div class="modal-body">
										
											<div class="form-group">
												<label class="control-label col-xs-3" >MATAKULIAH</label>
												<select id="kode_mk" name="kode_mk" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_matkul->result_array() as $i):
															$kode_matkul_combo=$i['kode_mk'];
															$nama_matkul_combo=$i['nama_mk'];
															
													?>
													<option  value="<?php echo $kode_matkul_combo ?>" <?php if($kode_matkul_combo==$kode_matkul){ echo 'selected'; } ?>>
														<?php echo $kode_matkul_combo," - ",$nama_matkul_combo?>
													</option>
													<?php endforeach;?>
												</select>
											</div>

											<div class="form-group bg-warning rounded mt-3 mb-3">
											<label class="control-label col-xs-3" >DOSEN PENGAMPU-1</label>
											<select id="dosen_pengampu1" name="dosen_pengampu1" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>" <?php if($npk_combo==$array_dosen_hasil[0]){ echo 'selected'; } ?>>
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

											<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-2 <i class="text-danger">optional</i></label>
											<select id="dosen_pengampu2" name="dosen_pengampu2" class="form-control">
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>" <?php if($npk_combo==$array_dosen_hasil[1]){ echo 'selected'; } ?>>
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

											<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-3 <i class="text-danger">optional</i></label>
											<select id="dosen_pengampu3" name="dosen_pengampu3" class="form-control">
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_dosen_semua->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												?>
												<option  value="<?php echo $npk_combo ?>" <?php if($npk_combo==$array_dosen_hasil[2]){ echo 'selected'; } ?>>
													<?php echo $nama_dosen_combo?>
												</option>
												<?php endforeach;?>
											</select>

										</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >JUMLAH KELAS</label>
												<div class="col-xs-8">
													<input name="jumlah_kelas" value="<?php echo $jumlah_kelas; ?>" class="form-control" type="number" placeholder="Jumlah kelas..." required>
												</div>
											</div>
											<input type="hidden" name="id_jadwal_pengampu" value="<?php echo $id_jadwal_pengampu; ?>">

										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info">Simpan Perubahan</button>
										</div>
									</form>
									</div>
									</div>
								</div>

								<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_jadwal_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/hapus_jadwal_pengampu_matkul'?>">
										<div class="modal-body">
											<p>Anda yakin menghapus jadwal matakuliah <b><?php echo $nama_mk;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_jadwal_pengampu" value="<?php echo $id_jadwal_pengampu;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>


								<div class="modal fade" id="modal_detail<?php echo $id_jadwal_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-info">
										<h3 class="modal-title" id="myModalLabel">Detail Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<table class="table">
										<tr>
											<td>ID Jadwal</td>
											<td>:</td>
											<td><?php echo $id_jadwal_pengampu;?></td>
										</tr>
										<tr>
											<td>Tahun Ajaran</td>
											<td>:</td>
											<td><?php echo $tahun_ajaran;?></td>
										</tr>
										<tr>
											<td>Semester</td>
											<td>:</td>
											<td><?php echo $semester;?></td>
										</tr>
										<tr>
											<td>Nama Matakuliah</td>
											<td>:</td>
											<td><?php echo $nama_mk;?></td>
										</tr>
										<tr>
											<td>Dosen Pengampu</td>
											<td>:</td>
											<td>
												<?php 
													$index = 0;
													$array_dosen_result = array();

													foreach ($array_dosen as $npk) {
														$nama_dosen = $this->m_jadwal_pengampu_matkul->getNamaDosen($npk);
														$array_dosen_result[$index++] = $nama_dosen;
													}

													echo $string_dosen_hasil = implode('/ ', $array_dosen_result)

												?>
											</td>
										</tr>
										<tr>
											<td>Jumlah Kelas</td>
											<td>:</td>
											<td><?php echo $jumlah_kelas;?></td>
										</tr>
										<tr>
											<td>Jumlah Kelas Terjadwal</td>
											<td>:</td>
											<td><?php echo $terjadwal;?> <a class="text-primary" data-toggle="modal" data-target="#modal_detail_kelas<?php echo $id_jadwal_pengampu;?>"><i class="fa fa-eye"></i></a></td>
										</tr>
									
										

									</table>
								
											<div class="modal-footer">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</div>
									</div>
								</div>


								<!-- modal detail kelas -->
								<div class="modal fade" id="modal_detail_kelas<?php echo $id_jadwal_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header bg-info">
												<h3 class="modal-title" id="myModalLabel">Detail List Kelas</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<div class="modal-body">
												<div class="table-responsive">
													<table class="table">
														<tr>
															<th>No</th>
															<th>Kelas</th>
															<th>Jumlah Mahasisw</th>
															<th>Jadwal Pertemuan Awal Mulai</th>
															<th>Jadwal Pertemuan Awal Selesai</th>
															<th>Aksi</th>
														</tr>
														<?php
														$nomor = 1;
														$list_kelas = $this->m_jadwal_pengampu_matkul->detail_list_kelas($id_jadwal_pengampu);
														if(count($list_kelas->result_array())){
															foreach($list_kelas->result_array() as $a):
														?>

														<tr>
															<td><?php echo $nomor++?></td>
															<td><?php echo $a['nama_kelas'];?></td>
															<td><?php echo $a['jumlah_mahasiswa'];?></td>
															<td><?php echo $a['waktu_pertemuan_pertama'];?></td>
															<td><?php echo $a['waktu_pertemuan_pertama_selesai'];?></td>
															<td>
																<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit_kelas<?php echo $a['id_jadwal_kelas_pertemuan'];?>"><i class="fa fa-pen"></i></a>
																<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_kelas<?php echo $a['id_jadwal_kelas_pertemuan'];?>"><i class="fa fa-trash"></i></a>
															</td>
														</tr>

														<?php
															endforeach;
														}else{
														?>
															<tr>
																<td colspan="4" class="text-center text-danger">Belum ada kelas yang didaftarkan</td>
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
										</div>
									</div>
								</div>

							<?php 
								endforeach;
							?>
							<!--END MODAL RINCIAN-->

							<!-- ============ MODAL JADWALKAN KELAS =============== -->
						<?php 
							foreach($show_jadwal_kelas_pertemuan->result_array() as $i):

								$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
								$waktu_pertemuan_pertama=$i['waktu_pertemuan_pertama'];
								$waktu_pertemuan_pertama_selesai=$i['waktu_pertemuan_pertama_selesai'];
								$nama_kelas=$i['nama_kelas'];
								$jumlah_mahasiswa=$i['jumlah_mahasiswa'];

								$tanggal_pertemuan_pertama = date("Y-m-d", strtotime($waktu_pertemuan_pertama));
								$jam_pertemuan_pertama = date("H:i", strtotime($waktu_pertemuan_pertama));
								$jam_pertemuan_pertama_selesai = date("H:i", strtotime($waktu_pertemuan_pertama_selesai));
								
							?>
							<div class="modal fade" id="modal_edit_kelas<?php echo $id_jadwal_kelas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-secondary">
									<h3 class="modal-title" id="myModalLabel">Edit Jadwal Kelas</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/edit_jadwal_kelas_pertemuan'?>" enctype="multipart/form-data">
									<div class="modal-body">
										<input type="hidden" name="id_jadwal_kelas_pertemuan" class="form-control" value="<?php echo $id_jadwal_kelas_pertemuan?>">
										
										<div class="form-group">
											<label class="control-label col-xs-3" >WAKTU PERTEMUAN PERTAMA (TANGGAL)</label>
											<div class="row">
												<div class="form-group"><input type="date" value="<?= $tanggal_pertemuan_pertama ?>" name="tanggal_pertemuan_pertama" class="form-control" required></div>

											</div>
											<div class="row">
												<div class="col-md-6">
													<label>JAM MULAI</label>
													<div class="form-group"><input type="time" value="<?= $jam_pertemuan_pertama ?>" name="jam_pertemuan_pertama" class="form-control" required></div>
												</div>
												<div class="col-md-6">
													<label>JAM SELESAI</label>
													<div class="form-group"><input type="time" value="<?= $jam_pertemuan_pertama_selesai ?>" name="jam_pertemuan_pertama_akhir" class="form-control" required></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>KELAS</label>
											<select name="nama_kelas" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php 
													$z= $this->m_jadwal_pengampu_matkul->combobox_kelas($_SESSION['kode_prodi'], $semester);
													if($z){
														foreach($z->result_array() as $y):
															$semester_combo=$y['semester'];
															$nama_kelas_combo=$y['nama_kelas'];
															$kelas_pilihan_combo=$y['kelas_pilihan'];
															if($semester_combo=='0'){
																$semester_combo = '';
															}
															if($kelas_pilihan_combo=="PIL"){
																$kelas_combo = $semester_combo.$nama_kelas_combo.' '.$kelas_pilihan_combo;
															}else{
																$kelas_combo = $semester_combo.$nama_kelas_combo;
															}
															

													?>
													<option  value="<?php echo $kelas_combo; ?>" <?php if($kelas_combo==$nama_kelas){ echo 'selected'; } ?>>
														<?php echo $kelas_combo; ?>
													</option>
													<?php
														endforeach;
														
													}
												?>
											</select>

										</div>
										<div class="form-group">
												<label>JUMLAH MAHASISWA</label>
												<input type="number" name="jumlah_mahasiswa" value="<?= $jumlah_mahasiswa; ?>" class="form-control" placeholder="Masukkan jumlah mahasiswa.." required>
										</div>
											

									</div>

									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-secondary">Simpan Perubahan</button>
									</div>
								</form>
								</div>
								</div>
							</div>

							<!-- ============ MODAL HAPUS =============== -->
							<div class="modal fade" id="modal_hapus_kelas<?php echo $id_jadwal_kelas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-danger">
									<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Kelas Pertemuan</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/hapus_jadwal_kelas_pertemuan'?>">
									<div class="modal-body">
										<p>Anda yakin menghapus jadwal kelas <b><?php echo $nama_kelas;?></b>?</p>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?php echo $id_jadwal_kelas_pertemuan;?>">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-danger">Hapus</button>
									</div>
								</form>
								</div>
								</div>
							</div>

						<?php endforeach;?>
						<!--END MODAL JADWALKAN KELAS-->

		<?php } ?>
							
										
									
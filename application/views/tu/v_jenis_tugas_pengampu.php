		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">TANDAI JENIS TUGAS PENGAMPU</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
										<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tandai Tugas Pengampu</a>
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
											<form action="<?php echo base_url('tu/jenis_tugas_pengampu')?>" method="post">
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
													<td align="center"><b>SEMUA DOSEN PENGAMPU</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>NAMA KELAS</b></td>
													<td align="center"><b>JENIS TUGAS</b></td>
													<td align="center"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>
												<?php 
													$no = 1;
													foreach($data->result_array() as $i):
														$id_tugas_pengampu=$i['id_tugas_pengampu'];
														
														
														$tahun_ajaran=$i['tahun_ajaran'];
														
														$nama_mk=$i['nama_mk'];

														$dosen_pengampu=$i['dosen_pengampu'];
														$nama_dosen_pengampu_array = array();
														$dosen_pengampu_string = '';
														$dosen_pengampu_array = explode(', ', $dosen_pengampu);
														foreach ($dosen_pengampu_array as $npk) {
															$nama_dosen_pengampu_array[] = $this->m_jenis_tugas_pengampu->getNamaDosen($npk);
														}
														$nama_dosen_pengampu_string = implode(', ', $nama_dosen_pengampu_array);

														$nama_kelas=$i['nama_kelas'];

														$npk_tugas=$i['npk_tugas'];
														$nama_npk_tugas_array = array();
														$npk_tugas_string = '';
														$npk_tugas_array = explode(', ', $npk_tugas);
														foreach ($npk_tugas_array as $npk) {
															$nama_npk_tugas_array[] = $this->m_jenis_tugas_pengampu->getNamaDosen($npk);
														}
														$nama_npk_tugas_string = implode(', ', $nama_npk_tugas_array);

														$kategori_tugas=$i['kategori_tugas'];
												?>
											
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $nama_dosen_pengampu_string;?></td>
													<td><?php echo $nama_npk_tugas_string;?></td>
													<td><?php echo $nama_mk;?></td>
													<td><?php echo $nama_kelas; ?></td>
													<td><?php echo $kategori_tugas; ?></td>
													<td style="" class="text-white">
													
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_tugas_pengampu;?>"><i class="fa fa-trash"></i> Hapus</a>

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
								<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jenis_tugas_pengampu/tandai_tugas_pengampu')?>">
									<div class="modal-body">

										<div class="form-group">
											<label class="control-label col-xs-3" >KELAS TERJADWAL</label>
											<select name="value_string" class="form-control" required>
												<option value="">--Pilih--</option>
												<?php
													foreach($combobox_kelas_terjadwal->result_array() as $i):
														$id_jadwal_kelas_pertemuan_combo=$i['id_jadwal_kelas_pertemuan'];
														$dosen_pengampu_combo=$i['dosen_pengampu'];
														$npk_array = explode(', ', $dosen_pengampu_combo);
														$nama_mk_combo=$i['nama_mk'];
														$nama_kelas_combo=$i['nama_kelas'];

														foreach ($npk_array as $j) {
															
															
															if($this->m_jenis_tugas_pengampu->cekKetersediaanTugas($id_jadwal_kelas_pertemuan_combo, $j)==0){

															$value_string = $id_jadwal_kelas_pertemuan_combo.', '.$j;
															$nama_dosen = $this->m_jenis_tugas_pengampu->getNamaDosen($j);
												?>
												<option  value="<?php echo $value_string ?>">
													<?php echo $nama_dosen.' -> '.$nama_mk_combo.' ('.$nama_kelas_combo.')'; ?>
												</option>
												<?php 
															}
														}
													endforeach;
													?>
											</select>
										</div>
										<div class="form-group">
											<label class="control-label col-xs-3" >KATEGORI TUGAS</label>
											<select name="kategori_tugas" class="form-control" required>
												<option value="">--Pilih--</option>
												<option value="Tugas Pokok">Tugas Pokok</option>
												<option value="Tugas Luar Biasa">Tugas Luar Biasa</option>
												
											</select>
										</div>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-info" name="tandai_tugas_pengampu">Simpan</button>
									</div>
								</form>
								</div>
								</div>
							</div>
						<!--END MODAL ADD-->

							<?php 
							foreach($data->result_array() as $i):
								$id_tugas_pengampu=$i['id_tugas_pengampu'];
								$dosen_pengampu=$i['dosen_pengampu'];
								$nama_kelas=$i['nama_kelas'];
								$nama_mk=$i['nama_mk'];
							?>
						<!-- ============ MODAL HAPUS =============== -->
							<div class="modal fade" id="modal_hapus<?php echo $id_tugas_pengampu;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-danger">
									<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Pengampu</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jenis_tugas_pengampu/hapus_kategori_tugas'?>">
									<div class="modal-body">
										<p>Anda yakin menghapus kategori tugas  <b><?php echo $dosen_pengampu;?></b> dalam matakuliah <b><?php echo $nama_mk;?></b> di kelas <b><?php echo $nama_kelas;?></b>?</p>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="id_tugas_pengampu" value="<?php echo $id_tugas_pengampu;?>">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-danger" name="hapus_kategori_tugas">Hapus</button>
									</div>
								</form>
								</div>
								</div>
							</div>
						<?php endforeach;?>
						<!--END MODAL HAPUS -->

						
		<?php } ?>
							
										
									
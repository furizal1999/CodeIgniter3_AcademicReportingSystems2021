		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR UJIAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Ujian</a>		
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
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>TAHUN AJARAN</b></td>
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>NAMA UJIAN</b></td>
												<td align="center"><b>UJIAN MULAI</b></td>
												<td align="center"><b>UJIAN SELESAI</b></td>
												<td align="center"><b>JENIS UJIAN</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_ujian=$i['id_ujian'];
													$id_pertemuan=$i['id_pertemuan'];
													$id_semester=$i['id_semester'];
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$semester=$i['semester'];
													$nama_ujian=$i['nama_ujian'];
													$range_mulai_ujian=$i['range_mulai_ujian'];
													$range_selesai_ujian=$i['range_selesai_ujian'];
													$ket_ujian=$i['ket_ujian'];
													$jenis_pertemuan=$i['jenis_pertemuan'];
													$pertemuan_mulai=$i['pertemuan_mulai'];
													$pertemuan_selesai=$i['pertemuan_selesai'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tahun_ajaran;?></td>
												<td><?php echo $semester;?></td>
												<td><?php echo $nama_ujian;?></td>
												<td><?php echo $range_mulai_ujian;?></td>
												<td><?php echo $range_selesai_ujian;?></td>
												<td><?php echo $ket_ujian; ?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_ujian;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_ujian;?>"><i class="fa fa-trash"></i> Hapus</a>
													<!-- <p class="text-warning">NO ACTION</p> -->
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>


							

						<!-- ============ MODAL ADD =============== -->
								<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-primary text-white">
										<h3 class="modal-title" id="myModalLabel">Tambah Ujian</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/ujian/tambah_ujian')?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >Surat Keputusan Ujian</label>
												<select name="id_surat_keputusan" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_surat_keputusan->result_array() as $i):
															$id_surat_combo=$i['id_surat'];
															$nomor_surat_combo=$i['nomor_surat'];
															$ket_ujian_combo=$i['ket_ujian'];
													?>
													<option  value="<?php echo $id_surat_combo ?>">
														<?php echo $nomor_surat_combo.' ('.$ket_ujian_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div> 
											<div class="form-group">
												<label class="control-label col-xs-3" >Pilih Relasi Pertemuan</label>
												<select name="id_pertemuan" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_pertemuan->result_array() as $i):
															$id_pertemuan_combo=$i['id_pertemuan'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$semester_combo=$i['semester'];
															$jenis_pertemuan_combo=$i['jenis_pertemuan'];
															$pertemuan_mulai_combo=$i['pertemuan_mulai'];
															$pertemuan_selesai_combo=$i['pertemuan_selesai'];
													?>
													<option  value="<?php echo $id_pertemuan_combo ?>">
														<?php echo $tahun_ajaran_combo.' ('.$semester_combo.' - '.$jenis_pertemuan_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div> 
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Ujian</label>
												<select name="nama_ujian" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Ujian Tengah Semester">Ujian Tengah Semester</option>
													<option  value="Ujian Akhir Semester">Ujian Akhir Semester</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Range Mulai Ujian</label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" name="tanggal_ujian_mulai" class="form-control">
													</div>
													<div class="col-md-6">
														<input type="time" name="jam_ujian_mulai" class="form-control" value="00:00:00" readonly>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Range Selesai Ujian</label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" name="tanggal_ujian_selesai" class="form-control">
													</div>
													<div class="col-md-6">
														<input type="time" name="jam_ujian_selesai" class="form-control" value="23:59" readonly>
													</div>
												</div>
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
							<!--END MODAL ADD-->
							
							<!-- ============ MODAL EDIT =============== -->
							<?php 
								foreach($data->result_array() as $i):
									$id_ujian=$i['id_ujian'];
									$id_pertemuan=$i['id_pertemuan'];
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$id_surat_keputusan=$i['id_surat_keputusan'];
									$range_mulai_ujian=$i['range_mulai_ujian'];
									$range_selesai_ujian=$i['range_selesai_ujian'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$semester=$i['semester'];
									$nama_ujian=$i['nama_ujian'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Ujian</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/ujian/edit_ujian'?>">
										<div class="modal-body">
											

											<div class="form-group">
												<label class="control-label col-xs-3" >Surat Keputusan Ujian</label>
												<select name="id_surat_keputusan" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_surat_keputusan->result_array() as $i):
															$id_surat_combo=$i['id_surat'];
															$nomor_surat_combo=$i['nomor_surat'];
															$ket_ujian_combo=$i['ket_ujian'];
													?>
													<option  value="<?php echo $id_surat_combo ?>" <?php if($id_surat_combo==$id_surat_keputusan){ echo 'selected'; } ?>>
														<?php echo $nomor_surat_combo.' ('.$ket_ujian_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div> 
											<div class="form-group">
												<label class="control-label col-xs-3" >Pilih Relasi Pertemuan</label>
												<select name="id_pertemuan" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_pertemuan->result_array() as $i):
															$id_pertemuan_combo=$i['id_pertemuan'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$semester_combo=$i['semester'];
															$jenis_pertemuan_combo=$i['jenis_pertemuan'];
															$pertemuan_mulai_combo=$i['pertemuan_mulai'];
															$pertemuan_selesai_combo=$i['pertemuan_selesai'];
													?>
													<option  value="<?php echo $id_pertemuan_combo ?>" <?php if($id_pertemuan_combo==$id_pertemuan){ echo 'selected'; } ?>>
														<?php echo $tahun_ajaran_combo.' ('.$semester_combo.' - '.$jenis_pertemuan_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div> 
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Ujian</label>
												<select name="nama_ujian" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Ujian Tengah Semester" <?php if($nama_ujian=="Ujian Tengah Semester"){ echo 'selected'; } ?>>Ujian Tengah Semester</option>
													<option  value="Ujian Akhir Semester" <?php if($nama_ujian=="Ujian Akhir Semester"){ echo 'selected'; } ?>>Ujian Akhir Semester</option>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Range Mulai Ujian</label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" name="tanggal_ujian_mulai" value="<?= date('Y-m-d', strtotime($range_mulai_ujian)) ?>" class="form-control">
													</div>
													<div class="col-md-6">
														<input type="time" name="jam_ujian_mulai" class="form-control" value="00:00:00" readonly>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Range Selesai Ujian</label>
												<div class="row">
													<div class="col-md-6">
														<input type="date" name="tanggal_ujian_selesai" value="<?= date('Y-m-d', strtotime($range_selesai_ujian)) ?>" class="form-control">
													</div>
													<div class="col-md-6">
														<input type="time" name="jam_ujian_selesai" class="form-control" value="23:59" readonly>
													</div>
												</div>
											</div>

											<input type="hidden" name="id_ujian" value="<?php echo $id_ujian; ?>">
										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info">Simpan Perubahan</button>
										</div>
									</form>
									</div>
									</div>
								</div>

							<?php endforeach;?>
							<!--END MODAL EDIT-->
							
							<?php 
								foreach($data->result_array() as $i):
									$id_ujian=$i['id_ujian'];
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$nama_ujian=$i['nama_ujian'];
									
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Pertemuan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/ujian/hapus_ujian'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus ujian <b><?php echo $nama_ujian;?></b> pada tahun ajaran <b><?php echo $tahun_ajaran.' ('.$semester.')';?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_ujian" value="<?php echo $id_ujian;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

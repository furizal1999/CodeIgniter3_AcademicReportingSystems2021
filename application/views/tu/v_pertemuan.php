		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PERTEMUAN TATAP MUKA DOSEN PENGAMPU</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Pertemuan Tatap Muka</a>		
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
												<td align="center"><b>JENIS PERTEMUAN</b></td>
												<td align="center"><b>RANGE</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_pertemuan=$i['id_pertemuan'];
													$id_semester=$i['id_semester'];
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$semester=$i['semester'];
													$jenis_pertemuan=$i['jenis_pertemuan'];
													$pertemuan_mulai=$i['pertemuan_mulai'];
													$pertemuan_selesai=$i['pertemuan_selesai'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tahun_ajaran;?></td>
												<td><?php echo $semester;?></td>
												<td><?php echo $jenis_pertemuan;?></td>
												<td><?php echo '<div class="text-success">'.$pertemuan_mulai.'</div> s/d '.'<div class="text-danger">'.$pertemuan_selesai.'</div>';?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_pertemuan;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_pertemuan;?>"><i class="fa fa-trash"></i> Hapus</a>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Pertemuan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/pertemuan/tambah_pertemuan')?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="id_semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_semester->result_array() as $i):
															$id_semester_combo=$i['id_semester'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$semester_combo=$i['semester'];
													?>
													<option  value="<?php echo $id_semester_combo ?>">
														<?php echo $tahun_ajaran_combo.' ('.$semester_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >JENIS PERTEMUAN</label>
												<select name="jenis_pertemuan" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Offline">Offline</option>
													<option  value="Online">Online</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >WAKTU MULAI PERTEMUAN</label>
												<div class="row">
													<div><input type="date" name="tanggal_pertemuan_mulai" class="form-control" required></div>
													<div><input type="time" name="jam_pertemuan_mulai" class="form-control" required></div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >WAKTU SELESAI PERTEMUAN</label>
												<div class="row">
													<div><input type="date" name="tanggal_pertemuan_selesai" class="form-control" required></div>
													<div><input type="time" name="jam_pertemuan_selesai" class="form-control" required></div>
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
									$id_pertemuan=$i['id_pertemuan'];
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$jenis_pertemuan=$i['jenis_pertemuan'];
									$pertemuan_mulai=$i['pertemuan_mulai'];
									$pertemuan_selesai=$i['pertemuan_selesai'];

									$tanggal_pertemuan_mulai = date("Y-m-d", strtotime($pertemuan_mulai));
									$jam_pertemuan_mulai = date("H:i:s", strtotime($pertemuan_mulai));
									$tanggal_pertemuan_selesai = date("Y-m-d", strtotime($pertemuan_selesai));
									$jam_pertemuan_selesai = date("H:i:s", strtotime($pertemuan_selesai));

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Pertemuan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/pertemuan/edit_pertemuan'?>">
										<div class="modal-body">
											

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="id_semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_semester->result_array() as $i):
															$id_semester_combo=$i['id_semester'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$semester_combo=$i['semester'];
													?>
													<option  value="<?php echo $id_semester_combo ?>" <?php if($id_semester_combo==$id_semester){ echo 'selected'; } ?>>
														<?php echo $tahun_ajaran_combo.' ('.$semester_combo.')'; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >JENIS PERTEMUAN</label>
												<select name="jenis_pertemuan" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Offline" <?php if($jenis_pertemuan=="Offline"){ echo 'selected'; } ?>>Offline</option>
													<option  value="Online" <?php if($jenis_pertemuan=="Online"){ echo 'selected'; } ?>>Online</option>
												</select>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >WAKTU MULAI PERTEMUAN</label>
												<div class="row">
													<div><input type="date" name="tanggal_pertemuan_mulai" value="<?php echo $tanggal_pertemuan_mulai ?>" class="form-control" required></div>
													<div><input type="time" name="jam_pertemuan_mulai" value="<?php echo $jam_pertemuan_mulai ?>" class="form-control" required></div>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >WAKTU SELESAI PERTEMUAN</label>
												<div class="row">
													<div><input type="date" name="tanggal_pertemuan_selesai" value="<?php echo $tanggal_pertemuan_selesai ?>" class="form-control" required></div>
													<div><input type="time" name="jam_pertemuan_selesai" value="<?php echo $jam_pertemuan_selesai ?>" class="form-control" required></div>
												</div>
											</div>

											<input type="hidden" name="id_pertemuan" value="<?php echo $id_pertemuan; ?>">
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
									$id_pertemuan=$i['id_pertemuan'];
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$jenis_pertemuan=$i['jenis_pertemuan'];
									$pertemuan_mulai=$i['pertemuan_mulai'];
									$pertemuan_selesai=$i['pertemuan_selesai'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Pertemuan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/pertemuan/hapus_pertemuan'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus Pertemuan pada tahun ajaran <b><?php echo $tahun_ajaran.' ('.$semester.')';?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_pertemuan" value="<?php echo $id_pertemuan;?>">
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

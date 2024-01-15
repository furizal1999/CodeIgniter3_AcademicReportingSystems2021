<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SEMESTER</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Semester</a>		
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
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													
													$id_semester=$i['id_semester'];
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$semester=$i['semester'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tahun_ajaran;?></td>
												<td><?php echo $semester;?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_semester;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_semester;?>"><i class="fa fa-trash"></i> Hapus</a>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Semester</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/semester/tambah_semester')?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >Tahun Ajaran</label>
												<select name="id_tahun_ajaran" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_tahun_ajaran->result_array() as $i):
															$id_tahun_ajaran_combo=$i['id_tahun_ajaran'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$status_combo=$i['status'];
													?>
													<option  value="<?php echo $id_tahun_ajaran_combo ?>">
														<?php echo $tahun_ajaran_combo; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Ganjil">Ganjil</option>
													<option  value="Genap">Genap</option>
												</select>
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
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_semester;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Semester</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/semester/edit_semester'?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >Tahun Ajaran</label>
												<select name="id_tahun_ajaran" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														foreach($combobox_tahun_ajaran->result_array() as $i):
															$id_tahun_ajaran_combo=$i['id_tahun_ajaran'];
															$tahun_ajaran_combo=$i['tahun_ajaran'];
															$status_combo=$i['status'];
													?>
													<option  value="<?php echo $id_tahun_ajaran_combo ?>" <?php if($id_tahun_ajaran_combo==$id_tahun_ajaran){ echo 'selected'; } ?>>
														<?php echo $tahun_ajaran_combo; ?>
													</option>
													<?php endforeach;?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Ganjil" <?php if($semester=="Ganjil"){ echo 'selected'; } ?>>Ganjil</option>
													<option  value="Genap" <?php if($semester=="Genap"){ echo 'selected'; } ?>>Genap</option>
												</select>
											</div>
											<input type="hidden" name="id_semester" value="<?php echo $id_semester; ?>">
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
									$id_semester=$i['id_semester'];
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_semester;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Semester</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/semester/hapus_semester'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus Semester <b><?php echo $tahun_ajaran;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_semester" value="<?php echo $id_semester;?>">
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

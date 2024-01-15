
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">HARI LIBUR</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Jadwal Libur</a>		
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
												<td align="center"><b>NO</b></td>
												<td align="center"><b>Waktu Mulai</b></td>
												<td align="center"><b>waktu Selesai</b></td>
												<td align="center"><b>Agenda Libur</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_jadwal_libur_pertemuan=$i['id_jadwal_libur_pertemuan'];
													$waktu_jadwal_libur_mulai=$i['waktu_jadwal_libur_mulai'];
													$waktu_jadwal_libur_selesai=$i['waktu_jadwal_libur_selesai'];
													$agenda_libur=$i['agenda_libur'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $waktu_jadwal_libur_mulai;?></td>
												<td><?php echo $waktu_jadwal_libur_selesai;?></td>
												<td><?php echo $agenda_libur;?></td>
												<td class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_jadwal_libur_pertemuan;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_jadwal_libur_pertemuan;?>"><i class="fa fa-trash"></i> Hapus</a>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Jadwal Libur</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jadwal_libur/tambah_jadwal_libur')?>">
										<div class="modal-body">

											<div class="form-group col-md-12">
												<label class="control-label col-xs-3" >WAKTU MULAI LIBUR</label>
												<div class="row">
													<div class="col-md-6"><input type="date" name="tanggal_libur_mulai" class="form-control" required></div>
													<div class="col-md-6"><input type="time" value="00:00:00" name="jam_libur_mulai" class="form-control" readonly></div>
												</div>
											</div>
											<div class="form-group col-md-12">
												<label class="control-label col-xs-3" >WAKTU SELESAI LIBUR</label>
												<div class="row">
													<div class="col-md-6"><input type="date" name="tanggal_libur_selesai" class="form-control" required></div>
													<div class="col-md-6"><input type="time" value="23:59:00" name="jam_libur_selesai" class="form-control" readonly></div>
												</div>
											</div>
											<div class="form-group col-md-12">
												<label class="control-label" >AGENDA LIBUR</label>
												<textarea class="form-control" name="agenda_libur"></textarea>
											</div>
										
										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info" name="tambah_jadwal_libur">Simpan</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<!--END MODAL ADD-->
							
							<!-- ============ MODAL EDIT =============== -->
							<?php 
								foreach($data->result_array() as $i):
									$id_jadwal_libur_pertemuan=$i['id_jadwal_libur_pertemuan'];
									$waktu_jadwal_libur_mulai=$i['waktu_jadwal_libur_mulai'];
									$waktu_jadwal_libur_selesai=$i['waktu_jadwal_libur_selesai'];
									$agenda_libur=$i['agenda_libur'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_jadwal_libur_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Admin Tata Usaha</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jadwal_libur/edit_jadwal_libur')?>">
											<div class="modal-body">

												<div class="form-group col-md-12">
													<label class="control-label col-xs-3" >WAKTU MULAI LIBUR</label>
													<div class="row">
														<div class="col-md-6"><input type="date" value="<?= date("Y-m-d", strtotime($waktu_jadwal_libur_mulai))?>" name="tanggal_libur_mulai" class="form-control" required></div>
														<div class="col-md-6"><input type="time" value="00:00:00" name="jam_libur_mulai" class="form-control" readonly></div>
													</div>
												</div>
												<div class="form-group col-md-12">
													<label class="control-label col-xs-3" >WAKTU SELESAI LIBUR</label>
													<div class="row">
														<div class="col-md-6"><input type="date" value="<?= date("Y-m-d", strtotime($waktu_jadwal_libur_selesai)) ?>" name="tanggal_libur_selesai" class="form-control" required></div>
														<div class="col-md-6"><input type="time" value="23:59:00" name="jam_libur_selesai" class="form-control" readonly></div>
													</div>
												</div>
												<div class="form-group col-md-12">
													<label class="control-label" >AGENDA LIBUR</label>
													<textarea class="form-control" name="agenda_libur"><?= $agenda_libur ?></textarea>
												</div>
													
												<input type="hidden" name="id_jadwal_libur_pertemuan" value="<?= $id_jadwal_libur_pertemuan ?>">
											</div>

											<div class="modal-footer">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-secondary" name="edit_jadwal_libur">Simpan Perubahan</button>
											</div>
										</form>
									</div>
									</div>
								</div>

							<?php endforeach;?>
							<!--END MODAL EDIT-->


							<?php 
								foreach($data->result_array() as $i):
									$id_jadwal_libur_pertemuan=$i['id_jadwal_libur_pertemuan'];
									$waktu_jadwal_libur_mulai=$i['waktu_jadwal_libur_mulai'];
									$waktu_jadwal_libur_selesai=$i['waktu_jadwal_libur_selesai'];
									$agenda_libur=$i['agenda_libur'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_jadwal_libur_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Admin Tata Usaha</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_libur/hapus_jadwal_libur'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus jadwal libur <b><?php echo $agenda_libur;?></b> ini?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_jadwal_libur_pertemuan" value="<?php echo $id_jadwal_libur_pertemuan;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger" name="hapus_jadwal_libur">Ya</button>
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

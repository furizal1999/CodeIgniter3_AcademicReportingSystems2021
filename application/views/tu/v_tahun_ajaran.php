<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">TAHUN AJARAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Tahun Ajaran</a>		
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
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$status=$i['status'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tahun_ajaran;?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_tahun_ajaran;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_tahun_ajaran;?>"><i class="fa fa-trash"></i> Hapus</a>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Tahun Ajaran</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/tahun_ajaran/tambah_tahun_ajaran')?>">
										<div class="modal-body">
											
											<div class="form-group">
												<label class="control-label col-xs-3" >TAHUN AJARAN</label>
												<div class="row">
													<div class="col-3"><input type="number" name="tahun_awal" class="form-control" required></div>
													<div class="col-1 text-lg"><h1>/</h1></div>
													<div class="col-3"><input type="number" name="tahun_akhir" class="form-control" required></div>
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
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$status=$i['status'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_tahun_ajaran;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Tahun Ajaran</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/tahun_ajaran/edit_tahun_ajaran'?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >TAHUN AJARAN</label>
												<div class="row">
													<div class="col-3"><input type="number" name="tahun_awal" class="form-control" value="<?php echo substr($tahun_ajaran, 0,4)?>" required></div>
													<div class="col-1 text-lg"><h1>/</h1></div>
													<div class="col-3"><input type="number" name="tahun_akhir" class="form-control" value="<?php echo substr($tahun_ajaran, 5,4)?>" required></div>
												</div>
											</div>
											<input type="hidden" name="id_tahun_ajaran" value="<?php echo $id_tahun_ajaran?>">
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
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$status=$i['status'];	
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_tahun_ajaran;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Tahun Ajaran</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/tahun_ajaran/hapus_tahun_ajaran'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus tahun ajaran <b><?php echo $tahun_ajaran;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_tahun_ajaran" value="<?php echo $id_tahun_ajaran;?>">
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


		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR PROGRAM STUDI</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Prodi</a>		
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
								<div class="table-responsive" >
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>KODE PRODI</b></td>
												<td align="center"><b>NAMA PRODI</b></td>
												<td align="center"><b>JENJANG</b></td>
												<td align="center"><b>AKREDITASI</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												foreach($data->result_array() as $i):
													$kode_prodi=$i['kode_prodi'];
													$nama_prodi=$i['nama_prodi'];
													$jenjang=$i['jenjang'];
													$akreditasi=$i['akreditasi'];
											?>
												<td><?php echo $kode_prodi;?></td>
												<td><?php echo $nama_prodi;?></td>
												<td><?php echo $jenjang;?></td>
												<td><?php echo $akreditasi;?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $kode_prodi;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $kode_prodi;?>"><i class="fa fa-trash"></i> Hapus</a>
													
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
										<h3 class="modal-title" id="myModalLabel">Tambah Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('fakultas/program_studi/tambah_program_studi')?>">
										<div class="modal-body">
											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Prodi</label>
												<div class="col-xs-8">
													<input name="kode_prodi"  class="form-control" type="number" placeholder="Kode prodi..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Prodi</label>
												<div class="col-xs-8">
													<input name="nama_prodi"  class="form-control" type="text" placeholder="Nama prodi..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Jenjang</label>
												<div class="col-xs-8">
													<input name="jenjang" class="form-control" type="text" placeholder="jenjang..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Akreditasi</label>
												<div class="col-xs-8">
													<input name="akreditasi" class="form-control" type="text" placeholder="Akreditasi..." required>
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
									$kode_prodi=$i['kode_prodi'];
									$nama_prodi=$i['nama_prodi'];
									$jenjang=$i['jenjang'];
									$akreditasi=$i['akreditasi'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $kode_prodi;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'fakultas/program_studi/edit_program_studi'?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Prodi</label>
												<div class="col-xs-8">
													<input name="kode_prodi" value="<?php echo $kode_prodi?>" class="form-control" type="number" placeholder="Kode prodi..." readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Prodi</label>
												<div class="col-xs-8">
													<input name="nama_prodi" value="<?php echo $nama_prodi?>" class="form-control" type="text" placeholder="Nama prodi..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Jenjang</label>
												<div class="col-xs-8">
													<input name="jenjang" value="<?php echo $jenjang?>" class="form-control" type="text" placeholder="jenjang..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Akreditasi</label>
												<div class="col-xs-8">
													<input name="akreditasi" value="<?php echo $akreditasi?>" class="form-control" type="text" placeholder="Akreditasi..." required>
												</div>
											</div>
										
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
									$kode_prodi=$i['kode_prodi'];
									$nama_prodi=$i['nama_prodi'];
									$jenjang=$i['jenjang'];
									$akreditasi=$i['akreditasi'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $kode_prodi;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'fakultas/program_studi/hapus_program_studi'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus program studi <b><?php echo $nama_prodi;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="kode_prodi" value="<?php echo $kode_prodi;?>">
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

<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SURAT KEPUTUSAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Surat Keputusan</a>		
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
												<td align="center"><b>NOMOR SURAT</b></td>
												<td align="center"><b>NAMA SURAT</b></td>
												<td align="center"><b>NAMA DEKAN</b></td>
												<td align="center"><b>NPK DEKAN</b></td>
												<td align="center"><b>TANGGAL</b></td>
												<td align="center"><b>KET</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_surat=$i['id_surat'];
													$nomor_surat=$i['nomor_surat'];
													$nama_surat=$i['nama_surat'];
													$nama_dekan=$i['nama_dekan'];
													$npk=$i['npk'];
													$tanggal=$i['tanggal'];
													$ket=$i['ket_ujian'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $nomor_surat;?></td>
												<td><?php echo $nama_surat;?></td>
												<td><?php echo $nama_dekan;?></td>
												<td><?php echo $npk;?></td>
												<td><?php echo $tanggal;?></td>
												<td><?php echo $ket;?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_surat;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_surat;?>"><i class="fa fa-trash"></i> Hapus</a>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Surat Keputusan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/surat_keputusan/tambah_surat_keputusan')?>">
										<div class="modal-body">

											
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nomor Surat</label>
												<input type="text" name="nomor_surat" class="form-control" required>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nama Surat</label>
												<input type="text" name="nama_surat" class="form-control" value="<?php echo $nama_surat;?>" readonly>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nama Dekan</label>
												<input type="text" name="nama_dekan" class="form-control" required>
											</div>

											<div class="form-group text-left">
												<label class="control-label col-xs-3" >NPK Dekan</label>
												<input type="text" name="npk" class="form-control" required>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Sistem Ujian</label>
												<select name="ket" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Daring">Daring</option>
													<option  value="Luring">Luring</option>
												</select>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Tanggal Surat</label>
												<input type="date" name="tanggal" class="form-control" value="<?php echo date("Y-m-d");?>" required>
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
									$id_surat=$i['id_surat'];
									$nomor_surat=$i['nomor_surat'];
									$nama_surat=$i['nama_surat'];
									$nama_dekan=$i['nama_dekan'];
									$npk=$i['npk'];
									$tanggal=$i['tanggal'];
									$ket=$i['ket_ujian'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_surat;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Surat Keputusan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/surat_keputusan/edit_surat_keputusan'?>">
										<div class="modal-body">

											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nomor Surat</label>
												<input type="text" name="nomor_surat" class="form-control" value="<?php echo $nomor_surat;?>" required>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nama Surat</label>
												<input type="text" name="nama_surat" class="form-control" value="<?php echo $nama_surat;?>" readonly>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Nama Dekan</label>
												<input type="text" name="nama_dekan" class="form-control" value="<?php echo $nama_dekan;?>" required>
											</div>

											<div class="form-group text-left">
												<label class="control-label col-xs-3" >NPK Dekan</label>
												<input type="text" name="npk" class="form-control" value="<?php echo $npk;?>" required>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Sistem Ujian</label>
												<select name="ket" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="Daring" <?php if($ket=="Daring") echo 'selected';?>>Daring</option>
													<option  value="Luring" <?php if($ket=="Luring") echo 'selected';?>>Luring</option>
												</select>
											</div>
											<div class="form-group text-left">
												<label class="control-label col-xs-3" >Tanggal Surat</label>
												<input type="date" name="tanggal" class="form-control" value="<?php echo $tanggal;?>" required>
											</div>
											<input type="hidden" name="id_surat" value="<?php echo $id_surat?>" class="form-control">
												

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
									$id_surat=$i['id_surat'];
									$nomor_surat=$i['nomor_surat'];
									$nama_surat=$i['nama_surat'];
									$nama_dekan=$i['nama_dekan'];
									$npk=$i['npk'];
									$tanggal=$i['tanggal'];
									$ket=$i['ket_ujian'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_surat;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Surat Keputusan</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/surat_keputusan/hapus_surat_keputusan'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus <b><?php echo $nama_surat;?></b> dengan nomor  <b><?php echo $nomor_surat;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_surat" value="<?php echo $id_surat;?>">
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


		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR RUANGAN</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi ",$_SESSION['nama_prodi'];?> Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Ruang</a>		
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
												<td align="center"><b>NO</b></td>
												<td align="center"><b>KODE RUANG</b></td>
												<td align="center"><b>KAPASITAS RUANG</b></td>
												<td align="center"><b>KETERANGAN</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no= 1;
												foreach($data->result_array() as $i):
													$kode_ruang=$i['kode_ruang'];
													$kapasitas=$i['kapasitas'];
													$kode_jurusan=$i['kode_jurusan'];
													$ket=$i['ket'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $kode_ruang;?></td>
												<td><?php echo $kapasitas," Orang";?></td>
												<td><?php echo $ket;?></td>
												<td style="width: 150px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo str_replace(".","-",$kode_ruang);?>"><i class="fa fa-pen"></i> Edit</a>
													<!-- <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo str_replace(".","-",$kode_ruang);?>"><i class="fa fa-trash"></i> Hapus</a> -->
													
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
										<h3 class="modal-title" id="myModalLabel">Tambah Ruang</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('prodi/ruang/tambah_ruang')?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Ruang</label>
												<div class="col-xs-8">
													<input name="kode_ruang" class="form-control" type="text" placeholder="Kode ruang..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Kapasitas Ruang</label>
												<div class="col-xs-8">
													<input name="kapasitas" class="form-control" type="number" placeholder="Kapasitas ruang..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Keterangan <i>(Optional)</i>	</label>
												<div class="col-xs-8">
													<textarea name="ket" cols="30" rows="3" class="form-control" placeholder="Keterangan tambahan (optional)..." ></textarea>
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
									$kode_ruang=$i['kode_ruang'];
									$kapasitas=$i['kapasitas'];
									$kode_jurusan=$i['kode_jurusan'];
									$ket=$i['ket'];

								?>
								<div class="modal fade" id="modal_edit<?php echo str_replace(".","-",$kode_ruang);?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Ruang</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/ruang/edit_ruang'?>">
										<div class="modal-body">

										<div class="form-group">
												<label class="control-label col-xs-3" >Kode Ruang</label>
												<div class="col-xs-8">
													<input name="kode_ruang" value="<?php echo $kode_ruang?>" class="form-control" type="text" placeholder="Kode ruang..." readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Kapasitas Ruang</label>
												<div class="col-xs-8">
													<input name="kapasitas" value="<?php echo $kapasitas?>" class="form-control" type="number" placeholder="Kapasitas ruang..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Keterangan <i>(Optional)</i>	</label>
												<div class="col-xs-8">
													<textarea name="ket" cols="30" rows="3" class="form-control" placeholder="Keterangan tambahan (optional)..." ><?php echo $ket?></textarea>
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
									$kode_ruang=$i['kode_ruang'];
									$kapasitas=$i['kapasitas'];
									$kode_jurusan=$i['kode_jurusan'];
									$ket=$i['ket'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo str_replace(".","-",$kode_ruang);?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Ruang</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/ruang/hapus_ruang'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus ruang <b><?php echo $kode_ruang;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="kode_ruang" value="<?php echo $kode_ruang;?>">
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

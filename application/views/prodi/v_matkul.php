
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR MATAKULIAH</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi ",$_SESSION['nama_prodi'];?> Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Matakuliah</a>		
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
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>KODE MATAKULIAH</b></td>
												<td align="center"><b>NAMA MATAKULIAH</b></td>
												<td align="center"><b>JUMLAH SKS</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												foreach($data->result_array() as $i):
													$kode_mk=$i['kode_mk'];
													$nama_mk=$i['nama_mk'];
													$sks_teori=$i['sks_teori'];
													$sks_praktik=$i['sks_praktik'];
													$semester=$i['semester'];
											?>
											<tr>
												<td><?php echo $semester;?></td>
												<td><?php echo $kode_mk;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $sks_teori+$sks_praktik;?></td>
												<td style="width: 270px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $kode_mk;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $kode_mk;?>"><i class="fa fa-trash"></i> Hapus</a>
													<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $kode_mk;?>"><i class="fa fa-book"></i> Rincian</a>

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
										<h3 class="modal-title" id="myModalLabel">Tambah Matakuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('prodi/matkul/tambah_matkul')?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Matakuliah</label>
												<div class="col-xs-8">
													<input name="kode_mk" class="form-control" type="text" placeholder="Kode matakuliah..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Matakuliah</label>
												<div class="col-xs-8">
													<input name="nama_mk" class="form-control" type="text" placeholder="Nama matakuliah..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Teori</label>
												<div class="col-xs-8">
													<input name="sks_teori" class="form-control" type="number" placeholder="Sks teori..." required>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Praktik</label>
												<div class="col-xs-8">
													<input name="sks_praktik" class="form-control" type="number" placeholder="Sks praktik..." required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<option value="TEAM TEACHING">TEAM TEACHING</option>
													<option value="PILIHAN">PILIHAN</option>
													<?php
														for($i=0; $i<8; $i++){
													?>
													<option  value="<?php echo ($i+1) ?>"><?php echo ($i+1) ?></option>
													<?php }?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Matakuliah Prasyarat <i class="text-danger">(OPTIONAL)</i></label>
												<select name="kode_mk_prasyarat" class="form-control">
													<option value="-">--Pilih--</option>
													<?php
														foreach($combobox_kode_mk_prasyarat->result_array() as $i):
															$kode_mk_combo=$i['kode_mk'];
															$nama_mk_combo=$i['nama_mk'];
													?>
													<option  value="<?php echo $kode_mk_combo ?>">
														<?php echo $kode_mk_combo," - ",$nama_mk_combo?>
													</option>
													<?php endforeach;?>
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
									$kode_mk=$i['kode_mk'];
									$nama_mk=$i['nama_mk'];
									$kode_jurusan=$i['kode_jurusan'];
									$semester=$i['semester'];
									$sks_teori=$i['sks_teori'];
									$sks_praktik=$i['sks_praktik'];
									$kode_mk_prasyarat=$i['kode_mk_prasyarat'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $kode_mk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Matakuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/matkul/edit_matkul'?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Matakuliah</label>
												<div class="col-xs-8">
													<input name="kode_mk" class="form-control" value="<?php echo $kode_mk?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Matakuliah</label>
												<div class="col-xs-8">
													<input name="nama_mk" class="form-control" value="<?php echo $nama_mk?>" required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Teori</label>
												<div class="col-xs-8">
													<input name="sks_teori" class="form-control" value="<?php echo $sks_teori?>" required>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Praktik</label>
												<div class="col-xs-8">
													<input name="sks_praktik" class="form-control" value="<?php echo $sks_praktik?>" required>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<option value="TEAM TEACHING" <?php if($semester=="TEAM TEACHING"){echo 'selected';}?>>TEAM TEACHING</option>
													<option value="PILIHAN" <?php if($semester=="PILIHAN"){echo 'selected';}?>>PILIHAN</option>

													<?php
														for($i=0; $i<8; $i++){
													?>
													<option  value="<?php echo ($i+1) ?>"<?php if($semester==($i+1)){echo 'selected';}?>><?php echo ($i+1) ?></option>
													<?php }?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Matakuliah Prasyarat <i class="text-danger">(OPTIONAL)</i></label>
												<select name="kode_mk_prasyarat" class="form-control" required>
													<option value="-">--Pilih--</option>
													<?php
														foreach($combobox_kode_mk_prasyarat->result_array() as $i):
															$kode_mk_combo=$i['kode_mk'];
															$nama_mk_combo=$i['nama_mk'];
													?>
													<option  value="<?php echo $kode_mk_combo ?>"<?php if($kode_mk_prasyarat==$kode_mk_combo){echo 'selected';}?>>
														<?php echo $kode_mk_combo," - ",$nama_mk_combo?>
													</option>
													<?php endforeach;?>
												</select>
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
									$kode_mk=$i['kode_mk'];
									$nama_mk=$i['nama_mk'];
									$kode_jurusan=$i['kode_jurusan'];
									$semester=$i['semester'];
									$sks_teori=$i['sks_teori'];
									$sks_praktik=$i['sks_praktik'];
									$kode_mk_prasyarat=$i['kode_mk_prasyarat'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $kode_mk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Matakuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/matkul/hapus_matkul'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus matakuliah <b><?php echo $nama_mk;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="kode_mk" value="<?php echo $kode_mk;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->
							
							<!-- ============ MODAL DETAIL =============== -->
							<?php 
								foreach($data->result_array() as $i):
									$kode_mk=$i['kode_mk'];
									$nama_mk=$i['nama_mk'];
									$kode_jurusan=$i['kode_jurusan'];
									$semester=$i['semester'];
									$sks_teori=$i['sks_teori'];
									$sks_praktik=$i['sks_praktik'];
									$kode_mk_prasyarat=$i['kode_mk_prasyarat'];

								?>
								<div class="modal fade" id="modal_detail<?php echo $kode_mk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-info text-white">
										<h3 class="modal-title" id="myModalLabel">Detail Matakuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'admin/bayar/simpan_pembayaran'?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Kode Matakuliah</label>
												<div class="col-xs-8">
													<input name="kode_mk" class="form-control" value="<?php echo $kode_mk?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Matakuliah</label>
												<div class="col-xs-8">
													<input name="nama_mk" class="form-control" value="<?php echo $nama_mk?>" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Teori</label>
												<div class="col-xs-8">
													<input name="sks_teori" class="form-control" value="<?php echo $sks_teori?>" readonly>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Jumlah SKS Praktik</label>
												<div class="col-xs-8">
													<input name="sks_praktik" class="form-control" value="<?php echo $sks_praktik?>" readonly>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<div class="col-xs-8">
													<input name="sks_teori" class="form-control" value="<?php echo $semester?>" readonly>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Matakuliah Prasyarat</label>
												<div class="col-xs-8">
													<?php
														$syarat = false;
														foreach($combobox_kode_mk_prasyarat->result_array() as $i):
															$kode_mk_combo=$i['kode_mk'];
															$nama_mk_combo=$i['nama_mk'];
															
															if($kode_mk_prasyarat==$kode_mk_combo){
														?>
														
														<input name="sks_praktik" class="form-control" value="<?php echo $nama_mk_combo;?>" readonly>

														<?php 
															$syarat = true;
															}
														endforeach;

															if($syarat==false){
														?>
														<input name="sks_praktik" class="form-control" value="<?php echo "Tidak ada matakuliah bersyarat";?>" readonly>
														<?php
															}
														
														?>


												</div>
											</div>
										
										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<!-- <button class="btn btn-info">Simpan Perubahan</button> -->
										</div>
									</form>
									</div>
									</div>
								</div>

							<?php endforeach;?>
							<!--END MODAL DETAIL-->

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

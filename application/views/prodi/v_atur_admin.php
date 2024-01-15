
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR ADMIN PRODI</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi ",$_SESSION['nama_prodi'];?> Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Admin Prodi</a>		
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
												<td align="center"><b>USERNAME</b></td>
												<td align="center"><b>NAMA LENGKAP</b></td>
												<td align="center"><b>JABATAN</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$username=$i['username'];
													$kode_prodi=$i['kode_prodi'];
													$nama_lengkap=$i['nama_lengkap'];
													$npk=$i['npk'];
													$jenis_kelamin=$i['jenis_kelamin'];
													$email=$i['email'];
													$no_hp=$i['no_hp'];
													$jabatan=$i['jabatan'];
													$hak_akses=$i['hak_akses'];
													$foto=$i['foto'];
													$status_akun=$i['status_akun'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $username;?></td>
												<td><?php echo $nama_lengkap;?></td>
												<td><?php echo $jabatan;?></td>
												<td style="width: 350px;" class="text-white">
												<?php if($hak_akses=="Admin"){ if($status_akun=="Aktif"){?>
													<a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_nonaktifkan<?php echo $username;?>"><i class="fa fa-times"></i> Non-aktifkan</a>
												<?php }else{ ?>
													<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_aktifkan<?php echo $username;?>"><i class="fa fa-check"></i> Aktifkan</a>
												<?php } ?>
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $username;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $username;?>"><i class="fa fa-trash"></i> Hapus</a>
													<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $username;?>"><i class="fa fa-book"></i> Rincian</a>
												<?php
													}else{
														echo '<p class="text-warning text-center">TIDAK ADA AKSI</p>';
													}
												?>
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
										<h3 class="modal-title" id="myModalLabel">Tambah Admin Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('prodi/atur_admin/tambah_admin_prodi')?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >NPK / NIDN</label>
												<div class="col-xs-8">
													<input name="npk" class="form-control" type="text" placeholder="NPK / NIDN..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Nama Lengkap</label>
												<div class="col-xs-8">
													<input name="nama_lengkap" class="form-control" type="text" placeholder="Nama lengkap..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-xs-3" >Jenis Kelamin</label>
												<select name="jk" class="form-control" required>
													<option value="">--Pilih--</option>
													<option value="Laki-laki">Laki-laki</option>
													<option value="Perempuan">Perempuan</option>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >E-mail</label>
												<div class="col-xs-8">
													<input name="email" class="form-control" type="email" placeholder="Email..." required>
												</div>
											</div>
											
											<div class="form-group">
												<label class="control-label col-xs-3" >Nomor <i>Handphone</i></label>
												<div class="col-xs-8">
													<input name="no_hp" class="form-control" type="number" placeholder="Nomor handphone..." required>
												</div>
											</div>

											<input name="jabatan" class="form-control" value="Asisten" type="hidden" placeholder="Jabatan...">
												
											
											<hr>
											<div class="form-group">
												<label>Password</label>
												<input type="password" name="password" class="form-control" placeholder="Masukkan password.." required>
											</div>
											<div class="form-group">
												<label>Konfirmasi Password</label>
												<input type="password" name="konfirmasi_password" class="form-control" placeholder="Masukkan konfirmasi password.." required>  
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
									$username=$i['username'];
									$kode_prodi=$i['kode_prodi'];
									$nama_lengkap=$i['nama_lengkap'];
									$npk=$i['npk'];
									$jenis_kelamin=$i['jenis_kelamin'];
									$email=$i['email'];
									$no_hp=$i['no_hp'];
									$jabatan=$i['jabatan'];
									$hak_akses=$i['hak_akses'];
									$foto=$i['foto'];
									$status_akun=$i['status_akun'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $username;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Admin Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url('prodi/atur_admin/edit_admin_prodi')?>">
											<div class="modal-body">

												<div class="form-group">
													<label class="control-label col-xs-3" >Username</label>
													<div class="col-xs-8">
														<input name="username" class="form-control" type="text" value="<?php echo $username?>" readonly>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-xs-3" >Nama Lengkap</label>
													<div class="col-xs-8">
														<input name="nama_lengkap" class="form-control" value="<?php echo $nama_lengkap?>" type="text" placeholder="Nama lengkap..." required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-xs-3" >Jenis Kelamin</label>
													<select name="jk" class="form-control" required>
														<option value="">--Pilih--</option>
														<option value="Laki-laki" <?php if($jenis_kelamin=="Laki-laki"){ echo "selected";}?>>Laki-laki</option>
														<option value="Perempuan" <?php if($jenis_kelamin=="Perempuan"){ echo "selected";}?>>Perempuan</option>
													</select>
												</div>

												<div class="form-group">
													<label class="control-label col-xs-3" >E-mail</label>
													<div class="col-xs-8">
														<input name="email" class="form-control" type="email" value="<?php echo $email?>" placeholder="Email..." required>
													</div>
												</div>
												
												<div class="form-group">
													<label class="control-label col-xs-3" >Nomor <i>Handphone</i></label>
													<div class="col-xs-8">
														<input name="no_hp" class="form-control" type="number" value="<?php echo $no_hp?>" placeholder="Nomor handphone..." required>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-xs-3" >Jabatan</i></label>
													<div class="col-xs-8">
														<input name="jabatan" class="form-control" type="text" value="<?php echo $jabatan?>" placeholder="Jabatan..." readonly>
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

							<?php endforeach;?>
							<!--END MODAL EDIT-->


							<?php 
								foreach($data->result_array() as $i):
									$username=$i['username'];
									$kode_prodi=$i['kode_prodi'];
									$nama_lengkap=$i['nama_lengkap'];
									$npk=$i['npk'];
									$jenis_kelamin=$i['jenis_kelamin'];
									$email=$i['email'];
									$no_hp=$i['no_hp'];
									$jabatan=$i['jabatan'];
									$hak_akses=$i['hak_akses'];
									$foto=$i['foto'];
									$status_akun=$i['status_akun'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $username;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Admin Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/atur_admin/hapus_admin_prodi'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus <b><?php echo $nama_lengkap;?></b> sebagai admin?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="username" value="<?php echo $username;?>">
											<input type="hidden" name="kode_prodi" value="<?php echo $kode_prodi;?>">
											<input type="hidden" name="foto" value="<?php echo $foto;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Ya</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->

							<?php 
								foreach($data->result_array() as $i):
									$username=$i['username'];
									$kode_prodi=$i['kode_prodi'];
									$nama_lengkap=$i['nama_lengkap'];
									$npk=$i['npk'];
									$jenis_kelamin=$i['jenis_kelamin'];
									$email=$i['email'];
									$no_hp=$i['no_hp'];
									$jabatan=$i['jabatan'];
									$hak_akses=$i['hak_akses'];
									$foto=$i['foto'];
									$status_akun=$i['status_akun'];
								?>
							<!-- ============ MODAL AKTIFKAN =============== -->
								<div class="modal fade" id="modal_aktifkan<?php echo $username;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-success">
										<h3 class="modal-title" id="myModalLabel">Aktifkan Admin Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/atur_admin/aktifkan_admin_prodi'?>">
										<div class="modal-body">
											<p>Anda yakin ingin mengaktifkan akun <b><?php echo $nama_lengkap;?></b> sebagai admin?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="username" value="<?php echo $username;?>">
											<input type="hidden" name="kode_prodi" value="<?php echo $kode_prodi;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-success">Ya</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL AKTIFKAN -->

							<?php 
								foreach($data->result_array() as $i):
									$username=$i['username'];
									$kode_prodi=$i['kode_prodi'];
									$nama_lengkap=$i['nama_lengkap'];
									$npk=$i['npk'];
									$jenis_kelamin=$i['jenis_kelamin'];
									$email=$i['email'];
									$no_hp=$i['no_hp'];
									$jabatan=$i['jabatan'];
									$hak_akses=$i['hak_akses'];
									$foto=$i['foto'];
									$status_akun=$i['status_akun'];
								?>
							<!-- ============ NONAKTIFKAN ADMIN =============== -->
								<div class="modal fade" id="modal_nonaktifkan<?php echo $username;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-warning">
										<h3 class="modal-title" id="myModalLabel">Non-aktifkan Admin Prodi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'prodi/atur_admin/nonaktifkan_admin_prodi'?>">
										<div class="modal-body">
											<p>Anda yakin ingin Non-aktifkan akun <b><?php echo $nama_lengkap;?></b> sebagai admin?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="username" value="<?php echo $username;?>">
											<input type="hidden" name="kode_prodi" value="<?php echo $kode_prodi;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-warning">Ya</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END NONAKTIFKAN ADMIN -->


							<!-- ============ MODAL DETAIL =============== -->
							<?php 
									foreach($data->result_array() as $i):
										$username=$i['username'];
										$kode_prodi=$i['kode_prodi'];
										$nama_lengkap=$i['nama_lengkap'];
										$npk=$i['npk'];
										$jenis_kelamin=$i['jenis_kelamin'];
										$email=$i['email'];
										$no_hp=$i['no_hp'];
										$jabatan=$i['jabatan'];
										$hak_akses=$i['hak_akses'];
										$foto=$i['foto'];
										$status_akun=$i['status_akun'];
									?>
									<div class="modal fade" id="modal_detail<?php echo $username;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Admin Prodi</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="" action="">
											<div class="modal-body">
												<div class="form-group text-center">
													<?php if(!empty($foto)){ ?>
														<a href="<?php echo base_url()?>templates/img/dosen/<?php echo $foto?>" class="venobox" data-gall="gallery-item">
														<img width="80%" src="<?php echo base_url()?>templates/img/dosen/<?php echo $foto?>" alt="" class="img-fluid">
													</a>
													
													<?php }else{
														echo "Foto belum tersedia!";
													} ?>
												</div>

												<div class="form-group">
														<label>Username</label>
														<input type="text" class="form-control" value="<?php echo $username?>" readonly>
												</div>
												<div class="form-group">
														<label>NPK / NIDN</label>
														<input type="text" class="form-control" value="<?php echo $npk?>" readonly>
												</div>
												<div class="form-group">
														<label>Nama Lengkap </label>
														<input type="text"  class="form-control" value="<?php echo $nama_lengkap?>" readonly>
												</div>
												<div class="form-group">
														<label>Jenis Kelamin</label>
														<input type="text" class="form-control" value="<?php echo $jenis_kelamin?>" readonly>                                      
												</div>
												<div class="form-group">
														<label>Email</label>
														<input type="text" class="form-control" value="<?php echo $email?>" readonly>                                                         
												</div>
												
												<div class="form-group">
														<label class="control-label col-xs-3" >Nomor <i>Handphone</i></label>
														<input type="text"  class="form-control" value="<?php echo $no_hp?>" readonly>								
												</div>
												<div class="form-group">
														<label>Jabatan</label>
														<input type="text" name="keahlian" class="form-control" value="<?php echo $jabatan?>" readonly>
												</div>
												
												<div class="form-group">
														<label>Hak Akses</label>
														<input type="text" class="form-control" value="<?php echo $hak_akses?>" readonly>                                                         
												</div>
												<div class="form-group">
														<label>Status Akun</label>
														<input type="text" class="form-control" value="<?php echo $status_akun?>" readonly>                                                         
												</div>
	
											</div>

											<div class="modal-footer">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
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

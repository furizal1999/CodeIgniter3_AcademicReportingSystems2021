
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DOSEN & PEGAWAI</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<?php if(isset($_SESSION['kode_prodi'])){?>
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Data</a>
								<?php } ?>
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
									<div class="col-md-6 bg-light rounded">
										<form action="<?php echo base_url('tu/dosen')?>" method="post">
											<div class="row">
												<div class="col-md-8">
													<div class="form-group text-left">
														<label class="control-label col-xs-3" >PROGRAM STUDI</label>
														<select name="kode_prodi" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_prodi->result_array() as $i):
																	$kode_prodi_combo=$i['kode_prodi'];
																	$nama_prodi_combo=$i['nama_prodi'];
															?>
															<option  value="<?php echo $kode_prodi_combo ?>" <?php if(isset($_SESSION['kode_prodi'])){if($_SESSION['kode_prodi']==$kode_prodi_combo){ echo 'selected';}}?>>
																<?php echo $nama_prodi_combo; ?>
															</option>
															<?php endforeach;?>
														</select>
													</div>
												</div>
												<div class="col-md-4">
													
													<div class="form-group text-left">
														<label class="control-label col-xs-3">AKSI</label>
														<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
													</div>
													
												</div>
											</div>
										</form>
									</div>
									<hr>
								<?php if(isset($_SESSION['kode_prodi'])){?>
								<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>STATUS</b></td>
													<td align="center"><b>USERNAME</b></td>
													<td align="center"><b>NAMA</b></td>
													<td align="center"><b>JABATAN FUNGSIONAL</b></td>
													<td align="center"><b>STATUS DOSEN</b></td>
													<td align="center"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>
												<?php 
													$no=1;
													foreach($data->result_array() as $i):
														$npk=$i['npk'];
														$status_jabatan=$i['status_jabatan'];
														$nama_dosen=$i['nama_dosen'];
														$jk=$i['jk'];
														$email=$i['email'];
														$kode_jurusan=$i['kode_jurusan'];
														$jabatan_fungsional=$i['jabatan_fungsional'];
														$pendidikan=$i['pendidikan'];
														$status_dosen=$i['status_dosen'];
														$foto=$i['foto'];
														$status=$i['status'];

														if($pendidikan!=""){
															$kurung = ' ('.$pendidikan.')';
														}else{
															$kurung = '';
														}
												?>
											
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $status_jabatan;?></td>
													<td><?php echo $npk;?></td>
													<td><?php echo $nama_dosen;?></td>
													<td><?php echo $jabatan_fungsional.$kurung;?></td>
													<td><?php echo $status_dosen;?></td>
													<td style="width: 430px;" class="text-white">
												<?php if($status=="Aktif"){ ?>
														<a class="btn btn-sm btn-warning text-dark" data-toggle="modal" data-target="#modal_batal<?php echo $npk;?>"><i> x</i> Batal Verifikasi</a>
												<?php }elseif($status=="Non-aktif"){ ?>
														<a class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_verifikasi<?php echo $npk;?>"><i> v</i> Verifikasi</a>
												<?php } ?>
														<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_resetPW<?php echo $npk;?>"><i class="fa fa-circle"></i> Reset PW</a>
														<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $npk;?>"><i class="fa fa-pen"></i> Edit</a>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $npk;?>"><i class="fa fa-trash"></i> Hapus</a>
														<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail<?php echo $npk;?>"><i class="fa fa-book"></i> Rincian</a>

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
										<h3 class="modal-title" id="myModalLabel">Tambah Dosen & Pegawai</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/dosen/daftar_akun_dosen')?>">
										<div class="modal-body">

											<div class="form-group">
                                             <label>NPK / NIDN</label>
                                             <input type="text" name="npk" class="form-control" placeholder="Masukkan  NPK.." required>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-xs-3" >STATUS</label>
                                             <select name="status_jabatan" class="form-control" required>
                                                  <option value="">--Pilih--</option>
                                                  <option  value="Dosen">Dosen</option>
                                                  <option  value="Pegawai">Pegawai</option>
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label>NAMA LENGKAP <i class="text-danger">(Termasuk gelar)</i></label>
                                             <input type="text" name="nama_dosen" class="form-control" placeholder="Masukkan Nama.."required>
                                        </div>
                                       
                                        <div class="form-group">
                                             <label class="control-label col-xs-3" >JENIS KELAMIN</label>
                                             <select name="jk" class="form-control" required>
                                                  <option value="">--Pilih--</option>
                                                  <option  value="Laki-laki">Laki-laki</option>
                                                  <option  value="Perempuan">Perempuan</option>
                                             </select>
                                        </div>

                                        <div class="form-group">
                                             <label class="control-label col-xs-3" >JABATAN FUNGSIONAL</label>
                                             <select name="jabatan_fungsional" class="form-control" required>
                                                  <option value="">--Pilih--</option>
                                                  <option  value="Guru Besar">Guru Besar</option>
                                                  <option  value="Lektor Kepala">Lektor Kepala</option>
                                                  <option  value="Lektor">Lektor</option>
                                                  <option  value="Asisten Ahli">Asisten Ahli</option>
                                                  <option  value="Staff Pegawai">Staff Pegawai</option>
                                                  <option  value="Non-Fungsional">Non-Fungsional</option>
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-xs-3" >PENDIDIKAN</label>
                                             <select name="pendidikan" class="form-control" required>
                                                  <option value="">--Pilih--</option>
                                                  <option  value="S1">S1</option>
                                                  <option  value="S2">S2</option>
                                                  <option  value="S3">S3</option>
                                             </select>
                                        </div>
                                        <div class="form-group">
                                             <label class="control-label col-xs-3" >STATUS DOSEN</label>
                                             <select name="status_dosen" class="form-control" required>
                                                  <option value="">--Pilih--</option>
                                                  <option  value="Dosen Tetap Program Studi">Dosen Tetap Program Studi</option>
                                                  <option  value="Dosen Tetap">Dosen Tetap</option>
                                                  <option  value="Dosen Tidak Tetap">Dosen Tidak Tetap</option>
                                             </select>
                                        </div>                            
                                        
                                        <hr>
                                        <div class="form-group">
                                             <label>PASSWORD</label>
                                             <input type="password" name="password" class="form-control" placeholder="Masukkan password.." required>
                                        </div>
                                        <div class="form-group">
                                             <label>KONFIRMASI PASSWORD</label>
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
										$npk=$i['npk'];
										$status_jabatan=$i['status_jabatan'];
										$nama_dosen=$i['nama_dosen'];
										$jk=$i['jk'];
										$email=$i['email'];
										$kode_jurusan=$i['kode_jurusan'];
										$jabatan_fungsional=$i['jabatan_fungsional'];
										$pendidikan=$i['pendidikan'];
										$status_dosen=$i['status_dosen'];
										$foto=$i['foto'];
										$status=$i['status'];
									?>
									<div class="modal fade" id="modal_edit<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary">
											<h3 class="modal-title" id="myModalLabel">Edit Data Dosen</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/dosen/edit_dosen_terverifikasi'?>" enctype="multipart/form-data">
											<div class="modal-body">
											<div class="form-group">
													<label>NPK / NIDN</label>
													<input type="text" name="npk" class="form-control" value="<?php echo $npk?>" readonly>
											</div>
											<div class="form-group">
													<label>NAMA LENGKAP DOSEN <i>(Termasuk gelar)</i></label>
													<input type="text" name="nama_dosen" class="form-control" value="<?php echo $nama_dosen?>" required>
											</div>
											<div class="form-group">
													<label class="control-label col-xs-3" >JENIS KELAMIN</label>
													<select name="jk" class="form-control">
														
														<option  value="Laki-laki" <?php if ($jk=="Laki-laki"){echo "selected";}?>>Laki-laki</option>
														<option  value="Perempuan" <?php if ($jk=="Perempuan"){echo "selected";}?>>Perempuan</option>
														<option value="-" <?php if ($jk=="-"){echo "selected";}?>>--Pilih--</option>
													</select>
											</div>

											 <div class="form-group">
			                                             <label class="control-label col-xs-3" >JABATAN FUNGSIONAL</label>
			                                             <select name="jabatan_fungsional" class="form-control" required>
			                                                  <option value="">--Pilih--</option>
			                                                  <option  value="Guru Besar" <?php if ($jabatan_fungsional=="Guru Besar"){echo "selected";}?>>Guru Besar</option>
			                                                  <option  value="Lektor Kepala"<?php if ($jabatan_fungsional=="Lektor Kepala"){echo "selected";}?>>Lektor Kepala</option>
			                                                  <option  value="Lektor" <?php if ($jabatan_fungsional=="Lektor"){echo "selected";}?>>Lektor</option>
			                                                  <option  value="Asisten Ahli" <?php if ($jabatan_fungsional=="Asisten Ahli"){echo "selected";}?>>Asisten Ahli</option>
			                                                  <option  value="Staff Pegawai" <?php if ($jabatan_fungsional=="Staff Pegawai"){echo "selected";}?>>Staff Pegawai</option>
			                                                  <option  value="Non-Fungsional" <?php if ($jabatan_fungsional=="Non-Fungsional"){echo "selected";}?>>Non-Fungsional</option>
			                                             </select>
			                                        </div>
			                                         <div class="form-group">
			                                             <label class="control-label col-xs-3" >PENDIDIKAN</label>
			                                             <select name="pendidikan" class="form-control" required>
			                                                  <option value="">--Pilih--</option>
			                                                  <option  value="S1" <?php if ($pendidikan=="S1"){echo "selected";}?>>S1</option>
			                                                  <option  value="S2" <?php if ($pendidikan=="S2"){echo "selected";}?>>S2</option>
			                                                  <option  value="S3" <?php if ($pendidikan=="S3"){echo "selected";}?>>S3</option>
			                                             </select>
			                                        </div>
			                                         <div class="form-group">
			                                             <label class="control-label col-xs-3" >STATUS DOSEN</label>
			                                             <select name="status_dosen" class="form-control" required>
			                                                  <option value="">--Pilih--</option>
			                                                  <option  value="Dosen Tetap Program Studi" <?php if ($status_dosen=="Dosen Tetap Program Studi"){echo "selected";}?>>Dosen Tetap Program Studi</option>
			                                                  <option  value="Dosen Tetap" <?php if ($status_dosen=="Dosen Tetap"){echo "selected";}?>>Dosen Tetap</option>
			                                                  <option  value="Dosen Tidak Tetap" <?php if ($status_dosen=="Dosen Tidak Tetap"){echo "selected";}?>>Dosen Tidak Tetap</option>
			                                             </select>
			                                        </div> 
											<div class="form-group">
													<label>EMAIL</label>
													<input type="email" name="email" class="form-control" value="<?php echo $email?>">                                                         
											</div>
											
											<div class="form-group">
													<label class="control-label col-xs-3" >Foto <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png <br>2. Ukuran maksimal 200 kb)</i></label>
													<div class="col-xs-8">
														<input type="file" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" name="gambar" class="bg-secondary border-secondary text-white">
													</div>
											</div>

											<div class="form-group">
													<div class="col-xs-8">
														<input type="hidden" name="nama_foto_lama" value="<?php echo $foto?>" class="bg-secondary border-secondary text-white">
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
										$npk=$i['npk'];
										$status_jabatan=$i['status_jabatan'];
										$nama_dosen=$i['nama_dosen'];
										$jk=$i['jk'];
										$email=$i['email'];
										$kode_jurusan=$i['kode_jurusan'];
										$foto=$i['foto'];
										$status=$i['status'];
									?>
									
								<!-- ============ MODAL HAPUS =============== -->
									<div class="modal fade" id="modal_hapus<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger">
											<h3 class="modal-title" id="myModalLabel">Hapus Data Dosen</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/dosen/hapus_dosen_terverifikasi'?>">
											<div class="modal-body">
												<p>Anda yakin menghapus data <b><?php echo $nama_dosen;?></b>?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="npk" value="<?php echo $npk;?>">
												<input type="hidden" name="nama_foto_lama" value="<?php echo $foto?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-danger">Hapus</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL HAPUS -->

								<?php 
									foreach($data->result_array() as $i):
										$npk=$i['npk'];
										$status_jabatan=$i['status_jabatan'];
										$nama_dosen=$i['nama_dosen'];
										$jk=$i['jk'];
										$email=$i['email'];
										$kode_jurusan=$i['kode_jurusan'];
										$foto=$i['foto'];
										$status=$i['status'];
									?>
									
								<!-- ============ MODAL BATAL =============== -->
									<div class="modal fade" id="modal_batal<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning">
											<h3 class="modal-title" id="myModalLabel">Batal Verifikasi</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/dosen/batal_verifikasi'?>">
											<div class="modal-body">
												<p>Anda yakin membatalkan verifikasi akun <b><?php echo $nama_dosen;?></b>?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="npk" value="<?php echo $npk;?>">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-warning">Batalkan Verifikasi Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL BATAL -->


							<?php 
								foreach($data->result_array() as $i):
									$npk=$i['npk'];
									$status_jabatan=$i['status_jabatan'];
									$nama_dosen=$i['nama_dosen'];
									$jk=$i['jk'];
									$email=$i['email'];
									$kode_jurusan=$i['kode_jurusan'];
									$foto=$i['foto'];
									$status=$i['status'];
								?>
								
								<!-- ============ MODAL VERIFIKASI =============== -->
								<div class="modal fade" id="modal_verifikasi<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-success">
										<h3 class="modal-title" id="myModalLabel">Verifikasi</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/dosen/verifikasi'?>">
										<div class="modal-body">
											<p>Anda yakin memverifikasi akun <b><?php echo $nama_dosen;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="npk" value="<?php echo $npk;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-success">Verifikasi Sekarang</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL VERIFIKASI -->
								
								<!-- ============ MODAL DETAIL =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$npk=$i['npk'];
										$status_jabatan=$i['status_jabatan'];
										$nama_dosen=$i['nama_dosen'];
										$jk=$i['jk'];
										$email=$i['email'];
										$kode_jurusan=$i['kode_jurusan'];
										$foto=$i['foto'];
										$status=$i['status'];

									?>
									<div class="modal fade" id="modal_detail<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Data Dosen</h3>
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
														<label>NPK / NIDN</label>
														<input type="text" name="npk" class="form-control" value="<?php echo $npk?>" readonly>
												</div>
												<div class="form-group">
														<label>NAMA LENGKAP DOSEN <i class="text-danger">(Termasuk gelar)</i></label>
														<input type="text" name="nama_dosen" class="form-control" value="<?php echo $nama_dosen?>" readonly>
												</div>
												
												<div class="form-group">
														<label class="control-label col-xs-3" >JENIS KELAMIN</label>
														<input type="text"  class="form-control" value="<?php echo $jk?>" readonly>								
												</div>
												<div class="form-group">
													<label class="control-label col-xs-3" >PROGRAM STUDI</label>
														<?php
															foreach($combobox_jurusan->result_array() as $i):
																			$kode_prodi_combo=$i['kode_prodi'];
																			$nama_prodi_combo=$i['nama_prodi'];
														?>
														<?php if ($kode_jurusan==$kode_prodi_combo){?>
															<input type="text"  class="form-control" value="<?php echo $kode_prodi_combo," - ",$nama_prodi_combo?>" readonly>	
														<?php 
															}else{
														?>
															<!-- <input type="text"  class="form-control" value="<?php echo "Belum dipilih";?>" readonly>	 -->
														<?php
															}
															endforeach;?>
												</div>
												<div class="form-group">
														<label>EMAIL</label>
														<input type="email" name="email" class="form-control" value="<?php echo $email?>" readonly>                                                         
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


								<?php 
								foreach($data->result_array() as $i):
									$npk=$i['npk'];
									$status_jabatan=$i['status_jabatan'];
									$nama_dosen=$i['nama_dosen'];
									$jk=$i['jk'];
									$email=$i['email'];
									$kode_jurusan=$i['kode_jurusan'];
									$foto=$i['foto'];
									$status=$i['status'];
								?>
								
								<!-- ============ MODAL RESET PASSWORD =============== -->
								<div class="modal fade" id="modal_resetPW<?php echo $npk;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-primary">
										<h3 class="modal-title" id="myModalLabel">Reset Password</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/dosen/reset_password'?>">
										<div class="modal-body">
											<div class="form-group">
												<label>Password Baru</label>
												<input type="password" name="password_baru" class="form-control" placeholder="Password Baru" required>
											</div>
											<div class="form-group">
												<label>Konfirmasi Password Baru</label>
												<input type="password" name="konfirmasi_password_baru" class="form-control" placeholder="Konfirmasi Password Baru" required>
											</div>

										</div>
										<div class="modal-footer">
											<input type="hidden" name="npk" value="<?php echo $npk;?>">
											<!-- <input type="hidden" name="kode_jurusan" value="<?php echo $kode_jurusan;?>"> -->
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-primary" name="reset_password">Reset Sekarang</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL RESET PASSWORD -->

								<?php }else{ ?>
									<h1 class="text-danger">SILAHKAN PILIH PRODI TERLEBIH DAHULU...</h1>
								<?php }?>

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

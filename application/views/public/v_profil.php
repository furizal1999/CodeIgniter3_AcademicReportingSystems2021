
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PROFIL</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
							
                            </div>
						</div>
					</div>
				</div>

                <!-- selamat datang -->
                <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="card-body text-center">
									<form  action="<?php echo base_url().'profil/editProfil'?>" method="post" class="contact-form" enctype="multipart/form-data">
										<div class="row text-left">
											<div class="col-md-4">
											<?php if($_SESSION['foto']==""){?>
												<img width="100%" src="<?php echo base_url('templates')?>/img/dosen/inisial/<?php echo $_SESSION['jenis_kelamin'];?>.jpg" alt="foto profil" class="text-center rounded">
											<?php }else{?>
												<img width="100%" src="<?php echo base_url('templates')?>/img/dosen/<?php echo $_SESSION['foto'];?>" alt="foto profil" class="text-center rounded">
											<?php }?>
												<div class="form-group">
													<label class="control-label col-xs-3" >Ganti Foto<br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png <br>2. Ukuran maksimal 200 kb)</i></label>
													<div class="col-xs-8">
														<input type="file" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" name="gambar" class="form-control border-secondary bg-info text-dark">
													</div>
												</div>
																					
											</div>
											<div class="col-md-4">
												<h1>INFO LOGIN</h1>
										<?php if($_SESSION['status_login']=="Dosen"){?>
												<div class="form-group">
													<label>Username</label>
													<input type="text" class="form-control" name="npk_login" value="<?php echo $_SESSION['npk'];?>" readonly>
												</div>
										<?php }else{?>
												<div class="form-group">
													<label>Username</label>
													<input type="text" class="form-control" name="username" value="<?php echo $_SESSION['username'];?>" readonly>
												</div>
												
										<?php }?>
												<div class="form-group">
													<label>Status Login</label>
													<?php 
														if(isset($_SESSION['status_jabatan'])){
															if($_SESSION['status_jabatan']=='Pegawai'){
																$stat= $_SESSION['status_jabatan'];
															}else{
																$stat= $_SESSION['status_login'];
															}
														}else{
															$stat= $_SESSION['status_login'];
														}
													?>
													<input type="text" class="form-control" name="status_login" value="<?php echo $stat;?>" readonly>
												</div>	
												<br>
												<h1>INFO IDENTITAS</h1>
												<div class="form-group">
													<label>Nama</label>
													<input type="text" class="form-control" name="nama" value="<?php echo $_SESSION['nama'];?>"readonly>
												</div>
												<div class="form-group">
													<label>Nomor Identitas</label>
													<input type="text" class="form-control" name="npk" value="<?php echo $_SESSION['npk'];?>" <?php if($_SESSION['status_login']=="Dosen"){echo 'readonly';}else{ echo 'required';}?>>
												</div>
												<div class="form-group">
													<label>Jenis Kelamin</label>
													<select class="form-control" name="jk" required>
														<option value="">--Pilih--</option>
														<option value="Laki-laki" <?php if($_SESSION['jenis_kelamin']=="Laki-laki"){ echo "selected";}?>>Laki-laki</option>
														<option value="Perempuan" <?php if($_SESSION['jenis_kelamin']=="Perempuan"){ echo "selected";}?>>Perempuan</option>
													</select>
												</div>
												

											</div>
											<div class="col-md-4 rounded">
												
										<?php if($_SESSION['status_login']=="Prodi" || $_SESSION['status_login']=="Fakultas"){?>
											<div class="form-group">
												<label>Jabatan</label>
												<input type="text" class="form-control" name="jabatan" value="<?php echo $_SESSION['jabatan'];?>" readonly>
											</div>												
										<?php }?>
												
												
											
												<h1>INFO KONTAK</h1>
												<div class="form-group bg-light">
													<label>E-mail</label>
													<input type="text" class="form-control" name="email" value="<?php echo $_SESSION['email'];?>">
												</div>
												<hr>
												<div class="form-group">
													<input type="submit" value="Simpan Perubahan" name="editProfil" class="btn btn-primary">
												</div>
											</div>
                						</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div> 
				<!-- selamat datang -->
                <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="card-body text-center">
									<form  action="<?php echo base_url().'profil/ganti_password'?>" method="post" class="contact-form">
										<div class="row text-left">
											<div class="col-md-12">
												<h1>GANTI PASSWORD</h1>								
											</div>
											
                						</div>
										<div class="row text-left">
											<div class="col-md-4">
												<div class="form-group bg-light">
													<label>Password Lama</label>
													<input type="password" name="password_lama" class="form-control" placeholder="Password lama" required>
												</div>									
											</div>
											<div class="col-md-4">
												<div class="form-group bg-light">
													<label>Password Baru</label>
													<input type="password" name="password_baru" class="form-control" placeholder="Password baru" required>
												</div>
											</div>
											<div class="col-md-4 rounded">
												<div class="form-group bg-light">
													<label>Konfirmasi Password Baru</label>
													<input type="password" name="konfirmasi_password_baru" class="form-control" placeholder="Konfirmasi password baru" required>
												</div>
												<hr>
												<input type="submit" value="Ganti Password" name="ganti_password" class="btn btn-warning">
											</div>
                						</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
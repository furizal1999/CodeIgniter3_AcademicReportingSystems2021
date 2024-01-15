<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">BERKAS KONTRAK KULIAH</h1>
								<h5 class="text-white op-7 mb-2">
									<?php 
										if(isset($_SESSION['status_login'])){
											if($_SESSION['status_login']=="Dosen" || $_SESSION['status_login']=="Pegawai"){
												if(isset($_SESSION['nama_prodi'])){
													echo $_SESSION['nama_prodi'].' ';
												}
											}
										} 
									?>
									Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									
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
								<div class="row">
										<div class="col-md-6 bg-light rounded">
											<form action="<?php echo base_url('dosen/kontrak_kuliah')?>" method="post">
												<div class="row">
													<div class="col-md-8">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PERTEMUAN SEMESTER</label>
															<select name="id_pertemuan" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_pertemuan->result_array() as $i):
																		$id_pertemuan_combo=$i['id_pertemuan'];
																		$tahun_ajaran_combo=$i['tahun_ajaran'];
																		$jenis_pertemuan_combo=$i['jenis_pertemuan'];
																		$semester_combo=$i['semester'];
																		
																?>
																<option  value="<?php echo $id_pertemuan_combo ?>" <?php if(isset($_SESSION['id_pertemuan_search'])){if($_SESSION['id_pertemuan_search']==$id_pertemuan_combo){ echo 'selected';}}?>>
																	<?php echo $tahun_ajaran_combo.' ('.$semester_combo.')'; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
													</div>
													<div class="col-md-4">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label><br>
															<input type="submit" name="tombol_cari_tahun_ajaran" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
										<a class="text-white border-white custom-btn bg-primary btn" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-upload"></i> Upload Kontrak Kuliah</a>
									<hr>
								<?php } ?>
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>MATAKULIAH</b></td>
												<td align="center"><b>NAMA KELAS</b></td>
												<td align="center"><b>JENIS PERTEMUAN</b></td>
												<td align="center"><b>FILE KONTRAK KULIAH</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$tahun_ajaran=$i['tahun_ajaran'];
													$id_berkas_pertemuan=$i['id_berkas_pertemuan'];
													$semester=$i['semester'];
													$jenis_pertemuan=$i['jenis_pertemuan'];
													$nama_mk=$i['nama_mk'];
													$nama_kelas=$i['nama_kelas'];
													$nama_file_berkas=$i['nama_file_berkas'];
													
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $jenis_pertemuan;?></td>
												<td>
													<?php if(empty($nama_file_berkas)){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/dosen/kontrak_kuliah/'.$nama_file_berkas)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
												<td style="width: 150px;" class="text-white">
													

													<?php if(empty($nama_file_berkas)){ ?>
														<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_upload_file<?php echo $id_berkas_pertemuan;?>"><i class="fa fa-upload"></i> Unggah Berkas</a>
													<?php }else{?>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_berkas_pertemuan;?>"><i class="fa fa-trash"></i> Hapus File</a>
													<?php }?>
													
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
										<h3 class="modal-title" id="myModalLabel">Upload Kontrak Kuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/kontrak_kuliah/upload'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<div class="col-xs-8 form-group">
														<label class="control-label col-xs-3" >KELAS MATAKULIAH</label>
														<select name="id_jadwal_kelas_pertemuan" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_kelas_matkul->result_array() as $i):
																	$nama_mk_combo=$i['nama_mk'];
																	$id_jadwal_kelas_pertemuan_combo=$i['id_jadwal_kelas_pertemuan'];
																	$nama_kelas_combo=$i['nama_kelas'];
																	
																	if($this->m_kontrak_kuliah->cekKetersediaanBerkasKontrakKuliah($id_jadwal_kelas_pertemuan_combo)==0){


															?>
															<option  value="<?php echo $id_jadwal_kelas_pertemuan_combo ?>">
																<?php echo $nama_mk_combo.' ('.$nama_kelas_combo.')'; ?>
															</option>
															<?php 
																	} 
																endforeach;
															?>
														</select>
													</div>
													<div class="col-xs-8 form-group">
														<label class="control-label col-xs-3" >Syarat File</label>
														<ol>
															<li><i class="text-danger">Ekstensi file : pdf</i></li>
														</ol>
														<input type="file" name="berkas" class="border-secondary text-dark" accept="application/pdf" required>
													</div>
													
												</div>
											</div>
											<div class="modal-footer">

												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-primary" name="upload_kontrak_kuliah">Upload Sekarang</button>
											</div>
										</form>
									</div>
									</div>
								</div>
							<!--END MODAL ADD-->

													
							
							<?php 
								foreach($data->result_array() as $i):
									$tahun_ajaran=$i['tahun_ajaran'];
									$id_berkas_pertemuan=$i['id_berkas_pertemuan'];
									$semester=$i['semester'];
									$jenis_pertemuan=$i['jenis_pertemuan'];
									$nama_mk=$i['nama_mk'];
									$nama_kelas=$i['nama_kelas'];
									$nama_file_berkas=$i['nama_file_berkas'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_berkas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Berkas Kontrak Kuliah</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/kontrak_kuliah/hapus_berkas'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus berkas kontrak kuliah untuk matkul <b><?php echo $nama_mk;?></b> pada kelas <b><?php echo $nama_kelas;?></b> ini?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_berkas_pertemuan" value="<?php echo $id_berkas_pertemuan;?>">
											<input type="hidden" name="berkaslama" value="<?php echo $nama_file_berkas;?>">

											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger" name="hapus_berkas_kontrak">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->

							<?php }else{ ?>
								<h1 class="text-danger">Silahkan pilih pertemuan semester terlebih dahulu!</h1>
							<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">BERKAS NILAI HASIL UJIAN</h1>
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
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('dosen/nilai_hasil_ujian')?>" method="post">
												<div class="row">
													
													<div class="col-md-5">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >UJIAN</label>
															<select name="id_ujian" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_ujian->result_array() as $i):
																		$id_ujian_combo=$i['id_ujian'];
																		$tahun_ajaran_combo=$i['tahun_ajaran'];
																		$nama_ujian_combo=$i['nama_ujian'];
																		$jenis_ujian_combo=$i['ket_ujian'];
																		$semester_combo=$i['semester'];
																?>
																<option  value="<?php echo $id_ujian_combo ?>" <?php if(isset($_SESSION['id_ujian_search'])){if($_SESSION['id_ujian_search']==$id_ujian_combo){ echo 'selected';}}?>>
																	<?php echo $tahun_ajaran_combo.'->'.$semester_combo.'->'.$nama_ujian_combo.'('.$jenis_ujian_combo.')'; ?>
																</option>
																<?php endforeach;?>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label>
															<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php if(isset($_SESSION['id_ujian_search'])){ ?>
								<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_upload_file"><i class="fa fa-upload"></i> Unggah Berkas</a>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>MATAKULIAH</b></td>
												<td align="center"><b>KELAS</b></td>
												<td align="center"><b>TANGGAL UJIAN</b></td>
												<td align="center"><b>BERKAS NILAI HASIL UJIAN</b></td>
												<!-- <td align="center"><b>BERKAS NILAI HASIL UJIAN (TERVALIDASI)</b></td> -->
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_berkas_ujian_kelas=$i['id_berkas_ujian_kelas'];
													$jenis_ujian=$i['ket_ujian'];
													$nama_kelas=$i['nama_kelas'];
													$nama_mk=$i['nama_mk'];
													$tanggal_ujian=$i['tanggal_ujian'];
													$jam_mulai=$i['jam_mulai'];
													$jam_selesai=$i['jam_selesai'];
													$file_soal_ujian=$i['nama_file_berkas'];
													$file_soal_ujian_valid=$i['nama_file_berkas_valid'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $nama_mk; ?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $tanggal_ujian.' ('.$jam_mulai.'-'.$jam_selesai.')';?></td>
												<td>
													<?php if(empty($file_soal_ujian)){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/dosen/nilai_hasil_ujian/'.$file_soal_ujian)?>" target="_BLANK" class="btn btn-sm btn-primary text-white"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
												<!-- <td>
													<?php if(empty($file_soal_ujian_valid)){ ?>
													<i class="text-danger">Berkas belum diunggah prodi!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/dosen/nilai_hasil_ujian/'.$file_soal_ujian_valid)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td> -->
												<td style="width: 150px;" class="text-white">
													

													<?php if(!empty($file_soal_ujian)){ ?>
														<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_hapus<?php echo $id_berkas_ujian_kelas;?>"><i class="fa fa-trash"></i> Hapus File</a>
													<?php }?>
													
													<!-- <p class="text-warning">NO ACTION</p> -->
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>


							

						<!-- ============ MODAL UPLOAD BUKTI FOTO =============== -->
								
								<div class="modal fade" id="modal_upload_file" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success">
											<h3 class="modal-title" id="myModalLabel">Upload Nilai Ujian Mahasiswa</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/nilai_hasil_ujian/upload'?>" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<label class="control-label col-xs-3" >MATAKULIAH DAN KELAS</label>
													<select name="id_jadwal_kelas_pertemuan" class="form-control" required>
														<option value="">--Pilih--</option>
														<?php
															foreach($combobox_kelas_diampu->result_array() as $i):
																$id_jadwal_kelas_pertemuan_combo=$i['id_jadwal_kelas_pertemuan'];
																$nama_mk_combo=$i['nama_mk'];
																$nama_kelas_combo=$i['nama_kelas'];
																if($this->m_nilai_hasil_ujian->cekKetersediaanfileBerkasSoalUjian($_SESSION['id_ujian_search'], $id_jadwal_kelas_pertemuan_combo)==0){
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
												<div class="form-group">
													
													<div class="col-xs-8">
														<label class="control-label col-xs-3" >Syarat File</label>
														<ol>
															<li><i class="text-danger">Ekstensi file : pdf</i></li>
															
														</ol>
													</div>
													
													<div class="col-xs-8">
														<input type="file" accept="application/pdf" name="berkas" class="border-secondary text-dark" required>
													</div>
												</div>
												
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_ujian" value="<?php echo $_SESSION['id_ujian_search'];?>">

												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-success" name="upload_berkas_soal_ujian">Unggah Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								
								<!--END MODAL UPLOAD BUKTI FOTO -->
							
							
							
							<?php 
								foreach($data->result_array() as $i):
									$id_berkas_ujian_kelas=$i['id_berkas_ujian_kelas'];
									$nama_kelas=$i['nama_kelas'];
									$nama_mk=$i['nama_mk'];
									$file_soal_ujian=$i['nama_file_berkas'];

									
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_berkas_ujian_kelas;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Berkas Nilai Ujian Mahasiswa</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'dosen/nilai_hasil_ujian/hapus_berkas'?>">
										<div class="modal-body">
											<p>Anda yakin ingin menghapus berkas nilai mahasiswa untuk matkul <b><?php echo $nama_mk;?></b> pada kelas <b><?php echo $nama_kelas;?></b> ini?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_berkas_ujian_kelas" value="<?php echo $id_berkas_ujian_kelas;?>">
											<input type="hidden" name="berkaslama" value="<?php echo $file_soal_ujian;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger" name="hapus_berkas_soal_ujian">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->

							<?php }else{ ?>
								<h2 class="text-danger">Silahkan pilih ujian terlebih dahulu!</h2>
							<?php } ?>

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

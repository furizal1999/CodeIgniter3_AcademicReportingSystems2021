<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">BERKAS RPS</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
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
											<form action="<?php echo base_url('prodi/rps')?>" method="post">
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
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>NAMA DOSEN</b></td>
												<td align="center"><b>MATAKULIAH</b></td>
												<td align="center"><b>NAMA KELAS</b></td>
												<td align="center"><b>JENIS PERTEMUAN</b></td>
												<td align="center"><b>FILE RPS</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$tahun_ajaran=$i['tahun_ajaran'];
													$id_berkas_pertemuan=$i['id_berkas_pertemuan'];
													$semester=$i['semester'];
													$dosen_pengampu=$i['dosen_pengampu'];
													$array_dosen = explode(', ', $dosen_pengampu);
													$jenis_pertemuan=$i['jenis_pertemuan'];
													$nama_mk=$i['nama_mk'];
													$nama_kelas=$i['nama_kelas'];
													$nama_file_berkas=$i['nama_file_berkas'];
													
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td>
													<?php 
														$index = 0;
														$array_dosen_hasil = array();

														foreach ($array_dosen as $npk) {
															$nama_dosen = $this->m_rps->getNamaDosen($npk);
															$array_dosen_hasil[$index++] = $nama_dosen;
														}

														echo $string_dosen_hasil = implode('/ ', $array_dosen_hasil)

													?>
													
												</td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $jenis_pertemuan;?></td>
												<td>
													<?php if(empty($nama_file_berkas)){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/dosen/rps/'.$nama_file_berkas)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
												
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>

					

							<?php }else{ ?>
								<h1 class="text-danger">Silahkan pilih pertemuan semester terlebih dahulu!</h1>
							<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

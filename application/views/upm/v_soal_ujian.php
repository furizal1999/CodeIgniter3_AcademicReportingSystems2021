		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">BERKAS SOAL UJIAN</h1>
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
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('upm/soal_ujian')?>" method="post">
												<div class="row">
													<div class="col-md-5">
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
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NOMOR</b></td>
													<td align="center"><b>NAMA DOSEN</b></td>
													<td align="center"><b>MATAKULIAH</b></td>
													<td align="center"><b>TANGGAL UJIAN</b></td>
													<td align="center"><b>BERKAS SOAL</b></td>
													<td align="center"><b>BERKAS SOAL (TERVALIDASI)</b></td>
												</tr>
											</thead>
											<tbody>
											<?php 
													$no = 1;
													foreach($data->result_array() as $i):

														//get nama dosen
														$dosen_pengampu=$i['dosen_pengampu'];
														$array_dosen = explode(', ', $dosen_pengampu);
														
														$array_dosen_hasil = array();
														$array_npk_hasil = array();
														$index = 0;
														foreach ($array_dosen as $npk) {
															$nama_dosen = $this->m_soal_ujian->getNamaDosen($npk);
															$array_npk_hasil[$index] = $npk;
															$array_dosen_hasil[$index] = $nama_dosen;
															$index++;
														}
														$string_dosen_hasil = implode('/ ', $array_dosen_hasil);



														$tahun_ajaran=$i['tahun_ajaran'];
														$semester=$i['semester'];
														$jenis_ujian=$i['ket_ujian'];
														$nama_ujian=$i['nama_ujian'];
														$nama_mk=$i['nama_mk'];
														$tanggal_ujian=$i['tanggal_ujian'];
														$jam_mulai=$i['jam_mulai'];
														$jam_selesai=$i['jam_selesai'];
														$nama_file_berkas=$i['nama_file_berkas'];
														$nama_file_berkas_valid=$i['nama_file_berkas_valid'];
												?>
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $string_dosen_hasil;?></td>
													<td><?php echo $nama_mk;?></td>
													<td><?php echo $tanggal_ujian.' ('.$jam_mulai.'-'.$jam_selesai.')';?></td>
													<td>
														<?php if(empty($nama_file_berkas)){ ?>
														<i class="text-danger">Berkas belum tersedia!</i>
														<?php }else{ ?>
															<a href="<?php echo base_url('templates/file/user/dosen/soal_ujian/'.$nama_file_berkas)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
														<?php } ?>
													</td>
													<td>
													<?php if(empty($nama_file_berkas_valid)){ ?>
													<i class="text-danger">Berkas belum diunggah prodi!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/dosen/soal_ujian/'.$nama_file_berkas_valid)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
													
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH TERLEBIH DAHULU PRODI DAN TAHUN AJARAN...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>							
										
									
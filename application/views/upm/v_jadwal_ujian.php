
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL UJIAN</h1>
								<?php $text="aaaa"; ?>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){?>
								<form class="" method="post" action="<?php echo base_url('upm/jadwal_ujian/cetak') ?>" target='_BLANK'>
									<input type="hidden" name="kode_jurusan" value="<?php echo $_SESSION['kode_prodi']; ?>">
									
									<button type="submit" name="print" class="btn btn-warning  text-white ">
										<i class="fa fa-print"></i> Print Jadwal Ujian
									</button>
								</form>
								
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
									
									<div class="row">
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('upm/jadwal_ujian')?>" method="post">
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
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){ ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>TANGGAL UJIAN</b></td>
													<td align="center"><b>JAM</b></td>	
													<td align="center"><b>MATAKULIAH</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>										
													<td align="center"><b>SEMESTER/KELAS</b></td>
													<td align="center"><b>RUANG</b></td>
												</tr>
											</thead>
											<tbody>
											<?php 
													$no = 1;
													$mulai = false;
													$rowspan = false;
													foreach($data->result_array() as $i):
														$tanggal_ujian=$i['tanggal_ujian'];
														$jam_mulai=$i['jam_mulai'];
														$jam_selesai=$i['jam_selesai'];
														$kode_matkul=$i['kode_matkul'];
														
														$dosen_pengampu=$i['dosen_pengampu'];
														$row_dosen_pengampu = $this->m_cetak_jadwal->ambil_dosen_pengampu($_SESSION['kode_prodi'], $dosen_pengampu);
										                if($row_dosen_pengampu){
										                    $dosen_pengampu = $row_dosen_pengampu->nama_dosen;
										                }elseif($dosen_pengampu!=""){
										                    $dosen_pengampu = $dosen_pengampu;
										                }else{
										                    $dosen_pengampu = 'Tidak diketahui';
										                }

														$nama_kelas=$i['nama_kelas'];
														$kode_ruang=$i['kode_ruang'];
														$jenis_ujian=$i['ket_ujian'];
														$nama_mk = $i['nama_mk'];
														if($jenis_ujian=="Daring"){
															$kode_ruang = "ONLINE";
														}

														
												?>
												<tr>
													<td><?php echo $no++;?></td>
													
													<td><?php echo $tanggal_ujian;?></td>	
													<td><?php echo substr($jam_mulai,0,5)." - ".substr($jam_selesai,0,5);?></td>
													<td><?php echo $nama_mk;?></td>										
													<td><?php echo $dosen_pengampu;?></td>
													<td><?php echo $nama_kelas;?></td>
													<td><?php echo $kode_ruang;?></td>
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
								</div>

								<?php }else{ ?>
									<h1 class="text-danger">SILAHKAN PILIH TERLEBIH DAHULU PRODI DAN UJIAN...</h1>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

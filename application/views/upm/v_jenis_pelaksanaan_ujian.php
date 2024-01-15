
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JENIS PELAKSANAAN UJIAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div align="right" class="ml-md-auto m-1">
								<?php if(isset($_SESSION['id_ujian_search'])){ ?>
									<form class="" method="post" action="<?php echo base_url('upm/jenis_pelaksanaan_ujian/cetak/'.$_SESSION['id_ujian_search']) ?>" target='_BLANK'>
										<!-- <input type="hidden" name="kode_jurusan" value="<?php echo $kode_jurusan; ?>"> -->
										
										<button type="submit" name="print" class="btn btn-warning  text-white ">
											<i class="fa fa-print"></i> Print Jenis Pelaksanaan Ujian
										</button>
									</form>
								<?php } ?>
							</div>
							<!-- <div align="right" class="ml-md-auto m-1">
								
							</div> -->
						</div>
					</div>
				</div>

                <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								
								<div class="card-body">
									<div class="col-md-10 bg-light rounded">
										<form action="<?php echo base_url('upm/jenis_pelaksanaan_ujian')?>" method="post">
											<div class="row">
												<div class="col-md-8">
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
												<div class="col-md-4">
													
													<div class="form-group text-left">
														<label class="control-label col-xs-3">AKSI</label><br>
														<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
													</div>
													
												</div>
											</div>
										</form>
									</div>
									<hr>
									<?php echo $this->session->flashdata('messege'); ?>
									<?php if(isset($_SESSION['id_ujian_search'])){ ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>PROGRAM STUDI</b></td>
													<td align="center"><b>NAMA PENGAWAS</b></td>	
													<td align="center"><b>MATAKULIAH</b></td>
													<td align="center"><b>JENIS UJIAN</b></td>										
													<td align="center"><b>MEDIA YANG DIGUNAKAN</b></td>
													<td align="center"><b>BUKTI TERSEDIA</b></td>
												</tr>
											</thead>
											<tbody>
											<?php 
													$no = 1;
													$mulai = false;
													$rowspan = false;
													foreach($data->result_array() as $i):
														$kode_prodi=$i['kode_prodi'];
														$npk=$i['npk'];
														$prodi=$i['prodi'];
														$nama_dosen=$i['nama_dosen'];
														$mk=$i['mk'];
														$jenis_soal=$i['jenis_soal'];
														$media=$i['media'];
														$foto_bukti=$i['foto_bukti'];
														

														if($mulai==false){
															$user = $npk;
															$mulai = true;
														}
														else{
															if($user == $npk){
																$rowspan = true;
															}else{
																$rowspan = false;
																$user = $npk;
															}
														}

												?>
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $prodi;?></td>	
													<td><?php echo $nama_dosen;?></td>	
													<td><?php echo $mk;?></td>									
													<td><?php echo $jenis_soal;?></td>
													<td><?php echo $media;?></td>
													<td>
														<ol>
															<li>Berita acara Ujian</li>
															<?php
																 if(!empty($foto_bukti)){
															?>
															<li>Foto bukti mengawas</li>
															<?php
																 }
															?>
														</ol>
													<?php

													 if(!empty($foto_bukti)){

													 }
													 ?>
														
													</td>													<!-- <?php if($rowspan==false){?>
													<td rowspan="<?php echo $count_kelas;?>"><?php echo $count_mk;?></td>
													<td rowspan="<?php echo $count_kelas;?>"><?php echo $count_kelas;?></td>
													<?php } ?> -->
													
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH UJIAN TERLEBIH DAHULU...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

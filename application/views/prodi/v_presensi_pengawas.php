<?php
	// header("Content-Type:application/octet-stream/");
	// header("Content-Disposition:attachment; filename=file.xls");

	// header("Pragma: no-cache");
	// header("Expires");


?>

		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PRESENSI PENGAWAS</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div align="right" class="ml-md-auto m-1">
								<?php if(isset($_SESSION['id_ujian_search'])){ ?>
								<form class="" method="post" action="<?php echo base_url('prodi/presensi_pengawas/cetak_excel') ?>" target='_BLANK'>
									<input type="hidden" name="kode_jurusan" value="<?php echo $_SESSION['kode_prodi']; ?>">
									
									<button type="submit" name="print" class="btn btn-warning  text-white ">
										<i class="fa fa-print"></i> Cetak Presensi Pengawas Excel
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
									<div class="row">
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('prodi/presensi_pengawas')?>" method="post">
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
									<?php echo $this->session->flashdata('messege'); ?>
									<?php if(isset($_SESSION['id_ujian_search'])){ ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped" id="mydatascroll" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<?php
														$jumlah_sesi = array();
														$jumlah_hari = $data_tanggal_ujian->num_rows();
														$tanggal_array= array();
														$index = 0;


														foreach($data_tanggal_ujian->result_array() as $i):

															$tanggal_array[$index]=$i['tanggal'];

															$jumlah_sesi[$index] = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$index])->num_rows();

															

															$index++;
														endforeach;
													?>


												<tr  class="bg-info">
													<th rowspan="2" align="center"><b>NO</b></th>
													<th rowspan="2" align="center"><b>NAMA PENGAWAS</b></th>
													<?php
														for ($i=0; $i < $jumlah_hari ; $i++) {	
													?>
													<th align="center" colspan="<?php echo $jumlah_sesi[$i];?>"><b><?php echo $tanggal_array[$i]; ?></b></th>	
													<?php
														}
																
													?>
													
												</tr>
												<tr>
													
													<?php
														for ($i=0; $i < $jumlah_hari ; $i++) {
															$sesi_array = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$i]);
															foreach ($sesi_array->result_array() as $sesi):
																$jam_mulai_array=$sesi['jam_mulai'];
															
															// for ($j=0; $j < $jumlah_sesi[$i]; $j++) { 
																// $this->m_presensi_pengawas->ambil_npk(, )
													?>

															<td><?php echo 'SESi '.$jam_mulai_array;?></td>
													

													<?php
															// }
															endforeach;

														}
													?>
												</tr>
											</thead>
											<tbody>
											<?php 
													$no = 1;
													$mulai = false;
													$rowspan = false;
													foreach($data_dosen->result_array() as $i):
														$npk_dosen=$i['npk'];
														$nama_dosen=$i['nama_dosen'];
														
												?>
												<tr>
													<td><?php echo $no++;?></td>
													
													<td><?php echo $nama_dosen;?></td>	

													<?php
														for ($a=0; $a < $jumlah_hari ; $a++) {
															// for ($b=0; $b < $jumlah_sesi[$a]; $b++) { 
																

																$sesi_array = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$a]);
																foreach ($sesi_array->result_array() as $sesi):
																	$jam_mulai_array=$sesi['jam_mulai'];
																	
																	$ttd = $this->m_presensi_pengawas->ambil_ttd($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$a], $jam_mulai_array, $npk_dosen);

																if($ttd){
																	$jam_mulai = $ttd->jam_mulai;
																}
																else{
																	$jam_mulai ="";
																}
																
													?>

															<td>
																	<?php 
																	// echo $jam_mulai;
																	if($jam_mulai==$jam_mulai_array){echo $jam_mulai;}else{echo '-';} 
																	?>
																	<!-- aa -->
																	
															</td>
													

													<?php
																endforeach;
															// }
														}
													?>
													
												</tr>
												<?php endforeach;?>
											</tbody>
										</table>
									</div>
									<?php }else{ ?>
										<h3 class="text-danger">Silahkan pilih ujian terlebih dahulu!</h3>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

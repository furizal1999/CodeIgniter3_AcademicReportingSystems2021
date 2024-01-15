
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DETAIL PRESENSI</h1>
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
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 bg-light rounded">
											
										</div>
									</div>
									
								<?php echo $this->session->flashdata('messege'); ?>
								<?php 
									if(isset($id_presensi_pertemuan)){
										$data = $this->m_preview_laporan_pertemuan->getPresensi($id_presensi_pertemuan);
										if($data->num_rows()==1){
											$dataRow = $data->row();
											if($dataRow){
												$pertemuan_ke = $dataRow->pertemuan_ke;
												$media = $dataRow->media_pertemuan;
												$kode_ruang = $dataRow->kode_ruang;
												$waktu_input = $dataRow->waktu_input;
												$waktu_pertemuan = $dataRow->waktu_pertemuan;
												$status_verifikasi = $dataRow->status_verifikasi;
												$mhs_hadir = $dataRow->mhs_hadir;
												$materi = $dataRow->materi_pertemuan;
												$metode = $dataRow->metode_pertemuan;
												$foto_pertemuan = $dataRow->foto_pertemuan;

								?>

															
																		
																		<div class="row">
																			<div class="col-md-6">
																				
																					
																				<div class="row">
																					<div class="col-md-12">
																						<label>Pertemuan Ke</label><br>
																						<h1><b><?php echo $pertemuan_ke; ?></b></h1>
																					</div>
																					<div class="col-md-12">
																						<label>Media</label><br>
																						<h1><b><?php echo $media; ?></b></h1>
																					</div>
																					<div class="col-md-12">
																						<label>Ruang</label><br>
																						<h1><b><?php if($kode_ruang!=""){ echo $kode_ruang; }else{ echo '-'; } ?></b></h1>
																					</div>
																				</div>
																				
																				<div class="row">
																					<div class="col-md-12">
																						<label>Waktu Pertemuan</label><br>
																						<h1><b><?php echo $waktu_pertemuan; ?></b></h1>
																					</div>
																					<div class="col-md-12">
																						<label>Waktu Input</label><br>
																						<h1><b><?php echo $waktu_input; ?></b></h1>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-12">
																						<label>Status verifikasi</label><br>
																						<h1><b><?php echo $status_verifikasi; ?></b></h1>
																					</div>
																					<div class="col-md-12">
																						<label>Jumlah Mahasiswa Hadir</label><br>
																						<h1><b><?php echo $mhs_hadir; ?></b></h1>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-12">
																						<label>Materi</label><br>
																						<h1><b><?php echo $materi; ?></b></h1>
																					</div>
																				</div>
																				<div class="row">
																					<div class="col-md-12">
																						<label>Metode Pembelajaran</label><br>
																						<h1><b><?php echo $metode; ?></b></h1>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="row">
																					<div class="col-md-12">
																						<label>Foto Bukti pertemuan</label><br>
																						<?php if($foto_pertemuan==""){ ?>
																							<p class="text-danger">Maaf foto bukti pertemuan belum tersedia..</p>
																						<?php }else{ ?>
																							<img width="100%" src="<?php echo base_url('templates/img/bukti-pertemuan/'.$foto_pertemuan)?>">
																						<?php } ?>
																					</div>
																				</div>
																			</div>
																		</div>
																		
								<?php
											}
										}else{
											echo 'Maaf, tidak ditemukan data yang valid!';
										}
									}else{
										echo 'Maaf, tidak ditemukan data yang valid!';
									}

								?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

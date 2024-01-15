<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SK PENGAWAS DAN TATA TERTIB UJIAN</h1>
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
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>UJIAN</b></td>
												<td align="center"><b>TATA TERTIB</b></td>
												<td align="center"><b>SK PENGAWAS</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$nomor_surat=$i['nomor_surat'];
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$id_surat_keputusan=$i['id_surat_keputusan'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$semester=$i['semester'];
													$jenis_ujian=$i['ket_ujian'];
													$nama_ujian=$i['nama_ujian'];
													$file_tata_tertib=$i['file_tata_tertib'];
													$file_sk_pengawas=$i['file_sk_pengawas'];
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tahun_ajaran.' | '.$semester.' | '.$nama_ujian.' | '.$jenis_ujian;?></td>
												<td>
													<?php if(empty($i['file_tata_tertib'])){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/fakultas/tata tertib/'.$file_tata_tertib)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
												<td>
													<?php if(empty($i['file_sk_pengawas'])){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/fakultas/sk_pengawas/'.$file_sk_pengawas)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

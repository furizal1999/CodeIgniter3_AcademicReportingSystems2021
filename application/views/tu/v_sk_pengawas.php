<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SK PENGAWAS UJIAN</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<!-- <a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Tahun Ajaran</a>		 -->
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
												<td align="center"><b>SK PENGAWAS</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$nomor_surat=$i['nomor_surat'];
													$id_tahun_ajaran=$i['id_tahun_ajaran'];
													$id_ujian=$i['id_ujian'];
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
													<?php if(empty($i['file_sk_pengawas'])){ ?>
													<i class="text-danger">Berkas belum tersedia!</i>
													<?php }else{ ?>
														<a href="<?php echo base_url('templates/file/user/fakultas/sk_pengawas/'.$file_sk_pengawas)?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
													<?php } ?>
												</td>
												<td style="width: 150px;" class="text-white">
													

													<?php if(empty($i['file_sk_pengawas'])){ ?>
														<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_upload_file<?php echo $id_ujian;?>"><i class="fa fa-upload"></i> Unggah Berkas</a>
													<?php }else{?>
														<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_ujian;?>"><i class="fa fa-trash"></i> Hapus File</a>
													<?php }?>
													
													<!-- <p class="text-warning">NO ACTION</p> -->
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>


							

						<!-- ============ MODAL UPLOAD BUKTI FOTO =============== -->
								<?php 
									foreach($data->result_array() as $i):
										$id_tahun_ajaran=$i['id_tahun_ajaran'];
										$id_surat_keputusan=$i['id_surat_keputusan'];
										$id_ujian=$i['id_ujian'];
										$nomor_surat=$i['nomor_surat'];
										$tahun_ajaran=$i['tahun_ajaran'];
										$semester=$i['semester'];
										$jenis_ujian=$i['ket_ujian'];
										$nama_ujian=$i['nama_ujian'];
										$file_tata_tertib=$i['file_tata_tertib'];
										$file_sk_pengawas=$i['file_sk_pengawas'];
										
									?>
								<div class="modal fade" id="modal_upload_file<?php echo $id_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success">
											<h3 class="modal-title" id="myModalLabel">Upload Berkas SK</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/sk_pengawas/upload'?>" enctype="multipart/form-data">
											<div class="modal-body">
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
												<input type="hidden" name="id_ujian" value="<?php echo $id_ujian;?>">

												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												<button class="btn btn-success">Unggah Sekarang</button>
											</div>
										</form>
										</div>
										</div>
									</div>
								<?php endforeach;?>
								<!--END MODAL UPLOAD BUKTI FOTO -->
							
							
							
							<?php 
								foreach($data->result_array() as $i):
									$id_tahun_ajaran=$i['id_tahun_ajaran'];
									$id_surat_keputusan=$i['id_surat_keputusan'];
									$id_ujian=$i['id_ujian'];
									$tahun_ajaran=$i['tahun_ajaran'];
									$semester=$i['semester'];
									$jenis_ujian=$i['ket_ujian'];
									$nama_ujian=$i['nama_ujian'];
									$file_tata_tertib=$i['file_tata_tertib'];
									$file_sk_pengawas=$i['file_sk_pengawas'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_ujian;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Berkas SK</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/sk_pengawas/hapus_berkas'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus berkas SK pengawas untuk tahun ajaran <b><?php echo $tahun_ajaran.'->'.$semester.'->'.$nama_ujian;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_ujian" value="<?php echo $id_ujian;?>">
											<input type="hidden" name="berkaslama" value="<?php echo $file_sk_pengawas;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

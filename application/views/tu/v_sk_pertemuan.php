<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SK PENGAMPU</h1>
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
									<div class="row">
										<div class="col-md-6 bg-light rounded">
											<form action="<?php echo base_url('tu/sk_pertemuan')?>" method="post">
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
													<div class="col-md-2">

														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label><br>
															<input type="submit" name="tombol_cari_pertemuan" value="Cari Sekarang" class="btn btn-primary">
														</div>

													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
									<?php if(isset($_SESSION["id_pertemuan_search"])){ ?>
										<div class="table-responsive">
											<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%">
												<thead>
													<tr  class="bg-info">
														<td align="center"><b>NOMOR</b></td>
														<td align="center"><b>NAMA PRODI</b></td>
														<td align="center"><b>BERKAS SK</b></td>
														<td align="center"><b>AKSI</b></td>
													</tr>
												</thead>
												<tbody>
												<?php
														$no = 1;
														foreach($data->result_array() as $i):
													?>
													<tr>
														<td><?php echo $no++;?></td>
														<td><?php echo $i["nama_prodi"] ?></td>
														<td>
															<?php if($this->m_sk_pertemuan->getFile($i['kode_prodi'])==''){ ?>
															<i class="text-danger">Berkas belum tersedia!</i>
															<?php }else{ ?>
																<a href="<?php echo base_url('templates/file/user/fakultas/sk_pertemuan/'.$this->m_sk_pertemuan->getFile($i['kode_prodi']))?>" target="_BLANK" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> Lihat File</a>
															<?php } ?>
														</td>
														<td style="width: 150px;" class="text-white">


															<?php if($this->m_sk_pertemuan->getFile($i['kode_prodi'])==''){ ?>
																<a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal_upload_file<?php echo $i["kode_prodi"];?>"><i class="fa fa-upload"></i> Unggah Berkas</a>
																<div class="modal fade" id="modal_upload_file<?php echo $i["kode_prodi"];?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
																		<div class="modal-dialog">
																		<div class="modal-content">
																		<div class="modal-header bg-success">
																			<h3 class="modal-title" id="myModalLabel">Upload Berkas SK</h3>
																			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																		</div>
																		<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/sk_pertemuan/upload'?>" enctype="multipart/form-data">
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
																				<input type="hidden" name="kode_prodi" value="<?= $i["kode_prodi"] ?>">
																				<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
																				<button class="btn btn-success" name="tombol_upload_sk_pertemuan">Upload Sekarang</button>
																			</div>
																		</form>
																		</div>
																		</div>
																	</div>
															<?php }else{?>
																<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $i["kode_prodi"];?>"><i class="fa fa-trash"></i> Hapus File</a>
																<div class="modal fade" id="modal_hapus<?php echo $i["kode_prodi"]; ?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
																	<div class="modal-dialog">
																	<div class="modal-content">
																	<div class="modal-header bg-danger">
																		<h3 class="modal-title" id="myModalLabel">Hapus Berkas SK</h3>
																		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
																	</div>
																	<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/sk_pertemuan/hapus_berkas'?>">
																		<div class="modal-body text-dark">
																			<p>Anda yakin menghapus berkas SK Program Studi <?= $i['nama_prodi'] ?>?</p>
																		</div>
																		<div class="modal-footer">
																			<input type="hidden" name="kode_prodi" value="<?php echo $i["kode_prodi"];?>">
																			<input type="hidden" name="berkaslama" value="<?php echo $this->m_sk_pertemuan->getFile($i['kode_prodi']);?>">
																			<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
																			<button class="btn btn-danger" name="tombol_hapus_sk_pertemuan">Hapus</button>
																		</div>
																	</form>
																	</div>
																	</div>
																</div>
															<?php }?>

															<!-- <p class="text-warning">NO ACTION</p> -->
														</td>
													</tr>
													<?php endforeach;?>
												</tbody>
											</table>
										</div>
									<?php }else{ echo '<b class="text-danger">Pilih pertemuan terlebih dahulu!</b>'; } ?>

								</div>
							</div>
						</div>
					</div>
				</div>


			</div>

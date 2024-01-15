		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">REKAP BERKAS PERTEMUAN</h1>
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
										
										<div class="col-md-8 bg-light rounded">
											<form action="<?php echo base_url('tu/rekap_berkas_pertemuan')?>" method="post">
												<div class="row">
													<div class="col-md-8">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PERTEMUAN</label>
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
															<label class="control-label col-xs-3">AKSI</label>
															<input type="submit" name="tombol_cari_id_pertemuan" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
										<div class="col-md-4 bg-light rounded">
										</div>
									</div>
									<?php 
										if(isset($_SESSION['id_pertemuan_search'])){
									?>
									<div class="row">
										
										<div class="col-md-8 bg-light rounded">
											<form action="<?php echo base_url('tu/rekap_berkas_pertemuan')?>" method="post">
												<div class="row">
													<?php 
														
															

															

															// date_default_timezone_set('Asia/Jakarta');
															// $bulan_sekarang = date('m');
													?>
													<div class="col-md-8">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >ORDER BY</label>
															<select name="orderby" class="form-control" required>
																<option value="">--Pilih--</option>
																<option value="prodi" <?php if (isset($_SESSION['orderby'])){ if ($_SESSION['orderby']=="prodi") {
																	echo 'selected';
																}} ?> >prodi</option>
																<option value="npk" <?php if (isset($_SESSION['orderby'])){ if ($_SESSION['orderby']=="npk") {
																	echo 'selected';
																}} ?> >NIDN Dosen</option>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label>
															<input type="submit" name="tombol_order_by" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
										<div class="col-md-4 bg-light rounded">
											<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['orderby'])){ ?>
												<div class="form-group text-left">
													<label class="control-label col-xs-3">AKSI CETAK</label><br>
													<a href="<?= base_url('tu/rekap_berkas_pertemuan/cetak/'.$_SESSION['id_pertemuan_search'])?>" target="_BLANK" class="btn btn-warning"><i class="fas fa-print"></i>  CETAK REKAP BERKAS PERTEMUAN</a>
												</div>
												
											<?php } ?>
										</div>
									</div>

									<?php
										}
									 ?>	

								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>
			


							
										
									
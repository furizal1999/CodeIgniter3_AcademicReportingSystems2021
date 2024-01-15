
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DAFTAR KELAS</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<?php if(isset($_SESSION['kode_prodi'])){?>
									<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Kelas</a>		
								<?php } ?>
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
									<div class="col-md-6 bg-light rounded">
										<form action="<?php echo base_url('tu/kelas')?>" method="post">
											<div class="row">
												<div class="col-md-8">
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
												<div class="col-md-4">
													
													<div class="form-group text-left">
														<label class="control-label col-xs-3">AKSI</label>
														<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
													</div>
													
												</div>
											</div>
										</form>
									</div>
									<hr>
								<?php if(isset($_SESSION['kode_prodi'])){?>
								
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>NOMOR</b></td>
												<td align="center"><b>SEMESTER</b></td>
												<td align="center"><b>NAMA KELAS</b></td>
												<td align="center"><b>KETERANGAN</b></td>
												<td align="center"><b>AKSI</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):
													$id_kelas=$i['id_kelas'];
													$semester=$i['semester'];
													$nama_kelas=$i['nama_kelas'];
													$kelas_pilihan=$i['kelas_pilihan'];
													if($kelas_pilihan=="PIL"){
														$kelas_pilihan = "PILIHAN";
													}
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $semester;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $kelas_pilihan;?></td>
												<td style="width: 250px;" class="text-white">
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit<?php echo $id_kelas;?>"><i class="fa fa-pen"></i> Edit</a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus<?php echo $id_kelas;?>"><i class="fa fa-trash"></i> Hapus</a>
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>


							

								<!-- ============ MODAL ADD =============== -->
								<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-primary text-white">
										<h3 class="modal-title" id="myModalLabel">Tambah Kelas</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url('tu/kelas/tambah_kelas')?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														for($i=0; $i<=8; $i++){
															if($i == 0){
																$det = "TIDAK ADA SEMESTER";
															}else{
																$det = "";
															}
													?>
													<option  value="<?php echo ($i) ?>"><?php echo ($i.' '.$det) ?></option>
													<?php }?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Kelas</label>
												<select name="kelas" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="A">A</option>
													<option  value="B">B</option>
													<option  value="C">C</option>
													<option  value="D">D</option>
													<option  value="E">E</option>
													<option  value="F">F</option>
													<option  value="G">G</option>
													<option  value="H">H</option>
													<option  value="I">I</option>
													<option  value="J">J</option>
													<option  value="K">K</option>
													<option  value="L">L</option>
													<option  value="M">M</option>
													<option  value="N">N</option>
													<option  value="O">O</option>
													<option  value="P">P</option>
													<option  value="Q">Q</option>
													<option  value="R">R</option>
													<option  value="S">S</option>
													<option  value="T">T</option>
												</select>
											</div>

											<div class="form-group bg-light rounded">
												<label>Apakah merupakan kelas pilihan? <i class="text-danger">(Optional)</i></label><br>
												<input type="checkbox" name="kelas_pilihan" value="PIL">
		  										<label class="text-danger"> Ya</label><br>
											</div>

										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info">Simpan</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<!--END MODAL ADD-->
							
							<!-- ============ MODAL EDIT =============== -->
							<?php 
								foreach($data->result_array() as $i):
									$id_kelas=$i['id_kelas'];
									$semester=$i['semester'];
									$nama_kelas=$i['nama_kelas'];
									$kelas_pilihan=$i['kelas_pilihan'];

								?>
								<div class="modal fade" id="modal_edit<?php echo $id_kelas;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary text-white">
										<h3 class="modal-title" id="myModalLabel">Edit Kelas</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/kelas/edit_kelas'?>">
										<div class="modal-body">

											<div class="form-group">
												<label class="control-label col-xs-3" >ID</label>
												<div class="col-xs-8">
													<input name="id_kelas" class="form-control" value="<?php echo $id_kelas?>" readonly>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Semester</label>
												<select name="semester" class="form-control" required>
													<option value="">--Pilih--</option>
													<?php
														for($i=0; $i<=8; $i++){
															if($i == 0){
																$det = "TIDAK ADA SEMESTER";
															}else{
																$det = "";
															}
													?>
													<option  value="<?php echo ($i) ?>" <?php if($i==$semester){ echo 'selected'; } ?>><?php echo ($i.' '.$det) ?></option>
													<?php }?>
												</select>
											</div>

											<div class="form-group">
												<label class="control-label col-xs-3" >Kelas</label>
												<select name="kelas" class="form-control" required>
													<option value="">--Pilih--</option>
													<option  value="A" <?php if($nama_kelas=="A"){echo 'selected';}?>>A</option>
													<option  value="B" <?php if($nama_kelas=="B"){echo 'selected';}?>>B</option>
													<option  value="C" <?php if($nama_kelas=="C"){echo 'selected';}?>>C</option>
													<option  value="D" <?php if($nama_kelas=="D"){echo 'selected';}?>>D</option>
													<option  value="E" <?php if($nama_kelas=="E"){echo 'selected';}?>>E</option>
													<option  value="F" <?php if($nama_kelas=="F"){echo 'selected';}?>>F</option>
													<option  value="G" <?php if($nama_kelas=="G"){echo 'selected';}?>>G</option>
													<option  value="H" <?php if($nama_kelas=="H"){echo 'selected';}?>>H</option>
													<option  value="I" <?php if($nama_kelas=="I"){echo 'selected';}?>>I</option>
													<option  value="J" <?php if($nama_kelas=="J"){echo 'selected';}?>>J</option>
													<option  value="K" <?php if($nama_kelas=="K"){echo 'selected';}?>>K</option>
													<option  value="L" <?php if($nama_kelas=="L"){echo 'selected';}?>>L</option>
													<option  value="M" <?php if($nama_kelas=="M"){echo 'selected';}?>>M</option>
													<option  value="N" <?php if($nama_kelas=="N"){echo 'selected';}?>>N</option>
													<option  value="O" <?php if($nama_kelas=="O"){echo 'selected';}?>>O</option>
													<option  value="P" <?php if($nama_kelas=="P"){echo 'selected';}?>>P</option>
													<option  value="Q" <?php if($nama_kelas=="Q"){echo 'selected';}?>>Q</option>
													<option  value="R" <?php if($nama_kelas=="R"){echo 'selected';}?>>R</option>
													<option  value="S" <?php if($nama_kelas=="S"){echo 'selected';}?>>S</option>
													<option  value="T" <?php if($nama_kelas=="T"){echo 'selected';}?>>T</option>
												</select>
											</div>

											<div class="form-group bg-light rounded">
												<label>Apakah merupakan kelas pilihan? <i class="text-danger">(Optional)</i></label><br>
												<input type="checkbox" name="kelas_pilihan" value="PIL" <?php if($kelas_pilihan=="PIL"){echo 'checked';}?>>
		  										<label class="text-danger"> Ya</label><br>
											</div>

										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info">Simpan Perubahan</button>
										</div>
									</form>
									</div>
									</div>
								</div>

							<?php endforeach;?>
							<!--END MODAL EDIT-->
							
							<?php 
								foreach($data->result_array() as $i):
									$id_kelas=$i['id_kelas'];
									$semester=$i['semester'];
									$nama_kelas=$i['nama_kelas'];
								?>
							<!-- ============ MODAL HAPUS =============== -->
								<div class="modal fade" id="modal_hapus<?php echo $id_kelas;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Kelas</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/kelas/hapus_kelas'?>">
										<div class="modal-body">
											<p>Anda yakin mau menghapus kelas <b><?php echo $semester.$nama_kelas;?></b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_kelas" value="<?php echo $id_kelas;?>">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>
							<?php endforeach;?>
							<!--END MODAL HAPUS -->



									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH PRODI TERLEBIH DAHULU...</h1>
									<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

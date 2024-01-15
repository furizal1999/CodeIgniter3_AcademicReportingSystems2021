		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">JADWAL PENGAMPU MATAKULIAH</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
										<a class="text-white border-white custom-btn bg-primary btn mt-3" data-toggle="modal" data-target="#modal_add_new"><i class="fa fa-plus"></i> Tambah Pengampu</a>
										<!-- ============ MODAL ADD =============== -->
										<div class="modal fade" id="modal_add_new" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-primary text-white">
												<h3 class="modal-title" id="myModalLabel">Tambah Jadwal Pengampu</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="<?php echo base_url('tu/jadwal_pengampu_matkul/tambah_jadwal_pengampu_matkul')?>">
												<div class="modal-body">

													<div class="form-group">
														<label class="control-label col-xs-3" >MATAKULIAH</label>
														<select id="kode_mk" name="kode_mk" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_matkul->result_array() as $i):
																	$kode_matkul_combo=$i['kode_mk'];
																	$nama_matkul_combo=$i['nama_mk'];
																	
															?>
															<option  value="<?php echo $kode_matkul_combo ?>">
																<?php echo $kode_matkul_combo," - ",$nama_matkul_combo?>
															</option>
															<?php endforeach;?>
														</select>
													</div>

													<div class="form-group bg-warning rounded mt-3 mb-3">
														<label class="control-label col-xs-3" >DOSEN PENGAMPU-1</label>
														<select id="dosen_pengampu1" name="dosen_pengampu1" class="form-control" required>
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_dosen_semua->result_array() as $i):
																	$npk_combo=$i['npk'];
																	$nama_dosen_combo=$i['nama_dosen'];
															?>
															<option  value="<?php echo $npk_combo ?>">
																<?php echo $nama_dosen_combo?>
															</option>
															<?php endforeach;?>
														</select>

														<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-2 <i class="text-danger">optional</i></label>
														<select id="dosen_pengampu2" name="dosen_pengampu2" class="form-control">
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_dosen_semua->result_array() as $i):
																	$npk_combo=$i['npk'];
																	$nama_dosen_combo=$i['nama_dosen'];
															?>
															<option  value="<?php echo $npk_combo ?>">
																<?php echo $nama_dosen_combo?>
															</option>
															<?php endforeach;?>
														</select>

														<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-3 <i class="text-danger">optional</i></label>
														<select id="dosen_pengampu3" name="dosen_pengampu3" class="form-control">
															<option value="">--Pilih--</option>
															<?php
																foreach($combobox_dosen_semua->result_array() as $i):
																	$npk_combo=$i['npk'];
																	$nama_dosen_combo=$i['nama_dosen'];
															?>
															<option  value="<?php echo $npk_combo ?>">
																<?php echo $nama_dosen_combo?>
															</option>
															<?php endforeach;?>
														</select>

													</div>
													
													<div class="form-group">
														<label class="control-label col-xs-3" >JUMLAH KELAS</label>
														<div class="col-xs-8">
															<input name="jumlah_kelas" class="form-control" type="number" placeholder="Jumlah kelas..." required>
														</div>
													</div>
												</div>

												<div class="modal-footer">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
													<button class="btn btn-info" name="tambah_pengampu">Simpan</button>
												</div>
											</form>
											</div>
											</div>
										</div>
									<!--END MODAL ADD-->
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
									
									<div class="row">
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('tu/jadwal_pengampu_matkul')?>" method="post">
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
															<label class="control-label col-xs-3" >PERTEMUAN</label>
															<select name="id_pertemuan" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach($combobox_tahun_ajaran->result_array() as $i):
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
															<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
									<div class="table-responsive">
										<table id="dataJadwalPengampuMatkul" class="table table-bordered table-striped"  cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center" width="120px"><b>JMLH KELAS</b></td>
													<td align="center"><b>BLM T'JDWL</b></td>
													<td align="center"><b>AKSI</b></td>
													
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								<?php }else{ ?>
									<h1 class="text-danger">Silahkan pilih prodi dan pertemuan semester terlebih dahulu!</h1>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>
<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>


<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#dataJadwalPengampuMatkul').DataTable( {
			"processing": true,
			"serverSide": true,
			"paging": true,
	        "lengthChange": true,
	        "searching": true,
	        "ordering": true,
	        "info": true,
	        "autoWidth": true,
	      //   "columnDefs": [ {
							// "targets": [2,3,4,5,6,7],
							// "orderable": false
							// } ],
			"ajax":{
				url :"<?= base_url('tu/jadwal_pengampu_matkul/get_ajax');?>",
				type: "post",
				error: function(){
					$(".dataJadwalPengampuMatkul-error").html("");
					$("#dataJadwalPengampuMatkul").append('<tbody class="dataJadwalPengampuMatkul-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
					$("#dataJadwalPengampuMatkul-error-proses").css("display","none");
					
				}
			}
		} );
	} );
</script>


<?php } ?>


							
										
									

		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">Jadwal Ujian Lanjutan</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi "?> Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<h1 align="right">
									<a class="btn btn-info mt-3" href="<?php echo base_url('tu/jadwal_ujian')?>"><i class="fa fa-eye"></i> Lihat Jadwal Awal</a>
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
											<form action="<?php echo base_url('tu/jadwal_ujian_lanjutan')?>" method="post">
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
								<?php if(isset($_SESSION['id_ujian_search'])){ ?>
									<div class="table-responsive">
										<table id="dataku" class="table table-bordered table-striped"  cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>MATAKULIAH</b></td>
													<td align="center"><b>PENGAMPU</b></td>
													<td align="center"><b>TANGGAL UJIAN</b></td>
													<td align="center"><b>JAM UJIAN</b></td>
													<td align="center"><b>NAMA KELAS</b></td>
													<td align="center"><b>JUMLAH MHS</b></td>
													<td align="center"><b>RUANG TERJADWAL</b></td>
												<td align="center" style="width: 200px;"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>

											</tbody>
										</table>
									</div>
								<?php }else{ ?>
									<h2 class="text-danger">Silahkan pilih ujian terlebih dahulu!</h2>
								<?php }?>
								</div>
							</div>
						</div>
					</div>
				</div>


			</div>

<?php if(isset($_SESSION['id_ujian_search'])){ ?>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#dataku').DataTable( {
			"processing": true,
			"serverSide": true,
			"paging": true,
	        "lengthChange": true,
	        "searching": true,
	        "ordering": true,
	        "info": true,
	        "autoWidth": true,
	        "columnDefs": [ {
							"targets": [2,3,4,5,6,7],
							"orderable": false
							} ],
			"ajax":{
				url :"<?= base_url('tu/jadwal_ujian_lanjutan/get_ajax');?>",
				type: "post",
				error: function(){
					$(".dataku-error").html("");
					$("#dataku").append('<tbody class="dataku-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
					$("#dataku-error-proses").css("display","none");

				}
			}
		} );
	} );
</script>

<?php } ?>

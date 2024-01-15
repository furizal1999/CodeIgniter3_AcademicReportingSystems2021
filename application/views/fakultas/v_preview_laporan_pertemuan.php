
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PREVIEW LAPORAN PERTEMUAN</h1>
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
											<form action="<?php echo base_url('fakultas/preview_laporan_pertemuan')?>" method="post">
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
															<input type="submit" name="tombol_cari_tahun_ajaran" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
									</div>
									<hr>
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
									<div class="table-responsive">
										<table id="dataPreviewLaporanPertemuanPadaAksesFakultas" class="table table-bordered table-striped"  cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-success">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>SEMESTER</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center"><b>NAMA MATKUL</b></td>
													<td align="center"><b>SKS</b></td>
													<td align="center"><b>KELAS</b></td>
													<td align="center"><b>HARI</b></td>
													<?php 

													$pertemuan_awal=0;
													$pertemuan_akhir=16;

													for ($i= $pertemuan_awal; $i < $pertemuan_akhir; $i++){ ?>
													<td align="center"><b>P<?php echo ($i+1);?></b></td>
													<?php } ?>
													<td align="center"><b>AKSI</b></td>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								<?php }else{ ?>
									<h1 class="text-danger">Silahkan pilih pertemuan semester terlebih dahulu!</h1>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>
<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
		var dataTable = $('#dataPreviewLaporanPertemuanPadaAksesFakultas').DataTable( {
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
				url :"<?= base_url('fakultas/preview_laporan_pertemuan/get_ajax');?>",
				type: "post",
				error: function(){
					$(".dataPreviewLaporanPertemuanPadaAksesFakultas-error").html("");
					$("#dataPreviewLaporanPertemuanPadaAksesFakultas").append('<tbody class="dataPreviewLaporanPertemuanPadaAksesFakultas-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
					$("#dataPreviewLaporanPertemuanPadaAksesFakultas-error-proses").css("display","none");
					
				}
			}
		} );
	} );
</script>


<?php } ?>


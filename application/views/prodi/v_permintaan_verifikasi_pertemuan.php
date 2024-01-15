
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PERMINTAAN VERIFIKASI PERTEMUAN</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi ",$_SESSION['nama_prodi'];?> Fakultas Teknik Universitas Islam Riau</h5>
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
											<form action="<?php echo base_url('prodi/permintaan_verifikasi_pertemuan')?>" method="post">
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
													<div class="col-md-4">
														
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
								<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
									<div class="table-responsive">
										<table id="dataPermintaanVerifikasiPertemuan" class="table table-bordered table-striped"  cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>						
													<td align="center"><b>NAMA DOSEN</b></td>
													<td align="center"><b>MATAKULIAH</b></td>						
													<td align="center"><b>KELAS</b></td>
													<td align="center"><b>PERTEMUAN KE</b></td>
													<td align="center"><b>STATUS VERIFIKASI</b></td>
													<td align="center" width="250px"><b>AKSI</b></td>
													
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
		var dataTable = $('#dataPermintaanVerifikasiPertemuan').DataTable( {
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
				url :"<?= base_url('prodi/permintaan_verifikasi_pertemuan/get_ajax');?>",
				type: "post",
				error: function(){
					$(".dataPermintaanVerifikasiPertemuan-error").html("");
					$("#dataPermintaanVerifikasiPertemuan").append('<tbody class="dataPermintaanVerifikasiPertemuan-error"><tr><th colspan="3">Tidak ada data untuk ditampilkan</th></tr></tbody>');
					$("#dataPermintaanVerifikasiPertemuan-error-proses").css("display","none");
					
				}
			}
		} );
	} );
</script>


<?php } ?>


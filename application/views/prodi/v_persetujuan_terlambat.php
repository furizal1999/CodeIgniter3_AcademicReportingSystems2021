
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">PERSETUJUAN TERLAMBAT</h1>
								<h5 class="text-white op-7 mb-2"><?php echo "Program Studi ",$_SESSION['nama_prodi'];?> Fakultas Teknik Universitas Islam Riau</h5>
							</div>
							<div class="ml-md-auto py-2 py-md-0">
								<!-- <a class="btn btn-success mt-3" href="<?php echo base_url('prodi/persetujuan_terlambat_search')?>"><i class="fa fa-search"></i> Cari Kategori Lain</a> -->
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
											<form action="<?php echo base_url('prodi/persetujuan_terlambat')?>" method="post">
												<div class="row">
													
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
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>PENGAWAS 1</b></td>
													<td align="center"><b>STATUS PENGAWAS 1</b></td>
													<td align="center" width="500px"><b>AKSI PENGAWAS 1</b></td>
													<td align="center"><b>PENGAWAS 2</b></td>	
													<td align="center"><b>STATUS PENGAWAS 2</b></td>
													<td align="center" width="500px"><b>AKSI PENGAWAS 2</b></td>
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
				url :"<?= base_url('prodi/persetujuan_terlambat/get_ajax');?>",
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




<div class="main-panel">
	<div class="content">
		<div class="panel-header bg-primary-gradient">
			<div class="page-inner py-5">
				<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
					<div>
						<h1 class="text-white pb-2 fw-bold">REKAPITULASI</h1>
						<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
					</div>
					<div align="right" class="ml-md-auto m-1 inline">
					</div>

							<!-- <div align="right" class="ml-md-auto m-1">

							</div> -->
						</div>
					</div>
				</div>

				<div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">

								<div class="card-body">
									<div class="col-md-10 bg-light rounded">
										<form action="<?php echo base_url('tu/rekapitulasi')?>" method="post">
											<div class="row">
												<div class="col-md-8">
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
												<div class="col-md-4">

													<div class="form-group text-left">
														<label class="control-label col-xs-3">AKSI</label><br>
														<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
													</div>

												</div>
											</div>
										</form>
									</div>
									<hr>
									<?php echo $this->session->flashdata('messege'); ?>
									<?php if(isset($_SESSION['id_ujian_search'])){ ?>
											<a class="btn btn-warning" href="<?php echo base_url('tu/rekapitulasi/cetak/'.$_SESSION['id_ujian_search']);?>" target="_BLANK">Cetak Laporan Tatap Muka</a>
										</div>
							<?php }else{ ?>
								<h1 class="text-danger">SILAHKAN PILIH PRODI TERLEBIH DAHULU...</h1>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>

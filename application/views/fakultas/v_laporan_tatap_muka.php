		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">LAPORAN TATAP MUKA</h1>
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
											<form action="<?php echo base_url('fakultas/laporan_tatap_muka')?>" method="post">
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
											$hasilCek = $this->m_laporan_tatap_muka->getRangePertemuan($_SESSION['id_pertemuan_search']);
											if($hasilCek->num_rows()==1){
												$HasilCekrow = $hasilCek->row();
												if($HasilCekrow){
													$start = date('Y-m-d', strtotime($HasilCekrow->pertemuan_mulai));
													$start = new DateTime($start);
													$start->modify('first day of this month');
													$end = date('Y-m-d', strtotime($HasilCekrow->pertemuan_selesai));
													
													$end = new DateTime($end);
													$end->modify('first day of next month');

													$interval = DateInterval::createFromDateString('1 month');
													$period   = new DatePeriod($start, $interval, $end);

													$monthList = array(
																'01' => 'Jan',
															    '02' => 'Feb',
															    '03' => 'Mar',
															    '04' => 'Apr',
															    '05' => 'Mei',
															    '06' => 'Jun',
															    '07' => 'Jul',
															    '08' => 'Agu',
															    '09' => 'Sep',
															    '10' => 'Okt',
															    '11' => 'Nov',
															    '12' => 'Des',
															);

													// foreach ($period as $dt) {
													//     echo $monthList[$dt->format("m")].'-'. $dt->format("Y") ;
													// }
													// die();
												}
												

									 ?>
									<div class="row">
										
										<div class="col-md-8 bg-light rounded">
											<form action="<?php echo base_url('fakultas/laporan_tatap_muka')?>" method="post">
												<div class="row">
													<?php 
														
															

															

															// date_default_timezone_set('Asia/Jakarta');
															// $bulan_sekarang = date('m');
													?>
													<div class="col-md-8">
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >BULAN</label>
															<select name="bulan" class="form-control" required>
																<option value="">--Pilih--</option>
																<?php
																	foreach ($period as $dt) {
																		$format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
																		$format_time_angka = $dt->format("Y-m") ;
																		$format_time_angka_tanpa_strip = $dt->format("Ym") ;
																			
																?>
																		<option  value="<?= $format_time_angka_tanpa_strip;?>" <?php if (isset($_SESSION['bulan_search'])){ if(strcmp($_SESSION['bulan_search'],$format_time_angka_tanpa_strip)==0){ echo 'selected'; }}  ?>>
																			<?= $format_time ?>
																		</option>
															
															<?php } ?>
															</select>
														</div>
													</div>
													<div class="col-md-2">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label>
															<input type="submit" name="tombol_cari_bulan" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
										</div>
										<div class="col-md-4 bg-light rounded">
											<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['bulan_search']) && isset($_SESSION['orderby'])){ ?>
												<!-- <div class="form-group text-left">
													<label class="control-label col-xs-3">AKSI CETAK</label><br>
													<a href="<?= base_url('fakultas/laporan_tatap_muka/cetak/'.$_SESSION['id_pertemuan_search'])?>" target="_BLANK" class="btn btn-warning"><i class="fas fa-print"></i>  CETAK LAPORAN TATAP MUKA</a>
												</div> -->
												
											<?php } ?>
										</div>
									</div>
									<?php 
											}
										}
										if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['bulan_search'])){
									?>
									<div class="row">
										
										<div class="col-md-8 bg-light rounded">
											<form action="<?php echo base_url('fakultas/laporan_tatap_muka')?>" method="post">
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
											<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['bulan_search']) && isset($_SESSION['orderby'])){ ?>
												<div class="form-group text-left">
													<label class="control-label col-xs-3">AKSI CETAK</label><br>
													<a href="<?= base_url('fakultas/laporan_tatap_muka/cetak/'.$_SESSION['id_pertemuan_search'])?>" target="_BLANK" class="btn btn-warning"><i class="fas fa-print"></i>  CETAK LAPORAN TATAP MUKA</a>
												</div>
												
											<?php } ?>
										</div>
									</div>

									<?php
										}
									 ?>	

									<hr>
									<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										
											<?php
										    
										        
										        if(isset($_SESSION['id_pertemuan_search'])){
										        	$id_pertemuan = $_SESSION['id_pertemuan_search'];
										            $query= $this->m_laporan_tatap_muka->cekPertemuan($id_pertemuan);
										            if($query->num_rows()==1){
										            	if(isset($_SESSION['bulan_search'])){
											            	if (isset($_SESSION['orderby'])) {
											            			
											        			$bulan_search = $_SESSION['bulan_search'];
												                $row = $query->row();
												                if($row){
												                    $tahun_ajaran_judul = $row->tahun_ajaran;
												                    $semester_judul = $row->semester;
												                    $semester_judul = $row->semester;
												    ?>

												    <!-- TABEL -->
												                   
												    <?php
												               
											                	}
											                }else{
														        echo '<h1 class="text-danger">Maaf, Pilih terlebih dahulu pengurutan datanya!</h1>';
														    }
										                }else{
													        echo '<h1 class="text-danger">Maaf, anda belum memilih bulan yang akan di hitung!</h1>';
													    }
										            }else{
										                 echo '<h1 class="text-danger">Maaf, tidak ditemukan data yang valid!</h1>';
										            }
										        }else{
										            echo '<h1 class="text-danger">Maaf, tidak ditemukan data yang valid!</h1>';
										        }
										    					                

										    ?>
									</div>
									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH TERLEBIH DAHULU PERTEMUAN YANG AKAN DI CARI...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>
			


							
										
									
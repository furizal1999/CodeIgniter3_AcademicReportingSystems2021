<!--  -->
		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">KUISIONER PELAPORAN UJIAN</h1>
								<h5 class="text-white op-7 mb-2">
									<?php 
										if(isset($_SESSION['status_login'])){
											if($_SESSION['status_login']=="Dosen" || $_SESSION['status_login']=="Pegawai"){
												if(isset($_SESSION['nama_prodi'])){
													echo $_SESSION['nama_prodi'].' ';
												}
											}
										} 
									?>
									Fakultas Teknik Universitas Islam Riau</h5>
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
										<div class="col-md-4">
											
										</div>
										<div class="col-md-8">
											<?php
												$status_login = $_SESSION['status_login'];
												$npk = $_SESSION['npk'];
												$cek = $this->m_kuisioner_pelaporan_ujian->check_kuisioner($status_login, $npk);
												if($cek > 0){
											 ?>
											 <div class="card">
											 	<div class="card-header bg-info">
													<h1 class="text-white">Kuisioner Pelaporan Ujian</h1>
													<p class="text-white">Kuisioner ini hanya dikhususkan untuk sistem palaporan ujian <b class="text-danger">(bukan tatap muka)</b></p>
												</div>
												<div class="card-body">
													<h2><i class="fas fa-check-circle text-success"></i> Terima kasih telah mengisi kuisioner ini...</h2>
												</div>
												<div class="card-footer">
													<i class="text-info"><i class="fas fa-question-circle"></i> kuisioner</i>
												</div>
											 </div>
											<?php }else{ ?>
											<form action="<?php echo base_url('dosen/kuisioner_pelaporan_ujian/simpan_kuisioner')?>" method="POST">
												<div class="card">
													<div class="card-header bg-info">
														<h1 class="text-white">Kuisioner Pelaporan Ujian</h1>
														<p class="text-white">Kuisioner ini disampaikan untuk mengevaluasi penggunaan Sistem Pelaporan Ujian yang telah dilakukan pada Ujian Akhir Semester (UAS) Genap TA 2020/2021 lalu untuk perbaikan SiPA pada pelaporan Ujian Tengah Semester (UTS) Ganjil TA. 2021/2022 yang akan dilaksanakan dalam waktu tidak lama lagi.<b class="text-danger">(bukan tatap muka)</b></p>
													</div>
													<div class="card-body">
														<ol>
															<li>
																<h3>Sistem Pelaporan Ujian ini mudah diakses dan diimplementasikan sesuai kegunaannya.</h3>
																<input type="radio" name="statement1" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement1" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement1" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement1" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Prosedur penggunaan yang diterapkan pada Sistem Pelaporan Ujian ini tidak menimbulkan kerancuan dan mudah difahami.</h3>
																<input type="radio" name="statement2" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement2" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement2" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement2" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Sistem Pelaporan Ujian ini dapat berjalan dan bekerja sesuai dengan fungsi kebutuhan dalam proses pelaporan pengawasan ujian.</h3>
																<input type="radio" name="statement3" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement3" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement3" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement3" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Fitur yang ada pada Sistem Pelaporan Ujian ini sudah cukup baik dan lengkap sesuai kebutuhan pelaporan di Fakultas Teknik UIR.</h3>
																<input type="radio" name="statement4" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement4" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement4" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement4" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Sistem Pelaporan Ujian ini dapat meningkatkan kedisiplinan pengawas ujian dalam melaporkan hasil pengawasan ujian yang telah dilakukan di Fakultas Teknik UIR.</h3>
																<input type="radio" name="statement5" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement5" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement5" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement5" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Sistem Pelaporan Ujian ini membantu menyelesaikan pelaporan ujian dengan cepat dan tepat waktu.</h3>
																<input type="radio" name="statement6" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement6" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement6" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement6" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Sistem pelaporan ujian ini cocok diterapkan pada masa pembelajaran daring (<i>Online</i>).</h3>
																<input type="radio" name="statement7" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement7" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement7" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement7" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Sistem Pelaporan Ujian ini dapat memberikan kemudahan dalam pelaporan ujian jika dibandingkan dengan sistem manual sebelumnya.</h3>
																<input type="radio" name="statement8" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement8" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement8" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement8" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3><i>Interface</i> atau antarmuka yang ada pada sistem pelaporan ujian ini cukup baik dan menarik.</h3>
																<input type="radio" name="statement9" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement9" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement9" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement9" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
															<li>
																<h3>Pelayanan dalam penerapan Sistem Pelaporan Ujian ini di Fakultas Teknik UIR cukup baik dan cepat tanggap.</h3>
																<input type="radio" name="statement10" value="SS" required>
																<label>Sangat Setuju</label><br>
																<input type="radio" name="statement10" value="S" required>
																<label>Setuju</label><br>
																<input type="radio" name="statement10" value="TS" required>
																<label>Tidak Setuju</label><br>
																<input type="radio" name="statement10" value="STS" required>
																<label>Sangat Tidak Setuju</label>
																<hr>
															</li>
														</ol>
														<input type="submit" name="simpan_kuisioner" class="btn btn-primary right">

													</div>
													<div class="card-footer">
														<i class="text-info"><i class="fas fa-question-circle"></i> kuisioner</i>
													</div>
												</div>
											</form>
											<?php } ?>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

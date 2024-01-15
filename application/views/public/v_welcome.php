
		<div class="main-panel">
          	<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">WELCOME</h1>
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
							
                            </div>
						</div>
					</div>
				</div>

                <!-- selamat datang -->
                <div class="page-inner mt--5">
					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body text-center">
									<h1>Assalamu'alaikum <?php echo $_SESSION['nama']?>...</h1>
									<h3>Selamat Datang di Sistem Pelaporan Akademik Fakultas Teknik (SiPA-FT) Universitas Islam Riau.</h3>
									<h2>VISI : <i class="text-primary">"Menjadi Fakultas Teknik Berkelas Dunia Yang Berkarakter Islami"</i></h2>
								</div>
							</div>
						</div>
					</div>
				</div> 
				
				<div class="page-inner mt--5">
					<div class="row mt--2">
					<?php if($_SESSION['status_login']== "Developer"){?>
						<?php if($_SESSION['hak_akses']== "Super"){?>
						<!-- <div class="col-md-6">
							<div class="card full-height text-white bg-danger">
								<div class="card-body text-center">
									<h4>ADMIN</h4>
									<h1><i class="fa fa-user"></i></h1>
									<h1><?php echo $jumlah_admin_fakultas;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('fakultas/atur_admin')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div> -->
						<?php }?>
						<!-- <div class="col-md-6">
							<div class="card full-height text-white bg-success">
								<div class="card-body text-center">
									<h4>PROGRAM STUDI</h4>
									<h1><i class="fa fa-users"></i></h1>
									<h1><?php echo $jumlah_prodi;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('fakultas/program_studi')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div> -->
						
					<?php }elseif($_SESSION['status_login']== "UPM"){?>
						
						<div class="col-md-6">
							<div class="card full-height text-white bg-danger">
								<div class="card-body text-center">
									<h4>ADMIN</h4>
									<h1><i class="fa fa-user"></i></h1>
									<h1><?php echo $jumlah_admin_upm;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<?php if($_SESSION['hak_akses']== "Super"){?>
									<a href="<?php echo base_url('upm/atur_admin')?>">Lihat selengkapnya...</a>
								<?php }else{ echo '<div class="text-danger">Penambahan admin baru hanya bisa dilakukan oleh super admin.</div>';}?>
								</div>
							</div>
						</div> 
						
						
					<?php } elseif($_SESSION['status_login']== "Fakultas"){?>
						<?php if($_SESSION['hak_akses']== "Super"){?>
						<div class="col-md-6">
							<div class="card full-height text-white bg-danger">
								<div class="card-body text-center">
									<h4>ADMIN</h4>
									<h1><i class="fa fa-user"></i></h1>
									<h1><?php echo $jumlah_admin_fakultas;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('fakultas/atur_admin')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<?php }?>
						<div class="col-md-6">
							<div class="card full-height text-white bg-success">
								<div class="card-body text-center">
									<h4>PROGRAM STUDI</h4>
									<h1><i class="fa fa-users"></i></h1>
									<h1><?php echo $jumlah_prodi;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('fakultas/program_studi')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						
					<?php }elseif($_SESSION['status_login']== "Tata Usaha"){?>
						
						<div class="col-md-6">
							<div class="card full-height text-white bg-danger">
								<div class="card-body text-center">
									<h4>ADMIN</h4>
									<h1><i class="fa fa-user"></i></h1>
									<h1><?php echo $jumlah_admin_tu;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<?php if($_SESSION['hak_akses']== "Super"){?>
									<a href="<?php echo base_url('tu/atur_admin')?>">Lihat selengkapnya...</a>
								<?php }else{ echo '<div class="text-danger">Penambahan admin baru hanya bisa dilakukan oleh super admin.</div>';}?>
								</div>
							</div>
						</div> 
						
					<?php }elseif($_SESSION['status_login']== "Prodi"){?>
						<?php if($_SESSION['hak_akses']== "Super"){?>
						<div class="col-md-4">
							<div class="card full-height text-white bg-danger">
								<div class="card-body text-center">
									<h4>ADMIN</h4>
									<h1><i class="fa fa-user"></i></h1>
									<h1><?php echo $jumlah_admin;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('prodi/atur_admin')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<?php }?>
						<div class="col-md-4">
							<div class="card full-height text-white bg-success">
								<div class="card-body text-center">
									<h4>KARYAWAN & DOSEN TERVERIFIKASI</h4>
									<h1><i class="fa fa-users"></i></h1>
									<h1><?php echo $jumlah_dosen_terverifikasi;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('prodi/dosen_terverifikasi')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card full-height text-white bg-warning">
								<div class="card-body text-center">
									<h4>KARYAWAN & DOSEN BELUM TERVERIFIKASI</h4>
									<h1><i class="fa fa-users"></i></h1>
									<h1><?php echo $jumlah_dosen_belum_terverifikasi;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('prodi/dosen_belum_terverifikasi')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card full-height text-white bg-secondary">
								<div class="card-body text-center">
									<h4>RUANGAN</h4>
									<h1><i class="fa fa-home"></i></h1>
									<h1><?php echo $jumlah_ruang;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('prodi/ruang')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card full-height text-white bg-info">
								<div class="card-body text-center">
									<h4>MATAKULIAH</h4>
									<h1><i class="fa fa-book"></i></h1>
									<h1><?php echo $jumlah_matkul;?></h1>
								</div>
								<div class="card-footer text-center bg-light">
									<a href="<?php echo base_url('prodi/matkul')?>">Lihat selengkapnya...</a>
								</div>
							</div>
						</div>
						<?php }else{?>
							<div class="row">
								<div class="col-md-12">
									<div class="card">
										<div class="card-header bg-warning rounded">
											<h2 class="text-white"><blink class="text-white">PENGUMUMAN</blink> <marquee class="text-danger bg-white">Pelaporan ujian hanya diizinkan untuk dilaporkan pada hari yang sama sesuai jadwal ujian. Jika lewat, dosen harus mengajukan alasan keterlambatan..... Matakuliah yang diampu oleh 2 atau 3 orang dosen, mohon melaporkan tatap muka melalui akun SiPA masing-masing...</marquee></h2>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-md-2">
													
												</div>
												<div class="col-md-10">

													<!-- <div class="p-3 border rounded">
														<h2 class="text-primary">1. Batas Pengajuan Ganti Jadwal</h2>
														<ol type="a">
															<li><h4>Jumlah pengajuan untuk bulan ini <b class="text-danger">(Oktober 2021)</b> tidak di batasi karena dalam masa tahap sosialisasi. Silahkan ajukan pengajuan ganti jadwal sejumlah pertemuan yang tertinggal. Karena bulan depan <b class="text-danger">(November 2021)</b> akan di terapkan jumlah pengajuan paling tinggi 2 kali.</h4></li>
															<li>
																<h4><b class="text-danger">Sekarang di SiPA-FT sudah bisa mengajukan keterlambatan  untuk hari yang sama.</b> Tapi ketentuan nya harus menghubungi petugas TU melalui telp atau wa untuk menyetujui.</h4>
																<ul>
																	<li>Teknik Sipil, Mesin dan Informatika <b class="text-warning">(Ahmad Pandi, S.Kom => 0822-8480-7293)</b></li>
																	<li>Teknik Perminyakan, PWK dan Geologi <b class="text-warning">(Zulfadli => 0853-6501-8008)</b></li>
																</ul>
															</li>
														</ol>														
													</div>
													<div class="p-3 border rounded">
														<h2 class="text-primary">2. Cara Perhitungan Perekapan Tatap Muka</h2>
														<ol type="a">
															<li><h4>Perekapan tatap muka dosen dilakukan berdasarkan tanggal melakukan input. <br>
															<b  class="text-warning">Contoh :</b> Jika jadwal sebenarnya bulan September dan setelah diajukan jadwal ganti pada bulan Oktober, maka perekapannya akan masuk ke dalam bulan Oktober <b class="text-danger">(bukan September lagi)</b> </h4></li>
															<li><h4>Perhitungannya <b class="text-danger">0.5 per SKS</b>. Berikut penjelasannya : </h4></li>
														</ol>	
														<div class="row">
															<div class="col-md-6">
																<img src="<?= base_url('templates/img/beranda/perhitungan_pelaporan_part1.png') ?>" width="100%" class="border">
															</div>
															<div class="col-md-6">
																<img src="<?= base_url('templates/img/beranda/perhitungan_pelaporan_part2.png') ?>" width="100%" class="border">
															</div>
														</div>													
													</div> -->
													
													<div class="p-3 border rounded bg-danger text-white">
														<h2 class="text-primary">1. PENGAJUAN TERLAMBAT PELAPORAN UJIAN</h2>
														<h4>Pelaporan ujian hanya diizinkan untuk dilaporkan pada hari yang sama sesuai jadwal ujian. Jika lewat, dosen harus mengajukan alasan keterlambatan seperti dibawah ini:</h4>
														<img src="<?= base_url('templates/img/beranda/gambar_terlambat.png') ?>" width="100%" class="border">
													</div>

													<div class="p-3 border rounded">
														<h2 class="text-primary">2. UPLOAD BERKAS SOAL UJIAN DAN NILAI MAHASISWA</h2>
														<h4>Dosen pengampu diharapkan untuk mengunggah file berkas soal ujian dan nilai ujian mahasiswa dalam format PDF sebagai kebutuhan mutu seperti dibawah ini:</h4>
														<img src="<?= base_url('templates/img/beranda/gambar_nilai_ujian.png') ?>" width="100%" class="border">
													</div>

													<div class="p-3 border rounded">
														<h2 class="text-primary">3. CETAK PRESENSI / LAPORAN PERTEMUAN</h2>
														<h4>Untuk melakukan cetak presensi atau laporan pertemuan dapat dilakukan seperti pada gambar dibawah ini:</h4>
														<img src="<?= base_url('templates/img/beranda/gambar_cetak_laporan_pertemuan.png') ?>" width="100%" class="border">
													</div>

													<div class="p-3 border rounded">
														<h2 class="text-primary">4. KUISIONER</h2>
													<h4>Untuk melakukan pengisian kuisioner sistem pelaporan ujian dapat dipilih pada menu kuisioner seperti pada gambar dibawah ini : <i class="text-danger">Bukan pelaporan tatap muka</i></h4>
													<img src="<?= base_url('templates/img/beranda/gambar_kuisioner.png') ?>" width="100%" class="border">
													</div>
													
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="col-md-4">
								<div class="card full-height text-white bg-primary">
									<div class="card-body text-center">
										<h4>JADWAL MENGAWAS AKAN DATANG</h4>
										<h1><i class="fa fa-calendar-alt"></i></h1>
										<h1><?php echo $jumlah_jadwal_mengawas;?></h1>
									</div>
									<div class="card-footer text-center bg-light">
										<a href="<?php echo base_url('dosen/jadwal_mengawas')?>">Lihat selengkapnya...</a>
									</div>
								</div>
								
							</div>
							<div class="col-md-4">
								<div class="card full-height text-white bg-dark">
									<div class="card-body text-center">
										<h4>TOTAL HISTORI MENGAWAS</h4>
										<h1><i class="fa fa-history"></i></h1>
										<h1><?php echo $jumlah_histori_mengawas;?></h1>
									</div>
									<div class="card-footer text-center bg-light">
										<a href="<?php echo base_url('dosen/jadwal_mengawas/histori')?>">Lihat selengkapnya...</a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card full-height text-white bg-success">
									<div class="card-body text-center">
										<h4>MENGAWAS TERVERIFIKASI <i class="text-light">(HISTORI)</i></h4>
										<h1><i class="fa fa-check"></i></h1>
										<h1><?php echo $jumlah_terverifikasi;?></h1>
									</div>
									<div class="card-footer text-center bg-light">
										<a href="<?php echo base_url('dosen/jadwal_mengawas/histori')?>">Lihat selengkapnya...</a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card full-height text-white bg-danger">
									<div class="card-body text-center">
										<h4>VERIFIKASI DITOLAK <i class="text-light">(HISTORI)</i></h4>
										<h1><i class="fa fa-shield-alt"></i></h1>
										<h1><?php echo $jumlah_ditolak;?></h1>
									</div>
									<div class="card-footer text-center bg-light">
										<a href="<?php echo base_url('dosen/jadwal_mengawas/histori')?>">Lihat selengkapnya...</a>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card full-height text-white bg-warning">
									<div class="card-body text-center">
										<h4>TIDAK DI SUBMIT <i class="text-light">(HISTORI)</i></h4>
										<h1><i class="fa fa-exclamation"></i></h1>
										<h1><?php echo $jumlah_belum_disubmit;?></h1>
									</div>
									<div class="card-footer text-center bg-light">
										<a href="<?php echo base_url('dosen/jadwal_mengawas/histori')?>">Lihat selengkapnya...</a>
									</div>
								</div>
							</div> -->
						<?php }?>
					</div>
				</div>   
				
				     

			
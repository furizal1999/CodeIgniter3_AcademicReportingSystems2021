<body>
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<a href="<?php echo base_url('welcome')?>" class="logo">
					<img width="40px" src="<?php echo base_url('templates')?>/img/logo/logo.png" alt="navbar brand" class="navbar-brand">
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

				<div class="container-fluid">
					<h2 class="text-light text-center"><b><i>SISTEM PELAPORAN AKADEMIK FAKULTAS TEKNIK (SiPA-FT)</i></b></h2>

					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
								<?php if($_SESSION['foto']==""){?>
									<img src="<?php echo base_url('templates')?>/img/dosen/inisial/<?php echo $_SESSION['jenis_kelamin'];?>.jpg" alt="..." class="avatar-img rounded-circle border-light">
								<?php }else{?>
									<img src="<?php echo base_url('templates')?>/img/dosen/<?php echo $_SESSION['foto'];?>" alt="..." class="avatar-img rounded-circle border-light">
								<?php }?>
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
										<?php if($_SESSION['foto']==""){?>
											<div class="avatar-lg"><img src="<?php echo base_url('templates')?>/img/dosen/inisial/<?php echo $_SESSION['jenis_kelamin'];?>.jpg" alt="image profile" class="avatar-img rounded"></div>
										<?php }else{?>
											<div class="avatar-lg"><img src="<?php echo base_url('templates')?>/img/dosen/<?php echo $_SESSION['foto'];?>" alt="image profile" class="avatar-img rounded"></div>
										<?php }?>
											<div class="u-text">
												<h4><?php echo $_SESSION['nama']?></h4>
												<p class="text-muted"><?php echo $_SESSION['status_login']?></p><a href="<?php echo base_url('profil')?>" class="btn btn-xs btn-secondary btn-sm">Lihat Profil</a>
											</div>
										</div>
									</li>

								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
					<?php if($_SESSION['foto']==""){?>
						<img src="<?php echo base_url('templates')?>/img/dosen/inisial/<?php echo $_SESSION['jenis_kelamin'];?>.jpg" alt="..." class="avatar-img rounded-circle">
					<?php }else{?>
						<img src="<?php echo base_url('templates')?>/img/dosen/<?php echo $_SESSION['foto'];?>" alt="..." class="avatar-img rounded-circle">
					<?php }?>
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
								<?php echo $_SESSION['nama'];?>
									<span class="user-level">
									<?php
									if(isset($_SESSION['status_jabatan'])){
										if($_SESSION['status_jabatan']=='Pegawai'){
											echo $_SESSION['status_jabatan'];
										}else{
											echo $_SESSION['status_login'];
										}
									}else{
										echo $_SESSION['status_login'];
									}
									?>
									</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="<?php echo base_url('profil')?>">
											<span class="link-collapse">Profil Saya</span>
										</a>
									</li>
									<li>
									<a class="btn btn-danger btn mt-3 text-light" data-toggle="modal" data-target="#modal_keluar<?php echo $_SESSION['status_login'];?>"><i class="text-light fas fa-power-off"></i> Logout</a>

									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
					<?php if($_SESSION['status_login']=="Developer"){?>
							<li class="nav-item active">
								<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-home"></i>
									<p>Dashboard</p>
								</a>
							</li>

							
							<li class="nav-item">
								<a data-toggle="collapse" href="#grafik_developer_dropdown">
									<i class="fas fa-chart-bar"></i>
									<p>Grafik</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="grafik_developer_dropdown">
									<ul class="nav nav-collapse">
										<li>
											<a href="<?php echo base_url('developer/grafik_kuesioner_tatap_muka')?>">
												<span class="sub-item">Kuesioner Tatap Muka</span>
											</a>
										</li>

									</ul>
								</div>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('dosen/kuisioner_pelaporan_ujian')?>" class="collapsed bg-warning" aria-expanded="false">
									<i class="fas fa-question-circle text-white"></i>
									<p class="text-white">Kuesioner Ujian</p>
								</a>
							</li>
							<li class="nav-item">
								<blink class="text-white">
									<a href="<?php echo base_url('dosen/kuisioner_pelaporan_tatap_muka')?>" class="collapsed bg-success" aria-expanded="false">
										<i class="fas fa-question-circle text-white"></i>
										<p class="text-white">Kuesioner Tatap Muka</p>
									</a>
								</blink>
								
							</li>

						<?php }elseif($_SESSION['status_login']=="UPM"){?>
						<li class="nav-item active">
							<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
					<?php
						if($_SESSION['hak_akses']== "Super"){
					?>
						<li class="nav-item">
							<a  href="<?php echo base_url('upm/atur_admin')?>">
								<i class="fas fa-user"></i>
								<p>Atur Admin</p>
							</a>
						</li>
					<?php } ?>
						<li class="nav-item">
							<a data-toggle="collapse" href="#laporanPertemuanAksesUPM">
								<i class="fas fa-th-list"></i>
								<p>Laporan Tatap Muka</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporanPertemuanAksesUPM">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('upm/preview_laporan_pertemuan')?>">
											<span class="sub-item">Preview Laporan Pertemuan <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>
									<!-- <li>
										<a href="<?php echo base_url('upm/laporan_tatap_muka')?>">
											<span class="sub-item">Rekap Tatap Muka <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li> -->
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#laporanujianaksesupm">
								<i class="fas fa-th-list"></i>
								<p>Laporan Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporanujianaksesupm">
								<ul class="nav nav-collapse">
									<!-- <li>
										<a href="<?php echo base_url('upm/soal_ujian')?>">
											<span class="sub-item">Soal Ujian</span>
										</a>
									</li> -->
									<li>
										<a href="<?php echo base_url('upm/jadwal_ujian')?>">
											<span class="sub-item">Jadwal Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('upm/berita_acara')?>">
											<span class="sub-item">Berita Acara</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('upm/jenis_pelaksanaan_ujian')?>">
											<span class="sub-item">Jenis Pelaksanaan Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('upm/rekapitulasi')?>">
											<span class="sub-item">Rekapitulasi Mengawas</span>
										</a>
									</li>
									<!-- <li>
										<a href="<?php echo base_url('upm/nilai_hasil_ujian')?>">
											<span class="sub-item">Nilai Ujian Mahasiswa <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>	 -->
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#grafikaksesUPM">
								<i class="fas fa-th-list"></i>
								<p>Laporan Grafik</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="grafikaksesUPM">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('upm/grafik_jumlah_pertemuan_tatap_muka')?>">
											<span class="sub-item">Grafik Jumlah Pertemuan Pengampu <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('upm/grafik_kontrak_rps_nilai')?>">
											<span class="sub-item">Grafik Kontrak, RPS dan Nilai <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('upm/grafik_penggunaan_media_tatap_muka')?>">
											<span class="sub-item">Grafik Media Tatap Muka <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<hr>
						<?php }elseif($_SESSION['status_login']=="Fakultas"){?>
						<li class="nav-item active">
							<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<li class="nav-item">
							<a  href="<?php echo base_url('fakultas/atur_admin')?>">
								<i class="fas fa-user"></i>
								<p>Atur Admin</p>
							</a>
						</li>
						<li class="nav-item">
							<a  href="<?php echo base_url('fakultas/program_studi')?>">
								<i class="fas fa-book"></i>
								<p>Program Studi</p>
							</a>
						</li>
						<?php
							// if($_SESSION['jabatan']=='Wakil Dekan I' || $_SESSION['jabatan']=='Wakil Dekan III'){
						?>
						<li class="nav-item">
							<a data-toggle="collapse" href="#monitor">
								<i class="fas fa-eye"></i>
								<p>Monitoring Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="monitor">
								<ul class="nav nav-collapse">
									<!-- <li>
										<a href="<?php echo base_url('fakultas/soal_ujian')?>">
											<span class="sub-item">Soal Ujian</span>
										</a>
									</li> -->
									<li>
										<a href="<?php echo base_url('fakultas/monitoring_pengawas')?>">
											<span class="sub-item">Monitoring Pengawas</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('fakultas/persetujuan_terlambat')?>">
											<span class="sub-item">Persetujuan Terlambat</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('fakultas/grafik_statistik')?>">
											<span class="sub-item">Grafik Statistik</span>
										</a>
									</li>
									<!-- <li>
										<a href="<?php echo base_url('fakultas/nilai_hasil_ujian')?>">
											<span class="sub-item">Nilai Ujian Mahasiswa <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li> -->

								</ul>
							</div>
						</li>

						<?php
							if($_SESSION['jabatan']=='Dekan'){
						?>
						<li class="nav-item">
							<a data-toggle="collapse" href="#ttd_pimpinan">
								<i class="fas fa-pen"></i>
								<p>Tanda Tangan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="ttd_pimpinan">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('fakultas/permintaan_verifikasi')?>">
											<span class="sub-item">Berita Acara Pengawas Ujian</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<?php
							}
						?>
						<li class="nav-item">
							<a data-toggle="collapse" href="#laporanpertemuan">
								<i class="fas fa-th-list"></i>
								<p>Laporan Pertemuan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporanpertemuan">
								<ul class="nav nav-collapse">
									<?php
										// if($_SESSION['jabatan']=='Wakil Dekan I'){
									?>
									<li>
										<a href="<?php echo base_url('fakultas/preview_laporan_pertemuan')?>">
											<span class="sub-item">Laporan Presensi Pertemuan</span>
										</a>
									</li>
									<?php
										// }
									?>
									<li>
										<a href="<?php echo base_url('fakultas/laporan_tatap_muka')?>">
											<span class="sub-item">Laporan Tatap Muka</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#laporan">
								<i class="fas fa-th-list"></i>
								<p>Laporan Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporan">
								<ul class="nav nav-collapse">

									<li>
										<a href="<?php echo base_url('fakultas/rekapitulasi')?>">
											<span class="sub-item">Rekapitulasi Mengawas</span>
										</a>
									</li>
								</ul>
							</div>
						</li>



						<hr>
						<?php }elseif($_SESSION['status_login']=="Prodi"){?>
						<li class="nav-item active">
							<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<?php if($_SESSION['hak_akses']== "Super"){?>
						<li class="nav-item">
							<a href="<?php echo base_url('prodi/atur_admin')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-user"></i>
								<p>Atur Admin</p>
							</a>
						</li>
						<?php } ?>
						<!-- <li class="nav-item">
							<a data-toggle="collapse" href="#dataMaster">
								<i class="fa fa-database"></i>
								<p>Data Master</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="dataMaster">
								<ul class="nav nav-collapse">
									<li class="nav-item">
										<a  href="<?php echo base_url('prodi/dosen')?>">
											<i class="fas fa-user"></i>
											<p>Dosen & Pegawai</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('prodi/ruang')?>">
											<i class="fas fa-home"></i>
											<p>Ruang</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('prodi/matkul')?>">
											<i class="fas fa-book"></i>
											<p>Matakuliah</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('prodi/kelas')?>">
											<i class="fas fa-users"></i>
											<p>Kelas</p>
										</a>
									</li>
								</ul>
							</div>
						</li> -->

						<li class="nav-item">
							<a data-toggle="collapse" href="#monitoringpengampu">
								<i class="fas fa-th-list"></i>
								<p>Monitoring Pengampu</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="monitoringpengampu">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('prodi/kontrak_kuliah')?>">
											<span class="sub-item">Berkas Kontrak Kuliah</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/rps')?>">
											<span class="sub-item">Berkas RPS</span>
										</a>
									</li>

									<li>
										<a href="<?php echo base_url('prodi/permintaan_verifikasi_pertemuan')?>">
											<span class="sub-item">Permintaaan Verifikasi Pertemuan</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/permintaan_jadwal_ganti')?>">
											<span class="sub-item">Permintaaan Jadwal Ganti</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/preview_laporan_pertemuan')?>">
											<span class="sub-item">Preview Laporan Pertemuan</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#monitoring">
								<i class="fas fa-th-list"></i>
								<p>Monitoring Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="monitoring">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('prodi/soal_ujian')?>">
											<span class="sub-item">Soal Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/sedang_ujian')?>">
											<span class="sub-item">Sedang Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/persetujuan_terlambat')?>">
											<span class="sub-item">Persetujuan Terlambat Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/permintaan_verifikasi')?>">
											<span class="sub-item">Verifikasi Mengawas Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/nilai_hasil_ujian')?>">
											<span class="sub-item">Nilai Ujian Mahasiswa <b class="blink text-primary rounded">Baru</b></span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<!-- <li class="nav-item">
							<a data-toggle="collapse" href="#laporantatapmuka">
								<i class="fas fa-book"></i>
								<p>laporan Tatap Muka</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporantatapmuka">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('prodi/laporan_tatap_muka')?>">
											<span class="sub-item">Rekapitulasi Tatap Muka</span>
										</a>
									</li>


								</ul>
							</div>
						</li> -->

						<li class="nav-item">
							<a data-toggle="collapse" href="#laporan">
								<i class="fas fa-book"></i>
								<p>Laporan Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporan">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('prodi/Cetak_jadwal')?>">
											<span class="sub-item">Jadwal Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/presensi_pengawas')?>">
											<span class="sub-item">Presensi Pengawas</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prodi/berita_acara')?>">
											<span class="sub-item">Berita Acara</span>
										</a>
									</li>

								</ul>
							</div>
						</li>

						<?php }elseif($_SESSION['status_login']=="Tata Usaha"){?>
						<li class="nav-item active">
							<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
							</a>
						</li>
						<?php if($_SESSION['hak_akses']== "Super"){?>
						<li class="nav-item">
							<a href="<?php echo base_url('tu/atur_admin')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-user"></i>
								<p>Atur Admin</p>
							</a>
						</li>
						<?php } ?>

						<li class="nav-item">
							<a data-toggle="collapse" href="#dataMaster">
								<i class="fa fa-database"></i>
								<p>Data Master</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="dataMaster">
								<ul class="nav nav-collapse">
									<li class="nav-item">
										<a  href="<?php echo base_url('tu/dosen')?>">
											<i class="fas fa-user"></i>
											<p>Dosen & Pegawai</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('tu/ruang')?>">
											<i class="fas fa-home"></i>
											<p>Ruang</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('tu/matkul')?>">
											<i class="fas fa-book"></i>
											<p>Matakuliah</p>
										</a>
									</li>
									<li class="nav-item">
										<a  href="<?php echo base_url('tu/kelas')?>">
											<i class="fas fa-users"></i>
											<p>Kelas</p>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#praumum">
								<i class="fas fa-keyboard"></i>
								<p>Input Umum</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="praumum">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('tu/tahun_ajaran')?>">
											<span class="sub-item">Tahun Ajaran</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/semester')?>">
											<span class="sub-item">Semester</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#prapertemuan">
								<i class="fas fa-keyboard"></i>
								<p>Input Pra Pertemuan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="prapertemuan">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('tu/pertemuan')?>">
											<span class="sub-item">Pertemuan</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/sk_pertemuan')?>">
											<span class="sub-item">SK Pengampu</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/jadwal_pengampu_matkul')?>">
											<span class="sub-item">Jadwal Pengampu MK</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/jenis_tugas_pengampu')?>">
											<span class="sub-item">Tandai Jenis Tugas Pengampu</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/jadwal_libur')?>">
											<span class="sub-item">Jadwal Libur</span>
										</a>
									</li>

								</ul>
							</div>
						</li>

						<li class="nav-item">
							<a data-toggle="collapse" href="#masukan">
								<i class="fas fa-keyboard"></i>
								<p>Input Pra Ujian</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="masukan">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('tu/surat_keputusan')?>">
											<span class="sub-item">Surat Keputusan Dekan</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/ujian')?>">
											<span class="sub-item">Ujian</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/tata_tertib')?>">
											<span class="sub-item">Tata Tertib</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/sk_pengawas')?>">
											<span class="sub-item">SK Pengawas</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/jadwal_ujian')?>">
											<span class="sub-item">Jadwalkan Ujian</span>
										</a>
									</li>
								</ul>
							</div>
						</li>


						<li class="nav-item">
							<a data-toggle="collapse" href="#permintaanDosen">
								<i class="fas fa-book"></i>
								<p>Permintaan Dosen</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="permintaanDosen">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('tu/permintaan_jadwal_ganti')?>">
											<span class="sub-item">Permintaan Jadwal Ganti</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/permintaan_verifikasi_pertemuan')?>">
											<span class="sub-item">Permintaan Verifikasi Pertemuan</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#laporan">
								<i class="fas fa-book"></i>
								<p>Laporan</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="laporan">
								<ul class="nav nav-collapse">
									<li>
										<a href="<?php echo base_url('tu/berita_acara')?>">
											<span class="sub-item">Berita Acara</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/rekapitulasi')?>">
											<span class="sub-item">Rekapitulasi Mengawas</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/laporan_tatap_muka')?>">
											<span class="sub-item">Laporan Tatap Muka</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tu/rekap_berkas_pertemuan')?>">
											<span class="sub-item">Rekap Berkas Pertemuan</span>
										</a>
									</li>


								</ul>
							</div>
						</li>

						<?php }elseif($_SESSION['status_login']=="Dosen"){?>
							<li class="nav-item active">
								<a href="<?php echo base_url('welcome')?>" class="collapsed" aria-expanded="false">
									<i class="fas fa-home"></i>
									<p>Dashboard</p>
								</a>
							</li>

							<?php if($_SESSION['status_jabatan']=='Dosen'){ ?>
							<li class="nav-item">
								<a data-toggle="collapse" href="#pelaporan">
									<i class="fas fa-calendar-day"></i>
									<p>Mengampu MK</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="pelaporan">
									<ul class="nav nav-collapse">
										<li>
											<a href="<?php echo base_url('dosen/kontrak_kuliah')?>">
												<span class="sub-item">Kontrak Kuliah</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/rps')?>">
												<span class="sub-item">RPS</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/presensi_pertemuan')?>">
												<span class="sub-item">Presensi Pertemuan</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/soal_ujian')?>">
												<span class="sub-item">Soal Ujian <b class="blink text-primary rounded">Baru</b></span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/nilai_hasil_ujian')?>">
												<span class="sub-item">Nilai Hasil Ujian <b class="blink text-primary rounded">Baru</b></span>
											</a>
										</li>
									</ul>
								</div>
							</li>
							<?php } ?>
							<li class="nav-item">
								<a data-toggle="collapse" href="#ujiandropdown">
									<i class="fas fa-calendar-day"></i>
									<p>Mengawas Ujian</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="ujiandropdown">
									<ul class="nav nav-collapse">
										<li>
											<a href="<?php echo base_url('dosen/info_dokumen')?>">
												<span class="sub-item">SK Dan Tata Tertib</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/jadwal_mengawas')?>">

												<span class="sub-item">Jadwal Mengawas</span>
											</a>
										</li>
										<li>
											<a href="<?php echo base_url('dosen/jadwal_mengawas/histori')?>">
												<span class="sub-item">Histori Mengawas</span>
											</a>
										</li>


									</ul>
								</div>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('dosen/kuisioner_pelaporan_ujian')?>" class="collapsed bg-warning" aria-expanded="false">
									<i class="fas fa-question-circle text-white"></i>
									<p class="text-white">Kuesioner Ujian</p>
								</a>
							</li>
							<li class="nav-item">
								<blink class="text-white">
									<a href="<?php echo base_url('dosen/kuisioner_pelaporan_tatap_muka')?>" class="collapsed bg-success" aria-expanded="false">
										<i class="fas fa-question-circle text-white"></i>
										<p class="text-white">Kuesioner Tatap Muka</p>
									</a>
								</blink>
								
							</li>

						<?php } ?>

						<li class="nav-item active">
							<a href="<?php echo base_url('forum_diskusi')?>" class="collapsed" aria-expanded="false">
								<i class="fas fa-comment"></i>
								<p>Forum Diskusi</p>
							</a>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#sistemlain">
								<i class="fas fa-th-list"></i>
								<p>Sub Sistem</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sistemlain">
								<ul class="nav nav-collapse">
									<li class="bg-info">
										<a href="<?php echo base_url('seminar')?>">
											<span class="sub-item">KP-SKRIPSI</span>
										</a>
									</li>
									<li>
										<a href="#">

											<span class="sub-item">Sistem Pelaporan Praktikum (Coming Soon)</span>
										</a>
									</li>
									<li>
										<a href="#">
											<span class="sub-item">Sistem Kerjasama (Coming Soon)</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('prestasi')?>">
											<span class="sub-item">Sistem Prestasi (Coming Soon)</span>
										</a>
									</li>
									<li>
										<a href="#">
											<span class="sub-item">Sistem Beasiswa (Coming Soon)</span>
										</a>
									</li>

								</ul>
							</div>
						</li>
						<li class="nav-item">
						<a class="btn btn-danger btn mt-3 text-light" data-toggle="modal" data-target="#modal_keluar<?php echo $_SESSION['status_login'];?>"><i class="text-light fas fa-power-off"></i> Logout</a>
						</li>


					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->


		<?php if(isset($_SESSION['login_smpu'])){ ?>
		<div class="container">
		<!-- Content Header (Page header) -->
		<!-- <div class="content-header"> -->
			<!-- ============ MODAL Keluar =============== -->
				<div class="modal fade" id="modal_keluar<?php echo $_SESSION['status_login'];?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="myModalLabel">Konfirmasi Logout</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					</div>
					<form class="form-horizontal" method="post" action="<?php echo base_url().'logout'?>">
						<div class="modal-body">
							<p>Anda yakin logout?</b></p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
							<button class="btn btn-danger">Ya</button>
						</div>
					</form>
					</div>
					</div>
				</div>
				<!-- end modal -->
		</div>

<?php } ?>

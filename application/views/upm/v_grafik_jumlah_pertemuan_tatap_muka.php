		
		 <style>
		    canvas {
		        -moz-user-select: none;
		        -webkit-user-select: none;
		        -ms-user-select: none;
		    }
	    </style>

		<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['kode_prodi'])){ ?>

		<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
	    <script>

        var horizontalBarChartData = {
        	
		       
            labels: [
            <?php
            	$tinggiChart = 0;
	          	$data_dosen = $this->m_grafik_jumlah_pertemuan_tatap_muka->data_dosen($_SESSION['id_pertemuan_search'], $_SESSION['kode_prodi']);
            	 foreach($data_dosen->result_array() as $i):
					$dosen_pengampu_grafik=$i['dosen_pengampu'];
					$nama_matkul_grafik=$i['nama_mk'];
					$nama_kelas_grafik=$i['nama_kelas'];
					$id_jadwal_kelas_pertemuan_grafik=$i['id_jadwal_kelas_pertemuan'];

					//menampilkan nama semua pengampu
					$array_dosen = explode(', ', $dosen_pengampu_grafik);
					$index = 0;
					$array_dosen_hasil = array();

					foreach ($array_dosen as $npk) {
						$nama_dosen = $this->m_grafik_jumlah_pertemuan_tatap_muka->getNamaDosen($npk);
						$array_dosen_hasil[$index++] = $nama_dosen;
					}

					$string_dosen_hasil = implode('/ ', $array_dosen_hasil);
					$jumlahTatapMukaPerkelas = $this->m_grafik_jumlah_pertemuan_tatap_muka->jumlahTatapMukaPerkelas($id_jadwal_kelas_pertemuan_grafik);

		     ?>
		     	'<?php echo $string_dosen_hasil." (".$nama_matkul_grafik." -> ".$nama_kelas_grafik.")";?>',
		     <?php
		     	$tinggiChart = $tinggiChart + 10;
	          	endforeach;
	          ?>
            	
            ],
            datasets: [{
                label: 'Jumlah Tatap Muka Pengampu Matakuliah',
                backgroundColor: "rgba(220,220,220)",
                data: [
                <?php
	          	$data_dosen = $this->m_grafik_jumlah_pertemuan_tatap_muka->data_dosen($_SESSION['id_pertemuan_search'], $_SESSION['kode_prodi']);
            	 foreach($data_dosen->result_array() as $i):
					$dosen_pengampu_grafik=$i['dosen_pengampu'];
					$nama_matkul_grafik=$i['nama_mk'];
					$nama_kelas_grafik=$i['nama_kelas'];
					$id_jadwal_kelas_pertemuan_grafik=$i['id_jadwal_kelas_pertemuan'];

					//menampilkan nama semua pengampu
					$array_dosen = explode(', ', $dosen_pengampu_grafik);
					$index = 0;
					$array_dosen_hasil = array();

					foreach ($array_dosen as $npk) {
						$nama_dosen = $this->m_grafik_jumlah_pertemuan_tatap_muka->getNamaDosen($npk);
						$array_dosen_hasil[$index++] = $nama_dosen;
					}

					$string_dosen_hasil = implode('/ ', $array_dosen_hasil);
					$jumlahTatapMukaPerkelas = $this->m_grafik_jumlah_pertemuan_tatap_muka->jumlahTatapMukaPerkelas($id_jadwal_kelas_pertemuan_grafik);

		     ?>
		     	<?php echo $jumlahTatapMukaPerkelas ?>,
		     <?php
	          	endforeach;
	          ?>
	          ]
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById("canvas").getContext("2d");
            var chartEl = document.getElementById("canvas");
			chartEl.height = <?= $tinggiChart ?>;
            window.myHorizontalBar = new Chart(ctx, {
                type: 'horizontalBar',
                data: horizontalBarChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each horizontal bar to be 2px wide and green
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: 'rgb(0, 255, 0)',
                            // borderSkipped: 'left'
                        }
                    },
                    responsive: true,
                    // legend: {
                    //     position: 'right',
                    // },
                    title: {
                        display: true,
                        text: 'Jumlah Tatap Muka Pengampu Matakuliah'
                    }
                }
            });

        };

      
    </script>
		<?php } ?> 

		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">GRAFIK PENGGUNAAN MEDIA TATAP MUKA</h1>
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
										
										<div class="col-md-12 bg-light rounded">
											<form action="<?php echo base_url('upm/grafik_jumlah_pertemuan_tatap_muka')?>" method="post">
												<div class="row">
													<div class="col-md-5">
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
													<div class="col-md-2">
														
														<div class="form-group text-left">
															<label class="control-label col-xs-3">AKSI</label><br>
															<input type="submit" name="tombol_cari" value="Cari Sekarang" class="btn btn-primary">
														</div>
														
													</div>
												</div>
											</form>
											
										</div>
									</div>
																		
									<hr>
									<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['kode_prodi'])){ ?>
										<a href="<?= base_url('upm/grafik_jumlah_pertemuan_tatap_muka/cetak/').$_SESSION['id_pertemuan_search'] ?>" class="btn btn-warning btn-sm">Cetak PDF</a>
										<hr>
										<div id="container" style="width: 100%;">
									        <canvas id="canvas"></canvas>
									    </div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>
			

							
										
									
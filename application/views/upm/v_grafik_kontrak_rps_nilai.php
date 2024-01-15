		
		<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">
	      google.charts.load('current', {'packages':['bar']});
	      google.charts.setOnLoadCallback(drawChart);
	   

	      function drawChart() {
	        var data = google.visualization.arrayToDataTable([

	          ['STATISTIK SEMUA PROGRAM STUDI', 



	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$nama_prodi_grafik=$i['nama_prodi'];

		       ?>
	          '<?php echo $nama_prodi_grafik;?>',

	          <?php
	          	endforeach;
	          ?>
	          
	          ],
	          ['TOTAL SEMUA KELAS', 

	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$hasil1 = $this->m_grafik_kontrak_rps_nilai->count_semua_kelas($_SESSION['id_pertemuan_search'], $kode_prodi_grafik);
					echo $hasil1.',';
				endforeach;
		       ?>
	          ],
	          ['TOTAL PENYERAHAN KONTRAK KULIAH', 

	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$hasil1 = $this->m_grafik_kontrak_rps_nilai->count_submit_kontrak_rps($_SESSION['id_pertemuan_search'], $kode_prodi_grafik, 'Kontrak Kuliah');
					echo $hasil1.',';
				endforeach;
		       ?>
	          ],
	          ['TOTAL PENYERAHAN RPS', 

	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$hasil1 = $this->m_grafik_kontrak_rps_nilai->count_submit_kontrak_rps($_SESSION['id_pertemuan_search'], $kode_prodi_grafik, 'RPS');
					echo $hasil1.',';
				endforeach;
		       ?>
	          ],
	          ['TOTAL PENYERAHAN NILAI UTS', 

	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$hasil1 = $this->m_grafik_kontrak_rps_nilai->count_submit_nilai($_SESSION['id_pertemuan_search'], $kode_prodi_grafik, 'Ujian Tengah Semester');
					echo $hasil1.',';
				endforeach;
		       ?>
	          ],
	          ['TOTAL PENYERAHAN NILAI UAS', 

	          <?php
		        foreach($combobox_prodi->result_array() as $i):
					$kode_prodi_grafik=$i['kode_prodi'];
					$hasil1 = $this->m_grafik_kontrak_rps_nilai->count_submit_nilai($_SESSION['id_pertemuan_search'], $kode_prodi_grafik, 'Ujian Akhir Semester');
					echo $hasil1.',';
				endforeach;
		       ?>
	          ],
	        ]);
	    
	        var options = {
	          chart: {
	            title: 'Grafiks',
	            // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
	          }
	        };

	        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

	        chart.draw(data, google.charts.Bar.convertOptions(options));
	      }
	    </script>
		<?php } ?> 

		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">GRAFIK PENYERAHAN KONTRAK KULIAH, RPS DAN NILAI</h1>
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
											<form action="<?php echo base_url('upm/grafik_kontrak_rps_nilai')?>" method="post">
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
									<?php if( isset($_SESSION['id_pertemuan_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
										<div id="columnchart_material" style="width: 100%; height: 500px;"></div>
									<?php }else{ ?>
										<h1 class="text-danger">SILAHKAN PILIH TAHUN AJARAN TERLEBIH DAHULU...</h1>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>                    
			</div>
			

							
										
									
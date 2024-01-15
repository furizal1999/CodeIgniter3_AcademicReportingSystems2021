	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Pernyataan', 'Sangat Setuju', 'Setuju', 'Tidak Setuju', 'Sangat Tidak Setuju'],
          
          ['P1', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement1") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement1") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement1") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement1") ?>],

          ['P2', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement2") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement2") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement2") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement2") ?>],

          ['P3', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement3") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement3") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement3") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement3") ?>],

          ['P4', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement4") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement4") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement4") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement4") ?>],

          ['P5', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement5") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement5") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement5") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement5") ?>],

          ['P6', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement6") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement6") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement6") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement6") ?>],

          ['P7', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement7") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement7") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement7") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement7") ?>],

          ['P8', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement8") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement8") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement8") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement8") ?>],

          ['P9', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement9") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement9") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement9") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement9") ?>],

          ['P10', <?= $this->m_grafik_kuesioner_tatap_muka->getCount("SS", "statement10") ?>, 
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("S", "statement10") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("TS", "statement10") ?>,
          		 <?= $this->m_grafik_kuesioner_tatap_muka->getCount("STS", "statement10") ?>],
        ]);

        var options = {
          chart: {
            title: 'Statistik respon responder',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    

		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">SK PENGAWAS DAN TATA TERTIB UJIAN</h1>
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
								<?php echo $this->session->flashdata('messege'); ?>
								<div class="table-responsive">
									<table class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>No</b></td>
												<td align="center"><b>Tanggal</b></td>
												<td align="center"><b>username</b></td>
												<td align="center"><b>P1</b></td>
												<td align="center"><b>P2</b></td>
												<td align="center"><b>P3</b></td>
												<td align="center"><b>P4</b></td>
												<td align="center"><b>P5</b></td>
												<td align="center"><b>P6</b></td>
												<td align="center"><b>P7</b></td>
												<td align="center"><b>P8</b></td>
												<td align="center"><b>P9</b></td>
												<td align="center"><b>P10</b></td>
											</tr>
										</thead>
										<tbody>
										<?php 
												$no = 1;
												foreach($data->result_array() as $i):

											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $i['date'];?></td>
												<td><?php echo $i['username_responder'];?></td>
												<td><?php echo $i['statement1'];?></td>
												<td><?php echo $i['statement2'];?></td>
												<td><?php echo $i['statement3'];?></td>
												<td><?php echo $i['statement4'];?></td>
												<td><?php echo $i['statement5'];?></td>
												<td><?php echo $i['statement6'];?></td>
												<td><?php echo $i['statement7'];?></td>
												<td><?php echo $i['statement8'];?></td>
												<td><?php echo $i['statement9'];?></td>
												<td><?php echo $i['statement10'];?></td>
												
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>

								</div>
							</div>
						</div>
					</div>

					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<table class="table table-bordered table-striped"cellspacing="0" cellpadding="3" width="100%" style="width: 100px">
										<thead>
											<tr  class="bg-info">
												<td align="center"><b>No</b></td>
												<td align="center"><b>bobot</b></td>
												<td align="center"><b>P1</b></td>
												<td align="center"><b>P2</b></td>
												<td align="center"><b>P3</b></td>
												<td align="center"><b>P4</b></td>
												<td align="center"><b>P5</b></td>
												<td align="center"><b>P6</b></td>
												<td align="center"><b>P7</b></td>
												<td align="center"><b>P8</b></td>
												<td align="center"><b>P9</b></td>
												<td align="center"><b>P10</b></td>
												<td align="center"><b>Total</b></td>
												<td align="center"><b>Score</b></td>
												<td align="center"><b>Max Score</b></td>
												<td align="center"><b>Percentase kepuasan pengguna</b></td>

											</tr>
										</thead>
										<tbody>
										<?php 
												$bobot = 4;
												$ar = array("SS","S","TS","STS");
												$jmlh =0;
												$execute=TRUE;
												$sumTotalScore=0;
												foreach($ar AS $value) { 
												$total=0;
												$totalScore =0;


											?>
											<tr>
												<td class="bg-info"><?php echo $value;?></td>
												<td class="bg-info"><?php echo $bobot;?></td>

												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement1"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement2"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement3"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement4"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement5"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement6"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement7"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement8"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement9"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php $jmlh = $this->m_grafik_kuesioner_tatap_muka->getCount($value, "statement10"); echo $jmlh; $total+=$jmlh; ?></td>
												<td><?php echo ($total);?></td>

												<td><?php $totalScore += ($total*$bobot); echo $totalScore ;?></td>

												<?php 
													$sumTotalScore+=$totalScore;
													if($execute==TRUE){
														echo '<td rowspan="4">'.'4 * 10 *'.$this->m_grafik_kuesioner_tatap_muka->getCountAll() ?> = <?= (4*10*$this->m_grafik_kuesioner_tatap_muka->getCountAll()).'</td>';
														$execute = FALSE;
													}
												?>
												<td class="bg-warning"></td>
											</tr>
											<?php $bobot--; } ?>
											<tr>
												<td colspan="13" class="bg-success">Total</td>
												<td><?= $sumTotalScore; ?></td>
												<td><?= (4*10*$this->m_grafik_kuesioner_tatap_muka->getCountAll()) ?></td>
												<td align="center" class="bg-success"><b><?= round($sumTotalScore/(4*10*$this->m_grafik_kuesioner_tatap_muka->getCountAll())*100, 2) ?>%</b></td>
												
											</tr>
										</tbody>
									</table>
									<br>
									

								</div>
								
							</div>
						</div>
					</div>

					<div class="row mt--2">
						<div class="col-md-12">
							<div class="card full-height">
								<div class="card-body">
									<div id="columnchart_material" style="width: 1300px; height: 800px;"></div>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>

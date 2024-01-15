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
											<form action="<?php echo base_url('prodi/laporan_tatap_muka')?>" method="post">
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
											$hasilCek = $this->m_laporan_tatap_muka_prodi->getRangePertemuan($_SESSION['id_pertemuan_search']);
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
											<form action="<?php echo base_url('prodi/laporan_tatap_muka')?>" method="post">
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
											<?php if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['bulan_search'])){ ?>
												<div class="form-group text-left">
													<label class="control-label col-xs-3">AKSI CETAK</label><br>
													<a href="<?= base_url('prodi/laporan_tatap_muka/cetak/'.$_SESSION['id_pertemuan_search'])?>" target="_BLANK" class="btn btn-warning"><i class="fas fa-print"></i>  CETAK LAPORAN TATAP MUKA</a>
												</div>
												
											<?php } ?>
										</div>
									</div>
									<?php 
											}
										}
									 ?>							
									<hr>
									<?php if(isset($_SESSION['id_pertemuan_search'])){ ?>
									<?php echo $this->session->flashdata('messege'); ?>
									<div class="table-responsive">
										
											<?php
										    
										        
										        if(isset($_SESSION['id_pertemuan_search'])){
										        	$id_pertemuan = $_SESSION['id_pertemuan_search'];
										            $query= $this->m_laporan_tatap_muka_prodi->cekPertemuan($id_pertemuan);
										            if($query->num_rows()==1){
										            	if(isset($_SESSION['bulan_search'])){
										        			$bulan_search = $_SESSION['bulan_search'];
											                $row = $query->row();
											                if($row){
											                    $tahun_ajaran_judul = $row->tahun_ajaran;
											                    $semester_judul = $row->semester;
											                    $semester_judul = $row->semester;
											    ?>
											                    <table class="table table-bordered table-striped text-center" id="mydatascroll" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											                        <thead>
											                            <tr class="bg-success">
											                                <th>NO</th>
											                                <th>NAMA DOSEN</th>
											                                <th>JABATAN FUNGSIONAL</th>
											                                <th>PEND</th>
											                                <th>JENIS TUGAS</th>
											                                <th>MATAKULIAH</th>
											                                <th>SKS</th>
											                                <th>KELAS</th>
											                                <th>PRODI</th>
											                                <?php
											                                    foreach ($period as $dt) {
											                                    	$format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
																					$format_time_angka = $dt->format("Y-m") ;
											                                ?>
											                                    <th><?= strtoupper($format_time) ?></th>
											                                    
											                                <?php
											                                    }
											                                ?>
											                                <th>JUMLAH</th>
											                            </tr>
											                        </thead>
											                        <tbody>
											                            <?php
											                               
											                                 $jumlah = array();
											                                 $total_semua_dosen_perbulan = 0;
											                                 $data = $this->m_laporan_tatap_muka_prodi->show_laporan_tatap_muka($id_pertemuan);
											                                 if($data->num_rows()>0){
											                                    $no = 1;
											                                    foreach ($data->result_array() as $item) {
											                                        $id_jadwal_kelas_pertemuan = $item['id_jadwal_kelas_pertemuan'];
											                                        $nama_dosen = $item['nama_dosen'];
											                                        $npk = $item['npk'];
											                                        $kode_mk = $item['kode_mk'];
											                                        $nama_mk = $item['nama_mk'];
											                                        $sks_teori = $item['sks_teori'];
											                                        $nama_kelas = $item['nama_kelas'];
											                                        $kategori_tugas = $item['kategori_tugas'];
											                                        $nama_prodi = $item['nama_prodi'];
											                                        $pendidikan = $item['pendidikan'];
											                                        $jabatan_fungsional = $item['jabatan_fungsional'];
											                                    
											                            ?>
											                            <tr>
											                                <?php
											                                    

											                                  

											                                 $j_kelas = $this->m_laporan_tatap_muka_prodi->cekJumlahKelas($id_pertemuan, $npk);

									                                        // $jabatan_fungsional = $this->m_laporan_tatap_muka_prodi->getJabatanFungsional($npk);
									                                        // $pendidikan = $this->m_laporan_tatap_muka_prodi->getPendidikan($npk);
											                                       

											                                ?>
											                                        
											                           
											                                
											                               	<td><?= $no++ ?></td>
									                                        <td><?= $nama_dosen ?></td>
									                                        <td><?= $jabatan_fungsional ?></td>
									                                        <td><?= $pendidikan ?></td>
									                                        <td><?= $kategori_tugas ?></td>
											                                <td><?= $nama_mk ?></td>
											                                <td><?= $sks_teori ?></td>
											                                <td><?= $nama_kelas ?></td>
											                                <td><?= $nama_prodi ?></td>
											                                <?php
											                                		$i=0;
											                                         foreach ($period as $dt) {
											                                    	$format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
																					$format_time_angka = $dt->format("Y-m") ;
																					$format_time_angka_tanpa_strip = $dt->format("Ym") ;
											                                            // code...
											                                            if(date('Y-m', strtotime($format_time_angka))<=date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4)))){
											                                                $jumlah[$i] = $this->m_laporan_tatap_muka_prodi->cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $npk, date('Y-m',strtotime($format_time_angka)));
											                                             }else{
											                                                $jumlah[$i] = 0;
											                                             }      
											                                             // echo date('m',strtotime($format_time_angka));die();


											                                       
											                                ?>

											                                        <td <?php if(strcmp(str_replace('-', '', $bulan_search),$format_time_angka_tanpa_strip)==0){ echo 'style="background-color: yellow; color: black;"'; } ?>><?= $jumlah[$i]*($sks_teori*0.5) ?></td>
											                                   
											                                <?php
											                                			$i++;
											                                        }


									                                           $array_perkategori = $this->m_laporan_tatap_muka_prodi->cekJumlahTatapMukaPerKategoriArray($id_pertemuan, $npk, $kategori_tugas);
										                                        $total_bobot_perbulan = 0; 
										                                        if($array_perkategori->num_rows()>0){
										                                            foreach ($array_perkategori->result_array() as $a) {
										                                                $jumlah_Perbulan = $this->m_laporan_tatap_muka_prodi->cekJumlahPerbulan($a['id_jadwal_kelas_pertemuan'], $a['npk'], date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4))));

										                                                // echo $str = substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4);

										                                                // echo date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4))); die();
										                                                // echo $bulan_search; die();
										                                               
										                                                $total_bobot_perbulan = $total_bobot_perbulan + ($a['sks_teori'] * 0.5 * $jumlah_Perbulan);
										                                            }
										                                        }
										                                        $total_semua_dosen_perbulan = $total_semua_dosen_perbulan +$total_bobot_perbulan;
											                                    ?>
											                                    <td style="background-color: yellow; color: black;"><?= $total_bobot_perbulan ?></td>
											                               
											                            </tr>
											                            <?php
											                                    }  
											                                 }
											                            ?>
											                            <!-- <tr style="text-align:center; background-color: lightyellow;">
											                                <td colspan="15">TOTAL</td>
											                                <td><?= $total_semua_dosen_perbulan ?></td>
											                            </tr> -->
											                        </tbody>
											                    </table>
											    <?php
											                   

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
			


							
										
									
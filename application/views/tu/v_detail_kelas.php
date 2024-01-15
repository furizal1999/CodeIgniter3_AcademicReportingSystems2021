		<div class="main-panel">
          <div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h1 class="text-white pb-2 fw-bold">DETAIL LIST KELAS</h1>
								<h5 class="text-white op-7 mb-2">Fakultas Teknik Universitas Islam Riau</h5>
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
								
								<div class="card-body">
									
								<?php echo $this->session->flashdata('messege'); ?>
								<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>
									<div class="table-responsive">
										<table id="mydatascroll" class="table table-bordered table-striped"  cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
											<thead>
												<tr  class="bg-info">
													<td align="center"><b>NO</b></td>
													<td align="center"><b>NAMA MATAKULIAH</b></td>
													<td align="center"><b>DOSEN PENGAMPU</b></td>
													<td align="center"><b>NAMA KELAS</b></td>
													<td align="center"><b>Jumlah Mahasiswa</b></td>
													<td align="center"><b>Jadwal Pertemuan Awal Mulai</b></td>
													<td align="center"><b>Jadwal Pertemuan Awal Selesai</b></td>
													<td align="center"><b>AKSI</b></td>
													
												</tr>
											</thead>
											<tbody>
										<?php 
												$no = 1;
												foreach($detail_kelas->result_array() as $i):
													$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
													$tahun_ajaran=$i['tahun_ajaran'];
													$dosen_pengampu=$i['dosen_pengampu'];

													$array_dosen = explode(', ', $dosen_pengampu);
													$array_dosen_hasil = array();
													$array_npk_hasil = array();
													$index = 0;
													foreach ($array_dosen as $npk) {
														$nama_dosen = $this->m_jadwal_pengampu_matkul->getNamaDosen($npk);
														$array_npk_hasil[$index] = $npk;
														$array_dosen_hasil[$index] = $nama_dosen;
														$index++;
													}
													$string_dosen_hasil = implode('/ ', $array_dosen_hasil); 

													$nama_mk=$i['nama_mk'];
													$nama_kelas=$i['nama_kelas'];
													$jumlah_mahasiswa=$i['jumlah_mahasiswa'];
													$waktu_pertemuan_pertama=$i['waktu_pertemuan_pertama'];
													$waktu_pertemuan_pertama_selesai=$i['waktu_pertemuan_pertama_selesai'];
													
											?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $nama_mk;?></td>
												<td><?php echo $string_dosen_hasil;?></td>
												<td><?php echo $nama_kelas;?></td>
												<td><?php echo $jumlah_mahasiswa;?></td>
												<td><?php echo $waktu_pertemuan_pertama;?></td>
												<td><?php echo $waktu_pertemuan_pertama_selesai;?></td>
												<td>
													<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit_kelas<?= $id_jadwal_kelas_pertemuan ?>"><i class="fa fa-pen"></i></a>
													<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus_kelas<?= $id_jadwal_kelas_pertemuan ?>"><i class="fa fa-trash"></i></a>
												</td>
												
											</tr>
											<?php endforeach;?>
										</tbody>
										</table>
									</div>
								<?php }else{ ?>
									<h1 class="text-danger">Silahkan pilih prodi dan pertemuan semester terlebih dahulu!</h1>
								<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

                    
			</div>


<?php if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){ ?>

	<?php 
		foreach($detail_kelas->result_array() as $i):

			$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
			$id_jadwal_pengampu=$i['id_jadwal_pengampu'];
			$waktu_pertemuan_pertama=$i['waktu_pertemuan_pertama'];
			$waktu_pertemuan_pertama_selesai=$i['waktu_pertemuan_pertama_selesai'];
			$nama_kelas=$i['nama_kelas'];
			$jumlah_mahasiswa=$i['jumlah_mahasiswa'];

			$tanggal_pertemuan_pertama = date("Y-m-d", strtotime($waktu_pertemuan_pertama));
			$jam_pertemuan_pertama = date("H:i", strtotime($waktu_pertemuan_pertama));
			$jam_pertemuan_pertama_selesai = date("H:i", strtotime($waktu_pertemuan_pertama_selesai));
			
		?>
		<div class="modal fade" id="modal_edit_kelas<?php echo $id_jadwal_kelas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header bg-secondary">
				<h3 class="modal-title" id="myModalLabel">Edit Jadwal Kelas</h3>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/edit_jadwal_kelas_pertemuan'?>" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="hidden" name="id_jadwal_kelas_pertemuan" class="form-control" value="<?php echo $id_jadwal_kelas_pertemuan?>">
					
					<div class="form-group">
						<label class="control-label col-xs-3" >WAKTU PERTEMUAN PERTAMA (TANGGAL)</label>
						<div class="row">
							<div class="form-group"><input type="date" value="<?= $tanggal_pertemuan_pertama ?>" name="tanggal_pertemuan_pertama" class="form-control" required></div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<label>JAM MULAI</label>
								<div class="form-group"><input type="time" value="<?= $jam_pertemuan_pertama ?>" name="jam_pertemuan_pertama" class="form-control" required></div>
							</div>
							<div class="col-md-6">
								<label>JAM SELESAI</label>
								<div class="form-group"><input type="time" value="<?= $jam_pertemuan_pertama_selesai ?>" name="jam_pertemuan_pertama_akhir" class="form-control" required></div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>KELAS</label>
						<select name="nama_kelas" class="form-control" required>
							<option value="">--Pilih--</option>
							<?php 
								$z= $this->m_jadwal_pengampu_matkul->combobox_kelas($_SESSION['kode_prodi'], $semester);
								if($z){
									foreach($z->result_array() as $y):
										$semester_combo=$y['semester'];
										$nama_kelas_combo=$y['nama_kelas'];
										$kelas_pilihan_combo=$y['kelas_pilihan'];
										if($semester_combo=='0'){
											$semester_combo = '';
										}
										if($kelas_pilihan_combo=="PIL"){
											$kelas_combo = $semester_combo.$nama_kelas_combo.' '.$kelas_pilihan_combo;
										}else{
											$kelas_combo = $semester_combo.$nama_kelas_combo;
										}
										

								?>
								<option  value="<?php echo $kelas_combo; ?>" <?php if($kelas_combo==$nama_kelas){ echo 'selected'; } ?>>
									<?php echo $kelas_combo; ?>
								</option>
								<?php
									endforeach;
									
								}
							?>
						</select>

					</div>
					<div class="form-group">
							<label>JUMLAH MAHASISWA</label>
							<input type="number" name="jumlah_mahasiswa" value="<?= $jumlah_mahasiswa; ?>" class="form-control" placeholder="Masukkan jumlah mahasiswa.." required>
					</div>

					<input type="hidden" name="id_jadwal_pengampu" value="<?= $id_jadwal_pengampu ?>">
						

				</div>

				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
					<button class="btn btn-secondary">Simpan Perubahan</button>
				</div>
			</form>
			</div>
			</div>
		</div>

		<!-- ============ MODAL HAPUS =============== -->
		<div class="modal fade" id="modal_hapus_kelas<?php echo $id_jadwal_kelas_pertemuan;?>" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
			<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header bg-danger">
				<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Kelas Pertemuan</h3>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<form class="form-horizontal" method="post" action="<?php echo base_url().'tu/jadwal_pengampu_matkul/hapus_jadwal_kelas_pertemuan'?>">
				<div class="modal-body">
					<p>Anda yakin menghapus jadwal kelas <b><?php echo $nama_kelas;?></b>?</p>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id_jadwal_pengampu" value="<?= $id_jadwal_pengampu ?>">
					<input type="hidden" name="id_jadwal_kelas_pertemuan" value="<?php echo $id_jadwal_kelas_pertemuan;?>">
					<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
					<button class="btn btn-danger">Hapus</button>
				</div>
			</form>
			</div>
			</div>
		</div>

	<?php endforeach;?>


<?php } ?>




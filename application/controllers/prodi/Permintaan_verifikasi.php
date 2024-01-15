<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Permintaan_verifikasi extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Prodi')!==0 ){
				//tidak dibolehkan
				if(strcmp($_SESSION["status_login"], 'Fakultas')==0){
					redirect('welcome');
				}else{
					redirect('welcome');
				}
			}else{
				//dibolehkan
			}
		}
		$this->load->model('m_permintaan_verifikasi');
	}


	
	public function index()
	{
		
			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			$x['combobox_ujian'] = $this->m_permintaan_verifikasi->combobox_ujian();
			
			$kode_prodi = $_SESSION['kode_prodi'];
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_permintaan_verifikasi', $x);
			$this->load->view('public/part/footer');
			
			unset($_SESSION['messege']);

        
		unset($_SESSION['messege']);
	}

	public function get_ajax() {
		date_default_timezone_set('Asia/Jakarta');
      	$sekarang = date("Y-m-d H:i:s");

        //koneksi database
		// $servername = "localhost";
		// $username = "root";
		// $password = "";
		// $dbname = "ftuir";
		// //----------------------------------------------------------------------------------
		// $conn = mysqli_connect($servername, $username, $password, $dbname) or die("Koneksi error: " . mysqli_connect_error());
		$requestData= $_REQUEST;
		$columns = array( 
			0 =>'id_jadwal_lanjutan',
			1 =>'nama_mk',
			// 2 =>'npk_pengawas1',
			// 3 =>'npk_pengawas2',
			// 0 =>'id_jadwal_lanjutan',
			// 0 =>'id_jadwal_lanjutan',
		);
		//----------------------------------------------------------------------------------
		//join 2 tabel dan bisa lebih, tergantung kebutuhan 
        $kode_jurusan = $_SESSION['kode_prodi'];
        $id_ujian = $_SESSION['id_ujian_search'];
        
		$sql = " SELECT *";
		$sql.= " 
				FROM 
	            tb_tahun_ajaran, 
	            tb_semester, 
	            tb_pertemuan,
	            tb_jadwal_pengampu,
	            tb_prodi,
	            tb_matkul,
	            tb_ujian,
	            tb_surat_keputusan,
	            tb_jadwal_ujian,
	            tb_jadwal_kelas_pertemuan,
	            tb_jadwal_ujian_lanjutan
			";

		$sql.= "

	            WHERE 
	            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
	            tb_semester.id_semester = tb_pertemuan.id_semester AND 
	            tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
	            tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
	            tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
	            tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
	            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
	            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
	            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
	            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
	            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
	            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
	            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

	            tb_tahun_ajaran.status='Tersedia' AND 
	            tb_semester.status = 'Tersedia' AND 
	            tb_pertemuan.status='Tersedia' AND
	            tb_jadwal_pengampu.status='Tersedia' AND
	            tb_prodi.status = 'Tersedia' AND
	            tb_matkul.status = 'Tersedia' AND
	            tb_ujian.status = 'Tersedia' AND
	            tb_surat_keputusan.status = 'Tersedia' AND
	            tb_jadwal_ujian.status = 'Tersedia' AND
	            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
	            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
	            tb_prodi.kode_prodi = '$kode_jurusan' AND
	            tb_ujian.id_ujian = '$id_ujian' AND
            
            	(((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00')) OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang')))

            ";
		$sql.= " ORDER BY (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Minta Verifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Minta Verifikasi') DESC, tb_jadwal_ujian.tanggal_ujian DESC, tb_jadwal_ujian.jam_mulai DESC";
		$queryAll = $this->m_permintaan_verifikasi->getAllData($sql);

		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		$totalData = $queryAll->num_rows();
		$totalFiltered = $totalData;

		//----------------------------------------------------------------------------------
		$sql = " SELECT *";
		$sql.= " 
				FROM 
	            tb_tahun_ajaran, 
	            tb_semester, 
	            tb_pertemuan,
	            tb_jadwal_pengampu,
	            tb_prodi,
	            tb_matkul,
	            tb_ujian,
	            tb_surat_keputusan,
	            tb_jadwal_ujian,
	            tb_jadwal_kelas_pertemuan,
	            tb_jadwal_ujian_lanjutan
		";
		$sql.= " 
				WHERE 
	            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
	            tb_semester.id_semester = tb_pertemuan.id_semester AND 
	            tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
	            tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
	            tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
	            tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
	            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
	            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
	            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
	            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
	            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
	            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
	            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

	            tb_tahun_ajaran.status='Tersedia' AND 
	            tb_semester.status = 'Tersedia' AND 
	            tb_pertemuan.status='Tersedia' AND
	            tb_jadwal_pengampu.status='Tersedia' AND
	            tb_prodi.status = 'Tersedia' AND
	            tb_matkul.status = 'Tersedia' AND
	            tb_ujian.status = 'Tersedia' AND
	            tb_surat_keputusan.status = 'Tersedia' AND
	            tb_jadwal_ujian.status = 'Tersedia' AND
	            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
	            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
	            tb_prodi.kode_prodi = '$kode_jurusan' AND
	            tb_ujian.id_ujian = '$id_ujian' AND
            
            	(((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00')) OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang')))
		";
		// $sql.= " ORDER BY (status_verifikasi_pengawas1='Minta Verifikasi' OR status_verifikasi_pengawas2='Minta Verifikasi') DESC, tanggal_ujian DESC, jam_mulai DESC";
		// $sql.= " WHERE 1=1";
		

		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";    
			$sql.=" OR npk_pengawas1 LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR npk_pengawas2 LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_permintaan_verifikasi->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows();
		// echo $totalFiltered; die();
		// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$sql.=" ORDER BY (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Minta Verifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Minta Verifikasi') DESC, tb_jadwal_ujian.tanggal_ujian DESC, tb_jadwal_ujian.jam_mulai DESC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_permintaan_verifikasi->getFilteredDataOrderBy($sql);

		$_SESSION['order_column'] = $columns[$requestData['order'][0]['column']];
		$_SESSION['order_dir'] = $requestData['order'][0]['dir'];
		$_SESSION['start'] = $requestData['start'];
		$_SESSION['length'] = $requestData['length'];


		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		//----------------------------------------------------------------------------------
		$data = array();
		$no = 1;
		//$jam_submit!="00:00:00" AND 



		foreach($queryOrderBy->result_array() as $row):
			$nestedData=array(); 
			$nestedData[] = $no++;
			$nestedData[] = $row["nama_mk"];
			$nama_pengawas1 = $this->m_permintaan_verifikasi->nama_pengawas($row['npk_pengawas1']);
			$nestedData[] = $nama_pengawas1;

			$tempo_status1 = '';

			if($row['npk_pengawas1']!=""){
				if($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Minta Verifikasi"){
					$tempo_status1 = $tempo_status1.'<div class="button text-danger">Minta verifikasi</div>';
				}elseif($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Terverifikasi"){
					$tempo_status1 = $tempo_status1.'<div class="text-success text-center">Terverifikasi</div>';
				}elseif($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Permintaan verifikasi ditolak"){
					$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Permintaan verifikasi ditolak</div>';
				}else{
					$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Belum melakukan submit</div>';
				}
			}
			else{
				$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Pengawas 1 tidak tersedia</div>';
			}
													

			$nestedData[] = $tempo_status1;

			date_default_timezone_set('Asia/Jakarta');
			// $waktu_awal        =strtotime($row['tanggal_ujian']." ".$row['jam_mulai']);
			// $waktu_akhir    = strtotime(date("Y-m-d H:i:s")); // bisa juga waktu 
			// $diff    =$waktu_akhir - $waktu_awal;
			$tanggal_ujian_time        =strtotime($row['tanggal_ujian']);
			$now_time    = strtotime(date("Y-m-d")); // bisa juga waktu 
			$id_jadwal_lanjutan = $row["id_jadwal_lanjutan"];
			if($row["npk_pengawas1"]!=""){
				$tempo = '';
			
				
		        
				if($now_time>$tanggal_ujian_time){
					
					
						if($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Minta Verifikasi"){
					
						$tempo = $tempo. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_verifikasi_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-check"></i> Verifikasi</a>'.'<div class="modal fade" id="modal_verifikasi_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success text-white">
											<h3 class="modal-title" id="myModalLabel">Verifikasi Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/verifikasi1'.'">
											<div class="modal-body">
												<p>Apakah anda yakin memverifikasi bukti yang telah dimasukkan?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>';



						$tempo = $tempo.'<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_tolak_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Tolak</a>'.'<div class="modal fade" id="modal_tolak_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger text-white">
											<h3 class="modal-title" id="myModalLabel">Tolak Bukti Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/tolak_pengawas1'.'">
											<div class="modal-body">
												<p>Apakah anda yakin menolak bukti yang telah dimasukkan?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-danger">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>';
						
					
						}elseif($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Terverifikasi"){
					
						$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_verifikasi_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Verifikasi</a>'.'<div class="modal fade" id="modal_batal_verifikasi_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Verifikasi Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/batal_verifikasi_pengawas1'.'">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan verifikasi?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>';
						
					
						}elseif($row['jam_submit_pengawas1']!="00:00:00" && $row['status_verifikasi_pengawas1']=="Permintaan verifikasi ditolak"){
					
						$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_tolak_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Tolak</a>'.'<div class="modal fade" id="modal_batal_tolak_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/batal_tolak_pengawas1'.'">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan penolakan berkas?</p>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-warning">Ya</button>
											</div>
										</form>
										</div>
										</div>
									</div>';
						
					
						}else{
							// echo '<div class="text-danger text-center">Belum melakukan submit</div>'; 
						}
					

					$tempo = $tempo.'<a class="btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#modal_edit_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-pen"></i> Edit</a>'.'<div class="modal fade" id="modal_edit_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-secondary text-white">
											<h3 class="modal-title" id="myModalLabel">Edit Data Mengawas</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/edit_pengawas1'.'" enctype="multipart/form-data">
											<div class="modal-body">
												<div class="form-group">
													<label>Jenis Soal</label>
													<select name="jenis_soal" class="form-control" required>
														<option value=""'; if($row['jenis_soal']==""){ $tempo = $tempo.'selected';} $tempo = $tempo.'>--Pilih--</option>
														<option value="Tugas"'; if($row['jenis_soal']=="Tugas"){ $tempo = $tempo. 'selected'; } $tempo = $tempo.'>Tugas</option>
														<option value="Take Home"'; if($row['jenis_soal']=="Take Home"){ $tempo = $tempo. 'selected'; } $tempo = $tempo.'>Take Home</option>
														<option value="Pemberian Soal Langsung"'; if($row['jenis_soal']=="Pemberian Soal Langsung"){ $tempo = $tempo. 'selected';}$tempo = $tempo.'>Pemberian Soal Langsung</option>
													</select>
												</div>
												<div class="form-group">
													<label>Media yang Digunakan</label>
													<input name="media" type="text" class="form-control" value="'. $row['media'] .'" required>
												</div>

												<div class="form-group">
													<label>Jumlah Peserta Hadir</label>
													<input name="jumlah_peserta_hadir" type="number" class="form-control" value="'. $row['jumlah_mahasiswa_hadir'] .'" required>
												</div>

												<div class="form-group">
													<label>Keterangan Ujian</label>
													<select name="ket_pelaksanaan" class="form-control" required>
														<option value=""'; if($row['ket_pelaksanaan']==""){ $tempo = $tempo. 'selected'; } $tempo = $tempo.'>--Pilih--</option>
														<option value="Aman dan Lancar"'; if($row['ket_pelaksanaan']=="Aman dan Lancar"){ $tempo = $tempo. 'selected'; } $tempo = $tempo.'>Aman dan Lancar</option>
														<option value="Ada Kendala"'; if($row['ket_pelaksanaan']=="Ada Kendala"){ $tempo = $tempo. 'selected';} $tempo = $tempo.'>Ada Kendala</option>
													</select>
												</div>
												<div class="form-group">
													<label class="control-label col-xs-3" >FOTO BUKTI <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i></label>
													<div class="col-xs-8">
														<input type="file" accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" name="gambar" class="border-secondary text-dark">
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<input type="hidden" name="foto_bukti_pengawas1" value="'. $row['foto_bukti_pengawas1'] .'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
												<button class="btn btn-success">Simpan Perubahan dan Verifikasi</button>
											</div>
										</form>
										</div>
										</div>
									</div>';


				}
			



				$tempo = $tempo.'<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal_detail_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-book"></i> Rincian</a>'.'<div class="modal fade" id="modal_detail_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-info text-white">
											<h3 class="modal-title" id="myModalLabel">Detail Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'dosen/permintaan_verifikasi/batal_submit">
											<div class="modal-body">
												<table class="table">
													<tr>
														<td colspan="3" class="text-center bg-warning"><h1>'.$nama_pengawas1.'</h1></td>
													</tr>
													
													<tr class="text-primary">
														<td>Waktu hadir</td>
														<td>:</td>
														<td>'. $row['tanggal_absen_pengawas1'].' '.$row["jam_absen_pengawas1"].'</td>
													</tr>
													<tr class="text-primary">
														<td>Waktu submit</td>
														<td>:</td>
														<td>'. $row['tanggal_submit_pengawas1'].' '.$row['jam_submit_pengawas1'].'</td>
													</tr>
												
													<tr>
														<td>Matakuliah</td>
														<td>:</td>
														<td>'. $row['nama_mk'].'</td>
													</tr>
													<tr>
														<td>Kode ruang</td>
														<td>:</td>
														<td>'. $row['kode_ruang'].'</td>
													</tr>
													<tr>
														<td>Nama kelas</td>
														<td>:</td>
														<td>'. $row['nama_kelas'].'</td>
													</tr>
													<tr>
														<td>Total mahasiswa</td>
														<td>:</td>
														<td>'. $row['jumlah_mahasiswa'].' orang</td>
													</tr>
													
													<tr>
														<td colspan="3"><b>Data yang diinpukan pengawas</b></td>
													</tr>
													<tr>
														<td>Jenis soal</td>
														<td>:</td>
														<td>'. $row['jenis_soal'].'</td>
													</tr>
													<tr>
														<td>Media</td>
														<td>:</td>
														<td>'. $row['media'].'</td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa hadir</td>
														<td>:</td>
														<td>'. $row['jumlah_mahasiswa_hadir'].' orang</td>
													</tr>
													<tr>
														<td>Jumlah mahasiswa alfa</td>
														<td>:</td>
														<td>'. max(($row['jumlah_mahasiswa']-$row['jumlah_mahasiswa_hadir']),0).' orang</td>
													</tr>
													<tr>
														<td>Hasil pelaksanaan</td>
														<td>:</td>
														<td>'. $row['ket_pelaksanaan'].'</td>
													</tr>
													<tr>
														<td colspan="3">Foto bukti mengawas</td>
													</tr>';
															 if($row['foto_bukti_pengawas1']==""){
													$tempo = $tempo.'<tr>
															<td colspan="3"><p class="text-danger">Maaf, Foto bukti belum tersedia!</p></td>
													</tr>';
															 }else{
													$tempo = $tempo.'<tr>
														<td colspan="3"><img width="100%" src="'. base_url('templates/img/bukti-mengawas/').$row['foto_bukti_pengawas1'].'" alt=""></td>
													</tr>';
													
															 }
													$tempo = $tempo.
													
												'</table>
											</div>
											<div class="modal-footer">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</form>
										</div>
										</div>
									</div>';
				
			
			}
			else{
				$tempo = $tempo.'<div class="text-danger text-center">Pengawas 1 tidak tersedia</div>';
			}


		   							



			$nestedData[] = $tempo;
			if($row['npk_pengawas2']!=""){
				$nama_pengawas2 = $this->m_permintaan_verifikasi->nama_pengawas($row['npk_pengawas2']);

				$tempo_status2 = '';
				if($row['npk_pengawas1']!=""){
					if($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Minta Verifikasi"){
						$tempo_status2 = $tempo_status2.'<div class="button text-danger">Minta verifikasi</div>';
					}elseif($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Terverifikasi"){
						$tempo_status2 = $tempo_status2.'<div class="text-success text-center">Terverifikasi</div>';
					}elseif($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Permintaan verifikasi ditolak"){
						$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Permintaan verifikasi ditolak</div>';
					}else{
						$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Belum melakukan submit</div>';
					}
				}
				else{
					$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Pengawas 2 tidak tersedia</div>';
				}
				// $tempo_aksi2 = 'ADA';

				if($row["npk_pengawas2"]!=""){
					$tempo2 = '';
				
					
			        
					if($now_time>$tanggal_ujian_time){
						
						
							if($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Minta Verifikasi"){
						
							$tempo2 = $tempo2. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_verifikasi_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-check"></i> Verifikasi</a>'.'<div class="modal fade" id="modal_verifikasi_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-success text-white">
												<h3 class="modal-title" id="myModalLabel">Verifikasi Pengawas 2</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/verifikasi2'.'">
												<div class="modal-body">
													<p>Apakah anda yakin memverifikasi bukti yang telah dimasukkan?</p>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
													<button class="btn btn-success">Ya</button>
												</div>
											</form>
											</div>
											</div>
										</div>';



							$tempo2 = $tempo2.'<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_tolak_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Tolak</a>'.'<div class="modal fade" id="modal_tolak_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-danger text-white">
												<h3 class="modal-title" id="myModalLabel">Tolak Bukti Pengawas 2</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/tolak_pengawas2'.'">
												<div class="modal-body">
													<p>Apakah anda yakin menolak bukti yang telah dimasukkan?</p>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
													<button class="btn btn-danger">Ya</button>
												</div>
											</form>
											</div>
											</div>
										</div>';
							
						
							}elseif($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Terverifikasi"){
						
							$tempo2 = $tempo2.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_verifikasi_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Verifikasi</a>'.'<div class="modal fade" id="modal_batal_verifikasi_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-warning text-white">
												<h3 class="modal-title" id="myModalLabel">Batal Verifikasi Pengawas 2</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/batal_verifikasi_pengawas2'.'">
												<div class="modal-body">
													<p>Apakah anda yakin membatalkan verifikasi?</p>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
													<button class="btn btn-warning">Ya</button>
												</div>
											</form>
											</div>
											</div>
										</div>';
							
						
							}elseif($row['jam_submit_pengawas2']!="00:00:00" && $row['status_verifikasi_pengawas2']=="Permintaan verifikasi ditolak"){
						
							$tempo2 = $tempo2.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_tolak_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Tolak</a>'.'<div class="modal fade" id="modal_batal_tolak_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-warning text-white">
												<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengawas 2</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/batal_tolak_pengawas2'.'">
												<div class="modal-body">
													<p>Apakah anda yakin membatalkan penolakan berkas?</p>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
													<button class="btn btn-warning">Ya</button>
												</div>
											</form>
											</div>
											</div>
										</div>';
							
						
							}else{
								// echo '<div class="text-danger text-center">Belum melakukan submit</div>'; 
							}
						

						$tempo2 = $tempo2.'<a class="btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#modal_edit_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-pen"></i> Edit</a>'.'<div class="modal fade" id="modal_edit_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-secondary text-white">
												<h3 class="modal-title" id="myModalLabel">Edit Data Mengawas</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_verifikasi/edit_pengawas2'.'" enctype="multipart/form-data">
												<div class="modal-body">
													<div class="form-group">
														<label>Jenis Soal</label>
														<select name="jenis_soal" class="form-control" required>
															<option value=""'; if($row['jenis_soal']==""){ $tempo2 = $tempo2.'selected';} $tempo2 = $tempo2.'>--Pilih--</option>
															<option value="Tugas"'; if($row['jenis_soal']=="Tugas"){ $tempo2 = $tempo2. 'selected'; } $tempo2 = $tempo2.'>Tugas</option>
															<option value="Take Home"'; if($row['jenis_soal']=="Take Home"){ $tempo2 = $tempo2. 'selected'; } $tempo2 = $tempo2.'>Take Home</option>
															<option value="Pemberian Soal Langsung"'; if($row['jenis_soal']=="Pemberian Soal Langsung"){ $tempo2 = $tempo2. 'selected';}$tempo2 = $tempo2.'>Pemberian Soal Langsung</option>
														</select>
													</div>
													<div class="form-group">
														<label>Media yang Digunakan</label>
														<input name="media" type="text" class="form-control" value="'. $row['media'] .'" required>
													</div>

													<div class="form-group">
														<label>Jumlah Peserta Hadir</label>
														<input name="jumlah_peserta_hadir" type="number" class="form-control" value="'. $row['jumlah_mahasiswa_hadir'] .'" required>
													</div>

													<div class="form-group">
														<label>Keterangan Ujian</label>
														<select name="ket_pelaksanaan" class="form-control" required>
															<option value=""'; if($row['ket_pelaksanaan']==""){ $tempo2 = $tempo2. 'selected'; } $tempo2 = $tempo2.'>--Pilih--</option>
															<option value="Aman dan Lancar"'; if($row['ket_pelaksanaan']=="Aman dan Lancar"){ $tempo2 = $tempo2. 'selected'; } $tempo2 = $tempo2.'>Aman dan Lancar</option>
															<option value="Ada Kendala"'; if($row['ket_pelaksanaan']=="Ada Kendala"){ $tempo2 = $tempo2. 'selected';} $tempo2 = $tempo2.'>Ada Kendala</option>
														</select>
													</div>
													<div class="form-group">
														<label class="control-label col-xs-3" >FOTO BUKTI <br><i class="text-danger">1. Ekstensi file : jpg / jpeg / png</i></label>
														<div class="col-xs-8">
															<input accept="image/png, image/jpg, image/jpeg, image/PNG, image/JPG, image/JPEG" type="file" name="gambar" class="border-secondary text-dark">
														</div>
													</div>
												</div>
												<div class="modal-footer">
													<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
													<input type="hidden" name="foto_bukti_pengawas2" value="'. $row['foto_bukti_pengawas2'] .'">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
													<button class="btn btn-success">Simpan Perubahan dan Verifikasi</button>
												</div>
											</form>
											</div>
											</div>
										</div>';


					}
				



					$tempo2 = $tempo2.'<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal_detail_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-book"></i> Rincian</a>'.'<div class="modal fade" id="modal_detail_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
											<div class="modal-dialog">
											<div class="modal-content">
											<div class="modal-header bg-info text-white">
												<h3 class="modal-title" id="myModalLabel">Detail Pengawas 2</h3>
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
											</div>
											<form class="form-horizontal" method="post" action="'. base_url().'dosen/permintaan_verifikasi/batal_submit">
												<div class="modal-body">
													<table class="table">
														<tr>
															<td colspan="3" class="text-center bg-warning"><h1>'.$nama_pengawas2.'</h1></td>
														</tr>
														
														<tr class="text-primary">
															<td>Waktu hadir</td>
															<td>:</td>
															<td>'. $row['tanggal_absen_pengawas2'].' '.$row["jam_absen_pengawas2"].'</td>
														</tr>
														<tr class="text-primary">
															<td>Waktu submit</td>
															<td>:</td>
															<td>'. $row['tanggal_submit_pengawas2'].' '.$row['jam_submit_pengawas2'].'</td>
														</tr>
													
														<tr>
															<td>Matakuliah</td>
															<td>:</td>
															<td>'. $row['nama_mk'].'</td>
														</tr>
														<tr>
															<td>Kode ruang</td>
															<td>:</td>
															<td>'. $row['kode_ruang'].'</td>
														</tr>
														<tr>
															<td>Nama kelas</td>
															<td>:</td>
															<td>'. $row['nama_kelas'].'</td>
														</tr>
														<tr>
															<td>Total mahasiswa</td>
															<td>:</td>
															<td>'. $row['jumlah_mahasiswa'].' orang</td>
														</tr>
														
														<tr>
															<td colspan="3"><b>Data yang diinpukan pengawas</b></td>
														</tr>
														<tr>
															<td>Jenis soal</td>
															<td>:</td>
															<td>'. $row['jenis_soal'].'</td>
														</tr>
														<tr>
															<td>Media</td>
															<td>:</td>
															<td>'. $row['media'].'</td>
														</tr>
														<tr>
															<td>Jumlah mahasiswa hadir</td>
															<td>:</td>
															<td>'. $row['jumlah_mahasiswa_hadir'].' orang</td>
														</tr>
														<tr>
															<td>Jumlah mahasiswa alfa</td>
															<td>:</td>
															<td>'. max(($row['jumlah_mahasiswa']-$row['jumlah_mahasiswa_hadir']),0).' orang</td>
														</tr>
														<tr>
															<td>Hasil pelaksanaan</td>
															<td>:</td>
															<td>'. $row['ket_pelaksanaan'].'</td>
														</tr>
														<tr>
															<td colspan="3">Foto bukti mengawas</td>
														</tr>';
																 if($row['foto_bukti_pengawas2']==""){
														$tempo2 = $tempo2.'<tr>
																<td colspan="3"><p class="text-danger">Maaf, Foto bukti belum tersedia!</p></td>
														</tr>';
																 }else{
														$tempo2 = $tempo2.'<tr>
															<td colspan="3"><img width="100%" src="'. base_url('templates/img/bukti-mengawas/').$row['foto_bukti_pengawas2'].'" alt=""></td>
														</tr>';
														
																 }
														$tempo2 = $tempo2.
														
													'</table>
												</div>
												<div class="modal-footer">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
												</div>
											</form>
											</div>
											</div>
										</div>';
					
				
				}
				else{
					$tempo2 = $tempo2.'<div class="text-danger text-center">Pengawas 2 tidak tersedia</div>';
				}

			}else{
				$nama_pengawas2 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo_status2 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo2 = '<div class="text-danger">TIDAK ADA</div>';
			}
			
			$nestedData[] = $nama_pengawas2;

			
													

			$nestedData[] = $tempo_status2;
			$nestedData[] = $tempo2;
			
			$data[] = $nestedData;
		endforeach;
		//----------------------------------------------------------------------------------
		$json_data = array(
					// "draw"            => intval( $requestData['draw'] ),  
					"recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $data );
		//----------------------------------------------------------------------------------
		echo json_encode($json_data);
    }


	function verifikasi1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->verifikasi1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil!
				</div>');
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function verifikasi2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->verifikasi2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function tolak_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->tolak_pengawas1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Tolak berkas berhasil!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function tolak_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->tolak_pengawas2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Tolak berkas berhasil!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function batal_verifikasi_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->batal_verifikasi_pengawas1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function batal_verifikasi_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->batal_verifikasi_pengawas2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function batal_tolak_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->batal_tolak_pengawas1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Penolakan berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function batal_tolak_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_permintaan_verifikasi->batal_tolak_pengawas2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Penolakan berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function edit_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			date_default_timezone_set('Asia/Jakarta');
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$jenis_soal = addslashes ($this->input->post('jenis_soal'));	
			$media = addslashes ($this->input->post('media'));
			$jumlah_peserta_hadir = addslashes ($this->input->post('jumlah_peserta_hadir'));	
			$ket_pelaksanaan = addslashes ($this->input->post('ket_pelaksanaan'));	
			$foto_bukti_pengawas1 = addslashes ($this->input->post('foto_bukti_pengawas1'));	

			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
			$maxsize = 1024 * 200;

			$foto = $_FILES['gambar']['name'];

			// Cek apakah user ingin mengubah fotonya atau tidak
			if(empty($foto)){ // Jika user tidak memilih file foto pada form
				// Lakukan proses update tanpa mengubah fotonya
				// Proses ubah data ke Database
				$this->m_permintaan_verifikasi->edit_pengawas1_nophoto($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data anda berhasil diedit!
							</div>');
				redirect('prodi/permintaan_verifikasi');

			}else{ // Jika user memilih foto / mengisi input file foto pada form
				$pecah = explode(".", $foto);
				$ekstensi = $pecah[1];

				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$fotobaru = date('dmYHis').$foto;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/img/bukti-mengawas/".$fotobaru;
				// Lakukan proses update termasuk mengganti foto sebelumnya
				if (in_array($ekstensi, $extensionList)){
					// memindahkan file ke temporary
					$tmp = $_FILES['gambar']['tmp_name'];

					// Proses upload
					if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
						// Proses simpan ke Database
						if($foto_bukti_pengawas1!=""){
							unlink('templates/img/bukti-mengawas/'.$foto_bukti_pengawas1);
						}
						$this->m_permintaan_verifikasi->edit_pengawas1($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan, $fotobaru);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data anda berhasil diedit!
							</div>');
						redirect('prodi/permintaan_verifikasi');      
					}else{
						// Jika gambar gagal diupload, Lakukan :
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Foto gagal untuk diupload!
								</div>');
						redirect('prodi/permintaan_verifikasi');
					}
					
				}
				else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, file yang diupload bukan file image!
					</div>');
					redirect('prodi/permintaan_verifikasi');
				}	
			}	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}

	function edit_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			date_default_timezone_set('Asia/Jakarta');
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$jam_absen = date('H:i:s');
			$jam_submit = date('H:i:s');
			$jenis_soal = addslashes ($this->input->post('jenis_soal'));	
			$media = addslashes ($this->input->post('media'));	
			$jumlah_peserta_hadir = addslashes ($this->input->post('jumlah_peserta_hadir'));	
			$ket_pelaksanaan = addslashes ($this->input->post('ket_pelaksanaan'));	
			$foto_bukti_pengawas2 = addslashes ($this->input->post('foto_bukti_pengawas2'));	

			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
			$maxsize = 1024 * 200;

			$foto = $_FILES['gambar']['name'];

			// Cek apakah user ingin mengubah fotonya atau tidak
			if(empty($foto)){ // Jika user tidak memilih file foto pada form
				// Lakukan proses update tanpa mengubah fotonya
				// Proses ubah data ke Database
				$this->m_permintaan_verifikasi->edit_pengawas2_nophoto($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data anda berhasil diedit!
							</div>');
				redirect('prodi/permintaan_verifikasi');

			}else{ // Jika user memilih foto / mengisi input file foto pada form
				$pecah = explode(".", $foto);
				$ekstensi = $pecah[1];

				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$fotobaru = date('dmYHis').$foto;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/img/bukti-mengawas/".$fotobaru;
				// Lakukan proses update termasuk mengganti foto sebelumnya
				if (in_array($ekstensi, $extensionList)){
					// memindahkan file ke temporary
					$tmp = $_FILES['gambar']['tmp_name'];

					// Proses upload
					if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
						// Proses simpan ke Database
						if($foto_bukti_pengawas2!=""){
							unlink('templates/img/bukti-mengawas/'.$foto_bukti_pengawas2);
						}
						$this->m_permintaan_verifikasi->edit_pengawas2($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan, $fotobaru);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data anda berhasil diedit!
							</div>');
						redirect('prodi/permintaan_verifikasi');      
					}else{
						// Jika gambar gagal diupload, Lakukan :
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Foto gagal untuk diupload!
								</div>');
						redirect('prodi/permintaan_verifikasi');
					}
					
				}
				else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, file yang diupload bukan file image!
					</div>');
					redirect('prodi/permintaan_verifikasi');
				}	
			}	
		}
		redirect('prodi/permintaan_verifikasi');
		
	}
}

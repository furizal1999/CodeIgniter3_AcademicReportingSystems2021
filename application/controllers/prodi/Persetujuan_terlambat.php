<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Persetujuan_terlambat extends CI_Controller {

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
		$this->load->model('m_persetujuan_terlambat');
	}


	
	public function index()
	{

			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}
			$x['combobox_ujian']=$this->m_persetujuan_terlambat->combobox_ujian();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_persetujuan_terlambat',$x);
			$this->load->view('public/part/footer');
			
			unset($_SESSION['messege']);
			
		

        
		unset($_SESSION['messege']);
	}

	public function get_ajax() {
		date_default_timezone_set('Asia/Jakarta');
      	$sekarang = date("Y-m-d H:i:s");
		$id_ujian = $_SESSION['id_ujian_search'];
        $kode_jurusan = $_SESSION['kode_prodi'];

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

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND

		 	(((status_pengajuan_terlambat_pengawas1 !='' AND jam_pengajuan_terlambat_pengawas1 !='00:00:00' AND file_pengajuan_terlambat_pengawas1 !='' AND tanggal_pengajuan_terlambat_pengawas1 !='0000-00-00') OR (status_pengajuan_terlambat_pengawas2 !='' AND jam_pengajuan_terlambat_pengawas2 !='00:00:00' AND file_pengajuan_terlambat_pengawas2 !='' AND tanggal_pengajuan_terlambat_pengawas2 !='0000-00-00')))

		 	ORDER BY (status_pengajuan_terlambat_pengawas1='Minta Persetujuan' OR status_pengajuan_terlambat_pengawas2='Minta Persetujuan') DESC, (tanggal_pengajuan_terlambat_pengawas1 OR tanggal_pengajuan_terlambat_pengawas2) DESC, (jam_pengajuan_terlambat_pengawas1 OR jam_pengajuan_terlambat_pengawas2) DESC
		";
		$queryAll = $this->m_persetujuan_terlambat->getAllData($sql);

		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		$totalData = $queryAll->num_rows();
		$totalFiltered = $totalData;

		//----------------------------------------------------------------------------------
		$sql = " 
			SELECT * 
        ";

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

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND

		 	(((status_pengajuan_terlambat_pengawas1 !='' AND jam_pengajuan_terlambat_pengawas1 !='00:00:00' AND file_pengajuan_terlambat_pengawas1 !='' AND tanggal_pengajuan_terlambat_pengawas1 !='0000-00-00') OR (status_pengajuan_terlambat_pengawas2 !='' AND jam_pengajuan_terlambat_pengawas2 !='00:00:00' AND file_pengajuan_terlambat_pengawas2 !='' AND tanggal_pengajuan_terlambat_pengawas2 !='0000-00-00')))";
		

		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";    
			$sql.=" OR npk_pengawas1 LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR npk_pengawas2 LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_persetujuan_terlambat->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows();
		// echo $totalFiltered; die();
		// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$sql.=" ORDER BY (status_pengajuan_terlambat_pengawas1='Minta Persetujuan' OR status_pengajuan_terlambat_pengawas2='Minta Persetujuan') DESC, (tanggal_pengajuan_terlambat_pengawas1 OR tanggal_pengajuan_terlambat_pengawas2) DESC, (jam_pengajuan_terlambat_pengawas1 OR jam_pengajuan_terlambat_pengawas2) DESC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_persetujuan_terlambat->getFilteredDataOrderBy($sql);

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
			
			

			$tempo_status1 = '';

			if($row['npk_pengawas1']!=""){
				if($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Minta Persetujuan"){
					$tempo_status1 = $tempo_status1.'<div class="button">Sedang meminta persetujuan</div>';
				}elseif($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Disetujui"){
					$tempo_status1 = $tempo_status1.'<div class="text-success text-center">Disetujui</div>';
				}elseif($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Pengajuan ditolak"){
					$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Pengajuan ditolak</div>';
				}else{
					$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Tidak ada pengajuan apapun</div>';
				}
			}
			else{
				$tempo_status1 = $tempo_status1.'<div class="text-danger text-center">Pengawas 1 tidak tersedia</div>';
			}
													
			

			date_default_timezone_set('Asia/Jakarta');
			// $waktu_awal        =strtotime($row['tanggal_ujian']." ".$row['jam_mulai']);
			// $waktu_akhir    = strtotime(date("Y-m-d H:i:s")); // bisa juga waktu 
			// $diff    =$waktu_akhir - $waktu_awal;
			$tanggal_ujian_time        =strtotime($row['tanggal_ujian']);
			$now_time    = strtotime(date("Y-m-d")); // bisa juga waktu 
			$id_jadwal_lanjutan = $row["id_jadwal_lanjutan"];
			if($row["npk_pengawas1"]!=""){
				$nama_pengawas1 = $this->m_persetujuan_terlambat->nama_pengawas($row['npk_pengawas1']);
				$tempo = '';
			
				
		        
				if($now_time>$tanggal_ujian_time){
					
					
						if($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Minta Persetujuan"){
					
						// $tempo = $tempo. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_persetujuan_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-check"></i> Setujui</a>'.'<div class="modal fade" id="modal_persetujuan_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
						// 				<div class="modal-dialog">
						// 				<div class="modal-content">
						// 				<div class="modal-header bg-success text-white">
						// 					<h3 class="modal-title" id="myModalLabel">Persetujuan Pengawas 1</h3>
						// 					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						// 				</div>
						// 				<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/persetujuan1'.'">
						// 					<div class="modal-body">
						// 						<p>Apakah anda yakin menyetujui permintaan terlambat yang diajukan oleh dosen ini?</p>
						// 					</div>
						// 					<div class="modal-footer">
						// 						<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
						// 						<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
						// 						<button class="btn btn-success">Ya</button>
						// 					</div>
						// 				</form>
						// 				</div>
						// 				</div>
						// 			</div>';



						$tempo = $tempo.'<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modalSetujuiPengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-check-circle"></i> Setujui</a>'.'<div class="modal fade" id="modalSetujuiPengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success text-white">
											<h3 class="modal-title" id="myModalLabel">Setujui</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/tolak_pengajuan_terlambat_pengawas1'.'">
											<div class="modal-body">
												<div class="form-group">
													<p>Apakah anda yakin menyetujui pengajuan terlambat oleh dosen ini? jika ada masukan, silahkan isi kolom masukan di bawah ini. Jika tidak, cukup abaikan.</p>
												</div>
												<div class="form-group">
													<label>Masukan <i>(Optional)</i></label>
													<textarea class="form-control" name="alasan_penolakan"></textarea>
												</div>
												
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
						
					
						}elseif($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Disetujui"){
					
						$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_persetujuan_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Persetujuan</a>'.'<div class="modal fade" id="modal_batal_persetujuan_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Persetujuan Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_persetujuan_pengawas1'.'">
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
						
					
						}elseif($row['jam_pengajuan_terlambat_pengawas1']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas1']=="Pengajuan ditolak"){
					
						$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_tolak_pengajuan_terlambat_pengawas1'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Tolak</a>'.'<div class="modal fade" id="modal_batal_tolak_pengajuan_terlambat_pengawas1'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengajuan Pengawas 1</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_tolak_pengajuan_terlambat_pengawas1'.'">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan penolakan pengajuan?</p>
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


				}


				if($row['file_pengajuan_terlambat_pengawas1']!=""){
					
				$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_lihat_alasan'. $id_jadwal_lanjutan.'"><i class="fa fa-eye"></i> Lihat Alasan</a>'.'<div class="modal fade" id="modal_lihat_alasan'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Alasan Terlambat</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_tolak_pengajuan_terlambat_pengawas1'.'">
											<div class="modal-body">
												Alasan : <b>'.$row["file_pengajuan_terlambat_pengawas1"].'</b>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
												<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
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
										<form class="form-horizontal" method="post" action="'. base_url().'dosen/persetujuan_terlambat/batal_submit">
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
				$nama_pengawas1 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo_status1 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo = '<div class="text-danger">TIDAK ADA</div>';
			}


		   							












			$tempo_status2 = '';

			if($row['npk_pengawas2']!=""){
				if($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Minta Persetujuan"){
					$tempo_status2 = $tempo_status2.'<div class="button">Sedang meminta persetujuan</div>';
				}elseif($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Disetujui"){
					$tempo_status2 = $tempo_status2.'<div class="text-success text-center">Disetujui</div>';
				}elseif($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Pengajuan ditolak"){
					$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Pengajuan ditolak</div>';
				}else{
					$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Tidak ada pengajuan apapun</div>';
				}
			}
			else{
				$tempo_status2 = $tempo_status2.'<div class="text-danger text-center">Pengawas 1 tidak tersedia</div>';
			}
													
			

			date_default_timezone_set('Asia/Jakarta');
			$waktu_awal        =strtotime($row['tanggal_ujian']." ".$row['jam_mulai']);
			$waktu_akhir    = strtotime(date("Y-m-d H:i:s")); // bisa juga waktu 
			$diff    =$waktu_akhir - $waktu_awal;
			$id_jadwal_lanjutan = $row["id_jadwal_lanjutan"];
			if($row["npk_pengawas2"]!=""){
				$nama_pengawas2 = $this->m_persetujuan_terlambat->nama_pengawas($row['npk_pengawas2']);
				$tempo2 = '';
			
				
		        
				if($now_time>$tanggal_ujian_time){
					
					
						if($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Minta Persetujuan"){
					
						$tempo2 = $tempo2. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_persetujuan_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-check"></i> Setujui</a>'.'<div class="modal fade" id="modal_persetujuan_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-success text-white">
											<h3 class="modal-title" id="myModalLabel">Persetujuan Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/persetujuan2'.'">
											<div class="modal-body">
												<p>Apakah anda yakin menyetujui permintaan terlambat yang diajukan oleh dosen ini?</p>
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



						$tempo2 = $tempo2.'<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_tolak_pengajuan_terlambat_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Tolak</a>'.'<div class="modal fade" id="modal_tolak_pengajuan_terlambat_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-danger text-white">
											<h3 class="modal-title" id="myModalLabel">Tolak Pengajuan Terlambat Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/tolak_pengajuan_terlambat_pengawas2'.'">
											<div class="modal-body">
												<div class="form-group">
													<p>Apakah anda yakin menolak pengajuan terlambat oleh dosen ini? jika yakin, silahkan isi alasan dibawah ini untuk disampaikan kepada pengawas bersangkutan.</p>
												</div>
												<div class="form-group">
													<label>Alasan Penolakan</label>
													<textarea class="form-control" name="alasan_penolakan" required></textarea>
												</div>
												
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
						
					
						}elseif($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Disetujui"){
					
						$tempo2 = $tempo2.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_persetujuan_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Persetujuan</a>'.'<div class="modal fade" id="modal_batal_persetujuan_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Persetujuan Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_persetujuan_pengawas2'.'">
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
						
					
						}elseif($row['jam_pengajuan_terlambat_pengawas2']!="00:00:00" && $row['status_pengajuan_terlambat_pengawas2']=="Pengajuan ditolak"){
					
						$tempo2 = $tempo2.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_tolak_pengajuan_terlambat_pengawas2'. $id_jadwal_lanjutan.'"><i class="fa fa-shield-alt"></i> Batal Tolak</a>'.'<div class="modal fade" id="modal_batal_tolak_pengajuan_terlambat_pengawas2'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
										<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header bg-warning text-white">
											<h3 class="modal-title" id="myModalLabel">Batal Tolak Pengajuan Pengawas 2</h3>
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
										</div>
										<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_tolak_pengajuan_terlambat_pengawas2'.'">
											<div class="modal-body">
												<p>Apakah anda yakin membatalkan penolakan pengajuan?</p>
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


				}


				if($row['file_pengajuan_terlambat_pengawas2']!=""){
					
				$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_lihat_alasan'. $id_jadwal_lanjutan.'"><i class="fa fa-eye"></i> Lihat Alasan</a>'.'<div class="modal fade" id="modal_lihat_alasan'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-warning text-white">
									<h3 class="modal-title" id="myModalLabel">Alasan Terlambat</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="'. base_url().'prodi/persetujuan_terlambat/batal_tolak_pengajuan_terlambat_pengawas1'.'">
									<div class="modal-body">
										Alasan : <b>'.$row["file_pengajuan_terlambat_pengawas2"].'</b>
									</div>
									<div class="modal-footer">
										<input type="hidden" name="id_jadwal_lanjutan" value="'. $id_jadwal_lanjutan.'">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
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
										<form class="form-horizontal" method="post" action="'. base_url().'dosen/persetujuan_terlambat/batal_submit">
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
				$nama_pengawas2 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo_status2 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo2 = '<div class="text-danger">TIDAK ADA</div>';
			}

			$nestedData[] = $nama_pengawas1;
			$nestedData[] = $tempo_status1;
			$nestedData[] = $tempo;
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


	function persetujuan1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->persetujuan1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil!
				</div>');
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function tolak_pengajuan_terlambat_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			$alasan_penolakan = addslashes ($this->input->post('alasan_penolakan'));
			$this->m_persetujuan_terlambat->tolak_pengajuan_terlambat_pengawas1($id_jadwal_lanjutan, $alasan_penolakan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Tolak pengajuan terlambat telah berhasil!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function batal_persetujuan_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->batal_persetujuan_pengawas1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function batal_tolak_pengajuan_terlambat_pengawas1(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->batal_tolak_pengajuan_terlambat_pengawas1($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Penolakan berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}



	function persetujuan2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->persetujuan2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil!
				</div>');
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function tolak_pengajuan_terlambat_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			$alasan_penolakan = addslashes ($this->input->post('alasan_penolakan'));
			$this->m_persetujuan_terlambat->tolak_pengajuan_terlambat_pengawas2($id_jadwal_lanjutan, $alasan_penolakan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Tolak pengajuan terlambat telah berhasil!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function batal_persetujuan_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->batal_persetujuan_pengawas2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}

	function batal_tolak_pengajuan_terlambat_pengawas2(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));	
			$this->m_persetujuan_terlambat->batal_tolak_pengajuan_terlambat_pengawas2($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Penolakan berhasil dibatalkan!
				</div>');	
		}
		redirect('prodi/persetujuan_terlambat');
		
	}
}

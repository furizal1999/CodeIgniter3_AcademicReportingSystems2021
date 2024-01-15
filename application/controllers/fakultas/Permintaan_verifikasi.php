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
			if(strcmp($_SESSION["status_login"], 'Fakultas')!==0 ){
				//tidak dibolehkan
				
				redirect('welcome');
				
			}else{
				if($_SESSION['jabatan']!='Dekan'){
					redirect('halaman_tamu');
				}
				//dibolehkan
			}
		}
		$this->load->model('m_permintaan_verifikasi');
	}


	
	public function index()
	{
		
			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}

			$x['combobox_ujian'] = $this->m_permintaan_verifikasi->combobox_ujian();
			$x['combobox_prodi'] = $this->m_permintaan_verifikasi->combobox_prodi();
			
			// $kode_prodi = $_SESSION['kode_prodi'];
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('fakultas/v_permintaan_verifikasi', $x);
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
			$waktu_awal        =strtotime($row['tanggal_ujian']." ".$row['jam_mulai']);
			$waktu_akhir    = strtotime(date("Y-m-d H:i:s")); // bisa juga waktu 
			$diff    =$waktu_akhir - $waktu_awal;
			$id_jadwal_lanjutan = $row["id_jadwal_lanjutan"];
			



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

				
				

			}else{
				$nama_pengawas2 = '<div class="text-danger">TIDAK ADA</div>';
				$tempo_status2 = '<div class="text-danger">TIDAK ADA</div>';
			}




			$aksi_tempo="";
			if($diff>=259200){
					
						
				if($row['status_verifikasi_pengawas1']=="Terverifikasi" || $row['status_verifikasi_pengawas2']=="Terverifikasi"){
					if($this->m_permintaan_verifikasi->cekTtdDekan($row['id_jadwal_lanjutan'])<=0){
				$aksi_tempo = $aksi_tempo. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#insert_ttd_dekan'. $id_jadwal_lanjutan.'"><i class="fa fa-pen"></i> Tandatangani</a>'.'<div class="modal fade" id="insert_ttd_dekan'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-success text-white">
									<h3 class="modal-title" id="myModalLabel">Verifikasi Pengawas 2</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="'. base_url().'fakultas/permintaan_verifikasi/insert_ttd_dekan'.'">
									<div class="modal-body">
										<input type="hidden" name="id_jadwal_lanjutan" value="'.$row['id_jadwal_lanjutan'].'">
										<input type="hidden" name="semester" value="'.$row['semester'].'">
										<input type="hidden" name="tahun_ajaran" value="'.$row['tahun_ajaran'].'">
										<input type="hidden" name="nama_mk" value="'.$row['nama_mk'].'">
										<input type="hidden" name="nama_kelas" value="'.$row['nama_kelas'].'">
										<input type="hidden" name="nama_ujian" value="'.$row['nama_ujian'].'">

										<p>Apakah anda yakin menandatangi berita acara ini?</p>
									</div>
									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
										<button class="btn btn-success" name="insert_ttd_dekan" >Ya</button>
									</div>
								</form>
								</div>
								</div>
							</div>';
				
					}
				}
			}
		



			$aksi_tempo = $aksi_tempo.'<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modalDetail'. $id_jadwal_lanjutan.'"><i class="fa fa-book"></i> Rincian</a>'.'<div class="modal fade" id="modalDetail'. $id_jadwal_lanjutan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-info text-white">
										<h3 class="modal-title" id="myModalLabel">Detail</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="'. base_url().'dosen/permintaan_verifikasi/batal_submit">
										<div class="modal-body">
											<table class="table">
												<tr>
													<td colspan="3" class="text-center bg-warning"><h1>'.$nama_pengawas1.'</h1></td>
												</tr>
												<tr>
													<td colspan="3" class="text-center bg-warning"><h1>'.$nama_pengawas2.'</h1></td>
												</tr>
												
												<tr class="text-primary">
													<td>Waktu hadir Pengawas 1</td>
													<td>:</td>
													<td>'. $row['tanggal_absen_pengawas1'].' '.$row["jam_absen_pengawas1"].'</td>
												</tr>
												<tr class="text-primary">
													<td>Waktu submit Pengawas 1</td>
													<td>:</td>
													<td>'. $row['tanggal_submit_pengawas1'].' '.$row['jam_submit_pengawas1'].'</td>
												</tr>
												<tr class="text-primary">
													<td>Waktu hadir Pengawas 2</td>
													<td>:</td>
													<td>'. $row['tanggal_absen_pengawas2'].' '.$row["jam_absen_pengawas2"].'</td>
												</tr>
												<tr class="text-primary">
													<td>Waktu submit Pengawas 2</td>
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
														 if($row['foto_bukti_pengawas1']==""){
												$aksi_tempo = $aksi_tempo.'<tr>
														<td colspan="3"><p class="text-danger">Maaf, Foto bukti pengawas 1 belum tersedia!</p></td>
												</tr>';
														 }else{
												$aksi_tempo = $aksi_tempo.'<tr>
													<td colspan="3"><img width="100%" src="'. base_url('templates/img/bukti-mengawas/').$row['foto_bukti_pengawas1'].'" alt=""></td>
												</tr>';
														}


														  if($row['foto_bukti_pengawas2']==""){
												$aksi_tempo = $aksi_tempo.'<tr>
														<td colspan="3"><p class="text-danger">Maaf, Foto bukti pengawas 2 belum tersedia!</p></td>
												</tr>';
														 }else{
												$aksi_tempo = $aksi_tempo.'<tr>
													<td colspan="3"><img width="100%" src="'. base_url('templates/img/bukti-mengawas/').$row['foto_bukti_pengawas2'].'" alt=""></td>
												</tr>';
												
														 }
												$aksi_tempo = $aksi_tempo.
												
											'</table>
										</div>
										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										</div>
									</form>
									</div>
									</div>
								</div>';
			
			$nestedData[] = $nama_pengawas2;

			
													

			$nestedData[] = $tempo_status2;
			$nestedData[] = $aksi_tempo;
			
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


	function insert_ttd_dekan(){
   	if(isset($_POST['insert_ttd_dekan'])){
		$id_jadwal_lanjutan = $_POST['id_jadwal_lanjutan'];
    	$tahun_ajaran = $_POST['tahun_ajaran'];
    	$semester = $_POST['semester'];
    	$nama_mk = $_POST['nama_mk'];
    	$nama_kelas = $_POST['nama_kelas'];

    	if($semester%2==1){
			$semester = 'Ganjil';
		}elseif($semester%2==0){
			$semester = 'Genap';
		}elseif($semester=="Ganjil"){
			$semester = 'Ganjil';
		}elseif($semester=="Genap"){
			$semester = 'Genap';
		}else{
			$semester = "Ganjil dan Genap";
		}


    	if($this->m_permintaan_verifikasi->insert_ttd_dekan($id_jadwal_lanjutan, $tahun_ajaran, $semester, $nama_mk, $nama_kelas)){
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Berita acara pengawas ujian berhasil ditandatangani!
				</div>');
			redirect('fakultas/permintaan_verifikasi');
		}else{
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Berita acara pengawas ujian gagal ditandatangani!
				</div>');
			redirect('fakultas/permintaan_verifikasi');
		}

   	}else{
   		redirect('fakultas/permintaan_verifikasi');
   	}
    	
   }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Permintaan_verifikasi_pertemuan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				//dibolehkan
			}
		}
		$this->load->model('m_permintaan_verifikasi_pertemuan');
	}



	public function index()
	{


			if(isset($_POST['tombol_cari_pertemuan'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}

			$x['combobox_pertemuan']=$this->m_permintaan_verifikasi_pertemuan->combobox_pertemuan();
			$x['combobox_prodi']=$this->m_permintaan_verifikasi_pertemuan->combobox_prodi();
			
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_permintaan_verifikasi_pertemuan', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
	}

	public function get_ajax() {
		date_default_timezone_set('Asia/Jakarta');
      	$sekarang = date("Y-m-d H:i:s");
		// $id_pertemuan = $_SESSION['id_pertemuan_search'];
        $kode_jurusan = $_SESSION['kode_prodi'];
        $id_pertemuan = $_SESSION['id_pertemuan_search'];

		$requestData= $_REQUEST;
		$columns = array(
			// 0 =>'nama_dosen',
			0 =>'nama_mk',
			1 =>'nama_kelas',
			2 =>'status_verifikasi',
			// 0 =>'id_presensi_pertemuan',
			// 0 =>'id_presensi_pertemuan',
		);




		$sql = " SELECT *";
		$sql.= 	"

			FROM
			tb_tahun_ajaran,
			tb_semester,
			tb_pertemuan,
			tb_jadwal_pengampu,
			tb_prodi,
			tb_matkul,
			tb_jadwal_kelas_pertemuan,
            tb_presensi_pertemuan

			WHERE
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND
			tb_semester.id_semester = tb_pertemuan.id_semester AND
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_presensi_pertemuan.id_jadwal_kelas_pertemuan AND

			tb_tahun_ajaran.status='Tersedia' AND
			tb_semester.status = 'Tersedia' AND
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_presensi_pertemuan.status = 'Tersedia' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY
            tb_presensi_pertemuan.status_verifikasi='Minta Verifikasi' DESC,
            tb_matkul.nama_mk ASC,
            tb_jadwal_kelas_pertemuan.nama_kelas ASC


				";
		$queryAll = $this->m_permintaan_verifikasi_pertemuan->getAllData($sql);

		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		$totalData = $queryAll->num_rows();
		$totalFiltered = $totalData;

		//----------------------------------------------------------------------------------
		$sql = " SELECT *";
		$sql.= " 	FROM
					tb_tahun_ajaran,
					tb_semester,
					tb_pertemuan,
					tb_jadwal_pengampu,
					tb_prodi,
					tb_matkul,
					tb_jadwal_kelas_pertemuan,
		            tb_presensi_pertemuan
	            ";
		$sql.= " 	WHERE
					tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND
					tb_semester.id_semester = tb_pertemuan.id_semester AND
					tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
					tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
					tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
					tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
					tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
		            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_presensi_pertemuan.id_jadwal_kelas_pertemuan AND

					tb_tahun_ajaran.status='Tersedia' AND
					tb_semester.status = 'Tersedia' AND
					tb_pertemuan.status='Tersedia' AND
					tb_jadwal_pengampu.status='Tersedia' AND
					tb_prodi.status = 'Tersedia' AND
					tb_matkul.status = 'Tersedia' AND
					tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
		            tb_presensi_pertemuan.status = 'Tersedia' AND
					tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
					tb_prodi.kode_prodi = '$kode_jurusan'
				";


		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR nama_kelas LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR status_verifikasi LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_permintaan_verifikasi_pertemuan->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows();

		$sql.=" ORDER BY
	            tb_presensi_pertemuan.status_verifikasi='Minta Verifikasi' DESC,
	            tb_matkul.nama_mk ASC,
	            tb_jadwal_kelas_pertemuan.nama_kelas ASC,
 				". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_permintaan_verifikasi_pertemuan->getFilteredDataOrderBy($sql);

		$_SESSION['order_column'] = $columns[$requestData['order'][0]['column']];
		$_SESSION['order_dir'] = $requestData['order'][0]['dir'];
		$_SESSION['start'] = $requestData['start'];
		$_SESSION['length'] = $requestData['length'];


		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		//----------------------------------------------------------------------------------
		$data = array();
		$no = 1;

		foreach($queryOrderBy->result_array() as $row):
			$nestedData=array();
			$nestedData[] = $no++;
			$nestedData[] = $this->m_permintaan_verifikasi_pertemuan->getNamaDosen($row["dosen_penginput_presensi"]);
			$nestedData[] = $row["nama_mk"];
			$nestedData[] = $row["nama_kelas"];
			$nestedData[] = $row["pertemuan_ke"];

			$tempo_SVP = '';

			if($row['status_verifikasi']=="Minta Verifikasi"){
				$tempo_SVP = $tempo_SVP.'<div class="button text-danger">Minta verifikasi</div>';
			}elseif($row['status_verifikasi']=="Terverifikasi"){
				$tempo_SVP = $tempo_SVP.'<div class="text-success text-center">Terverifikasi</div>';
			}elseif($row['status_verifikasi']=="Ditolak"){
				$tempo_SVP = $tempo_SVP.'<div class="text-danger text-center">Ditolak</div>';
			}else{
				$tempo_SVP = $tempo_SVP.'<div class="text-danger text-center">-</div>';
			}


			$tempo = '';

			if( $row['status_verifikasi']=="Minta Verifikasi"){

				$tempo = $tempo. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_verifikasi_pertemuan'. $row["id_presensi_pertemuan"].'"><i class="fa fa-check"></i> Verifikasi</a>'.'<div class="modal fade" id="modal_verifikasi_pertemuan'. $row["id_presensi_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-success text-white">
								<h3 class="modal-title" id="myModalLabel">Verifikasi Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'tu/permintaan_verifikasi_pertemuan/verifikasi_pertemuan'.'">
								<div class="modal-body">
									<p>Apakah anda yakin memverifikasi laporan pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_verifikasi_pertemuan->getNamaDosen($row["dosen_penginput_presensi"]).' ?</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_presensi_pertemuan" value="'. $row["id_presensi_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-success">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';

				$tempo = $tempo.'<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_tolak_pertemuan'. $row["id_presensi_pertemuan"].'"><i class="fa fa-shield-alt"></i> Tolak</a>'.'<div class="modal fade" id="modal_tolak_pertemuan'. $row["id_presensi_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-danger text-white">
								<h3 class="modal-title" id="myModalLabel">Tolak Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'tu/permintaan_verifikasi_pertemuan/tolak_pertemuan'.'">
								<div class="modal-body">
									<p>Apakah anda yakin menolak laporan pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_verifikasi_pertemuan->getNamaDosen($row["dosen_penginput_presensi"]).' ?</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_presensi_pertemuan" value="'. $row["id_presensi_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-danger">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';

			}
			elseif( $row['status_verifikasi']=="Terverifikasi"){

				$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_verifikasi_pertemuan'. $row["id_presensi_pertemuan"].'"><i class="fa fa-shield-alt"></i> Batal Verifikasi</a>'.'<div class="modal fade" id="modal_batal_verifikasi_pertemuan'. $row["id_presensi_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-warning text-white">
								<h3 class="modal-title" id="myModalLabel">Batal Verifikasi Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'tu/permintaan_verifikasi_pertemuan/batal_verifikasi_pertemuan'.'">
								<div class="modal-body">
									<p>Apakah anda yakin membatalkan verifikasi laporan pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_verifikasi_pertemuan->getNamaDosen($row["dosen_penginput_presensi"]).' ?</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_presensi_pertemuan" value="'. $row["id_presensi_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-warning">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';

			}elseif( $row['status_verifikasi']=="Ditolak"){

				$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_batal_tolak_pertemuan'. $row["id_presensi_pertemuan"].'"><i class="fa fa-shield-alt"></i> Batal Tolak</a>'.'<div class="modal fade" id="modal_batal_tolak_pertemuan'. $row["id_presensi_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-warning text-white">
								<h3 class="modal-title" id="myModalLabel">Batal Tolak Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'tu/permintaan_verifikasi_pertemuan/batal_tolak_petemuan'.'">
								<div class="modal-body">
									<p>Apakah anda yakin membatalkan penolakan laporan pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_verifikasi_pertemuan->getNamaDosen($row["dosen_penginput_presensi"]).' ?</p>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_presensi_pertemuan" value="'. $row["id_presensi_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-warning">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';


			}else{
				echo '<div class="text-danger text-center">NO ACTION</div>';
			}


			$tempo = $tempo.'<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal_detail_pertemuan'. $row["id_presensi_pertemuan"].'"><i class="fa fa-book"></i> Rincian</a>'.'<div class="modal fade" id="modal_detail_pertemuan'. $row["id_presensi_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-info text-white">
							<h3 class="modal-title" id="myModalLabel">Detail Pertemuan</h3>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						</div>
						<form class="form-horizontal" method="post" action="'. base_url().'tu/permintaan_verifikasi_pertemuan/batal_submit">
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<label>Pertemuan Ke</label><br>
										<h3><b>'.$row["pertemuan_ke"].'</b></h3>
									</div>';
									if($row["jenis_pertemuan"]=="Online"){
						$tempo = $tempo.'<div class="col-md-6">
											<label>Media</label><br>
											<h3><b>'.$row["media_pertemuan"].'</b></h3>
										</div>';
									}else{
						$tempo = $tempo.'<div class="col-md-6">
											<label>Ruang</label><br>
											<h3><b>'. $row["kode_ruang"].'</b></h3>
										</div>';
									}
				$tempo = $tempo.'</div>
								<div class="row">
									<div class="col-md-6">
										<label>Waktu Pertemuan</label><br>
										<h3><b>'. $row["waktu_pertemuan"].'</b></h3>
									</div>
									<div class="col-md-6">
										<label>Waktu Input</label><br>
										<h3><b>'. $row["waktu_input"].'</b></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Status verifikasi</label><br>
										<h3><b>'. $row["status_verifikasi"].'</b></h3>
									</div>
									<div class="col-md-6">
										<label>Jumlah Mahasiswa Hadir</label><br>
										<h3><b>'. $row["mhs_hadir"].'</b></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Materi</label><br>
										<h3><b>'. $row["materi_pertemuan"].'</b></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Metode Pembelajaran</label><br>
										<h3><b>'. $row["metode_pertemuan"].'</b></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Foto Bukti pertemuan</label><br>';
										if($row["foto_pertemuan"]==""){
							$tempo = $tempo.'<p class="text-danger">Maaf foto bukti pertemuan belum tersedia..</p>';
										}else{
							$tempo = $tempo.'<img width="100%" src="'. base_url("templates/img/bukti-pertemuan/".$row["foto_pertemuan"]).'">';
										}
							$tempo = $tempo.'</div>
								</div>


							</div>
							<div class="modal-footer">
								<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
							</div>
						</form>
					</div>
				</div>
			</div>';


			$nestedData[] = $tempo_SVP;
			$nestedData[] = $tempo;
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


	function verifikasi_pertemuan(){
		if(isset($_POST['id_presensi_pertemuan'])){
			$id_presensi_pertemuan = addslashes ($this->input->post('id_presensi_pertemuan'));
			if($this->m_permintaan_verifikasi_pertemuan->verifikasi_pertemuan($id_presensi_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Verifikasi pertemuan berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, verifikasi pertemuan gagal!
					</div>');
			}

		}
		redirect('tu/permintaan_verifikasi_pertemuan');

	}


	function tolak_pertemuan(){
		if(isset($_POST['id_presensi_pertemuan'])){
			$id_presensi_pertemuan = addslashes ($this->input->post('id_presensi_pertemuan'));


			if($this->m_permintaan_verifikasi_pertemuan->tolak_pertemuan($id_presensi_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Tolak pertemuan berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, tolak pertemuan gagal!
					</div>');
			}
		}
		redirect('tu/permintaan_verifikasi_pertemuan');

	}


	function batal_verifikasi_pertemuan(){
		if(isset($_POST['id_presensi_pertemuan'])){
			$id_presensi_pertemuan = addslashes ($this->input->post('id_presensi_pertemuan'));

			if($this->m_permintaan_verifikasi_pertemuan->batal_verifikasi_pertemuan($id_presensi_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Batal verifikasi pertemuan berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, batal verifikasi pertemuan gagal!
					</div>');
			}
		}
		redirect('tu/permintaan_verifikasi_pertemuan');

	}


	function batal_tolak_petemuan(){
		if(isset($_POST['id_presensi_pertemuan'])){
			$id_presensi_pertemuan = addslashes ($this->input->post('id_presensi_pertemuan'));

			if($this->m_permintaan_verifikasi_pertemuan->batal_tolak_petemuan($id_presensi_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Batal penolakan pertemuan berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, batal penolakan pertemuan gagal!
					</div>');
			}
		}
		redirect('tu/permintaan_verifikasi_pertemuan');

	}



}

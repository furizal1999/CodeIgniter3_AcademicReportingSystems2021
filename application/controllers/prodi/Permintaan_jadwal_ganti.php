<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Permintaan_jadwal_ganti extends CI_Controller {

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
		$this->load->model('m_permintaan_jadwal_ganti');
	}


	
	public function index()
	{
		
			
			if(isset($_POST['tombol_cari_pertemuan'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
			}
			
			$x['combobox_pertemuan']=$this->m_permintaan_jadwal_ganti->combobox_pertemuan();
			$kode_prodi = $_SESSION['kode_prodi'];
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_permintaan_jadwal_ganti', $x);
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
			2 =>'status_request_pertemuan',
			// 0 =>'id_request_pertemuan',
			// 0 =>'id_request_pertemuan',
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
            tb_request_pertemuan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_request_pertemuan.id_jadwal_kelas_pertemuan AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_request_pertemuan.status = 'Tersedia' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY 
            tb_request_pertemuan.status_request_pertemuan='Minta Persetujuan' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
				";
		$queryAll = $this->m_permintaan_jadwal_ganti->getAllData($sql);

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
		            tb_request_pertemuan
	            ";
		$sql.= " 	WHERE 
					tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
					tb_semester.id_semester = tb_pertemuan.id_semester AND 
					tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
					tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
					tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
					tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
					tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
		            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_request_pertemuan.id_jadwal_kelas_pertemuan AND

					tb_tahun_ajaran.status='Tersedia' AND 
					tb_semester.status = 'Tersedia' AND 
					tb_pertemuan.status='Tersedia' AND
					tb_jadwal_pengampu.status='Tersedia' AND
					tb_prodi.status = 'Tersedia' AND
					tb_matkul.status = 'Tersedia' AND
					tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
		            tb_request_pertemuan.status = 'Tersedia' AND
					tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
					tb_prodi.kode_prodi = '$kode_jurusan'
				";
		

		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";  
			$sql.=" OR nama_kelas LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR status_request_pertemuan LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_permintaan_jadwal_ganti->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows(); 

		$sql.=" ORDER BY 
	            tb_request_pertemuan.status_request_pertemuan='Minta Persetujuan' DESC,
	            tb_matkul.nama_mk ASC, 
	            tb_jadwal_kelas_pertemuan.nama_kelas ASC,
 				". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_permintaan_jadwal_ganti->getFilteredDataOrderBy($sql);

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
			$nestedData[] = $this->m_permintaan_jadwal_ganti->getNamaDosen($row["dosen_penginput_request"]);
			$nestedData[] = $row["nama_mk"];
			$nestedData[] = $row["nama_kelas"];
			$nestedData[] = $row["pertemuan_ke"];

			$tempo_SVP = '';

			if($row['status_request_pertemuan']=="Minta Persetujuan"){
				$tempo_SVP = $tempo_SVP.'<div class="button text-danger">Minta Persetujuan</div>';
			}elseif($row['status_request_pertemuan']=="Disetujui"){
				$tempo_SVP = $tempo_SVP.'<div class="text-success text-center">Disetujui</div>';
			}elseif($row['status_request_pertemuan']=="Ditolak"){
				$tempo_SVP = $tempo_SVP.'<div class="text-danger text-center">Ditolak</div>';
			}else{
				$tempo_SVP = $tempo_SVP.'<div class="text-danger text-center">-</div>';
			}
			
			
			$tempo = '';
		
			if( $row['status_request_pertemuan']=="Minta Persetujuan"){
		
				$tempo = $tempo. '<a class="btn btn-sm btn-success text-white" data-toggle="modal" data-target="#modal_setujui_jadwal_ganti'. $row["id_request_pertemuan"].'"><i class="fa fa-check"></i> Setujui</a>'.'<div class="modal fade" id="modal_setujui_jadwal_ganti'. $row["id_request_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-success text-white">
								<h3 class="modal-title" id="myModalLabel">Persetujuan Jadwal Ganti</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_jadwal_ganti/setujui_ganti_jadwal'.'">
								<div class="modal-body">
									<p>Apakah anda yakin menyetujui permintaan ganti jadwal pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_jadwal_ganti->getNamaDosen($row["dosen_penginput_request"]).' ?</p>
									
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_request_pertemuan" value="'. $row["id_request_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-success">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';

				$tempo = $tempo.'<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal_tolak_jadwal_ganti'. $row["id_request_pertemuan"].'"><i class="fa fa-shield-alt"></i> Tolak</a>'.'<div class="modal fade" id="modal_tolak_jadwal_ganti'. $row["id_request_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-danger text-white">
								<h3 class="modal-title" id="myModalLabel">Tolak Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_jadwal_ganti/tolak_jadwal_ganti'.'">
								<div class="modal-body">
									<p>Apakah anda yakin menolak permintaan ganti jadwal pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_jadwal_ganti->getNamaDosen($row["dosen_penginput_request"]).' ?</p>
									
									<label>Sertakan Alasan Penolakan :</label>
									<textarea class="form-control" name="alasan_penolakan" required></textarea>
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_request_pertemuan" value="'. $row["id_request_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-danger">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';
		
			}
			elseif( $row['status_request_pertemuan']=="Disetujui" || $row['status_request_pertemuan']=="Ditolak"){
		
				$tempo = $tempo.'<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#batal'. $row["id_request_pertemuan"].'"><i class="fa fa-shield-alt"></i> Batal</a>'.'<div class="modal fade" id="batal'. $row["id_request_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header bg-warning text-white">
								<h3 class="modal-title" id="myModalLabel">Tolak Pertemuan</h3>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							</div>
							<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_jadwal_ganti/batal_respon'.'">
								<div class="modal-body">
									<p>Apakah anda yakin membatalkan respon ganti jadwal pertemuan ke-'.$row["pertemuan_ke"].' matakuliah '.$row["nama_mk"].' oleh '.$this->m_permintaan_jadwal_ganti->getNamaDosen($row["dosen_penginput_request"]).' ?</p>
																		
								</div>
								<div class="modal-footer">
									<input type="hidden" name="id_request_pertemuan" value="'. $row["id_request_pertemuan"].'">
									<button class="btn" data-dismiss="modal" aria-hidden="true">Tidak</button>
									<button class="btn btn-warning">Ya</button>
								</div>
							</form>
						</div>
					</div>
				</div>';
		
			}else{
				$tempo = $tempo.''; 
			}
					

			$tempo = $tempo.'<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modal_detail_jadwal_ganti'. $row["id_request_pertemuan"].'"><i class="fa fa-book"></i> Rincian</a>'.'<div class="modal fade" id="modal_detail_jadwal_ganti'. $row["id_request_pertemuan"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-info text-white">
							<h3 class="modal-title" id="myModalLabel">Detail Jadwal Ganti</h3>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						</div>
						<form class="form-horizontal" method="post" action="'. base_url().'prodi/permintaan_jadwal_ganti/batal_submit">
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<label>Pertemuan Ke</label><br>
										<h3><b>'.$row["pertemuan_ke"].'</b></h3>
									</div>
									<div class="col-md-6">
										<label>Status persetujuan</label><br>
										<h3><b class="text-warning">'. $row["status_request_pertemuan"].'</b></h3>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label>Waktu Pengajuan</label><br>
										<h3><b>'. $row["waktu_input_request_pertemuan"].'</b></h3>
									</div>
									
								</div>
								<div class="row">
									<div class="col-md-4">
										<label>Tanggal yang diajukan</label><br>
										<h3><b>'. date("Y-m-d", strtotime($row["waktu_request_pertemuan"])).'</b></h3>
									</div>
									<div class="col-md-4">
										<label>Jam mulai</label><br>
										<h3><b class="text-success">'.date("H:i:s", strtotime($row["waktu_request_pertemuan"])).'</b></h3>
									</div>
									<div class="col-md-4">
										<label>Jam Selesai </label><br>
										<h3><b class="text-danger">'. date("H:i:s", strtotime($row["waktu_request_pertemuan_selesai"])).'</b></h3>
									</div>
								</div>
								
								<div class="row">
									
									<div class="col-md-12">
										<label>Alasan pengajuan ganti jadwal</label><br>
										<h3><b>'. $row["alasan_request_pertemuan"].'</b></h3>
									</div>
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


	function setujui_ganti_jadwal(){
		if(isset($_POST['id_request_pertemuan'])){
			$id_request_pertemuan = addslashes ($this->input->post('id_request_pertemuan'));	
			if($this->m_permintaan_jadwal_ganti->setujui_ganti_jadwal($id_request_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Penyetujuan permintaan Jadwal Ganti berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, penyetujuan permintaan Jadwal Ganti gagal!
					</div>');
			}
			
		}
		redirect('prodi/permintaan_jadwal_ganti');
		
	}


	function tolak_jadwal_ganti(){
		if(isset($_POST['id_request_pertemuan'])){
			$id_request_pertemuan = addslashes ($this->input->post('id_request_pertemuan'));	
			$alasan_penolakan = addslashes ($this->input->post('alasan_penolakan'));
			

			if($this->m_permintaan_jadwal_ganti->tolak_jadwal_ganti($id_request_pertemuan, $alasan_penolakan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Tolak permintaan jadwal ganti berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, tolak permintaan jadwal ganti gagal!
					</div>');
			}	
		}
		redirect('prodi/permintaan_jadwal_ganti');
		
	}

	function batal_respon(){
		if(isset($_POST['id_request_pertemuan'])){
			$id_request_pertemuan = addslashes ($this->input->post('id_request_pertemuan'));	
			

			if($this->m_permintaan_jadwal_ganti->batal_respon($id_request_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Pembatalan respon permintaan jadwal ganti berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, pembatalan respon permintaan jadwal ganti gagal!
					</div>');
			}	
		}
		redirect('prodi/permintaan_jadwal_ganti');
		
	}

}

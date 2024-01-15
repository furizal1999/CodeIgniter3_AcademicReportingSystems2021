<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Preview_laporan_pertemuan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'UPM')==0 ){
				
			}else{
				//tidak dibolehkan
				redirect('welcome');
			}
		}

        $this->load->library('ciqrcode');
		// $this->load->library('PDF_MC_Table');

        $this->load->library('pdfgenerator');

		$this->load->model('m_preview_laporan_pertemuan');
	}

	public function index()
	{
		

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        	$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
      }


      $x['combobox_pertemuan']=$this->m_preview_laporan_pertemuan->combobox_pertemuan();
      $x['combobox_prodi']=$this->m_preview_laporan_pertemuan->combobox_prodi();

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('upm/v_preview_laporan_pertemuan', $x);
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
			// 2 =>'status_request_pertemuan',
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
			tb_jadwal_kelas_pertemuan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
				";
		$queryAll = $this->m_preview_laporan_pertemuan->getAllData($sql);

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
						tb_jadwal_kelas_pertemuan
	            ";
		$sql.= " 	WHERE 
						tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
						tb_semester.id_semester = tb_pertemuan.id_semester AND 
						tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
						tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
						tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
						tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
						tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

						tb_tahun_ajaran.status='Tersedia' AND 
						tb_semester.status = 'Tersedia' AND 
						tb_pertemuan.status='Tersedia' AND
						tb_jadwal_pengampu.status='Tersedia' AND
						tb_prodi.status = 'Tersedia' AND
						tb_matkul.status = 'Tersedia' AND
						tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
						tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
						tb_prodi.kode_prodi = '$kode_jurusan'
				";
		

		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";  
			$sql.=" OR nama_kelas LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR nama_kelas LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_preview_laporan_pertemuan->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows(); 

		$sql.=" ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC,
 				". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_preview_laporan_pertemuan->getFilteredDataOrderBy($sql);

		$_SESSION['order_column'] = $columns[$requestData['order'][0]['column']];
		$_SESSION['order_dir'] = $requestData['order'][0]['dir'];
		$_SESSION['start'] = $requestData['start'];
		$_SESSION['length'] = $requestData['length'];


		// $query=mysqli_query($conn, $sql) or die("data_server.php: get dataku");
		//----------------------------------------------------------------------------------
		$data = array();
		$no = 1;
		$pertemuan_awal=0;
		$pertemuan_akhir=16;
		foreach($queryOrderBy->result_array() as $row):
			$id_jadwal_kelas_pertemuan = $row['id_jadwal_kelas_pertemuan'];
			$semester = $row['semester'];
			$tahun_ajaran = $row['tahun_ajaran'];
			$nama_mk = $row['nama_mk'];
			date_default_timezone_set('Asia/Jakarta');
			$now = date("Y-m-d");
			$jadwalAwal = date('Y-m-d', strtotime($row['waktu_pertemuan_pertama']));
			$jadwalAwalJam = date('H:i:s', strtotime($row['waktu_pertemuan_pertama']));
			$today = date('D', strtotime($now));
			$dayList = array(
			    'Sun' => 'Minggu',
			    'Mon' => 'Senin',
			    'Tue' => 'Selasa',
			    'Wed' => 'Rabu',
			    'Thu' => 'Kamis',
			    'Fri' => 'Jumat',
			    'Sat' => 'Sabtu'
			);
			$nestedData=array(); 
			$nestedData[] = $no++;
			$nestedData[] = $row['semester'];

			//menampilkan nama semua pengampu
			$dosen_pengampu = $row['dosen_pengampu'];
			$array_dosen = explode(', ', $dosen_pengampu);
			$index = 0;
			$array_dosen_hasil = array();

			foreach ($array_dosen as $npk) {
				$nama_dosen = $this->m_preview_laporan_pertemuan->getNamaDosen($npk);
				$array_dosen_hasil[$index++] = $nama_dosen;
			}

			$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

	
			$nestedData[] = $string_dosen_hasil;
			$nestedData[] = $row['nama_mk'];
			$nestedData[] = $row['sks_teori'];
			$nestedData[] = $row['nama_kelas'];
			$nestedData[] = $dayList[date('D', strtotime($jadwalAwal))];



			$index = 0;
			$cek_pertemuan_sebelumnya = false;
			for ($i=$pertemuan_awal; $i < $pertemuan_akhir; $i++){ 
				$baris = $this->m_preview_laporan_pertemuan->getDataPertemuan($id_jadwal_kelas_pertemuan, ($i+1))->row();
				if($baris){
					$id_presensi_pertemuan = $baris->id_presensi_pertemuan;
				}

				
				$yesterday = date('D', strtotime($jadwalAwal));



				if((($i+1)%8)==0){
					if(($i+1)==8){
						$temp = '<i class="text-success">UTS</i>';
					}elseif(($i+1)==16){
						$temp = '<i class="text-success">UAS</i>';
					}
				}
				elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_minta_verifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){
					$temp = '<td align="center">

								<div class="dropdown">
								  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  	<b><i class="fas fa-clock text-warning"></i></b>
								  </a>
								  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

								    	<a class="text-info dropdown-item" target="_BLANK" href="'.base_url("upm/preview_laporan_pertemuan/detail_presensi/").$id_presensi_pertemuan.'"><i class="fas fa-book"></i>  Detail</a>
								  </div>
								</div>
							</td>';
					
				}elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_terverifikasi($id_jadwal_kelas_pertemuan, ($i+1))>0){
					$temp = '<td align="center">
									<div class="dropdown">
									  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  	<b><i class="fas fa-check-circle text-success"></i></b>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									  	<!-- isi -->
									     <a class="text-info dropdown-item" target="_BLANK" href="'.base_url("upm/preview_laporan_pertemuan/detail_presensi/").$id_presensi_pertemuan.'"><i class="fas fa-book"></i>  Detail</a>
									  </div>
									</div>
								</td>';
					
				}elseif($this->m_preview_laporan_pertemuan->check_ketersediaan_pertemuan_ditolak($id_jadwal_kelas_pertemuan, ($i+1))>0){
					$temp = '<td align="center">
									<div class="dropdown">
									  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  	<b><i class="fas fa-times-circle text-danger"></i></b>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									  	
									    <a class="text-info dropdown-item" target="_BLANK" href="'.base_url("upm/preview_laporan_pertemuan/detail_presensi/").$id_presensi_pertemuan.'"><i class="fas fa-book"></i>  Detail</a>
									  </div>
									</div>
								</td>';
					
				}else{
					$temp = '<td align="center">
									<div class="dropdown">
									  <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  	<b><i class="fas fa-dot-circle text-dark"></i></b>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
									  	 <a class="text-danger dropdown-item"><i class="fas fa-exclamation"></i>  INFO : Masih Kosong! </a>
									  </div>
									</div>
								</td>';
					
				}
				$nestedData[] = $temp;

				if((($i+1)%8)!=0){
					$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
					while($this->m_preview_laporan_pertemuan->cekHariLibur($jadwalAwal, $jadwalAwalJam)==-1){
						$jadwalAwal = date('Y-m-d', strtotime('+7 days', strtotime($jadwalAwal)));
					}
				}
				
			}

			$aksi = '<td align="center">
							<div class="btn-group">';
								
								$aksi.= ' <a class="btn btn-warning btn-sm inline" target="_BLANK" href="'.base_url('upm/preview_laporan_pertemuan/cetak_laporan_pertemuan/'.$id_jadwal_kelas_pertemuan).'"> <i class="fas fa-print"></i> Cetak</a>
							</div>
						</td>';







			
			$nestedData[] = $aksi;




			$nestedData[] = '';
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

    public function detail_presensi($id_presensi_pertemuan)
	{
		if(isset($id_presensi_pertemuan)){
			$x['id_presensi_pertemuan'] = $id_presensi_pertemuan;
		}else{
			redirect('upm/preview_laporan_pertemuan');
		}

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('upm/v_detail_presensi', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function cetak_laporan_pertemuan($id_jadwal_kelas_pertemuan=null)
    {

        

       $this->data['id_jadwal_kelas_pertemuan'] = $id_jadwal_kelas_pertemuan;
       // $this->data
        
        // filename dari pdf ketika didownload
        $file_pdf = 'Monitoring Kehadiran Pengampu';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";
        
        $html = $this->load->view('upm/v_cetak_laporan_pertemuan',$this->data, true);

        
        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
        unlink("templates/img/qrcode/qrcode".$id_jadwal_kelas_pertemuan.".png");
        
    }

   
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_pengampu_matkul extends CI_Controller {

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

		$this->load->model('m_jadwal_pengampu_matkul');
	}

	public function index()
	{
			
			if(isset($_POST['id_pertemuan'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}


			
			$x['combobox_prodi']=$this->m_jadwal_pengampu_matkul->combobox_prodi();
			$x['combobox_tahun_ajaran']=$this->m_jadwal_pengampu_matkul->combobox_tahun_ajaran();
			
			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){

				$baris = $this->m_jadwal_pengampu_matkul->ambil_tahun_ajaran($_SESSION['id_pertemuan_search']);
				if($baris){
					$semester = $baris->semester;
				}

				$kode_jurusan = $_SESSION['kode_prodi'];
				// $x['data']=$this->m_jadwal_pengampu_matkul->show_jadwal_ujian($kode_jurusan,$_SESSION['id_pertemuan_search']);
				// $x['show_jadwal_kelas_pertemuan']=$this->m_jadwal_pengampu_matkul->show_jadwal_kelas_pertemuan();
				// $x['combobox_ruang']=$this->m_jadwal_pengampu_matkul->combobox_ruang($kode_jurusan);
				// $x['combobox_dosen1']=$this->m_jadwal_pengampu_matkul->combobox_dosen1($kode_jurusan);
				// $x['combobox_dosen2']=$this->m_jadwal_pengampu_matkul->combobox_dosen2($kode_jurusan);
				$x['combobox_dosen_semua']=$this->m_jadwal_pengampu_matkul->combobox_dosen_semua($kode_jurusan);
				$x['combobox_matkul']=$this->m_jadwal_pengampu_matkul->combobox_matkul($kode_jurusan, $semester);
				
			}
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_jadwal_pengampu_matkul', $x);
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
			1 =>'nama_mk',
			2 =>'nama_mk',
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
			tb_matkul

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND

			tb_prodi.kode_prodi = '$kode_jurusan' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan'

			ORDER BY tb_jadwal_pengampu.id_jadwal_pengampu DESC


				";
		$queryAll = $this->m_jadwal_pengampu_matkul->getAllData($sql);

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
					tb_matkul
	            ";
		$sql.= " 	WHERE 
					tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
					tb_semester.id_semester = tb_pertemuan.id_semester AND 
					tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
					tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
					tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
					tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND

					tb_tahun_ajaran.status='Tersedia' AND 
					tb_semester.status = 'Tersedia' AND 
					tb_pertemuan.status='Tersedia' AND
					tb_jadwal_pengampu.status='Tersedia' AND
					tb_prodi.status = 'Tersedia' AND
					tb_matkul.status = 'Tersedia' AND

					tb_prodi.kode_prodi = '$kode_jurusan' AND
					tb_pertemuan.id_pertemuan = '$id_pertemuan'
				";
		

		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";   
			$sql.=" OR nama_mk LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR nama_mk LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_jadwal_pengampu_matkul->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows(); 

		$sql.=" ORDER BY tb_jadwal_pengampu.id_jadwal_pengampu DESC,
 				". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$queryOrderBy = $this->m_jadwal_pengampu_matkul->getFilteredDataOrderBy($sql);

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
			$terjadwal = $this->m_jadwal_pengampu_matkul->total_terjadwal($row["id_jadwal_pengampu"]);
			//get nama dosen
			$dosen_pengampu=$row['dosen_pengampu'];
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

			$nestedData[] = $no++;
			$nestedData[] = $row["nama_mk"];
			$nestedData[] = $string_dosen_hasil;
			$nestedData[] = $row["jumlah_kelas"].' ('.$terjadwal.' <a class="text-primary" target="_BLANK" href="'.base_url("tu/jadwal_pengampu_matkul/detail_kelas/").$row["id_jadwal_pengampu"].'"><i class="fa fa-eye"></i></a> terjadwal)';
			$nestedData[] = $row["jumlah_kelas"]-$terjadwal;
			
			$tempo = '';		
			if(($row["jumlah_kelas"]-$terjadwal)>0){
				$tempo.= '<a class="btn btn-sm btn-warning text-dark" data-toggle="modal" data-target="#modal_jadwal_lanjutan'.$row["id_jadwal_pengampu"].'"><i class="fa fa-arrow-right"></i> JADWALKAN KELAS</a>';
				$tempo.= '<div class="modal fade" id="modal_jadwal_lanjutan'.$row["id_jadwal_pengampu"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
								<div class="modal-dialog">
								<div class="modal-content">
								<div class="modal-header bg-warning">
									<h3 class="modal-title" id="myModalLabel">Penjadwalan Kelas</h3>
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
								</div>
								<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_pengampu_matkul/tambah_jadwal_kelas_pertemuan'.'" enctype="multipart/form-data">
									<div class="modal-body">
									
										<input type="hidden" name="id_jadwal_pengampu" class="form-control" value="'.$row["id_jadwal_pengampu"].'" readonly>
										
										<div class="form-group">
											<label class="control-label col-xs-3" >WAKTU PERTEMUAN PERTAMA (TANGGAL)</label>
											<div class="row">
												<div class="form-group"><input type="date" name="tanggal_pertemuan_pertama" class="form-control" required></div>

											</div>
											<div class="row">
												<div class="col-md-6">
													<label>JAM MULAI</label>
													<div class="form-group"><input type="time" name="jam_pertemuan_pertama" class="form-control" required></div>
												</div>
												<div class="col-md-6">
													<label>JAM SELESAI</label>
													<div class="form-group"><input type="time" name="jam_pertemuan_pertama_akhir" class="form-control" required></div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>KELAS</label>
											<select name="nama_kelas" class="form-control" required>
												<option value="">--Pilih--</option>';

													$z= $this->m_jadwal_pengampu_matkul->combobox_kelas($_SESSION['kode_prodi'], $row['semester']);
													if($z){
														foreach($z->result_array() as $i):
															$semester_combo=$i['semester'];
															$nama_kelas_combo=$i['nama_kelas'];
															$kelas_pilihan_combo=$i['kelas_pilihan'];
															if($semester_combo=='0'){
																$semester_combo = '';
															}
															
															if($kelas_pilihan_combo=="PIL"){
																$kelas_combo = $semester_combo.$nama_kelas_combo.' '.$kelas_pilihan_combo;
															}else{
																$kelas_combo = $semester_combo.$nama_kelas_combo;
															}

													
													$tempo.= '<option  value="'.$kelas_combo.'">'.$kelas_combo.'</option>';
													
														endforeach;
														
													}
												
									$tempo.= '</select>

										</div>
										<div class="form-group">
												<label>JUMLAH MAHASISWA</label>
												<input type="number" name="jumlah_mahasiswa" class="form-control" placeholder="Masukkan jumlah mahasiswa.." required>
										</div>
											

									</div>

									<div class="modal-footer">
										<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
										<button class="btn btn-info">Simpan</button>
									</div>
								</form>
								</div>
								</div>
							</div>';
			}
			$tempo.= '<a class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal_edit'.$row["id_jadwal_pengampu"].'"><i class="fa fa-pen"></i> Edit</a>';

				$tempo.= '<div class="modal fade" id="modal_edit'.$row["id_jadwal_pengampu"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-secondary">
										<h3 class="modal-title" id="myModalLabel">Edit Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_pengampu_matkul/edit_jadwal_pengampu_matkul'.'" enctype="multipart/form-data">
										<div class="modal-body">';

										
										$tempo.= '<div class="form-group">
												<label class="control-label col-xs-3" >MATAKULIAH</label>
												<select id="kode_mk" name="kode_mk" class="form-control" required>
													<option value="">--Pilih--</option>';
													
														foreach($this->m_jadwal_pengampu_matkul->combobox_matkul($_SESSION['kode_prodi'], $row['semester'])->result_array() as $i):
															$kode_matkul_combo=$i['kode_mk'];
															$nama_matkul_combo=$i['nama_mk'];
															
													
													$tempo.= '<option  value="'.$kode_matkul_combo.'"';
													if($kode_matkul_combo==$row["kode_mk"]){
													  	$tempo.= 'selected'; 
													} 
										  $tempo.= '>'.($kode_matkul_combo.' - '.$nama_matkul_combo).'</option>';
													endforeach;
									   $tempo.= '</select>
									   			</div>';

										$tempo.= '<div class="form-group bg-warning rounded mt-3 mb-3">';
											$tempo.= '<label class="control-label col-xs-3" >DOSEN PENGAMPU-1</label>
											<select id="dosen_pengampu1" name="dosen_pengampu1" class="form-control" required>
												<option value="">--Pilih--</option>';
												
													foreach($this->m_jadwal_pengampu_matkul->combobox_dosen_semua($_SESSION['kode_prodi'])->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												
												$tempo.= '<option  value="'.$npk_combo.'"';

												if(isset($array_npk_hasil[0])){
													if($npk_combo==$array_npk_hasil[0]){
														$tempo.='selected'; 
													}
												}
												$tempo.='>'.$nama_dosen_combo.'</option>';
												endforeach;
											$tempo.='</select>';

											$tempo.= '<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-2</label>
											<select id="dosen_pengampu2" name="dosen_pengampu2" class="form-control">
												<option value="">--Pilih--</option>';
												
													foreach($this->m_jadwal_pengampu_matkul->combobox_dosen_semua($_SESSION['kode_prodi'])->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												
												$tempo.= '<option  value="'.$npk_combo.'"';

												if(isset($array_npk_hasil[1])){
													if($npk_combo==$array_npk_hasil[1]){
														$tempo.='selected'; 
													}
												}
												$tempo.='>'.$nama_dosen_combo.'</option>';
												endforeach;
											$tempo.='</select>';

											$tempo.= '<label class="control-label col-xs-3 pt-3" >DOSEN PENGAMPU-3</label>
											<select id="dosen_pengampu3" name="dosen_pengampu3" class="form-control">
												<option value="">--Pilih--</option>';
												
													foreach($this->m_jadwal_pengampu_matkul->combobox_dosen_semua($_SESSION['kode_prodi'])->result_array() as $i):
														$npk_combo=$i['npk'];
														$nama_dosen_combo=$i['nama_dosen'];
												
												$tempo.= '<option  value="'.$npk_combo.'"';
												if(isset($array_npk_hasil[2])){
													if($npk_combo==$array_npk_hasil[2]){
														$tempo.='selected'; 
													}
												}
												
												$tempo.='>'.$nama_dosen_combo.'</option>';
												endforeach;
											$tempo.='</select>';

										$tempo.='</div>';
											$tempo.='<div class="form-group">
												<label class="control-label col-xs-3" >JUMLAH KELAS</label>
												<div class="col-xs-8">
													<input name="jumlah_kelas" value="'.$row["jumlah_kelas"].'" class="form-control" type="number" placeholder="Jumlah kelas..." required>
												</div>
											</div>
											<input type="hidden" name="id_jadwal_pengampu" value="'.$row["id_jadwal_pengampu"].'">

										</div>

										<div class="modal-footer">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-info">Simpan Perubahan</button>
										</div>
									</form>
									</div>
									</div>
								</div>';

			$tempo.= '<a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal_hapus'.$row["id_jadwal_pengampu"].'"><i class="fa fa-trash"></i> Hapus</a>';
					$tempo.= '<div class="modal fade" id="modal_hapus'.$row["id_jadwal_pengampu"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-danger">
										<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_pengampu_matkul/hapus_jadwal_pengampu_matkul'.'">
										<div class="modal-body">
											<p>Anda yakin menghapus jadwal matakuliah <b>'.$row["nama_mk"].'</b>?</p>
										</div>
										<div class="modal-footer">
											<input type="hidden" name="id_jadwal_pengampu" value="'.$row["id_jadwal_pengampu"].'">
											<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											<button class="btn btn-danger">Hapus</button>
										</div>
									</form>
									</div>
									</div>
								</div>';
														
			$tempo.= '<a class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_detail'.$row["id_jadwal_pengampu"].'"><i class="fa fa-book"></i> Rincian</a>';
				$tempo.= '<div class="modal fade" id="modal_detail'.$row["id_jadwal_pengampu"].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
									<div class="modal-dialog">
									<div class="modal-content">
									<div class="modal-header bg-info">
										<h3 class="modal-title" id="myModalLabel">Detail Jadwal Pengampu</h3>
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									</div>
									<table class="table">
										<tr>
											<td>ID Jadwal</td>
											<td>:</td>
											<td>'.$row["id_jadwal_pengampu"].'</td>
										</tr>
										<tr>
											<td>Tahun Ajaran</td>
											<td>:</td>
											<td>'.$row["tahun_ajaran"].'</td>
										</tr>
										<tr>
											<td>Semester</td>
											<td>:</td>
											<td>'.$row["semester"].'</td>
										</tr>
										<tr>
											<td>Nama Matakuliah</td>
											<td>:</td>
											<td>'.$row["nama_mk"].'</td>
										</tr>
										<tr>
											<td>Dosen Pengampu</td>
											<td>:</td>
											<td>';
													
										$tempo.= $string_dosen_hasil;
										$tempo.= '</td>

										</tr>
										<tr>
											<td>Jumlah Kelas</td>
											<td>:</td>
											<td>'.$row["jumlah_kelas"].'</td>
										</tr>
										<tr>
											<td>Jumlah Kelas Terjadwal</td>
											<td>:</td>
											<td>'.$terjadwal.'<a class="text-primary" target="_BLANK" href="'.base_url("tu/jadwal_pengampu_matkul/detail_kelas/").$row["id_jadwal_pengampu"].'"><i class="fa fa-eye"></i></a></td>
										</tr>
									
										

									</table>
								
											<div class="modal-footer">
													<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
											</div>
										</div>
									</div>
								</div>';




								


							// foreach($this->m_jadwal_pengampu_matkul->show_jadwal_kelas_pertemuan()->result_array() as $i):

							// 	$id_jadwal_kelas_pertemuan=$i['id_jadwal_kelas_pertemuan'];
							// 	$waktu_pertemuan_pertama=$i['waktu_pertemuan_pertama'];
							// 	$waktu_pertemuan_pertama_selesai=$i['waktu_pertemuan_pertama_selesai'];
							// 	$nama_kelas=$i['nama_kelas'];
							// 	$jumlah_mahasiswa=$i['jumlah_mahasiswa'];

							// 	$tanggal_pertemuan_pertama = date("Y-m-d", strtotime($waktu_pertemuan_pertama));
							// 	$jam_pertemuan_pertama = date("H:i", strtotime($waktu_pertemuan_pertama));
							// 	$jam_pertemuan_pertama_selesai = date("H:i", strtotime($waktu_pertemuan_pertama_selesai));
								
						

							
							//  $tempo.= '<div class="modal fade" id="modal_hapus_kelas'.$id_jadwal_kelas_pertemuan.'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
							// 	<div class="modal-dialog">
							// 	<div class="modal-content">
							// 	<div class="modal-header bg-danger">
							// 		<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Kelas Pertemuan</h3>
							// 		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							// 	</div>
							// 	<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_pengampu_matkul/hapus_jadwal_kelas_pertemuan'.'">
							// 		<div class="modal-body">
							// 			<p>Anda yakin menghapus jadwal kelas <b>'.$nama_kelas.'</b>?</p>
							// 		</div>
							// 		<div class="modal-footer">
							// 			<input type="hidden" name="id_jadwal_kelas_pertemuan" value="'.$id_jadwal_kelas_pertemuan.'">
							// 			<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
							// 			<button class="btn btn-danger">Hapus</button>
							// 		</div>
							// 	</form>
							// 	</div>
							// 	</div>
							// </div>';

							// endforeach;



			
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

    function detail_kelas($id_jadwal_pengampu=null){
    	if($id_jadwal_pengampu!=null){
    		$x['id_jadwal_pengampu'] = $id_jadwal_pengampu;
    		if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){
    			$x['detail_kelas']=$this->m_jadwal_pengampu_matkul->detail_kelas($id_jadwal_pengampu);
    			$this->load->view('public/part/header');
				$this->load->view('public/part/menu');
				$this->load->view('tu/v_detail_kelas', $x);
				$this->load->view('public/part/footer');

				unset($_SESSION['messege']);
			}else{
				redirect('tu/jadwal_pengampu_matkul');
			}
			
    	}else{
    		redirect('tu/jadwal_pengampu_matkul');
    	}


    }


	function tambah_jadwal_pengampu_matkul(){
		if(isset($_POST['tambah_pengampu'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$id_pertemuan = $_SESSION['id_pertemuan_search'];
			$dosen_pengampu1 = $this->input->post('dosen_pengampu1');
			$dosen_pengampu2 = $this->input->post('dosen_pengampu2');
			$dosen_pengampu3 = $this->input->post('dosen_pengampu3');

			if($dosen_pengampu1!=""){
				$array_dosen_pengampu[] = $dosen_pengampu1;
			}

			if($dosen_pengampu2!=""){
				$array_dosen_pengampu[] = $dosen_pengampu2;
			}

			if($dosen_pengampu3!=""){
				$array_dosen_pengampu[] = $dosen_pengampu3;
			}


			$kode_mk = addslashes ($this->input->post('kode_mk'));
			$dosen_pengampu2= implode(", ", $array_dosen_pengampu);
			$jumlah_kelas = addslashes ($this->input->post('jumlah_kelas'));

			
			if($this->m_jadwal_pengampu_matkul->tambah_jadwal_pengampu_matkul($kode_jurusan, $id_pertemuan, $kode_mk, $dosen_pengampu2, $jumlah_kelas)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal berhasil ditambahkan!
					</div>');
				redirect('tu/jadwal_pengampu_matkul');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal gagal ditambahkan!
					</div>');
				redirect('tu/jadwal_pengampu_matkul');
			}
			
			
		}else{
			redirect('tu/jadwal_pengampu_matkul');
		}
	}

	function hapus_jadwal_pengampu_matkul(){
		if(isset($_POST['id_jadwal_pengampu'])){
			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			
			if($this->m_jadwal_pengampu_matkul->hapus_jadwal_pengampu_matkul($id_jadwal_pengampu)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal berhasil hapus!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal gagal hapus!
					</div>');
			}
			
		}
		redirect('tu/jadwal_pengampu_matkul');		
	}

	function edit_jadwal_pengampu_matkul(){
		if(isset($_POST['id_jadwal_pengampu'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			$kode_mk = addslashes ($this->input->post('kode_mk'));

			$dosen_pengampu1 = $this->input->post('dosen_pengampu1');
			$dosen_pengampu2 = $this->input->post('dosen_pengampu2');
			$dosen_pengampu3 = $this->input->post('dosen_pengampu3');

			if($dosen_pengampu1!=""){
				$array_dosen_pengampu[] = $dosen_pengampu1;
			}

			if($dosen_pengampu2!=""){
				$array_dosen_pengampu[] = $dosen_pengampu2;
			}

			if($dosen_pengampu3!=""){
				$array_dosen_pengampu[] = $dosen_pengampu3;
			}
			$dosen_pengampu2= implode(", ", $array_dosen_pengampu);


			$jumlah_kelas = addslashes ($this->input->post('jumlah_kelas'));

			if($jumlah_kelas>=$this->m_jadwal_pengampu_matkul->cek_jumlah__kelas_terjadwal($id_jadwal_pengampu)){
				$this->m_jadwal_pengampu_matkul->edit_jadwal_pengampu_matkul($id_jadwal_pengampu, $kode_jurusan, $kode_mk, $dosen_pengampu2, $jumlah_kelas);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal berhasil diedit!
					</div>');
				redirect('tu/jadwal_pengampu_matkul');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Jumlah kelas yang di update lebih kecil dari pada kelas yang telah terjadwal. Untuk tetap melakukannya, silahkan hapus terlebih dahulu kelas yang terjadwal sampai jumlahnya sama dengan jumlah kelas yang akan di update!
					</div>');
				redirect('tu/jadwal_pengampu_matkul');
			}

		}else{
			redirect('tu/jadwal_pengampu_matkul');
		}
		
	}


	function tambah_jadwal_kelas_pertemuan(){
		if(isset($_POST['id_jadwal_pengampu'])){

			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			$jam_pertemuan_pertama = addslashes ($this->input->post('jam_pertemuan_pertama'));
			$jam_pertemuan_pertama_akhir = addslashes ($this->input->post('jam_pertemuan_pertama_akhir'));
			$tanggal_pertemuan_pertama = addslashes ($this->input->post('tanggal_pertemuan_pertama'));
			$nama_kelas = addslashes ($this->input->post('nama_kelas'));
			$jumlah_mahasiswa = addslashes ($this->input->post('jumlah_mahasiswa'));
			if($jam_pertemuan_pertama<$jam_pertemuan_pertama_akhir){
				if($this->m_jadwal_pengampu_matkul->check_nama_kelas_tambah($id_jadwal_pengampu, $nama_kelas)==0){
					if($this->m_jadwal_pengampu_matkul->tambah_jadwal_kelas_pertemuan($id_jadwal_pengampu, $jam_pertemuan_pertama, $jam_pertemuan_pertama_akhir, $tanggal_pertemuan_pertama, $nama_kelas, $jumlah_mahasiswa)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Jadwal kelas pertemuan berhasil ditambahkan!
							</div>');
						redirect('tu/jadwal_pengampu_matkul');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Jadwal kelas pertemuan gagal ditambahkan!
							</div>');
						redirect('tu/jadwal_pengampu_matkul');
					}		
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, kelas ini telah tersedia pada mata kuliah yang sama! Silahkan perhatikan lagi!
						</div>');
					redirect('tu/jadwal_pengampu_matkul');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, jam mulai harus lebih kecil dari jam selesai!
					</div>');
				redirect('tu/jadwal_pengampu_matkul');
			}
			
				
		}else{
			redirect('tu/jadwal_pengampu_matkul');
		}
	}

	function edit_jadwal_kelas_pertemuan(){
		if(isset($_POST['id_jadwal_kelas_pertemuan'])){

			$id_jadwal_kelas_pertemuan = addslashes ($this->input->post('id_jadwal_kelas_pertemuan'));
			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			$jam_pertemuan_pertama = addslashes ($this->input->post('jam_pertemuan_pertama'));
			$jam_pertemuan_pertama_akhir = addslashes ($this->input->post('jam_pertemuan_pertama_akhir'));
			$tanggal_pertemuan_pertama = addslashes ($this->input->post('tanggal_pertemuan_pertama'));
			$nama_kelas = addslashes ($this->input->post('nama_kelas'));
			$jumlah_mahasiswa = addslashes ($this->input->post('jumlah_mahasiswa'));
			if($jam_pertemuan_pertama<$jam_pertemuan_pertama_akhir){
				if($this->m_jadwal_pengampu_matkul->check_nama_kelas_edit($id_jadwal_pengampu, $id_jadwal_kelas_pertemuan, $nama_kelas)==0){
					if($this->m_jadwal_pengampu_matkul->edit_jadwal_kelas_pertemuan($id_jadwal_kelas_pertemuan,  $jam_pertemuan_pertama, $jam_pertemuan_pertama_akhir, $tanggal_pertemuan_pertama, $nama_kelas, $jumlah_mahasiswa)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Jadwal kelas pertemuan berhasil diedit!
							</div>');
						redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Jadwal kelas pertemuan gagal diedit!
							</div>');
						redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);
					}		
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, kelas ini telah tersedia pada mata kuliah yang sama! Silahkan perhatikan lagi!
						</div>');
					redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, jam mulai harus lebih kecil dari jam selesai!
					</div>');
				redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);
			}
			
			
				
		}else{
			redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);
		}
	}

	function hapus_jadwal_kelas_pertemuan(){
		if(isset($_POST['id_jadwal_kelas_pertemuan'])){
			$id_jadwal_kelas_pertemuan = addslashes ($this->input->post('id_jadwal_kelas_pertemuan'));
			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			
			if($this->m_jadwal_pengampu_matkul->hapus_jadwal_kelas_pertemuan($id_jadwal_kelas_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal kelas berhasil hapus!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal kelas gagal hapus!
					</div>');
			}
			
		}
		redirect('tu/jadwal_pengampu_matkul/detail_kelas/'.$id_jadwal_pengampu);	
	}

	function get_kode_mk(){
		if(isset($_POST['semester'])){
			$kode_jurusan= $_SESSION['kode_prodi'];
			$semester = addslashes ($this->input->post('semester'));
			header('Content-Type: application/x-json; charset=utf-8');
			echo(json_encode($this->m_jadwal_pengampu_matkul->get_kode_mk($kode_jurusan, $semester)));	
		}
	}
}

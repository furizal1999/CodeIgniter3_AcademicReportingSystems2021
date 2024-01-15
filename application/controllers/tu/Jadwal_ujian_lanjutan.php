<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_ujian_lanjutan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
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
		$this->load->model('m_jadwal_ujian_lanjutan');
		$this->load->model('m_persetujuan_terlambat');
	}



	public function index()
	{


			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}
			$x['combobox_prodi']=$this->m_jadwal_ujian_lanjutan->combobox_prodi();
			$x['combobox_ujian']=$this->m_persetujuan_terlambat->combobox_ujian();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_jadwal_ujian_lanjutan',$x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);




		unset($_SESSION['messege']);
	}

	public function get_ajax() {
		date_default_timezone_set('Asia/Jakarta');
      	$sekarang = date("Y-m-d H:i:s");
		$id_ujian = $_SESSION['id_ujian_search'];
        $kode_jurusan = $_SESSION['kode_prodi'];

		$requestData= $_REQUEST;
		$columns = array(
			0 =>'kode_prodi',
			1 =>'nama_mk',
			// 2 =>'npk_pengawas1',
			// 3 =>'npk_pengawas2',
			// 0 =>'id_jadwal_lanjutan',
			// 0 =>'id_jadwal_lanjutan',
		);
		//----------------------------------------------------------------------------------
		//join 2 tabel dan bisa lebih, tergantung kebutuhan


		$sql = " SELECT * ";
		$sql.= "
		FROM

		tb_surat_keputusan,
		tb_tahun_ajaran,
		tb_semester,
		tb_pertemuan,
		tb_jadwal_pengampu,
		tb_prodi,
		tb_matkul,
					tb_ujian,
					tb_jadwal_ujian,
					tb_jadwal_kelas_pertemuan

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

					tb_ujian.id_ujian = '$id_ujian' AND
					tb_prodi.kode_prodi = '$kode_jurusan'
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
		tb_surat_keputusan,
		tb_tahun_ajaran,
		tb_semester,
		tb_pertemuan,
		tb_jadwal_pengampu,
		tb_prodi,
		tb_matkul,
					tb_ujian,

					tb_jadwal_ujian,
					tb_jadwal_kelas_pertemuan
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

					tb_ujian.id_ujian = '$id_ujian' AND
					tb_prodi.kode_prodi = '$kode_jurusan'
			";


		if( !empty($requestData['search']['value']) ) {
			//----------------------------------------------------------------------------------
			$sql.=" AND ( nama_mk LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR kode_prodi LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR kode_prodi LIKE '%".$requestData['search']['value']."%' )";
		}
		//----------------------------------------------------------------------------------
		$queryFIltered = $this->m_persetujuan_terlambat->getFilteredData($sql);
		$totalFiltered = $queryFIltered->num_rows();
		// echo $totalFiltered; die();
		// $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$sql.=" ORDER BY tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan DESC, ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
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

			$jenis_ujian = $row['ket_ujian'];
			$dosen_pengampu=$row['dosen_pengampu'];
			$array_dosen = explode(', ', $dosen_pengampu);

			$array_dosen_hasil = array();
			$array_npk_hasil = array();
			$index = 0;
			foreach ($array_dosen as $npk) {
				$nama_dosen = $this->m_jadwal_ujian_lanjutan->getNamaDosen($npk);
				$array_npk_hasil[$index] = $npk;
				$array_dosen_hasil[$index] = $nama_dosen;
				$index++;
			}
			$string_dosen_hasil = implode('/ ', $array_dosen_hasil);

			$nestedData=array();
			$nestedData[] = $no++;
			$nestedData[] = $row["nama_mk"];





			$nestedData[] = $string_dosen_hasil;
			$nestedData[] =  $row["tanggal_ujian"];
			$nestedData[] = '<i class="text-success">'.$row["jam_mulai"].' </i>  s/d <i class="text-danger">'.$row["jam_selesai"].'</i>';
			$nestedData[] = $row["nama_kelas"];
			$nestedData[] = $row["jumlah_mahasiswa"];
			$nestedData[] = $this->m_jadwal_ujian_lanjutan->showDetailJadwalPengawas($row["kode_prodi"], $row["id_jadwal_kelas_pertemuan"], $row["id_jadwal_ujian"])->num_rows();;
			$tempAksi = '
			<a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#modal_jadwal_pengawas'.$row['id_jadwal_kelas_pertemuan'].'"><i class="fa fa-arrow-right"></i> Jadwalkan Pengawas</a>
			<div class="modal fade" id="modal_jadwal_pengawas'.$row['id_jadwal_kelas_pertemuan'].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
				<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header bg-warning">
					<h3 class="modal-title" id="myModalLabel">Jadwalkan Pengawas Ujian</h3>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				</div>
				<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_ujian_lanjutan/jadwalkan_pengawas_ujian'.'">
					<div class="modal-body">
						<input type="hidden" name="id_jadwal_ujian" value="'.$row['id_jadwal_ujian'].'">
						<input type="hidden" name="id_jadwal_kelas_pertemuan" value="'.$row['id_jadwal_kelas_pertemuan'].'">
						<div class="form-group">
							<label>JUMLAH MAHASISWA</label>
							<input type="number" name="jumlah_mhs_terjadwal_ujian" class="form-control" value="'.$row['jumlah_mahasiswa'].'" required>
						</div>
						<div class="form-group text-left">
							<label class="control-label col-xs-3" >PENGAWAS UJIAN 1</label>
							<select name="npk_pengawas1" class="form-control" required>
								<option value="">--Pilih--</option>';

									foreach($this->m_jadwal_ujian_lanjutan->combobox_dosen1($row['kode_prodi'])->result_array() as $i):
										$nama_dosen_combo=$i['nama_dosen'];
										$npk_combo=$i['npk'];

		$tempAksi .= '<option  value="'.$npk_combo.'"';
		if($row['dosen_pengampu']==$npk_combo){
			$tempAksi .= 'selected';
		}
		$tempAksi .= '>'.$nama_dosen_combo.'
								</option>';
								endforeach;
	  $tempAksi .= '</select>
						</div>';
						if($jenis_ujian=="Luring"){

		$tempAksi .= '<div class="form-group text-left">
							<label class="control-label col-xs-3" >PENGAWAS UJIAN 2</label>
							<select name="npk_pengawas2" class="form-control">
								<option value="">--Pilih--</option>';

									foreach($this->m_jadwal_ujian_lanjutan->combobox_dosen2($row['kode_prodi'])->result_array() as $i):
										$nama_dosen_combo=$i['nama_dosen'];
										$npk_combo=$i['npk'];

    $tempAksi .= '<option  value="'.$npk_combo.'">'.$nama_dosen_combo.'</option>';
								endforeach;
		$tempAksi .= '</select>
						</div>
						<div class="form-group text-left">
							<label class="control-label col-xs-3" >RUANG</label>
							<select name="kode_ruang" class="form-control" required>
								<option value="">--Pilih--</option>';

									foreach($this->m_jadwal_ujian_lanjutan->combobox_ruang($kode_jurusan)->result_array() as $i):
										$kode_ruang_combo=$i['kode_ruang'];
										$kapasitas_combo=$i['kapasitas'];

    $tempAksi .= '<option  value="'.$kode_ruang_combo.'">'.$kode_ruang_combo.'</option>';
								endforeach;
		$tempAksi .= '</select>
						</div>';
					}else{

		$tempAksi .= '<input type="hidden" name="npk_pengawas2" value="">
							<input type="hidden" name="kode_ruang" value="">';
					}
	  $tempAksi .= '</div>
					<div class="modal-footer">
						<input type="hidden" name="jenis_ujian" value="'.$jenis_ujian.'">
						<input type="hidden" name="tanggal_ujian" value="'.$row['tanggal_ujian'].'">
						<input type="hidden" name="jam_mulai" value="'.$row['jam_mulai'].'">
						<input type="hidden" name="jam_selesai" value="'.$row['jam_selesai'].'">

						<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
						<button class="btn btn-warning" name="jadwalkan_pengawas">Simpan</button>
					</div>
				</form>
				</div>
				</div>
			</div>




				<a class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#modalDetailPengawas'.$row['id_jadwal_kelas_pertemuan'].$row['id_jadwal_ujian'].'"><i class="fa fa-eye"></i></a>

				<div class="modal fade" id="modalDetailPengawas'.$row['id_jadwal_kelas_pertemuan'].$row['id_jadwal_ujian'].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
					<div class="modal-content">
					<div class="modal-header bg-info">
						<h3 class="modal-title" id="myModalLabel">Hapus Jadwal Ujian Lanjutan</h3>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					</div>
						<div class="modal-body">
							<div class="table-responsive">
								<table class="table">
									<tr class="bg-light">
										<th>No</th>
										<th>Ruang</th>
										<th>Pengawas 1</th>
										<th>Pengawas 2</th>
										<th>Jumlah Mahasiswa</th>
										<th>Aksi</th>
									</tr>';

										$detail = $this->m_jadwal_ujian_lanjutan->showDetailJadwalPengawas($row['kode_prodi'], $row['id_jadwal_kelas_pertemuan'], $row['id_jadwal_ujian']);
										$no = 1;
										if($detail->num_rows()>0){
												foreach ($detail->result_array() as $b) {

													$id_jadwal_lanjutan = $b['id_jadwal_lanjutan'];
													$jumlah_mhs_terjadwal_ujian = $b['jumlah_mhs_terjadwal_ujian'];
													$npk_pengawas1 = $b['npk_pengawas1'];

													$ket_ujian = $b['ket_ujian'];
													$npk_pengawas2 = $b['npk_pengawas2'];

													if($ket_ujian=='Daring'){
														$kode_ruang = 'ONLINE';
													}else{
														$kode_ruang = $b['kode_ruang'];
													}

													if($npk_pengawas1!=''){
														$nama_pengawas1 = $this->m_jadwal_ujian_lanjutan->get_pengawas($row['kode_prodi'], $npk_pengawas1);
													}else{
														$nama_pengawas1 = 'TIDAK ADA';
													}


													if($npk_pengawas2!=''){
														$nama_pengawas2 = $this->m_jadwal_ujian_lanjutan->get_pengawas($row['kode_prodi'], $npk_pengawas2);
													}else{
														$nama_pengawas2 = 'TIDAK ADA';
													}

					$tempAksi .=	'<tr>
										<td>'.$no++.'</td>
										<td>'.$b['kode_ruang'].'</td>
										<td>'.$nama_pengawas1.'</td>
										<td>'.$nama_pengawas2.'</td>
										<td>'.$b['jumlah_mhs_terjadwal_ujian'].'</td>
										<td>
											<a class="btn btn-sm btn-secondary text-white" data-toggle="modal" data-target="#modalEditPengawas'.$b['id_jadwal_lanjutan'].'"><i class="fa fa-pen"></i></a>
											<div class="modal fade" id="modalEditPengawas'.$b['id_jadwal_lanjutan'].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
												<div class="modal-dialog">
												<div class="modal-content">
												<div class="modal-header bg-secondary">
													<h3 class="modal-title" id="myModalLabel">Edit Pengawas Ujian</h3>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
												</div>
												<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_ujian_lanjutan/edit_pengawas_ujian'.'">
													<div class="modal-body">
														<div class="form-group">
															<label>JUMLAH MAHASISWA</label>
															<input type="number" name="jumlah_mhs_terjadwal_ujian" class="form-control" value="'.$b['jumlah_mhs_terjadwal_ujian'].'" required>
														</div>
														<div class="form-group text-left">
															<label class="control-label col-xs-3" >PENGAWAS UJIAN 1</label>
															<select name="npk_pengawas1" class="form-control" required>
																<option value="">--Pilih--</option>';

																	foreach($this->m_jadwal_ujian_lanjutan->combobox_dosen1($row['kode_prodi'])->result_array() as $i):
																		$nama_dosen_combo=$i['nama_dosen'];
																		$npk_combo=$i['npk'];

									$tempAksi .=   		'<option  value="'.$npk_combo.'"';
									if($b['npk_pengawas1']==$npk_combo){
										$tempAksi .= 'selected';
									}
									$tempAksi .= '>'.$nama_dosen_combo.'</option>';
															endforeach;
									$tempAksi .= '</select>
														</div>';
														if($jenis_ujian=="Luring"){

									$tempAksi .= '<div class="form-group text-left">
															<label class="control-label col-xs-3" >PENGAWAS UJIAN 2</label>
															<select name="npk_pengawas2" class="form-control">
																<option value="">--Pilih--</option>';

																	foreach($this->m_jadwal_ujian_lanjutan->combobox_dosen2($row['kode_prodi'])->result_array() as $i):
																		$nama_dosen_combo=$i['nama_dosen'];
																		$npk_combo=$i['npk'];

									$tempAksi .= '<option  value="'.$npk_combo.'"';
									if($b['npk_pengawas2']==$npk_combo){
										$tempAksi .= 'selected';
									}
									$tempAksi .= '>'.$nama_dosen_combo.'</option>';
										 							endforeach;
								  $tempAksi .= '</select>
														</div>

														<div class="form-group text-left">
															<label class="control-label col-xs-3" >RUANG</label>
															<select name="kode_ruang" class="form-control" required>
																<option value="">--Pilih--</option>';

																	foreach($this->m_jadwal_ujian_lanjutan->combobox_ruang($kode_jurusan)->result_array() as $i):
																		$kode_ruang_combo=$i['kode_ruang'];
																		$kapasitas_combo=$i['kapasitas'];

									$tempAksi .=	'<option  value="'.$kode_ruang_combo.'"';
									if($b['kode_ruang']==$kode_ruang_combo){
										$tempAksi .= 'selected';
									}
									$tempAksi .= '>'.$kode_ruang_combo.'</option>';
																	endforeach;
									$tempAksi .=	'</select>
														</div>';
													}else{

									$tempAksi .= '<input type="hidden" name="npk_pengawas2" value="">
															<input type="hidden" name="kode_ruang" value="">';
													 }
									$tempAksi .= '</div>
													<div class="modal-footer">

														<input type="hidden" name="id_jadwal_lanjutan" value="'.$b['id_jadwal_lanjutan'].'">

														<input type="hidden" name="jenis_ujian" value="'.$jenis_ujian.'">
														<input type="hidden" name="tanggal_ujian" value="'.$row['tanggal_ujian'].'">
														<input type="hidden" name="jam_mulai" value="'.$row['jam_mulai'].'">
														<input type="hidden" name="jam_selesai" value="'.$row['jam_selesai'].'">


														<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
														<button class="btn btn-secondary" name="edit_pengawas">Simpan Perubahan</button>
													</div>
												</form>
												</div>
												</div>
											</div>



											<a class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modalHapusPengawas'.$b['id_jadwal_lanjutan'].'"><i class="fa fa-trash"></i></a>
												<div class="modal fade" id="modalHapusPengawas'.$b['id_jadwal_lanjutan'].'" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
													<div class="modal-dialog">
													<div class="modal-content">
													<div class="modal-header bg-danger">
														<h3 class="modal-title" id="myModalLabel">Hapus Pengawas Ujian</h3>
														<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
													</div>
													<form class="form-horizontal" method="post" action="'.base_url().'tu/jadwal_ujian_lanjutan/hapus_pengawas_ujian'.'">
														<div class="modal-body">
															<p>Apakah anda yakin menghapus jadwal pengawas ini?</p>
														</div>
														<div class="modal-footer">

															<input type="hidden" name="id_jadwal_lanjutan" value="'.$b['id_jadwal_lanjutan'].'">
															<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
															<button class="btn btn-danger" name="hapus_pengawas">Ya</button>
														</div>
													</form>
													</div>
													</div>
												</div>
										</td>
									</tr>';

									 }
										}else{

					$tempAksi .= '<tr>
										<td colspan="6" class="text-center text-danger">TIDAK ADA DATA</td>
									</tr>';
										}

					$tempAksi .= '</table>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
						</div>
					</div>
					</div>
				</div>';
			$nestedData[] = $tempAksi;

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


		function jadwalkan_pengawas_ujian(){
			if(isset($_POST['jadwalkan_pengawas'])){
				$kode_jurusan = $_SESSION['kode_prodi'];
				$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
				$id_jadwal_ujian = $_POST['id_jadwal_ujian'];
				$jumlah_mhs_terjadwal_ujian = $_POST['jumlah_mhs_terjadwal_ujian'];
				$npk_pengawas1 = $_POST['npk_pengawas1'];
				$npk_pengawas2 = $_POST['npk_pengawas2'];
				$kode_ruang = $_POST['kode_ruang'];

				$jenis_ujian = $_POST['jenis_ujian'];
				$tanggal_ujian = $_POST['tanggal_ujian'];
				$jam_mulai = $_POST['jam_mulai'];
				$jam_selesai = $_POST['jam_selesai'];
				// echo $npk_pengawas2; die();


				if($jenis_ujian=="Luring"){
					if($npk_pengawas1!==$npk_pengawas2){
						// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas1($kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
							// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas2($kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
								// if($this->m_jadwal_ujian_lanjutan->check_ruang($kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
									if($this->m_jadwal_ujian_lanjutan->jadwalkan_pengawas_ujian($id_jadwal_ujian, $id_jadwal_kelas_pertemuan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
										$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											Data berhasil ditambahkan!
											</div>');
										redirect('tu/jadwal_ujian_lanjutan');
									}else{
										$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											Maaf, jadwal pengawas ujian gagal ditambahkan!
											</div>');
										redirect('tu/jadwal_ujian_lanjutan');
									}
						// 		}else{
						// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 				Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
						// 				</div>');
						// 			redirect('tu/jadwal_ujian_lanjutan');
						// 		}
						// 	}else {
						// 		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 			Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
						// 			</div>');
						// 		redirect('tu/jadwal_ujian_lanjutan');
						// 	}
						// }else {
						// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 		Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
						// 		</div>');
						// 	redirect('tu/jadwal_ujian_lanjutan');
						// }
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}

				}else{
					if($this->m_jadwal_ujian_lanjutan->jadwalkan_pengawas_ujian($id_jadwal_ujian, $id_jadwal_kelas_pertemuan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil ditambahkan!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, jadwal pengawas ujian gagal ditambahkan!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}
				}

			}else{
				redirect('tu/jadwal_ujian_lanjutan');
			}
		}

		function edit_pengawas_ujian(){
			if(isset($_POST['edit_pengawas'])){
				$kode_jurusan = $_SESSION['kode_prodi'];
				$id_jadwal_lanjutan = $_POST['id_jadwal_lanjutan'];

				$jumlah_mhs_terjadwal_ujian = $_POST['jumlah_mhs_terjadwal_ujian'];
				$npk_pengawas1 = $_POST['npk_pengawas1'];
				$npk_pengawas2 = $_POST['npk_pengawas2'];
				$kode_ruang = $_POST['kode_ruang'];

				$jenis_ujian = $_POST['jenis_ujian'];
				$tanggal_ujian = $_POST['tanggal_ujian'];
				$jam_mulai = $_POST['jam_mulai'];
				$jam_selesai = $_POST['jam_selesai'];
				// echo $npk_pengawas2; die();


				if($jenis_ujian=="Luring"){
					if($npk_pengawas1!==$npk_pengawas2){
						// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas1($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
							// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas2($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
								// if($this->m_jadwal_ujian_lanjutan->check_ruang($id_jadwal_lanjutan, $kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
									if($this->m_jadwal_ujian_lanjutan->edit_pengawas_ujian_luring($id_jadwal_lanjutan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
										$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											Data berhasil diedit!
											</div>');
										redirect('tu/jadwal_ujian_lanjutan');
									}else{
										$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											Maaf, jadwal pengawas ujian gagal diedit!
											</div>');
										redirect('tu/jadwal_ujian_lanjutan');
									}
						// 		}else{
						// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 				Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
						// 				</div>');
						// 			redirect('tu/jadwal_ujian_lanjutan');
						// 		}
						// 	}else {
						// 		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 			Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
						// 			</div>');
						// 		redirect('tu/jadwal_ujian_lanjutan');
						// 	}
						// }else {
						// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 		Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
						// 		</div>');
						// 	redirect('tu/jadwal_ujian_lanjutan');
						// }
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}

				}else{
					if($this->m_jadwal_ujian_lanjutan->edit_pengawas_ujian_daring($id_jadwal_lanjutan, $npk_pengawas1, $jumlah_mhs_terjadwal_ujian)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil diedit!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, jadwal pengawas ujian gagal diedit!
							</div>');
						redirect('tu/jadwal_ujian_lanjutan');
					}
				}

			}else{
				redirect('tu/jadwal_ujian_lanjutan');
			}
		}

		function hapus_pengawas_ujian(){
			if(isset($_POST['hapus_pengawas'])){
				$id_jadwal_lanjutan=addslashes ($this->input->post('id_jadwal_lanjutan'));
				if($this->m_jadwal_ujian_lanjutan->hapus_pengawas_ujian($id_jadwal_lanjutan)){
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil dihapus!
						</div>');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jadwal pengawas ujian gagal dihapus!
						</div>');
				}

			}
			redirect('tu/jadwal_ujian_lanjutan');
		}

}

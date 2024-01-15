<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_mengawas extends CI_Controller {

	function __construct(){
		parent::__construct();
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Dosen')!==0){
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
		$this->load->model('m_jadwal_mengawas');
	}

	public function index()
	{
        $kode_jurusan = $_SESSION['kode_jurusan'];
        $npk = $_SESSION['npk'];
        $x['data']=$this->m_jadwal_mengawas->show_jadwal_mengawas($kode_jurusan, $npk);
        // $x['combobox_kode_mk_prasyarat']=$this->m_jadwal_mengawas->combobox_kode_mk_prasyarat($kode_jurusan);
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_jadwal_mengawas', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function histori(){
		$kode_jurusan = $_SESSION['kode_jurusan'];
		$npk = $_SESSION['npk'];
        $x['data']=$this->m_jadwal_mengawas->show_histori($kode_jurusan, $npk);
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_histori', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function absensi(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$field_tanggal_absen = addslashes ($this->input->post('field_tanggal_absen'));
			$field_jam_absen = addslashes ($this->input->post('field_jam_absen'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));

			$this->m_jadwal_mengawas->absensi($id_jadwal_lanjutan, $field_tanggal_absen, $field_jam_absen);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Selamat, anda telah hadir!
				</div>');
			redirect('dosen/jadwal_mengawas');
		}
		else{
			redirect('welcome');
		}
	}

	function upload_foto_bukti(){
		if(isset($_POST['field'])){
			$field = addslashes ($this->input->post('field'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));

			$foto = $_FILES['gambar']['name'];

			$pecah = explode(".", $foto);
			$ekstensi = $pecah[1];
			
			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
				
			if (in_array($ekstensi, $extensionList))
			{
				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$fotobaru = $id_jadwal_lanjutan.'-'.date('dmYHis').$foto;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/img/bukti-mengawas/".$fotobaru;
				// memindahkan file ke temporary
				$tmp = $_FILES['gambar']['tmp_name'];
		
				// Proses upload
				if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$this->m_jadwal_mengawas->upload_foto_bukti($id_jadwal_lanjutan, $field, $fotobaru);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Selamat, foto bukti berhasil di upload!
						</div>');
					redirect('dosen/jadwal_mengawas');      
				}else{
					// Jika gambar gagal diupload, Lakukan :
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, foto bukti gagal diupload!
							</div>');
					redirect('dosen/jadwal_mengawas');
				}
			}
			else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, file yang diupload bukan file image!
				</div>');
				redirect('dosen/jadwal_mengawas');
			}
		}else{
			redirect('dosen/jadwal_mengawas');
		}	
	}

	function ganti_foto_bukti(){
		if(isset($_POST['field'])){
			$field = addslashes ($this->input->post('field'));
			$fotolama = addslashes ($this->input->post('fotolama'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));

			$foto = $_FILES['gambar']['name'];

			$pecah = explode(".", $foto);
			$ekstensi = $pecah[1];
			
			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
				
			if (in_array($ekstensi, $extensionList))
			{
				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$fotobaru = $id_jadwal_lanjutan.'-'.date('dmYHis').$foto;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/img/bukti-mengawas/".$fotobaru;
				// memindahkan file ke temporary
				$tmp = $_FILES['gambar']['tmp_name'];
		
				// Proses upload
				if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
					// Proses simpan ke Database
					$this->m_jadwal_mengawas->upload_foto_bukti($id_jadwal_lanjutan, $field, $fotobaru);
					unlink('templates/img/bukti-mengawas/'.$fotolama);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Selamat, foto bukti berhasil di ganti!
						</div>');
					redirect('dosen/jadwal_mengawas');      
				}else{
					// Jika gambar gagal diupload, Lakukan :
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, foto bukti gagal diupload!
							</div>');
					redirect('dosen/jadwal_mengawas');
				}
			}
			else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, file yang diupload bukan file image!
				</div>');
				redirect('dosen/jadwal_mengawas');
			}		
		}else{
			redirect('dosen/jadwal_mengawas');
		}
		
		
	}

	function hapus_foto_bukti(){
		if(isset($_POST['field'])){
			$field = addslashes ($this->input->post('field'));
			$fotolama = addslashes ($this->input->post('fotolama'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));

			
			$this->m_jadwal_mengawas->hapus_foto_bukti($id_jadwal_lanjutan, $field);
			unlink('templates/img/bukti-mengawas/'.$fotolama);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Selamat, foto bukti berhasil di hapus!
				</div>');
			redirect('dosen/jadwal_mengawas');
		}else{
			redirect('dosen/jadwal_mengawas');
		}  		
	}

	function input_data(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			$jenis_soal = addslashes ($this->input->post('jenis_soal'));

			$media = $this->input->post('media');
			if($media!=null){
				$media2= implode(", ", $media);
			}else{
				$media2 = $media;
			}

			$jumlah_peserta_hadir = addslashes ($this->input->post('jumlah_peserta_hadir'));
			$ket_pelaksanaan = addslashes ($this->input->post('ket_pelaksanaan'));

			$row = $this->m_jadwal_mengawas->ambil_jumlah_mahasiswa($id_jadwal_lanjutan);
			if(isset($row)){
				$jumlah_mahasiswa = $row->jumlah_mahasiswa;
			}

			// if($jumlah_mahasiswa<$jumlah_peserta_hadir){
			// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 		Maaf, jumlah mahasiswa yang ada inputkan lebih besar dari pada jumlah peserta ujian. Silahkan coba lagi!
			// 		</div>');
			// 	redirect('dosen/jadwal_mengawas');
			// }else{
				$this->m_jadwal_mengawas->input_data($id_jadwal_lanjutan, $jenis_soal, $media2, $jumlah_peserta_hadir, $ket_pelaksanaan);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil disimpan!
					</div>');
				redirect('dosen/jadwal_mengawas');
			// }
		}else{
			redirect('dosen/jadwal_mengawas');
		}
	}

	function edit_data_histori(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$field_status_verifikasi = addslashes ($this->input->post('field_status_verifikasi'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			$jenis_soal = addslashes ($this->input->post('jenis_soal'));

			$media = $this->input->post('media');
			if($media!=null){
				$media2= implode(", ", $media);
			}else{
				$media2 = $media;
			}

			$jumlah_peserta_hadir = addslashes ($this->input->post('jumlah_peserta_hadir'));
			$ket_pelaksanaan = addslashes ($this->input->post('ket_pelaksanaan'));

			$field_foto_bukti = addslashes ($this->input->post('field'));
			$field_status_verifikasi = addslashes ($this->input->post('field_status_verifikasi'));
			$fotolama = addslashes ($this->input->post('foto_bukti'));


			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
			$maxsize = 1024 * 200;

			$foto = $_FILES['gambar']['name'];

			// Cek apakah user ingin mengubah fotonya atau tidak
			if(empty($foto)){ // Jika user tidak memilih file foto pada form
				// Lakukan proses update tanpa mengubah fotonya
				// Proses ubah data ke Database
				$this->m_jadwal_mengawas->edit_data_histori($id_jadwal_lanjutan, $jenis_soal, $media2, $jumlah_peserta_hadir, $ket_pelaksanaan, $field_status_verifikasi);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Perubahan data dan minta ulang verifikasi berhasil dilakukan!
					</div>');
				redirect('dosen/jadwal_mengawas/histori');

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
						if($fotolama!=""){
							unlink('templates/img/bukti-mengawas/'.$fotolama);
						}
						$this->m_jadwal_mengawas->edit_data_histori_foto($id_jadwal_lanjutan, $jenis_soal, $media2, $jumlah_peserta_hadir, $ket_pelaksanaan, $field_status_verifikasi, $field_foto_bukti, $fotobaru);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Perubahan data dan minta ulang verifikasi berhasil dilakukan!
							</div>');
						redirect('dosen/jadwal_mengawas/histori');   
					}else{
						// Jika gambar gagal diupload, Lakukan :
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Foto gagal untuk diupload!
								</div>');
						redirect('dosen/jadwal_mengawas/histori');
					}
					
				}
				else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, file yang diupload bukan file image!
					</div>');
					redirect('dosen/jadwal_mengawas/histori');
				}	
			}
			///

			
		}else{
			redirect('dosen/jadwal_mengawas/histori');
		}
	}

	function hapus_data(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			$this->m_jadwal_mengawas->hapus_data($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus
				</div>');
			redirect('dosen/jadwal_mengawas');
		}else{
			redirect('dosen/jadwal_mengawas');
		}	
	}

	function submit(){
		if(isset($_POST['field'])){
			$field = addslashes ($this->input->post('field'));
			$field_tanggal_submit = addslashes ($this->input->post('field_tanggal_submit'));
			$field_jam_submit = addslashes ($this->input->post('field_jam_submit'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			
			$this->m_jadwal_mengawas->submit($id_jadwal_lanjutan, $field, $field_tanggal_submit, $field_jam_submit);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Informasi berhasil disubmit!
				</div>');
			redirect('dosen/jadwal_mengawas');
		}else{
			redirect('dosen/jadwal_mengawas');
		}		
	}

	function batal_submit(){
		if(isset($_POST['field'])){
			$field = addslashes ($this->input->post('field'));
			$field_tanggal_submit = addslashes ($this->input->post('field_tanggal_submit'));
			$field_jam_submit = addslashes ($this->input->post('field_jam_submit'));
			$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
			
			$this->m_jadwal_mengawas->batal_submit($id_jadwal_lanjutan, $field, $field_tanggal_submit, $field_jam_submit);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Submit berhasil dibatalkan!
				</div>');
			redirect('dosen/jadwal_mengawas');
		}else{
			redirect('dosen/jadwal_mengawas');
		}		
	}

	function upload_pengajuan(){
		if(isset($_POST['id_jadwal_lanjutan'])){

			$id_jadwal_lanjutan = $_POST['id_jadwal_lanjutan'];
			$field_tanggal_pengajuan_terlambat = $_POST['field_tanggal_pengajuan_terlambat'];
			$field_jam_pengajuan_terlambat = $_POST['field_jam_pengajuan_terlambat'];
			$field_file_pengajuan_terlambat = $_POST['field_file_pengajuan_terlambat'];
			$field_status_pengajuan_terlambat = $_POST['field_status_pengajuan_terlambat'];
			$alasan = $_POST['alasan'];
			
			$this->m_jadwal_mengawas->upload_pengajuan($id_jadwal_lanjutan, $field_tanggal_pengajuan_terlambat, $field_jam_pengajuan_terlambat, $field_file_pengajuan_terlambat, $field_status_pengajuan_terlambat, $alasan);
			// if($query){
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Pengajuan berhasil, silahkan tunggu persetujuan dari prodi!
					</div>');
				redirect('dosen/jadwal_mengawas/histori'); 
			// }else{
			// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 			// Maaf, pengajuan gagal dilakukan!
			// 			</div>');
			// 	redirect('dosen/jadwal_mengawas/histori');
			// }
					     
				

			// $berkas = $_FILES['berkas']['name'];

			// $extensionList = array("PDF", "pdf");
			// $pecah = explode(".", $berkas);
			// $ekstensi = $pecah[1];

			// if (in_array($ekstensi, $extensionList))
			// {
			// 	// Rename nama fotonya dengan menambahkan tanggal dan jam upload
			// 	$berkasbaru = date('dmYHis').$berkas;

			// 	// Set path folder tempat menyimpan fotonya
			// 	$path = "templates/file/user/dosen/pengajuan_terlambat/".$berkasbaru;
			// 	// memindahkan file ke temporary
			// 	$tmp = $_FILES['berkas']['tmp_name'];
			
			// 	// Proses upload
			// 	if(move_uploaded_file($tmp, $path)){ // Cek apakah berkas berhasil diupload atau tidak
			// 		// Proses simpan ke Database
					
			// 		$this->m_jadwal_mengawas->upload_pengajuan($id_jadwal_lanjutan, $field_tanggal_pengajuan_terlambat, $field_jam_pengajuan_terlambat, $field_file_pengajuan_terlambat, $field_status_pengajuan_terlambat, $berkasbaru);
			// 		$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
			// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 			Berkas berhasil diunggah..
			// 			</div>');
			// 		redirect('dosen/jadwal_mengawas/histori');      
			// 	}else{
			// 		// Jika berkas gagal diupload, Lakukan :
			// 		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 				Maaf, berkas gagal untuk diunggah!
			// 				</div>');
			// 		redirect('dosen/jadwal_mengawas/histori');
			// 	}
			// }
			// else{
			// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 		Maaf, file yang diupload bukan file PDF!
			// 	</div>');
			// 	redirect('dosen/jadwal_mengawas/histori');
			// }	
			
		}else{
			redirect('dosen/jadwal_mengawas/histori');
		}
	
	}


}

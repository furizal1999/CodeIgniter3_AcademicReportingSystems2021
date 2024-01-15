<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Dosen extends CI_Controller {

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
		$this->load->model('m_dosen_terverifikasi');
	}

	public function index()
	{

		$x['combobox_prodi']=$this->m_dosen_terverifikasi->combobox_prodi();
		if(isset($_POST['tombol_cari'])){
			$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
		}
		if(isset($_SESSION['kode_prodi'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
		$x['data']=$this->m_dosen_terverifikasi->show_dosen_terverifikasi($kode_jurusan);
		$x['combobox_jurusan']=$this->m_dosen_terverifikasi->combobox_jurusan();
		}
        
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_dosen_terverifikasi', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);

		
        // $x['combobox_kode_mk_prasyarat']=$this->m_dosen_terverifikasi->combobox_kode_mk_prasyarat($kode_jurusan);
		
	}

	public function daftar_akun_dosen()
	{
		if(isset($_POST['npk'])){
			$npk = $_SESSION['kode_prodi'].addslashes($this->input->post('npk'));
			$status_jabatan = addslashes($this->input->post('status_jabatan'));
			$nama_dosen = addslashes($this->input->post('nama_dosen'));
			$jk = addslashes($this->input->post('jk'));
			$jabatan_fungsional = addslashes($this->input->post('jabatan_fungsional'));
			$pendidikan = addslashes($this->input->post('pendidikan'));
			$status_dosen = addslashes($this->input->post('status_dosen'));
			$email = "";
			$kode_jurusan = $_SESSION['kode_prodi'];

			$password = addslashes($this->input->post('password'));
			$konfirmasi_password = addslashes($this->input->post('konfirmasi_password'));
			$foto = "";
			$status = "Aktif";

			if($this->m_dosen_terverifikasi->checkPrimaryKey($npk)==-1){
				if($password==$konfirmasi_password){
						$password_enc = password_hash($password, PASSWORD_DEFAULT);
						
						// Proses Update ke Database
						$this->m_dosen_terverifikasi->edit_dosen_dihapus($npk, $status);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Berhasil... Catatan : <ol><li>NPK/NIDN ini telah terdaftar sebelumnya atau kemungkinan telah dihapus... Namun sekarang telah kami aktifkan kembali... Dan histori terkait akun bisa untuk diakses kembali... Terima kasih...</li><li>Jika anda tidak menemukan datanya di prodi anda, pastikan bahwa NPK/NIDN yang anda input belum terdaftar di program studi lain...</li><li>Silahkan coba login menggunakan NPK/NIDN dan Password yang anda inputkan..</li></ol>
							</div>');
						redirect('tu/dosen');      
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, konfirmasi password anda tidak sesuai. Silahkan coba lagi!
						</div>');
					redirect('tu/dosen');
				}
			}
			else {
				if($password==$konfirmasi_password){
						$password_enc = password_hash($password, PASSWORD_DEFAULT);
						
						// Proses simpan ke Database
						$this->m_dosen_terverifikasi->daftar_akun_dosen($npk, $status_jabatan, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen, $password_enc, $foto, $status);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Tambah akun berhasil...
							</div>');
						redirect('tu/dosen');      
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, konfirmasi password anda tidak sesuai. Silahkan coba lagi!
						</div>');
					redirect('tu/dosen');
				}
			}
		}else{
			redirect('tu/dosen');
		}
	}

	function edit_dosen_terverifikasi(){
		if(isset($_POST['npk'])){
			$npk = addslashes($this->input->post('npk'));
			$nama_dosen = addslashes($this->input->post('nama_dosen'));
			$jk = addslashes($this->input->post('jk'));
			$email = addslashes($this->input->post('email'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$jabatan_fungsional = addslashes($this->input->post('jabatan_fungsional'));
			$pendidikan = addslashes($this->input->post('pendidikan'));
			$status_dosen = addslashes($this->input->post('status_dosen'));
			$nama_foto_lama = addslashes($this->input->post('nama_foto_lama'));
			$foto = $_FILES['gambar']['name'];
			//ekstensi foto yang akan diperbolehkan di program
			$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
			$maxsize = 1024 * 200;

			// Cek apakah user ingin mengubah fotonya atau tidak
			if(empty($foto)){ // Jika user tidak memilih file foto pada form
				// Lakukan proses update tanpa mengubah fotonya
				// Proses ubah data ke Database
				$this->m_dosen_terverifikasi->edit_dosen_terverifikasi_nophoto($npk, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil diedit!
							</div>');
				redirect('tu/dosen');

			}else{ // Jika user memilih foto / mengisi input file foto pada form
				// Lakukan proses update termasuk mengganti foto sebelumnya
				$pecah = explode(".", $foto);
				$ekstensi = $pecah[1];
				if (in_array($ekstensi, $extensionList))
					{
						// Rename nama fotonya dengan menambahkan tanggal dan jam upload
						$fotobaru = date('dmYHis').$foto;

						// Set path folder tempat menyimpan fotonya
						$path = "templates/img/dosen/".$fotobaru;
						// memindahkan file ke temporary
						$tmp = $_FILES['gambar']['tmp_name'];
					
						if($_FILES['gambar']['size']<=$maxsize){
							// Proses upload
							if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
								// Proses simpan ke Database
								if($nama_foto_lama!=""){
									unlink('templates/img/dosen/'.$nama_foto_lama);
								}
								$this->m_dosen_terverifikasi->edit_dosen_terverifikasi($npk, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen, $fotobaru);
								$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Data berhasil diedit!
									</div>');
								redirect('tu/dosen');      
							}else{
								// Jika gambar gagal diupload, Lakukan :
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Gambar gagal untuk diupload!
										</div>');
								redirect('tu/dosen');
							}
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Ukuran foto besar dari 200 kb!
							</div>');
							redirect('tu/dosen');
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, file yang diupload bukan file image!
						</div>');
						redirect('tu/dosen');
					}	
			}
		}else{
			redirect('tu/dosen');
		}
	}

	function hapus_dosen_terverifikasi(){
		if(isset($_POST['npk'])){
			$npk=addslashes($this->input->post('npk'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$nama_foto_lama = addslashes($this->input->post('nama_foto_lama'));
			$this->m_dosen_terverifikasi->hapus_dosen_terverifikasi($kode_jurusan, $npk);
			if($nama_foto_lama!=""){
				unlink('templates/img/dosen/'.$nama_foto_lama);
			}
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
		}
		redirect('tu/dosen');
	}

	function batal_verifikasi(){
		if(isset($_POST['npk'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$npk=addslashes($this->input->post('npk'));
			$this->m_dosen_terverifikasi->batal_verifikasi($kode_jurusan, $npk);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Pembatalan Verifikasi berhasil!
				</div>');
		}
		redirect('tu/dosen');
	}

	function verifikasi(){
		if(isset($_POST['npk'])){
			$npk=addslashes($this->input->post('npk'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$this->m_dosen_terverifikasi->verifikasi($kode_jurusan, $npk);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Verifikasi berhasil!
				</div>');
		}
		redirect('tu/dosen');
	}

	function reset_password(){
		if(isset($_POST['reset_password'])){

			$npk=addslashes($this->input->post('npk'));
			$password_baru=addslashes($this->input->post('password_baru'));
			$konfirmasi_password_baru=addslashes($this->input->post('konfirmasi_password_baru'));
			$npk=addslashes($this->input->post('npk'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			if($password_baru==$konfirmasi_password_baru){

				$password_baru_enc = password_hash($password_baru, PASSWORD_DEFAULT);
				if($this->m_dosen_terverifikasi->reset_password($kode_jurusan, $npk, $password_baru_enc)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Password akun berhasil direset!
						</div>');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Password akun gagal direset!
					</div>');
				}
				
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, konfirmasi password tidak sesuai. Silahkan coba lagi!
					</div>');
			}
		}
		redirect('tu/dosen');
	}

}

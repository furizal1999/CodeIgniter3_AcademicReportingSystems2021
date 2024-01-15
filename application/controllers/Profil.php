<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Profil extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_profil');
		$this->load->helper(array('url','download'));
		if((!isset($_SESSION['login_smpu']))){	
			redirect('halaman_tamu');
		}
	}

	public function index()
	{
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('public/v_profil');
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	public function editProfil(){
		if(isset($_POST['status_login'])){
			if($_POST['status_login']=="Fakultas" || $_POST['status_login']=="Prodi" || $_POST['status_login']=="UPM" || $_POST['status_login']=="Tata Usaha" || $_POST['status_login']=="Developer"){
				$username = addslashes ($this->input->post('username'));
				$status_login = addslashes ($this->input->post('status_login'));
				$nama = addslashes ($this->input->post('nama'));
				$npk = addslashes ($this->input->post('npk'));
				$jk = addslashes ($this->input->post('jk'));
				// $jabatan = addslashes ($this->input->post('jabatan'));
				$no_hp = addslashes ($this->input->post('no_hp'));
				$email = addslashes ($this->input->post('email'));

				if($_POST['status_login']=="UPM"){
					$namatabel = "tb_upm";
					$field_nama = "nama";
				}elseif($_POST['status_login']=="Developer"){
					$namatabel = "tb_developer";
					$field_nama = "nama";
				}elseif($_POST['status_login']=="Fakultas"){
					$namatabel = "tb_fakultas";
					$field_nama = "nama";
				}elseif($_POST['status_login']=="Tata Usaha"){
					$namatabel = "tb_tu";
					$field_nama = "nama";
				}else{
					$namatabel = "tb_prodi_attribut";
					$field_nama = "nama_lengkap";
				}
				//ekstensi foto yang akan diperbolehkan di program
				$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
				$maxsize = 1024 * 200;

				$foto = $_FILES['gambar']['name'];

				// Cek apakah user ingin mengubah fotonya atau tidak
				if(empty($foto)){ // Jika user tidak memilih file foto pada form
					// Lakukan proses update tanpa mengubah fotonya
					// Proses ubah data ke Database
					$this->m_profil->edit_profil_nophoto($namatabel, $field_nama, $username, $nama, $npk, $jk, $no_hp, $email);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Data anda berhasil diedit!
								</div>');
					//set session
					$_SESSION["username"] = $username;
					$_SESSION["nama"] = $nama;
					$_SESSION["npk"] = $npk;
					$_SESSION["jenis_kelamin"] = $jk;
					
					$_SESSION["no_hp"] = $no_hp;
					$_SESSION["email"] = $email;
					redirect('profil');

				}else{ // Jika user memilih foto / mengisi input file foto pada form
					$pecah = explode(".", $foto);
					$ekstensi = $pecah[1];

					// Rename nama fotonya dengan menambahkan tanggal dan jam upload
					$fotobaru = date('dmYHis').$foto;

					// Set path folder tempat menyimpan fotonya
					$path = "templates/img/dosen/".$fotobaru;
					// Lakukan proses update termasuk mengganti foto sebelumnya
					if (in_array($ekstensi, $extensionList)){
						// memindahkan file ke temporary
						$tmp = $_FILES['gambar']['tmp_name'];
					
						if($_FILES['gambar']['size']<=$maxsize){
							// Proses upload
							if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
								// Proses simpan ke Database
								// if($_SESSION['foto']!=""){
								// 	unlink('templates/img/dosen/'.$_SESSION['foto']);
								// }
								$this->m_profil->edit_profil($namatabel, $field_nama, $username, $nama, $npk, $jk, $no_hp, $email, $fotobaru);
								$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Data anda berhasil diedit!
									</div>');
								//set session
								$_SESSION["username"] = $username;
								$_SESSION["nama"] = $nama;
								$_SESSION["npk"] = $npk;
								$_SESSION["jenis_kelamin"] = $jk;
								
								$_SESSION["no_hp"] = $no_hp;
								$_SESSION["email"] = $email;
								$_SESSION["foto"] = $fotobaru;
								redirect('profil');      
							}else{
								// Jika gambar gagal diupload, Lakukan :
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Foto gagal untuk diupload!
										</div>');
								redirect('profil');
							}
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Ukuran foto besar dari 200 kb!
							</div>');
							redirect('profil');
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, file yang diupload bukan file image!
						</div>');
						redirect('profil');
					}	
				}	
			}else{
				$username = addslashes ($this->input->post('username'));
				$status_login = addslashes ($this->input->post('status_login'));
				$nama = addslashes ($this->input->post('nama'));
				$npk = addslashes ($this->input->post('npk'));
				$jk = addslashes ($this->input->post('jk'));

				// $tempat_lahir = addslashes ($this->input->post('tempat_lahir'));
				// $tanggal_lahir = addslashes ($this->input->post('tanggal_lahir'));
				// $keahlian = addslashes ($this->input->post('keahlian'));
				// $alamat = addslashes ($this->input->post('alamat'));

				// $no_hp = addslashes ($this->input->post('no_hp'));
				$email = addslashes ($this->input->post('email'));

				//ekstensi foto yang akan diperbolehkan di program
				$extensionList = array("png", "jpg", "jpeg", "PNG", "JPG", "JPEG");
				$maxsize = 1024 * 200;

				$foto = $_FILES['gambar']['name'];

				// Cek apakah user ingin mengubah fotonya atau tidak
				if(empty($foto)){ // Jika user tidak memilih file foto pada form
					// Lakukan proses update tanpa mengubah fotonya
					// Proses ubah data ke Database
					$this->m_profil->edit_profil_dosen_nophoto($nama, $npk, $jk, $email);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Data anda berhasil diedit!
								</div>');
					//set session
					$_SESSION["nama"] = $nama;
					$_SESSION["npk"] = $npk;
					$_SESSION["jenis_kelamin"] = $jk;
					// $_SESSION["tempat_lahir"] = $tempat_lahir;
					// $_SESSION["tanggal_lahir"] = $tanggal_lahir;
					// $_SESSION["keahlian"] = $keahlian;
					// $_SESSION["alamat"] = $alamat;
					// $_SESSION["no_hp"] = $no_hp;
					$_SESSION["email"] = $email;
					redirect('profil');

				}else{ // Jika user memilih foto / mengisi input file foto pada form
					$pecah = explode(".", $foto);
					$ekstensi = $pecah[1];

					// Rename nama fotonya dengan menambahkan tanggal dan jam upload
					$fotobaru = date('dmYHis').$foto;

					// Set path folder tempat menyimpan fotonya
					$path = "templates/img/dosen/".$fotobaru;
					// Lakukan proses update termasuk mengganti foto sebelumnya
					if (in_array($ekstensi, $extensionList)){
						// memindahkan file ke temporary
						$tmp = $_FILES['gambar']['tmp_name'];
					
						if($_FILES['gambar']['size']<=$maxsize){
							// Proses upload
							if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
								// Proses simpan ke Database
								// unlink('templates/img/dosen/'.$_SESSION['foto']);
								$this->m_profil->edit_profil_dosen($nama, $npk, $jk, $email, $fotobaru);
								$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Data anda berhasil diedit!
									</div>');
								//set session
								$_SESSION["nama"] = $nama;
								$_SESSION["npk"] = $npk;
								$_SESSION["jenis_kelamin"] = $jk;
								// $_SESSION["tempat_lahir"] = $tempat_lahir;
								// $_SESSION["tanggal_lahir"] = $tanggal_lahir;
								// $_SESSION["keahlian"] = $keahlian;
								// $_SESSION["alamat"] = $alamat;
								// $_SESSION["no_hp"] = $no_hp;
								$_SESSION["email"] = $email;
								$_SESSION["foto"] = $fotobaru;
								redirect('profil');      
							}else{
								// Jika gambar gagal diupload, Lakukan :
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Foto gagal untuk diupload!
										</div>');
								redirect('profil');
							}
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Ukuran foto besar dari 200 kb!
							</div>');
							redirect('profil');
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, file yang diupload bukan file image!
						</div>');
						redirect('profil');
					}	
				}	
			}
		}else{
			redirect('profil');
		}
	}

	function ganti_password(){
		if(isset($_POST['password_baru'])){
			$password_lama = addslashes ($this->input->post('password_lama'));
			$password_baru = addslashes ($this->input->post('password_baru'));
			$konfirmasi_password_baru = addslashes ($this->input->post('konfirmasi_password_baru'));

			if($_SESSION['status_login']=="UPM"){
				$isi = $_SESSION['username'];
				$nama_tabel = "tb_upm";
				$nama_field = "username";
			}elseif($_SESSION['status_login']=="Fakultas"){
				$isi = $_SESSION['username'];
				$nama_tabel = "tb_fakultas";
				$nama_field = "username";
			}elseif($_SESSION['status_login']=="Tata Usaha"){
				$isi = $_SESSION['username'];
				$nama_tabel = "tb_tu";
				$nama_field = "username";
			}elseif($_SESSION['status_login']=="Prodi"){
				$isi = $_SESSION['username'];
				$nama_tabel = "tb_prodi_attribut";
				$nama_field = "username";
			}else{
				$isi = $_SESSION['npk'];
				$nama_tabel = "tb_dosen";
				$nama_field = "npk";
			}

			$row = $this->m_profil->ambil($nama_tabel, $nama_field, $isi);
			if(isset($row)){
				$password_encripsi = $row->password;
				if(password_verify($password_lama, $password_encripsi)){
					$password_baru_enc = password_hash($password_baru, PASSWORD_DEFAULT);
					if(strcmp($password_baru, $konfirmasi_password_baru)==0){
						$this->m_profil->ganti_password($nama_tabel, $nama_field, $isi, $password_baru_enc);
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Password akun anda berhasil diubah..
							</div>');
						redirect('profil');
						date_default_timezone_set('Asia/Jakarta');
						$this->m_profil->input_log($_SESSION['status'],$_SESSION['id'],$_SESSION['nama'],date('Y/m/d'),date("H:i:s"),'Ganti sandi akun');
						redirect('profil');
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Konfirmasi sandi baru tidak sesuai!
							</div>');
						redirect('profil');
					}
				}
				else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Password lama tidak sesuai!
							</div>');
					redirect('profil');
				}
			}
		}else{
			redirect('profil');
		}
	}
}

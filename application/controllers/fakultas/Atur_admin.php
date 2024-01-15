<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Atur_admin extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Fakultas')!==0 ){
				//tidak dibolehkan
				if(strcmp($_SESSION["status_login"], 'Prodi')==0){
					redirect('welcome');
				}else{
					redirect('welcome');
				}
			}else{
				if($_SESSION['hak_akses']!=="Super"){
					redirect('welcome');
				}else{
					//dibolehkan
				}
			}
		}
		$this->load->model('m_atur_admin');
	}

	public function index()
	{
        $x['data']=$this->m_atur_admin->show_atur_admin_fakultas();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('fakultas/v_atur_admin', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_admin(){

		if(isset($_POST['npk'])){
			$npk = addslashes ($this->input->post('npk'));
			$nama_lengkap = addslashes ($this->input->post('nama_lengkap'));
			$jk = addslashes ($this->input->post('jk'));
			$email = addslashes ($this->input->post('email'));
			$no_hp = addslashes ($this->input->post('no_hp'));
			$jabatan = addslashes ($this->input->post('jabatan'));
			$password = addslashes ($this->input->post('password'));
			$konfirmasi_password = addslashes ($this->input->post('konfirmasi_password'));
			$hak_akses = 'Admin';
			$username = 'admin3'.$npk;
			$foto = "";
			$status_akun ="Aktif";

			if($this->m_atur_admin->checkUsername($username)==-1){
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, npk yang anda masukkan telah didaftarkan sebelumnya.. Silahkan cek kembali!
					</div>');
				redirect('fakultas/atur_admin');
			}
			else {
				if($password==$konfirmasi_password){
					$password_enc = password_hash($password, PASSWORD_DEFAULT);
					$this->m_atur_admin->tambah_admin_fakultas($username, $nama_lengkap, $npk, $jk, $email, $no_hp, $jabatan, $hak_akses, $password_enc, $foto, $status_akun);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil ditambahkan!
						</div>');
					redirect('fakultas/atur_admin');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, konfirmasi password tidak sesuai.. Silahkan coba lagi!
						</div>');
					redirect('fakultas/atur_admin');
				}
			}
		}else{
			redirect('fakultas/atur_admin');
		}
		
	}

	function edit_admin(){
		if(isset($_POST['username'])){
			$username = addslashes ($this->input->post('username'));
			$nama_lengkap = addslashes ($this->input->post('nama_lengkap'));
			$jk = addslashes ($this->input->post('jk'));
			$email = addslashes ($this->input->post('email'));
			$no_hp = addslashes ($this->input->post('no_hp'));
			$jabatan = addslashes ($this->input->post('jabatan'));

			$this->m_atur_admin->edit_admin_fakultas($username, $nama_lengkap, $jk, $email, $no_hp, $jabatan);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');
			redirect('fakultas/atur_admin');
		}else{
			redirect('fakultas/atur_admin');
		}
		
	}

	function hapus_admin(){
		if(isset($_POST['username'])){
			$username=addslashes ($this->input->post('username'));
			$foto=addslashes ($this->input->post('foto'));
			$this->m_atur_admin->hapus_admin_fakultas($username);
			if($foto!=""){
				unlink('templates/img/dosen/'.$foto);
			}
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
		}
		redirect('fakultas/atur_admin');
	}

	function aktifkan_admin(){
		if(isset($_POST['username'])){
			$username=addslashes ($this->input->post('username'));
			$this->m_atur_admin->aktifkan_admin_fakultas($username);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Akun berhasil di aktifkan!
				</div>');
		}
		redirect('fakultas/atur_admin');
	}

	function nonaktifkan_admin(){
		if(isset($_POST['username'])){
			$username=addslashes ($this->input->post('username'));
			$this->m_atur_admin->nonaktifkan_admin_fakultas($username);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Akun berhasil di non-aktifkan!
				</div>');	
		}
		redirect('fakultas/atur_admin');
	}

}

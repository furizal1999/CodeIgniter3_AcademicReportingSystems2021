<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Program_studi extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
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
				//dibolehkan
			}
		}
		$this->load->model('m_program_studi');
	}

	public function index()
	{
        $x['data']=$this->m_program_studi->show_program_studi();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('fakultas/v_program_studi', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_program_studi(){
		if(isset($_POST['kode_prodi'])){
			$kode_prodi = addslashes ($this->input->post('kode_prodi'));
			$nama_prodi = addslashes ($this->input->post('nama_prodi'));
			$jenjang = addslashes ($this->input->post('jenjang'));
			$akreditasi = addslashes ($this->input->post('akreditasi'));

			if($this->m_program_studi->checkPrimaryKey($kode_prodi)==-1){
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Kode prodi yang ada masukkan telah tersedia.. Silahkan masukkan kode prodi yang berbeda!
					</div>');
				redirect('fakultas/program_studi');
			}
			else {
				$this->m_program_studi->tambah_program_studi($kode_prodi, $nama_prodi, $jenjang, $akreditasi);
				$this->m_program_studi->tambah_admin_program_studi($kode_prodi);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil ditambahkan!
					</div>');
				redirect('fakultas/program_studi');
			}
		}else{
			redirect('fakultas/program_studi');
		}
		
	}
	

	function edit_program_studi(){
		if(isset($_POST['kode_prodi'])){
			$kode_prodi = addslashes ($this->input->post('kode_prodi'));
			$nama_prodi = addslashes ($this->input->post('nama_prodi'));
			$jenjang = addslashes ($this->input->post('jenjang'));
			$akreditasi = addslashes ($this->input->post('akreditasi'));
			$this->m_program_studi->edit_program_studi($kode_prodi, $nama_prodi, $jenjang, $akreditasi);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');
		}
		redirect('fakultas/program_studi');
	}

	function hapus_program_studi(){
		if(isset($_POST['kode_prodi'])){
			$kode_prodi = addslashes ($this->input->post('kode_prodi'));
			$this->m_program_studi->hapus_program_studi($kode_prodi);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');	
		}
		redirect('fakultas/program_studi');
	}

}

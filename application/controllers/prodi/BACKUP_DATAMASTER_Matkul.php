<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Matkul extends CI_Controller {

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
		$this->load->model('m_matkul');
	}

	public function index()
	{
        $kode_jurusan = $_SESSION['kode_prodi'];
        $x['data']=$this->m_matkul->show_matkul($kode_jurusan);
        $x['combobox_kode_mk_prasyarat']=$this->m_matkul->combobox_kode_mk_prasyarat($kode_jurusan);
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_matkul', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_matkul(){
		if(isset($_POST['kode_mk'])){
			$kode_mk = addslashes ($this->input->post('kode_mk'));
			$nama_mk = addslashes ($this->input->post('nama_mk'));
			$sks_teori = addslashes ($this->input->post('sks_teori'));
			$sks_praktik = addslashes ($this->input->post('sks_praktik'));
			$semester = addslashes ($this->input->post('semester'));
			$kode_mk_prasyarat = addslashes ($this->input->post('kode_mk_prasyarat'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$kode_mk = $kode_jurusan.$kode_mk;

			if($this->m_matkul->checkPrimaryKey($kode_mk)==-1){
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Kode matakuliah ini telah tersedia... silahkan masukkan kode yang lain!
					</div>');
				redirect('prodi/matkul');
			}
			else {
				$this->m_matkul->tambah_matkul($kode_mk, $nama_mk, $sks_teori, $sks_praktik, $semester, $kode_mk_prasyarat, $kode_jurusan);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil ditambahkan!
					</div>');
				redirect('prodi/matkul');
			}
		}else{
			redirect('prodi/matkul');
		}
	}

	function edit_matkul(){
		if(isset($_POST['kode_mk'])){
			$kode_mk = addslashes ($this->input->post('kode_mk'));
			$nama_mk = addslashes ($this->input->post('nama_mk'));
			$sks_teori = addslashes ($this->input->post('sks_teori'));
			$sks_praktik = addslashes ($this->input->post('sks_praktik'));
			$semester = addslashes ($this->input->post('semester'));
			$kode_mk_prasyarat = addslashes ($this->input->post('kode_mk_prasyarat'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$this->m_matkul->edit_matkul($kode_mk, $nama_mk, $sks_teori, $sks_praktik, $semester, $kode_mk_prasyarat, $kode_jurusan);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');
		}
		redirect('prodi/matkul');
	}

	function hapus_matkul(){
		if(isset($_POST['kode_mk'])){
			$kode_mk=addslashes ($this->input->post('kode_mk'));
			$this->m_matkul->hapus_matkul($kode_mk);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');	
		}
		redirect('prodi/matkul');
	}

}

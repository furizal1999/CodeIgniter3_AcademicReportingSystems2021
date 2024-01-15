<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Kelas extends CI_Controller {

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
		$this->load->model('m_kelas');
	}

	public function index()
	{
        $kode_jurusan = $_SESSION['kode_prodi'];
        $x['data']=$this->m_kelas->show_kelas($kode_jurusan);
        // $x['combobox_kode_mk_prasyarat']=$this->m_kelas->combobox_kode_mk_prasyarat($kode_jurusan);
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_kelas', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_kelas(){
		if(isset($_POST['semester'])){
			$semester = addslashes ($this->input->post('semester'));
			$kelas = addslashes ($this->input->post('kelas'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$kelas_pilihan = addslashes ($this->input->post('kelas_pilihan'));

			$this->m_kelas->tambah_kelas($kode_jurusan, $semester, $kelas, $kelas_pilihan);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil ditambahkan!
				</div>');
		}
		redirect('prodi/kelas');
	}

	function edit_kelas(){
		if(isset($_POST['id_kelas'])){
			$id_kelas = addslashes ($this->input->post('id_kelas'));
			$semester = addslashes ($this->input->post('semester'));
			$kelas = addslashes ($this->input->post('kelas'));
			$kelas_pilihan = addslashes ($this->input->post('kelas_pilihan'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$this->m_kelas->edit_kelas($id_kelas, $kode_jurusan, $semester, $kelas, $kelas_pilihan);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');	
		}
		redirect('prodi/kelas');
	}

	function hapus_kelas(){
		if(isset($_POST['id_kelas'])){
			$id_kelas=addslashes ($this->input->post('id_kelas'));
			$this->m_kelas->hapus_kelas($id_kelas);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');	
		}
		redirect('prodi/kelas');
	}

}

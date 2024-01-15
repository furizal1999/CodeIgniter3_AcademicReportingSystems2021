<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Ruang extends CI_Controller {

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
		$this->load->model('m_ruang');
	}

	public function index()
	{
        $kode_jurusan = $_SESSION['kode_prodi'];
        $x['data']=$this->m_ruang->show_ruang($kode_jurusan);
        $x['combobox_kode_mk_prasyarat']=$this->m_ruang->combobox_kode_mk_prasyarat($kode_jurusan);
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_ruang', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_ruang(){
		if(isset($_POST['kode_ruang'])){
			$kode_ruang = addslashes ($this->input->post('kode_ruang'));
			$kapasitas = addslashes ($this->input->post('kapasitas'));
			$ket = addslashes ($this->input->post('ket'));
			$kode_jurusan = $_SESSION['kode_prodi'];

			if($this->m_ruang->checkPrimaryKey($kode_ruang)==-1){
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Kode ruang yang ada masukkan telah tersedia.. Silahkan masukkan kode ruang yang berbeda!
					</div>');
				redirect('prodi/ruang');
			}
			else {
				$this->m_ruang->tambah_ruang($kode_ruang, $kapasitas, $kode_jurusan, $ket);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil ditambahkan!
					</div>');
				redirect('prodi/ruang');
			}
		}else{
			redirect('prodi/ruang');
		}
	}

	function edit_ruang(){
		if(isset($_POST['kode_ruang'])){
			$kode_ruang = addslashes ($this->input->post('kode_ruang'));
			$kapasitas = addslashes ($this->input->post('kapasitas'));
			$ket = addslashes ($this->input->post('ket'));
			$kode_jurusan = $_SESSION['kode_prodi'];
			$this->m_ruang->edit_ruang($kode_ruang, $kapasitas, $kode_jurusan, $ket);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');	
		}
		redirect('prodi/ruang');
	}

	function hapus_ruang(){
		if(isset($_POST['kode_ruang'])){
			$kode_ruang=addslashes ($this->input->post('kode_ruang'));
			$this->m_ruang->hapus_ruang($kode_ruang);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');	
		}
		redirect('prodi/ruang');
	}

}

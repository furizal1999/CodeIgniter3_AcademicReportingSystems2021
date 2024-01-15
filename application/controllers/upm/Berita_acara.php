<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class berita_acara extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'UPM')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				//dibolehkan
			}
		}

		$this->load->model('m_berita_acara');
		
	}

	public function index()
	{
			if(isset($_POST['id_ujian'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}

			$x['combobox_prodi']=$this->m_berita_acara->combobox_prodi();
			$x['combobox_ujian']=$this->m_berita_acara->combobox_ujian();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){
				$kode_jurusan = $_SESSION['kode_prodi'];
				$x['data']=$this->m_berita_acara->show_berita_acara($kode_jurusan,$_SESSION['id_ujian_search']);
			}
			$this->load->view('upm/v_berita_acara', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
	}

	
}

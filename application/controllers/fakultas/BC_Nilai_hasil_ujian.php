<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Nilai_hasil_ujian extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Fakultas')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				//dibolehkan
				
			}
		}

		$this->load->model('m_nilai_hasil_ujian');
	}

	public function index()
	{
		if(isset($_POST['id_ujian'])){
			$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
		}

		if(isset($_POST['kode_prodi'])){
			$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
		}


		
		$x['combobox_prodi']=$this->m_nilai_hasil_ujian->combobox_prodi();
		$x['combobox_ujian']=$this->m_nilai_hasil_ujian->combobox_ujian();
		
		if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$x['data']=$this->m_nilai_hasil_ujian->show_soal_ujian($_SESSION['id_ujian_search'], $kode_jurusan);
		}
        
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('fakultas/v_nilai_hasil_ujian', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}	

}

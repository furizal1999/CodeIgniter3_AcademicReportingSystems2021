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

		$this->load->model('m_berita_acara');
		
	}

	public function index()
	{

		
			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			$kode_jurusan = $_SESSION['kode_prodi'];

			if(isset($_SESSION['id_ujian_search'])){
				$x['data']=$this->m_berita_acara->show_berita_acara($kode_jurusan,$_SESSION['id_ujian_search']);
			}

			$x['combobox_ujian']=$this->m_berita_acara->combobox_ujian();
			
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_berita_acara', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
			
	}

	
}

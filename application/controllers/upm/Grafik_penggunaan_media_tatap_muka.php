<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Grafik_penggunaan_media_tatap_muka extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'UPM')!==0 ){
				//tidak dibolehkan
					redirect('welcome');
			}else{
				
			}
		}

		$this->load->model('m_grafik_penggunaan_media_tatap_muka');
	}

	public function index()
	{
			
			if(isset($_POST['id_pertemuan'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
			}
			$x['combobox_pertemuan']=$this->m_grafik_penggunaan_media_tatap_muka->combobox_pertemuan();
			$x['combobox_prodi']=$this->m_grafik_penggunaan_media_tatap_muka->combobox_prodi();
			
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('upm/v_grafik_penggunaan_media_tatap_muka', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
	}
}

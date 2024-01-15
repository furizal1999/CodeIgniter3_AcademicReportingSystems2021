<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Monitoring_pengawas extends CI_Controller {

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
				// if(!$_SESSION['jabatan']=='Wakil Dekan I' || !$_SESSION['jabatan']=='Wakil Dekan III'){
				// 	redirect('welcome');
				// }
			}
		}

		$this->load->model('m_permintaan_verifikasi');
	}

	public function index()
	{
			
			if(isset($_POST['id_ujian'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}


			
			$x['combobox_prodi']=$this->m_permintaan_verifikasi->combobox_prodi();
			$x['combobox_ujian']=$this->m_permintaan_verifikasi->combobox_ujian();
			
			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){

				
				$kode_jurusan = $_SESSION['kode_prodi'];
				$x['data']=$this->m_permintaan_verifikasi->show_permintaan_verifikasi($_SESSION['kode_prodi'], $_SESSION['id_ujian_search']);
				
			}
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('fakultas/v_monitoring_pengawas', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
	}
}

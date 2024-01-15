<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Presensi_pengawas extends CI_Controller {

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

		$this->load->model('m_presensi_pengawas');
		
	}

	public function index()
	{
			$kode_prodi = $_SESSION['kode_prodi'];

			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $this->input->post('id_ujian');
			}
			
			if(isset($_SESSION['id_ujian_search'])){
				$x['data_tanggal_ujian']=$this->m_presensi_pengawas->show_tanggal_ujian($kode_prodi, $_SESSION['id_ujian_search']);
				$x['data']=$this->m_presensi_pengawas->show_jadwal($kode_prodi, $_SESSION['id_ujian_search']);
				$x['data_dosen']=$this->m_presensi_pengawas->show_dosen($kode_prodi); 
			}
			
			
			$x['combobox_ujian']=$this->m_presensi_pengawas->combobox_ujian(); 
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_presensi_pengawas', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		
	}	

	public function cetak_excel()
	{
		
		$kode_prodi = $_SESSION['kode_prodi'];
		
		if(!isset($_POST['print'])){
			redirect('prodi/presensi_pengawas');
		}
		
		if(isset($_SESSION['id_ujian_search'])){
			$x['data_tanggal_ujian']=$this->m_presensi_pengawas->show_tanggal_ujian($kode_prodi, $_SESSION['id_ujian_search']);
			$x['data']=$this->m_presensi_pengawas->show_jadwal($kode_prodi, $_SESSION['id_ujian_search']);
			$x['data_dosen']=$this->m_presensi_pengawas->show_dosen($kode_prodi);
			$this->load->view('prodi/v_presensi_pengawas_excel', $x);
		}

		unset($_SESSION['messege']);
	}	
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Rps extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Prodi')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
				
			}else{
				//dibolehkan
				
			}
		}

		$this->load->model('m_rps');
	}

	public function index()
	{
		// $npk = $_SESSION['npk'];
		$kode_jurusan = $_SESSION['kode_prodi'];

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        }

        $x['combobox_pertemuan']=$this->m_rps->combobox_pertemuan();

        if(isset($_SESSION['id_pertemuan_search'])){
        	$x['data']=$this->m_rps->show_berkas_pertemuan_monitor($_SESSION['id_pertemuan_search'], $kode_jurusan);
        }
        $this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_rps', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
			
	}

}

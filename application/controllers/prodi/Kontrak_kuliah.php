<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Kontrak_kuliah extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Dosen')!==0 ){
				//tidak dibolehkan
				
			}else{
				//dibolehkan
				redirect('prodi/welcome');
			}
		}

		$this->load->model('m_kontrak_kuliah');
	}

	public function index()
	{
		$kode_jurusan = $_SESSION['kode_prodi'];

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        }

        $x['combobox_pertemuan']=$this->m_kontrak_kuliah->combobox_pertemuan();

        if(isset($_SESSION['id_pertemuan_search'])){
        	$x['data']=$this->m_kontrak_kuliah->show_berkas_pertemuan_monitor($_SESSION['id_pertemuan_search'], $kode_jurusan);
        }
        $this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_kontrak_kuliah', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
			
	}

	

}

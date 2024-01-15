<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Info_dokumen extends CI_Controller {

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
				
			}
		}

		$this->load->model('m_info_dokumen');
	}

	public function index()
	{
        $x['data']=$this->m_info_dokumen->show_tahun_ajaran();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_info_dokumen', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

}

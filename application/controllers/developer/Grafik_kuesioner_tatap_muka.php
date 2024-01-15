<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Grafik_kuesioner_tatap_muka extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Developer')!==0 ){
				//tidak dibolehkan
				
			}else{
				//dibolehkan
				
			}
		}

		$this->load->model('m_grafik_kuesioner_tatap_muka');
	}

	public function index()
	{
        $x['data']=$this->m_grafik_kuesioner_tatap_muka->show_tahun_ajaran();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('developer/v_grafik_kuesioner_tatap_muka', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

}

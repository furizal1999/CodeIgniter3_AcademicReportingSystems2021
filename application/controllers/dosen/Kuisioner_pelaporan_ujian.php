<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Kuisioner_pelaporan_ujian extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if((strcmp($_SESSION["status_login"], 'Dosen')!==0)){
				//tidak dibolehkan
				redirect('welcome');
				
			}else{
				//dibolehkan
				
			}
		}

		$this->load->model('m_kuisioner_pelaporan_ujian');
	}

	public function index()
	{
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_kuisioner_pelaporan_ujian');
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function simpan_kuisioner(){
		if(isset($_POST['simpan_kuisioner'])){
			$status_login = $_SESSION['status_login'];
			$npk = $_SESSION['npk'];
			$statement1 = $_POST['statement1'];
			$statement2 = $_POST['statement2'];
			$statement3 = $_POST['statement3'];
			$statement4 = $_POST['statement4'];
			$statement5 = $_POST['statement5'];
			$statement6 = $_POST['statement6'];
			$statement7 = $_POST['statement7'];
			$statement8 = $_POST['statement8'];
			$statement9 = $_POST['statement9'];
			$statement10 = $_POST['statement10'];

			if($this->m_kuisioner_pelaporan_ujian->simpan_kuisioner($status_login, $npk, $statement1, $statement2, $statement3, $statement4, $statement5, $statement6, $statement7, $statement8, $statement9, $statement10)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Respon berhasil di simpan!
					</div>');
				redirect('dosen/kuisioner_pelaporan_ujian');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, respon gagal di simpan!
					</div>');
				redirect('dosen/kuisioner_pelaporan_ujian');
			}

		}else{
			redirect('dosen/kuisioner_pelaporan_ujian');
		}
	}

	

}

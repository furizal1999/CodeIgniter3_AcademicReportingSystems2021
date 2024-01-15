<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_welcome');
		$this->load->helper(array('url','download'));
		if((!isset($_SESSION['login_smpu']))){	
			redirect('halaman_tamu');
		}
	}

	public function index()
	{
		if($_SESSION['status_login']=="UPM"){
			// $x['jumlah_admin_fakultas']=$this->m_welcome->jumlah_admin_fakultas();
			// $x['jumlah_prodi']=$this->m_welcome->jumlah_prodi();
			$x['jumlah_admin_upm']=$this->m_welcome->jumlah_admin_upm();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}elseif($_SESSION['status_login']=="Developer"){
			// $x['jumlah_admin_fakultas']=$this->m_welcome->jumlah_admin_fakultas();
			// $x['jumlah_prodi']=$this->m_welcome->jumlah_prodi();
			// $x['jumlah_admin_upm']=$this->m_welcome->jumlah_admin_upm();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome');
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}elseif($_SESSION['status_login']=="Fakultas"){
			$x['jumlah_admin_fakultas']=$this->m_welcome->jumlah_admin_fakultas();
			$x['jumlah_prodi']=$this->m_welcome->jumlah_prodi();
			$x['jumlah_super_admin_prodi']=$this->m_welcome->jumlah_super_admin_prodi();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}elseif($_SESSION['status_login']=="Tata Usaha"){
			// $x['jumlah_admin_fakultas']=$this->m_welcome->jumlah_admin_fakultas();
			// $x['jumlah_prodi']=$this->m_welcome->jumlah_prodi();
			$x['jumlah_admin_tu']=$this->m_welcome->jumlah_admin_tu();
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}elseif($_SESSION['status_login']=="Prodi"){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$x['jumlah_admin']=$this->m_welcome->jumlah_admin($kode_jurusan);
			$x['jumlah_dosen_terverifikasi']=$this->m_welcome->jumlah_dosen_terverifikasi($kode_jurusan);
			$x['jumlah_dosen_belum_terverifikasi']=$this->m_welcome->jumlah_dosen_belum_terverifikasi($kode_jurusan);
			$x['jumlah_ruang']=$this->m_welcome->jumlah_ruang($kode_jurusan);
			$x['jumlah_matkul']=$this->m_welcome->jumlah_matkul($kode_jurusan);
			// $x['jumlah_ujian_terjadwal']=$this->m_welcome->jumlah_ujian_terjadwal($kode_jurusan);
			// $x['jumlah_ujian_belum_terjadwal']=$this->m_welcome->jumlah_ujian_belum_terjadwal($kode_jurusan);
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}elseif($_SESSION['status_login']=="Dosen" || $_SESSION['status_login']=="Pegawai"){
			$npk = $_SESSION['npk'];
			// $x['jumlah_jadwal_mengawas']=$this->m_welcome->jumlah_jadwal_mengawas($npk);
			// $x['jumlah_histori_mengawas']=$this->m_welcome->jumlah_histori_mengawas($npk);
			// $x['jumlah_terverifikasi']=$this->m_welcome->jumlah_terverifikasi($npk);
			// $x['jumlah_ditolak']=$this->m_welcome->jumlah_ditolak($npk);
			// $x['jumlah_belum_disubmit']=$this->m_welcome->jumlah_belum_disubmit($npk);
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('public/v_welcome');
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		}else{
			echo '<script type"text/javascript">';
			echo 'window.location.href="http://localhost/sipa/seminar/"';
			echo '</script>';
		}
		
	}
}
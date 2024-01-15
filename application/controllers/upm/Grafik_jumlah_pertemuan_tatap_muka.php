<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Grafik_jumlah_pertemuan_tatap_muka extends CI_Controller {

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

		$this->load->model('m_grafik_jumlah_pertemuan_tatap_muka');
		$this->load->library('pdfgenerator');
	}

	public function index()
	{
			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}
			$x['combobox_pertemuan']=$this->m_grafik_jumlah_pertemuan_tatap_muka->combobox_pertemuan();
			$x['combobox_prodi']=$this->m_grafik_jumlah_pertemuan_tatap_muka->combobox_prodi();
			
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('upm/v_grafik_jumlah_pertemuan_tatap_muka', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
	}

	function cetak($id_pertemuan=null)
    {
    	if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['kode_prodi'])){
    		$this->data['id_pertemuan'] = $id_pertemuan;
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
	     	$mpdf = new \Mpdf\Mpdf();


			$html = $this->load->view('upm/v_cetak_grafik_jumlah_pertemuan_tatap_muka',$this->data,true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();   
    	}else{
    		redirect('upm/laporan_tatap_muka');
    	}
    }
}

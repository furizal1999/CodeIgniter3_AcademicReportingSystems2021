<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Laporan_tatap_muka extends CI_Controller {

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

        $this->load->library('ciqrcode');
		// $this->load->library('PDF_MC_Table');

        $this->load->library('pdfgenerator');

		$this->load->model('m_laporan_tatap_muka_prodi');
	}

	public function index()
	{
		if(isset($_POST['tombol_cari_id_pertemuan'])){
			$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
		}

		if(isset($_POST['tombol_cari_bulan'])){
			$_SESSION['bulan_search'] = $_POST['bulan'];
		}

		$x['combobox_pertemuan']=$this->m_laporan_tatap_muka_prodi->combobox_pertemuan();

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('prodi/v_laporan_tatap_muka', $x);
		$this->load->view('public/part/footer');

		unset($_SESSION['messege']);
	}

	function cetak($id_pertemuan=null)
    {

     	$this->data['id_pertemuan'] = $id_pertemuan;
		// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
     	$mpdf = new \Mpdf\Mpdf();


		$html = $this->load->view('prodi/v_cetak_laporan_tatap_muka',$this->data,true);
		$mpdf->WriteHTML($html);
		$mpdf->Output();   
    }
}

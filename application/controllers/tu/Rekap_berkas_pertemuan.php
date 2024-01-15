<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Rekap_berkas_pertemuan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				//dibolehkan
				
			}
		}

        $this->load->library('ciqrcode');
		// $this->load->library('PDF_MC_Table');

        // $this->load->library('pdfgenerator');

		$this->load->model('m_laporan_tatap_muka');
	}

	public function index()
	{
		if(isset($_POST['tombol_cari_id_pertemuan'])){
			$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
		}

		if(isset($_POST['tombol_cari_bulan'])){
			$_SESSION['bulan_search'] = $_POST['bulan'];
		}

		if(isset($_POST['tombol_order_by'])){
			$_SESSION['orderby'] = $_POST['orderby'];
		}

		$x['combobox_pertemuan']=$this->m_laporan_tatap_muka->combobox_pertemuan();

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_rekap_berkas_pertemuan', $x);
		$this->load->view('public/part/footer');

		unset($_SESSION['messege']);
	}

	function cetak($id_pertemuan=null)
    {

     	if(isset($_SESSION['orderby'])){
    		$this->data['id_pertemuan'] = $id_pertemuan;
			// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
	     	$mpdf = new \Mpdf\Mpdf();
			ini_set("pcre.backtrack_limit", "5000000");


			$html = $this->load->view('tu/v_cetak_rekap_berkas_pertemuan',$this->data,true);
			$mpdf->WriteHTML($html);
			$mpdf->Output();    
    	}else{
    		redirect('tu/rekap_berkas_pertemuan');
    	}
    }
}

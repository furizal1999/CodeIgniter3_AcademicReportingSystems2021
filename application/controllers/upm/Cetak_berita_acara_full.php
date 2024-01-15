<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Cetak_berita_acara_full extends CI_Controller {

    function __construct(){
        parent::__construct();
        //CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'UPM')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				//dibolehkan
			}
		}
        
        $this->load->library('ciqrcode');
        $this->load->library('cetak_pdf');
        $this->load->model('m_berita_acara');

    }

    function index()
    {
        if(isset($_SESSION['id_ujian_search']) && isset($_SESSION['kode_prodi'])){
            
            $this->data['data'] = '';
            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf = new \Mpdf\Mpdf();


            $html = $this->load->view('upm/v_cetak_berita_acara_full',$this->data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();   
        }else{
            redirect('upm/berita_acara');
        }
    }
}
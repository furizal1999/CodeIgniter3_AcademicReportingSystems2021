<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Cetak_jadwal extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Prodi')!==0 ){
				//tidak dibolehkan
				if(strcmp($_SESSION["status_login"], 'Fakultas')==0){
					redirect('welcome');
				}else{
					redirect('welcome');
				}
			}else{
				//dibolehkan
			}
		}

		$this->load->model('m_cetak_jadwal');
		$this->load->library('cetak_pdf');

		
	}

	public function index()
	{
		
			$kode_prodi = $_SESSION['kode_prodi'];
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			if(isset($_SESSION['id_ujian_search'])){
				$x['data']=$this->m_cetak_jadwal->show_jadwal($kode_prodi, $_SESSION['id_ujian_search']);
			}
			$x['combobox_ujian']=$this->m_cetak_jadwal->combobox_ujian();
			
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_cetak_jadwal', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
		
	}	


	public function cetak_sekarang($data=null){
		if($data!=null){
            $this->data['data'] = $data;
            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf = new \Mpdf\Mpdf();


            $html = $this->load->view('prodi/v_cetak_jadwal_ujian',$this->data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();   
            
        }else{
            redirect('prodi/cetak_jadwal');
        }
	}
		
		
}

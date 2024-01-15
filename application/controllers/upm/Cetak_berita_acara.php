<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Cetak_berita_acara extends CI_Controller {

    function __construct(){
        parent::__construct();
        //CEK SESSION
        
        $this->load->library('ciqrcode');
        $this->load->library('cetak_pdf');
        
        $this->load->model('m_berita_acara');
        
    }

    function cetak($data=null)
    {
        if($data!=null){
            $this->data['data'] = $data;
            // $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf = new \Mpdf\Mpdf();


            $html = $this->load->view('upm/v_cetak_berita_acara',$this->data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output();   
            
        }else{
            redirect('upm/berita_acara');
        }

        
    }
}
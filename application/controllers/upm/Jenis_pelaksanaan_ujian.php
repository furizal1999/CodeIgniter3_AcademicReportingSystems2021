<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jenis_pelaksanaan_ujian extends CI_Controller {

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

		$this->load->model('m_jenis_pelaksanaan_ujian');
		$this->load->library('PDF_MC_Table');
		
	}

	public function index()
	{

		$x['combobox_ujian']=$this->m_jenis_pelaksanaan_ujian->combobox_ujian();

		if(isset($_POST['id_ujian']) ){
			$_SESSION['id_ujian_search'] = addslashes ($this->input->post('id_ujian'));
		}

		if(isset($_SESSION['id_ujian_search'])){
			$x['data']=$this->m_jenis_pelaksanaan_ujian->show_rekapitulasi($_SESSION['id_ujian_search']);
		}
		
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('upm/v_jenis_pelaksanaan_ujian', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
		
		
	}	

	function cetak($data=null){
		if($data!=null){
            $hasil = $this->m_jenis_pelaksanaan_ujian->show_rekapitulasi($data);
            if(empty($hasil)){
            	echo '<div class="text-warning"><h1>Maaf, Tidak ditemukan data yang falid!</h1></div>';
            }else{

            	$hasil2 = $this->m_jenis_pelaksanaan_ujian->ambil_ujian($data);
            	if($hasil2){
            		$jenis_ujian = $hasil2->ket_ujian;
            		$nama_ujian = $hasil2->nama_ujian;
            		$semester = $hasil2->semester;
            		$tahun_ajaran = $hasil2->tahun_ajaran;
            	}else{
            		$jenis_ujian = '.......................';
            		$nama_ujian = '.......................';
            		$semester = '.......................';
            		$tahun_ajaran = '.......................';
            	}

            	$hasil2 = $this->m_jenis_pelaksanaan_ujian->ambil_ujian($data);
            	if($hasil2){
            		$jenis_ujian = $hasil2->ket_ujian;
            		$nama_ujian = $hasil2->nama_ujian;
            		$semester = $hasil2->semester;
            		$tahun_ajaran = $hasil2->tahun_ajaran;
            	}else{
            		$jenis_ujian = '.......................';
            		$nama_ujian = '.......................';
            		$semester = '.......................';
            		$tahun_ajaran = '.......................';
            	}

            	$pdf = new PDF_MC_Table('L', 'mm','A4');
				// $pdf = new FPDF('L', 'mm','A4');
				$tinggiJudul = 12;
    			$tinggiCell = 6;
                $pdf->AddPage();

                

                $pdf->Image('templates/img/logo/header.jpg',63,15,170);
                
                $pdf->SetFont('Times','B',14);
                $pdf->ln(36);
                $pdf->Cell(0,7,'REKAPITULASI JENIS PELAKSANAAN '.strtoupper($nama_ujian),0,1,'C');
                $pdf->Cell(0,7,'FAKULTAS TEKNIK UNIVERSITAS ISLAM RIAU',0,1,'C');
                $pdf->Cell(0,7,'SEMESTER '.strtoupper($semester).' T.A. '.strtoupper($tahun_ajaran),0,1,'C');
                $pdf->setMargins(23,40,30);
                $pdf->Cell(0,0,'',0,1);
                $pdf->ln(5);




                $pdf->SetFont('Times','B',10);

                //set width for each column (6 columns)
				$pdf->SetWidths(Array(10,50,60,30,10,35,35,25));
				$pdf->SetLineHeight($tinggiCell);

				//set alignment
				$pdf->SetAligns(Array('C','','','','C','C','',''));

				//add table heading using standard cells
				//set font to bold
				$pdf->Cell(10,$tinggiJudul,'No',1,0,'C');
		        $pdf->Cell(50,$tinggiJudul,'Nama Pengawas',1,0,'C');
		        $pdf->Cell(60,$tinggiJudul,'Matakuliah',1,0,'C');
		        $pdf->Cell(30,$tinggiJudul,'Program Studi',1,0,'C');
		        $pdf->Cell(10,$tinggiJudul,'Kelas',1,0,'C');
		        $pdf->Cell(35,$tinggiJudul,'Jenis Ujian',1,0,'C');
		        $pdf->Cell(35,$tinggiJudul,'Media',1,0,'C');
		        $pdf->Cell(25,$tinggiJudul,'Bukti',1,1,'C');
				
				$pdf->SetFont('Times','',10);

				//loop the data
				$no =1;
				foreach($hasil->result_array() as $item){
					if($item['foto_bukti']!==""){
					  	$buktiFull = "Berita acara dan foto bukti";
					  }else{
					  	$buktiFull = "Berita acara";
					  }
				 //write data using Row() method containing array of values.
					 $pdf->Row(Array(
					  $no++,
					  $item['nama_dosen'],
					  $item['mk'],
					  $item['prodi'],
					  $item['kelas'],
					  $item['jenis_soal'],
					  $item['media'],
					  $buktiFull
					  
				 	));
				}

                $pdf->Output('I','JenisPelaksanaanUjian'.date('YmdHis'));
            }

        }else{
            redirect('upm/jenis_pelaksanaan_ujian');
        }
	}
}

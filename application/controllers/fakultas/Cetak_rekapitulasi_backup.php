<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Cetak_rekapitulasi extends CI_Controller {

    function __construct(){
        parent::__construct();
        if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Fakultas')!==0 ){
				//tidak dibolehkan
				if(strcmp($_SESSION["status_login"], 'Prodi')==0){
					redirect('welcome');
				}else{
					redirect('welcome');
				}
			}else{
				if(!isset($_SESSION["id_tahun_ajaran_search"])){
                    redirect('welcome');
                }
			}
        }
        
        $this->load->library('cetak_pdf');
        $this->load->model('m_rekapitulasi');

    }

    function index()
    {

        $baris = $this->m_rekapitulasi->ambil_tahun_dan_surat($_SESSION['id_tahun_ajaran_search']);
        if($baris){
            $semester = $baris->semester;
            $nama_ujian = $baris->nama_ujian;
            $jenis_ujian = $baris->jenis_ujian;
            $tahun_ajaran = $baris->tahun_ajaran;
            $nomor_surat = $baris->nomor_surat;
            $nama_surat = $baris->nama_surat;
            $nama_dekan = $baris->nama_dekan;
            $npk_dekan = $baris->npk;
            $tgl_surat = $baris->tanggal;
            $ket = $baris->ket_ujian;
        }

        if($nama_ujian=='Ujian Akhir Semester'){
            $nama_ujian = 'UAS';
        }else{
            $nama_ujian = 'UTS';
        }

        if($semester=='Ganjil'){
            $semester = 'GANJIL';
        }else{
            $semester = 'GENAP';
        }
        
        $pdf = new FPDF('L', 'mm','A4');

        $pdf->AddPage();
        
        $pdf->SetFont('Times','B',14);
        $pdf->ln(10);
        $pdf->Cell(0,10,'REKAPITULASI JUMLAH MAHASISWA/I PER-MATAKULIAH '.$nama_ujian.' '.$semester,0,1,'C');
        $pdf->Cell(0,3,'FAKULTAS TEKNIK UIR TAHUN AKADEMIK '.$tahun_ajaran,0,1,'C');
        $pdf->setMargins(20,40,30);
        $pdf->Cell(0,0,'',0,1);
        $pdf->ln(2);
        $pdf->Line(20, 39, 275, 39); // 20mm from each edge
        $pdf->Line(20, 40, 275, 40); // 20mm from each edge
        $pdf->ln(10);


        //PENGAWAS 1
        $pdf->SetFont('Times','B',12);
        $pdf->ln(2);
        $pdf->SetFont('Times','B',9);
        $pdf->Cell(10,6,'No',1,0,'C');
        $pdf->Cell(50,6,'Nama Pengawas',1,0,'C');
        $pdf->Cell(65,6,'Matakuliah',1,0,'C');
        $pdf->Cell(10,6,'Sem',1,0,'C');
        $pdf->Cell(45,6,'Prodi',1,0,'C');
        $pdf->Cell(10,6,'Kelas',1,0,'C');
        $pdf->Cell(15,6,'Tot Mhs',1,0,'C');
        $pdf->Cell(20,6,'Mhs Hadir',1,0,'C');
        $pdf->Cell(15,6,'Tot MK',1,0,'C');
        $pdf->Cell(15,6,'Tot Kelas',1,1,'C');

        // $pdf->SetFont('Times','',11);
        $x=$this->m_rekapitulasi->show_rekapitulasi($_SESSION['id_tahun_ajaran_search']);
        $no = 1;
        $tot_mhs1 = 0;
        $tot_mhs_hadir1 = 0;
        $tot_mk = 0;
        $tot_kelas = 0;
        $mulai = false;
        $rowspan = false;
        foreach($x->result_array() as $i):
           $kode_prodi=$i['kode_prodi'];
            $npk=$i['npk'];
            $nama_dosen=$i['nama_dosen'];
            $mk=$i['mk'];
            $prodi=$i['prodi'];
            $kelas=$i['kelas'];
            $tot_jumlah=$i['tot_jumlah'];
            $jum_hadir=$i['jum_hadir'];

            $row = $this->m_rekapitulasi->j_mk1($npk, $_SESSION['id_tahun_ajaran_search']);
            if(isset($row)){
                $count_mk = $row->count_mk;
            }
            else{
                $count_mk = 0;
            }

            $row = $this->m_rekapitulasi->j_kelas1($npk, $_SESSION['id_tahun_ajaran_search']);
            if(isset($row)){
                $count_kelas = $row->count_kelas;
            }
            else{
                $count_kelas = 0;
            }
            

            if($mulai==false){
                $user = $npk;
                $mulai = true;
            }
            else{
                if($user == $npk){
                    $rowspan = true;
                }else{
                    $rowspan = false;
                    $user = $npk;
                }
            }

            $pdf->SetFont('Times','',9);
            if($rowspan==false){
                $pdf->Cell(10,6,$no++,'L,T,R',0,'C');
            }else{
                $pdf->Cell(10,6,'','R,L',0,'C');
            }
            

            if($rowspan==false){
                $pdf->Cell(50,6,$nama_dosen,'L,T,R',0,'L');
            }else{
                $pdf->Cell(50,6,'',0,0,'L');
            }
            $pdf->Cell(65,6,$mk,1,0,'L');
            $pdf->Cell(10,6,substr($kelas, 0,1),1,0,'C');
            $pdf->Cell(45,6,$prodi,1,0,'L');
            $pdf->Cell(10,6,$kelas,1,0,'C');
            $pdf->Cell(15,6,$tot_jumlah,1,0,'C');
            $pdf->Cell(20,6,$jum_hadir,1,0,'C');
            $tot_mhs1 = $tot_mhs1 + $tot_jumlah;
            $tot_mhs_hadir1 = $tot_mhs_hadir1 + $jum_hadir;

            if($rowspan==false){
                // $pdf->Cell(50,6,$nama_dosen,'L,T,R',0,'L');
                $pdf->Cell(15,6,$count_mk,'L,T,R',0,'C');
                $pdf->Cell(15,6,$count_kelas,'L,T,R',1,'C');
                $tot_mk = $tot_mk + $count_mk;
                $tot_kelas = $tot_kelas + $count_kelas;
            }else{
                $pdf->Cell(15,6,'','R,L',0,'C');
                $pdf->Cell(15,6,'','R,L',1,'C');
            }
        endforeach;

        $pdf->SetFont('Times','B',9);
        $pdf->Cell(190,6,'Total',1,0,'C');
        $pdf->Cell(15,6,$tot_mhs1,1,0,'C');
        $pdf->Cell(20,6,$tot_mhs_hadir1,1,0,'C');
        $pdf->Cell(15,6,$tot_mk,1,0,'C');
        $pdf->Cell(15,6,$tot_kelas,1,1,'C');
        //END PENGAWAS 1    


        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Y/m/d');
        // echo substr($tanggal, 5,2); die();
        if(substr($tanggal, 5,2)=='01'){
            $tanggal = substr($tanggal, 8).' Januari '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='02'){
            $tanggal = substr($tanggal, 8).' Februari '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='03'){
            $tanggal = substr($tanggal, 8).' Maret '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='04'){
            $tanggal = substr($tanggal, 8).' April '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='05'){
            $tanggal = substr($tanggal, 8).' Mei '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='06'){
            $tanggal = substr($tanggal, 8).' Juni '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='07'){
            $tanggal = substr($tanggal, 8).' Juli '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='08'){
            $tanggal = substr($tanggal, 8).' Agustus '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='09'){
            $tanggal = substr($tanggal, 8).' September '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='10'){
            $tanggal = substr($tanggal, 8).' Oktober '.substr($tanggal,0,4);
        }
        else if(substr($tanggal, 5,2)=='11'){
            $tanggal = substr($tanggal, 8).' November '.substr($tanggal,0,4);
        }
        else{
            $tanggal = substr($tanggal, 8).' Desember '.substr($tanggal,0,4);
        }

        $pdf->ln(10);
        $pdf->SetFont('Times','',12);
        $pdf->Cell(200,6,'',0,0,'L');
        $pdf->Cell(50,6,'Pekanbaru, '.$tanggal,0,1,'L');
        $pdf->Cell(200,6,'',0,0,'L');
        $pdf->Cell(50,6,'Dekan',0,1,'L');

        $pdf->ln(20);
        $pdf->SetTextColor(1);
        $pdf->SetFont('Times','BU',12);
        $pdf->Cell(200,6,'',0,0,'L');
        $pdf->Cell(50,6,$nama_dekan,0,1,'C');
        $pdf->SetFont('Times','',12);
        $pdf->Cell(200,6,'',0,0,'L');
        $pdf->Cell(50,6,'NPK : '.$npk_dekan,0,1,'C');
        $pdf->ln(5);

        $pdf->Output('D','Rekapitulasi'.date('YmdHis').'.pdf');
    }
}
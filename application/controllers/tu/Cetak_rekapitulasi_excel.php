<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Cetak_rekapitulasi_excel extends CI_Controller {

    function __construct(){
        parent::__construct();
        if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				if(!isset($_SESSION["id_ujian_search"])){
                    redirect('welcome');
                }
			}
        }
        
        $this->load->model('m_rekapitulasi');

    }

    function index()
    {
        if(isset($_SESSION['id_ujian_search'])){
            $x['title']='RekapitulasiMengawas';
            $x['data']=$this->m_rekapitulasi->show_rekapitulasi($_SESSION['id_ujian_search']);
            $this->load->view('tu/v_cetak_rekapitulasi_excel', $x);
        }
    }
}


 // require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
        // require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

        // $Excel = new PHPExcel();

        // $Excel->getProperties()->setCreator("SMPU-Fakultas Teknik UIR");
        // $Excel->getProperties()->setLastModifiedBy("SMPU-Fakultas Teknik UIR");
        // $Excel->getProperties()->setTitle('Rekapitulasi'.date('YmdHis'));

        // $Excel->setActiveSheetIndex(0);

        // $Excel->getActiveSheet()->setCellValue('A1', 'NO');
        // $Excel->getActiveSheet()->setCellValue('B1', 'NAMA PENGAWAS');
        // $Excel->getActiveSheet()->setCellValue('C1', 'MATAKULIAH');
        // $Excel->getActiveSheet()->setCellValue('D1', 'SEM');
        // $Excel->getActiveSheet()->setCellValue('E1', 'PROGRAM STUDI');
        // $Excel->getActiveSheet()->setCellValue('F1', 'KELAS');
        // $Excel->getActiveSheet()->setCellValue('G1', 'JUMLAH MAHASISWA');
        // $Excel->getActiveSheet()->setCellValue('H1', 'MAHASISWA PER DOSEN');
        // $Excel->getActiveSheet()->setCellValue('I1', 'MATAKULIAH PER DOSEN');
        // $Excel->getActiveSheet()->setCellValue('J1', 'KELAS PER DOSEN');

        // $no = 1;
        // $baris = 2;
        // $tot_mhs1 = 0;
        // $tot_mhs_hadir1 = 0;
        // $tot_mhs_hadir2 = 0;
        // $tot_mk = 0;
        // $tot_kelas = 0;
        // $mulai = false;
        // $rowspan = false;
        // foreach($x->result_array() as $i):
        //     $kode_prodi=$i['kode_prodi'];
        //     $npk=$i['npk'];
        //     $nama_dosen=$i['nama_dosen'];
        //     $mk=$i['mk'];
        //     $prodi=$i['prodi'];
        //     $kelas=$i['kelas'];
        //     $tot_jumlah=$i['tot_jumlah'];
        //     $jum_hadir=$i['jum_hadir'];

        //     $row = $this->m_rekapitulasi->j_mhs1($npk, $_SESSION['id_tahun_ajaran_search']);
        //     if(isset($row)){
        //         $count_mhs = $row->count_mhs;
        //     }
        //     else{
        //         $count_mhs = 0;
        //     }

        //     $row = $this->m_rekapitulasi->j_mk1($npk, $_SESSION['id_tahun_ajaran_search']);
        //     if(isset($row)){
        //         $count_mk = $row->count_mk;
        //     }
        //     else{
        //         $count_mk = 0;
        //     }

        //     $row = $this->m_rekapitulasi->j_kelas1($npk, $_SESSION['id_tahun_ajaran_search']);
        //     if(isset($row)){
        //         $count_kelas = $row->count_kelas;
        //     }
        //     else{
        //         $count_kelas = 0;
        //     }
            

            // $Excel->getActiveSheet()->setCellValue('A'.$baris, $no++);
            // $Excel->getActiveSheet()->setCellValue('B'.$baris, $nama_dosen);
            // $Excel->getActiveSheet()->setCellValue('C'.$baris, $mk);
            // $Excel->getActiveSheet()->setCellValue('D'.$baris, substr($kelas, 0,1));
            // $Excel->getActiveSheet()->setCellValue('E'.$baris, $prodi);
            // $Excel->getActiveSheet()->setCellValue('F'.$baris, $kelas);
            // $Excel->getActiveSheet()->setCellValue('G'.$baris, $jum_hadir);
            // $Excel->getActiveSheet()->setCellValue('H'.$baris, $count_mhs);
            // $Excel->getActiveSheet()->setCellValue('I'.$baris, $count_mk);
            // $Excel->getActiveSheet()->setCellValue('J'.$baris, $count_kelas);
        //     $baris++;
        // endforeach;

        // $fileName = 'Rekapitulasi'.date('YmdHis').'.xlsx';
        // $Excel->getActiveSheet()->setTitle('Rekapitulasi'.date('YmdHis'));

        // header('Content-Type: appication/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment;filename="'.$fileName. '"');
        // header('Cache-Control: max-age=0');

        // $writer=PHPExcel_IOFactory::createwriter($Excel, 'Excel2007');
        // $writer->save('php://output');

        // exit;
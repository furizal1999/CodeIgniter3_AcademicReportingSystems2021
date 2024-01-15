<?php
$baris = $this->m_rekapitulasi->ambil_tahun_dan_surat($data);
if($baris){
    $semester = $baris->semester;
    $nama_ujian = $baris->nama_ujian;
    $jenis_ujian = $baris->ket_ujian;
    $tahun_ajaran = $baris->tahun_ajaran;
    $nomor_surat = $baris->nomor_surat;
    $nama_surat = $baris->nama_surat;
    $nama_dekan = $baris->nama_dekan;
    $npk_dekan = $baris->npk;
    $tgl_surat = $baris->tanggal;
    $ket = $baris->ket_ujian;
}else{
    echo 'Maaf data tidak ditemukan!';
    die();
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
$TinggiSemua = 12;
$pdf->SetFont('Times','B',10);
$pdf->ln(2);
$pdf->SetFont('Times','B',9);
$pdf->Cell(10,$TinggiSemua,'No',1,0,'C');
$pdf->Cell(30,$TinggiSemua,'Nama Pengawas',1,0,'C');
$pdf->Cell(30,$TinggiSemua,'Matakuliah',1,0,'C');
$pdf->Cell(10,$TinggiSemua,'Sem',1,0,'C');
$pdf->Cell(35,$TinggiSemua,'Prodi',1,0,'C');
$pdf->Cell(10,$TinggiSemua,'Kelas',1,0,'C');
$pdf->Cell(70,$TinggiSemua,'Dosen Pengampu',1,0,'C');
$pdf->Cell(15,$TinggiSemua,'Jml Mhs',1,0,'C');
$pdf->Cell(15,$TinggiSemua,'Mhs/Mk',1,0,'C');
$pdf->Cell(15,$TinggiSemua,'Mhs/Dsn',1,0,'C');
$pdf->Cell(15,$TinggiSemua,'Mk/Dsn',1,0,'C');
$pdf->Cell(15,$TinggiSemua,'Kls/Dsn',1,1,'C');

// $pdf->SetFont('Times','',11);
$x=$this->m_rekapitulasi->show_rekapitulasi($data);
$no = 1;
$tot_mhs1 = 0;
$tot_mhs_hadir1 = 0;
$tot_mhs_hadir2 = 0;
$tot_mhsMk = 0;
$tot_mk = 0;
$tot_kelas = 0;

$mulai = false;
$rowspan = false;

$mulai2 = false;
$rowspan2 = false;
foreach($x->result_array() as $i):

    $kode_prodi=$i['kode_prodi'];
    $npk=$i['npk'];
    $nama_dosen=$i['nama_dosen'];
    $dosen_pengampu=$i['dosen_pengampu'];
    $kode_mk=$i['kode_mk'];
    $mk=$i['mk'];
    $prodi=$i['prodi'];
    $kelas=$i['kelas'];
    $tot_jumlah=$i['tot_jumlah'];
    $jum_hadir=$i['jum_hadir'];


    $row = $this->m_rekapitulasi->mhs_per_mk($npk, $_SESSION['id_ujian_search'], $kode_mk);
    if(isset($row)){
        $count_mhs_per_mk = $row->count_mhs_per_mk;
    }
    else{
        $count_mhs_per_mk = 0;
    }

    $row = $this->m_rekapitulasi->j_mhs1($npk, $data);
    if(isset($row)){
        $count_mhs = $row->count_mhs;
    }
    else{
        $count_mhs = 0;
    }

    $row = $this->m_rekapitulasi->j_mk1($npk, $data);
    if(isset($row)){
        $count_mk = $row->count_mk;
    }
    else{
        $count_mk = 0;
    }

    $row = $this->m_rekapitulasi->j_kelas1($npk, $data);
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


    if($mulai2==false){
        $user2 = $npk;
        $mk2 = $kode_mk;
        $mulai2 = true;
    }
    else{
        if($user2 == $npk && $mk2 ==$kode_mk){
            $rowspan2 = true;
        }else{
            $rowspan2 = false;
            $user2 = $npk;
            $mk2 = $kode_mk;
        }
    }



    $cellWidthLecture=30; //lebar sel
    $cellHeightLecture=6; //tinggi sel satu baris normal
    
    //periksa apakah teksnya melibihi kolom?
    if($pdf->GetStringWidth($nama_dosen) < $cellWidthLecture){
        //jika tidak, maka tidak melakukan apa-apa
        $lineLecture=1;
    }else{
        //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
        //dengan memisahkan teks agar sesuai dengan lebar sel
        //lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
        
        $textLengthLecture=strlen($nama_dosen);    //total panjang teks
        $errMarginLecture=5;       //margin kesalahan lebar sel, untuk jaga-jaga
        $startCharLecture=0;       //posisi awal karakter untuk setiap baris
        $maxCharLecture=0;         //karakter maksimum dalam satu baris, yang akan ditambahkan nanti
        $textArrayLecture=array(); //untuk menampung data untuk setiap baris
        $tmpStringLecture="";      //untuk menampung teks untuk setiap baris (sementara)
        
        while($startCharLecture < $textLengthLecture){ //perulangan sampai akhir teks
            //perulangan sampai karakter maksimum tercapai
            while( 
            $pdf->GetStringWidth( $tmpStringLecture ) < ($cellWidthLecture) &&
            ($startCharLecture+$maxCharLecture) < $textLengthLecture ) {
                $maxCharLecture++;
                $tmpStringLecture=substr($nama_dosen,$startCharLecture,$maxCharLecture);
            }
            //pindahkan ke baris berikutnya
            $startCharLecture=$startCharLecture+$maxCharLecture;
            //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
            array_push($textArrayLecture,$tmpStringLecture);
            //reset variabel penampung
            $maxCharLecture=0;
            $tmpStringLecture='';
            
        }
        //dapatkan jumlah baris
        $lineLecture=count($textArrayLecture);
    }



    // MATKUL
    
     $cellWidthMatkul=30; //lebar sel
    $cellHeightMatkul=6; //tinggi sel satu baris normal
    $ChooseMatkul = false;
    
    //periksa apakah teksnya melibihi kolom?
    if($pdf->GetStringWidth($mk) < $cellWidthMatkul){
        //jika tidak, maka tidak melakukan apa-apa
        $lineMatkul=1;


    }else{
        $ChooseMatkul = true;
        //jika ya, maka hitung ketinggian yang dibutuhkan untuk sel akan dirapikan
        //dengan memisahkan teks agar sesuai dengan lebar sel
        //lalu hitung berapa banyak baris yang dibutuhkan agar teks pas dengan sel
        
        $textLengthMatkul=strlen($mk);    //total panjang teks
        $errMarginMatkul=5;       //margin kesalahan lebar sel, untuk jaga-jaga
        $startCharMatkul=0;       //posisi awal karakter untuk setiap baris
        $maxCharMatkul=0;         //karakter maksimum dalam satu baris, yang akan ditambahkan nanti
        $textArrayMatkul=array(); //untuk menampung data untuk setiap baris
        $tmpStringMatkul="";      //untuk menampung teks untuk setiap baris (sementara)
        
        while($startCharMatkul < $textLengthMatkul){ //perulangan sampai akhir teks
            //perulangan sampai karakter maksimum tercapai
            while( 
            $pdf->GetStringWidth( $tmpStringMatkul ) < ($cellWidthMatkul-$errMarginMatkul) &&
            ($startCharMatkul+$maxCharMatkul) < $textLengthMatkul ) {
                $maxCharMatkul++;
                $tmpStringMatkul=substr($mk,$startCharMatkul,$maxCharMatkul);
            }
            //pindahkan ke baris berikutnya
            $startCharMatkul=$startCharMatkul+$maxCharMatkul;
            //kemudian tambahkan ke dalam array sehingga kita tahu berapa banyak baris yang dibutuhkan
            array_push($textArrayMatkul,$tmpStringMatkul);
            //reset variabel penampung
            $maxCharMatkul=0;
            $tmpStringMatkul='';
            
        }
        //dapatkan jumlah baris
        $lineMatkul=count($textArrayMatkul);
    }
    
    //tulis selnya
    $pdf->SetFillColor(255,255,255);


    if($cellHeightLecture>=$cellHeightMatkul){
        $cellHeight = $cellHeightLecture;
    }else{
        $cellHeight = $cellHeightMatkul;
    }

    if($lineLecture>=$lineMatkul){
        $line = $lineLecture;
    }else{
        $line = $lineMatkul;
    }




    $pdf->SetFont('Times','',6);
    if($rowspan==false){
        $pdf->Cell(10,$TinggiSemua,$no++,'L,T,R',0,'C');
    }else{
        $pdf->Cell(10,$TinggiSemua,'','R,L',0,'C');
    }
    

    if($rowspan==false){
        //memanfaatkan MultiCell sebagai ganti Cell
        //atur posisi xy untuk sel berikutnya menjadi di sebelahnya.
        //ingat posisi x dan y sebelum menulis MultiCell
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell($cellWidthLecture,$cellHeight,$nama_dosen,'R,T,L');
        
        //kembalikan posisi untuk sel berikutnya di samping MultiCell 
        //dan offset x dengan lebar MultiCell
        $pdf->SetXY($xPos + $cellWidthLecture , $yPos);
        // $pdf->Cell(50,$TinggiSemua,$nama_dosen,'L,T,R',0,'L');
    }else{
        $pdf->Cell($cellWidthLecture,$TinggiSemua,'',0,0,'L');

    }


    if($ChooseMatkul == true){
        $xPos=$pdf->GetX();
        $yPos=$pdf->GetY();
        $pdf->MultiCell($cellWidthMatkul,$cellHeight,$mk,1);
        
        //kembalikan posisi untuk sel berikutnya di samping MultiCell 
        //dan offset x dengan lebar MultiCell
        $pdf->SetXY($xPos + $cellWidthMatkul , $yPos);
    }else{
        $pdf->Cell($cellWidthMatkul,$TinggiSemua,$mk,1,0,'L');
    }



    $pdf->Cell(10,$TinggiSemua,substr($kelas, 0,1),1,0,'C');
    $pdf->Cell(35,$TinggiSemua,$prodi,1,0,'L');
    $pdf->Cell(10,$TinggiSemua,$kelas,1,0,'C');
    $pdf->Cell(70,$TinggiSemua,$dosen_pengampu,1,0,'C');
    $pdf->Cell(15,$TinggiSemua,$jum_hadir,1,0,'C');
    
    $tot_mhs1 = $tot_mhs1 + $tot_jumlah;
    $tot_mhs_hadir1 = $tot_mhs_hadir1 + $jum_hadir;



    if($rowspan2==false){
        $pdf->Cell(15,$TinggiSemua,$count_mhs_per_mk,'L,T,R',0,'C');
        
        $tot_mhsMk = $tot_mhsMk + $count_mhs_per_mk;
    }else{
        $pdf->Cell(15,$TinggiSemua,'','R,L',0,'C');
    }

    if($rowspan==false){
        $pdf->Cell(15,$TinggiSemua,$count_mhs,'L,T,R',0,'C');
        $tot_mhs_hadir2 = $tot_mhs_hadir2 + $count_mhs;	 

        $pdf->Cell(15,$TinggiSemua,$count_mk,'L,T,R',0,'C');
        $pdf->Cell(15,$TinggiSemua,$count_kelas,'L,T,R',1,'C');
        $tot_mk = $tot_mk + $count_mk;
        $tot_kelas = $tot_kelas + $count_kelas;
    }else{
        $pdf->Cell(15,$TinggiSemua,'','R,L',0,'C');
        $pdf->Cell(15,$TinggiSemua,'','R,L',0,'C');
        $pdf->Cell(15,$TinggiSemua,'','R,L',1,'C');
    }


endforeach;

$pdf->SetFont('Times','B',9);
$pdf->Cell(190,$TinggiSemua,'Total',1,0,'C');
$pdf->Cell(15,$TinggiSemua,$tot_mhs_hadir1,1,0,'C');
$pdf->Cell(15,$TinggiSemua,$tot_mhsMk,1,0,'C');
$pdf->Cell(15,$TinggiSemua,$tot_mhs_hadir2,1,0,'C');
$pdf->Cell(15,$TinggiSemua,$tot_mk,1,0,'C');
$pdf->Cell(15,$TinggiSemua,$tot_kelas,1,1,'C');
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

$pdf->Output('I','Rekapitulasi'.date('YmdHis').'.pdf');
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $id_jadwal_kelas_pertemuan;?></title>
        <style>
            #table2 {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #ddd;
                font-size: 10;
            }

            #table2 td, #table2 th {
                border: 1px solid #ddd;
                padding: 8px;
                font-size: 10;
            }

            /*#table2 tr:nth-child(even){background-color: #f2f2f2;}*/

            #table2 tr:hover {background-color: #ddd;}

            #table2 th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                background-color: #4CAF50;
                color: white;
            }

            #table2 td {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: left;
                /*background-color: #4CAF50;*/
                /*color: white;*/
            }
            




            #table {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }



            #table td, #table th {
                border: 1px solid #ddd;
                padding: 8px;
                font-size: 10;
            }

            #table tr:nth-child(even){background-color: #f2f2f2;}

            #table tr:hover {background-color: #ddd;}

            #table th {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                background-color: #4CAF50;
                color: white;
            }

            #table td {
                padding-top: 10px;
                padding-bottom: 10px;
                text-align: center;
                /*background-color: #4CAF50;*/
                /*color: white;*/
            }
            .img-center {
              display: block;
              margin-left: auto;
              margin-right: auto;
              /*margin-bottom: 20px;*/
              width: 100%;
            }
            #textkecil {
                font-size: 7px;
                color: blue;
            }
        </style>
    </head>
    <body>
        
        
    <?php

        if($id_jadwal_kelas_pertemuan!=null){
                

                $query = $this->m_preview_laporan_pertemuan->selectCetakLaporanPertemuan($id_jadwal_kelas_pertemuan);
                if($query->num_rows()==1){
                    
                     date_default_timezone_set('Asia/Jakarta');
                    $namaFile = 'LaporanPertemuan'.date('YmdHis').'.pdf'; 

                    $baris = $query->row();
                    if($baris){
                        $nama_prodi = $baris->nama_prodi;
                        $kode_mk = $baris->kode_mk;
                        
                        $dosen_pengampu = $baris->dosen_pengampu;
                        $array_dosen = explode(', ', $dosen_pengampu);
                        $index = 0;
                        $array_dosen_hasil = array();

                        foreach ($array_dosen as $npk) {
                            $nama_dosen = $this->m_preview_laporan_pertemuan->getNamaDosen($npk);
                            $array_dosen_hasil[$index++] = $nama_dosen;
                        }

                        $nama_kelas = $baris->nama_kelas;
                        $semester = $baris->semester;
                        $nama_mk = $baris->nama_mk;


                    }
                                
    ?>
                    <div style="text-align:center;  padding: 5;">
                        <img class="img-center" src="<?php echo base_url('templates/img/logo/header2.jpg') ?>">
                        <br> 
                        <h4>FORMULIR MONITORING MATERI DAN KEHADIRAN DOSEN DALAM PERKULIAHAN</h4>
                    </div>
                     <table id="table2">
                        <thead>
                            <tr>
                                <td width="100"><b>Program Studi</b></td>
                                <td width="5">:</td>
                                <td width="230"><?= $nama_prodi ?></td>
                                
                                <td width="50">Kelas</td>
                                <td width="5">:</td>
                                <td><?= substr($nama_kelas, 1) ?></td>
                            </tr>
                            
                        </thead>
                        <tbody>
                             <tr>
                               <td width="100">Matakuliah</td>
                                <td width="5">:</td>
                                <td width="230"><?= $nama_mk ?></td>
                                
                                <td width="50">Kode MK</td>
                                <td width="5">:</td>
                                <td><?= substr($kode_mk, 1) ?></td>
                            </tr>
                             <tr>
                               <td width="100">Dosen</td>
                                <td width="5">:</td>
                                <td width="230"><?= $string_dosen_hasil = implode('/ ', $array_dosen_hasil) ?></td>
                                
                                <td width="50">Semester</td>
                                <td width="5">:</td>
                                <td><?= $semester ?></td>
                            </tr>
                             <tr>
                               <td colspan="6" style="text-align: center;"><b>MONITORING KEHADIRAN KULIAH</b></td>
                               
                            </tr>
                        </tbody>
                    </table>
                    <table id="table2"style="border-style: solid; border-color: #ddd;" >
                        <thead>
                           
                            
                    </table>

                    <table id="table">
                        <thead>

                            <tr>
                                <th>Minggu</th>
                                <th>Hari/Tanggal</th>
                                <th>Materi Kuliah</th>
                                <th>Ttd Dosen</th>
                                <th>Ttd Ketua Kelas</th>
                                <th width="2">Mhs Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                                    
                    <?php 
                        $jumlah_pertemuan = 16;
                        for ($i=0; $i < $jumlah_pertemuan; $i++) { 
                            $cek = $this->m_preview_laporan_pertemuan->ambilPresensiPertemuan($id_jadwal_kelas_pertemuan, ($i+1));
                            if(($i+1)==8){
                    ?>
                                <tr>
                                    <td><?= ($i+1) ?></td>
                                    <td style="padding-top: 40px; padding-bottom: 40px;" colspan="5">Ujian Tengah Semester</td>
                                </tr>
                    <?php
                                echo '';
                            }elseif(($i+1)==16){
                    ?>
                                <tr>
                                    <td><?= ($i+1) ?></td>
                                    <td style="padding-top: 40px; padding-bottom: 40px;" colspan="5">Ujian Akhir Semester</td>
                                </tr>
                    <?php
                               
                            }
                            elseif($cek){
                                $id_presensi_pertemuan = $cek->id_presensi_pertemuan;
                                $waktu_pertemuan = $cek->waktu_pertemuan;
                                $hari = $this->m_preview_laporan_pertemuan->hari(date('Y-m-d', strtotime($waktu_pertemuan)));

                                
                                $tanggal_pertemuan = $this->m_preview_laporan_pertemuan->format_tanggal(date('Y-m-d', strtotime($waktu_pertemuan)));


                    ?>
                            <tr> 
                                <td><?= ($i+1) ?></td>
                                <td><?= $hari.', '.$tanggal_pertemuan ?></td>
                                <td width="200"><?= $cek->materi_pertemuan; ?></td>

                                <td width="60">
                                    <?php
                                        $getIdRandom = $this->m_preview_laporan_pertemuan->getIdRandom($id_presensi_pertemuan);
                                        if($getIdRandom!=null){

                                        QRcode::png(base_url("validasi_ttd_digital/cek/".$getIdRandom),"templates/img/qrcode/presensipertemuan".$getIdRandom.".png");
                                    ?>
                                    <img width="80" src="<?php echo base_url('templates/img/qrcode/presensipertemuan').$getIdRandom.'.png' ?>">
                                    <i class="text-success text-center" id="textkecil"><small><?= $this->m_preview_laporan_pertemuan->getPenandaTangan($getIdRandom) ?></small></i>
                                     <?php                                            
                                        }
                                    ?>
                                </td>
                                <td width="60">
                                    <!-- <img width="80" src="<?php echo base_url('templates/img/qrcode/qrcode').$id_jadwal_kelas_pertemuan.'.png' ?>"> -->
                                </td>
                                 <td><?= $cek->mhs_hadir; ?></td>
                            </tr>
                    <?php   }else{
                    ?>
                            <tr> 
                                <td style="padding-top: 40px; padding-bottom: 40px;"><?= ($i+1) ?></td>
                                <td></td>
                                <td></td>

                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    <?php
                            } 
                        }
                    ?>
                        </tbody>
                    </table>
                    <br>
                    <table id="table2">
                        <tr>
                            <td>
                                Mengetahui 
                                <br>
                                Wakil Dekan I
                                <br>
                                <br>
                                <br>

                                <?php
                                        $getIdRandom = $this->m_preview_laporan_pertemuan->getIdRandomTddWd1($id_jadwal_kelas_pertemuan);
                                        if($getIdRandom!=null){

                                        QRcode::png(base_url("validasi_ttd_digital/cek/".$getIdRandom),"templates/img/qrcode/presensipertemuan".$getIdRandom.".png");
                                ?>
                                    <img width="80" src="<?php echo base_url('templates/img/qrcode/presensipertemuan').$getIdRandom.'.png' ?>">
                                   <br>
                                
                                <?php                                            
                                        }else{
                                ?>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                <?php
                                        }
                                        $topik_relasi_ttd_wd1 = "Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Wakil Dekan I)";
                                        if($this->m_preview_laporan_pertemuan->getNamaTtd($id_jadwal_kelas_pertemuan, $topik_relasi_ttd_wd1)!=""){
                                            echo $this->m_preview_laporan_pertemuan->getNamaTtd($id_jadwal_kelas_pertemuan, $topik_relasi_ttd_wd1);
                                        }else{
                                           $nama_wd1 = $this->m_preview_laporan_pertemuan->ambilNamaWd1();
                                            if($nama_wd1!=null){
                                                echo $nama_wd1;
                                            }else{
                                                echo '.........................';
                                            }
                                        }
                                        
                                    ?>
                                </td>
                                <td>
                                    Tanggal
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <?php  
                                        date_default_timezone_set('Asia/Jakarta');
                                        $sekarang = date("Y-m-d H:i:s");
                                        $hari_sekarang = $this->m_preview_laporan_pertemuan->hari(date('Y-m-d', strtotime($sekarang)));
                                        $tanggal_sekarang = $this->m_preview_laporan_pertemuan->format_tanggal(date('Y-m-d', strtotime($sekarang)));
                                        echo $hari_sekarang.', '.$tanggal_sekarang;
                                    ?>

                                </td>
                                <td>
                                    Diperiksa Oleh 
                                    <br>
                                    Ketua Program Studi
                                    <br>
                                    <br>
                                    <br>

                                    <?php
                                            $getIdRandom = $this->m_preview_laporan_pertemuan->getIdRandomTddProdi($id_jadwal_kelas_pertemuan);
                                            if($getIdRandom!=null){

                                            QRcode::png(base_url("validasi_ttd_digital/cek/".$getIdRandom),"templates/img/qrcode/presensipertemuan".$getIdRandom.".png");
                                    ?>
                                        <img width="80" src="<?php echo base_url('templates/img/qrcode/presensipertemuan').$getIdRandom.'.png' ?>">
                                       <br>
                                    
                                    <?php                                            
                                            }else{
                                    ?>
                                        <br>
                                        <br>
                                        <br>
                                        <br>
                                    <?php
                                            }
                                        
                        
                                        if(isset($_SESSION['kode_prodi'])){
                                            $kode_jurusan = $_SESSION['kode_prodi'];
                                            $topik_relasi_ttd_prodi = "Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Ketua Program Studi)";
                                            if($this->m_preview_laporan_pertemuan->getNamaTtd($id_jadwal_kelas_pertemuan, $topik_relasi_ttd_prodi)!=""){
                                                echo $this->m_preview_laporan_pertemuan->getNamaTtd($id_jadwal_kelas_pertemuan, $topik_relasi_ttd_prodi);
                                            }else{
                                               $nama_kaprodi = $this->m_preview_laporan_pertemuan->ambilNamaKaProdi($kode_jurusan);
                                                if($nama_kaprodi!=null){
                                                    echo $nama_kaprodi;
                                                }else{
                                                    echo '.........................';
                                                }
                                            }
                                            
                                        }else{
                                            echo '.........................';
                                        }
                                    
                                ?>
                            </td>
                        </tr>
                    </table>
                                
                <?php
                               
                        }
                        else{
                            echo '<div class="text-warning"><h1>Maaf, Tidak ditemukan data yang falid!</h1></div>';
                        }
                        
                    }else{
                        echo '<div class="text-warning"><h1>Maaf, Tidak ditemukan data yang falid!</h1></div>';
                    }
                    
                ?>
            
    </body>
</html>
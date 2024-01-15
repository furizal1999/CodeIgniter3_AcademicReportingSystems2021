


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= 'LAPORAN TATAP MUKA';?></title>
        <style>
            #table2 {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
                border: 1px solid #ddd;
                font-size: 11;
            }

            #table2 td, #table2 th {
                border: 1px solid #ddd;
                padding: 8px;
                font-size: 11;
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
                font-size: 9;
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

            table {page-break-before: always; 
               font-size: 100px;}
            tr{page-break-inside: avoid; 
           page-break-after: auto;}
        </style>
    </head>
    <body>
        <div style="page-break-after:auto;">
        
    <?php


        
        if($data!=null){

            

           

            

           
           $baris = $this->m_cetak_jadwal->ambil_ujian($data);
            if($baris){
                $semester = $baris->semester;
                $tahun_ajaran = $baris->tahun_ajaran;
                $nama_ujian = $baris->nama_ujian;
                 
    ?>
                    <div>
                        <div style="text-align:center; padding-bottom: 5px"><b>JADWAL <?php echo strtoupper($nama_ujian.' '.$semester.' TA. '.$tahun_ajaran) ?></b></div>
                        <div style="text-align:center; padding-bottom: 5px"><b>PROGRAM STUDI <?php echo strtoupper($_SESSION['nama_prodi']).' FAKULTAS TEKNIK'; ?></b></div>
                        <div style="text-align:center; padding-bottom: 5px"><b><?php echo 'UNIVERSITAS ISLAM RIAU';?></b></div>
                        <hr>
                    </div>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL UJIAN</th>
                                <th>JAM</th>
                                <th>MATAKULIAH</th>
                                <th>DOSEN PENGAMPU</th>
                                <th>SEMESTER/KELAS</th>
                                <th>RUANG</th>
                            </tr>
                        </thead>
                        <tbody style="page-break-inside: avoid;">
                          
                            <?php 


                                $x=$this->m_cetak_jadwal->show_jadwal($_SESSION['kode_prodi'], $data);
                                $no = 1;
                                $tot_baris = 0;
                                $tot_kelas = 0;
                                $mulai = false;
                                $rowspan = false;
                                $rowspan_jam = false;
                                $rowspan_kode_mk = false;
                                $rowspan_dosen = false;
                                foreach($x->result_array() as $i):
                                    $tanggal_ujian=$i['tanggal_ujian'];
                                    $jam_mulai=$i['jam_mulai'];
                                    $jam_selesai=$i['jam_selesai'];
                                    $kode_matkul=$i['kode_matkul'];
                                    $dosen_pengampu=$i['dosen_pengampu'];

                                    //get nama dosen
                                    $dosen_pengampu=$i['dosen_pengampu'];
                                    $array_dosen = explode(', ', $dosen_pengampu);
                                    
                                    $array_dosen_hasil = array();
                                    $array_npk_hasil = array();
                                    $index = 0;
                                    foreach ($array_dosen as $npk) {
                                        $nama_dosen = $this->m_cetak_jadwal->getNamaDosen($npk);
                                        $array_npk_hasil[$index] = $npk;
                                        $array_dosen_hasil[$index] = $nama_dosen;
                                        $index++;
                                    }
                                    $string_dosen_hasil = implode('/ ', $array_dosen_hasil);
                                    $nama_kelas=$i['nama_kelas'];
                                    $kode_ruang=$i['kode_ruang'];
                                    $jenis_ujian=$i['ket_ujian'];
                                    $nama_mk = $i['nama_mk'];
                                    
                                    if($jenis_ujian=="Daring"){
                                        $kode_ruang = "ONLINE";
                                    }
                                    

                                    

                                    //MENGHITUNG BARIS
                                    $tot_baris++;

                                     //ROWSPAN PERTANGGAL
                                    if($mulai==false){
                                        $tanggal_cek = $tanggal_ujian;
                                        $jam_cek = substr($jam_mulai,0,5)." - ".substr($jam_selesai,0,5);
                                        $kode_mk_cek = $kode_matkul;
                                        $dosen_pengampu_cek = $dosen_pengampu;
                                        $mulai = true;
                                    }
                                    else{
                                        if($tanggal_cek == $tanggal_ujian){
                                            $rowspan = true;
                                        }else{
                                            $rowspan = false;
                                            $tanggal_cek = $tanggal_ujian;
                                        }

                                        if($jam_cek == substr($jam_mulai,0,5)." - ".substr($jam_selesai,0,5)){
                                            $rowspan_jam = true;
                                        }else{
                                            $rowspan_jam = false;
                                            $jam_cek = substr($jam_mulai,0,5)." - ".substr($jam_selesai,0,5);
                                        }

                                        if($kode_mk_cek == $kode_matkul){
                                            $rowspan_kode_mk = true;
                                        }else{
                                            $rowspan_kode_mk = false;
                                            $kode_mk_cek = $kode_matkul;
                                        }
                                    }

                                   
                            ?>
                            <tr>
                                
                                <?php 
                                    if($rowspan==false){ 
                                        $cekJumlahPerTanggal = $this->m_cetak_jadwal->cekJumlahPerTanggal($_SESSION['kode_prodi'], $tanggal_ujian, $data);


                                ?>
                                <td rowspan="<?php echo $cekJumlahPerTanggal ?>"><?php echo $no; ?></td>
                                <td rowspan="<?php echo $cekJumlahPerTanggal ?>"><?php echo $this->m_cetak_jadwal->getFormatTanggalIndo($tanggal_ujian); ?></td>
                                <?php 
                                    $no++;
                                    }
                                
                                    if($rowspan_jam==false){ 
                                        $cekJumlahPerJamTanggal = $this->m_cetak_jadwal->cekJumlahPerJamTanggal($_SESSION['kode_prodi'], $tanggal_ujian, $jam_mulai, $jam_selesai, $data);
                                ?>

                                    <td rowspan="<?php echo $cekJumlahPerJamTanggal ?>"><?php echo $jam_mulai.'-'.$jam_selesai; ?></td>
                                <?php }

                                if($rowspan_kode_mk==false){ 
                                        $cekJumlahPerJamTanggalMK = $this->m_cetak_jadwal->cekJumlahPerJamTanggalMK($_SESSION['kode_prodi'], $tanggal_ujian, $jam_mulai, $jam_selesai, $kode_matkul, $data);
                                ?>

                                    <td rowspan="<?php echo $cekJumlahPerJamTanggalMK ?>"><?php echo $nama_mk; ?></td>
                                <?php }
                                
                                ?>
                                <td><?php echo $string_dosen_hasil; ?></td>
                                <td><?php echo $nama_kelas; ?></td>
                                <td><?php echo $kode_ruang; ?></td>
                            </tr>
                            <?php
                                    
                                endforeach;


                             ?>
                             <tr>
                               
                                <td colspan="5"><b>TOTAL KELAS</b></td>
                                <td colspan="2"><?php echo $tot_baris; ?></td>
                            </tr>
                                
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <?php

                        date_default_timezone_set('Asia/Jakarta');
                        $tanggal = date('Y/m/d');
                       

                    ?>

                     <table style="font-size: 14 ;">
                        <tr>
                            <td width="600px" style="color: white;">.</td>
                            <td width="100px" style="color: white;">.</td>
                            <td width="300px" style="text-align: left;">Pekanbaru, <?= $this->m_cetak_jadwal->getFormatTanggalIndo($tanggal) ?></td>
                        </tr>
                        <tr>
                            <td width="600px" style="text-align: left;">Wakil Dekan Bid. Akademik</td>
                            <td width="100px">.</td>
                            <td width="300px" style="text-align: left;">Ka.Prodi <?php echo $_SESSION['nama_prodi'] ?></td>
                            
                        </tr>
                    </table>
                    <br>
                    <br>
                    <br>
                    <br>
                     <table style="font-size: 14 ;">
                        <tr>

                            <td width="600px"><?= $this->m_cetak_jadwal->ambil_wd1() ?></td>
                            <td width="100px">.</td>
                            <td width="300px" style="text-align: left;"><?= $this->m_cetak_jadwal->ambil_kaprodi($_SESSION['kode_prodi']) ?></td>
                        </tr>
                    </table>
                   
    <?php
                   

                }else{
                    echo '<h1>Maaf, tidak ditemukan data yang valid!</h1>';
                }
            }else{
                 echo '<h1>Maaf, tidak ditemukan data yang valid!</h1>';
            }
        
   
                

    ?>
        </div> 
    </body>
</html>
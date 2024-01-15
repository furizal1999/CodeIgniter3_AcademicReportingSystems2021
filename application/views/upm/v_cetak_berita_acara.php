


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= 'BERITA ACARA';?></title>
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

            $data1 = $this->m_berita_acara->cetakBeritaAcara($data);
            if(empty($data1)){
                echo '<div class="text-warning"><h1>Maaf, Tidak ditemukan data yang falid!</h1></div>';
            }else{
                if($data1[0]->npk_pengawas1!=null AND $data1[0]->npk_pengawas2!=null){
                    $query="select * from tb_dosen where npk='".$data1[0]->npk_pengawas1."' or npk='".$data1[0]->npk_pengawas2."'";
                    $data2=$this->db->query($query)->result();
                    // echo "<pre>";print_r($data1);
                    // echo "<pre>";print_r($data2);
                    $id_jadwal_lanjutan =$data;
                    $nama_dosen1 =$data2[0]->nama_dosen;
                    $nama_dosen2 =$data2[1]->nama_dosen;
                    
                }elseif($data1[0]->npk_pengawas1!=null AND $data1[0]->npk_pengawas2==null){
                    $query="select * from tb_dosen where npk='".$data1[0]->npk_pengawas1."'";
                    $data2=$this->db->query($query)->result();
                    // echo "<pre>";print_r($data1);
                    // echo "<pre>";print_r($data2);
                    $id_jadwal_lanjutan =$data;
                    $nama_dosen1 =$data2[0]->nama_dosen;
                    $nama_dosen2 = "";
                    
                }elseif($data1[0]->npk_pengawas1==null AND $data1[0]->npk_pengawas2!=null){
                    $query="select * from tb_dosen where npk='".$data1[0]->npk_pengawas2."'";
                    $data2=$this->db->query($query)->result();
                    // echo "<pre>";print_r($data1);
                    // echo "<pre>";print_r($data2);
                    $id_jadwal_lanjutan =$data;
                    $nama_dosen1 = "";
                    $nama_dosen2 = $data2[0]->nama_dosen;
                    
                }
                
                $kode_jurusan =$data1[0]->kode_jurusan;
                $nama_ujian =$data1[0]->nama_ujian;
                $tahun_ajaran =$data1[0]->tahun_ajaran;
                $semester =$data1[0]->semester;
                $nama_mk =$data1[0]->nama_mk;
                $nama_kelas =$data1[0]->nama_kelas;
                $jenis_soal =$data1[0]->jenis_soal;


                //get nama dosen
                $dosen_pengampu =$data1[0]->dosen_pengampu;

                $array_dosen = explode(', ', $dosen_pengampu);
                
                $array_dosen_hasil = array();
                $array_npk_hasil = array();
                $index = 0;
                foreach ($array_dosen as $npk) {
                    $nama_dosen = $this->m_berita_acara->getNamaDosen($npk);
                    $array_npk_hasil[$index] = $npk;
                    $array_dosen_hasil[$index] = $nama_dosen;
                    $index++;
                }
                $string_dosen_hasil = implode('/ ', $array_dosen_hasil);


                $tanggal_ujian =$data1[0]->tanggal_ujian;
                $jam_mulai =$data1[0]->jam_mulai;
                $jam_selesai =$data1[0]->jam_selesai;
                $media =$data1[0]->media;
                $jumlah_mahasiswa =$data1[0]->jumlah_mahasiswa;
                $jumlah_mahasiswa_hadir =$data1[0]->jumlah_mahasiswa_hadir;
                $ket_pelaksanaan =$data1[0]->ket_pelaksanaan;
                $foto_bukti_pengawas1 =$data1[0]->foto_bukti_pengawas1;
                $foto_bukti_pengawas2 =$data1[0]->foto_bukti_pengawas2;
                $status_verifikasi_pengawas1 =$data1[0]->status_verifikasi_pengawas1;
                $status_verifikasi_pengawas2 =$data1[0]->status_verifikasi_pengawas2;

                $nomor_surat =$data1[0]->nomor_surat;
                $nama_surat =$data1[0]->nama_surat;
                $nama_dekan =$data1[0]->nama_dekan;
                $npk =$data1[0]->npk;
                $tgl_surat =$data1[0]->tanggal;
                $ket_ujian =$data1[0]->ket_ujian;
    
                if($nama_dosen1=="Tidak diketahui"){
                    $nama_dosen1 = "..............";
                }
    
                if($nama_dosen2=="Tidak diketahui"){
                    $nama_dosen2 = "..............";
                }

                $row = $this->m_berita_acara->ambil_nama_prodi($data1[0]->kode_prodi);
                if(isset($row)){
                    $nama_prodi = $row->nama_prodi;
                    $jenjang = $row->jenjang;
                }else{
                     $nama_prodi = "..................";
                     $jenjang = "..................";
                }
    
                $awal  = strtotime($tanggal_ujian.' '.$jam_mulai); //waktu awal
                $akhir = strtotime($tanggal_ujian.' '.$jam_selesai); //waktu akhir
                $diff  = $akhir - $awal;
                $jam   = floor($diff / (60 * 60));
                $menit = $diff - $jam * (60 * 60);
                $lama_ujian = $jam .  ' jam, ' . floor( $menit / 60 ) . ' menit';    
    
                if($media==""){
                    $media = "-";
                }
                
        
                if($nama_ujian=="Ujian Tengah Semester"){
                    $pdf_nama_ujian = "UJIAN TENGAH SEMESTER (UTS)";
                    $nama_ujian = "Ujian Tengah Semester (UTS)";
                }else{
                    $pdf_nama_ujian = "UJIAN AKHIR SEMESTER (UAS)";
                    $nama_ujian = "Ujian Akhir Semester (UAS)";
                }


                if($semester%2==1){
                    $pdf_semester = "GANJIL";
                }else{
                    $pdf_semester = "GENAP";
                }
                 date_default_timezone_set('Asia/Jakarta');
                $namaFile = 'BeritaAcara'.date('YmdHis').'.pdf';
    
                QRcode::png(base_url("prodi/cetak_berita_acara/cetak/".$data),"templates/img/qrcode/".$data.".png");

    ?>
            <img src="<?= base_url('templates/img/logo/kop_teknik.png') ?>">
            <br>
            <br>
            <div style="font-size: 16; text-align: center;">
                <b>BERITA ACARA <?php echo $pdf_nama_ujian.' '.$pdf_semester; ?> </b><br>
                <b>FAKULTAS TEKNIK UNIVERSITAS ISLAM RIAU</b><br>
                <b>TAHUN AKADEMIK <?php echo $tahun_ajaran ?></b>             
            </div>
            <hr>
            <div style="font-size: 13;">
                <p style="line-height: 20px; text-align: justify;">Berdasarkan <?= $nama_surat ?> Nomor  : <?= $nomor_surat ?> tanggal <?= $this->m_berita_acara->getFormatTanggalIndo($tgl_surat); ?>,  maka  pada   hari  ini   Tanggal <?= $this->m_berita_acara->getFormatTanggalIndo($tanggal_ujian); ?> telah dilangsungkan <?= $nama_ujian.' '.$pdf_semester ?> T.A <?= $tahun_ajaran ?> Secara <?= $ket_ujian ?> sebagai berikut:</p>
            </div>
            <?php $no=1; ?>
            <table style="font-size: 13; margin-left: 50px ; line-height: 20px;">
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Fakultas</td>
                    <td>:</td>
                    <td>Teknik</td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Program Studi</td>
                    <td>:</td>
                    <td><?= $nama_prodi ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Jenjang Pendidikan</td>
                    <td>:</td>
                    <td><?= $jenjang ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Matakuliah Yang Di Uji</td>
                    <td>:</td>
                    <td><?= $nama_mk ?></td>
                </tr>
                 <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Kelas</td>
                    <td>:</td>
                    <td><?= $nama_kelas ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Jenis Ujian yang Dilakukan</td>
                    <td>:</td>
                    <td><?= $jenis_soal ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Dosen Penguji/Pengasuh</td>
                    <td>:</td>
                    <td><?= $string_dosen_hasil ?></td>
                </tr>
    <?php
            if($status_verifikasi_pengawas1 == "Terverifikasi" && $status_verifikasi_pengawas2 == "Terverifikasi"){
    ?>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Pengawas 1</td>
                    <td>:</td>
                    <td><?= $nama_dosen1 ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Pengawas 2</td>
                    <td>:</td>
                    <td><?= $nama_dosen2 ?></td>
                </tr>
    <?php
            }elseif($status_verifikasi_pengawas1 != "Terverifikasi" && $status_verifikasi_pengawas2 == "Terverifikasi"){
    ?>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Pengawas 2</td>
                    <td>:</td>
                    <td><?= $nama_dosen2 ?></td>
                </tr>
    <?php
            }else{
    ?>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Pengawas 1</td>
                    <td>:</td>
                    <td><?= $nama_dosen1 ?></td>
                </tr>
    <?php
            }
    ?>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Waktu Ujian</td>
                    <td>:</td>
                    <td><?= $lama_ujian ?></td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Media Online yang Digunakan</td>
                    <td>:</td>
                    <td><?= $media ?></td>
                </tr>
                 <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Jumlah Peserta Ujian</td>
                    <td>:</td>
                    <td><?= $jumlah_mahasiswa ?> Orang</td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Jumlah Peserta Hadir</td>
                    <td>:</td>
                    <td><?= $jumlah_mahasiswa_hadir ?> Orang</td>
                </tr>
        <?php
            $tidak_hadir = ($jumlah_mahasiswa-$jumlah_mahasiswa_hadir);
            if($tidak_hadir<0){
                $tidak_hadir = 0;
            }
        ?>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Jumlah yang Tidak Mengikuti Ujian</td>
                    <td>:</td>
                    <td><?= $tidak_hadir ?> Orang</td>
                </tr>
                <tr>
                    <td width=""><?= $no++.'.'; ?></td>
                    <td width="220px">Keterangan</td>
                    <td>:</td>
                    <td><?= $ket_pelaksanaan ?></td>
                </tr>    
            </table>
            <br>
        <?php
            date_default_timezone_set('Asia/Jakarta');
            $tanggal_sekarang = date('Y/m/d');
        ?>
             <table style="font-size: 16px ;">
                <tr>
                    <td width="500px" style="color: white;"></td>
                    <td width="300px" style="text-align: left;">
                        Pekanbaru, <?php 
                        if($this->m_berita_acara->getTanggalTddDekan($data)!=""){
                            echo $this->m_berita_acara->getFormatTanggalIndo($this->m_berita_acara->getTanggalTddDekan($data));
                        }else{
                            echo $this->m_berita_acara->getFormatTanggalIndo($tanggal_sekarang);
                        }
                        ?>
                            
                        </td>
                </tr>
                <tr style="height: 50px;">
                    <td width="500px" align="center" rowspan="3"><img width="130px" src="<?= base_url('templates/img/qrcode/'.$data.'.png') ?>"></td>
                    <td width="300px" style="text-align: left;">
                        <?php
                                        $getIdRandom = $this->m_berita_acara->getIdRandomTddDekan($data);
                                        if($getIdRandom!=null){
                                        // echo $getIdRandom; die();

                                        QRcode::png(base_url("validasi_ttd_digital/cek/".$getIdRandom),"templates/img/qrcode/presensipertemuan".$getIdRandom.".png");
                                ?>
                                    <img width="110px" src="<?php echo base_url('templates/img/qrcode/presensipertemuan').$getIdRandom.'.png' ?>">
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
                                ?>
                    </td>
                </tr>
                <tr>
                    
                    <td width="300px" style="text-align: left;"><b><u>
                        <?php 
                            if($this->m_berita_acara->getNamaTtdDekan($data)!=""){
                                echo $this->m_berita_acara->getNamaTtdDekan($data);
                            }else{
                                echo $nama_dekan;
                            }
                        ?>
                            
                    </u></b></td>
                 <tr>
                    

                    <td width="300px" style="text-align: left;"></td>
                </tr>
              
                <tr>
                    <td width="500px" align="center" style="font-size: 10;"><i>Scan disini untuk melihat berkas asli</i></td>
                    <td width="300px" style="text-align: left;"></td>
                </tr>
                
            </table>


    <?php    
                // unlink("templates/img/qrcode/".$data.".png");
            }


           
    ?>

        </div> 
    </body>
</html>


   
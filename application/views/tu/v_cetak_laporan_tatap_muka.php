


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
    if(isset($_SESSION['bulan_search'])){


        $bulan_search = $_SESSION['bulan_search'];

        if($id_pertemuan!=null){
            $query= $this->m_laporan_tatap_muka->cekPertemuan($id_pertemuan);
            if($query->num_rows()==1){
                $row = $query->row();
                if($row){
                    $tahun_ajaran_judul = $row->tahun_ajaran;
                    $semester_judul = $row->semester;
                    $start = date('Y-m-d', strtotime($row->pertemuan_mulai));
                    $start = new DateTime($start);
                    $start->modify('first day of this month');
                    $end = date('Y-m-d', strtotime($row->pertemuan_selesai));

                    $end = new DateTime($end);
                    $end->modify('first day of next month');

                    $interval = DateInterval::createFromDateString('1 month');
                    $period   = new DatePeriod($start, $interval, $end);

                    $monthList = array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'Mei',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Agu',
                        '09' => 'Sep',
                        '10' => 'Okt',
                        '11' => 'Nov',
                        '12' => 'Des',
                    );
    ?>
                    <div style="text-align:center;">
                      <b>FAKULTAS TEKNIK UNIVERSITAS ISLAM RIAU</b>
                    </div><br>
                    <!-- <b>Daftar Pembayaran Honorium TATAP MUKA DOSEN</b> -->

                    <table style="font-size:12px">
                      <tr>
                        <td>FAKULTAS</td>
                        <td>:</td>
                        <td>TEKNIK</td>
                      </tr>
                      <tr>
                        <td>JURUSAN</td>
                        <td>:</td>
                        <td>SEMUA JURUSAN</td>
                      </tr>
                      <tr>
                        <td>Untuk Bulan</td>
                        <td>:</td>
                        <td><?= substr($_SESSION['bulan_search'],4,2)."-".substr($_SESSION['bulan_search'],0,4) ?></td>
                      </tr>
                    </table>
                    <hr>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <!-- <th>NIDN/USERNAME</th> -->
                                <th>NAMA DOSEN</th>
                                <th>JABATAN FUNGSIONAL</th>
                                <th>PEND</th>
                                <th colspan="3">MATAKULIAH</th>
                                <th>SKS</th>
                                <th>PRODI</th>
                                <th>SEM</th>
                                <th>KELAS</th>

                                <?php
                                    $jumlah_bulan = 0;
                                     foreach ($period as $dt) {
                                        $format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
                                        $format_time_angka = $dt->format("Y-m") ;
                                        $total_perbulan_array[$jumlah_bulan]=0;
                                ?>
                                    <th><?= strtoupper($format_time) ?></th>

                                <?php
                                    $jumlah_bulan++;
                                    }
                                ?>
                                <th>JUMLAH</th>
                            </tr>
                        </thead>
                        <tbody style="page-break-inside: avoid;">
                            <?php
                                 $mulai = false;
                                 $rowspan = false;

                                 $mulai2 = false;
                                 $rowspan2 = false;
                                 $jumlah = array();
                                 $total_semua_dosen_perbulan = 0;
                                 $data = $this->m_laporan_tatap_muka->show_laporan_tatap_muka($id_pertemuan);
                                 if($data->num_rows()>0){
                                    $no = 1;
                                    $no_mk = 1;
                                    $j_kategori = 0;
                                    $totFinal = 0;
                                    $tampil_total = 0;
                                    foreach ($data->result_array() as $item) {
                                        $id_jadwal_kelas_pertemuan = $item['id_jadwal_kelas_pertemuan'];
                                        $nama_dosen = $item['nama_dosen'];
                                        $str_npk = $item['str_npk'];
                                        $kode_mk = $item['kode_mk'];
                                        $nama_mk = $item['nama_mk'];
                                        $semester = $item['semester'];
                                        $sks_teori = $item['sks_teori'];
                                        $nama_kelas = $item['nama_kelas'];
                                        $kategori_tugas = $item['kategori_tugas'];
                                        $nama_prodi = $item['nama_prodi'];
                                        $pendidikan = $item['pendidikan'];
                                        $jabatan_fungsional = $item['jabatan_fungsional'];


                            ?>
                            <tr>
                                <?php


                                    if($mulai==false){
                                        $user = $str_npk;
                                        $mulai = true;
                                    }
                                    else{
                                        if($user == $str_npk){
                                            $rowspan = true;
                                        }else{
                                            $rowspan = false;
                                            $user = $str_npk;
                                        }
                                    }

                                    if($mulai2==false){
                                        $user2 = $str_npk;
                                        $kategori_tugas2 = $kategori_tugas;
                                        $mulai2 = true;
                                    }
                                    else{
                                        if($user2 == $str_npk && $kategori_tugas2 ==$kategori_tugas){
                                            $rowspan2 = true;
                                        }else{
                                            $rowspan2 = false;
                                            $user2 = $str_npk;
                                            $kategori_tugas2 = $kategori_tugas;
                                        }
                                    }


                                    if($rowspan==false){
                                        $j_kelas = $this->m_laporan_tatap_muka->cekJumlahKelas($id_pertemuan, $str_npk);
                                        $pokok= $this->m_laporan_tatap_muka->cekKetersediaanJenisTugas($id_pertemuan, $str_npk, 'Tugas Pokok');
                                        $luar_biasa= $this->m_laporan_tatap_muka->cekKetersediaanJenisTugas($id_pertemuan, $str_npk, 'Tugas Luar Biasa');

                                        // $jabatan_fungsional = $this->m_laporan_tatap_muka->getJabatanFungsional($str_npk);
                                        // $pendidikan = $this->m_laporan_tatap_muka->getPendidikan($str_npk);

                                ?>
                                        <td rowspan="<?= ($j_kelas+$pokok+$luar_biasa) ?>"><?= $no++ ?></td>

                                        <!-- <td rowspan="<?= ($j_kelas+$pokok+$luar_biasa) ?>"><?php if($_SESSION['orderby']=="prodi"){ echo substr($str_npk,1); }else{ echo $str_npk; } $str_npk; ?></td> -->
                                        <td rowspan="<?= ($j_kelas+$pokok+$luar_biasa) ?>"><?= $nama_dosen; ?></td>
                                        <td rowspan="<?= ($j_kelas+$pokok+$luar_biasa) ?>"><?= $jabatan_fungsional ?></td>
                                        <td rowspan="<?= ($j_kelas+$pokok+$luar_biasa) ?>"><?= $pendidikan ?></td>
                                <?php
                                    }
                                    if($rowspan2==false){
                                        $j_kategori = $this->m_laporan_tatap_muka->cekJumlahPerKategori($id_pertemuan, $str_npk, $kategori_tugas);
                                ?>
                                        <td rowspan="<?= ($j_kategori+1) ?>"><?= $kategori_tugas ?></td>
                                <?php
                                    }


                                 ?>

                                <!-- <td><?= $kategori_tugas ?></td> -->
                                <td><?= $no_mk++ ?></td>
                                <td><?= $nama_mk ?></td>
                                <td><?= $sks_teori ?></td>
                                <td><?= $nama_prodi ?></td>
                                <td><?= $semester ?></td>
                                <td><?= $nama_kelas ?></td>

                               <?php
                                        $i=0;
                                        $kalkulasi= 0;
                                        $kalkukasi_permatkul = 0;
                                         foreach ($period as $dt) {
                                        $format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
                                        $format_time_angka = $dt->format("Y-m") ;
                                        $format_time_angka_tanpa_strip = $dt->format("Ym") ;
                                            // code...
                                            if(date('Y-m', strtotime($format_time_angka))<=date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4)))){
                                                $jumlah[$i] = $this->m_laporan_tatap_muka->cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $str_npk, date('Y-m',strtotime($format_time_angka)));
                                             }else{
                                                $jumlah[$i] = 0;
                                             }
                                             // echo date('m',strtotime($format_time_angka));die();
                                             
                                             // $kalkulasi = $jumlah[$i]*($sks_teori*0.5); //Sebelumnya
                                             $kalkulasi = $jumlah[$i];

                                             $kalkukasi_permatkul = $kalkukasi_permatkul + $kalkulasi;
                                             if($tampil_total==1){
                                               $total_perbulan_array[$i] = 0;
                                             }
                                             $total_perbulan_array[$i]= $total_perbulan_array[$i] + $kalkulasi;
                                ?>

                                        <td <?php if(strcmp(str_replace('-', '', $bulan_search),$format_time_angka_tanpa_strip)==0){ echo 'style="background-color: yellow; color: black;"'; } ?>><?= $kalkulasi ?></td>

                                <?php
                                            $i++;
                                        }
                                        $tampil_total = 0;
                                        $totFinal= $totFinal + $kalkukasi_permatkul;
                                ?>
                                <td style="background-color: yellow; color: black;"><?= $kalkukasi_permatkul; ?></td>
                            </tr>

                            <?php
                            if($j_kategori==1){
                              $tampil_total = 1;
                              $no_mk=1;
                            ?>
                            <tr style="background-color:lightyellow">
                              <td colspan="6"><b>Jumlah</b></td>
                              <?php foreach ($total_perbulan_array as $key): ?>
                                  <td><?= $key ?></td>
                              <?php endforeach; ?>


                              <td><?= $totFinal ?></td>
                            </tr>

                            <?php
                                  $totFinal = 0;
                                }
                                    $j_kategori--;
                                    }
                                 }
                            ?>
                            <tr style="text-align:center; background-color: lightyellow;">
                                <td colspan="<?= 10+$jumlah_bulan-1 ?>">TOTAL</td>
                                <td><?= $total_semua_dosen_perbulan ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $hari_ini = date('Y-m-d');

                    ?>
                    <table style="font-size: 10 ;">
                        <tr>
                            <td width="800px" style="color: white;">.</td>
                            <td width="200px" style="text-align: left;">Pekanbaru, <?= $this->m_laporan_tatap_muka->format_tanggal($hari_ini) ?></td>
                        </tr>
                        <tr>
                            <td width="800px"></td>
                            <td width="200px" style="text-align: left;">Wakil Dekan Bid. Akademik</td>
                        </tr>
                    </table>
                    <br>
                    <br>
                    <br>
                     <table style="font-size: 10 ;">
                        <tr>

                            <td width="800px" style="color: white;">.</td>
                            <td width="200px" style="text-align: left;"><?= $this->m_laporan_tatap_muka->getWD1() ?></td>
                        </tr>
                    </table>
    <?php


                }
            }else{
                 echo '<h1>Maaf, tidak ditemukan data yang valid!</h1>';
            }
        }else{
            echo '<h1>Maaf, tidak ditemukan data yang valid!</h1>';
        }
    }else{
        echo '<h1>Maaf, anda belum memilih bulan yang akan di hitung!</h1>';
    }


    ?>
        </div>
    </body>
</html>

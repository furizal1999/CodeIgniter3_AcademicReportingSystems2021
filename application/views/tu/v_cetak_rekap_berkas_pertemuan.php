


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= 'REKAP BERKAS SIPA ';?></title>
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
                background-color: yellow;
                color: black;
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
        if($id_pertemuan!=null){
            $query= $this->m_laporan_tatap_muka->cekPertemuan($id_pertemuan);
            if($query->num_rows()==1){
                $row = $query->row();
                if($row){
                    $tahun_ajaran_judul = $row->tahun_ajaran;
                    $semester_judul = $row->semester;                   
    ?>
                    <div style="text-align:center;">
                      <b>REKAP BERKAS SIPA SEMESTER <?= strtoupper($semester_judul." ".$tahun_ajaran_judul) ?></b>
                    </div><br>

                  
                    <hr>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA DOSEN</th>
                                <th colspan="3">MATAKULIAH</th>
                                <th>SKS</th>
                                <th>PRODI</th>
                                <th>SEM</th>
                                <th>KELAS</th>

                                <th>Kontrak Kuliah</th>
                                <th>RPS</th>
                                <th>Soal UTS</th>
                                <th>Soal UAS</th>
                                <th>Nilai UTS</th>
                                <th>Nilai UAS</th>

                                <th>Tot. Kurang</th>
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
                                        <td rowspan="<?= ($j_kelas) ?>"><?= $no++ ?></td>

                                        <td rowspan="<?= ($j_kelas) ?>"><?= $nama_dosen; ?></td>
                                <?php
                                    }
                                    if($rowspan2==false){
                                        $j_kategori = $this->m_laporan_tatap_muka->cekJumlahPerKategori($id_pertemuan, $str_npk, $kategori_tugas);
                                ?>
                                        <td rowspan="<?= ($j_kategori) ?>"><?= $kategori_tugas ?></td>
                                <?php
                                    }


                                 ?>

                                <td><?= $no_mk++ ?></td>
                                <td><?= $nama_mk ?></td>
                                <td><?= $sks_teori ?></td>
                                <td><?= $nama_prodi ?></td>
                                <td><?= $semester ?></td>
                                <td><?= $nama_kelas ?></td>
                                <?php
                                    $hitung = 0;
                                    $kontrak_kuliah = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "Kontrak Kuliah", $id_pertemuan);
                                    $rps = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "RPS", $id_pertemuan);
                                    $soal_uts = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "Soal UTS", $id_pertemuan);
                                    $soal_uas = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "Soal UAS", $id_pertemuan);
                                    $nilai_uts = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "Nilai UTS", $id_pertemuan);
                                    $nilai_uas = $this->m_laporan_tatap_muka->checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, "Nilai UAS", $id_pertemuan);
                                    
                                    if($kontrak_kuliah=="0"){
                                        $hitung++;
                                    }
                                    if($rps==0){
                                        $hitung++;
                                    }
                                    if($soal_uts==0){
                                        $hitung++;
                                    }
                                    if($soal_uas==0){
                                        $hitung++;
                                    }
                                    if($nilai_uts==0){
                                        $hitung++;
                                    }
                                    if($nilai_uas==0){
                                        $hitung++;
                                    }
                               ?>
                                <?php if($kontrak_kuliah>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>
                                <?php if($rps>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>
                                <?php if($soal_uts>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>
                                <?php if($soal_uas>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>
                                <?php if($nilai_uts>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>
                                <?php if($nilai_uas>0){echo '<td style="background:green;"><b style="color:white;">Y</b></td>'; }else{ echo '<td style="background:red;"><b style="color:white;">N</b></td>';} ?>


                                <td style="background-color: yellow; color: black;"><?= $hitung ?></td>
                            </tr>

                            <?php
                                    // $j_kategori--;
                                    }
                                 }
                            ?>
                           
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
    ?>
        </div>
    </body>
</html>

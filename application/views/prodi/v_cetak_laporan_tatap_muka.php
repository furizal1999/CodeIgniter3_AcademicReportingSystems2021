


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
            $query= $this->m_laporan_tatap_muka_prodi->cekPertemuan($id_pertemuan);
            if($query->num_rows()==1){
                $row = $query->row();
                if($row){
                    $tahun_ajaran_judul = $row->tahun_ajaran;
                    $semester_judul = $row->semester;
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
                    <div>
                        <h5 style="text-align:center;">LAPORAN TATAP MUKA SEMESTER <?= strtoupper($semester_judul.' '.$tahun_ajaran_judul) ?> FAKULTAS TEKNIK</h5>
                    </div>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA DOSEN</th>
                                <th>JABATAN FUNGSIONAL</th>
                                <th>PEND</th>
                                <th colspan="2">MATAKULIAH</th>
                                <th>SKS</th>
                                <th>KELAS</th>
                                <th>PRODI</th>
                                <?php
                                    $jumlah_bulan = 0;
                                     foreach ($period as $dt) {
                                        $format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
                                        $format_time_angka = $dt->format("Y-m") ;
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
                                 $data = $this->m_laporan_tatap_muka_prodi->show_laporan_tatap_muka($id_pertemuan);
                                 if($data->num_rows()>0){
                                    $no = 1;
                                    foreach ($data->result_array() as $item) {
                                        $id_jadwal_kelas_pertemuan = $item['id_jadwal_kelas_pertemuan'];
                                        $nama_dosen = $item['nama_dosen'];
                                        $npk = $item['npk'];
                                        $kode_mk = $item['kode_mk'];
                                        $nama_mk = $item['nama_mk'];
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
                                        $kategori_tugas2 = $kategori_tugas;
                                        $mulai2 = true;
                                    }
                                    else{
                                        if($user2 == $npk && $kategori_tugas2 ==$kategori_tugas){
                                            $rowspan2 = true;
                                        }else{
                                            $rowspan2 = false;
                                            $user2 = $npk;
                                            $kategori_tugas2 = $kategori_tugas;
                                        }
                                    }


                                    if($rowspan==false){
                                        $j_kelas = $this->m_laporan_tatap_muka_prodi->cekJumlahKelas($id_pertemuan, $npk);

                                        // $jabatan_fungsional = $this->m_laporan_tatap_muka_prodi->getJabatanFungsional($npk);
                                        // $pendidikan = $this->m_laporan_tatap_muka_prodi->getPendidikan($npk);

                                ?>
                                        <td rowspan="<?= $j_kelas ?>"><?= $no++ ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $nama_dosen ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $jabatan_fungsional ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $pendidikan ?></td>
                                <?php
                                    }
                                    if($rowspan2==false){
                                        $j_kategori = $this->m_laporan_tatap_muka_prodi->cekJumlahPerKategori($id_pertemuan, $npk, $kategori_tugas);
                                ?>
                                        <td rowspan="<?= $j_kategori ?>"><?= $kategori_tugas ?></td>
                                <?php
                                    }
                                ?>
                                
                                <!-- <td><?= $kategori_tugas ?></td> -->
                                <td><?= $nama_mk ?></td>
                                <td><?= $sks_teori ?></td>
                                <td><?= $nama_kelas ?></td>
                                <td><?= $nama_prodi ?></td>
                               <?php
                                        $i=0;
                                         foreach ($period as $dt) {
                                        $format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
                                        $format_time_angka = $dt->format("Y-m") ;
                                        $format_time_angka_tanpa_strip = $dt->format("Ym") ;
                                            // code...
                                            if(date('Y-m', strtotime($format_time_angka))<=date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4)))){
                                                $jumlah[$i] = $this->m_laporan_tatap_muka_prodi->cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $npk, date('Y-m',strtotime($format_time_angka)));
                                             }else{
                                                $jumlah[$i] = 0;
                                             }      
                                             // echo date('m',strtotime($format_time_angka));die();


                                       
                                ?>

                                        <td <?php if(strcmp(str_replace('-', '', $bulan_search),$format_time_angka_tanpa_strip)==0){ echo 'style="background-color: yellow; color: black;"'; } ?>><?= $jumlah[$i]*($sks_teori*0.5) ?></td>
                                   
                                <?php
                                            $i++;
                                        }

                                    if($rowspan2==false){
                                        
                                        $array_perkategori = $this->m_laporan_tatap_muka_prodi->cekJumlahTatapMukaPerKategoriArray($id_pertemuan, $npk, $kategori_tugas);
                                        $total_bobot_perbulan = 0; 
                                        if($array_perkategori->num_rows()>0){
                                            foreach ($array_perkategori->result_array() as $a) {
                                                $jumlah_Perbulan = $this->m_laporan_tatap_muka_prodi->cekJumlahPerbulan($a['id_jadwal_kelas_pertemuan'], $a['npk'], date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4))));
                                               
                                                $total_bobot_perbulan = $total_bobot_perbulan + ($a['sks_teori'] * 0.5 * $jumlah_Perbulan);
                                            }
                                        }
                                        $total_semua_dosen_perbulan = $total_semua_dosen_perbulan +$total_bobot_perbulan;
                                    ?>
                                            <td style="background-color: yellow; color: black;" rowspan="<?= $j_kategori ?>"><?= $total_bobot_perbulan ?></td>
                                    <?php
                                    }
                                ?>
                            </tr>
                            <?php
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
                            <td width="200px" style="text-align: left;">Pekanbaru, <?= $this->m_laporan_tatap_muka_prodi->format_tanggal($hari_ini) ?></td>
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
                            <td width="200px" style="text-align: left;"><?= $this->m_laporan_tatap_muka_prodi->getWD1() ?></td>
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
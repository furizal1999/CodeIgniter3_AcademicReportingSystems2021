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
                font-size: 8px;
            }

            #table2 td, #table2 th {
                border: 1px solid #ddd;
                padding: 8px;
                font-size: 8px;
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
                font-size: 8px;
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

    ?>
                    <div style="text-align:center;  padding: 5;">
                        <h4><?= 'REKAPITULASI JUMLAH MAHASISWA/I PER-MATAKULIAH '.$nama_ujian.' '.$semester ?></h4>
                        <h4><?= 'FAKULTAS TEKNIK UIR TAHUN AKADEMIK '.$tahun_ajaran ?></h4>
                    </div>


                    <table id="table">
                        <thead>

                            <tr>
                                <th>No</th>
                                <th>Nama Pengawas</th>
                                <th>Matakuliah</th>
                                <th>Dosen Pengampu</th>
                                <th>Sem</th>
                                <th>Prodi</th>
                                <th>Kelas</th>
                                <th>Jml Mhs</th>
                                <th>Mhs/Mk</th>
                                <th>Mhs/Dsn</th>
                                <th>Mk/Dsn</th>
                                <th>Kls/Dsn</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
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
                                        $id_jadwal_kelas_pertemuan = $item['id_jadwal_kelas_pertemuan'];
                                        $nama_dosen = $item['nama_dosen'];
                                        $str_npk = $item['str_npk'];
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


                                    if($rowspan==false){
                                        // $j_kelas = $this->m_laporan_tatap_muka->cekJumlahKelas($id_pertemuan, $str_npk);

                                ?>
                                        <!-- <td rowspan="<?= $j_kelas ?>"><?= $no++ ?></td>

                                        <td rowspan="<?= $j_kelas ?>"><?php if($_SESSION['orderby']=="prodi"){ echo substr($str_npk,1); }else{ echo $str_npk; } $str_npk; ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $nama_dosen; ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $jabatan_fungsional ?></td>
                                        <td rowspan="<?= $j_kelas ?>"><?= $pendidikan ?></td> -->
                                <?php
                                    }
                                ?>


                                <th>No</th>
                                <th>Nama Pengawas</th>
                                <th>Matakuliah</th>
                                <th>Dosen Pengampu</th>
                                <th>Sem</th>
                                <th>Prodi</th>
                                <th>Kelas</th>
                                <th>Jml Mhs</th>
                                <th>Mhs/Mk</th>
                                <th>Mhs/Dsn</th>
                                <th>Mk/Dsn</th>
                                <th>Kls/Dsn</th>

                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <br>



    </body>
</html>

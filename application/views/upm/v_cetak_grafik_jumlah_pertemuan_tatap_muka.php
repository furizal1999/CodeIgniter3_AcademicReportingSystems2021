


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


        
        if(isset($_SESSION['id_pertemuan_search']) && isset($_SESSION['kode_prodi'])){
            $id_pertemuan= $_SESSION['id_pertemuan_search'];
            $kode_prodi= $_SESSION['kode_prodi'];
            $hasil = $this->m_grafik_jumlah_pertemuan_tatap_muka->data_dosen_pengampu_semester($id_pertemuan, $kode_prodi);
            if($hasil->num_rows()>0){
                $nomor_dosen = 1;
                foreach ($hasil->result_array() as $key):                           

                           ?>
                    <h5><?= $nomor_dosen ?>. Nama Dosen : <?php echo $key['nama_dosen'] ?> </h5>
                    <table id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Matakuliah</th>
                                <th>SKS</th>
                                <th>Nama Kelas</th>
                                <th>Pertemuan Terakhir</th>
                                <th>Persentasi Pertemuan</th>
                                <th>Grafik</th>
                            </tr>
                        </thead>
                        <tbody style="page-break-inside: avoid;">
                            <?php 
                                $hasil2 = $this->m_grafik_jumlah_pertemuan_tatap_muka->data_matkul_perdosen($id_pertemuan, $kode_prodi, $key['npk']);
                                if($hasil2->num_rows()>0){
                                    $nomor = 1;
                                    foreach ($hasil2->result_array() as $item):
                                        $jumlahTatapMukaPerkelas = $this->m_grafik_jumlah_pertemuan_tatap_muka->jumlahTatapMukaPerkelas($item['id_jadwal_kelas_pertemuan']);
                                        if($jumlahTatapMukaPerkelas>8){
                                            $jumlahTatapMukaPerkelas = $jumlahTatapMukaPerkelas -1;
                                        }
                                        $persentasi_sudah_masuk = $jumlahTatapMukaPerkelas/16*100;
                                        // $persentasi_belum_ujian = (16-$jumlahTatapMukaPerkelas-2)/16*100;
                                        // $persentasi_uts = 1/16*100;
                                        // $persentasi_uas = 1/16*100;
                                        $jumlah_sudah_masuk = $jumlahTatapMukaPerkelas;
                                        $jumlah_belum_ujian = (16-$jumlahTatapMukaPerkelas-2);
                                        $jumlah_uts = 1;
                                        $jumlah_uas = 1;

                            ?>
                            <tr>

                                <td><?php echo $nomor ?></td>
                                <td><?php echo $item['nama_mk'] ?></td>
                                <td><?php echo $item['sks_teori'] ?></td>
                                <td><?php echo $item['nama_kelas'] ?></td>
                                <td><?php echo $jumlahTatapMukaPerkelas ?></td>
                                <td><?php echo $persentasi_sudah_masuk; ?>%</td>
                                <td width="300px">
                                    <img
                      src="https://quickchart.io/chart?width=500&height=300&c={
                        type: 'pie',
                        data: {
                          labels: ['Jumlah Pertemuan', 'Sisa Pertemuan', 'UAS', 'UTS'],
                          datasets: [
                            { label: 'Grafik', data: [
                                <?= $jumlah_sudah_masuk ?>, 
                                <?= $jumlah_belum_ujian ?>, 
                                <?= $jumlah_uts ?>, 
                                <?= $jumlah_uas ?>
                            ] }
                          ]
                        }
                      }" width="300px">
                                </td>
                            </tr>
                            <?php    $nomor++;
                                     endforeach;
                                }else{
                            ?>
                            <tr>
                                <td colspan="6" align="center">TIDAK ADA DATA</td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <hr>
                    <br>
   <?php 
                $nomor_dosen++;
                endforeach;
            }
        }else{
             echo '<h1>Maaf, tidak ditemukan data yang valid!</h1>';
        }
        
   
                

    ?>
        </div> 
        
    </body>
</html>
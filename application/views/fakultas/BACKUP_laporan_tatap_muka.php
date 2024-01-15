 <table class="table table-bordered table-striped text-center" id="mydatascroll" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
												                        <thead>
												                            <tr class="bg-success">
												                                <th>NO</th>
												                                <th>NAMA DOSEN</th>
												                                <th>JABATAN FUNGSIONAL</th>
												                                <th>PEND</th>
												                                <th>JENIS TUGAS</th>
												                                <th>MATAKULIAH</th>
												                                <th>SKS</th>
												                                <th>KELAS</th>
												                                <th>PRODI</th>
												                                <?php
												                                    foreach ($period as $dt) {
												                                    	$format_time =  $dt->format("Y").'-'.$monthList[$dt->format("m")];
																						$format_time_angka = $dt->format("Y-m") ;
												                                ?>
												                                    <th><?= strtoupper($format_time) ?></th>
												                                    
												                                <?php
												                                    }
												                                ?>
												                                <th>JUMLAH</th>
												                            </tr>
												                        </thead>
												                        <tbody>
												                            <?php
												                               
												                                 $jumlah = array();
												                                 $total_semua_dosen_perbulan = 0;
												                                 $data = $this->m_laporan_tatap_muka->show_laporan_tatap_muka($id_pertemuan);
												                                 if($data->num_rows()>0){
												                                    $no = 1;
												                                    foreach ($data->result_array() as $item) {
												                                        $id_jadwal_kelas_pertemuan = $item['id_jadwal_kelas_pertemuan'];
												                                        $nama_dosen = $item['nama_dosen'];
												                                        $npk = $item['str_npk'];
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
												                                    

												                                  

												                                 $j_kelas = $this->m_laporan_tatap_muka->cekJumlahKelas($id_pertemuan, $npk);

										                                        // $jabatan_fungsional = $this->m_laporan_tatap_muka->getJabatanFungsional($npk);
										                                        // $pendidikan = $this->m_laporan_tatap_muka->getPendidikan($npk);
												                                       

												                                ?>
												                                        
												                           
												                                
												                               	<td><?= $no++ ?></td>
										                                        <td><?= $nama_dosen ?></td>
										                                        <td><?= $jabatan_fungsional ?></td>
										                                        <td><?= $pendidikan ?></td>
										                                        <td><?= $kategori_tugas ?></td>
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
												                                                $jumlah[$i] = $this->m_laporan_tatap_muka->cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $npk, date('Y-m',strtotime($format_time_angka)));
												                                             }else{
												                                                $jumlah[$i] = 0;
												                                             }      
												                                             // echo date('m',strtotime($format_time_angka));die();


												                                       
												                                ?>

												                                        <td <?php if(strcmp(str_replace('-', '', $bulan_search),$format_time_angka_tanpa_strip)==0){ echo 'style="background-color: yellow; color: black;"'; } ?>><?= $jumlah[$i]*($sks_teori*0.5) ?></td>
												                                   
												                                <?php
												                                			$i++;
												                                        }


										                                           $array_perkategori = $this->m_laporan_tatap_muka->cekJumlahTatapMukaPerKategoriArray($id_pertemuan, $npk, $kategori_tugas);
											                                        $total_bobot_perbulan = 0; 
											                                        if($array_perkategori->num_rows()>0){
											                                            foreach ($array_perkategori->result_array() as $a) {
											                                                $jumlah_Perbulan = $this->m_laporan_tatap_muka->cekJumlahPerbulan($a['id_jadwal_kelas_pertemuan'], $a['str_npk'], date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4))));

											                                                // echo $str = substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4);

											                                                // echo date('Y-m',strtotime(substr($bulan_search, 0, 4) . '-' . substr($bulan_search, 4))); die();
											                                                // echo $bulan_search; die();
											                                               
											                                                $total_bobot_perbulan = $total_bobot_perbulan + ($a['sks_teori'] * 0.5 * $jumlah_Perbulan);
											                                            }
											                                        }
											                                        $total_semua_dosen_perbulan = $total_semua_dosen_perbulan +$total_bobot_perbulan;
												                                    ?>
												                                    <td style="background-color: yellow; color: black;"><?= $total_bobot_perbulan ?></td>
												                               
												                            </tr>
												                            <?php
												                                    }  
												                                 }
												                            ?>
												                            <!-- <tr style="text-align:center; background-color: lightyellow;">
												                                <td colspan="15">TOTAL</td>
												                                <td><?= $total_semua_dosen_perbulan ?></td>
												                            </tr> -->
												                        </tbody>
												                    </table>
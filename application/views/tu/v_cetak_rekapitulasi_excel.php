
<?php
	header("Content-Type:application/octet-stream/");
	header("Content-Disposition:attachment; filename=$title.xls");

	header("Pragma: no-cache");
	header("Expires");


?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table border="1">
		<thead>
			<tr>
				<th>NO</th>
		        <th>NAMA PENGAWAS</th>
		        <th>MATAKULIAH</th>
		        <th>SEMESTER</th>
		        <th>PROGRAM STUDI</th>
		        <th>KELAS</th>
		        <th>JUMLAH MAHASISWA</th>
		        <th>JUMLAH MAHASISWA PER MATAKULIAH</th>
		        <th>MAHASISWA PER DOSEN</th>
		        <th>MATAKULIAH PER DOSEN</th>
		        <th>KELAS PER DOSEN</th>
			</tr>
		</thead>
		<tbody>
			
			<?php

				$no=1;
				$user = "";
				$mulai = false;
        		$rowspan = false;
        		$mulai2 = false;
	        	$rowspan2 = false;
        		$total_mhs1 = 0;
        		$total_mhs2 = 0;
        		$tot_mhsMk = 0;
        		$total_mk1 = 0;
        		$total_kelas1 = 0;
				foreach($data->result_array() as $rekapitulasi):
		            $npk=$rekapitulasi['npk'];
		            $nama_dosen=$rekapitulasi['nama_dosen'];
		            $kode_mk=$rekapitulasi['kode_mk'];
		            $mk=$rekapitulasi['mk'];
		            $prodi=$rekapitulasi['prodi'];
		            $kelas=$rekapitulasi['kelas'];
		            $tot_jumlah=$rekapitulasi['tot_jumlah'];
		            $jum_hadir=$rekapitulasi['jum_hadir'];

		            $row = $this->m_rekapitulasi->mhs_per_mk($npk, $_SESSION['id_ujian_search'], $kode_mk);
					if(isset($row)){
						$count_mhs_per_mk = $row->count_mhs_per_mk;
					}
					else{
						$count_mhs_per_mk = 0;
					}

		            $row = $this->m_rekapitulasi->j_mhs1($npk, $_SESSION['id_ujian_search']);
		            if(isset($row)){
		                $count_mhs = $row->count_mhs;
		            }
		            else{
		                $count_mhs = 0;
		            }

		            $row = $this->m_rekapitulasi->j_mk1($npk, $_SESSION['id_ujian_search']);
		            if(isset($row)){
		                $count_mk = $row->count_mk;
		            }
		            else{
		                $count_mk = 0;
		            }

		            $row = $this->m_rekapitulasi->j_kelas1($npk, $_SESSION['id_ujian_search']);
		            if(isset($row)){
		                $count_kelas = $row->count_kelas;
		            }
		            else{
		                $count_kelas = 0;
		            }

		            $row = $this->m_rekapitulasi->j_kelas_per_mk($npk, $_SESSION['id_ujian_search'],$kode_mk);
		            if(isset($row)){
		                $count_kelas_per_mk = $row->count_kelas_per_mk;
		            }
		            else{
		                $count_kelas_per_mk = 0;
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
		            
		
			?>
			<tr>
				<?php
					if($rowspan==false){
				?>
				<td rowspan="<?php echo $count_kelas;?>"><?php echo $no++;?></td>
				<td rowspan="<?php echo $count_kelas;?>"><?php echo $nama_dosen;?></td>
				<?php   
		            }
				?>
				
				<td><?php echo $mk;?></td>
				<td><?php echo substr($kelas, 0,1);?></td>
				<td><?php echo $prodi;?></td>
				<td><?php echo $kelas;?></td>
				<td><?php echo $jum_hadir;?></td>
				<?php
					$total_mhs1 = $total_mhs1+ $jum_hadir;

					if($rowspan2==false){
				?>
				<td rowspan="<?php echo $count_kelas_per_mk;?>"><?php echo $count_mhs_per_mk;?></td>
				<?php
						$tot_mhsMk = $tot_mhsMk+ $count_mhs_per_mk;
					}

					if($rowspan==false){
				?>
				<td rowspan="<?php echo $count_kelas;?>"><?php echo $count_mhs;?></td>
				<td rowspan="<?php echo $count_kelas;?>"><?php echo $count_mk;?></td>
				<td rowspan="<?php echo $count_kelas;?>"><?php echo $count_kelas;?></td>
				<?php   
						$total_mhs2 = $total_mhs2+ $count_mhs;
						$total_mk1 = $total_mk1+ $count_mk;
						$total_kelas1 = $total_kelas1+ $count_kelas;
		            }
				?>
			</tr>
				
			<?php endforeach; ?>
			<tr>
				<td colspan="6" class="text-center">TOTAL</td>
		        <td><?php echo $total_mhs1;?></td>
		        <td><?php echo $tot_mhsMk;?></td>
		        <td><?php echo $total_mhs2;?></td>
		        <td><?php echo $total_mk1;?></td>
		        <td><?php echo $total_kelas1;?></td>
			</tr>
			
		</tbody>
	</table>
</body>
</html>
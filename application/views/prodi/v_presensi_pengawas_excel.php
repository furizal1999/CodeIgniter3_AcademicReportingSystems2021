<?php
	header("Content-Type:application/octet-stream/");
	header("Content-Disposition:attachment; filename=filePresensiPengawas.xls");

	header("Pragma: no-cache");
	header("Expires");


?>

<?php
	$jumlah_sesi = array();
	$jumlah_hari = $data_tanggal_ujian->num_rows();
	$tanggal_array= array();
	$index = 0;


	foreach($data_tanggal_ujian->result_array() as $i):

		$tanggal_array[$index]=$i['tanggal'];

		$jumlah_sesi[$index] = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$index])->num_rows();

		

		$index++;
	endforeach;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<h1>DATA PRESENSI PENGAWAS UJIAN</h1>
	<table border="1px" class="table table-bordered table-striped" id="mydata" cellspacing="0" cellpadding="3" width="100%" style="width: 0px">
		<thead>
			<tr  class="bg-info">
				<td rowspan="2" align="center"><b>NO</b></td>
				<td rowspan="2" align="center"><b>NAMA PENGAWAS</b></td>
				<?php
					for ($i=0; $i < $jumlah_hari ; $i++) {	
				?>
				<td align="center" colspan="<?php echo $jumlah_sesi[$i];?>"><b><?php echo $tanggal_array[$i]; ?></b></td>	
				<?php
					}
							
				?>
				
			</tr>
			<tr>
				
				<?php
					for ($i=0; $i < $jumlah_hari ; $i++) {
						$sesi_array = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$i]);
						foreach ($sesi_array->result_array() as $sesi):
							$jam_mulai_array=$sesi['jam_mulai'];
						
						// for ($j=0; $j < $jumlah_sesi[$i]; $j++) { 
							// $this->m_presensi_pengawas->ambil_npk(, )
				?>

						<td><?php echo 'Sesi '.$jam_mulai_array;?></td>
				

				<?php
						// }
						endforeach;

					}
				?>
			</tr>
		</thead>
		<tbody>
		<?php 
				$no = 1;
				$mulai = false;
				$rowspan = false;
				foreach($data_dosen->result_array() as $i):
					$npk_dosen=$i['npk'];
					$nama_dosen=$i['nama_dosen'];
					
			?>
			<tr>
				<td><?php echo $no++;?></td>
				
				<td><?php echo $nama_dosen;?></td>	

				<?php
					for ($a=0; $a < $jumlah_hari ; $a++) {
						// for ($b=0; $b < $jumlah_sesi[$a]; $b++) { 
							

							$sesi_array = $this->m_presensi_pengawas->show_sesi_ujian($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$a]);
							foreach ($sesi_array->result_array() as $sesi):
								$jam_mulai_array=$sesi['jam_mulai'];
								
								$ttd = $this->m_presensi_pengawas->ambil_ttd($_SESSION['kode_prodi'], $_SESSION['id_ujian_search'], $tanggal_array[$a], $jam_mulai_array, $npk_dosen);

							if($ttd){
								$jam_mulai = $ttd->jam_mulai;
							}
							else{
								$jam_mulai ="";
							}
							
				?>

						<td>
								<?php 
								// echo $jam_mulai;
								if($jam_mulai==$jam_mulai_array){echo $jam_mulai;}else{echo '-';} 
								?>
								<!-- aa -->
								
						</td>
				

				<?php
							endforeach;
						// }
					}
				?>
				
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</body>
</html>
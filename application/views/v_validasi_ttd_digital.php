<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	
</head>
<body>
	<div class="wrapper">
	  <div class="container">

	    <div class="row pt-5">
	    	<div class="col-md-4">
	    	</div>
	    	<div class="col-md-4">
	    		<?php
	      			if($getDataValidasi->num_rows()==1){
	      				$row = $getDataValidasi->row();
	      				if($row){
	      					$nama_penanda_tangan = $row->nama_penanda_tangan;
	      					$jabatan_penanda_tangan = $row->jabatan_penanda_tangan;
	      					$perihal = $row->perihal;
	      					$waktu_input_ttd = $row->waktu_input_ttd;
	      					$tanggal_input = date('Y-m-d', strtotime($waktu_input_ttd));
	      					$tanggal_diformat = $this->m_validasi->format_tanggal($tanggal_input);
	      					$jam_input = date('H:i', strtotime($waktu_input_ttd));

	      					$status_validasi = $row->status_validasi;
	      					$id_random = $row->id_random;
	      		?>

	      		<div class="card rounded">
			      <header class="card-header bg-success rounded text-white">
			        <h1 class="text-center text-white">TERVALIDASI</h1>
			      </header>
			      <div class="card-body">

			        	<p class="card-content">  
					         <h5>Waktu Tanda Tangan</h5>
					         <h3 class="text-primary">Tanggal <?= $tanggal_diformat ?></h3>
					         <h3 class="text-primary">Pukul <?= $jam_input ?> WIB</h3>
				        </p>
				        <p class="card-content">  
					         <h5>Penanda Tangan</h5>
					         <h3 class="text-primary"><?= $nama_penanda_tangan.' ('.$jabatan_penanda_tangan.')' ?></h3>
				        </p>
				         <p class="card-content">  
					         <h5>Perihal</h5>
					         <h3 class="text-primary"><?= $perihal ?></h3>
				        </p>
			      </div>
			      <footer class="card-footer text-primary">
			        Validasi oleh sistem
			      </footer>
			    </div>

	      		<?php
	      				}
	      			}else{
	      		?>
	      		<div class="card rounded">
			      <header class="card-header bg-danger rounded text-white">
			        <h1 class="text-center text-white">TIDAK TERVALIDASI</h1>
			      </header>
			      <footer class="card-footer text-danger">
			        Maaf, tanda tangan digital ini tidak tervalidasi pada sistem kami!
			      </footer>

			    </div>
	      		<?php
	      			}

	      		?>
	    		
	    	</div>
	    	<div class="col-md-4">
	    	</div>
	    </div>
	    
	  </div>
	</div>

</body>
</html>
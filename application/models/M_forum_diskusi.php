<?php
class M_forum_diskusi extends CI_model{
	function data(){
		$q = "SELECT * FROM tb_forum_diskusi 
			WHERE 
			jenis_diskusi = 'General' AND
			status_penerima = 'Everyone' AND
			username_penerima = 'Everyone' AND
			nama_penerima = 'Everyone' AND
			status = 'Tersedia'
			ORDER BY
			id_diskusi ASC";
		return $q;
	}
	function data_forum_diskusi(){
		$query = $this->data();
		$hasil = $this->db->query("
			$query;
		")->result_array();
		return $hasil;
	}

	function insert_chat($status_pengirim, $username_pengirim, $nama_pengirim, $foto_pengirim, $isi_pesan){
		date_default_timezone_set('Asia/Jakarta');
	    $waktu_input = date("Y-m-d H:i:s");
		$hasil = $this->db->query("INSERT INTO tb_forum_diskusi (jenis_diskusi, status_pengirim, username_pengirim, nama_pengirim, foto_pengirim, status_penerima, username_penerima, nama_penerima, foto_penerima, waktu_pesan, isi_pesan, status) VALUES ('General', '$status_pengirim', '$username_pengirim', '$nama_pengirim', '$foto_pengirim', 'Everyone', 'Everyone', 'Everyone', 'Everyone', '$waktu_input', '$isi_pesan', 'Tersedia')");


		$options = array(
		    'cluster' => 'ap1',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    'a64f2e32e363a09b9ed7',
		    '846a57217e5d36dd290c',
		    '1306769',
		    $options
		  );
		  $query = "SELECT * FROM `tb_forum_diskusi` ORDER BY id_diskusi DESC LIMIT 1";
		  $push = $this->db->query("$query")->result_array();

		  foreach ($push as $key) {
		  	$data_pusher[] = $key;
		  }


		if($hasil){
			$pusher->trigger('my-channel', 'my-event', $data_pusher);
			return $hasil;
		}
		
	}


	


	// public function ownerDetails(){
	// 	if(isset($_SESSION['login_smpu'])){
	// 		$status_login = $_SESSION['status_login'];
	// 		$username = $_SESSION['username'];
	// 		if($status_login=="Fakultas"){
	// 			$res = $this->db->query("SELECT * FROM tb_fakultas WHERE username='$username'");
	// 		}elseif($status_login=="UPM"){
	// 			$res = $this->db->query("SELECT * FROM tb_upm WHERE username='$username'");
	// 		}elseif($status_login=="Tata Usaha"){
	// 			$res = $this->db->query("SELECT * FROM tb_tu WHERE username='$username'");
	// 		}elseif($status_login=="Prodi"){
	// 			$res = $this->db->query("SELECT * FROM tb_prodi, tb_prodi_attribut WHERE tb_prodi.kode_prodi = tb_prodi_attribut.kode_prodi AND tb_prodi_attribut.username='$username' AND tb_prodi_attribut.status_akun != 'Dihapus' AND tb_prodi.status='Tersedia'");
	// 		}elseif($status_login=="Dosen"){
	// 			$res = $this->db->query("SELECT * FROM tb_dosen, tb_prodi WHERE tb_dosen.kode_jurusan=tb_prodi.kode_prodi AND tb_dosen.npk='$username' AND status_jabatan='Dosen' AND tb_dosen.status!='Dihapus' AND tb_prodi.status='Tersedia'");
	// 		}elseif($status_login=="Pegawai"){
	// 			$res = $this->db->query("SELECT * FROM tb_dosen, tb_prodi WHERE tb_dosen.kode_jurusan=tb_prodi.kode_prodi AND tb_dosen.npk='$username' AND status_jabatan='Pegawai' AND tb_dosen.status!='Dihapus' AND tb_prodi.status='Tersedia'");
	// 		}else{
	// 			$res = $this->db->query("SELECT * FROM tb_prodi, tbl_mahasiswa WHERE tbl_mahasiswa.kode_prodi = tb_prodi.kode_prodi AND npm='$username' AND tb_prodi.status='Tersedia' AND tbl_mahasiswa.status!='Dihapus' ");
	// 		}
			
	// 		return $res->result_array();
	// 	}
	// }
	
	
}


?>
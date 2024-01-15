<?php
class M_atur_admin extends CI_Model{
	
	function show_atur_admin($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_prodi_attribut WHERE kode_prodi = $kode_jurusan;");
		return $hasil;
	}

	function tambah_admin_prodi($username, $kode_jurusan, $nama_lengkap, $npk, $jk, $email, $no_hp, $jabatan, $hak_akses, $password_enc, $foto, $status_akun){
		$hasil=$this->db->query("INSERT INTO tb_prodi_attribut (username, kode_prodi, nama_lengkap, npk, jenis_kelamin, email, no_hp, jabatan, hak_akses, password, foto, status_akun) VALUES ('$username', '$kode_jurusan', '$nama_lengkap', '$npk', '$jk', '$email', '$no_hp', '$jabatan', '$hak_akses', '$password_enc', '$foto', '$status_akun')");
		return $hasil;
	}

	
	function edit_admin_prodi($username, $kode_jurusan, $nama_lengkap, $jk, $email, $no_hp, $jabatan){
		$hasil=$this->db->query("UPDATE tb_prodi_attribut SET nama_lengkap='$nama_lengkap', jenis_kelamin='$jk', email='$email', no_hp='$no_hp', jabatan='$jabatan' WHERE kode_prodi = '$kode_jurusan' AND username='$username'");
		return $hasil;
	}

	function hapus_admin_prodi($username, $kode_prodi){
		$hasil=$this->db->query("DELETE FROM tb_prodi_attribut WHERE username='$username' AND kode_prodi = '$kode_prodi';");
		return $hasil;
	}

	function aktifkan_admin_prodi($username, $kode_prodi){
		$hasil=$this->db->query("UPDATE tb_prodi_attribut SET status_akun='Aktif' WHERE  username='$username' AND kode_prodi = '$kode_prodi'");
		return $hasil;
	}

	function nonaktifkan_admin_prodi($username, $kode_prodi){
		$hasil=$this->db->query("UPDATE tb_prodi_attribut SET status_akun='Non-aktif' WHERE  username='$username' AND kode_prodi = '$kode_prodi'");
		return $hasil;
	}

	function checknpk($npk){
		$sql = "SELECT * FROM tb_prodi_attribut WHERE npk = '$npk'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}






	//FAKULTAS ADMIN

	function show_atur_admin_fakultas(){
		$hasil=$this->db->query("SELECT * FROM tb_fakultas");
		return $hasil;
	}

	function tambah_admin_fakultas($username, $nama_lengkap, $npk, $jk, $email, $no_hp, $jabatan, $hak_akses, $password_enc, $foto, $status_akun){
		$hasil=$this->db->query("INSERT INTO tb_fakultas (username, nama, npk, jenis_kelamin, email, no_hp, jabatan, hak_akses, password, foto, status) VALUES ('$username', '$nama_lengkap', '$npk', '$jk', '$email', '$no_hp', '$jabatan', '$hak_akses', '$password_enc', '$foto', '$status_akun')");
		return $hasil;
	}

	
	function edit_admin_fakultas($username, $nama_lengkap, $jk, $email, $no_hp, $jabatan){
		$hasil=$this->db->query("UPDATE tb_fakultas SET nama='$nama_lengkap', jenis_kelamin='$jk', email='$email', no_hp='$no_hp', jabatan='$jabatan' WHERE username='$username'");
		return $hasil;
	}

	function hapus_admin_fakultas($username){
		$hasil=$this->db->query("DELETE FROM tb_fakultas WHERE username='$username'");
		return $hasil;
	}

	function aktifkan_admin_fakultas($username){
		$hasil=$this->db->query("UPDATE tb_fakultas SET status='Aktif' WHERE  username='$username'");
		return $hasil;
	}

	function nonaktifkan_admin_fakultas($username){
		$hasil=$this->db->query("UPDATE tb_fakultas SET status='Non-aktif' WHERE  username='$username'");
		return $hasil;
	}

	function checkUsername($username){
		$sql = "SELECT * FROM tb_fakultas WHERE username = '$username'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}




	// UPM

	function show_atur_admin_upm(){
		$hasil=$this->db->query("SELECT * FROM tb_upm");
		return $hasil;
	}

	function tambah_admin_upm($username, $nama_lengkap, $npk, $jk, $email, $no_hp, $hak_akses, $password_enc, $foto, $status_akun){
		$hasil=$this->db->query("INSERT INTO tb_upm (username, nama, npk, jenis_kelamin, email, no_hp, hak_akses, password, foto, status) VALUES ('$username', '$nama_lengkap', '$npk', '$jk', '$email', '$no_hp', '$hak_akses', '$password_enc', '$foto', '$status_akun')");
		return $hasil;
	}

	
	function edit_admin_upm($username, $nama_lengkap, $jk, $email, $no_hp){
		$hasil=$this->db->query("UPDATE tb_upm SET nama='$nama_lengkap', jenis_kelamin='$jk', email='$email', no_hp='$no_hp' WHERE username='$username'");
		return $hasil;
	}

	function hapus_admin_upm($username){
		$hasil=$this->db->query("DELETE FROM tb_upm WHERE username='$username'");
		return $hasil;
	}

	function aktifkan_admin_upm($username){
		$hasil=$this->db->query("UPDATE tb_upm SET status='Aktif' WHERE  username='$username'");
		return $hasil;
	}

	function nonaktifkan_admin_upm($username){
		$hasil=$this->db->query("UPDATE tb_upm SET status='Non-aktif' WHERE  username='$username'");
		return $hasil;
	}

	function checkUsernameUpm($username){
		$sql = "SELECT * FROM tb_upm WHERE username = '$username'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}


	// UPM

	function show_atur_admin_tu(){
		$hasil=$this->db->query("SELECT * FROM tb_tu");
		return $hasil;
	}

	function tambah_admin_tu($username, $nama_lengkap, $npk, $jk, $email, $no_hp, $hak_akses, $password_enc, $foto, $status_akun){
		$hasil=$this->db->query("INSERT INTO tb_tu (username, nama, npk, jenis_kelamin, email, no_hp, hak_akses, password, foto, status) VALUES ('$username', '$nama_lengkap', '$npk', '$jk', '$email', '$no_hp', '$hak_akses', '$password_enc', '$foto', '$status_akun')");
		return $hasil;
	}

	
	function edit_admin_tu($username, $nama_lengkap, $jk, $email, $no_hp){
		$hasil=$this->db->query("UPDATE tb_tu SET nama='$nama_lengkap', jenis_kelamin='$jk', email='$email', no_hp='$no_hp' WHERE username='$username'");
		return $hasil;
	}

	function hapus_admin_tu($username){
		$hasil=$this->db->query("DELETE FROM tb_tu WHERE username='$username'");
		return $hasil;
	}

	function aktifkan_admin_tu($username){
		$hasil=$this->db->query("UPDATE tb_tu SET status='Aktif' WHERE  username='$username'");
		return $hasil;
	}

	function nonaktifkan_admin_tu($username){
		$hasil=$this->db->query("UPDATE tb_tu SET status='Non-aktif' WHERE  username='$username'");
		return $hasil;
	}

	function checkUsernametu($username){
		$sql = "SELECT * FROM tb_tu WHERE username = '$username'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}
	
}
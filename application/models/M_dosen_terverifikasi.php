<?php
class M_dosen_terverifikasi extends CI_Model{
	
	function show_dosen_terverifikasi($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_dosen WHERE kode_jurusan=$kode_jurusan AND (status='Aktif' OR status ='Non-aktif')");
		return $hasil;
	}

	function combobox_jurusan(){
		$hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia'");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC"); //PAKAI ORDER BY
	    return $hasil;
	}

	function verifikasi($kode_jurusan, $npk){
		$hasil=$this->db->query("UPDATE tb_dosen SET status='Aktif' WHERE kode_jurusan='$kode_jurusan' AND npk='$npk'");
		return $hasil;
	}

	function batal_verifikasi($kode_jurusan, $npk){
		$hasil=$this->db->query("UPDATE tb_dosen SET status='Non-aktif' WHERE kode_jurusan='$kode_jurusan' AND npk='$npk'");
		return $hasil;
	}

	function edit_dosen_terverifikasi_nophoto($npk, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen= '$nama_dosen', jk = '$jk', email = '$email', jabatan_fungsional = '$jabatan_fungsional', pendidikan = '$pendidikan', status_dosen = '$status_dosen' WHERE npk='$npk' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}

	function edit_dosen_terverifikasi($npk, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen, $fotobaru){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen= '$nama_dosen', jk = '$jk', email = '$email', jabatan_fungsional = '$jabatan_fungsional', pendidikan = '$pendidikan', status_dosen = '$status_dosen', foto='$fotobaru' WHERE npk='$npk' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}

	function hapus_dosen_terverifikasi($kode_jurusan, $npk){
		$hasil=$this->db->query("UPDATE tb_dosen SET status='Dihapus' WHERE npk='$npk' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}

	function daftar_akun_dosen($npk, $status_jabatan, $nama_dosen, $jk, $email, $kode_jurusan, $jabatan_fungsional, $pendidikan, $status_dosen, $password_enc, $foto, $status){
		
		$hasil=$this->db->query("INSERT INTO tb_dosen (npk, status_jabatan, nama_dosen, jk, email, kode_jurusan, jabatan_fungsional, pendidikan, status_dosen, password, foto, status) VALUES ('$npk', '$status_jabatan', '$nama_dosen', '$jk', '$email', '$kode_jurusan', '$jabatan_fungsional', '$pendidikan', '$status_dosen', '$password_enc', '$foto', '$status')");
		return $hasil;
	}

	function checkPrimaryKey($npk){
		$sql = "SELECT * FROM tb_dosen WHERE npk = '$npk'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function edit_dosen_dihapus($npk, $status){
		$hasil=$this->db->query("UPDATE tb_dosen SET status='$status' WHERE npk='$npk'");
		return $hasil;
	}

	function reset_password($kode_jurusan, $npk, $password_baru_enc){
		$hasil=$this->db->query("UPDATE tb_dosen SET password='$password_baru_enc' WHERE npk='$npk' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}
	
}
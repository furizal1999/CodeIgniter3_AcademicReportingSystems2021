<?php
class M_profil extends CI_Model{

	function edit_profil_nophoto($nama_tabel, $field_nama, $username, $nama, $npk, $jk, $no_hp, $email){
		$hasil=$this->db->query("UPDATE $nama_tabel SET $field_nama='$nama', npk='$npk', jenis_kelamin='$jk', no_hp='$no_hp', email='$email' WHERE username = '$username';");
		return $hasil;
	}

	function edit_profil($nama_tabel, $field_nama, $username, $nama, $npk, $jk, $no_hp, $email, $fotobaru){
		$hasil=$this->db->query("UPDATE $nama_tabel SET $field_nama='$nama', npk='$npk', jenis_kelamin='$jk', no_hp='$no_hp', email='$email', foto='$fotobaru' WHERE username = '$username';");
		return $hasil;
	}

	function edit_profil_dosen_nophoto($nama, $npk, $jk, $email){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen='$nama', jk='$jk', email='$email' WHERE npk = '$npk';");
		return $hasil;
	}

	function edit_profil_dosen($nama, $npk, $jk, $email, $fotobaru){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen='$nama', jk='$jk', email='$email', foto='$fotobaru' WHERE npk = '$npk';");
		return $hasil;
	}

	function ambil($nama_tabel, $nama_field, $isi){
		$query = $this->db->query("SELECT * from $nama_tabel where $nama_field='$isi'");
		return $row = $query->row();
	}

	function ganti_password($nama_tabel, $nama_field, $isi, $password_baru_enc){
		return $this->db->query("UPDATE $nama_tabel SET password='$password_baru_enc' where $nama_field='$isi'");
	}
	

	
}
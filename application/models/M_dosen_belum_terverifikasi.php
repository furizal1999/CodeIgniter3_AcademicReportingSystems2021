<?php
class M_dosen_belum_terverifikasi extends CI_Model{
	
	function show_dosen_belum_terverifikasi($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_dosen WHERE kode_jurusan=$kode_jurusan AND status='Non-aktif'");
		return $hasil;
	}

	function combobox_jurusan(){
		$hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia'");
		return $hasil;
	}

	function batal_verifikasi($npk){
		$hasil=$this->db->query("UPDATE tb_dosen SET status='Aktif' WHERE npk='$npk'");
		return $hasil;
	}

	function edit_dosen_belum_terverifikasi_nophoto($npk, $nama_dosen, $tempat_lahir, $tanggal_lahir, $jk, $keahlian, $email, $no_hp, $alamat, $kode_jurusan){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen= '$nama_dosen', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', jk = '$jk', keahlian='$keahlian', email = '$email', no_hp = '$no_hp', alamat = '$alamat', kode_jurusan='$kode_jurusan' WHERE npk='$npk'");
		return $hasil;
	}

	function edit_dosen_belum_terverifikasi($npk, $nama_dosen, $tempat_lahir, $tanggal_lahir, $jk, $keahlian, $email, $no_hp, $alamat, $kode_jurusan, $fotobaru){
		$hasil=$this->db->query("UPDATE tb_dosen SET nama_dosen= '$nama_dosen', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', jk = '$jk', keahlian='$keahlian', email = '$email', no_hp = '$no_hp', alamat = '$alamat', kode_jurusan='$kode_jurusan', foto='$fotobaru' WHERE npk='$npk'");
		return $hasil;
	}

	function hapus_dosen_belum_terverifikasi($npk){
		$hasil=$this->db->query("DELETE FROM tb_dosen WHERE npk='$npk'");
		return $hasil;
	}

	
}
<?php
class M_matkul extends CI_Model{
	
	function show_matkul($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_matkul WHERE kode_jurusan=$kode_jurusan AND status='Tersedia'");
		return $hasil;
	}

	function combobox_kode_mk_prasyarat($kode_jurusan){
		$hasil=$this->db->query("SELECT kode_mk, nama_mk, semester from tb_matkul WHERE kode_jurusan=$kode_jurusan AND status='Tersedia'");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function tambah_matkul($kode_mk, $nama_mk, $sks_teori, $sks_praktik, $semester, $kode_mk_prasyarat, $kode_jurusan){
		$hasil=$this->db->query("INSERT INTO tb_matkul (kode_mk, nama_mk, sks_teori, sks_praktik, semester, kode_mk_prasyarat, kode_jurusan, status) VALUES ('$kode_mk', '$nama_mk', $sks_teori, $sks_praktik, '$semester', '$kode_mk_prasyarat', '$kode_jurusan', 'Tersedia')");
		return $hasil;
	}

	function edit_matkul($kode_mk, $nama_mk, $sks_teori, $sks_praktik, $semester, $kode_mk_prasyarat, $kode_jurusan){
		$hasil=$this->db->query("UPDATE tb_matkul SET nama_mk='$nama_mk', sks_teori='$sks_teori', sks_praktik='$sks_praktik', semester='$semester', kode_mk_prasyarat='$kode_mk_prasyarat', kode_jurusan='$kode_jurusan' WHERE kode_mk='$kode_mk'");
		return $hasil;
	}

	function hapus_matkul($kode_mk){
		$hasil=$this->db->query("UPDATE tb_matkul SET status='Dihapus' WHERE kode_mk='$kode_mk'");
		return $hasil;
	}

	function checkPrimaryKey($kode_mk){
		$sql = "SELECT * FROM tb_matkul WHERE kode_mk = '$kode_mk'";
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
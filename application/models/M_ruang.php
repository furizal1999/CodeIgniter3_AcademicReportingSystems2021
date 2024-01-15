<?php
class M_ruang extends CI_Model{
	
	function show_ruang($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_ruang WHERE kode_jurusan=$kode_jurusan");
		return $hasil;
	}

	function combobox_kode_mk_prasyarat($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_ruang WHERE kode_jurusan=$kode_jurusan");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function tambah_ruang($kode_ruang, $kapasitas, $kode_jurusan, $ket){
		$hasil=$this->db->query("INSERT INTO tb_ruang (kode_ruang, kapasitas, kode_jurusan, ket) VALUES ('$kode_ruang', $kapasitas, '$kode_jurusan', '$ket')");
		return $hasil;
	}

	function edit_ruang($kode_ruang, $kapasitas, $kode_jurusan, $ket){
		$hasil=$this->db->query("UPDATE tb_ruang SET kapasitas='$kapasitas', ket='$ket' WHERE kode_ruang='$kode_ruang' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}

	function hapus_ruang($kode_ruang){
		$hasil=$this->db->query("DELETE FROM tb_ruang WHERE kode_ruang='$kode_ruang'");
		return $hasil;
	}

	function checkPrimaryKey($kode_ruang){
		$sql = "SELECT * FROM tb_ruang WHERE kode_ruang = '$kode_ruang'";
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
<?php
class M_kelas extends CI_Model{
	
	function show_kelas($kode_jurusan){
		$hasil=$this->db->query("SELECT * FROM tb_kelas WHERE kode_jurusan=$kode_jurusan ORDER BY semester, nama_kelas ASC");
		return $hasil;
	}

	function tambah_kelas($kode_jurusan, $semester, $kelas, $kelas_pilihan){
		$hasil=$this->db->query("INSERT INTO tb_kelas (kode_jurusan, semester, nama_kelas, kelas_pilihan) VALUES ('$kode_jurusan', '$semester', '$kelas', '$kelas_pilihan');");
		return $hasil;
	}

	function edit_kelas($id_kelas, $kode_jurusan, $semester, $kelas, $kelas_pilihan){
		$hasil=$this->db->query("UPDATE tb_kelas SET semester='$semester', nama_kelas='$kelas',  kelas_pilihan='$kelas_pilihan' WHERE kode_jurusan='$kode_jurusan' AND id_kelas='$id_kelas'");
		return $hasil;
	}

	function hapus_kelas($id_kelas){
		$kode_jurusan= $_SESSION['kode_prodi'];
		$hasil=$this->db->query("DELETE FROM tb_kelas WHERE id_kelas='$id_kelas' AND kode_jurusan='$kode_jurusan'");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}
		
}
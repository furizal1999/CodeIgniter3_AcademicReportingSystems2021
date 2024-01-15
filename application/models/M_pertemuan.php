<?php
class M_pertemuan extends CI_Model{
	
	function show_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function tambah_pertemuan($id_semester, $jenis_pertemuan, $waktu_pertemuan_mulai, $waktu_pertemuan_selesai){

		$hasil=$this->db->query("INSERT INTO tb_pertemuan (id_semester, jenis_pertemuan, pertemuan_mulai, pertemuan_selesai, status) VALUES ($id_semester, '$jenis_pertemuan', '$waktu_pertemuan_mulai', '$waktu_pertemuan_selesai', 'Tersedia')");
		return $hasil;
	}

	function edit_pertemuan($id_pertemuan, $id_semester, $jenis_pertemuan, $waktu_pertemuan_mulai, $waktu_pertemuan_selesai){
		$hasil=$this->db->query("UPDATE tb_pertemuan SET id_semester='$id_semester', jenis_pertemuan='$jenis_pertemuan', pertemuan_mulai='$waktu_pertemuan_mulai', pertemuan_selesai='$waktu_pertemuan_selesai' WHERE id_pertemuan='$id_pertemuan';");
		return $hasil;
	}

	function hapus_pertemuan($id_pertemuan){
		$hasil=$this->db->query("UPDATE tb_pertemuan SET status='Dihapus' WHERE id_pertemuan='$id_pertemuan';");
		return $hasil;
	}
	
	function check_ketersediaan($id_semester){
		$sql = "SELECT * FROM tb_pertemuan WHERE id_semester = '$id_semester' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_ketersediaan_edit($id_pertemuan, $id_semester){
		$sql = "SELECT * FROM tb_pertemuan WHERE id_semester = '$id_semester' AND status='Tersedia' AND id_pertemuan!='$id_pertemuan'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function combobox_semester(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}
		
}
<?php
class M_semester extends CI_Model{
	
	function show_semester(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function tambah_semester($id_tahun_ajaran, $semester){

		$hasil=$this->db->query("INSERT INTO tb_semester (id_tahun_ajaran, semester, status) VALUES ('$id_tahun_ajaran', '$semester', 'Tersedia')");
		return $hasil;
	}

	function edit_semester($id_semester, $id_tahun_ajaran, $semester){
		$hasil=$this->db->query("UPDATE tb_semester SET id_tahun_ajaran='$id_tahun_ajaran', semester='$semester' WHERE id_semester='$id_semester';");
		return $hasil;
	}

	function hapus_tahun_ajaran($id_semester){
		$hasil=$this->db->query("UPDATE tb_semester SET status='Dihapus' WHERE id_semester='$id_semester';");
		return $hasil;
	}
	
	function check_ketersediaan($id_tahun_ajaran, $semester){
		$sql = "SELECT * FROM tb_semester WHERE id_tahun_ajaran = '$id_tahun_ajaran' AND  semester = '$semester' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_ketersediaan_edit($id_semester,$id_tahun_ajaran, $semester){
		$sql = "SELECT * FROM tb_semester WHERE id_tahun_ajaran = '$id_tahun_ajaran' AND semester = '$semester' AND status='Tersedia' AND id_semester!='$id_semester'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function combobox_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.status='Tersedia' ORDER BY tahun_ajaran DESC");
		return $hasil;
	}
		
}
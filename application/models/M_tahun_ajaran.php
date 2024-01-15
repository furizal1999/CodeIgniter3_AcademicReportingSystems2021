<?php
class M_tahun_ajaran extends CI_Model{
	
	function show_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran WHERE tb_tahun_ajaran.status='Tersedia' ORDER BY tahun_ajaran DESC");
		return $hasil;
	}

	function tambah_tahun_ajaran($tahun_ajaran){

		$hasil=$this->db->query("INSERT INTO tb_tahun_ajaran (tahun_ajaran, status) VALUES ('$tahun_ajaran', 'Tersedia')");
		return $hasil;
	}

	function edit_tahun_ajaran($id_tahun_ajaran, $tahun_ajaran){
		$hasil=$this->db->query("UPDATE tb_tahun_ajaran SET tahun_ajaran='$tahun_ajaran' WHERE id_tahun_ajaran='$id_tahun_ajaran';");
		return $hasil;
	}

	function hapus_tahun_ajaran($id_tahun_ajaran){
		$hasil=$this->db->query("UPDATE tb_tahun_ajaran SET status='Dihapus' WHERE id_tahun_ajaran='$id_tahun_ajaran';");
		return $hasil;
	}
	
	function check_ketersediaan($tahun_ajaran){
		$sql = "SELECT * FROM tb_tahun_ajaran WHERE tahun_ajaran = '$tahun_ajaran' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_ketersediaan_edit($id_tahun_ajaran, $tahun_ajaran){
		$sql = "SELECT * FROM tb_tahun_ajaran WHERE tahun_ajaran = '$tahun_ajaran' AND status='Tersedia' AND id_tahun_ajaran!='$id_tahun_ajaran'";
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
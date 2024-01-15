<?php
class M_ujian extends CI_Model{
	
	function show_pertemuan(){
		$hasil=$this->db->query("

			SELECT * FROM 

			tb_tahun_ajaran, 
			tb_semester, 
			tb_pertemuan, 
			tb_ujian, 
			tb_surat_keputusan 
			
			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_ujian.id_surat_keputusan = tb_surat_keputusan.id_surat AND
			tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND 

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND 
			tb_ujian.status = 'Tersedia' AND 
			tb_surat_keputusan.status ='Tersedia' 

			ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function tambah_ujian($id_surat_keputusan, $id_pertemuan, $nama_ujian, $range_mulai_ujian, $range_selesai_ujian){

		$hasil=$this->db->query("INSERT INTO tb_ujian (id_surat_keputusan, id_pertemuan, nama_ujian, range_mulai_ujian, range_selesai_ujian, file_tata_tertib, file_sk_pengawas, status) VALUES ($id_surat_keputusan, $id_pertemuan, '$nama_ujian', '$range_mulai_ujian', '$range_selesai_ujian', '', '', 'Tersedia')");
		return $hasil;
	}

	function edit_ujian($id_ujian, $id_surat_keputusan, $id_pertemuan, $nama_ujian, $range_mulai_ujian, $range_selesai_ujian){
		$hasil=$this->db->query("UPDATE tb_ujian SET id_surat_keputusan='$id_surat_keputusan', id_pertemuan='$id_pertemuan', nama_ujian='$nama_ujian', range_mulai_ujian='$range_mulai_ujian', range_selesai_ujian='$range_selesai_ujian' WHERE id_ujian='$id_ujian';");
		return $hasil;
	}

	function hapus_ujian($id_ujian){
		$hasil=$this->db->query("UPDATE tb_ujian SET status='Dihapus' WHERE id_ujian='$id_ujian';");
		return $hasil;
	}
	
	function check_ketersediaan($id_pertemuan, $nama_ujian){
		$sql = "SELECT * FROM tb_ujian WHERE id_pertemuan = '$id_pertemuan' AND  nama_ujian = '$nama_ujian' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_ketersediaan_edit($id_ujian, $id_pertemuan, $nama_ujian){
		$sql = "SELECT * FROM tb_ujian WHERE id_pertemuan = '$id_pertemuan' AND  nama_ujian = '$nama_ujian' AND  status='Tersedia' AND id_ujian!='$id_ujian'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function combobox_surat_keputusan(){
		$hasil=$this->db->query("SELECT * FROM tb_surat_keputusan WHERE status='Tersedia'");
		return $hasil;
	}

	function combobox_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}
		
}
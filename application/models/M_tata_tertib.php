<?php
class M_tata_tertib extends CI_Model{
	
	function show_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_ujian, tb_pertemuan, tb_surat_keputusan WHERE tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_pertemuan.id_pertemuan = tb_ujian.id_pertemuan AND tb_pertemuan.status = 'Tersedia' AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_ujian.status='Tersedia' AND tb_surat_keputusan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester = 'Ganjil', nama_ujian = 'Ujian Tengah Semester'");
		return $hasil;
	}

	function upload($id_ujian, $berkasbaru){
		$hasil=$this->db->query("UPDATE tb_ujian SET file_tata_tertib='$berkasbaru' WHERE id_ujian='$id_ujian';");
		return $hasil;
	}

	function hapus_berkas($id_ujian){
		$hasil=$this->db->query("UPDATE tb_ujian SET file_tata_tertib='' WHERE id_ujian='$id_ujian';");
		return $hasil;
	}
		
}
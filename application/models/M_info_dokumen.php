<?php
class M_info_dokumen extends CI_Model{
	
	function show_tahun_ajaran(){
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

			ORDER BY tahun_ajaran DESC, semester='Ganjil'
		");
		return $hasil;
	}

	function upload($id_tahun_ajaran, $berkasbaru){
		$hasil=$this->db->query("UPDATE tb_tahun_ajaran SET file_tata_tertib='$berkasbaru' WHERE id_tahun_ajaran='$id_tahun_ajaran';");
		return $hasil;
	}

	function hapus_berkas($id_tahun_ajaran){
		$hasil=$this->db->query("UPDATE tb_tahun_ajaran SET file_tata_tertib='' WHERE id_tahun_ajaran='$id_tahun_ajaran';");
		return $hasil;
	}
		
}
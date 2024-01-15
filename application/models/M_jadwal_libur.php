<?php
class M_jadwal_libur extends CI_Model{

	function show_jadwal_libur(){
		$hasil=$this->db->query("SELECT * FROM tb_jadwal_libur_pertemuan WHERE status='Tersedia' ORDER BY waktu_jadwal_libur_mulai DESC");
		return $hasil;
	}

	function tambah_jadwal_libur($waktu_libur_mulai, $waktu_libur_selesai, $agenda_libur){

		date_default_timezone_set('Asia/Jakarta');
        $waktu_input = date("Y-m-d H:i:s");
		$hasil=$this->db->query("INSERT INTO tb_jadwal_libur_pertemuan (waktu_input_jadwal_libur, waktu_jadwal_libur_mulai, waktu_jadwal_libur_selesai, agenda_libur, status) VALUES ('$waktu_input', '$waktu_libur_mulai', '$waktu_libur_selesai', '$agenda_libur', 'Tersedia') ");
		return $hasil;
	}

	
	function edit_jadwal_libur($id_jadwal_libur_pertemuan, $waktu_libur_mulai, $waktu_libur_selesai, $agenda_libur){
		$hasil=$this->db->query("UPDATE tb_jadwal_libur_pertemuan SET waktu_jadwal_libur_mulai='$waktu_libur_mulai', waktu_jadwal_libur_selesai='$waktu_libur_selesai', agenda_libur='$agenda_libur' WHERE id_jadwal_libur_pertemuan='$id_jadwal_libur_pertemuan'");
		return $hasil;
	}

	function hapus_jadwal_libur($id_jadwal_libur_pertemuan){
		$hasil=$this->db->query("UPDATE tb_jadwal_libur_pertemuan SET status='Dihapus' WHERE id_jadwal_libur_pertemuan='$id_jadwal_libur_pertemuan'");
		return $hasil;
	}
	
}
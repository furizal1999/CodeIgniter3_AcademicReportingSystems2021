<?php
class M_sk_pertemuan extends CI_Model{

	// function show_sk_pertemuan($id_pertemuan){
	// 	$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan LEFT JOIN tb_berkas_sk_pertemuan ON tb_berkas_sk_pertemuan.id_pertemuan = tb_pertemuan.id_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
	// 	return $hasil;
	// }

	function list_prodi($id_pertemuan){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC"); //PAKAI ORDER BY
      return $hasil;
  }

	function getFile($kode_prodi){
		$id_pertemuan = $_SESSION['id_pertemuan_search'];
		$hasil=$this->db->query("SELECT nama_file_berkas AS nfb from tb_berkas_sk_pertemuan WHERE status='Tersedia' AND kode_prodi='$kode_prodi' AND id_pertemuan='$id_pertemuan'")->row();
		if($hasil){
			return $hasil->nfb;
		}else{
			return '';
		}
	}

	function combobox_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function upload($kode_prodi, $berkasbaru){
		$id_pertemuan = $_SESSION['id_pertemuan_search'];
		$hasil=$this->db->query("INSERT INTO tb_berkas_sk_pertemuan (kode_prodi, id_pertemuan, nama_file_berkas, status) VALUES ('$kode_prodi', $id_pertemuan, '$berkasbaru', 'Tersedia')");
		return $hasil;
	}

	function hapus_berkas($kode_prodi){
		$id_pertemuan = $_SESSION['id_pertemuan_search'];
		$hasil=$this->db->query("UPDATE tb_berkas_sk_pertemuan SET status='Dihapus' WHERE kode_prodi='$kode_prodi' AND id_pertemuan='$id_pertemuan';");
		return $hasil;
	}

}

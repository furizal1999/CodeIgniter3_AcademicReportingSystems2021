<?php
class M_welcome extends CI_Model{

  //upm
  function jumlah_admin_upm(){
    $hasil=$this->db->query("SELECT * FROM tb_upm")->num_rows();
    return $hasil;
  }

  // function jumlah_prodi(){
  //   $hasil=$this->db->query("SELECT * FROM tb_prodi WHERE status='Tersedia'")->num_rows();
  //   return $hasil;
  // }

  // function jumlah_super_admin_prodi(){
  //   $hasil=$this->db->query("SELECT * FROM tb_prodi_attribut WHERE hak_akses ='Super'")->num_rows();
  //   return $hasil;
  // }

  //fakultas
  function jumlah_admin_fakultas(){
    $hasil=$this->db->query("SELECT * FROM tb_fakultas")->num_rows();
		return $hasil;
  }

  function jumlah_prodi(){
    $hasil=$this->db->query("SELECT * FROM tb_prodi WHERE status='Tersedia'")->num_rows();
		return $hasil;
  }

  function jumlah_super_admin_prodi(){
    $hasil=$this->db->query("SELECT * FROM tb_prodi_attribut WHERE hak_akses ='Super'")->num_rows();
		return $hasil;
  }

  //upm
  function jumlah_admin_tu(){
    $hasil=$this->db->query("SELECT * FROM tb_tu")->num_rows();
    return $hasil;
  }

  //prodi
  
  function jumlah_admin($kode_prodi){
    $hasil=$this->db->query("SELECT * FROM tb_prodi_attribut WHERE kode_prodi='$kode_prodi'")->num_rows();
		return $hasil;
  }
  
  function jumlah_dosen_terverifikasi($kode_prodi){
    $hasil=$this->db->query("SELECT * FROM tb_dosen WHERE kode_jurusan= '$kode_prodi' AND status ='Aktif'")->num_rows();
		return $hasil;
  }

  function jumlah_dosen_belum_terverifikasi($kode_prodi){
    $hasil=$this->db->query("SELECT * FROM tb_dosen WHERE kode_jurusan='$kode_prodi' AND status ='Non-aktif'")->num_rows();
		return $hasil;
  }
  
  function jumlah_ruang($kode_prodi){
    $hasil=$this->db->query("SELECT * FROM tb_ruang WHERE kode_jurusan='$kode_prodi'")->num_rows();
		return $hasil;
  }

  function jumlah_matkul($kode_prodi){
    $hasil=$this->db->query("SELECT * FROM tb_matkul WHERE kode_jurusan=$kode_prodi AND status='Tersedia'")->num_rows();
		return $hasil;
  }

  // function jumlah_ujian_terjadwal($kode_prodi){
  //   $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal and tb_jadwal_ujian.kode_jurusan=$kode_prodi AND concat(tanggal_ujian,' ',jam_selesai) BETWEEN concat('$sekarang') AND concat('4000-01-01 00:00:00')")->num_rows();
		// return $hasil;
  // }

  // function jumlah_ujian_belum_terjadwal($kode_prodi){
  //   $hasil=$this->db->query("SELECT sum(jumlah_kelas) AS ujian_belum_terjadwal FROM tb_jadwal_ujian WHERE kode_jurusan=$kode_prodi AND concat(tanggal_ujian,' ',jam_selesai) BETWEEN concat('$sekarang') AND concat('4000-01-01 00:00:00')")->row();
		// return $hasil;
  // }

  //dosen 
  function jumlah_jadwal_mengawas($npk){
    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");
    $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' and ((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) OR (tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk)) AND concat('$sekarang') <= concat(tanggal_ujian,' ',jam_selesai)  ORDER BY tanggal_ujian, jam_mulai ASC")->num_rows();
		return $hasil;
  }

  function jumlah_histori_mengawas($npk){
    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");
    $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' and ((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) OR (tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk)) AND concat('$sekarang') > concat(tanggal_ujian,' ',jam_selesai) ORDER BY tanggal_ujian, jam_mulai ASC")->num_rows();
		return $hasil;
  }

  function jumlah_terverifikasi($npk){
    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");
    $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' and (((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Terverifikasi')) OR ((tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk) AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Terverifikasi'))) AND concat('$sekarang') > concat(tanggal_ujian,' ',jam_selesai)")->num_rows();
		return $hasil;
  }

  function jumlah_ditolak($npk){
    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");
    $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' and (((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Permintaan verifikasi ditolak')) OR ((tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk) AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Permintaan verifikasi ditolak'))) AND concat('$sekarang') > concat(tanggal_ujian,' ',jam_selesai)")->num_rows();
		return $hasil;
  }

  function jumlah_belum_disubmit($npk){
    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");
    $hasil=$this->db->query("SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' and (((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) AND (tb_jadwal_ujian_lanjutan.jam_submit_pengawas1='00:00:00')) OR ((tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk) AND (tb_jadwal_ujian_lanjutan.jam_submit_pengawas2='00:00:00'))) AND concat('$sekarang') > concat(tanggal_ujian,' ',jam_selesai)")->num_rows();
		return $hasil;
  }

    
}
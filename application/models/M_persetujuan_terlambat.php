<?php
class M_persetujuan_terlambat extends CI_Model{
	

   //getAllData
  public function getAllData($sql){

    $hasil = $this->db->query($sql);
    return $hasil;
  }

  public function getFilteredData($sql){
    $hasil = $this->db->query($sql);
    return $hasil;
  }

  public function getFilteredDataOrderBy($sql){
    $hasil = $this->db->query($sql);
    return $hasil;
  }

  public function nama_pengawas($npk_pengawas){
    $query = $this->db->query("SELECT * from tb_dosen where npk=$npk_pengawas");
    if($row = $query->row()){
      return $row->nama_dosen;
    }else{
      return 'Tidak diketahui';
    }
  }


  function combobox_ujian(){
    $hasil=$this->db->query("
      SELECT * 
      FROM 
      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan, 
      tb_ujian, 
      tb_surat_keputusan 

      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND  
      tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
      tb_ujian.id_surat_keputusan = tb_surat_keputusan.id_surat AND

      tb_tahun_ajaran.status='Tersedia' AND
      tb_semester.status = 'Tersedia' AND
      tb_pertemuan.status='Tersedia' AND
      tb_ujian.status = 'Tersedia' AND
      tb_surat_keputusan.status = 'Tersedia'

      ORDER BY tahun_ajaran DESC, semester='Ganjil'");
    return $hasil;
  }
  

  function combobox_prodi(){
    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
    return $hasil;
  }



  // function show_permintaan_verifikasi($kode_jurusan, $id_tahun_ajaran){
  //   date_default_timezone_set('Asia/Jakarta');
  //   $sekarang = date("Y-m-d H:i:s");
		// $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_jadwal_ujian, tb_jadwal_ujian_lanjutan, tb_matkul WHERE tb_jadwal_ujian.id_jadwal =tb_jadwal_ujian_lanjutan.id_jadwal AND tb_tahun_ajaran.id_tahun_ajaran = tb_jadwal_ujian.id_tahun_ajaran AND tb_matkul.kode_mk = tb_jadwal_ujian.kode_matkul AND tb_tahun_ajaran.id_tahun_ajaran='$id_tahun_ajaran' AND tb_jadwal_ujian.kode_jurusan='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND  (((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00')) OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) ORDER BY (status_verifikasi_pengawas1='Minta Verifikasi' OR status_verifikasi_pengawas2='Minta Verifikasi') DESC, tanggal_ujian DESC, jam_mulai DESC");
		// return $hasil;
  // }
    
  function ambil_matkul($kode_mk){
		$query = $this->db->query("SELECT * from tb_matkul where kode_mk='$kode_mk'");
		return $row = $query->row();
  }

  function ambil_dosen1($npk){
		$query = $this->db->query("SELECT * from tb_dosen where npk='$npk'");
		return $row = $query->row();
	}
	function ambil_dosen2($npk){
		$query = $this->db->query("SELECT * from tb_dosen where npk='$npk'");
		return $row = $query->row();
  }
  
  function ambil_jumlah_mahasiswa($id_jadwal_lanjutan){
  $query = $this->db->query("SELECT * from tb_jadwal_ujian_lanjutan where id_jadwal_lanjutan='$id_jadwal_lanjutan' AND status='Tersedia'");
  return $row = $query->row();
  }
  


  function persetujuan1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas1='Disetujui' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function tolak_pengajuan_terlambat_pengawas1($id_jadwal_lanjutan, $alasan_penolakan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas1='Disetujui', alasan_penolakan_pengawas1='$alasan_penolakan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_persetujuan_pengawas1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas1='Minta Persetujuan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_tolak_pengajuan_terlambat_pengawas1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas1='Minta Persetujuan', alasan_penolakan_pengawas1='$alasan_penolakan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }




  function persetujuan2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas2='Disetujui' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function tolak_pengajuan_terlambat_pengawas2($id_jadwal_lanjutan, $alasan_penolakan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas2='Disetujui', alasan_penolakan_pengawas2='$alasan_penolakan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_persetujuan_pengawas2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas2='Minta Persetujuan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_tolak_pengajuan_terlambat_pengawas2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_pengajuan_terlambat_pengawas2='Minta Persetujuan', alasan_penolakan_pengawas2='$alasan_penolakan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }



}




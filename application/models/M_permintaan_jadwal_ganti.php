<?php
class M_permintaan_jadwal_ganti extends CI_Model{
	

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

  function combobox_pertemuan(){
    $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
    return $hasil;
  }

  function setujui_ganti_jadwal($id_request_pertemuan){
    $hasil = $this->db->query("UPDATE tb_request_pertemuan SET status_request_pertemuan ='Disetujui' WHERE id_request_pertemuan='$id_request_pertemuan'");
    return $hasil;
  }

   function tolak_jadwal_ganti($id_request_pertemuan, $alasan_penolakan){
    $hasil = $this->db->query("UPDATE tb_request_pertemuan SET status_request_pertemuan ='Ditolak', alasan_penolakan_request='$alasan_penolakan' WHERE id_request_pertemuan='$id_request_pertemuan'");
    return $hasil;
  }

  function batal_respon($id_request_pertemuan){
    $hasil = $this->db->query("UPDATE tb_request_pertemuan SET status_request_pertemuan ='Minta Persetujuan' WHERE id_request_pertemuan='$id_request_pertemuan'");
    return $hasil;
  }

  

  function getNamaDosen($npk){
    $query = $this->db->query("SELECT * FROM tb_dosen WHERE npk = '$npk'");
    if($query->num_rows()==1){
      $baris = $query->row();
      $nama_dosen = $baris->nama_dosen;
      return $nama_dosen;
    }else{
      return $npk;
    }
    
  }

  function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC"); //PAKAI ORDER BY
      return $hasil;
  }
}




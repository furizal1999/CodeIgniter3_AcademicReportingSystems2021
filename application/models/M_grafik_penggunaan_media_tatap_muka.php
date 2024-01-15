<?php
class M_grafik_penggunaan_media_tatap_muka extends CI_Model{
	
  function combobox_pertemuan(){
    $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
    return $hasil;
  }

  function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
      return $hasil;
  }


  function count_media($id_pertemuan, $kode_jurusan, $media){
    $query = $this->db->query("

      SELECT *

      FROM 
      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan,
      tb_jadwal_pengampu,
      tb_prodi,
      tb_matkul,
      tb_jadwal_kelas_pertemuan,
      tb_presensi_pertemuan

      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND 
      tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
      tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
      tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
      tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
      tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
      tb_presensi_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND
      tb_jadwal_pengampu.status='Tersedia' AND
      tb_prodi.status = 'Tersedia' AND
      tb_matkul.status = 'Tersedia' AND
      tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
      tb_presensi_pertemuan.status = 'Tersedia' AND
      tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
      tb_prodi.kode_prodi = '$kode_jurusan' AND
      LOCATE('{$media}', tb_presensi_pertemuan.media_pertemuan) > 0
      ")->num_rows();
    return $query;
  }

}






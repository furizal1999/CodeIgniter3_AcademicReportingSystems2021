<?php
class M_grafik_kontrak_rps_nilai extends CI_Model{
	
  function combobox_pertemuan(){
    $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
    return $hasil;
  }

  function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
      return $hasil;
  }


  function count_semua_kelas($id_pertemuan, $kode_jurusan){

    return $query = $this->db->query("

      SELECT *

      FROM 
      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan,
      tb_jadwal_pengampu,
      tb_prodi,
      tb_matkul,
      tb_jadwal_kelas_pertemuan

      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND 
      tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
      tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
      tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
      tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
      
      tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND
      tb_jadwal_pengampu.status='Tersedia' AND
      tb_prodi.status = 'Tersedia' AND
      tb_matkul.status = 'Tersedia' AND
      tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
      tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
      tb_prodi.kode_prodi = '$kode_jurusan' 
      ")->num_rows();
  }

  function query_from(){
    return $query_from = "
                FROM 
                tb_tahun_ajaran, 
                tb_semester, 
                tb_pertemuan,
                tb_jadwal_pengampu,
                tb_prodi,
                tb_matkul,
                tb_jadwal_kelas_pertemuan,
                tb_berkas_pertemuan
                ";
  }
  function query_where(){

    return $query_where = "
                  WHERE 
                  tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
                  tb_semester.id_semester = tb_pertemuan.id_semester AND 
                  tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
                  tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
                  tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
                  tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
                  tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
                  tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_berkas_pertemuan.id_jadwal_kelas_pertemuan AND

                  tb_tahun_ajaran.status='Tersedia' AND 
                  tb_semester.status = 'Tersedia' AND 
                  tb_pertemuan.status='Tersedia' AND
                  tb_jadwal_pengampu.status='Tersedia' AND
                  tb_prodi.status = 'Tersedia' AND
                  tb_matkul.status = 'Tersedia' AND
                  tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
                  tb_berkas_pertemuan.status = 'Tersedia' AND
                  
                ";
  }

 



  function count_submit_kontrak_rps($id_pertemuan, $kode_jurusan, $jenis_berkas){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      return $this->db->query("
        SELECT *

        $query_from
        $query_where

        tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
        tb_prodi.kode_prodi = '$kode_jurusan' AND
        tb_berkas_pertemuan.nama_berkas = '$jenis_berkas'
        ")->num_rows();
  }


  function count_submit_nilai($id_pertemuan, $kode_jurusan, $nama_ujian){
    return $hasil=$this->db->query("
      SELECT *

      FROM 
      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan,
      tb_jadwal_pengampu,
      tb_prodi,
      tb_matkul,
      tb_ujian,
      tb_surat_keputusan,
      tb_jadwal_ujian,
      tb_jadwal_kelas_pertemuan,
      tb_berkas_ujian_kelas

      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND 
      tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
      tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
      tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
      tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
      tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
      tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
      tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
      tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
      tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
      tb_berkas_ujian_kelas.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND
      tb_berkas_ujian_kelas.id_ujian = tb_ujian.id_ujian AND
      tb_berkas_ujian_kelas.nama_berkas = 'Nilai Hasil Ujian' AND

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND
      tb_jadwal_pengampu.status='Tersedia' AND
      tb_prodi.status = 'Tersedia' AND
      tb_matkul.status = 'Tersedia' AND
      tb_ujian.status = 'Tersedia' AND
      tb_surat_keputusan.status = 'Tersedia' AND
      tb_jadwal_ujian.status = 'Tersedia' AND
      tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
      tb_berkas_ujian_kelas.status = 'Tersedia' AND
      tb_ujian.nama_ujian = '$nama_ujian' AND
      tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
      tb_prodi.kode_prodi = '$kode_jurusan'
      
      ")->num_rows();
  }

}






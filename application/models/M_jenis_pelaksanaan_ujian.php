<?php
class M_jenis_pelaksanaan_ujian extends CI_Model{
  
    function show_rekapitulasi($id_ujian){
      
    $hasil=$this->db->query("
        SELECT 

        tb_jadwal_kelas_pertemuan.nama_kelas as kelas, 
        tb_surat_keputusan.ket_ujian as jenis_ujian, 
        tb_ujian.nama_ujian as nama_ujian, 
        tb_tahun_ajaran.tahun_ajaran as tahun_ajaran, 
        tb_semester.semester as semester, 
        tb_prodi.kode_prodi as kode_prodi, 
        tb_prodi.nama_prodi as prodi, 
        tb_dosen.npk as npk,  
        tb_dosen.nama_dosen as nama_dosen, 
        tb_matkul.nama_mk as mk,
        tb_jadwal_ujian_lanjutan.jenis_soal as jenis_soal, 
        tb_jadwal_ujian_lanjutan.media as media, 
        tb_jadwal_ujian_lanjutan.foto_bukti_pengawas1 as foto_bukti 


        FROM 
        tb_tahun_ajaran, 
        tb_semester, 
        tb_pertemuan,
        tb_jadwal_pengampu,
        tb_prodi,
        tb_matkul,
        tb_dosen,
        tb_ujian,
        tb_surat_keputusan,
        tb_jadwal_ujian,
        tb_jadwal_kelas_pertemuan,
        tb_jadwal_ujian_lanjutan

        WHERE 
        tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
        tb_semester.id_semester = tb_pertemuan.id_semester AND 
        tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
        tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
        tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
        tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
        tb_dosen.npk = tb_jadwal_ujian_lanjutan.npk_pengawas1 AND
        tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
        tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
        tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
        tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
        tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
        tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
        tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

        tb_tahun_ajaran.status='Tersedia' AND 
        tb_semester.status = 'Tersedia' AND 
        tb_pertemuan.status='Tersedia' AND
        tb_jadwal_pengampu.status='Tersedia' AND
        tb_prodi.status = 'Tersedia' AND
        tb_matkul.status = 'Tersedia' AND
        tb_dosen.status!='Dihapus' AND
        tb_ujian.status = 'Tersedia' AND
        tb_surat_keputusan.status = 'Tersedia' AND
        tb_jadwal_ujian.status = 'Tersedia' AND
        tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
        tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
        tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Terverifikasi' AND
        tb_ujian.id_ujian = '$id_ujian'


        UNION

        SELECT 

        tb_jadwal_kelas_pertemuan.nama_kelas as kelas, 
        tb_surat_keputusan.ket_ujian as jenis_ujian, 
        tb_ujian.nama_ujian as nama_ujian, 
        tb_tahun_ajaran.tahun_ajaran as tahun_ajaran, 
        tb_semester.semester as semester, 
        tb_prodi.kode_prodi as kode_prodi, 
        tb_prodi.nama_prodi as prodi, 
        tb_dosen.npk as npk,  
        tb_dosen.nama_dosen as nama_dosen, 
        tb_matkul.nama_mk as mk,
        tb_jadwal_ujian_lanjutan.jenis_soal as jenis_soal, 
        tb_jadwal_ujian_lanjutan.media as media, 
        tb_jadwal_ujian_lanjutan.foto_bukti_pengawas1 as foto_bukti 


        FROM 
        tb_tahun_ajaran, 
        tb_semester, 
        tb_pertemuan,
        tb_jadwal_pengampu,
        tb_prodi,
        tb_matkul,
        tb_dosen,
        tb_ujian,
        tb_surat_keputusan,
        tb_jadwal_ujian,
        tb_jadwal_kelas_pertemuan,
        tb_jadwal_ujian_lanjutan

        WHERE 
        tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
        tb_semester.id_semester = tb_pertemuan.id_semester AND 
        tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
        tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
        tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
        tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
        tb_dosen.npk = tb_jadwal_ujian_lanjutan.npk_pengawas2 AND
        tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
        tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
        tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
        tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
        tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
        tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
        tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

        tb_tahun_ajaran.status='Tersedia' AND 
        tb_semester.status = 'Tersedia' AND 
        tb_pertemuan.status='Tersedia' AND
        tb_jadwal_pengampu.status='Tersedia' AND
        tb_prodi.status = 'Tersedia' AND
        tb_matkul.status = 'Tersedia' AND
        tb_dosen.status!='Dihapus' AND
        tb_ujian.status = 'Tersedia' AND
        tb_surat_keputusan.status = 'Tersedia' AND
        tb_jadwal_ujian.status = 'Tersedia' AND
        tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
        tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
        tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Terverifikasi' AND
        tb_ujian.id_ujian = '$id_ujian'

        ORDER BY kode_prodi ASC, nama_dosen ASC, mk ASC, kelas ASC
    ");

    return $hasil;
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

    // function j_mk1($npk, $id_tahun_ajaran){
    //   $query=$this->db->query("SELECT COUNT(DISTINCT kode_matkul) count_mk from tb_tahun_ajaran, tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND tb_tahun_ajaran.id_tahun_ajaran = tb_jadwal_ujian.id_tahun_ajaran AND (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND tb_tahun_ajaran.id_tahun_ajaran ='$id_tahun_ajaran' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')");
    //   return $row = $query->row();
    // }
    
    // function j_kelas1($npk, $id_tahun_ajaran){
    //   $query=$this->db->query("SELECT COUNT(nama_kelas) count_kelas from tb_tahun_ajaran, tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND tb_tahun_ajaran.id_tahun_ajaran = tb_jadwal_ujian.id_tahun_ajaran AND (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND tb_tahun_ajaran.id_tahun_ajaran ='$id_tahun_ajaran' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')");
    //   return $row = $query->row();
    // }

    // function j_mhs1($npk, $id_tahun_ajaran){
    //   $query=$this->db->query("SELECT SUM(jumlah_mahasiswa_hadir) count_mhs from tb_tahun_ajaran, tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND tb_tahun_ajaran.id_tahun_ajaran = tb_jadwal_ujian.id_tahun_ajaran AND (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND tb_tahun_ajaran.id_tahun_ajaran ='$id_tahun_ajaran' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')");
    //   return $row = $query->row();
    // }

    // function ambil_tahun_dan_surat($id_tahun_ajaran){
    //   $query = $this->db->query("SELECT * from tb_tahun_ajaran, tb_surat_keputusan where tb_surat_keputusan.id_surat = tb_tahun_ajaran.id_surat_keputusan AND tb_tahun_ajaran.id_tahun_ajaran = '$id_tahun_ajaran'");
    //   return $row = $query->row();
    // }
  
  function ambil_ujian($id_ujian){
    $query = $this->db->query("
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

    ");
    return $row = $query->row();
  }
}
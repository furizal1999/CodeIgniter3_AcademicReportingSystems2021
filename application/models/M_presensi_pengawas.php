<?php
class M_presensi_pengawas extends CI_Model{

    function show_dosen($kode_jurusan){
    $hasil=$this->db->query("SELECT * FROM tb_dosen WHERE kode_jurusan=$kode_jurusan AND status='Aktif'");
    return $hasil;
    }

    function show_tanggal_ujian($kode_jurusan, $id_ujian){

      $hasil=$this->db->query("
            SELECT DISTINCT tb_jadwal_ujian.tanggal_ujian as tanggal 
            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_jadwal_pengampu,
            tb_prodi,
            tb_matkul,
            -- tb_dosen,
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
            -- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
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
            -- tb_dosen.status!='Dihapus' AND
            tb_ujian.status = 'Tersedia' AND
            tb_surat_keputusan.status = 'Tersedia' AND
            tb_jadwal_ujian.status = 'Tersedia' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian'

            ORDER BY tanggal ASC
      ");

      return $hasil;
    }


    function show_sesi_ujian($kode_jurusan, $id_ujian, $tanggal_ujian){

      $hasil=$this->db->query("
            SELECT DISTINCT tb_jadwal_ujian.jam_mulai as jam_mulai 
            
            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_jadwal_pengampu,
            tb_prodi,
            tb_matkul,
            -- tb_dosen,
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
            -- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
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
            -- tb_dosen.status!='Dihapus' AND
            tb_ujian.status = 'Tersedia' AND
            tb_surat_keputusan.status = 'Tersedia' AND
            tb_jadwal_ujian.status = 'Tersedia' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' AND

            tb_jadwal_ujian.tanggal_ujian='$tanggal_ujian' 

            ORDER BY jam_mulai ASC
      ");

      return $hasil;

    }
	
    function show_jadwal($kode_jurusan, $id_ujian){
		$hasil=$this->db->query("

            SELECT * 

            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_jadwal_pengampu,
            tb_prodi,
            tb_matkul,
            -- tb_dosen,
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
            -- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
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
            -- tb_dosen.status!='Dihapus' AND
            tb_ujian.status = 'Tersedia' AND
            tb_surat_keputusan.status = 'Tersedia' AND
            tb_jadwal_ujian.status = 'Tersedia' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' 

            ORDER BY tanggal_ujian, jam_mulai ASC
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

    function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
      return $hasil;
    }


    function ambil_kaprodi($kode_prodi){
      $query = $this->db->query("SELECT * from tb_prodi_attribut where kode_prodi='$kode_prodi' AND jabatan = 'Ketua Program Studi'");
      return $row = $query->row();
    }

    function ambil_wd1(){
      $query = $this->db->query("SELECT * from tb_fakultas where jabatan = 'Wakil Dekan I';");
      return $row = $query->row();
    }

    function ambil_dosen1($npk){
      $kode_jurusan= $_SESSION['kode_prodi'];
  		$query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan'");
  		return $row = $query->row();
	   }
	function ambil_dosen2($npk){
    $kode_jurusan= $_SESSION['kode_prodi'];
		$query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan'");
		return $row = $query->row();
  }
  
  function ambil_jumlah_mahasiswa($id_jadwal_lanjutan){
  $query = $this->db->query("SELECT * from tb_jadwal_ujian_lanjutan where id_jadwal_lanjutan='$id_jadwal_lanjutan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia'");
  return $row = $query->row();
  }

  function ambil_tahun_ajaran($id_tahun_ajaran){
    $query = $this->db->query("SELECT * from tb_tahun_ajaran where id_tahun_ajaran='$id_tahun_ajaran'");
    return $row = $query->row();
  }

  function ambil_prodi($kode_prodi){
    $query = $this->db->query("SELECT * from tb_prodi where kode_prodi='$kode_prodi'");
    return $row = $query->row();
  }

  function ambil_dosen_pengampu($kode_jurusan, $npk){
    $query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan'");
    return $row = $query->row();
  }

  function ambil_ttd($kode_jurusan, $id_ujian, $tanggal_ujian, $jam_mulai, $npk){
    $query = $this->db->query("
        SELECT * 
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
            LOCATE(tb_dosen.npk, tb_jadwal_pengampu.dosen_pengampu) > 0 AND
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
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian.tanggal_ujian='$tanggal_ujian' AND 
            tb_jadwal_ujian.jam_mulai='$jam_mulai' AND
            tb_dosen.npk='$npk' AND 

        ((tb_dosen.npk = tb_jadwal_ujian_lanjutan.npk_pengawas1 AND tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 ='Terverifikasi') OR (tb_dosen.npk = tb_jadwal_ujian_lanjutan.npk_pengawas2 AND tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 ='Terverifikasi'))
        
    ");

    return $row = $query->row();
  }

}
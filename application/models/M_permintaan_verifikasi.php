<?php
class M_permintaan_verifikasi extends CI_Model{
	
  function query_from(){
    return $query_from = "
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
                  tb_jadwal_ujian_lanjutan
                ";
  }
  function query_where(){

    date_default_timezone_set('Asia/Jakarta');
    $sekarang = date("Y-m-d H:i:s");

    return $query_where = "
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
                  tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
                  tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

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
                  tb_jadwal_ujian_lanjutan.status ='Tersedia' AND

                  
                ";
  }

  // (((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00')) OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND
   
  function query_order(){
    return $query_order = "
                  ORDER BY (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Minta Verifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Minta Verifikasi') DESC, tb_jadwal_ujian.tanggal_ujian DESC, tb_jadwal_ujian.jam_mulai DESC
                ";
  }


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

  function show_permintaan_verifikasi($kode_jurusan, $id_ujian){
    $query_from = $this->query_from();
    $query_where = $this->query_where();
    $query_order = $this->query_order();

    $hasil=$this->db->query("
        SELECT *
        $query_from
        $query_where

        tb_prodi.kode_prodi = '$kode_jurusan' AND
        tb_ujian.id_ujian = '$id_ujian'

        $query_order
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
  
  function verifikasi1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas1='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function verifikasi2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas2='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function tolak_pengawas1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas1='Permintaan verifikasi ditolak' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function tolak_pengawas2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas2='Permintaan verifikasi ditolak' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_verifikasi_pengawas1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas1='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_verifikasi_pengawas2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas2='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_tolak_pengawas1($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas1='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function batal_tolak_pengawas2($id_jadwal_lanjutan){
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status_verifikasi_pengawas2='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function edit_pengawas1_nophoto($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan){
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_absen = date('Y-m-d');
    $tanggal_submit = date('Y-m-d');
    $jam_absen = date('H:i:s');
    $jam_submit = date('H:i:s');

    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET tanggal_absen_pengawas1='$tanggal_absen', tanggal_submit_pengawas1='$tanggal_submit', jam_absen_pengawas1='$jam_absen', jam_submit_pengawas1='$jam_submit', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_peserta_hadir', ket_pelaksanaan='$ket_pelaksanaan', status_verifikasi_pengawas1='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function edit_pengawas1($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan, $fotobaru){
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_absen = date('Y-m-d');
    $tanggal_submit = date('Y-m-d');
    $jam_absen = date('H:i:s');
    $jam_submit = date('H:i:s');
    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET tanggal_absen_pengawas1='$tanggal_absen', tanggal_submit_pengawas1='$tanggal_submit', jam_absen_pengawas1='$jam_absen', jam_submit_pengawas1='$jam_submit', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_peserta_hadir', ket_pelaksanaan='$ket_pelaksanaan', foto_bukti_pengawas1='$fotobaru', status_verifikasi_pengawas1='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function edit_pengawas2_nophoto($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan){
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_absen = date('Y-m-d');
    $tanggal_submit = date('Y-m-d');
    $jam_absen = date('H:i:s');
    $jam_submit = date('H:i:s');

    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET tanggal_absen_pengawas2='$tanggal_absen', tanggal_submit_pengawas2='$tanggal_submit', jam_absen_pengawas2='$jam_absen', jam_submit_pengawas2='$jam_submit', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_peserta_hadir', ket_pelaksanaan='$ket_pelaksanaan', status_verifikasi_pengawas2='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function edit_pengawas2($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_peserta_hadir, $ket_pelaksanaan, $fotobaru){
    date_default_timezone_set('Asia/Jakarta');
    $tanggal_absen = date('Y-m-d');
    $tanggal_submit = date('Y-m-d');
    $jam_absen = date('H:i:s');
    $jam_submit = date('H:i:s');

    $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET tanggal_absen_pengawas2='$tanggal_absen', tanggal_submit_pengawas2='$tanggal_submit', jam_absen_pengawas2='$jam_absen', jam_submit_pengawas2='$jam_submit', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_peserta_hadir', ket_pelaksanaan='$ket_pelaksanaan', foto_bukti_pengawas2='$fotobaru', status_verifikasi_pengawas2='Terverifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    return $hasil;
  }

  function combobox_prodi(){
    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
    return $hasil;
  }


  function count_total_semua($kode_jurusan, $id_ujian){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $nilai1 = 0;
      $nilai2 = 0;

      $hasil1=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total1 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          tb_jadwal_ujian_lanjutan.npk_pengawas1!='' 
      ")->row();

      $hasil2=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total2 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          tb_jadwal_ujian_lanjutan.npk_pengawas2!='' 
      ")->row();

      if($hasil1){
        $nilai1 = $hasil1->total1;
      }

      if($hasil2){
        $nilai2 = $hasil2->total2;
      }

      return $nilai1 + $nilai2;
  }

  function count_total_ujian($kode_jurusan, $id_ujian){
      date_default_timezone_set('Asia/Jakarta');
      $sekarang = date("Y-m-d H:i:s");
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $nilai1 = 0;
      $nilai2 = 0;

      $hasil1=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total1 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas1!='' 
      ")->row();

      $hasil2=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total2 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00') OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas2!='' 
      ")->row();

      if($hasil1){
        $nilai1 = $hasil1->total1;
      }

      if($hasil2){
        $nilai2 = $hasil2->total2;
      }

      return $nilai1 + $nilai2;
  }


  function count_total_sudah_submit($kode_jurusan, $id_ujian){
      date_default_timezone_set('Asia/Jakarta');
      $sekarang = date("Y-m-d H:i:s");
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $nilai1 = 0;
      $nilai2 = 0;

      $hasil1=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total1 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas1 !='00:00:00') AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas1!='' 
      ")->row();

      $hasil2=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total2 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas2 !='00:00:00') AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas2!='' 
      ")->row();

      if($hasil1){
        $nilai1 = $hasil1->total1;
      }

      if($hasil2){
        $nilai2 = $hasil2->total2;
      }

      return $nilai1 + $nilai2;
  }

  function count_total_belum_submit($kode_jurusan, $id_ujian){
      date_default_timezone_set('Asia/Jakarta');
      $sekarang = date("Y-m-d H:i:s");
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $nilai1 = 0;
      $nilai2 = 0;

      $hasil1=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total1 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas1 ='00:00:00') AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas1!=''  
      ")->row();

      $hasil2=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total2 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas2 ='00:00:00') AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas2!=''  
      ")->row();

      if($hasil1){
        $nilai1 = $hasil1->total1;
      }

      if($hasil2){
        $nilai2 = $hasil2->total2;
      }

      return $nilai1 + $nilai2;
  }


  function count_total_terverifikasi($kode_jurusan, $id_ujian){
      date_default_timezone_set('Asia/Jakarta');
      $sekarang = date("Y-m-d H:i:s");
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $nilai1 = 0;
      $nilai2 = 0;

      $hasil1=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total1 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas1 !='00:00:00') AND status_verifikasi_pengawas1='Terverifikasi' AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas1!=''  
      ")->row();

      $hasil2=$this->db->query("
          SELECT count(id_jadwal_lanjutan) as total2 
          $query_from
          $query_where

          tb_prodi.kode_prodi = '$kode_jurusan' AND
          tb_ujian.id_ujian = '$id_ujian' AND

          ((jam_submit_pengawas2 !='00:00:00') AND status_verifikasi_pengawas2='Terverifikasi' AND (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) AND npk_pengawas2!=''  
      ")->row();

      if($hasil1){
        $nilai1 = $hasil1->total1;
      }

      if($hasil2){
        $nilai2 = $hasil2->total2;
      }

      return $nilai1 + $nilai2;
  }


  // function count_total_minta_verifikasi($kode_jurusan, $id_ujian){
  //   date_default_timezone_set('Asia/Jakarta');
  //   $sekarang = date("Y-m-d H:i:s");
  //   $query_from = $this->query_from();
  //   $query_where = $this->query_where();

  //   $hasil=$this->db->query("
  //     SELECT count(id_jadwal_lanjutan) as total_semua 
  //     $query_from
  //     $query_where
  //     tb_prodi.kode_prodi = '$kode_jurusan' AND
  //     tb_ujian.id_ujian = '$id_ujian' AND
      
  //    (((status_verifikasi_pengawas1 ='Minta Verifikasi' AND jam_submit_pengawas1 !='00:00:00') OR (status_verifikasi_pengawas2 ='Minta Verifikasi' AND jam_submit_pengawas2 !='00:00:00')) OR (concat(tanggal_ujian,' ',jam_mulai) <= concat('$sekarang'))) 
  //    ORDER BY (status_verifikasi_pengawas1='Minta Verifikasi' OR status_verifikasi_pengawas2='Minta Verifikasi') DESC, tanggal_ujian DESC, jam_mulai DESC");
  //   return $row = $hasil->row();
  // }
  function generateRandomId(){
    $seed = str_split('abcdefghijklmnopqrstuvwxyz0123456789'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
                 .'0123456789abcdefghijklmnopqrstuvwxyz'); // and any other characters
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $rand = '';
    foreach (array_rand($seed, 100) as $k) $rand .= $seed[$k];
    $rand;

    while($this->db->query("SELECT * FROM tb_ttd_digital WHERE id_random='$rand'")->num_rows()>0){
      $seed = str_split('abcdefghijklmnopqrstuvwxyz0123456789'
             .'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
             .'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'
             .'0123456789abcdefghijklmnopqrstuvwxyz'); // and any other characters
      shuffle($seed); // probably optional since array_is randomized; this may be redundant
      $rand = '';
      foreach (array_rand($seed, 100) as $k) $rand .= $seed[$k];
      $rand;
    }

    return $rand;
  }


  function insert_ttd_dekan($id_jadwal_lanjutan, $tahun_ajaran, $semester, $nama_mk, $nama_kelas){

    date_default_timezone_set('Asia/Jakarta');
    $waktu_input = date("Y-m-d H:i:s");

    $topik_relasi = 'Ujian Lanjutan (Verifikasi Berita Acara Oleh Dekan Fakultas Teknik)';
    $nama_penanda_tangan = $_SESSION['nama'];
    $jabatan_penanda_tangan = 'Dekan Fakultas Teknik';
    $perihal = 'Verifikasi berita acara Pengawas ujian matakuliah '.$nama_mk.' Kelas '.$nama_kelas.' pada '.$nama_ujian.' '.$semester.' Tahun Ajaran '.$tahun_ajaran.'.';

    $rand = $this->generateRandomId();

    $hasil =$this->db->query("
      INSERT INTO 
      tb_ttd_digital (id_relasi, topik_relasi, id_random, waktu_input_ttd, nama_penanda_tangan, jabatan_penanda_tangan, perihal, status_validasi, status) 
      VALUES (
        $id_jadwal_lanjutan, 
        '$topik_relasi', 
        '$rand', 
        '$waktu_input', 
        '$nama_penanda_tangan', 
        '$jabatan_penanda_tangan', 
        '$perihal', 
        'Tervalidasi', 
        'Tersedia'
      )");

        return $hasil;

  }

  function cekTtdDekan($id_jadwal_lanjutan){
    $topik_relasi = 'Ujian Lanjutan (Verifikasi Berita Acara Oleh Dekan Fakultas Teknik)';
    $hasil =$this->db->query("SELECT * FROM tb_ttd_digital WHERE id_relasi='$id_jadwal_lanjutan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'")->num_rows();

      return $hasil;
  }
}






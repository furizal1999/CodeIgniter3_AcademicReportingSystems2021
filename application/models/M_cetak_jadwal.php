<?php
class M_cetak_jadwal extends CI_Model{
	
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

            ORDER BY tb_jadwal_ujian.tanggal_ujian, tb_jadwal_ujian.jam_mulai, tb_jadwal_ujian.jam_selesai, tb_matkul.kode_mk ASC

        ");
		return $hasil;
    }

    function cekJumlahPerTanggal($kode_jurusan, $tanggal_ujian, $id_ujian){
    $hasil=$this->db->query("

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
            tb_jadwal_ujian_lanjutan

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
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian'
            ORDER BY tb_jadwal_ujian.tanggal_ujian, tb_jadwal_ujian.jam_mulai, tb_jadwal_ujian.jam_selesai, tb_matkul.kode_mk ASC

        ");
    return $hasil->num_rows();
    }

    function cekJumlahPerJamTanggal($kode_jurusan, $tanggal_ujian, $jam_mulai, $jam_selesai, $id_ujian){
    $hasil=$this->db->query("

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
            tb_jadwal_ujian_lanjutan

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
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            tb_jadwal_ujian.jam_mulai = '$jam_mulai' AND
            tb_jadwal_ujian.jam_selesai = '$jam_selesai'

            ORDER BY tb_jadwal_ujian.tanggal_ujian, tb_jadwal_ujian.jam_mulai, tb_jadwal_ujian.jam_selesai, tb_matkul.kode_mk ASC

        ");
    return $hasil->num_rows();
    }


    function cekJumlahPerJamTanggalMK($kode_jurusan, $tanggal_ujian, $jam_mulai, $jam_selesai, $kode_mk, $id_ujian){
    $hasil=$this->db->query("

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
            tb_jadwal_ujian_lanjutan

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
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            tb_jadwal_ujian.jam_mulai = '$jam_mulai' AND
            tb_jadwal_ujian.jam_selesai = '$jam_selesai' AND
            tb_matkul.kode_mk = '$kode_mk'

            ORDER BY tb_jadwal_ujian.tanggal_ujian, tb_jadwal_ujian.jam_mulai, tb_jadwal_ujian.jam_selesai, tb_matkul.kode_mk ASC

        ");
    return $hasil->num_rows();
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

  function ambil_ujian($id_ujian){
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
      tb_surat_keputusan.status = 'Tersedia' AND
      tb_ujian.id_ujian = '$id_ujian'

    ");
    return $hasil->row();
  }

    function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
      return $hasil;
    }


    function ambil_kaprodi($kode_prodi){
      $query = $this->db->query("SELECT * from tb_prodi_attribut where kode_prodi='$kode_prodi' AND jabatan = 'Ketua Program Studi'")->row();
      if($query){
        return $query->nama_lengkap;
      }else{
        return '........................';
      }
    }

    function ambil_wd1(){
      $query = $this->db->query("SELECT * from tb_fakultas where jabatan = 'Wakil Dekan I';")->row();
      if($query){
        return $query->nama;
      }else{
        return '........................';
      }
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

  function ambil_nama_prodi($kode_prodi){
    $query = $this->db->query("SELECT * from tb_prodi where kode_prodi='$kode_prodi'")->row();
    if($query){
      return $query->nama_prodi;
    }else{
      return '........................';
    }
  }

  function ambil_dosen_pengampu($kode_jurusan, $npk){
    $query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan'");
    return $row = $query->row();
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

  function getFormatTanggalIndo($tanggal){
    if(substr($tanggal, 5,2)=='01'){
        $tanggal = substr($tanggal, 8).' Januari '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='02'){
        $tanggal = substr($tanggal, 8).' Februari '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='03'){
        $tanggal = substr($tanggal, 8).' Maret '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='04'){
        $tanggal = substr($tanggal, 8).' April '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='05'){
        $tanggal = substr($tanggal, 8).' Mei '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='06'){
        $tanggal = substr($tanggal, 8).' Juni '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='07'){
        $tanggal = substr($tanggal, 8).' Juli '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='08'){
        $tanggal = substr($tanggal, 8).' Agustus '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='09'){
        $tanggal = substr($tanggal, 8).' September '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='10'){
        $tanggal = substr($tanggal, 8).' Oktober '.substr($tanggal,0,4);
    }
    else if(substr($tanggal, 5,2)=='11'){
        $tanggal = substr($tanggal, 8).' November '.substr($tanggal,0,4);
    }
    else{
        $tanggal = substr($tanggal, 8).' Desember '.substr($tanggal,0,4);
    }
    return $tanggal;
  }

}
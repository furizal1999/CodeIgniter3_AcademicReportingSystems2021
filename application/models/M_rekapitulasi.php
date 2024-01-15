<?php
class M_rekapitulasi extends CI_Model{
	
    function show_rekapitulasi($id_ujian){
      
    $hasil=$this->db->query("
      SELECT
            tb_prodi.kode_prodi as kode_prodi, 
            
            tb_dosen.npk as npk, 
            tb_dosen.nama_dosen as nama_dosen, 
            tb_matkul.kode_mk as kode_mk, 
            tb_matkul.nama_mk as mk, 
            tb_prodi.nama_prodi as prodi, 
            tb_jadwal_kelas_pertemuan.nama_kelas as kelas, 
            tb_jadwal_pengampu.dosen_pengampu as dosen_pengampu,
            tb_jadwal_ujian_lanjutan.jumlah_mhs_terjadwal_ujian as tot_jumlah, 
            tb_jadwal_ujian_lanjutan.jumlah_mahasiswa_hadir as jum_hadir 

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
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND
            tb_jadwal_ujian_lanjutan.npk_pengawas1 = tb_dosen.npk AND 

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
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Terverifikasi' 

      UNION 

      SELECT
            tb_prodi.kode_prodi as kode_prodi, 
            tb_dosen.npk as npk, 
            tb_dosen.nama_dosen as nama_dosen, 
            tb_matkul.kode_mk as kode_mk, 
            tb_matkul.nama_mk as mk, 
            tb_prodi.nama_prodi as prodi, 
            tb_jadwal_kelas_pertemuan.nama_kelas as kelas, 
            tb_jadwal_pengampu.dosen_pengampu as dosen_pengampu,
            tb_jadwal_ujian_lanjutan.jumlah_mhs_terjadwal_ujian as tot_jumlah, 
            tb_jadwal_ujian_lanjutan.jumlah_mahasiswa_hadir as jum_hadir 

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
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND
            tb_jadwal_ujian_lanjutan.npk_pengawas2 = tb_dosen.npk AND 

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
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Terverifikasi' 

        ORDER BY kode_prodi ASC, npk ASC, mk ASC, kelas ASC

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

   







    function query_from(){
      return "
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
      return "
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

    function j_mhs1($npk, $id_ujian){
      $query1=$this->db->query("
        SELECT 
            SUM(jumlah_mahasiswa_hadir) count_mhs 

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
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND
            tb_jadwal_ujian_lanjutan.npk_pengawas1 = tb_dosen.npk AND 

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
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' AND
            tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1='Terverifikasi' 

      
            ")->row();

            $query2=$this->db->query("
      SELECT
      SUM(jumlah_mahasiswa_hadir) count_mhs 
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
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND
            tb_jadwal_ujian_lanjutan.npk_pengawas2 = tb_dosen.npk AND 

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
            tb_ujian.id_ujian = '$id_ujian' AND
            tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk' AND
            tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2='Terverifikasi'
            
            ")->row();

            if($query1){
              $count_mhs1 = $query1->count_mhs;
            }
            else{
              $count_mhs1 = 0;
            }

            if($query2){
              $count_mhs2 = $query2->count_mhs;
            }
            else{
                $count_mhs2 = 0;
            }


            
      return ($count_mhs1+$count_mhs2);
    }

    function mhs_per_mk($npk, $id_ujian, $kode_mk){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $query=$this->db->query("
        SELECT 
            SUM(jumlah_mahasiswa_hadir) count_mhs_per_mk 
            
        $query_from 
        $query_where 
            tb_matkul.kode_mk = '$kode_mk' AND
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND
            tb_ujian.id_ujian = '$id_ujian' AND
            (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')
      ");
      return $row = $query->row();
    }

    function j_mk1($npk, $id_ujian){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $query=$this->db->query("
        SELECT 
            COUNT(DISTINCT kode_matkul) count_mk
            
        $query_from 
        $query_where 
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND
            tb_ujian.id_ujian = '$id_ujian' AND
            (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')

      ");
      return $row = $query->row();
    }

    function j_kelas_per_mk($npk, $id_ujian, $kode_mk){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $query=$this->db->query("
        SELECT 
            COUNT(nama_kelas) count_kelas_per_mk
            
        $query_from 
        $query_where 
        tb_matkul.kode_mk = '$kode_mk' AND
        (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND
        tb_ujian.id_ujian = '$id_ujian' AND
        (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')   
      ");
      return $row = $query->row();
    }


    function j_kelas1($npk, $id_ujian){
      $query_from = $this->query_from();
      $query_where = $this->query_where();
      $query=$this->db->query("
        SELECT 
            COUNT(nama_kelas) count_kelas
            
        $query_from 
        $query_where 
        (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk') AND
        tb_ujian.id_ujian = '$id_ujian' AND
        (tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas1 = 'Terverifikasi' OR tb_jadwal_ujian_lanjutan.status_verifikasi_pengawas2 = 'Terverifikasi')

        
      ");
      return $row = $query->row();
    }
    

    function ambil_tahun_dan_surat($id_ujian){
      $query = $this->db->query("
        SELECT * FROM 

      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan, 
      tb_ujian, 
      tb_surat_keputusan 
      
      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND 
      tb_ujian.id_surat_keputusan = tb_surat_keputusan.id_surat AND
      tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND 

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND 
      tb_ujian.status = 'Tersedia' AND 
      tb_surat_keputusan.status ='Tersedia' AND
      tb_ujian.id_ujian = '$id_ujian'

      ");
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
  
  // function ambil_jumlah_mahasiswa($id_jadwal_lanjutan){
  // $query = $this->db->query("SELECT * from tb_jadwal_ujian_lanjutan where id_jadwal_lanjutan='$id_jadwal_lanjutan'");
  // return $row = $query->row();
  // }
}
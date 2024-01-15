<?php
class M_grafik_jumlah_pertemuan_tatap_muka extends CI_Model{
	
  function combobox_pertemuan(){
    $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
    return $hasil;
  }

  function combobox_prodi(){
      $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
      return $hasil;
  }


  function data_dosen($id_pertemuan, $kode_jurusan){
    $query = $this->db->query("

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

      ORDER BY tb_matkul.semester ASC, tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
      ");
    return $query;
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

	function jumlahTatapMukaPerkelas($id_jadwal_kelas_pertemuan){
		$query = $this->db->query("
									SELECT max(tb_presensi_pertemuan.pertemuan_ke) AS maximal FROM tb_jadwal_kelas_pertemuan, tb_presensi_pertemuan 
									WHERE 
									tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_presensi_pertemuan.id_jadwal_kelas_pertemuan AND
									tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = '$id_jadwal_kelas_pertemuan' AND
									tb_jadwal_kelas_pertemuan.status='Tersedia' AND
									tb_presensi_pertemuan.status = 'Tersedia'
									")->row();

		if($query){
			$hasil = $query->maximal;
			if($query->maximal==null){
				$hasil = 0;
			}
		}else{
			$hasil = 0;
		}
		return $hasil;
		// return 4;
	}


	function data_dosen_pengampu_semester($id_pertemuan, $kode_jurusan){
    $query = $this->db->query("

      SELECT  DISTINCT tb_dosen.npk, tb_dosen.nama_dosen

      FROM 
      tb_tahun_ajaran, 
      tb_semester, 
      tb_pertemuan,
      tb_jadwal_pengampu,
      tb_prodi,
      tb_matkul,
      tb_dosen

      WHERE 
      tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
      tb_semester.id_semester = tb_pertemuan.id_semester AND 
      tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
      tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
      tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
      tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
      LOCATE(tb_dosen.npk, tb_jadwal_pengampu.dosen_pengampu) > 0 AND

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND
      tb_jadwal_pengampu.status='Tersedia' AND
      tb_prodi.status = 'Tersedia' AND
      tb_matkul.status = 'Tersedia' AND
      tb_dosen.status!='Dihapus' AND
      tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
      tb_prodi.kode_prodi = '$kode_jurusan'
      

      ORDER BY tb_dosen.npk ASC, tb_matkul.nama_mk ASC
      ");
    return $query;
  }

  function data_matkul_perdosen($id_pertemuan, $kode_jurusan, $npk){
    $query = $this->db->query("

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
      LOCATE('{$npk}', tb_jadwal_pengampu.dosen_pengampu) > 0 AND

      tb_tahun_ajaran.status='Tersedia' AND 
      tb_semester.status = 'Tersedia' AND 
      tb_pertemuan.status='Tersedia' AND
      tb_jadwal_pengampu.status='Tersedia' AND
      tb_prodi.status = 'Tersedia' AND
      tb_matkul.status = 'Tersedia' AND
      tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
      tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
      tb_prodi.kode_prodi = '$kode_jurusan'

      ORDER BY tb_matkul.semester ASC, tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
      ");
    return $query;
  }

}






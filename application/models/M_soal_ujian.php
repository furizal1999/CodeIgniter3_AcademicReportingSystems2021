<?php
class M_soal_ujian extends CI_Model{
	
	function show_tahun_ajaran($id_ujian, $kode_jurusan, $npk){
		$hasil=$this->db->query("

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
            tb_berkas_ujian_kelas

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			LOCATE('{$npk}', tb_jadwal_pengampu.dosen_pengampu) > 0 AND
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_berkas_ujian_kelas.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND
            tb_berkas_ujian_kelas.id_ujian = tb_ujian.id_ujian AND
            tb_berkas_ujian_kelas.nama_berkas = 'Soal Ujian' AND

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
            tb_berkas_ujian_kelas.status = 'Tersedia' AND

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_dosen.npk ='$npk'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC

            ");
		return $hasil;
	}



	function show_soal_ujian($id_ujian, $kode_jurusan){
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
            tb_berkas_ujian_kelas.nama_berkas = 'Soal Ujian' AND

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

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
			
			");
		return $hasil;
	}

	function combobox_kelas_diampu($id_ujian, $kode_jurusan, $npk){
		$hasil=$this->db->query("
			
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
            tb_jadwal_kelas_pertemuan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			LOCATE('{$npk}', tb_jadwal_pengampu.dosen_pengampu) > 0 AND
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

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

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_dosen.npk ='$npk'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
		");
		return $hasil;
	}

	function cekKetersediaanfileBerkasSoalUjian($id_ujian, $id_jadwal_kelas_pertemuan){
	    $hasil=$this->db->query("SELECT * from tb_berkas_ujian_kelas WHERE nama_berkas='Soal Ujian' AND id_ujian='$id_ujian' AND id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND status='Tersedia'");
	    if($hasil->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	
	}

	function upload($id_ujian,$id_jadwal_kelas_pertemuan, $berkasbaru){
		date_default_timezone_set('Asia/Jakarta');
        $sekarang = date("Y-m-d H:i:s");
		$hasil=$this->db->query("INSERT INTO tb_berkas_ujian_kelas (id_jadwal_kelas_pertemuan, id_ujian, nama_berkas, nama_file_berkas, waktu_input_berkas, nama_file_berkas_valid, waktu_input_berkas_valid, status) VALUES ($id_jadwal_kelas_pertemuan, $id_ujian, 'Soal Ujian', '$berkasbaru', '$sekarang','','0000-00-00 00:00:00', 'Tersedia')");
		return $hasil;
	}

	function upload_prodi($id_berkas_ujian_kelas, $berkasbaru){
		date_default_timezone_set('Asia/Jakarta');
        $sekarang = date("Y-m-d H:i:s");
		$hasil=$this->db->query("UPDATE tb_berkas_ujian_kelas SET nama_file_berkas_valid='$berkasbaru', waktu_input_berkas_valid='$sekarang' WHERE id_berkas_ujian_kelas='$id_berkas_ujian_kelas' AND nama_berkas='Soal Ujian';");
		return $hasil;
	}

	function hapus_berkas($id_berkas_ujian_kelas){
		$hasil=$this->db->query("UPDATE tb_berkas_ujian_kelas SET status='Dihapus' WHERE id_berkas_ujian_kelas='$id_berkas_ujian_kelas' AND nama_berkas='Soal Ujian';");
		return $hasil;
	}

	function hapus_berkas_prodi($id_berkas_ujian_kelas){
		$hasil=$this->db->query("UPDATE tb_berkas_ujian_kelas SET nama_file_berkas_valid='', waktu_input_berkas_valid='0000-00-00 00:00:00' WHERE id_berkas_ujian_kelas='$id_berkas_ujian_kelas' AND nama_berkas='Soal Ujian';");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
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
		
}
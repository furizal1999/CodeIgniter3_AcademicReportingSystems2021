<?php
class M_kontrak_kuliah extends CI_Model{
	
	function show_berkas_pertemuan($id_pertemuan, $kode_jurusan, $npk){
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
			tb_berkas_pertemuan

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
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			
			tb_prodi.kode_prodi = '$kode_jurusan' AND
			tb_berkas_pertemuan.nama_berkas = 'Kontrak Kuliah' AND
			LOCATE('{$npk}', tb_jadwal_pengampu.dosen_pengampu) > 0

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC

			");
		return $query;
	}

	function upload($id_jadwal_kelas_pertemuan, $berkasbaru){

		date_default_timezone_set('Asia/Jakarta');
        $waktu_input = date("Y-m-d H:i:s");
		$hasil=$this->db->query("INSERT INTO tb_berkas_pertemuan (id_jadwal_kelas_pertemuan, nama_berkas, nama_file_berkas, waktu_upload_berkas_pertemuan, status) VALUES ($id_jadwal_kelas_pertemuan, 'Kontrak Kuliah', '$berkasbaru', '$waktu_input', 'Tersedia')");
		return $hasil;
	}

	function hapus_berkas($id_berkas_pertemuan){
		$hasil=$this->db->query("DELETE FROM tb_berkas_pertemuan WHERE id_berkas_pertemuan='$id_berkas_pertemuan'");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function combobox_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function combobox_kelas_matkul($id_pertemuan, $kode_jurusan, $npk){
		$hasil=$this->db->query("SELECT *

			FROM 
			tb_tahun_ajaran, 
			tb_semester, 
			tb_pertemuan,
			tb_jadwal_pengampu,
			tb_prodi,
			tb_matkul,
			-- tb_dosen,
			tb_jadwal_kelas_pertemuan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			-- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			-- tb_dosen.status!='Dihapus' AND
			tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			LOCATE('{$npk}', tb_jadwal_pengampu.dosen_pengampu) > 0 AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC
			
			");

		return $hasil;
	}

	function cekKetersediaanBerkasKontrakKuliah($id_jadwal_kelas_pertemuan){
		$sql = "SELECT * FROM tb_berkas_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND nama_berkas='Kontrak Kuliah' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows()>0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function show_berkas_pertemuan_monitor($id_pertemuan, $kode_jurusan){
		$query = $this->db->query("

			SELECT *

			FROM 
			tb_tahun_ajaran, 
			tb_semester, 
			tb_pertemuan,
			tb_jadwal_pengampu,
			tb_prodi,
			tb_matkul,
			-- tb_dosen,
			tb_jadwal_kelas_pertemuan,
			tb_berkas_pertemuan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			-- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
			tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_berkas_pertemuan.id_jadwal_kelas_pertemuan AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			-- tb_dosen.status!='Dihapus' AND
			tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
			tb_berkas_pertemuan.status = 'Tersedia' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan' AND
			tb_berkas_pertemuan.nama_berkas = 'Kontrak Kuliah'

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC

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
		
}
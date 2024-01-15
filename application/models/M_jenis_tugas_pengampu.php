<?php
class M_jenis_tugas_pengampu extends CI_Model{
	
	function query_select(){
		$query = "
			SELECT * 
		";
		return $query;
	}

	function query_from(){
		$query = "
			FROM 
			tb_tahun_ajaran, 
			tb_semester, 
			tb_pertemuan,
			tb_jadwal_pengampu,
			tb_prodi,
			tb_matkul,
			tb_jadwal_kelas_pertemuan
			
		";
		return $query;
	}

	function query_where(){
		$query = "
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
		";
		return $query;
	}



	function show_jadwal_kelas_pertemuan($kode_jurusan,$id_pertemuan){

		$query_select = $this->query_select();
		$query_from = $this->query_from();
		$query_where = $this->query_where();

		$query = $this->db->query("

			$query_select 
			$query_from,
			tb_tugas_pengampu 

			$query_where 
			tb_tugas_pengampu.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND 
			tb_tugas_pengampu.status = 'Tersedia' AND 
			
			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY 
			tb_tugas_pengampu.id_tugas_pengampu DESC,
			tb_tugas_pengampu.npk_tugas ASC,
			tb_tugas_pengampu.kategori_tugas ='Tugas Pokok' DESC,
			tb_matkul.nama_mk ASC,
			tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan ASC
		");
		return $query;
	}

	function combobox_kelas_terjadwal($kode_jurusan,$id_pertemuan){

		$query_select = $this->query_select();
		$query_from = $this->query_from();
		$query_where = $this->query_where();

		$query = $this->db->query("

			$query_select 
			$query_from 
			$query_where 

			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_prodi.kode_prodi = '$kode_jurusan'

			ORDER BY 
			tb_matkul.nama_mk ASC,
			tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan ASC
		");
		return $query;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function combobox_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function cekKetersediaanTugas($id_jadwal_kelas_pertemuan, $npk_tugas){
		$hasil=$this->db->query("SELECT * FROM tb_tugas_pengampu WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND npk_tugas = '$npk_tugas' AND status='Tersedia' ");
		return $hasil->num_rows();
	}




	
	function insert_tandai_tugas_pengampu($id_jadwal_kelas_pertemuan, $npk_tugas, $kategori_tugas){
		$status = "Tersedia";
		$hasil=$this->db->query("INSERT INTO tb_tugas_pengampu (id_jadwal_kelas_pertemuan, npk_tugas, kategori_tugas, status) VALUES ($id_jadwal_kelas_pertemuan, '$npk_tugas', '$kategori_tugas', '$status')");
		return $hasil;
	}

	function hapus_kategori_tugas($id_tugas_pengampu){
		$status = "Dihapus";
		$hasil=$this->db->query("UPDATE tb_tugas_pengampu SET status='$status' WHERE id_tugas_pengampu = '$id_tugas_pengampu';");
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
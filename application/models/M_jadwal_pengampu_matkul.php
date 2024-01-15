<?php
class M_jadwal_pengampu_matkul extends CI_Model{

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


	
	function show_jadwal_ujian($kode_jurusan, $id_pertemuan){
		$hasil=$this->db->query("

			SELECT *

			-- tb_matkul.nama_mk AS nama_mk,
			-- tb_dosen.nama_dosen AS nama_dosen,
			-- tb_semester.semester AS semester


			FROM 
			tb_tahun_ajaran, 
			tb_semester, 
			tb_pertemuan,
			tb_jadwal_pengampu,
			tb_prodi,
			tb_matkul
			-- tb_dosen

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			-- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			-- tb_dosen.status!='Dihapus' AND

			tb_prodi.kode_prodi = '$kode_jurusan' AND
			tb_pertemuan.id_pertemuan = '$id_pertemuan'

			ORDER BY tb_jadwal_pengampu.id_jadwal_pengampu DESC


			");
		return $hasil;
	}

	// function show_jadwal_kelas_pertemuan($id_jadwal_pengampu){
	// 	$query = $this->db->query("

	// 		SELECT *

	// 		FROM 
	// 		tb_tahun_ajaran, 
	// 		tb_semester, 
	// 		tb_pertemuan,
	// 		tb_jadwal_pengampu,
	// 		tb_prodi,
	// 		tb_matkul,
	// 		-- tb_dosen,
	// 		tb_jadwal_kelas_pertemuan

	// 		WHERE 
	// 		tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
	// 		tb_semester.id_semester = tb_pertemuan.id_semester AND 
	// 		tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
	// 		tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
	// 		tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
	// 		tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
	// 		-- tb_dosen.npk = tb_jadwal_pengampu.dosen_pengampu AND
	// 		tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

	// 		tb_tahun_ajaran.status='Tersedia' AND 
	// 		tb_semester.status = 'Tersedia' AND 
	// 		tb_pertemuan.status='Tersedia' AND
	// 		tb_jadwal_pengampu.status='Tersedia' AND
	// 		tb_prodi.status = 'Tersedia' AND
	// 		tb_matkul.status = 'Tersedia' AND
	// 		-- tb_dosen.status!='Dihapus' AND
	// 		tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND

	// 		tb_jadwal_pengampu.id_jadwal_pengampu ='$id_jadwal_pengampu'


	// 		");
	// 	return $query;
	// }

	function combobox_ruang($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_ruang where kode_jurusan = $kode_jurusan");
		return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function combobox_kelas($kode_jurusan, $semester){
		// if($semester=="Ganjil"){
			// if($semester=='ALL' || $semester=='TEAM TEACHING'){
				$hasil=$this->db->query("SELECT * from tb_kelas where kode_jurusan = $kode_jurusan ORDER BY semester, nama_kelas ASC");
			// }else{
			// 	$hasil=$this->db->query("SELECT * from tb_kelas where kode_jurusan = $kode_jurusan AND semester='$semester' ORDER BY semester, nama_kelas ASC");
			// }
			
		// }else{
		// 	$hasil=$this->db->query("SELECT * from tb_kelas where kode_jurusan = $kode_jurusan AND semester='$semester' ORDER BY semester, nama_kelas ASC");
		// }
		return $hasil;
	}

	function combobox_dosen1($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_dosen where kode_jurusan = $kode_jurusan AND status='Aktif' ORDER BY nama_dosen ASC");
		return $hasil;
	}

	function combobox_dosen_semua($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_dosen where kode_jurusan = $kode_jurusan AND status='Aktif' AND status_jabatan = 'Dosen' ORDER BY nama_dosen ASC");
		return $hasil;
	}

	function combobox_dosen2($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_dosen where kode_jurusan = $kode_jurusan AND status='Aktif' ORDER BY nama_dosen ASC");
		return $hasil;
	}

	function combobox_matkul($kode_jurusan, $semester){
		if($semester=="Ganjil"){
			$hasil=$this->db->query("SELECT * from tb_matkul where kode_jurusan = $kode_jurusan AND status='Tersedia' AND semester % 2 != 0 ORDER BY semester, nama_mk ASC");
		}elseif($semester=="Genap"){
			$hasil=$this->db->query("SELECT * from tb_matkul where kode_jurusan = $kode_jurusan AND status='Tersedia' AND semester % 2 != 1 ORDER BY semester, nama_mk ASC");
		}else{
			$hasil=$this->db->query("SELECT * from tb_matkul where kode_jurusan = $kode_jurusan AND status='Tersedia' ORDER BY semester, nama_mk ASC");
		}
		return $hasil;
	}

	function combobox_matkul_ganjil($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_matkul where (semester % 2=1 OR semester = 'TEAM TEACHING') AND kode_jurusan = '$kode_jurusan' AND status='Tersedia'");
		return $hasil;
	}

	function combobox_matkul_genap($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_matkul where (semester % 2=0 OR semester = 'TEAM TEACHING') AND kode_jurusan = '$kode_jurusan'  AND status='Tersedia'");
		return $hasil;
	}

	function combobox_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function total_terjadwal($id_jadwal_pengampu){
		$query = $this->db->query("

			SELECT count(tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan) AS terjadwal

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
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = '$id_jadwal_pengampu'


			");
		return $row = $query->row()->terjadwal;
	}


	function detail_kelas($id_jadwal_pengampu){
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
			tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = '$id_jadwal_pengampu'

			ORDER BY tb_jadwal_kelas_pertemuan.nama_kelas ASC


			");
		return $query;
	}



	function tambah_jadwal_pengampu_matkul($kode_jurusan, $id_pertemuan, $kode_mk, $dosen_pengampu, $jumlah_kelas){
		$status = "Tersedia";
		$hasil=$this->db->query("INSERT INTO tb_jadwal_pengampu (kode_jurusan, id_pertemuan, kode_matkul, dosen_pengampu, jumlah_kelas, status) VALUES ($kode_jurusan, $id_pertemuan, '$kode_mk', '$dosen_pengampu', $jumlah_kelas, '$status')");
		return $hasil;
	}

	function edit_jadwal_pengampu_matkul($id_jadwal_pengampu, $kode_jurusan, $kode_mk, $dosen_pengampu, $jumlah_kelas){
		$hasil=$this->db->query("UPDATE tb_jadwal_pengampu SET kode_matkul='$kode_mk', dosen_pengampu='$dosen_pengampu', jumlah_kelas='$jumlah_kelas' WHERE id_jadwal_pengampu = '$id_jadwal_pengampu' AND kode_jurusan='$kode_jurusan';");
		return $hasil;
	}

	function hapus_jadwal_pengampu_matkul($id_jadwal_pengampu){
		$status = "Dihapus";
		$hasil=$this->db->query("UPDATE tb_jadwal_pengampu SET status='$status' WHERE id_jadwal_pengampu = '$id_jadwal_pengampu';");
		return $hasil;
	}

	// function hapus_jadwal_ujian_lanjutan($id_jadwal){
	// 	$hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status='Dihapus' WHERE id_jadwal = '$id_jadwal';");
	// 	return $hasil;
	// }

	function tambah_jadwal_kelas_pertemuan($id_jadwal_pengampu, $jam_pertemuan_pertama, $jam_pertemuan_pertama_akhir, $tanggal_pertemuan_pertama, $nama_kelas, $jumlah_mahasiswa){
		$waktu_pertemuan_pertama = $tanggal_pertemuan_pertama.' '.$jam_pertemuan_pertama;
		$waktu_pertemuan_pertama_akhir = $tanggal_pertemuan_pertama.' '.$jam_pertemuan_pertama_akhir;

		$hasil=$this->db->query("INSERT INTO tb_jadwal_kelas_pertemuan (id_jadwal_pengampu, nama_kelas, jumlah_mahasiswa, waktu_pertemuan_pertama,waktu_pertemuan_pertama_selesai, status) VALUES ($id_jadwal_pengampu, '$nama_kelas', $jumlah_mahasiswa, '$waktu_pertemuan_pertama', '$waktu_pertemuan_pertama_akhir', 'Tersedia')");
		return $hasil;
	}

	function edit_jadwal_kelas_pertemuan($id_jadwal_kelas_pertemuan,  $jam_pertemuan_pertama, $jam_pertemuan_pertama_akhir, $tanggal_pertemuan_pertama, $nama_kelas, $jumlah_mahasiswa){
		$waktu_pertemuan_pertama = $tanggal_pertemuan_pertama.' '.$jam_pertemuan_pertama;
		$waktu_pertemuan_pertama_akhir = $tanggal_pertemuan_pertama.' '.$jam_pertemuan_pertama_akhir;
		$hasil=$this->db->query("UPDATE tb_jadwal_kelas_pertemuan SET nama_kelas='$nama_kelas', jumlah_mahasiswa='$jumlah_mahasiswa', waktu_pertemuan_pertama='$waktu_pertemuan_pertama', waktu_pertemuan_pertama_selesai='$waktu_pertemuan_pertama_akhir'  WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan'");
		return $hasil;
	}

	function hapus_jadwal_kelas_pertemuan($id_jadwal_kelas_pertemuan){
		$hasil=$this->db->query("UPDATE tb_jadwal_kelas_pertemuan SET status='Dihapus' WHERE id_jadwal_kelas_pertemuan = '$id_jadwal_kelas_pertemuan';");
		return $hasil;
	}
	
	function get_kode_mk($kode_jurusan ,$semester){
		if($semester=="Ganjil"){
			$hasil = $this->db->query("SELECT * from tb_matkul where (semester % 2=1 OR semester = 'TEAM TEACHING') AND kode_jurusan = $kode_jurusan");
		}else{
			$hasil = $this->db->query("SELECT * from tb_matkul where (semester % 2=0 OR semester = 'TEAM TEACHING') AND kode_jurusan = $kode_jurusan");
		}
		return $hasil;

		// $query = $this->db->get('tb_matkul');
		
		// $kode_mk = array();
		
		// if($query->result()){
		// foreach ($query->result() as $mk) {
		// $kode_mk[$mk->semester] = $mk->nama_mk;
		// }
		// return $kode_mk;
		// }else{
		// return FALSE;
		// }
	}

	function ambil_tahun_ajaran($id_pertemuan){
		$query = $this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' AND tb_pertemuan.id_pertemuan='$id_pertemuan' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $row = $query->row();
	}

	function check_nama_kelas_tambah($id_jadwal_pengampu, $nama_kelas){
		$sql = "SELECT * FROM tb_jadwal_kelas_pertemuan WHERE id_jadwal_pengampu = '$id_jadwal_pengampu' AND  nama_kelas ='$nama_kelas' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
		
	}

	function check_nama_kelas_edit($id_jadwal_pengampu, $id_jadwal_kelas_pertemuan, $nama_kelas){
		$sql = "SELECT * FROM tb_jadwal_kelas_pertemuan WHERE id_jadwal_pengampu = '$id_jadwal_pengampu' AND   id_jadwal_kelas_pertemuan != '$id_jadwal_kelas_pertemuan' AND  nama_kelas ='$nama_kelas' AND status='Tersedia'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
		
	}

	function cek_jumlah__kelas_terjadwal($id_jadwal_pengampu){
		$query = $this->db->query("SELECT * FROM tb_jadwal_kelas_pertemuan WHERE id_jadwal_pengampu='$id_jadwal_pengampu' AND status='Tersedia'");
		return $row = $query->num_rows();
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
<?php
class M_jadwal_ujian_lanjutan extends CI_Model{

	function show_jadwal_ujian_lanjutan($kode_jurusan, $id_ujian){
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
            tb_jadwal_kelas_pertemuan

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

            tb_ujian.id_ujian = '$id_ujian' AND
            tb_prodi.kode_prodi = '$kode_jurusan'

			");
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





	function combobox_kelas($kode_jurusan, $semester){
		if($semester=="Ganjil"){
			$hasil=$this->db->query("SELECT * from tb_kelas where kode_jurusan = $kode_jurusan AND semester % 2 = 1 ORDER BY semester, nama_kelas ASC");
		}else{
			$hasil=$this->db->query("SELECT * from tb_kelas where kode_jurusan = $kode_jurusan AND semester % 2 = 0 ORDER BY semester, nama_kelas ASC");
		}
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

	//combobox
	function combobox_ruang($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_ruang where kode_jurusan = $kode_jurusan");
		return $hasil;
	}

	function combobox_dosen1($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_dosen where kode_jurusan = '$kode_jurusan' AND status='Aktif' ORDER BY nama_dosen ASC");
		return $hasil;
	}

	function combobox_dosen2($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_dosen where kode_jurusan = '$kode_jurusan' AND status='Aktif' ORDER BY nama_dosen ASC");
		return $hasil;
	}


	//CEK KETERSEDIAAN
	function check_jadwal_pengawas1($kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai){
		if($npk_pengawas1==''){
				$npk_pengawas1 = 'TIDAK ADA';
		}

		$sql = "
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
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk_pengawas1' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk_pengawas1') AND
           	tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_jadwal_pengawas2($kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai){
		if($npk_pengawas2==''){
				$npk_pengawas2 = 'TIDAK ADA';
		}
		$sql = "
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
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk_pengawas2' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk_pengawas2') AND
           	tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}



	function check_ruang($kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sql = "
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
            tb_jadwal_ujian_lanjutan,
            tb_ruang

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
            tb_ruang.kode_ruang = tb_jadwal_ujian_lanjutan.kode_ruang AND

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
            tb_ruang.kode_ruang = '$kode_ruang' AND
            tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}





	//CEK KETERSEDIAAN
	function check_jadwal_pengawas1_edit($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai){
		if($npk_pengawas1==''){
				$npk_pengawas1 = 'TIDAK ADA';
		}

		$sql = "
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
            tb_jadwal_ujian_lanjutan.id_jadwal_lanjutan != '$id_jadwal_lanjutan' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk_pengawas1' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk_pengawas1') AND
           	tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_jadwal_pengawas2_edit($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai){
		if($npk_pengawas2==''){
				$npk_pengawas2 = 'TIDAK ADA';
		}
		$sql = "
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
            tb_jadwal_ujian_lanjutan.id_jadwal_lanjutan != '$id_jadwal_lanjutan' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            (tb_jadwal_ujian_lanjutan.npk_pengawas1 = '$npk_pengawas2' OR tb_jadwal_ujian_lanjutan.npk_pengawas2 = '$npk_pengawas2') AND
           	tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}



	function check_ruang_edit($id_jadwal_lanjutan, $kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sql = "
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
            tb_jadwal_ujian_lanjutan,
            tb_ruang

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
            tb_ruang.kode_ruang = tb_jadwal_ujian_lanjutan.kode_ruang AND

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
            tb_jadwal_ujian_lanjutan.id_jadwal_lanjutan != '$id_jadwal_lanjutan' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            tb_ruang.kode_ruang = '$kode_ruang' AND
            tb_jadwal_ujian.tanggal_ujian = '$tanggal_ujian' AND
            ((tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_mulai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_selesai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai <= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai >= '$jam_selesai') OR (tb_jadwal_ujian.jam_mulai >= '$jam_mulai' AND tb_jadwal_ujian.jam_selesai <= '$jam_selesai'))";

		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}




	function jadwalkan_pengawas_ujian($id_jadwal_ujian, $id_jadwal_kelas_pertemuan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian){
		$hasil=$this->db->query("
			INSERT INTO
			tb_jadwal_ujian_lanjutan
			(
				id_jadwal_ujian,
				id_jadwal_kelas_pertemuan,
				jumlah_mhs_terjadwal_ujian,
				npk_pengawas1,
				npk_pengawas2,
				kode_ruang,
				tanggal_absen_pengawas1,
				jam_absen_pengawas1,
				tanggal_absen_pengawas2,
				jam_absen_pengawas2,
				tanggal_submit_pengawas1,
				jam_submit_pengawas1,
				tanggal_submit_pengawas2,
				jam_submit_pengawas2,
				foto_bukti_pengawas1,
				foto_bukti_pengawas2,
				jenis_soal,
				media,
				jumlah_mahasiswa_hadir,
				ket_pelaksanaan,
				status_verifikasi_pengawas1,
				status_verifikasi_pengawas2,
				tanggal_pengajuan_terlambat_pengawas1,
				jam_pengajuan_terlambat_pengawas1,
				tanggal_pengajuan_terlambat_pengawas2,
				jam_pengajuan_terlambat_pengawas2,
				file_pengajuan_terlambat_pengawas1,
				file_pengajuan_terlambat_pengawas2,
				status_pengajuan_terlambat_pengawas1,
				status_pengajuan_terlambat_pengawas2,
				alasan_penolakan_pengawas1,
				alasan_penolakan_pengawas2,
				status
			)

			VALUES
			(
				$id_jadwal_ujian,
				$id_jadwal_kelas_pertemuan,
				$jumlah_mhs_terjadwal_ujian,
				'$npk_pengawas1',
				'$npk_pengawas2',
				'$kode_ruang',
				'0000-00-00',
				'00:00:00',
				'0000-00-00',
				'00:00:00',
				'0000-00-00',
				'00:00:00',
				'0000-00-00',
				'00:00:00',
				'',
				'',
				'',
				'',
				0,
				'',
				'',
				'',
				'0000-00-00',
				'00:00:00',
				'0000-00-00',
				'00:00:00',
				'',
				'',
				'',
				'',
				'',
				'',
				'Tersedia'
			)
		");
		return $hasil;
	}

	function showDetailJadwalPengawas($kode_jurusan, $id_jadwal_kelas_pertemuan, $id_jadwal_ujian){
		$sql = "
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

            tb_jadwal_ujian.id_jadwal_ujian = '$id_jadwal_ujian' AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = '$id_jadwal_kelas_pertemuan' AND
            tb_prodi.kode_prodi = '$kode_jurusan'";

		return $query=$this->db->query($sql);

	}

	function ambil_pengawas($kode_jurusan, $npk){
		$query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan' AND status!='Dihapus'");
		return $query->row();
  	}

		function get_pengawas($kode_jurusan, $npk){
			$query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND kode_jurusan='$kode_jurusan' AND status!='Dihapus'");
			$row = $query->row();
			if($row){
				$nama_pengawas = $row->nama_dosen;
			}else{
				$nama_pengawas = 'TIDAK DIKETAHUI';
			}
			return $nama_pengawas;
	 	}

		function getJenisUjian($id_surat_keputusan){
			// $query = $this->db->query("SELECT * from tb_surat_keputusan where  id_surat_keputusan='$id_surat_keputusan'");
			// $row = $query->row();
			// if($row){
			// 	$jenis_ujian = $row->nama_surat;
			// }else{
			// 	$jenis_ujian = 'UNKNOWN';
			// }
			return 0;
	 	}




  	function showJadwalPengawas($kode_jurusan){
		$sql = "
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
            tb_prodi.kode_prodi = '$kode_jurusan'";

		return $query=$this->db->query($sql);

	}

	public function hapus_pengawas_ujian($id_jadwal_lanjutan){
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status='Dihapus' WHERE id_jadwal_lanjutan ='$id_jadwal_lanjutan';");
		return $hasil;
	}


	function edit_pengawas_ujian_luring($id_jadwal_lanjutan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian){
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET npk_pengawas1 = '$npk_pengawas1', npk_pengawas2 = '$npk_pengawas2', kode_ruang = '$kode_ruang', jumlah_mhs_terjadwal_ujian = '$jumlah_mhs_terjadwal_ujian' WHERE id_jadwal_lanjutan ='$id_jadwal_lanjutan';");
		return $hasil;
	}

	function edit_pengawas_ujian_daring($id_jadwal_lanjutan, $npk_pengawas1, $jumlah_mhs_terjadwal_ujian){
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET npk_pengawas1 = '$npk_pengawas1', jumlah_mhs_terjadwal_ujian = '$jumlah_mhs_terjadwal_ujian' WHERE id_jadwal_lanjutan ='$id_jadwal_lanjutan';");
		return $hasil;
	}









	function check_nama_kelas($id_jadwal_lanjutan,$nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sub_kelas = substr($nama_kelas,-3);
		if($sub_kelas=="PIL"){
			return 0;
		}else{
			$kode_jurusan = $_SESSION['kode_prodi'];
			$sql = "SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND kode_jurusan='$kode_jurusan' AND id_jadwal_lanjutan != '$id_jadwal_lanjutan' AND  nama_kelas ='$nama_kelas' AND tanggal_ujian = '$tanggal_ujian' AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai'))";
			/* Replace table_name And primary_key With Actual Table Name And Column Name */
			$query=$this->db->query($sql);
			if($query->num_rows() == 1){
				return -1; //Key already exists
			}
			else{
				return 0;  //Key does not exist
			}
		}

	}



	function ambil_kapasitas_ruang($kode_jurusan, $kode_ruang){
		$query = $this->db->query("SELECT * from tb_ruang where kode_ruang='$kode_ruang' AND kode_jurusan='$kode_jurusan'");
		return $row = $query->row();
	}



	function ambil_tahun_ajaran($id_tahun_ajaran){
		$query = $this->db->query("SELECT * from tb_tahun_ajaran where id_tahun_ajaran='$id_tahun_ajaran'");
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


}

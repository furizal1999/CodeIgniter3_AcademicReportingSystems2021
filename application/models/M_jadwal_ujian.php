<?php
class M_jadwal_ujian extends CI_Model{
	
	function show_jadwal_ujian($kode_jurusan, $id_ujian){
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
            tb_jadwal_ujian

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			-- LOCATE(tb_dosen.npk, tb_jadwal_pengampu.dosen_pengampu) > 0 AND
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_surat_keputusan.id_surat = tb_ujian.id_surat_keputusan AND
            tb_jadwal_ujian.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_jadwal_ujian.id_ujian = tb_ujian.id_ujian AND

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

	function combobox_jadwal_pengampu($kode_jurusan, $id_ujian){
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
			tb_surat_keputusan

			WHERE 
			tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
			tb_semester.id_semester = tb_pertemuan.id_semester AND 
			tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
			tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
			tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
			tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
			-- LOCATE(tb_dosen.npk, tb_jadwal_pengampu.dosen_pengampu) > 0 AND
			tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
			tb_ujian.id_surat_keputusan = tb_surat_keputusan.id_surat AND

			tb_tahun_ajaran.status='Tersedia' AND 
			tb_semester.status = 'Tersedia' AND 
			tb_pertemuan.status='Tersedia' AND
			tb_jadwal_pengampu.status='Tersedia' AND
			tb_prodi.status = 'Tersedia' AND
			tb_matkul.status = 'Tersedia' AND
			-- tb_dosen.status!='Dihapus' AND
			tb_surat_keputusan.status = 'Tersedia' AND
			tb_ujian.status = 'Tersedia' AND

			tb_prodi.kode_prodi = '$kode_jurusan' AND
			tb_ujian.id_ujian = '$id_ujian'

			ORDER BY tb_matkul.nama_mk ASC

			");
		return $hasil;
	}


	function cekKetersediaanJadwalUjian($id_ujian, $id_jadwal_pengampu){
	    $hasil=$this->db->query("SELECT * from tb_jadwal_ujian WHERE id_ujian='$id_ujian' AND id_jadwal_pengampu='$id_jadwal_pengampu' AND status='Tersedia'");
	    if($hasil->num_rows() > 0){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	
	}


	function ambil_semester($id_ujian){
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

			ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}

	function tambah_jadwal_ujian($id_ujian, $id_jadwal_pengampu, $tanggal_ujian, $jam_mulai_fiks, $jam_selesai_fiks){
		$hasil=$this->db->query("INSERT INTO tb_jadwal_ujian (id_ujian, id_jadwal_pengampu, tanggal_ujian, jam_mulai, jam_selesai, status) VALUES ($id_ujian, $id_jadwal_pengampu, '$tanggal_ujian', '$jam_mulai_fiks', '$jam_selesai_fiks', 'Tersedia')");
		return $hasil;
	}

	function edit_jadwal_ujian($id_jadwal_ujian, $tanggal_ujian, $jam_mulai_fiks, $jam_selesai_fiks){
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian SET tanggal_ujian='$tanggal_ujian', jam_mulai='$jam_mulai_fiks', jam_selesai='$jam_selesai_fiks' WHERE id_jadwal_ujian = '$id_jadwal_ujian'");
		return $hasil;
	}

	function hapus_jadwal_ujian($id_jadwal_ujian){
		$status = "Dihapus";
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian SET status='$status' WHERE id_jadwal_ujian = '$id_jadwal_ujian';");
		return $hasil;
	}
	







	function total_terjadwal($id_jadwal){
		$this->db->select('COUNT(id_jadwal) as terjadwal');
		$hasil = $this->db->get_where('tb_jadwal_ujian_lanjutan',array('id_jadwal'=>$id_jadwal,'status'=>'Tersedia'))->row()->terjadwal;
		return $hasil;
	}

	function check_jadwal_pengawas1($kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sql = "SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND kode_jurusan='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND (npk_pengawas1 = '$npk_pengawas1' OR npk_pengawas2 = '$npk_pengawas1') AND tanggal_ujian = '$tanggal_ujian' AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai') OR (jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_selesai') OR (jam_mulai >= '$jam_mulai' AND jam_selesai <= '$jam_selesai'))";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_jadwal_pengawas2($kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sql = "SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND kode_jurusan='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND (npk_pengawas1 = '$npk_pengawas2' OR npk_pengawas2 = '$npk_pengawas2') AND tanggal_ujian = '$tanggal_ujian' AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai') OR (jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_selesai') OR (jam_mulai >= '$jam_mulai' AND jam_selesai <= '$jam_selesai'))";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function check_nama_kelas($kode_jurusan, $nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sub_kelas = substr($nama_kelas,-3);
		if($sub_kelas=="PIL"){
			return 0;
		}else{
			$sql = "SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND kode_jurusan='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND nama_kelas ='$nama_kelas' AND tanggal_ujian = '$tanggal_ujian' AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai'))";
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

	function check_ruang($kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai){
		$sql = "SELECT * FROM tb_jadwal_ujian, tb_jadwal_ujian_lanjutan WHERE tb_jadwal_ujian.id_jadwal = tb_jadwal_ujian_lanjutan.id_jadwal AND kode_jurusan='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' AND kode_ruang ='$kode_ruang' AND tanggal_ujian = '$tanggal_ujian' AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai'))";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function ambil_matkul($kode_jurusan, $kode_mk){
		$query = $this->db->query("SELECT * from tb_matkul where kode_mk='$kode_mk' AND kode_jurusan='$kode_jurusan'");
		return $row = $query->row();
	}

	function ambil_kapasitas_ruang($kode_jurusan, $kode_ruang){
		$query = $this->db->query("SELECT * from tb_ruang where kode_ruang='$kode_ruang' AND kode_jurusan='$kode_jurusan'");
		return $row = $query->row();
	}

	function hapus_jadwal_ujian_lanjutan($id_jadwal){
		$hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET status='Dihapus' WHERE id_jadwal = '$id_jadwal';");
		return $hasil;
	}

	function tambah_jadwal_ujian_lanjutan($id_jadwal, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $nama_kelas, $jumlah_mahasiswa){
		$hasil=$this->db->query("INSERT INTO tb_jadwal_ujian_lanjutan (id_jadwal, npk_pengawas1, npk_pengawas2, kode_ruang, nama_kelas, jumlah_mahasiswa, tanggal_absen_pengawas1, jam_absen_pengawas1, tanggal_absen_pengawas2, jam_absen_pengawas2, tanggal_submit_pengawas1, jam_submit_pengawas1, tanggal_submit_pengawas2, jam_submit_pengawas2, foto_bukti_pengawas1, foto_bukti_pengawas2, jenis_soal, media, jumlah_mahasiswa_hadir, ket_pelaksanaan, status_verifikasi_pengawas1, status_verifikasi_pengawas2, tanggal_pengajuan_terlambat_pengawas1, jam_pengajuan_terlambat_pengawas1, tanggal_pengajuan_terlambat_pengawas2, jam_pengajuan_terlambat_pengawas2, file_pengajuan_terlambat_pengawas1, file_pengajuan_terlambat_pengawas2,  status_pengajuan_terlambat_pengawas1, status_pengajuan_terlambat_pengawas2, alasan_penolakan_pengawas1, alasan_penolakan_pengawas2, status) VALUES ($id_jadwal, '$npk_pengawas1', '$npk_pengawas2', '$kode_ruang', '$nama_kelas', $jumlah_mahasiswa , '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', '', '', '', '', 0, '', '', '' , '0000-00-00', '00:00:00', '0000-00-00', '00:00:00', '' , '' ,'' , '', '' , '','Tersedia')");
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

	

	function cek_jumlah_terjadwal($id_jadwal){
		$query = $this->db->query("SELECT count(id_jadwal_lanjutan) AS jumlah_terjadwal from tb_jadwal_ujian, tb_jadwal_ujian_lanjutan where tb_jadwal_ujian.id_jadwal=tb_jadwal_ujian_lanjutan.id_jadwal AND tb_jadwal_ujian.id_jadwal = '$id_jadwal' AND tb_jadwal_ujian.status = 'Tersedia' AND tb_jadwal_ujian_lanjutan.status ='Tersedia'");
		return $row = $query->row();
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
	
}
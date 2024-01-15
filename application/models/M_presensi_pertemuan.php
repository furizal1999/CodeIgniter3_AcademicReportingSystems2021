<?php
class M_presensi_pertemuan extends CI_Model{

	function show_kelas_diampu($id_pertemuan, $kode_jurusan, $dosen_pengampu){


		// $array_dosen = explode(', ', $dosen_pengampu);

		// $index = 0;
		// $array_dosen_hasil = array();

		// foreach ($array_dosen as $npk) {
		// 	// $nama_dosen = $this->m_jadwal_pengampu_matkul->getNamaDosen($npk);
		// 	$array_dosen_hasil[$index++] = $npk;
		// }

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
			tb_prodi.kode_prodi = '$kode_jurusan' AND
			LOCATE('{$dosen_pengampu}', tb_jadwal_pengampu.dosen_pengampu) > 0

			ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC


			");
		return $query;
	}

	// function show_soal_ujian($kode_jurusan, $id_tahun_ajaran){
	// 	$hasil=$this->db->query("SELECT tb_dosen.nama_dosen AS nama_dosen, tb_jadwal_ujian.id_jadwal AS id_jadwal, tb_tahun_ajaran.tahun_ajaran AS tahun_ajaran, tb_tahun_ajaran.semester AS semester, tb_tahun_ajaran.jenis_ujian AS jenis_ujian, tb_tahun_ajaran.nama_ujian AS nama_ujian, tb_matkul.nama_mk AS nama_mk, tb_jadwal_ujian.tanggal_ujian AS tanggal_ujian, tb_jadwal_ujian.jam_mulai AS jam_mulai, tb_jadwal_ujian.jam_selesai AS jam_selesai, tb_jadwal_ujian.file_soal_ujian AS file_soal_ujian FROM tb_tahun_ajaran, tb_jadwal_ujian, tb_matkul, tb_prodi, tb_dosen WHERE tb_dosen.npk = tb_jadwal_ujian.dosen_pengampu AND tb_prodi.kode_prodi = tb_jadwal_ujian.kode_jurusan AND tb_tahun_ajaran.id_tahun_ajaran = tb_jadwal_ujian.id_tahun_ajaran AND tb_jadwal_ujian.kode_matkul = tb_matkul.kode_mk AND tb_tahun_ajaran.id_tahun_ajaran='$id_tahun_ajaran' AND tb_prodi.kode_prodi='$kode_jurusan' AND tb_jadwal_ujian.status='Tersedia' AND tb_tahun_ajaran.status='Tersedia' ORDER BY file_soal_ujian!='' DESC, tanggal_ujian ASC, jam_mulai ASC");
	// 	return $hasil;
	// }

	function combobox_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
		return $hasil;
	}








    function ambil_tahun_ajaran($id_tahun_ajaran){
      $hasil=$this->db->query("SELECT * from tb_tahun_ajaran WHERE id_tahun_ajaran='$id_tahun_ajaran'  AND status='Tersedia' ");
      return $hasil;
    }

    function check_ketersediaan_pertemuan_minta_verifikasi($id_jadwal_kelas_pertemuan, $pertemuan_ke){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status_verifikasi='Minta Verifikasi' AND status='Tersedia'")->num_rows();
      return $hasil;
    }

    function check_ketersediaan_pertemuan_terverifikasi($id_jadwal_kelas_pertemuan, $pertemuan_ke){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status_verifikasi='Terverifikasi' AND status='Tersedia'")->num_rows();
      return $hasil;
    }

    function check_ketersediaan_pertemuan_ditolak($id_jadwal_kelas_pertemuan, $pertemuan_ke){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status_verifikasi='Ditolak' AND status='Tersedia'")->num_rows();
      return $hasil;
    }

    function getDataPertemuan($id_jadwal_kelas_pertemuan, $pertemuan_ke){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status='Tersedia'");
      return $hasil;
    }


     function semuaDataPertemuan($id_jadwal_kelas_pertemuan){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND status='Tersedia'");
      return $hasil;
    }

	function cekPertemuanSebelumnya($id_jadwal_kelas_pertemuan, $pertemuanSebelum){
		if($pertemuanSebelum==0 || $pertemuanSebelum==8){
			return 1;
		}else{
			$hasil=$this->db->query("SELECT count(id_presensi_pertemuan) AS jml from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuanSebelum' AND status_verifikasi !='Ditolak' AND status = 'Tersedia'")->row();
			if($hasil->jml == 0){
				return 0;
			}else{
				return 1;
			}
		}
	  }
	


    function cekSemuaRequestPertemuan($id_jadwal_kelas_pertemuan, $pertemuan_ke){
    	 $hasil=$this->db->query("SELECT * from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status='Tersedia'");
      return $hasil;
    }

    function cekRequestPertemuanDisetujui($id_jadwal_kelas_pertemuan, $pertemuan_ke){
    	$hasil=$this->db->query("SELECT * from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Disetujui' AND status='Tersedia'");
      return $hasil;
    }

    function cekRequestPertemuanDitolak($id_jadwal_kelas_pertemuan, $pertemuan_ke){
    	$hasil=$this->db->query("SELECT * from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Ditolak' AND status='Tersedia'");
      return $hasil;
    }

    function cekRequestPertemuanMintaSetujui($id_jadwal_kelas_pertemuan, $pertemuan_ke){
    	$hasil=$this->db->query("SELECT * from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Minta Persetujuan' AND status='Tersedia'");
      return $hasil;
    }


    function cekHariLibur($jadwalAwal, $jadwalAwalJam){
    	$jadwalPertemuan = $jadwalAwal.' '.$jadwalAwalJam;
			$sql = "SELECT * FROM tb_jadwal_libur_pertemuan WHERE ((waktu_jadwal_libur_mulai <= '$jadwalPertemuan') AND (waktu_jadwal_libur_selesai >= '$jadwalPertemuan')) AND status='Tersedia'";
			/* Replace table_name And primary_key With Actual Table Name And Column Name */
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				return -1; //Key already exists
			}
			else{
				return 0;  //Key does not exist
			}
		}

		function cekTanggalUTS($id_pertemuan, $nama_ujian, $jadwalAwal, $jadwalAwalJam){
    	$jadwalPertemuan = $jadwalAwal.' '.$jadwalAwalJam;

			$sql = "

			SELECT range_selesai_ujian AS rg_selesai FROM

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

			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_ujian.nama_ujian = '$nama_ujian' AND

			((tb_ujian.range_mulai_ujian <= '$jadwalPertemuan') AND (tb_ujian.range_selesai_ujian >= '$jadwalPertemuan'))";


			/* Replace table_name And primary_key With Actual Table Name And Column Name */
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				return -1; //Key already exists
			}
			else{
				return 0;  //Key does not exist
			}
		}

		function cekJumlahPengajuanPerbulan($id_jadwal_kelas_pertemuan, $bulan){
			$sql = "SELECT * FROM tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND month(waktu_request_pertemuan)='$bulan' AND status_request_pertemuan='Disetujui' AND status='Tersedia'";
			/* Replace table_name And primary_key With Actual Table Name And Column Name */
			$query=$this->db->query($sql);
			if($query->num_rows()>=2){
				return -1; //Key already exists
			}
			else{
				return 0;  //Key does not exist
			}
		}

		function ambilAlasan($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT alasan_penolakan_request AS alasan from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Ditolak' AND status='Tersedia'");
				// $arrayVar[1]
				$arrayResult = $arrayVar->result_array();
				$jumlah = $arrayVar->num_rows();
				if($jumlah>0){
					$hasil = $arrayResult[$jumlah-1]['alasan'];
				}else{
					$hasil = '';
				}


      	return $hasil;
		}

		function ambilTanggalDiaju($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT waktu_request_pertemuan AS tanggal from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Disetujui' AND status='Tersedia'");
				// $arrayVar[1]
				$arrayResult = $arrayVar->result_array();
				$jumlah = $arrayVar->num_rows();

				if($jumlah>0){
					$hasil = $arrayResult[$jumlah-1]['tanggal'];
					$hasil2 = date("Y-m-d", strtotime($hasil));
				}else{
					$hasil2 = '';
				}


      	return $hasil2;
		}

		function ambilJamDiaju($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT waktu_request_pertemuan AS tanggal from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Disetujui' AND status='Tersedia'");
				// $arrayVar[1]
				$arrayResult = $arrayVar->result_array();
				$jumlah = $arrayVar->num_rows();

				if($jumlah>0){
					$hasil = $arrayResult[$jumlah-1]['tanggal'];
					$hasil2 = date("H:i:s", strtotime($hasil));
				}else{
					$hasil2 = '';
				}


      	return $hasil2;
		}

		function ambilTanggalDiajuSelesai($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT waktu_request_pertemuan_selesai AS tanggal from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Disetujui' AND status='Tersedia'");
				// $arrayVar[1]
				$arrayResult = $arrayVar->result_array();
				$jumlah = $arrayVar->num_rows();

				if($jumlah>0){
					$hasil = $arrayResult[$jumlah-1]['tanggal'];
					$hasil2 = date("Y-m-d", strtotime($hasil));
				}else{
					$hasil2 = '';
				}


      	return $hasil2;
		}

		function ambilJamDiajuSelesai($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT waktu_request_pertemuan_selesai AS tanggal from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan ='Disetujui' AND status='Tersedia'");
				// $arrayVar[1]
				$arrayResult = $arrayVar->result_array();
				$jumlah = $arrayVar->num_rows();

				if($jumlah>0){
					$hasil = $arrayResult[$jumlah-1]['tanggal'];
					$hasil2 = date("H:i:s", strtotime($hasil));
				}else{
					$hasil2 = '';
				}


      	return $hasil2;
		}




	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
	    return $hasil;
	}

	function combobox_ruang($kode_jurusan){
		$hasil=$this->db->query("SELECT * from tb_ruang where kode_jurusan = $kode_jurusan");
		return $hasil;
	}

	function presensi($id_jadwal_kelas_pertemuan, $pertemuan_ke, $tanggal_pertemuan_mulai, $jam_pertemuan_mulai_fiks, $tanggal_pertemuan_selesai, $jam_pertemuan_selesai_fiks, $kode_ruang, $materi, $metode, $mhs_hadir, $media2, $nama_fotobaru, $dosen_penginput_presensi){
			date_default_timezone_set('Asia/Jakarta');
	        $waktu_input = date("Y-m-d H:i:s");
	        $waktu_pertemuan_mulai = $tanggal_pertemuan_mulai.' '.$jam_pertemuan_mulai_fiks;
	        $waktu_pertemuan_selesai = $tanggal_pertemuan_selesai.' '.$jam_pertemuan_selesai_fiks;
			$hasil =$this->db->query("INSERT INTO tb_presensi_pertemuan (id_jadwal_kelas_pertemuan, dosen_penginput_presensi, waktu_pertemuan, waktu_pertemuan_selesai, waktu_input, pertemuan_ke, kode_ruang, media_pertemuan, materi_pertemuan, metode_pertemuan, mhs_hadir, foto_pertemuan, status_verifikasi, status) VALUES ($id_jadwal_kelas_pertemuan, $dosen_penginput_presensi, '$waktu_pertemuan_mulai','$waktu_pertemuan_selesai', '$waktu_input', $pertemuan_ke, '$kode_ruang', '$media2', '$materi', '$metode', $mhs_hadir, '$nama_fotobaru', 'Minta Verifikasi', 'Tersedia')");
	    return $this->db->insert_id();
	}

	function insert_ttd($id_terakhir, $pertemuan_ke, $nama_mk, $semester, $tahun_ajaran){
			date_default_timezone_set('Asia/Jakarta');
      $waktu_input = date("Y-m-d H:i:s");
      $topik_relasi = 'Presensi Pertemuan';
      $nama_penanda_tangan = $_SESSION['nama'];
      $jabatan_penanda_tangan = 'Dosen Pengampu Matakuliah';
      $perihal = 'Presensi Tatap Muka Dosen Pengampu Matakuliah '.$nama_mk.' (Pertemuan Ke-'.$pertemuan_ke.') Pada Semester '.$semester.' Tahun Ajaran '.$tahun_ajaran;



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



			$hasil =$this->db->query("INSERT INTO tb_ttd_digital (id_relasi, topik_relasi, id_random, waktu_input_ttd, nama_penanda_tangan, jabatan_penanda_tangan, perihal, status_validasi, status) VALUES ($id_terakhir, '$topik_relasi', '$rand', '$waktu_input', '$nama_penanda_tangan', '$jabatan_penanda_tangan', '$perihal', 'Tervalidasi', 'Tersedia')");

	    return $hasil;
	}


	function edit_presensi_nophoto($id_presensi_pertemuan, $kode_ruang, $materi, $metode, $mhs_hadir, $media2){
		date_default_timezone_set('Asia/Jakarta');
    $waktu_input = date("Y-m-d H:i:s");
		$hasil =$this->db->query("UPDATE tb_presensi_pertemuan SET kode_ruang='$kode_ruang', materi_pertemuan='$materi',  metode_pertemuan='$metode', mhs_hadir='$mhs_hadir', media_pertemuan='$media2', status_verifikasi='Minta Verifikasi' WHERE id_presensi_pertemuan='$id_presensi_pertemuan'");
      	return $hasil;
	}

	function edit_presensi_photo($id_presensi_pertemuan, $kode_ruang, $materi, $metode, $mhs_hadir, $media2, $nama_fotobaru){
		$hasil =$this->db->query("UPDATE tb_presensi_pertemuan SET kode_ruang='$kode_ruang', materi_pertemuan='$materi', metode_pertemuan='$metode', mhs_hadir='$mhs_hadir', media_pertemuan='$media2', foto_pertemuan='$nama_fotobaru', status_verifikasi='Minta Verifikasi' WHERE id_presensi_pertemuan='$id_presensi_pertemuan'");
      	return $hasil;
	}

	function ajukan_request_pertemuan($id_jadwal_kelas_pertemuan, $dosen_penginput_request, $pertemuan_ke, $tanggal_pertemuan,  $jam_pertemuan_mulai_fiks, $jam_pertemuan_selesai_fiks, $alasan){
		date_default_timezone_set('Asia/Jakarta');
    $waktu_input = date("Y-m-d H:i:s");
    $waktu_pertemuan_mulai = $tanggal_pertemuan.' '.$jam_pertemuan_mulai_fiks;
    $waktu_pertemuan_selesai = $tanggal_pertemuan.' '.$jam_pertemuan_selesai_fiks;
		$hasil =$this->db->query("INSERT INTO tb_request_pertemuan (id_jadwal_kelas_pertemuan, dosen_penginput_request, pertemuan_ke, alasan_request_pertemuan, waktu_request_pertemuan, waktu_request_pertemuan_selesai, waktu_input_request_pertemuan, status_request_pertemuan, alasan_penolakan_request, status) VALUES ($id_jadwal_kelas_pertemuan, '$dosen_penginput_request', $pertemuan_ke, '$alasan', '$waktu_pertemuan_mulai', '$waktu_pertemuan_selesai', '$waktu_input', 'Disetujui', '', 'Tersedia')");
      	return $hasil;
	}

	function batal_jadwal_ganti($id_jadwal_kelas_pertemuan, $pertemuan_ke){
		$hasil =$this->db->query("UPDATE tb_request_pertemuan SET status='Dihapus' WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan'AND pertemuan_ke='$pertemuan_ke' AND status_request_pertemuan='Minta Persetujuan' AND status='Tersedia'");
    return $hasil;
	}


	function cekRangePertemuan($id_pertemuan, $tanggal, $jam){
			$tanggal_jam = $tanggal.' '.$jam;

			$sql = "SELECT * FROM tb_pertemuan WHERE id_pertemuan='$id_pertemuan' AND (pertemuan_mulai<='$tanggal_jam' AND pertemuan_selesai>='$tanggal_jam') AND status='Tersedia'";

			/* Replace table_name And primary_key With Actual Table Name And Column Name */
			$query=$this->db->query($sql);
			if($query->num_rows()>0){
				return -1; //Key already exists
			}
			else{
				return 0;  //Key does not exist
			}
	}







	//laporan
	function selectCetakLaporanPertemuan($id_jadwal_kelas_pertemuan){
			return $this->db->query("
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
                tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = '$id_jadwal_kelas_pertemuan'

				");

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

		function ambilPresensiPertemuan($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status='Tersedia' AND status_verifikasi!='Ditolak' ");
				// $arrayVar[1]
				return $arrayVar->row();
		}

		function hari($tanggal){
    	$today = date('D', strtotime($tanggal));
			$dayList = array(
			    'Sun' => 'Minggu',
			    'Mon' => 'Senin',
			    'Tue' => 'Selasa',
			    'Wed' => 'Rabu',
			    'Thu' => 'Kamis',
			    'Fri' => 'Jumat',
			    'Sat' => 'Sabtu'
			);

			return $dayList[$today];
    }

    function format_tanggal($tanggal){
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

    function getIdRandom($id_presensi_pertemuan){
			$arrayVar=$this->db->query("SELECT id_random AS rand from tb_ttd_digital WHERE id_relasi='$id_presensi_pertemuan' AND topik_relasi ='Presensi Pertemuan' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['rand'];
			}else{
				$hasil = '';
			}
			return $hasil;

		}

		function getPenandaTangan($id_random){
			$arrayVar=$this->db->query("SELECT nama_penanda_tangan AS nama_ptd from tb_ttd_digital WHERE id_random='$id_random' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['nama_ptd'];
			}else{
				$hasil = '';
			}
			return $hasil;

		}

		function getIdRandomTddProdi($id_jadwal_kelas_pertemuan){
			$topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Ketua Program Studi)';
			$arrayVar=$this->db->query("SELECT id_random AS rand from tb_ttd_digital WHERE id_relasi='$id_jadwal_kelas_pertemuan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['rand'];
			}else{
				$hasil = '';
			}
			return $hasil;

		}

		function getIdRandomTddWd1($id_jadwal_kelas_pertemuan){
			$topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Wakil Dekan I)';
			$arrayVar=$this->db->query("SELECT id_random AS rand from tb_ttd_digital WHERE id_relasi='$id_jadwal_kelas_pertemuan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['rand'];
			}else{
				$hasil = '';
			}
			return $hasil;

		}

		function ambilNamaWd1(){
			$arrayVar=$this->db->query("SELECT nama AS nama from tb_fakultas WHERE jabatan='Wakil Dekan I' AND status='Aktif'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();

			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['nama'];
			}else{
				$hasil = '';
			}


    	return $hasil;
	}

	function ambilNamaKaProdi($kode_jurusan){
			$arrayVar=$this->db->query("SELECT nama_lengkap AS nama from tb_prodi_attribut WHERE kode_prodi='$kode_jurusan' AND jabatan='Ketua Program Studi' AND status_akun='Aktif'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();

			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['nama'];
			}else{
				$hasil = '';
			}


    	return $hasil;
	}



		function getTanggalSelesaiUjianUTS($id_pertemuan, $nama_ujian){
			$arrayVar=$this->db->query("

			SELECT range_selesai_ujian AS rg_selesai FROM

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

			tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
			tb_ujian.nama_ujian = '$nama_ujian'

				");


			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();

			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['rg_selesai'];
			}else{
				$hasil = '';
			}


    	return $hasil;
	}

		function getTanggalPresensi($id_jadwal_kelas_pertemuan, $pertemuan_ke, $jadwalAwal){
			$arrayVar=$this->db->query("SELECT waktu_pertemuan AS tanggal from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status_verifikasi!='Ditolak' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['tanggal'];
			}else{
				$hasil = $jadwalAwal;
			}
			return $hasil;

		}

		function getTanggalPengajuan($id_jadwal_kelas_pertemuan, $pertemuan_ke, $jadwalAwal){
			$arrayVar=$this->db->query("SELECT waktu_request_pertemuan AS tanggal from tb_request_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke ='$pertemuan_ke' AND status_request_pertemuan='Disetujui' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['tanggal'];
			}else{
				$hasil = $jadwalAwal;
			}
			return $hasil;

		}

		function getTugasPengampu($id_jadwal_kelas_pertemuan, $npk){
			$arrayVar=$this->db->query("SELECT kategori_tugas AS kategori from tb_tugas_pengampu WHERE npk_tugas = '$npk' AND id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND status='Tersedia'");
			// $arrayVar[1]
			$arrayResult = $arrayVar->result_array();
			$jumlah = $arrayVar->num_rows();
			if($jumlah>0){
				$hasil = $arrayResult[$jumlah-1]['kategori'];
			}else{
				$hasil = '<i class="text-danger">Belum diinput</i>';
			}
			return $hasil;
		}

		function getNamaTtd($id_jadwal_kelas_pertemuan, $topik_relasi){
	      $arrayVar=$this->db->query("SELECT nama_penanda_tangan AS nama from tb_ttd_digital WHERE id_relasi='$id_jadwal_kelas_pertemuan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'");
	      // $arrayVar[1]
	      $arrayResult = $arrayVar->result_array();
	      $jumlah = $arrayVar->num_rows();
	      if($jumlah>0){
	        $hasil = $arrayResult[$jumlah-1]['nama'];
	      }else{
	        $hasil = '';
	      }
	      return $hasil;

	  }

		function getFile($kode_prodi, $id_pertemuan){
			$hasil=$this->db->query("SELECT nama_file_berkas AS nfb from tb_berkas_sk_pertemuan WHERE status='Tersedia' AND kode_prodi='$kode_prodi' AND id_pertemuan='$id_pertemuan'")->row();
			if($hasil){
				return $hasil->nfb;
			}else{
				return '';
			}
		}

}

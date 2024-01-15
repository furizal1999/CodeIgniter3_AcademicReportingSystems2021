<?php
class M_preview_laporan_pertemuan extends CI_Model{

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
	
	// function show_kelas_diampu($id_pertemuan, $kode_jurusan){

	// 	$query = $this->db->query("

	// 		SELECT *

	// 		FROM 
	// 		tb_tahun_ajaran, 
	// 		tb_semester, 
	// 		tb_pertemuan,
	// 		tb_jadwal_pengampu,
	// 		tb_prodi,
	// 		tb_matkul,
	// 		tb_jadwal_kelas_pertemuan

	// 		WHERE 
	// 		tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
	// 		tb_semester.id_semester = tb_pertemuan.id_semester AND 
	// 		tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
	// 		tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
	// 		tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
	// 		tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
	// 		tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND

	// 		tb_tahun_ajaran.status='Tersedia' AND 
	// 		tb_semester.status = 'Tersedia' AND 
	// 		tb_pertemuan.status='Tersedia' AND
	// 		tb_jadwal_pengampu.status='Tersedia' AND
	// 		tb_prodi.status = 'Tersedia' AND
	// 		tb_matkul.status = 'Tersedia' AND
	// 		tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
	// 		tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
	// 		tb_prodi.kode_prodi = '$kode_jurusan'

	// 		ORDER BY tb_matkul.nama_mk ASC, tb_jadwal_kelas_pertemuan.nama_kelas ASC


	// 		");
	// 	return $query;
	// }

	
	function combobox_pertemuan(){
		$hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND  tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
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

		function ambilPresensiPertemuan($id_jadwal_kelas_pertemuan, $pertemuan_ke){
				$arrayVar=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND pertemuan_ke='$pertemuan_ke' AND status='Tersedia' AND status_verifikasi!='Ditolak' ");
				// $arrayVar[1]
				return $arrayVar->row();
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


    function getPresensi($id_presensi_pertemuan){
      $hasil=$this->db->query("SELECT * from tb_presensi_pertemuan WHERE id_presensi_pertemuan='$id_presensi_pertemuan' AND status='Tersedia'");
      return $hasil;
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


	function insert_ttd($id_jadwal_kelas_pertemuan, $tahun_ajaran, $semester, $nama_mk, $nama_dosen){

		date_default_timezone_set('Asia/Jakarta');
	    $waktu_input = date("Y-m-d H:i:s");

	    $topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Ketua Program Studi)';
	    $nama_penanda_tangan = $_SESSION['nama'];
	    $jabatan_penanda_tangan = 'Ketua Program Studi '.$_SESSION['nama_prodi'];
	    $perihal = 'Pengesahan Laporan Presensi Tatap Muka Matakuliah '.$nama_mk.' yang diampu oleh '.$nama_dosen.' Pada Semester '.$semester.' Tahun Ajaran '.$tahun_ajaran;

	    $rand = $this->generateRandomId();

		$hasil =$this->db->query("
			INSERT INTO 
			tb_ttd_digital (id_relasi, topik_relasi, id_random, waktu_input_ttd, nama_penanda_tangan, jabatan_penanda_tangan, perihal, status_validasi, status) 
			VALUES (
				$id_jadwal_kelas_pertemuan, 
				'$topik_relasi', 
				'$rand', 
				'$waktu_input', 
				'$nama_penanda_tangan', 
				'$jabatan_penanda_tangan', 
				'$perihal', 
				'Tervalidasi', 
				'Tersedia'
			)");

		    return $hasil;

	}

	function insert_ttd_wd1($id_jadwal_kelas_pertemuan, $tahun_ajaran, $semester, $nama_mk, $nama_dosen){

		date_default_timezone_set('Asia/Jakarta');
	    $waktu_input = date("Y-m-d H:i:s");

	    $topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Wakil Dekan I)';
	    $nama_penanda_tangan = $_SESSION['nama'];
	    $jabatan_penanda_tangan = 'Wakil Dekan I Fakultas Teknik';
	    $perihal = 'Pengesahan Laporan Presensi Tatap Muka Matakuliah '.$nama_mk.' yang diampu oleh '.$nama_dosen.' Pada Semester '.$semester.' Tahun Ajaran '.$tahun_ajaran;

	    $rand = $this->generateRandomId();

		$hasil =$this->db->query("
			INSERT INTO 
			tb_ttd_digital (id_relasi, topik_relasi, id_random, waktu_input_ttd, nama_penanda_tangan, jabatan_penanda_tangan, perihal, status_validasi, status) 
			VALUES (
				$id_jadwal_kelas_pertemuan, 
				'$topik_relasi', 
				'$rand', 
				'$waktu_input', 
				'$nama_penanda_tangan', 
				'$jabatan_penanda_tangan', 
				'$perihal', 
				'Tervalidasi', 
				'Tersedia'
			)");

		    return $hasil;

	}
	  

	function generateRandomId(){
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

		return $rand;
	}

	function cekTtdKetuaProdi($id_jadwal_kelas_pertemuan){
		$topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Ketua Program Studi)';
		$hasil =$this->db->query("SELECT * FROM tb_ttd_digital WHERE id_relasi='$id_jadwal_kelas_pertemuan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'")->num_rows();

	    return $hasil;
	}

	function cekTtdWd1($id_jadwal_kelas_pertemuan){
		$topik_relasi = 'Kelas Pertamuan (Persetujuan Laporan Presensi Oleh Wakil Dekan I)';
		$hasil =$this->db->query("SELECT * FROM tb_ttd_digital WHERE id_relasi='$id_jadwal_kelas_pertemuan' AND topik_relasi ='$topik_relasi' AND status='Tersedia'")->num_rows();

	    return $hasil;
	}

	function combobox_prodi(){
	    $hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia' ORDER BY kode_prodi ASC");
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

		
}
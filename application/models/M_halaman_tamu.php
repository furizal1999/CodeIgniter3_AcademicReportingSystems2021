<?php
class M_halaman_tamu extends CI_Model{

	function combobox_jurusan(){
		$hasil=$this->db->query("SELECT * from tb_prodi WHERE status='Tersedia'");
		return $hasil;
	}

	function daftar_akun_dosen($npk, $status_jabatan, $nama_dosen, $jk, $email, $kode_jurusan, $password_enc, $foto, $status){
		$hasil=$this->db->query("INSERT INTO tb_dosen (npk, status_jabatan, nama_dosen, jk, email, kode_jurusan, password, foto, status) VALUES ('$npk', '$status_jabatan', '$nama_dosen', '$jk', '$email', '$kode_jurusan', '$password_enc', '$foto', '$status')");
		return $hasil;
	}

	function ambil_upm($username){
		$query = $this->db->query("SELECT * from tb_upm where username='$username'");
		return $row = $query->row();
	}

	function ambil_tu($username){
		$query = $this->db->query("SELECT * from tb_tu where username='$username'");
		return $row = $query->row();
	}

	function ambil_fakultas($username){
		$query = $this->db->query("SELECT * from tb_fakultas where username='$username'");
		return $row = $query->row();
	}

	function ambil_developer($username){
		$query = $this->db->query("SELECT * from tb_developer where username='$username'");
		return $row = $query->row();
	}

	function ambil_pembimbing_lapangan_kp($username, $password){
		$query = $this->db->query("
			SELECT * from 
			tbl_syarat_sk, tbl_mahasiswa, tbl_jenis_sk, tbl_surat_pengantar
			WHERE
			tbl_syarat_sk.id_jenis_sk = tbl_jenis_sk.id_jenis_sk AND
			tbl_syarat_sk.npm = tbl_mahasiswa.npm AND
			tbl_surat_pengantar.id_surat_pengantar = tbl_syarat_sk.nama_tempat_kp AND
			tbl_syarat_sk.status='Tersedia' AND
			tbl_mahasiswa.status!='Dihapus' AND
			tbl_jenis_sk.status='Tersedia' AND
			tbl_surat_pengantar.status='Tersedia' AND
			(tbl_syarat_sk.email_pembimbing_lapangan = '$username') AND
			tbl_syarat_sk.string_random = '$password'
			");
		return $row = $query->row();
	}
	

	function ambil_prodi($username){
		$query = $this->db->query("SELECT * from tb_prodi, tb_prodi_attribut where tb_prodi.kode_prodi = tb_prodi_attribut.kode_prodi AND tb_prodi_attribut.username='$username'");
		return $row = $query->row();
	}
	function ambil_dosen($npk, $status_jabatan){
		$query = $this->db->query("
			SELECT 
			tb_dosen.npk,
			tb_dosen.nama_dosen,
			tb_dosen.status_jabatan,
			tb_dosen.jk,
			tb_dosen.password,
			tb_dosen.email,
			tb_dosen.jabatan_fungsional,
			tb_dosen.pendidikan,
			tb_dosen.kode_jurusan,
			tb_dosen.foto,
			tb_dosen.status,
			tb_prodi.nama_prodi
			from tb_dosen, tb_prodi where tb_dosen.kode_jurusan = tb_prodi.kode_prodi AND tb_dosen.npk='$npk' AND tb_dosen.status_jabatan='$status_jabatan'");
		// $query = $this->db->query("SELECT * from tb_dosen where npk='$npk' AND status_jabatan='$status_jabatan'");

		return $row = $query->row();
	}

	function ambil_mahasiswa($username){
		$query = $this->db->query("SELECT 
			tbl_mahasiswa.npm AS npm,
			tbl_mahasiswa.nama_mahasiswa AS nama_mahasiswa,
			tbl_mahasiswa.jk AS jk,
			tbl_mahasiswa.tempat_lahir AS tempat_lahir,
			tbl_mahasiswa.tgl_lahir AS tgl_lahir,
			tbl_mahasiswa.password AS password,
			tbl_mahasiswa.email_student AS email_student,
			tbl_mahasiswa.email_umum AS email_umum,
			tbl_mahasiswa.no_hp AS no_hp,
			tbl_mahasiswa.no_ktp AS no_ktp,
			tbl_mahasiswa.agama AS agama,
			tbl_mahasiswa.alamat AS alamat,
			tbl_mahasiswa.foto AS foto,
			tbl_mahasiswa.kode_prodi AS kode_prodi,
			tb_prodi.nama_prodi AS nama_prodi,
			tbl_mahasiswa.status AS status_akun,
			tb_prodi.status AS status_prodi
			from tb_prodi, tbl_mahasiswa where tb_prodi.kode_prodi = tbl_mahasiswa.kode_prodi AND tbl_mahasiswa.npm='$username'");
		return $row = $query->row();
	}

	function ambil_gkm($username){
		$query = $this->db->query("SELECT * from tb_prodi, tbl_gkm where tb_prodi.kode_prodi = tbl_gkm.kode_prodi AND tbl_gkm.username='$username'");
		return $row = $query->row();
	}

	function ambil_koordinator($username){
		$query = $this->db->query("SELECT * from tb_prodi, tbl_koordinator where tb_prodi.kode_prodi = tbl_koordinator.kode_prodi AND tbl_koordinator.username='$username'");
		return $row = $query->row();
	}

	function cek_prodi_untuk_dosen($kode_prodi){
		$query = $this->db->query("SELECT * from tb_prodi where kode_prodi='$kode_prodi'");
		return $row = $query->row();
	}


	function checkPrimaryKey($npk){
		$sql = "SELECT * FROM tb_dosen WHERE npk = '$npk'";
		/* Replace table_name And primary_key With Actual Table Name And Column Name */
		$query=$this->db->query($sql);
		if($query->num_rows() == 1){
			return -1; //Key already exists
		}
		else{
			return 0;  //Key does not exist
		}
	}

	function input_log($status_login, $username, $aktifitas, $aktifitas_detail){
		$query = $this->db->query("INSERT INTO tb_log (username, status_login, aktifitas, aktifitas_detail, status) VALUES ('$username', '$status_login', '$aktifitas', '$aktifitas_detail', 'Tersedia')");
		return $query;
	}

	function ambilJumlahLogin(){
		date_default_timezone_set('Asia/Jakarta');
        $tgl_sekarang = date("Y-m-d");
		$query = $this->db->query("SELECT * FROM tb_log WHERE aktifitas='Login' AND date(waktu_log)='$tgl_sekarang' AND status='Tersedia'");
		return $query->num_rows();
	}
}
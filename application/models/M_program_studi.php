<?php
class M_program_studi extends CI_Model{
	
	function show_program_studi(){
		$hasil=$this->db->query("SELECT * FROM tb_prodi WHERE status='Tersedia'");
		return $hasil;
	}

	function tambah_program_studi($kode_prodi, $nama_prodi, $jenjang, $akreditasi){
		$hasil=$this->db->query("INSERT INTO tb_prodi (kode_prodi, nama_prodi, jenjang, akreditasi, status) VALUES ('$kode_prodi','$nama_prodi', '$jenjang', '$akreditasi','Tersedia')");
		return $hasil;
	}

	function tambah_admin_program_studi($kode_prodi){
		$username= 'superadmin3'.$kode_prodi;
		$nama_lengkap = '';
		$npk ='';
		$jenis_kelamin = 'Laki-laki';
		$email = '';
		$no_hp = '';
		$jabatan = 'Ketua Program Studi';
		$hak_akses = 'Super';
		$password = password_hash("1111111111", PASSWORD_DEFAULT);
		$foto = '';
		$status_akun='Aktif';
		$hasil=$this->db->query("INSERT INTO tb_prodi_attribut (username, kode_prodi, nama_lengkap, npk, jenis_kelamin, email, no_hp, jabatan, hak_akses, password, foto, status_akun) VALUES ('$username', '$kode_prodi', '$nama_lengkap', '$npk', '$jenis_kelamin', '$email', '$no_hp', '$jabatan', '$hak_akses', '$password', '$foto', '$status_akun')");
		return $hasil;
	}

	function edit_program_studi($kode_prodi, $nama_prodi, $jenjang, $akreditasi){
		$hasil=$this->db->query("UPDATE tb_prodi SET nama_prodi='$nama_prodi', jenjang='$jenjang', akreditasi='$akreditasi' WHERE kode_prodi='$kode_prodi'");
		return $hasil;
	}

	function hapus_program_studi($kode_prodi){
		$hasil=$this->db->query("UPDATE tb_prodi SET status='Dihapus' WHERE kode_prodi='$kode_prodi'");
		return $hasil;
	}	

	function checkPrimaryKey($kode_prodi){
		$sql = "SELECT * FROM tb_prodi WHERE kode_prodi = '$kode_prodi'";
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
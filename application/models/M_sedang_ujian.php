<?php
class M_sedang_ujian extends CI_Model{
	
    function show_sedang_ujian($kode_jurusan){
    	date_default_timezone_set('Asia/Jakarta');
      	$sekarang = date("Y-m-d H:i:s");
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
            tb_jadwal_ujian_lanjutan

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
            tb_jadwal_ujian_lanjutan.id_jadwal_ujian = tb_jadwal_ujian.id_jadwal_ujian AND
            tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_ujian_lanjutan.id_jadwal_kelas_pertemuan AND

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
            tb_jadwal_ujian_lanjutan.status ='Tersedia' AND
            tb_prodi.kode_prodi = '$kode_jurusan' AND
            
            concat('$sekarang') BETWEEN concat(tanggal_ujian,' ',jam_mulai) AND concat(tanggal_ujian,' ',jam_selesai) 

            ORDER BY  
            tb_matkul.nama_mk ASC,
            tb_jadwal_kelas_pertemuan.nama_kelas ASC,
            tb_jadwal_ujian.tanggal_ujian ASC, 
            tb_jadwal_ujian.jam_mulai ASC
        ");
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

    function ambil_jumlah_mahasiswa($id_jadwal_lanjutan){
		$query = $this->db->query("SELECT * from tb_jadwal_ujian_lanjutan where id_jadwal_lanjutan='$id_jadwal_lanjutan' AND status='Tersedia'");
		return $row = $query->row();
    }
}
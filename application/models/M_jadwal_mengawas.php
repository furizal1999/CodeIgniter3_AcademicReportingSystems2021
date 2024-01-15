<?php
class M_jadwal_mengawas extends CI_Model{
	
    function show_jadwal_mengawas($kode_jurusan, $npk){
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
            ((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) OR (tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk)) AND concat('$sekarang') <= concat(tanggal_ujian,' ',jam_selesai) AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' ORDER BY tanggal_ujian ASC, jam_mulai ASC
        ");
		return $hasil;
    }

    function show_histori($kode_jurusan, $npk){
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
            ((tb_jadwal_ujian_lanjutan.npk_pengawas1=$npk) OR (tb_jadwal_ujian_lanjutan.npk_pengawas2=$npk)) AND concat('$sekarang') > concat(tanggal_ujian,' ',jam_selesai) AND tb_jadwal_ujian.status='Tersedia' AND tb_jadwal_ujian_lanjutan.status='Tersedia' ORDER BY tanggal_ujian DESC, jam_mulai DESC");
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
    
    function absensi($id_jadwal_lanjutan, $field_tanggal_absen, $field_jam_absen){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_absen = date("Y-m-d");
        $jam_absen = date("H:i:s");


        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_tanggal_absen ='$tanggal_absen', $field_jam_absen ='$jam_absen' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }

    function upload_foto_bukti($id_jadwal_lanjutan, $field, $fotobaru){
        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field='$fotobaru' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }
    
    function hapus_foto_bukti($id_jadwal_lanjutan, $field){
        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field='' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }
    
    function input_data($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_mahasiswa_hadir, $ket_pelaksanaan){
        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_mahasiswa_hadir', ket_pelaksanaan='$ket_pelaksanaan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }

    function edit_data_histori($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_mahasiswa_hadir, $ket_pelaksanaan, $field_status_verifikasi){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_sekarang = date("Y-m-d");
        $jam_sekarang = date("H:i:s");
         if($field_status_verifikasi=="status_verifikasi_pengawas1"){
            $field_status_verifikasi = "status_verifikasi_pengawas1";

            $field_tanggal_submit = "tanggal_submit_pengawas1";
            $field_tanggal_absen = "tanggal_absen_pengawas1";
            $field_jam_submit = "jam_submit_pengawas1";
            $field_jam_absen = "jam_absen_pengawas1";
            
        }else{
            $field_status_verifikasi = "status_verifikasi_pengawas2";
            
            $field_tanggal_submit = "tanggal_submit_pengawas2";
            $field_tanggal_absen = "tanggal_absen_pengawas2";
            $field_jam_submit = "jam_submit_pengawas2";
            $field_jam_absen = "jam_absen_pengawas2";
        }

        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_tanggal_absen='$tanggal_sekarang', $field_jam_absen='$jam_sekarang', $field_tanggal_submit='$tanggal_sekarang', $field_jam_submit='$jam_sekarang', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_mahasiswa_hadir', ket_pelaksanaan='$ket_pelaksanaan', $field_status_verifikasi='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");

        return $hasil;
    }

     function edit_data_histori_foto($id_jadwal_lanjutan, $jenis_soal, $media, $jumlah_mahasiswa_hadir, $ket_pelaksanaan, $field_status_verifikasi, $field_foto_bukti, $fotobaru){
        date_default_timezone_set('Asia/Jakarta');
        $sekarang = date("H:i:s");
         if($field_status_verifikasi=="status_verifikasi_pengawas1"){
            $field_status_verifikasi = "status_verifikasi_pengawas1";
            $field_jam_submit = "jam_submit_pengawas1";
        }else{
            $field_status_verifikasi = "status_verifikasi_pengawas2";
            $field_jam_submit = "jam_submit_pengawas2";
        }

        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_jam_submit='$sekarang', jenis_soal='$jenis_soal', media='$media', jumlah_mahasiswa_hadir='$jumlah_mahasiswa_hadir', ket_pelaksanaan='$ket_pelaksanaan', $field_status_verifikasi='Minta Verifikasi', $field_foto_bukti='$fotobaru' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");

        return $hasil;
    }

    function ambil_jumlah_mahasiswa($id_jadwal_lanjutan){
		$query = $this->db->query("SELECT * from tb_jadwal_ujian_lanjutan where id_jadwal_lanjutan='$id_jadwal_lanjutan' AND status='Tersedia'");
		return $row = $query->row();
    }
    
    function hapus_data($id_jadwal_lanjutan){
        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET jenis_soal='', media='', jumlah_mahasiswa_hadir='0', ket_pelaksanaan='' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }

    function submit($id_jadwal_lanjutan, $field, $field_tanggal_submit, $field_jam_submit){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_submit = date("Y-m-d");
        $jam_submit = date("H:i:s");

        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_tanggal_submit='$tanggal_submit', $field_jam_submit='$jam_submit', $field='Minta Verifikasi' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }

    function batal_submit($id_jadwal_lanjutan, $field, $field_tanggal_submit, $field_jam_submit){
        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_tanggal_submit='0000-00-00', $field_jam_submit='00:00:00', $field='' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
		return $hasil;
    }

    function upload_pengajuan($id_jadwal_lanjutan, $field_tanggal_pengajuan_terlambat, $field_jam_pengajuan_terlambat, $field_file_pengajuan_terlambat, $field_status_pengajuan_terlambat, $alasan){
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_pengajuan = date("Y-m-d");
        $jam_pengajuan = date("H:i:s");

        $hasil=$this->db->query("UPDATE tb_jadwal_ujian_lanjutan SET $field_tanggal_pengajuan_terlambat ='$tanggal_pengajuan', $field_jam_pengajuan_terlambat='$jam_pengajuan', $field_file_pengajuan_terlambat='$alasan', $field_status_pengajuan_terlambat='Minta Persetujuan' WHERE id_jadwal_lanjutan='$id_jadwal_lanjutan'");
    }
}
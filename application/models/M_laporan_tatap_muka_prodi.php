<?php
class M_laporan_tatap_muka_prodi extends CI_Model{

    function querySelect(){
        return "
            SELECT *

            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_prodi,
            tb_matkul,
            tb_dosen,
            tb_jadwal_pengampu,
            tb_jadwal_kelas_pertemuan,
            tb_tugas_pengampu

            WHERE 
            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
            tb_semester.id_semester = tb_pertemuan.id_semester AND
            tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
            tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
            tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
            tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
            tb_dosen.npk = tb_tugas_pengampu.npk_tugas AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_tugas_pengampu.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND

            tb_tahun_ajaran.status='Tersedia' AND 
            tb_semester.status = 'Tersedia' AND 
            tb_pertemuan.status='Tersedia' AND
            tb_jadwal_pengampu.status='Tersedia' AND
            tb_prodi.status = 'Tersedia' AND
            tb_matkul.status = 'Tersedia' AND
            tb_dosen.status!='Dihapus' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_tugas_pengampu.status = 'Tersedia' AND
        ";
    }
    
    function show_laporan_tatap_muka($id_pertemuan){
        $query = $this->querySelect();
        $kode_prodi = $_SESSION["kode_prodi"];
        $hasil=$this->db->query("
            $query
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_prodi.kode_prodi = '$kode_prodi'

            ORDER BY 
            tb_prodi.kode_prodi ASC, 
            tb_dosen.npk ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil;
    }

    function cekJumlahKelas($id_pertemuan, $npk){
        $kode_prodi = $_SESSION["kode_prodi"];
        $query = $this->querySelect();
        $hasil=$this->db->query("
            $query
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_dosen.npk = '$npk' AND
            tb_prodi.kode_prodi = '$kode_prodi' 

            ORDER BY tb_prodi.kode_prodi ASC, 
            tb_dosen.nama_dosen ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil->num_rows();
    }

    function cekJumlahPerKategori($id_pertemuan, $npk, $kategori_tugas){
        $kode_prodi = $_SESSION["kode_prodi"];
        $query = $this->querySelect();
        $hasil=$this->db->query("
            $query
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_dosen.npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas' AND
            tb_prodi.kode_prodi = '$kode_prodi'

            ORDER BY tb_prodi.kode_prodi ASC, 
            tb_dosen.nama_dosen ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil->num_rows();
    }

    function cekJumlahTatapMukaPerKategori($id_pertemuan, $npk, $bulan_search, $kategori_tugas){
        $query = $this->querySelect();
        $kode_prodi = $_SESSION["kode_prodi"];
        $hasil=$this->db->query("
            SELECT *

            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_jadwal_pengampu,
            tb_prodi,
            tb_matkul,
            tb_dosen,
            tb_jadwal_kelas_pertemuan,
            tb_tugas_pengampu,
            tb_presensi_pertemuan

            WHERE 
            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
            tb_semester.id_semester = tb_pertemuan.id_semester AND 
            tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
            tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
            tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
            tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
             tb_dosen.npk = tb_tugas_pengampu.npk_tugas AND
            tb_dosen.npk = tb_presensi_pertemuan.dosen_penginput_presensi AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_tugas_pengampu.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND
            tb_presensi_pertemuan.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND

            tb_tahun_ajaran.status='Tersedia' AND 
            tb_semester.status = 'Tersedia' AND 
            tb_pertemuan.status='Tersedia' AND
            tb_jadwal_pengampu.status='Tersedia' AND
            tb_prodi.status = 'Tersedia' AND
            tb_matkul.status = 'Tersedia' AND
            tb_dosen.status!='Dihapus' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_tugas_pengampu.status = 'Tersedia' AND
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_dosen.npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas' AND
            DATE_FORMAT(tb_presensi_pertemuan.waktu_pertemuan, '%Y-%m') ='$bulan_search' AND
            tb_prodi.kode_prodi = '$kode_prodi'

            ORDER BY tb_prodi.kode_prodi ASC, 
            tb_dosen.npk ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil->num_rows();
    }

    function cekJumlahSKS($kode_mk){
         $hasil=$this->db->query("SELECT * FROM tb_matkul WHERE tb_matkul.status='Tersedia'");
         if($hasil->num_rows()>0){
            $row = $hasil->row();
            if($row){
                $final = $row->sks_teori;
            }else{
                $final = 0;
            }
         }else{
            $final = 0;
         }
        return $final;
    }

    function cekPertemuan($id_pertemuan){
        $hasil=$this->db->query("
            SELECT * 
            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan 
            WHERE 
            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
            tb_semester.id_semester = tb_pertemuan.id_semester AND 

            tb_tahun_ajaran.status='Tersedia' AND 
            tb_semester.status = 'Tersedia' AND 
            tb_pertemuan.status='Tersedia' AND
            tb_pertemuan.id_pertemuan = '$id_pertemuan'
        ");
        return $hasil;
    }

    function cekJumlahKategori($id_pertemuan, $npk, $kategori_tugas){
        $query = $this->querySelect();
        $kode_prodi = $_SESSION["kode_prodi"];
        $hasil=$this->db->query("
            $query
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_dosen.npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas' AND
            tb_prodi.kode_prodi = '$kode_prodi'

            ORDER BY tb_prodi.kode_prodi ASC, 
            tb_dosen.nama_dosen ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil->num_rows();
    }

    function cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $npk, $format_time_angka){
        // $bulan = date('m',strtotime($format_time_angka));
        // echo $id_jadwal_kelas_pertemuan.' '.$npk.' '.$format_time_angka; die();
        $sql = "SELECT * FROM tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND DATE_FORMAT(waktu_pertemuan, '%Y-%m') ='$format_time_angka' AND dosen_penginput_presensi='$npk' AND status_verifikasi!='Ditolak' AND status='Tersedia' GROUP BY pertemuan_ke";
        /* Replace table_name And primary_key With Actual Table Name And Column Name */
        return $query=$this->db->query($sql)->num_rows();
    }

    function getJabatanFungsional($npk){
        $arrayVar=$this->db->query("SELECT jabatan_fungsional AS jf FROM tb_dosen_lanjutan WHERE npk='$npk' AND status='Tersedia'");

        $arrayResult = $arrayVar->result_array();
        $jumlah = $arrayVar->num_rows();
        if($jumlah==1){
            $hasil = $arrayResult[$jumlah-1]['jf'];
        }else{
            $hasil = '-';
        }

        return $hasil;
    }

    function getPendidikan($npk){
        $arrayVar=$this->db->query("SELECT pendidikan AS pdd FROM tb_dosen_lanjutan WHERE npk='$npk' AND status='Tersedia'");

        $arrayResult = $arrayVar->result_array();
        $jumlah = $arrayVar->num_rows();
        if($jumlah==1){
            $hasil = $arrayResult[$jumlah-1]['pdd'];
        }else{
            $hasil = '-';
        }
               
        return $hasil;
    }

    function getWD1(){
        $arrayVar=$this->db->query("SELECT nama AS nm FROM tb_fakultas WHERE jabatan='Wakil Dekan I' AND status='Aktif'");

        $arrayResult = $arrayVar->result_array();
        $jumlah = $arrayVar->num_rows();
        if($jumlah==1){
            $hasil = $arrayResult[$jumlah-1]['nm'];
        }else{
            $hasil = '';
        }
               
        return $hasil;
    }

    function getSemester($id_pertemuan){
        $arrayVar=$this->db->query("
                    SELECT semester AS sem 
                    FROM 
                    tb_tahun_ajaran, 
                    tb_semester, 
                    tb_pertemuan 
                    WHERE 
                    tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
                    tb_semester.id_semester = tb_pertemuan.id_semester AND 

                    tb_tahun_ajaran.status='Tersedia' AND 
                    tb_semester.status = 'Tersedia' AND 
                    tb_pertemuan.status='Tersedia' AND
                    tb_pertemuan.id_pertemuan = '$id_pertemuan'

            ");

        $arrayResult = $arrayVar->result_array();
        $jumlah = $arrayVar->num_rows();
        if($jumlah==1){
            $hasil = $arrayResult[$jumlah-1]['sem'];
        }else{
            $hasil = '';
        }
               
        return $hasil;
    }

    function getRangePertemuan($id_pertemuan){
        $hasil=$this->db->query("
                    SELECT *
                    FROM 
                    tb_tahun_ajaran, 
                    tb_semester, 
                    tb_pertemuan 
                    WHERE 
                    tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
                    tb_semester.id_semester = tb_pertemuan.id_semester AND 

                    tb_tahun_ajaran.status='Tersedia' AND 
                    tb_semester.status = 'Tersedia' AND 
                    tb_pertemuan.status='Tersedia' AND
                    tb_pertemuan.id_pertemuan = '$id_pertemuan'

            ");

        return $hasil;
    }

    function combobox_pertemuan(){
        $hasil=$this->db->query("SELECT * FROM tb_tahun_ajaran, tb_semester, tb_pertemuan WHERE tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND tb_semester.id_semester = tb_pertemuan.id_semester AND tb_tahun_ajaran.status='Tersedia' AND tb_semester.status = 'Tersedia' AND tb_pertemuan.status='Tersedia' ORDER BY tahun_ajaran DESC, semester='Ganjil'");
        return $hasil;
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


    function cekJumlahTatapMukaPerKategoriArray($id_pertemuan, $npk, $kategori_tugas){
        $query = $this->querySelect();
        $kode_prodi = $_SESSION["kode_prodi"];
        $hasil=$this->db->query("
            SELECT *

            FROM 
            tb_tahun_ajaran, 
            tb_semester, 
            tb_pertemuan,
            tb_jadwal_pengampu,
            tb_prodi,
            tb_matkul,
            tb_dosen,
            tb_jadwal_kelas_pertemuan,
            tb_tugas_pengampu

            WHERE 
            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND 
            tb_semester.id_semester = tb_pertemuan.id_semester AND 
            tb_pertemuan.id_pertemuan = tb_jadwal_pengampu.id_pertemuan AND
            tb_prodi.kode_prodi = tb_jadwal_pengampu.kode_jurusan AND
            tb_matkul.kode_jurusan = tb_prodi.kode_prodi AND
            tb_matkul.kode_mk = tb_jadwal_pengampu.kode_matkul AND
            tb_dosen.npk = tb_tugas_pengampu.npk_tugas AND
            tb_jadwal_kelas_pertemuan.id_jadwal_pengampu = tb_jadwal_pengampu.id_jadwal_pengampu AND
            tb_tugas_pengampu.id_jadwal_kelas_pertemuan = tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan AND

            tb_tahun_ajaran.status='Tersedia' AND 
            tb_semester.status = 'Tersedia' AND 
            tb_pertemuan.status='Tersedia' AND
            tb_jadwal_pengampu.status='Tersedia' AND
            tb_prodi.status = 'Tersedia' AND
            tb_matkul.status = 'Tersedia' AND
            tb_dosen.status!='Dihapus' AND
            tb_jadwal_kelas_pertemuan.status = 'Tersedia' AND
            tb_tugas_pengampu.status = 'Tersedia' AND
            
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_dosen.npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas' AND
            tb_prodi.kode_prodi = '$kode_prodi'

            ORDER BY tb_prodi.kode_prodi ASC, 
            tb_dosen.npk ASC, 
            tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,
            tb_matkul.nama_mk ASC, 
            tb_jadwal_kelas_pertemuan.nama_kelas ASC
        ");
        return $hasil;
    }


}
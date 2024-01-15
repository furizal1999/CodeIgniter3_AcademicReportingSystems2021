<?php
class M_laporan_tatap_muka extends CI_Model{

    function substring_npk(){
        if(isset($_SESSION['orderby'])){
            if($_SESSION['orderby']=="prodi"){
                $sub = 'tb_dosen.npk';
            }else{
                $sub = 'substr(tb_dosen.npk, 2)';
            }
        }else{
            $sub = 'substr(tb_dosen.npk, 2)';
        }
        return $sub;
    }

    function substring_npk2(){
        if(isset($_SESSION['orderby'])){
            if($_SESSION['orderby']=="prodi"){
                $sub = 'tb_presensi_pertemuan.dosen_penginput_presensi';
            }else{
                $sub = 'substr(tb_presensi_pertemuan.dosen_penginput_presensi, 2)';
            }
        }else{
            $sub = 'substr(tb_presensi_pertemuan.dosen_penginput_presensi, 2)';
        }
        return $sub;
    }

    function querySelect(){
        $substring_npk = $this->substring_npk();

        return "
            SELECT *, $substring_npk AS str_npk

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
            LOCATE(tb_dosen.npk, tb_jadwal_pengampu.dosen_pengampu) > 0 AND
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

    function orderby_laporan(){

        if($_SESSION['orderby']=="prodi"){
            $urut = "ORDER BY tb_prodi.kode_prodi ASC,
                     str_npk ASC,
                     tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC,";
        }elseif ($_SESSION['orderby']=="npk") {
            $urut = "ORDER BY str_npk ASC, tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC, tb_prodi.kode_prodi ASC, ";
        }else{
            $urut = "ORDER BY tb_prodi.kode_prodi ASC, str_npk ASC, tb_tugas_pengampu.kategori_tugas = 'Tugas Pokok' DESC, ";
        }

        $urut .= "tb_matkul.nama_mk ASC,
                     tb_jadwal_kelas_pertemuan.nama_kelas ASC ";
        return $urut;
    }

    function show_laporan_tatap_muka($id_pertemuan){
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            $query

            tb_pertemuan.id_pertemuan = '$id_pertemuan'

            $orderby_laporan
        ");
        return $hasil;
    }

    function cekKetersediaanJenisTugas($id_pertemuan, $npk, $jenis_tugas){
        $substring_npk = $this->substring_npk();

        $query =  "
            SELECT count(tb_jadwal_kelas_pertemuan.id_jadwal_kelas_pertemuan) AS jmlh, $substring_npk AS str_npk

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
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            $substring_npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$jenis_tugas'
        ";

        $hasil = $this->db->query($query)->row();
        if(($hasil->jmlh)>0){
          return 1;
        }else{
          return 0;
        }
    }

    function cekJumlahKelas($id_pertemuan, $npk){
        // $npk = substr($npk, 1);
        $substring_npk = $this->substring_npk();
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            $query

            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            $substring_npk = '$npk'

            $orderby_laporan
        ");
        return $hasil->num_rows();
    }

    function cekJumlahPerKategori($id_pertemuan, $npk, $kategori_tugas){
        // $npk = substr($npk, 1);
        $substring_npk = $this->substring_npk();
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            $query

            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            $substring_npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas'

            $orderby_laporan
        ");
        return $hasil->num_rows();
    }

    function cekJumlahTatapMukaPerKategori($id_pertemuan, $npk, $bulan_search, $kategori_tugas){
        // $npk = substr($npk, 1);
        $substring_npk = $this->substring_npk();
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            SELECT count(distinct tb_presensi_pertemuan.pertemuan_ke) AS jml,  $substring_npk AS str_npk

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
            $substring_npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas' AND
            DATE_FORMAT(tb_presensi_pertemuan.waktu_pertemuan, '%Y-%m') ='$bulan_search'

            $orderby_laporan

        ")->row();
        if($hasil){
            return $hasil->jml;
        }else{
            return 0;
        }
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
        // $npk = substr($npk, 1);
        $substring_npk = $this->substring_npk();
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            $query

            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            $substring_npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas'

            $orderby_laporan
        ");
        return $hasil->num_rows();
    }

    function cekJumlahPerbulan($id_jadwal_kelas_pertemuan, $npk, $format_time_angka){
        $substring_npk2 = $this->substring_npk2();
        // $bulan = date('m',strtotime($format_time_angka));
        // echo $id_jadwal_kelas_pertemuan.' '.$npk.' '.$format_time_angka; die();
        // $sql = "";
        /* Replace table_name And primary_key With Actual Table Name And Column Name */

        // return $query=$this->db->query("SELECT * FROM tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND DATE_FORMAT(waktu_pertemuan, '%Y-%m') ='$format_time_angka' AND $substring_npk2 ='$npk' AND status_verifikasi!='Ditolak' AND status='Tersedia' GROUP BY pertemuan_ke")->num_rows();
        $query=$this->db->query("SELECT count(distinct pertemuan_ke) AS jml FROM tb_presensi_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND DATE_FORMAT(waktu_pertemuan, '%Y-%m') ='$format_time_angka' AND $substring_npk2 ='$npk' AND status_verifikasi!='Ditolak' AND status='Tersedia' AND (pertemuan_ke!='8' AND pertemuan_ke!='16')")->row();
        if($query){
            return $query->jml;
        }else{
            return 0;
        }
        // return 10;

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
        // $npk = substr($npk, 1);
        $substring_npk = $this->substring_npk();
        $query = $this->querySelect();
        $orderby_laporan = $this->orderby_laporan();
        $hasil=$this->db->query("
            SELECT *, $substring_npk AS str_npk

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
            $substring_npk = '$npk' AND
            tb_tugas_pengampu.kategori_tugas = '$kategori_tugas'

            $orderby_laporan
        ");
        return $hasil;
    }


    //Rekap berkas pertemuan
    function checkKetersediaanBerkas($id_jadwal_kelas_pertemuan, $nama_berkas, $id_pertemuan){
        if($nama_berkas=="RPS" || $nama_berkas=="Kontrak Kuliah"){
            $query = $this->db->query("SELECT count(id_berkas_pertemuan) AS jml FROM tb_berkas_pertemuan WHERE id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND nama_berkas='$nama_berkas' AND status='Tersedia'")->row();
            if($query){
                if(($query->jml)<1){
                    return 0;
                }else{
                    return $query->jml;
                }
            }else{
                return 0;
            }
        }elseif($nama_berkas=="Soal UTS" || $nama_berkas=="Soal UAS" || $nama_berkas=="Nilai UTS" || $nama_berkas=="Nilai UAS"){
            if($nama_berkas=="Soal UTS"){
                $nama_berkas = "Soal Ujian";
                $nama_ujian = "Ujian Tengah Semester";
            }elseif($nama_berkas=="Soal UAS"){
                $nama_berkas = "Soal Ujian";
                $nama_ujian = "Ujian Akhir Semester";
            }elseif($nama_berkas=="Nilai UTS"){
                $nama_berkas = "Nilai Hasil Ujian";
                $nama_ujian = "Ujian Tengah Semester";
            }else{
                $nama_berkas = "Nilai Hasil Ujian";
                $nama_ujian = "Ujian Akhir Semester";
            }

            $query = $this->db->query("SELECT count(id_berkas_ujian_kelas) AS jml

            FROM
            tb_tahun_ajaran,
            tb_semester,
            tb_pertemuan,
            tb_ujian,
            tb_berkas_ujian_kelas

            WHERE
            tb_tahun_ajaran.id_tahun_ajaran = tb_semester.id_tahun_ajaran AND
            tb_ujian.id_pertemuan = tb_pertemuan.id_pertemuan AND
            tb_semester.id_semester = tb_pertemuan.id_semester AND
            tb_berkas_ujian_kelas.id_ujian = tb_ujian.id_ujian AND
          
            tb_tahun_ajaran.status='Tersedia' AND
            tb_semester.status = 'Tersedia' AND
            tb_pertemuan.status='Tersedia' AND
            tb_ujian.status='Tersedia' AND
            tb_berkas_ujian_kelas.status ='Tersedia' AND

            tb_ujian.nama_ujian = '$nama_ujian' AND
            tb_pertemuan.id_pertemuan = '$id_pertemuan' AND
            tb_berkas_ujian_kelas.id_jadwal_kelas_pertemuan='$id_jadwal_kelas_pertemuan' AND
            tb_berkas_ujian_kelas.nama_berkas='$nama_berkas'
            ")->row();
            if($query){
                if(($query->jml)<1){
                    return 0;
                }else{
                    return $query->jml;
                }
            }else{
                return 0;
            }
        }else{
            return -1;
        }
    }


}

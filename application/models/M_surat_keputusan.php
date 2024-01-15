<?php
class M_surat_keputusan extends CI_Model{

    function show_surat_keputusan(){
      // $hasil=$this->db->query("SELECT * FROM tb_surat_keputusan WHERE id_surat='1'");
    	$hasil=$this->db->query("SELECT * FROM tb_surat_keputusan WHERE status='Tersedia'");
      return $hasil;
    }

    function tambah_surat_keputusan($nomor_surat, $nama_surat, $nama_dekan, $npk, $tanggal, $ket){
     	$hasil=$this->db->query("INSERT INTO tb_surat_keputusan (nomor_surat, nama_surat, nama_dekan, npk, tanggal, ket_ujian, status) VALUES ('$nomor_surat', '$nama_surat', '$nama_dekan', '$npk', '$tanggal', '$ket', 'Tersedia')");
		return $hasil;
    }
    
    function edit_surat_keputusan($id_surat, $nomor_surat, $nama_surat, $nama_dekan, $npk, $tanggal, $ket){
      	$hasil=$this->db->query("UPDATE tb_surat_keputusan SET nomor_surat='$nomor_surat', nama_surat ='$nama_surat' , nama_dekan ='$nama_dekan' , npk ='$npk' , tanggal ='$tanggal', ket_ujian ='$ket' WHERE id_surat='$id_surat'");
		return $hasil;
    }

     function hapus_surat_keputusan($id_surat){
     	$status = "Dihapus";
      	$hasil=$this->db->query("UPDATE tb_surat_keputusan SET status='$status' WHERE id_surat='$id_surat'");
		return $hasil;
    }
}
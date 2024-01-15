<?php
class M_grafik_kuesioner_tatap_muka extends CI_Model{
	
	function show_tahun_ajaran(){
		$hasil=$this->db->query("SELECT * FROM tb_kuisioner_tatap_muka WHERE status='Tersedia' ORDER BY id_kuisioner_tatap_muka DESC;");
		return $hasil;
	}

	function getCount($jenis, $p){
		$hasil=$this->db->query("SELECT count(id_kuisioner_tatap_muka) AS jmlh FROM tb_kuisioner_tatap_muka WHERE status='Tersedia' AND $p='$jenis';")->row();
		if($hasil){
			return $hasil->jmlh;
		}else{
			return 0;
		}
	}

	function getCountAll(){
		$hasil=$this->db->query("SELECT count(id_kuisioner_tatap_muka) AS jmlh FROM tb_kuisioner_tatap_muka WHERE status='Tersedia';")->row();
		if($hasil){
			return $hasil->jmlh;
		}else{
			return 0;
		}
	}
		
}
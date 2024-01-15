<?php
class M_kuisioner_pelaporan_ujian extends CI_Model{

	function simpan_kuisioner($status_login, $npk, $statement1, $statement2, $statement3, $statement4, $statement5, $statement6, $statement7, $statement8, $statement9, $statement10){
		$hasil=$this->db->query("
			INSERT INTO tb_kuisioner 
			(
				status_login_responder,
				username_responder,
				statement1,
				statement2,
				statement3,
				statement4,
				statement5,
				statement6,
				statement7,
				statement8,
				statement9,
				statement10,
				status
			)
			VALUES
			(
				'$status_login',
				'$npk',
				'$statement1',
				'$statement2',
				'$statement3',
				'$statement4',
				'$statement5',
				'$statement6',
				'$statement7',
				'$statement8',
				'$statement9',
				'$statement10',
				'Tersedia'
			)
		");
		return $hasil;
	}

	function check_kuisioner($status_login, $npk){
		$hasil=$this->db->query("SELECT * FROM tb_kuisioner WHERE status_login_responder='$status_login' AND username_responder ='$npk' AND status='Tersedia'")->num_rows();
		return $hasil;
	}
		
}
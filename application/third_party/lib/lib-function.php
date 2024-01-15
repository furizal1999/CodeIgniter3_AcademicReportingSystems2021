<?php
/*
*Library untuk pemmbuatan aplikasi-aplikasi sederhana
*Oleh : Ahyarudin
*www.ayayayank.com
*/
require('kwt-config.php');
Class Libfunction extends KwtConfig{	

			function Terbilang($satuan){
			$huruf = array("","SATU","DUA","TIGA","EMPAT","LIMA","ENAM","TUJUH","DELAPAN","SEMBILAN","SEPULUH","SEBELAS");
			if($satuan<12)
			return " ".$huruf[$satuan];
			else if($satuan<20)
			return $this->Terbilang($satuan-10)." BELAS";
			else if($satuan<100)
			return $this->Terbilang($satuan/10)." PULUH".$this->Terbilang($satuan%10);
			elseif($satuan<200)
			return " SERATUS".$this->Terbilang($satuan-100);
			elseif($satuan<1000)
			return $this->Terbilang($satuan/100)." RATUS".$this->Terbilang($satuan%100);
			elseif($satuan<2000)
			return "SERIBU ".$this->Terbilang($satuan-1000);
			elseif($satuan<1000000)
			return $this->Terbilang($satuan/1000)." RIBU".$this->Terbilang($satuan%1000);
			elseif($satuan<1000000000)
			return $this->Terbilang($satuan/1000000)." JUTA".$this->Terbilang($satuan%1000000);
			elseif($satuan>=1000000000)
			echo "hasil terbilang tidak dapat di proses, nilai terlalu besar";
		}
		
		function Ribuan($angka){
			if($angka=='0')
		return '';
		 elseif($angka<100)
		return $angka.',-';
		else
		return number_format($angka,0,'','.').',-';
		}
		
	// 	function Tanggal($param){
	// 		$bulan=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	// 		$bln=array('JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES');
	// 		$blnRoma=array('I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII');
	// 		switch($param){
	// 			case 'tgl' : return date('d');//tanggal dengan 2 digit Angka
	// 			break;
	// 			case 'blnL' : return $bulan[date('m')-1];//nama bulan lengkap bahasa Indonesia
	// 			break;
	// 			case 'blnk' : return $bln[date('m')-1];//nama bulan singkat bahasa Indonesia
	// 			break;
	// 			case 'romawi' : return $blnRoma[date('m')-1];//bulan dalam angka romawi;
	// 			break;
	// 			case 'blnAngka' : return date('m'); // bulan dengan angka latin biasa, 2 digit;
	// 			break;
	// 			case 'THN' : return date('Y');//4 digit Tahun
	// 			break;
	// 			case 'th' : return date('y');//2 digit Tahun
	// 			break;
	// 			default: return '';
	// 			}
	// 		}
	// 	function checkDB(){
	// 		if($this->conn)
	// 			if(mysql_select_db($this->dbName))
	// 				return TRUE;
	// 			else
	// 				return FALSE;
	// 	}
	// 	function dbSetup(){
	// 			if(mysql_query('CREATE DATABASE '.$this->dbName))
	// 				echo "<b>Sukses!</b><br>Database berhasil dibuat, ";
	// 			mysql_select_db($this->dbName);

	// 			if(mysql_query("CREATE TABLE ".$this->dbName.".memodb(`kwnum` VARCHAR( 20 ) NOT NULL ,`nominal` INT NOT NULL ,`payee` VARCHAR( 25 ) NOT NULL ,`pic` VARCHAR( 25 ) NOT NULL ,`tglkw` VARCHAR( 20 ) NOT NULL ,`ktrg` TEXT NOT NULL ,PRIMARY KEY ( `kwnum` )) ",$this->conn)){
	// 				echo "Table Berhasi Dibuat<br>";
	// 			}
	// 			echo "Silakan Refresh atau tekan F5 di keyboard untuk menggunakan aplikasi <a class='btn btn-primary' href='index.html'>Refresh</a>";
	// 			mysql_close($this->conn);
	// 	}
	// 	function ConnectDB(){
	// 		if($this->conn )
	// 			mysql_select_db($this->dbName);
	// 	}
	// 	function RetriveLastKwNums(){
	// 		$LastKwNum='';
	// 		$this->ConnectDB();
	// 		$sql = 'SELECT kwnum FROM memodb';
	// 		$retval = mysql_query($sql, $this->conn);
	// 		while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
	// 			$LastKwNum =  $row['kwnum'];
	// 		}

	// 		if($LastKwNum=='')
	// 			$LastKwNum = 0;
	// 		return $LastKwNum;
	// 		mysql_close($this->conn);
	// 		}

	// 	function tambahNol($x){
	// 		$y=($x>9)?($x>99)?$x:'0'.$x:'00'.$x;
	// 		return $y;
	// 	}

	// 	function KwNums(){
	// 		$LastKwNum = explode('/',$this->RetriveLastKwNums());
	// 		//mereset nomor jika
	// 		if(count($LastKwNum)>1){
	// 		if(intval($LastKwNum[3])!=$this->Tanggal('th'))
	// 			$LastKwNum[0] = 1;
	// 		else
	// 		$LastKwNum[0]++;
	// }
	// else {$LastKwNum[0]++;}

	// 		return $this->tambahNol($LastKwNum[0]).$this->kwNumPattern;
	// 	}
	// 	function insertData($nominal, $payee, $pic,$ktrg){
	// 		//insert nomor memo terbaru
	// 		$this->ConnectDB();
	// 		$kwnums = $this->KwNums();
	// 		$tanggal = $this->Tanggal('tgl').' '.$this->Tanggal('blnL').' '.$this->Tanggal('THN');
	// 		$sql = "INSERT INTO memodb (kwnum, nominal, payee, pic, tglkw, ktrg) VALUES ('$kwnums','$nominal','$payee','$pic','$tanggal','$ktrg')";
	// 		if(! mysql_query($sql,$this->conn))
	// 			echo "gagal -> ".mysql_error();
	// 		else
	// 			echo "berhasil";
	// 	}
	// 	function fetchData($query,$mode){
	// 		$this->ConnectDB();
	// 		$sql = "SELECT * FROM memodb WHERE kwnum LIKE '%$query%' OR nominal LIKE '%$query%' OR payee LIKE '%$query%' OR tglkw LIKE '%$query%' OR ktrg LIKE '%$query%'";
	// 		$retval = mysql_query($sql, $this->conn);
	// 		//Pilih Modul Tabel atau Line
	// 		if($mode == 'tab'){
	// 		echo "<table class='arsip-hover'>";
	// 		while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)){
	// 			echo "<tr><td>".$row['kwnum']."</td><td>Rp ".$this->Ribuan($row['nominal']).
	// 			"</td><td>".$row['payee']."</td><td>".$row['tglkw']."</td><td>".$row['ktrg']."</td></tr>";
	// 		}
	// 		echo "</table>";
	// 		}
	// 		if($mode == 'line'){
	// 			while ($row = mysql_fetch_array($retval, MYSQL_ASSOC)){
	// 				echo "Nomor Kwitansi   : <h4>".$row['kwnum']."</h4>";
	// 				echo "Jumlah Uang      : ".$row['nominal']."<br>";
	// 				echo "Pembayar         : ".$row['payee']."<br>";
	// 				echo "Untuk Pembayaran : ".$row['ktrg']."<br>";
	// 				echo "Tanggal Cetak    : ".$row['tglkw']."<br>";
	// 				echo "<hr>";
	// 			}
	// 		}
	// 		mysql_close($this->conn);
	// 	}
}
?>

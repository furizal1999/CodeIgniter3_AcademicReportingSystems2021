<?php
class M_validasi extends CI_Model{

  //upm
  function getDataValidasi($id_random){
    $hasil=$this->db->query("SELECT * FROM tb_ttd_digital WHERE id_random = '$id_random' AND status_validasi='Tervalidasi' AND status='Tersedia'");
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
    
}
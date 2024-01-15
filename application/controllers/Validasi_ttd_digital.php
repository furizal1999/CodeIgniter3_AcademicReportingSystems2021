<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Validasi_ttd_digital extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_validasi');
	}

	public function cek($id_random = null)
	{
		// echo $data; die();

		$x['getDataValidasi'] = $this->m_validasi->getDataValidasi($id_random);
		$this->load->view('public/part/header');
		$this->load->view('v_validasi_ttd_digital', $x);
		unset($_SESSION['messege']);

	}

}

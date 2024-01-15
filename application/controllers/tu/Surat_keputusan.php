<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Surat_keputusan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
				//tidak dibolehkan
				
			}else{
				//dibolehkan
			}
		}

		$this->load->model('m_surat_keputusan');
		
	}

	public function index()
	{		
        $x['data']=$this->m_surat_keputusan->show_surat_keputusan();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_surat_keputusan', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_surat_keputusan(){
		if(isset($_POST['nomor_surat'])){
			$nomor_surat = addslashes ($this->input->post('nomor_surat'));
			$nama_surat = addslashes ($this->input->post('nama_surat'));
			$nama_dekan = addslashes ($this->input->post('nama_dekan'));
			$npk = addslashes ($this->input->post('npk'));
			$tanggal = addslashes ($this->input->post('tanggal'));
			$ket = addslashes ($this->input->post('ket'));
			$this->m_surat_keputusan->tambah_surat_keputusan($nomor_surat, $nama_surat, $nama_dekan, $npk, $tanggal, $ket);
			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil ditambahkan!
				</div>');
		}
		redirect('tu/surat_keputusan');
	}

	function edit_surat_keputusan(){
		if(isset($_POST['id_surat'])){
			$id_surat = addslashes ($this->input->post('id_surat'));
			$nomor_surat = addslashes ($this->input->post('nomor_surat'));
			$nama_surat = addslashes ($this->input->post('nama_surat'));
			$nama_dekan = addslashes ($this->input->post('nama_dekan'));
			$npk = addslashes ($this->input->post('npk'));
			$tanggal = addslashes ($this->input->post('tanggal'));
			$ket = addslashes ($this->input->post('ket'));
			$this->m_surat_keputusan->edit_surat_keputusan($id_surat, $nomor_surat, $nama_surat, $nama_dekan, $npk, $tanggal, $ket);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil diedit!
				</div>');
		}
		redirect('tu/surat_keputusan');
	}

	function hapus_surat_keputusan(){
		if(isset($_POST['id_surat'])){
			$id_surat = addslashes ($this->input->post('id_surat'));
			$this->m_surat_keputusan->hapus_surat_keputusan($id_surat);
			$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
		}
		redirect('tu/surat_keputusan');
	}

}

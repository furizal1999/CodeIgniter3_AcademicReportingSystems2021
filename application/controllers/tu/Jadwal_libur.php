<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_libur extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Tata Usaha')!==0 ){
				//tidak dibolehkan
				
					redirect('welcome');
			}else{
				if($_SESSION['hak_akses']!=="Super"){
					redirect('welcome');
				}else{
					//dibolehkan
				}
			}
		}
		$this->load->model('m_jadwal_libur');
	}

	public function index()
	{
        $x['data']=$this->m_jadwal_libur->show_jadwal_libur();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_jadwal_libur', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_jadwal_libur(){

		if(isset($_POST['tambah_jadwal_libur'])){
			$agenda_libur = addslashes ($this->input->post('agenda_libur'));
			$tanggal_libur_mulai = addslashes ($this->input->post('tanggal_libur_mulai'));
			$jam_libur_mulai = addslashes ($this->input->post('jam_libur_mulai'));
			$tanggal_libur_selesai = addslashes ($this->input->post('tanggal_libur_selesai'));
			$jam_libur_selesai = addslashes ($this->input->post('jam_libur_selesai'));

			$waktu_libur_mulai = $tanggal_libur_mulai.' '.$jam_libur_mulai;
			$waktu_libur_selesai = $tanggal_libur_selesai.' '.$jam_libur_selesai;

			if($tanggal_libur_mulai<=$tanggal_libur_selesai){
				
				if($this->m_jadwal_libur->tambah_jadwal_libur($waktu_libur_mulai, $waktu_libur_selesai, $agenda_libur)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal libur berhasil di tambahkan!
						</div>');
					redirect('tu/jadwal_libur');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal libur gagal ditambahkan!
						</div>');
					redirect('tu/jadwal_libur');
				}
				
				
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, waktu libur selesai tidak boleh lebih kecil dari waktu mulai!
					</div>');
				redirect('tu/jadwal_libur');
			}

			
		}else{
			redirect('tu/jadwal_libur');
		}
		
	}

	function edit_jadwal_libur(){
		if(isset($_POST['edit_jadwal_libur'])){
			$id_jadwal_libur_pertemuan = addslashes ($this->input->post('id_jadwal_libur_pertemuan'));
			$agenda_libur = addslashes ($this->input->post('agenda_libur'));
			$tanggal_libur_mulai = addslashes ($this->input->post('tanggal_libur_mulai'));
			$jam_libur_mulai = addslashes ($this->input->post('jam_libur_mulai'));
			$tanggal_libur_selesai = addslashes ($this->input->post('tanggal_libur_selesai'));
			$jam_libur_selesai = addslashes ($this->input->post('jam_libur_selesai'));

			$waktu_libur_mulai = $tanggal_libur_mulai.' '.$jam_libur_mulai;
			$waktu_libur_selesai = $tanggal_libur_selesai.' '.$jam_libur_selesai;

			if($tanggal_libur_mulai<=$tanggal_libur_selesai){
				
				if($this->m_jadwal_libur->edit_jadwal_libur($id_jadwal_libur_pertemuan, $waktu_libur_mulai, $waktu_libur_selesai, $agenda_libur)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal libur berhasil di perbaharui!
						</div>');
					redirect('tu/jadwal_libur');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal libur gagal diperbaharui!
						</div>');
					redirect('tu/jadwal_libur');
				}
				
				
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, waktu libur selesai tidak boleh lebih kecil dari waktu mulai!
					</div>');
				redirect('tu/jadwal_libur');
			}
		}else{
			redirect('tu/jadwal_libur');
		}
		
	}

	function hapus_jadwal_libur(){
		if(isset($_POST['hapus_jadwal_libur'])){
			$id_jadwal_libur_pertemuan=addslashes ($this->input->post('id_jadwal_libur_pertemuan'));
			if($this->m_jadwal_libur->hapus_jadwal_libur($id_jadwal_libur_pertemuan)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal libur berhasil dihapus!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, jadwal libur gagal dihapus!
					</div>');
			}
			
			
		}
		redirect('tu/jadwal_libur');
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Pertemuan extends CI_Controller {

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

		$this->load->model('m_pertemuan');
	}

	public function index()
	{
        $x['data']=$this->m_pertemuan->show_pertemuan();
        $x['combobox_semester']=$this->m_pertemuan->combobox_semester();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_pertemuan', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_pertemuan(){
		if(isset($_POST['id_semester'])){
			$id_semester = addslashes ($this->input->post('id_semester'));
			$jenis_pertemuan = addslashes ($this->input->post('jenis_pertemuan'));
			$tanggal_pertemuan_mulai = addslashes ($this->input->post('tanggal_pertemuan_mulai'));
			$jam_pertemuan_mulai = addslashes ($this->input->post('jam_pertemuan_mulai'));
			$tanggal_pertemuan_selesai = addslashes ($this->input->post('tanggal_pertemuan_selesai'));
			$jam_pertemuan_selesai = addslashes ($this->input->post('jam_pertemuan_selesai'));

			$waktu_pertemuan_mulai = $tanggal_pertemuan_mulai.' '.$jam_pertemuan_mulai;
			$waktu_pertemuan_selesai = $tanggal_pertemuan_selesai.' '.$jam_pertemuan_selesai;

			if($tanggal_pertemuan_mulai<$tanggal_pertemuan_selesai){
				if($this->m_pertemuan->check_ketersediaan($id_semester)!=-1){
					if($this->m_pertemuan->tambah_pertemuan($id_semester, $jenis_pertemuan, $waktu_pertemuan_mulai, $waktu_pertemuan_selesai)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil ditambahkan!
							</div>');
						redirect('tu/pertemuan');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, gagal ditambahkan!
							</div>');
						redirect('tu/pertemuan');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, data yang sama telah tersedia!
						</div>');
					redirect('tu/pertemuan');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, tanggal mulai harus lebih kecil dari tanggal selesai!
					</div>');
				redirect('tu/pertemuan');
			}
			
		}else{
			redirect('tu/pertemuan');
		}
	}

	function edit_pertemuan(){
		if(isset($_POST['id_pertemuan'])){
			$id_pertemuan = addslashes ($this->input->post('id_pertemuan'));
			$id_semester = addslashes ($this->input->post('id_semester'));
			$jenis_pertemuan = addslashes ($this->input->post('jenis_pertemuan'));
			$tanggal_pertemuan_mulai = addslashes ($this->input->post('tanggal_pertemuan_mulai'));
			$jam_pertemuan_mulai = addslashes ($this->input->post('jam_pertemuan_mulai'));
			$tanggal_pertemuan_selesai = addslashes ($this->input->post('tanggal_pertemuan_selesai'));
			$jam_pertemuan_selesai = addslashes ($this->input->post('jam_pertemuan_selesai'));

			$waktu_pertemuan_mulai = $tanggal_pertemuan_mulai.' '.$jam_pertemuan_mulai;
			$waktu_pertemuan_selesai = $tanggal_pertemuan_selesai.' '.$jam_pertemuan_selesai;

			if($tanggal_pertemuan_mulai<$tanggal_pertemuan_selesai){
				if($this->m_pertemuan->check_ketersediaan_edit($id_pertemuan, $id_semester)!=-1){
					if($this->m_pertemuan->edit_pertemuan($id_pertemuan, $id_semester, $jenis_pertemuan, $waktu_pertemuan_mulai, $waktu_pertemuan_selesai)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil diedit!
							</div>');
						redirect('tu/pertemuan');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, gagal diedit!
							</div>');
						redirect('tu/pertemuan');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, data yang sama telah tersedia!
						</div>');
					redirect('tu/pertemuan');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, tanggal mulai harus lebih kecil dari tanggal selesai!
					</div>');
				redirect('tu/pertemuan');
			}
		}else{
			redirect('tu/pertemuan');
		}
	}

	function hapus_pertemuan(){
		if(isset($_POST['id_pertemuan'])){
			$id_pertemuan=addslashes ($this->input->post('id_pertemuan'));
			$this->m_pertemuan->hapus_pertemuan($id_pertemuan);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
			redirect('tu/pertemuan');
		}else{
			redirect('tu/pertemuan');
		}
	}

}

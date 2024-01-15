<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Semester extends CI_Controller {

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

		$this->load->model('m_semester');
	}

	public function index()
	{
        $x['data']=$this->m_semester->show_semester();
        $x['combobox_tahun_ajaran']=$this->m_semester->combobox_tahun_ajaran();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_semester', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_semester(){
		if(isset($_POST['semester'])){
			$id_tahun_ajaran = addslashes ($this->input->post('id_tahun_ajaran'));
			$semester = addslashes ($this->input->post('semester'));
			if($this->m_semester->check_ketersediaan($id_tahun_ajaran, $semester)!=-1){
				if($this->m_semester->tambah_semester($id_tahun_ajaran, $semester)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil ditambahkan!
						</div>');
					redirect('tu/semester');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, gagal ditambahkan!
						</div>');
					redirect('tu/semester');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, data yang sama telah tersedia!
					</div>');
				redirect('tu/semester');
			}
			
		}else{
			redirect('tu/semester');
		}
	}

	function edit_semester(){
		if(isset($_POST['id_semester'])){
			$id_semester = addslashes ($this->input->post('id_semester'));
			$id_tahun_ajaran = addslashes ($this->input->post('id_tahun_ajaran'));
			$semester = addslashes ($this->input->post('semester'));
			if($this->m_semester->check_ketersediaan_edit($id_semester,$id_tahun_ajaran, $semester)!=-1){
				if($this->m_semester->edit_semester($id_semester, $id_tahun_ajaran, $semester)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil diedit!
						</div>');
					redirect('tu/semester');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, gagal diedit!
						</div>');
					redirect('tu/semester');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, data yang sama telah tersedia!
					</div>');
				redirect('tu/semester');
			}
		}else{
			redirect('tu/semester');
		}
	}

	function hapus_semester(){
		if(isset($_POST['id_semester'])){
			$id_semester=addslashes ($this->input->post('id_semester'));
			$this->m_semester->hapus_tahun_ajaran($id_semester);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
			redirect('tu/semester');
		}else{
			redirect('tu/semester');
		}
	}

}

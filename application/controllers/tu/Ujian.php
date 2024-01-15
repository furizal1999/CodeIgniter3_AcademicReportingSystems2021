<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Ujian extends CI_Controller {

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

		$this->load->model('m_ujian');
	}

	public function index()
	{
        $x['data']=$this->m_ujian->show_pertemuan();
        $x['combobox_pertemuan']=$this->m_ujian->combobox_pertemuan();
        $x['combobox_surat_keputusan']=$this->m_ujian->combobox_surat_keputusan();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_ujian', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_ujian(){
		if(isset($_POST['nama_ujian'])){
			$id_surat_keputusan = $this->input->post('id_surat_keputusan');
			$id_pertemuan = addslashes ($this->input->post('id_pertemuan'));
			$nama_ujian = addslashes ($this->input->post('nama_ujian'));
			$tanggal_ujian_mulai = addslashes ($this->input->post('tanggal_ujian_mulai'));
			$jam_ujian_mulai = addslashes ($this->input->post('jam_ujian_mulai'));
			$tanggal_ujian_selesai = addslashes ($this->input->post('tanggal_ujian_selesai'));
			$jam_ujian_selesai = addslashes ($this->input->post('jam_ujian_selesai'));
			
			$range_mulai_ujian = $tanggal_ujian_mulai.' '.$jam_ujian_mulai;
			$range_selesai_ujian = $tanggal_ujian_selesai.' '.$jam_ujian_selesai;
			
			// if($this->m_ujian->check_ketersediaan($id_pertemuan, $nama_ujian)!=-1){
				if($tanggal_ujian_mulai<=$tanggal_ujian_selesai){
					if($this->m_ujian->tambah_ujian($id_surat_keputusan, $id_pertemuan, $nama_ujian, $range_mulai_ujian, $range_selesai_ujian)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil ditambahkan!
							</div>');
						redirect('tu/ujian');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, gagal ditambahkan!
							</div>');
						redirect('tu/ujian');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, tanggal mulai harus lebih kecil dari atau sama dengan tanggal selesai!
						</div>');
					redirect('tu/ujian');
				}
				
			// }else{
			// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 		Maaf, data yang sama telah tersedia!
			// 		</div>');
			// 	redirect('tu/ujian');
			// }
			
		}else{
			redirect('tu/ujian');
		}
	}

	function edit_ujian(){
		if(isset($_POST['id_ujian'])){
			$id_ujian = $this->input->post('id_ujian');
			$id_surat_keputusan = $this->input->post('id_surat_keputusan');
			$id_pertemuan = addslashes ($this->input->post('id_pertemuan'));
			$nama_ujian = addslashes ($this->input->post('nama_ujian'));
			$tanggal_ujian_mulai = addslashes ($this->input->post('tanggal_ujian_mulai'));
			$jam_ujian_mulai = addslashes ($this->input->post('jam_ujian_mulai'));
			$tanggal_ujian_selesai = addslashes ($this->input->post('tanggal_ujian_selesai'));
			$jam_ujian_selesai = addslashes ($this->input->post('jam_ujian_selesai'));
			
			$range_mulai_ujian = $tanggal_ujian_mulai.' '.$jam_ujian_mulai;
			$range_selesai_ujian = $tanggal_ujian_selesai.' '.$jam_ujian_selesai;
			
			
			// if($this->m_ujian->check_ketersediaan_edit($id_ujian, $id_pertemuan, $nama_ujian)!=-1){
				if($tanggal_ujian_mulai<=$tanggal_ujian_selesai){
					if($this->m_ujian->edit_ujian($id_ujian, $id_surat_keputusan, $id_pertemuan, $nama_ujian, $range_mulai_ujian, $range_selesai_ujian)){
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Data berhasil diedit!
							</div>');
						redirect('tu/ujian');
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, gagal diedit!
							</div>');
						redirect('tu/ujian');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, tanggal mulai harus lebih kecil dari atau sama dengan tanggal selesai!
						</div>');
					redirect('tu/ujian');
				}
				
			// }else{
			// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
			// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			// 		Maaf, data yang sama telah tersedia!
			// 		</div>');
			// 	redirect('tu/ujian');
			// }
		}else{
			redirect('tu/ujian');
		}
	}

	function hapus_ujian(){
		if(isset($_POST['id_ujian'])){
			$id_ujian=addslashes ($this->input->post('id_ujian'));
			$this->m_ujian->hapus_ujian($id_ujian);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
			redirect('tu/ujian');
		}else{
			redirect('tu/ujian');
		}
	}

}

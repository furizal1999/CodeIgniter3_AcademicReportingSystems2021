<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jenis_tugas_pengampu extends CI_Controller {

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
				//dibolehkan
			}
		}

		$this->load->model('m_jenis_tugas_pengampu');
	}

	public function index()
	{
			
			if(isset($_POST['id_pertemuan'])){
				$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}


			
			$x['combobox_prodi']=$this->m_jenis_tugas_pengampu->combobox_prodi();
			$x['combobox_tahun_ajaran']=$this->m_jenis_tugas_pengampu->combobox_tahun_ajaran();
			
			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_pertemuan_search'])){

				$kode_jurusan = $_SESSION['kode_prodi'];
				$x['data']=$this->m_jenis_tugas_pengampu->show_jadwal_kelas_pertemuan($kode_jurusan,$_SESSION['id_pertemuan_search']);
				$x['combobox_kelas_terjadwal']=$this->m_jenis_tugas_pengampu->combobox_kelas_terjadwal($kode_jurusan,$_SESSION['id_pertemuan_search']);
				
				
			}
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_jenis_tugas_pengampu', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
			
	}

	function tandai_tugas_pengampu(){
		if(isset($_POST['tandai_tugas_pengampu'])){

			$value_string = addslashes ($this->input->post('value_string'));

			$value_array = explode(', ', $value_string);
			if (isset($value_array[0]) && isset($value_array[1])) {
				$id_jadwal_kelas_pertemuan = $value_array[0];
				$npk_tugas = $value_array[1];
			
			


				$kategori_tugas = addslashes ($this->input->post('kategori_tugas'));

				
				if($this->m_jenis_tugas_pengampu->insert_tandai_tugas_pengampu($id_jadwal_kelas_pertemuan, $npk_tugas, $kategori_tugas)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Pemberian kategori tugas berhasil!
						</div>');
					redirect('tu/jenis_tugas_pengampu');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Pemberian kategori tugas gagal!
						</div>');
					redirect('tu/jenis_tugas_pengampu');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Pemberian kategori tugas gagal! (2)
						</div>');
				redirect('tu/jenis_tugas_pengampu');
			}
			
			
		}else{
			redirect('tu/jenis_tugas_pengampu');
		}
	}

	function hapus_kategori_tugas(){
		if(isset($_POST['hapus_kategori_tugas'])){
			$id_tugas_pengampu = addslashes ($this->input->post('id_tugas_pengampu'));
			
			if($this->m_jenis_tugas_pengampu->hapus_kategori_tugas($id_tugas_pengampu)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Penghapusan kategori tugas berhasil!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Penghapusan kategori tugas gagal!
					</div>');
			}
			
		}
		redirect('tu/jenis_tugas_pengampu');		
	}
}

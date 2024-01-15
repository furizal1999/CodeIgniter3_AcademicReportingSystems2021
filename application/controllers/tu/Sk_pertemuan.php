<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Sk_pertemuan extends CI_Controller {

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

		$this->load->model('m_sk_pertemuan');
	}

	public function index()
	{
				if(isset($_POST['tombol_cari_pertemuan'])){
					$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
				}

				if(isset($_SESSION['id_pertemuan_search'])){
					  $x['data']=$this->m_sk_pertemuan->list_prodi($_SESSION['id_pertemuan_search']);
				}

				$x['combobox_pertemuan']=$this->m_sk_pertemuan->combobox_pertemuan();
				$this->load->view('public/part/header');
				$this->load->view('public/part/menu');
				$this->load->view('tu/v_sk_pertemuan', $x);
				$this->load->view('public/part/footer');
				unset($_SESSION['messege']);
	}

	function upload(){
		if(isset($_POST['tombol_upload_sk_pertemuan'])){

			$kode_prodi = $_POST['kode_prodi'];
			$berkas = $_FILES['berkas']['name'];
			// Rename nama fotonya dengan menambahkan tanggal dan jam upload
			$berkasbaru = date('dmYHis').$berkas;

			// Set path folder tempat menyimpan fotonya
			$path = "templates/file/user/fakultas/sk_pertemuan/".$berkasbaru;
			// memindahkan file ke temporary
			$tmp = $_FILES['berkas']['tmp_name'];

			// Proses upload
			if(move_uploaded_file($tmp, $path)){ // Cek apakah berkas berhasil diupload atau tidak
				// Proses simpan ke Database

				if($this->m_sk_pertemuan->upload($kode_prodi, $berkasbaru)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Berkas berhasil diunggah..
						</div>');
					redirect('tu/sk_pertemuan');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, input data gagal!
							</div>');
					redirect('tu/sk_pertemuan');
				}

			}else{
				// Jika berkas gagal diupload, Lakukan :
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, berkas gagal untuk diunggah!
						</div>');
				redirect('tu/sk_pertemuan');
			}

		}else{
			redirect('tu/sk_pertemuan');
		}

	}

	function hapus_berkas(){
		if(isset($_POST['tombol_hapus_sk_pertemuan'])){
			$berkaslama = addslashes ($this->input->post('berkaslama'));
			$kode_prodi = addslashes ($this->input->post('kode_prodi'));

			if($this->m_sk_pertemuan->hapus_berkas($kode_prodi)){
				unlink('templates/file/user/fakultas/sk_pertemuan/'.$berkaslama);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil dihapus!
					</div>');
				redirect('tu/sk_pertemuan');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, berkas gagal di hapus!
					</div>');
				redirect('tu/sk_pertemuan');
			}

		}else{
			redirect('tu/sk_pertemuan');
		}
	}

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Tata_tertib extends CI_Controller {

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

		$this->load->model('m_tata_tertib');
	}

	public function index()
	{
        $x['data']=$this->m_tata_tertib->show_tahun_ajaran();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_tata_tertib', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function upload(){
		if(isset($_POST['id_ujian'])){

			$id_ujian = $_POST['id_ujian'];
			$berkas = $_FILES['berkas']['name'];

			$extensionList = array("PDF", "pdf");
			$pecah = explode(".", $berkas);
			$ekstensi = $pecah[1];

			if (in_array($ekstensi, $extensionList))
			{
				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$berkasbaru = date('dmYHis').$berkas;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/file/user/fakultas/tata tertib/".$berkasbaru;
				// memindahkan file ke temporary
				$tmp = $_FILES['berkas']['tmp_name'];
			
				// Proses upload
				if(move_uploaded_file($tmp, $path)){ // Cek apakah berkas berhasil diupload atau tidak
					// Proses simpan ke Database
					
					$this->m_tata_tertib->upload($id_ujian, $berkasbaru);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Berkas berhasil diunggah..
						</div>');
					redirect('tu/tata_tertib');      
				}else{
					// Jika berkas gagal diupload, Lakukan :
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, berkas gagal untuk diunggah!
							</div>');
					redirect('tu/tata_tertib');
				}
			}
			else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, file yang diupload bukan file PDF!
				</div>');
				redirect('tu/tata_tertib');
			}	
			
		}else{
			redirect('tu/tata_tertib');
		}
	
	}

	function hapus_berkas(){
		if(isset($_POST['id_ujian'])){
			$berkaslama = addslashes ($this->input->post('berkaslama'));
			$id_ujian = addslashes ($this->input->post('id_ujian'));

			
			$update_db = $this->m_tata_tertib->hapus_berkas($id_ujian);
			if($update_db){
				unlink('templates/file/user/fakultas/tata tertib/'.$berkaslama);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil dihapus!
					</div>');
				redirect('tu/tata_tertib');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, berkas gagal di hapus!
					</div>');
				redirect('tu/tata_tertib');
			}
			
		}else{
			redirect('tu/tata_tertib');
		}
	}

}

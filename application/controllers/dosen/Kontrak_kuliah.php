<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Kontrak_kuliah extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Dosen')!==0 ){
				//tidak dibolehkan
				redirect('welcome');
			}else{
				if($_SESSION['status_jabatan']=='Dosen'){
					//dibolehkan
				}else{
					redirect('welcome');
				}
			}
		}

		$this->load->model('m_kontrak_kuliah');
	}

	public function index()
	{
		$npk = $_SESSION['npk'];
		$kode_jurusan = $_SESSION['kode_jurusan'];

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        }

        $x['combobox_pertemuan']=$this->m_kontrak_kuliah->combobox_pertemuan();

        if(isset($_SESSION['id_pertemuan_search'])){
        	$x['data']=$this->m_kontrak_kuliah->show_berkas_pertemuan($_SESSION['id_pertemuan_search'], $kode_jurusan, $npk);
        	$x['combobox_kelas_matkul']=$this->m_kontrak_kuliah->combobox_kelas_matkul($_SESSION['id_pertemuan_search'], $kode_jurusan, $npk);
        }
        $this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_kontrak_kuliah', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
			
	}

	function upload(){
		if(isset($_POST['upload_kontrak_kuliah'])){

			$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
			$berkas = $_FILES['berkas']['name'];

			
			// Rename nama fotonya dengan menambahkan tanggal dan jam upload
			$berkasbaru = date('dmYHis').$berkas;

			// Set path folder tempat menyimpan fotonya
			$path = "templates/file/user/dosen/kontrak_kuliah/".$berkasbaru;
			// memindahkan file ke temporary
			$tmp = $_FILES['berkas']['tmp_name'];
		
			// Proses upload
			if(move_uploaded_file($tmp, $path)){ // Cek apakah berkas berhasil diupload atau tidak
				// Proses simpan ke Database
				
				$this->m_kontrak_kuliah->upload($id_jadwal_kelas_pertemuan, $berkasbaru);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil diunggah..
					</div>');
				redirect('dosen/kontrak_kuliah');      
			}else{
				// Jika berkas gagal diupload, Lakukan :
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, berkas gagal untuk diunggah!
						</div>');
				redirect('dosen/kontrak_kuliah');
			}
			
			
		}else{
			redirect('dosen/kontrak_kuliah');
		}
	
	}

	function hapus_berkas(){
		if(isset($_POST['hapus_berkas_kontrak'])){
			$berkaslama = addslashes ($this->input->post('berkaslama'));
			$id_berkas_pertemuan = addslashes ($this->input->post('id_berkas_pertemuan'));

			
			$update_db = $this->m_kontrak_kuliah->hapus_berkas($id_berkas_pertemuan);
			if($update_db){
				unlink('templates/file/user/dosen/kontrak_kuliah/'.$berkaslama);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil dihapus!
					</div>');
				redirect('dosen/kontrak_kuliah');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, berkas gagal di hapus!
					</div>');
				redirect('dosen/kontrak_kuliah');
			}
			
		}else{
			redirect('dosen/kontrak_kuliah');
		}
	}

}

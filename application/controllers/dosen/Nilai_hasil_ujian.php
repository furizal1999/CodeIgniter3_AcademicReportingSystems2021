<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Nilai_hasil_ujian extends CI_Controller {

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

		$this->load->model('m_nilai_hasil_ujian');
	}

	public function index()
	{
		if(isset($_POST['id_ujian'])){
			$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
		}
		$npk = $_SESSION['npk'];
		$kode_jurusan = $_SESSION['kode_jurusan'];


        $x['combobox_ujian']=$this->m_nilai_hasil_ujian->combobox_ujian();

        if(isset($_SESSION['id_ujian_search'])){
        	$x['data']=$this->m_nilai_hasil_ujian->show_tahun_ajaran($_SESSION['id_ujian_search'], $kode_jurusan, $npk);
        	$x['combobox_kelas_diampu']=$this->m_nilai_hasil_ujian->combobox_kelas_diampu($_SESSION['id_ujian_search'], $kode_jurusan, $npk);
        }

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_nilai_hasil_ujian', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function upload(){
		if(isset($_POST['upload_berkas_soal_ujian'])){

			$id_ujian = $_POST['id_ujian'];
			$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];

			$berkas = $_FILES['berkas']['name'];

			$extensionList = array("PDF", "pdf");
			$pecah = explode(".", $berkas);
			$ekstensi = $pecah[1];

			if (in_array($ekstensi, $extensionList))
			{
				// Rename nama fotonya dengan menambahkan tanggal dan jam upload
				$berkasbaru = date('dmYHis').$berkas;

				// Set path folder tempat menyimpan fotonya
				$path = "templates/file/user/dosen/nilai_hasil_ujian/".$berkasbaru;
				// memindahkan file ke temporary
				$tmp = $_FILES['berkas']['tmp_name'];

				// Proses upload
				if(move_uploaded_file($tmp, $path)){ // Cek apakah berkas berhasil diupload atau tidak
					// Proses simpan ke Database

					$this->m_nilai_hasil_ujian->upload($id_ujian,$id_jadwal_kelas_pertemuan, $berkasbaru);
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Berkas berhasil diunggah..
						</div>');
						echo '<script type"text/javascript">';
						echo 'window.location.href="'.site_url("/dosen/nilai_hasil_ujian").'"';
						echo '</script>';
					// redirect('dosen/nilai_hasil_ujian');
				}else{
					// Jika berkas gagal diupload, Lakukan :
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, berkas gagal untuk diunggah!
							</div>');
							echo '<script type"text/javascript">';
							echo 'window.location.href="'.site_url("/dosen/nilai_hasil_ujian").'"';
							echo '</script>';

					// redirect('dosen/nilai_hasil_ujian');
				}
			}
			else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, file yang diupload bukan file PDF!
				</div>');
				redirect('dosen/nilai_hasil_ujian');
			}

		}else{
			redirect('dosen/nilai_hasil_ujian');
		}

	}

	function hapus_berkas(){
		if(isset($_POST['hapus_berkas_soal_ujian'])){
			$berkaslama = addslashes ($this->input->post('berkaslama'));
			$id_berkas_ujian_kelas = addslashes ($this->input->post('id_berkas_ujian_kelas'));


			$hasil = $this->m_nilai_hasil_ujian->hapus_berkas($id_berkas_ujian_kelas);
			if($hasil){
				// unlink('templates/file/user/dosen/nilai_hasil_ujian/'.$berkaslama);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil dihapus!
					</div>');
				redirect('dosen/nilai_hasil_ujian');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, berkas gagal di hapus!
					</div>');
				redirect('dosen/nilai_hasil_ujian');
			}

		}else{
			redirect('dosen/nilai_hasil_ujian');
		}
	}

}

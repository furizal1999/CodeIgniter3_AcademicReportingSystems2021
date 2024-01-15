<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Rps extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Dosen')!==0 ){
				//tidak dibolehkan
				
			}else{
				if($_SESSION['status_jabatan']=='Dosen'){
					//dibolehkan
				}else{
					redirect('welcome');
				}
				
			}
		}

		$this->load->model('m_rps');
	}

	public function index()
	{
		$npk = $_SESSION['npk'];
		$kode_jurusan = $_SESSION['kode_jurusan'];

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        }

        $x['combobox_pertemuan']=$this->m_rps->combobox_pertemuan();

        if(isset($_SESSION['id_pertemuan_search'])){
        	$x['data']=$this->m_rps->show_berkas_pertemuan($_SESSION['id_pertemuan_search'], $kode_jurusan, $npk);
        	$x['combobox_kelas_matkul']=$this->m_rps->combobox_kelas_matkul($_SESSION['id_pertemuan_search'], $kode_jurusan, $npk);
        }
        $this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_rps', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
			
	}

	function upload(){
		if(isset($_POST['upload_rps'])){

			$id_jadwal_kelas_pertemuan = $this->input->post('id_jadwal_kelas_pertemuan');
			$berkas = $_FILES['berkas']['name'];

			// memindahkan file ke temporary
			// $tmp = $_FILES['berkas']['tmp_name'];

			if($id_jadwal_kelas_pertemuan!=null){
				$no = 1;
				$uploaded = false;
				foreach ($id_jadwal_kelas_pertemuan as $key) :

					

			
					// Rename nama fotonya dengan menambahkan tanggal dan jam upload
					$berkasbaru = $no.'_'.$key.'_'.date('dmYHis').$berkas;

					// Set path folder tempat menyimpan fotonya
					$path = "templates/file/user/dosen/rps/".$berkasbaru;

					if ($uploaded)
				     {
				         if(copy($uploaded, $path)){
				         	 $this->m_rps->upload($key, $berkasbaru);
				         	}else{
				         		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, berkas gagal untuk diunggah pada kelas ke-'.$no.'
									</div>');
								redirect('dosen/rps');
				         	}

				     }
				     else
				     {
				         if (move_uploaded_file($_FILES["berkas"]["tmp_name"],$path))
				         {
				             
				             $this->m_rps->upload($key, $berkasbaru);
				             $uploaded = $path;
				         }else{
				         	// Jika berkas gagal diupload, Lakukan :
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, berkas gagal untuk diunggah pada kelas ke-'.$no.'
									</div>');
							redirect('dosen/rps');
				         }
				     }
					
					$no++;
				endforeach;
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil diunggah untuk semua kelas yang dipilih..
					</div>');  
				redirect('dosen/rps');
			}else{
				
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf.. Pastikan kelas anda masih tersedia dan anda memilih kelasnya terlebih dahulu!
					</div>');
				redirect('dosen/rps'); 
			}

			die();


			
		
			
			
			
		}else{
			redirect('dosen/rps');
		}
	
	}

	function hapus_berkas(){
		if(isset($_POST['hapus_berkas_rps'])){
			$berkaslama = addslashes ($this->input->post('berkaslama'));
			$id_berkas_pertemuan = addslashes ($this->input->post('id_berkas_pertemuan'));

			
			$update_db = $this->m_rps->hapus_berkas($id_berkas_pertemuan);
			if($update_db){
				unlink('templates/file/user/dosen/rps/'.$berkaslama);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Berkas berhasil dihapus!
					</div>');
				redirect('dosen/rps');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, berkas gagal di hapus!
					</div>');
				redirect('dosen/rps');
			}
			
		}else{
			redirect('dosen/rps');
		}
	}

}

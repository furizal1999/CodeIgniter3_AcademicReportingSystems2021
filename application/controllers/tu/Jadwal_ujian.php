<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_ujian extends CI_Controller {

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

		$this->load->model('m_jadwal_ujian');
	}

	public function index()
	{
			
			if(isset($_POST['id_ujian'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}


			
			$x['combobox_prodi']=$this->m_jadwal_ujian->combobox_prodi();
			$x['combobox_ujian']=$this->m_jadwal_ujian->combobox_ujian();
			
			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){
				
				$kode_jurusan = $_SESSION['kode_prodi'];
				$x['data']=$this->m_jadwal_ujian->show_jadwal_ujian($kode_jurusan,$_SESSION['id_ujian_search']);
				$x['combobox_jadwal_pengampu']=$this->m_jadwal_ujian->combobox_jadwal_pengampu($kode_jurusan,$_SESSION['id_ujian_search']);
				
			}
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_jadwal_ujian', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
			
	}

	function tambah_jadwal_ujian(){
		if(isset($_POST['tambah_jadwal_ujian'])){
			$id_ujian = addslashes ($this->input->post('id_ujian'));
			$id_jadwal_pengampu = addslashes ($this->input->post('id_jadwal_pengampu'));
			$tanggal_ujian = addslashes ($this->input->post('tanggal_ujian'));
			$jam_mulai = addslashes ($this->input->post('jam_mulai'));
			$jam_selesai = addslashes ($this->input->post('jam_selesai'));
			$jam_mulai_fiks =  date("H:i", strtotime($jam_mulai));
			$jam_selesai_fiks =  date("H:i", strtotime($jam_selesai));

			if($jam_mulai_fiks<$jam_selesai_fiks){
				if($this->m_jadwal_ujian->tambah_jadwal_ujian($id_ujian, $id_jadwal_pengampu, $tanggal_ujian, $jam_mulai_fiks, $jam_selesai_fiks)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal berhasil ditambahkan!
						</div>');
					redirect('tu/jadwal_ujian');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jadwal gagal ditambahkan!
						</div>');
					redirect('tu/jadwal_ujian');
				}
			}
			else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Jam mulai harus lebih kecil daripada jam selesai... Silahkan coba lagi!
					</div>');
				redirect('tu/jadwal_ujian');
			}
		}else{
			redirect('tu/jadwal_ujian');
		}
	}

	function hapus_jadwal_ujian(){
		if(isset($_POST['hapus_jadwal_ujian'])){
			$id_jadwal_ujian = addslashes ($this->input->post('id_jadwal_ujian'));
			
			if($this->m_jadwal_ujian->hapus_jadwal_ujian($id_jadwal_ujian)){
				// $this->m_jadwal_ujian->hapus_jadwal_ujian_lanjutan($id_jadwal);
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Jadwal berhasil hapus!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, jadwal gagal dihapus!
					</div>');
			}
		}
		redirect('tu/jadwal_ujian');		
	}

	function edit_jadwal_ujian(){
		if(isset($_POST['edit_jadwal_ujian'])){

			$id_jadwal_ujian = addslashes ($this->input->post('id_jadwal_ujian'));
		
			$tanggal_ujian = addslashes ($this->input->post('tanggal_ujian'));
			$jam_mulai = addslashes ($this->input->post('jam_mulai'));
			$jam_selesai = addslashes ($this->input->post('jam_selesai'));
			$jam_mulai_fiks =  date("H:i", strtotime($jam_mulai));
			$jam_selesai_fiks =  date("H:i", strtotime($jam_selesai));
			
			if($jam_mulai_fiks<$jam_selesai_fiks){
				
				if($this->m_jadwal_ujian->edit_jadwal_ujian($id_jadwal_ujian, $tanggal_ujian, $jam_mulai_fiks, $jam_selesai_fiks)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jadwal berhasil diedit!
						</div>');
					redirect('tu/jadwal_ujian');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jadwal gagal diedit!
						</div>');
					redirect('tu/jadwal_ujian');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, Jam mulai harus lebih kecil daripada jam selesai... Silahkan coba lagi!
					</div>');
				redirect('tu/jadwal_ujian');
			}
		}else{
			redirect('tu/jadwal_ujian');
		}
		
	}
}



















	// function tambah_jadwal_ujian_lanjutan(){
	// 	if(isset($_POST['id_jadwal'])){
	// 		$kode_jurusan = $_SESSION['kode_prodi'];
	// 		$id_jadwal = addslashes ($this->input->post('id_jadwal'));
	// 		$npk_pengawas1 = addslashes ($this->input->post('npk_pengawas1'));
	// 		$npk_pengawas2 = addslashes ($this->input->post('npk_pengawas2'));
	// 		$nama_kelas = addslashes ($this->input->post('nama_kelas'));
	// 		$jumlah_mahasiswa = addslashes ($this->input->post('jumlah_mahasiswa'));
	// 		$id_tahun_ajaran = addslashes ($this->input->post('id_tahun_ajaran'));

			
	// 		$row = $this->m_jadwal_ujian->ambil_tahun_ajaran($id_tahun_ajaran);
	// 		if($row){
	// 			$jenis_ujian = $row->jenis_ujian;
	// 		}

	// 		if($jenis_ujian=="Online"){
	// 			$kode_ruang="";
	// 		}else{
	// 			$kode_ruang = addslashes ($this->input->post('kode_ruang'));
	// 		}

			

	// 		$tanggal_ujian = addslashes ($this->input->post('tanggal_ujian'));
	// 		$jam_mulai = addslashes ($this->input->post('jam_mulai'));
	// 		$jam_selesai = addslashes ($this->input->post('jam_selesai'));

	// 		// echo $tanggal_ujian.$jam_mulai.$jam_selesai.$npk_pengawas1.$npk_pengawas2; die();
			
	// 		if($jenis_ujian=="Online"){
	// 			if($npk_pengawas1!==$npk_pengawas2){
	// 				if($this->m_jadwal_ujian->check_nama_kelas($kode_jurusan, $nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
	// 					$this->m_jadwal_ujian->tambah_jadwal_ujian_lanjutan($id_jadwal, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $nama_kelas, $jumlah_mahasiswa);
	// 					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
	// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 						Jadwal lanjutan berhasil ditambahkan!
	// 						</div>');
	// 					redirect('tu/jadwal_ujian');
	// 				}else{
	// 					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 						Maaf, nama kelas yang anda inputkan telah memiliki jadwal matakuliah diwaktu yang sama.. Silahkan perhatikan lagi!
	// 						</div>');
	// 					redirect('tu/jadwal_ujian');
	// 				}						
	// 			}
	// 			else{
	// 				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 					Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
	// 					</div>');
	// 					redirect('tu/jadwal_ujian');
	// 			}
	// 		}
	// 		else{
	// 			if($npk_pengawas1!==$npk_pengawas2){
	// 				if($this->m_jadwal_ujian->check_jadwal_pengawas1($kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
	// 					if($this->m_jadwal_ujian->check_jadwal_pengawas2($kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
	// 						if($this->m_jadwal_ujian->check_ruang($kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
	// 							$row = $this->m_jadwal_ujian->ambil_kapasitas_ruang($kode_jurusan, $kode_ruang);
	// 							if(isset($row)){
	// 								$kapasitas = $row->kapasitas;
	// 								if($jumlah_mahasiswa<=$kapasitas){
	// 									// if($this->m_jadwal_ujian->check_nama_kelas($kode_jurusan, $nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
	// 										$this->m_jadwal_ujian->tambah_jadwal_ujian_lanjutan($id_jadwal, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $nama_kelas, $jumlah_mahasiswa, $status);
	// 										$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
	// 											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 											Jadwal lanjutan berhasil ditambahkan!
	// 											</div>');
	// 										redirect('tu/jadwal_ujian');
	// 									// }else{
	// 									// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 									// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 									// 		Maaf, nama kelas yang anda inputkan telah memiliki jadwal matakuliah diwaktu yang sama.. Silahkan perhatikan lagi!
	// 									// 		</div>');
	// 									// 	redirect('tu/jadwal_ujian');
	// 									// }
										
	// 								}else{
	// 									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 										Maaf, kapasitas ruangan yang anda pilih tidak mencukupi.. Silahkan pilih ruangan yang lebih besar!
	// 										</div>');
	// 									redirect('tu/jadwal_ujian');
	// 								}
	// 							}
	// 							else{
	// 								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 									Maaf, ruangan tidak tersedia.. Silahkan pilih ruangan yang berbeda!
	// 									</div>');
	// 								redirect('tu/jadwal_ujian');
	// 							}
	// 						}else{
	// 							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 								Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
	// 								</div>');
	// 							redirect('tu/jadwal_ujian');
	// 						}
	// 					}
	// 					else {
	// 						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 							Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
	// 							</div>');
	// 						redirect('tu/jadwal_ujian');
	// 					}
	// 				}
	// 				else {
	// 					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 						Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
	// 						</div>');
	// 					redirect('tu/jadwal_ujian');
	// 				}
	// 			}
	// 			else{
	// 				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 					Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
	// 					</div>');
	// 					redirect('tu/jadwal_ujian');
	// 			}
	// 		}
	// 	}else{
	// 		redirect('tu/jadwal_ujian');
	// 	}
	// }

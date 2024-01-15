<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_ujian_lanjutan_BACKUP extends CI_Controller {

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

		$this->load->model('m_jadwal_ujian_lanjutan');
	}

	public function index()
	{
		if(isset($_SESSION['id_ujian_search']) && $_SESSION['kode_prodi']){
			if(isset($_POST['id_ujian'])){
				$_SESSION['id_ujian_search'] = $_POST['id_ujian'];
			}

			if(isset($_POST['kode_prodi'])){
				$_SESSION['kode_prodi'] = $_POST['kode_prodi'];
			}



			$x['combobox_prodi']=$this->m_jadwal_ujian_lanjutan->combobox_prodi();
			$x['combobox_ujian']=$this->m_jadwal_ujian_lanjutan->combobox_ujian();

			if(isset($_SESSION['kode_prodi']) && isset($_SESSION['id_ujian_search'])){

				$kode_jurusan = $_SESSION['kode_prodi'];

				$x['data']=$this->m_jadwal_ujian_lanjutan->show_jadwal_ujian_lanjutan($kode_jurusan,$_SESSION['id_ujian_search']);
				$x['combobox_dosen1']=$this->m_jadwal_ujian_lanjutan->combobox_dosen1($kode_jurusan);
				$x['combobox_dosen2']=$this->m_jadwal_ujian_lanjutan->combobox_dosen2($kode_jurusan);
				$x['combobox_ruang']=$this->m_jadwal_ujian_lanjutan->combobox_ruang($kode_jurusan);
				$x['showJadwalPengawas']=$this->m_jadwal_ujian_lanjutan->showJadwalPengawas($kode_jurusan);

			}
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('tu/v_jadwal_ujian_lanjutan', $x);
			$this->load->view('public/part/footer');

			unset($_SESSION['messege']);
		}else{
			echo 'Maaf, anda tidak bisa mengakses halaman jadwal ujian lanjutan ini.. silahkan kembali kehalaman jadwal ujian untuk mengakses halaman ini';
		}
	}

	function jadwalkan_pengawas_ujian(){
		if(isset($_POST['jadwalkan_pengawas'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
			$id_jadwal_ujian = $_POST['id_jadwal_ujian'];
			$jumlah_mhs_terjadwal_ujian = $_POST['jumlah_mhs_terjadwal_ujian'];
			$npk_pengawas1 = $_POST['npk_pengawas1'];
			$npk_pengawas2 = $_POST['npk_pengawas2'];
			$kode_ruang = $_POST['kode_ruang'];

			$jenis_ujian = $_POST['jenis_ujian'];
			$tanggal_ujian = $_POST['tanggal_ujian'];
			$jam_mulai = $_POST['jam_mulai'];
			$jam_selesai = $_POST['jam_selesai'];
			// echo $npk_pengawas2; die();


			if($jenis_ujian=="Luring"){
				if($npk_pengawas1!==$npk_pengawas2){
					// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas1($kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
						// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas2($kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
							// if($this->m_jadwal_ujian_lanjutan->check_ruang($kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
								if($this->m_jadwal_ujian_lanjutan->jadwalkan_pengawas_ujian($id_jadwal_ujian, $id_jadwal_kelas_pertemuan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
									$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Data berhasil ditambahkan!
										</div>');
									redirect('tu/jadwal_ujian_lanjutan');
								}else{
									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, jadwal pengawas ujian gagal ditambahkan!
										</div>');
									redirect('tu/jadwal_ujian_lanjutan');
								}
					// 		}else{
					// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 				Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
					// 				</div>');
					// 			redirect('tu/jadwal_ujian_lanjutan');
					// 		}
					// 	}else {
					// 		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 			Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
					// 			</div>');
					// 		redirect('tu/jadwal_ujian_lanjutan');
					// 	}
					// }else {
					// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 		Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
					// 		</div>');
					// 	redirect('tu/jadwal_ujian_lanjutan');
					// }
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}

			}else{
				if($this->m_jadwal_ujian_lanjutan->jadwalkan_pengawas_ujian($id_jadwal_ujian, $id_jadwal_kelas_pertemuan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil ditambahkan!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jadwal pengawas ujian gagal ditambahkan!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}
			}

		}else{
			redirect('tu/jadwal_ujian_lanjutan');
		}
	}

	function edit_pengawas_ujian(){
		if(isset($_POST['edit_pengawas'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$id_jadwal_lanjutan = $_POST['id_jadwal_lanjutan'];

			$jumlah_mhs_terjadwal_ujian = $_POST['jumlah_mhs_terjadwal_ujian'];
			$npk_pengawas1 = $_POST['npk_pengawas1'];
			$npk_pengawas2 = $_POST['npk_pengawas2'];
			$kode_ruang = $_POST['kode_ruang'];

			$jenis_ujian = $_POST['jenis_ujian'];
			$tanggal_ujian = $_POST['tanggal_ujian'];
			$jam_mulai = $_POST['jam_mulai'];
			$jam_selesai = $_POST['jam_selesai'];
			// echo $npk_pengawas2; die();


			if($jenis_ujian=="Luring"){
				if($npk_pengawas1!==$npk_pengawas2){
					// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas1($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
						// if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas2($id_jadwal_lanjutan, $kode_jurusan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
							// if($this->m_jadwal_ujian_lanjutan->check_ruang($id_jadwal_lanjutan, $kode_jurusan, $kode_ruang,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
								if($this->m_jadwal_ujian_lanjutan->edit_pengawas_ujian_luring($id_jadwal_lanjutan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $jumlah_mhs_terjadwal_ujian)){
									$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Data berhasil diedit!
										</div>');
									redirect('tu/jadwal_ujian_lanjutan');
								}else{
									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, jadwal pengawas ujian gagal diedit!
										</div>');
									redirect('tu/jadwal_ujian_lanjutan');
								}
					// 		}else{
					// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 				Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
					// 				</div>');
					// 			redirect('tu/jadwal_ujian_lanjutan');
					// 		}
					// 	}else {
					// 		$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 			Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
					// 			</div>');
					// 		redirect('tu/jadwal_ujian_lanjutan');
					// 	}
					// }else {
					// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 		Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
					// 		</div>');
					// 	redirect('tu/jadwal_ujian_lanjutan');
					// }
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}

			}else{
				if($this->m_jadwal_ujian_lanjutan->edit_pengawas_ujian_daring($id_jadwal_lanjutan, $npk_pengawas1, $jumlah_mhs_terjadwal_ujian)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil diedit!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jadwal pengawas ujian gagal diedit!
						</div>');
					redirect('tu/jadwal_ujian_lanjutan');
				}
			}

		}else{
			redirect('tu/jadwal_ujian_lanjutan');
		}
	}

	function hapus_pengawas_ujian(){
		if(isset($_POST['hapus_pengawas'])){
			$id_jadwal_lanjutan=addslashes ($this->input->post('id_jadwal_lanjutan'));
			if($this->m_jadwal_ujian_lanjutan->hapus_pengawas_ujian($id_jadwal_lanjutan)){
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Data berhasil dihapus!
					</div>');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Maaf, jadwal pengawas ujian gagal dihapus!
					</div>');
			}

		}
		redirect('tu/jadwal_ujian_lanjutan');
	}

}

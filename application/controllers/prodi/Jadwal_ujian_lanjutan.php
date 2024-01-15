<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Jadwal_ujian_lanjutan extends CI_Controller {

	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}else{
			if(strcmp($_SESSION["status_login"], 'Prodi')!==0 ){
				//tidak dibolehkan
				if(strcmp($_SESSION["status_login"], 'Fakultas')==0){
					redirect('welcome');
				}else{
					redirect('welcome');
				}
			}else{
				//dibolehkan
			}
		}

		$this->load->model('m_jadwal_ujian_lanjutan');
	}

	public function index()
	{
		if(isset($_POST['tombol_cari']) || isset($_SESSION['id_tahun_ajaran_search'])){
			
			if(isset($_POST['tombol_cari'])){
				$_SESSION['id_tahun_ajaran_search'] = $_POST['id_tahun_ajaran'];
			}

			$kode_jurusan = $_SESSION['kode_prodi'];

			$x['data']=$this->m_jadwal_ujian_lanjutan->show_jadwal_ujian_lanjutan($kode_jurusan, $_SESSION['id_tahun_ajaran_search']);
			$x['combobox_ruang']=$this->m_jadwal_ujian_lanjutan->combobox_ruang($kode_jurusan);
			$x['combobox_dosen1']=$this->m_jadwal_ujian_lanjutan->combobox_dosen1($kode_jurusan);
			$x['combobox_dosen2']=$this->m_jadwal_ujian_lanjutan->combobox_dosen2($kode_jurusan);
			$this->load->view('public/part/header');
			$this->load->view('public/part/menu');
			$this->load->view('prodi/v_jadwal_ujian_lanjutan', $x);
			$this->load->view('public/part/footer');
			unset($_SESSION['messege']);
				
			}else{
				redirect('prodi/jadwal_ujian_lanjutan_search');
			}
	}

	function edit_jadwal_ujian_lanjutan(){
		if(isset($_POST['jenis_ujian'])){
			$kode_jurusan = $_SESSION['kode_prodi'];
			$tanggal_ujian = addslashes ($this->input->post('tanggal_ujian'));
			$jam_mulai = addslashes ($this->input->post('jam_mulai'));
			$jam_selesai = addslashes ($this->input->post('jam_selesai'));
			$jenis_ujian = addslashes ($this->input->post('jenis_ujian'));
			if($jenis_ujian=="Online"){
				$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
				$npk_pengawas1 = addslashes ($this->input->post('npk_pengawas1'));
				$nama_kelas = addslashes ($this->input->post('nama_kelas'));
				$jumlah_mahasiswa = addslashes ($this->input->post('jumlah_mahasiswa'));

				if($this->m_jadwal_ujian_lanjutan->check_nama_kelas($id_jadwal_lanjutan, $nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
					$this->m_jadwal_ujian_lanjutan->edit_online($id_jadwal_lanjutan, $npk_pengawas1, $nama_kelas, $jumlah_mahasiswa);
					$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Data berhasil diedit!
						</div>');
					redirect('prodi/jadwal_ujian_lanjutan');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, nama kelas yang anda inputkan telah memiliki jadwal matakuliah diwaktu yang sama.. Silahkan perhatikan lagi!
						</div>');
					redirect('prodi/jadwal_ujian_lanjutan');
				}
			}
			else{
				$id_jadwal_lanjutan = addslashes ($this->input->post('id_jadwal_lanjutan'));
				$npk_pengawas1 = addslashes ($this->input->post('npk_pengawas1'));
				$nama_kelas = addslashes ($this->input->post('nama_kelas'));
				$jumlah_mahasiswa = addslashes ($this->input->post('jumlah_mahasiswa'));
				$npk_pengawas2 = addslashes ($this->input->post('npk_pengawas2'));
				$kode_ruang = addslashes ($this->input->post('kode_ruang'));

				if($npk_pengawas1!==$npk_pengawas2){
					if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas1($kode_jurusan, $id_jadwal_lanjutan, $npk_pengawas1,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
						if($this->m_jadwal_ujian_lanjutan->check_jadwal_pengawas2($kode_jurusan, $id_jadwal_lanjutan, $npk_pengawas2,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
							if($this->m_jadwal_ujian_lanjutan->check_ruang($kode_jurusan, $id_jadwal_lanjutan, $kode_ruang, $tanggal_ujian, $jam_mulai, $jam_selesai)==0){
								$row = $this->m_jadwal_ujian_lanjutan->ambil_kapasitas_ruang($kode_jurusan, $kode_ruang);
								if(isset($row)){
									$kapasitas = $row->kapasitas;
									if($jumlah_mahasiswa<=$kapasitas){
										// if($this->m_jadwal_ujian_lanjutan->check_nama_kelas($id_jadwal_lanjutan, $nama_kelas,$tanggal_ujian, $jam_mulai, $jam_selesai)==0){
											$this->m_jadwal_ujian_lanjutan->edit_offline($id_jadwal_lanjutan, $npk_pengawas1, $npk_pengawas2, $kode_ruang, $nama_kelas, $jumlah_mahasiswa);
											$this->session->set_flashdata('messege','<div class="alert alert-warning alert-dismissible" role="alert">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												Data berhasil diedit!
												</div>');
											redirect('prodi/jadwal_ujian_lanjutan');
										// }else{
										// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										// 		Maaf, nama kelas yang anda inputkan telah memiliki jadwal matakuliah diwaktu yang sama.. Silahkan perhatikan lagi!
										// 		</div>');
										// 	redirect('prodi/jadwal_ujian_lanjutan');
										// }										
									}else{
										$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
											<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											Maaf, kapasitas ruangan yang anda pilih tidak mencukupi.. Silahkan pilih ruangan yang lebih besar!
											</div>');
										redirect('prodi/jadwal_ujian_lanjutan');
									}
								}
								else{
									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Maaf, ruangan tidak tersedia.. Silahkan pilih ruangan yang berbeda!
										</div>');
									redirect('prodi/jadwal_ujian_lanjutan');
								}
							}else{
								$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, ruangan telah digunakan di jadwal lain pada jam yang sama.. Silahkan pilih ruangan yang berbeda!
									</div>');
								redirect('prodi/jadwal_ujian_lanjutan');
							}
						}
						else {
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, pengawas 2 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
								</div>');
							redirect('prodi/jadwal_ujian_lanjutan');
						}
					}
					else {
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Maaf, pengawas 1 telah memiliki jadwal yang lain pada waktu yang sama.. Silahkan pilih pengawas yang berbeda!
							</div>');
						redirect('prodi/jadwal_ujian_lanjutan');
					}
				}
				else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, Pengawas 1 dan pengawas 2 tidak boleh dosen yang sama... Silahkan coba lagi!
						</div>');
						redirect('prodi/jadwal_ujian_lanjutan');
				}
			}
		}else{
			redirect('prodi/jadwal_ujian_lanjutan');
		}
	}

	function hapus_jadwal_ujian_lanjutan(){
		if(isset($_POST['id_jadwal_lanjutan'])){
			$id_jadwal_lanjutan=addslashes ($this->input->post('id_jadwal_lanjutan'));
			$this->m_jadwal_ujian_lanjutan->hapus_jadwal_ujian_lanjutan($id_jadwal_lanjutan);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
		}
		redirect('prodi/jadwal_ujian_lanjutan');
	}

}

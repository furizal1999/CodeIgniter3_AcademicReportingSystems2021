<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Presensi_pertemuan extends CI_Controller {

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
		$this->load->helper(array('url'));
		$this->load->library('ciqrcode');
		// $this->load->library('PDF_MC_Table');

        $this->load->library('pdfgenerator');
		$this->load->model('m_presensi_pertemuan');
	}

	public function index()
	{
		$npk = $_SESSION['npk'];
		$kode_jurusan = $_SESSION['kode_jurusan'];

		if(isset($_POST['tombol_cari_tahun_ajaran'])){
        	$_SESSION['id_pertemuan_search'] = $_POST['id_pertemuan'];
        }

        if(isset($_SESSION['id_pertemuan_search'])){
        	$x['data']=$this->m_presensi_pertemuan->show_kelas_diampu($_SESSION['id_pertemuan_search'], $kode_jurusan, $npk);

        }

        $x['combobox_ruang']=$this->m_presensi_pertemuan->combobox_ruang($kode_jurusan);
        $x['combobox_pertemuan']=$this->m_presensi_pertemuan->combobox_pertemuan();

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('dosen/v_presensi_pertemuan', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function presensi(){
		if(isset($_POST['presensi'])){
	
			$dosen_penginput_presensi = $_SESSION['npk'];
	
			$jenis_pertemuan = $_POST['jenis_pertemuan'];
			$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
			$nama_mk = $_POST['nama_mk'];
			$semester = $_POST['semester'];
			if($semester=="PILIHAN"){
				$semester = "Ganjil dan Genap (Pilihan)";
			}else{
				if($semester%2==1){
					$semester = 'Ganjil';
				}else{
					$semester = 'Genap';
				}
			}
			
			$tahun_ajaran = $_POST['tahun_ajaran'];
			$pertemuan_ke = $_POST['pertemuan_ke'];
			$tanggal_pertemuan_mulai = $_POST['tanggal_pertemuan_mulai'];
			$jam_pertemuan_mulai = $_POST['jam_pertemuan_mulai'];
			$tanggal_pertemuan_selesai = $_POST['tanggal_pertemuan_selesai'];
			$jam_pertemuan_selesai = $_POST['jam_pertemuan_selesai'];
			$jam_pertemuan_mulai_fiks =  date("H:i:s", strtotime($jam_pertemuan_mulai));
			$jam_pertemuan_selesai_fiks =  date("H:i:s", strtotime($jam_pertemuan_selesai));
			$kode_ruang = $_POST['kode_ruang'];
			$mhs_hadir = $_POST['mhs_hadir'];
	
			$materi = addslashes ($this->input->post('materi'));
			$metode = addslashes ($this->input->post('metode'));
	
			$media = $this->input->post('media');
			if($media!=null){
				$media2= implode(", ", $media);
			}else{
				$media2 = $media;
			}
	
	
			$nama_foto = $_FILES['foto_bukti_pertemuan']['name'];
			$tmp = $_FILES['foto_bukti_pertemuan']['tmp_name'];
	
			$nama_fotobaru = $_SESSION['npk'].date('dmYHis').$nama_foto;
	
			// Set path folder tempat menyimpan fotonya
			$path = "templates/img/bukti-pertemuan/".$nama_fotobaru;
	
			if(move_uploaded_file($tmp, $path)){
				if($id_terakhir = $this->m_presensi_pertemuan->presensi($id_jadwal_kelas_pertemuan, $pertemuan_ke, $tanggal_pertemuan_mulai, $jam_pertemuan_mulai_fiks, $tanggal_pertemuan_selesai, $jam_pertemuan_selesai_fiks, $kode_ruang, $materi, $metode, $mhs_hadir, $media2, $nama_fotobaru, $dosen_penginput_presensi)){
						if($this->m_presensi_pertemuan->insert_ttd($id_terakhir, $pertemuan_ke, $nama_mk, $semester, $tahun_ajaran)){
							$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Presensi berhasil diisi dan silahkan tunggu verifikasi dari admin prodi!
								</div>');
							redirect('dosen/presensi_pertemuan');
						}else{
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Ttd gagal diisi..!
								</div>');
							redirect('dosen/presensi_pertemuan');
						}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Presensi gagal diisi.. Silahkan coba lagi!
						</div>');
					redirect('dosen/presensi_pertemuan');
				 }
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Foto bukti gagal diupload..
					</div>');
				redirect('dosen/presensi_pertemuan');
			}
	
		}else{
			redirect('dosen/presensi_pertemuan');
		}
	
	}

	// function presensi(){
	// 	if(isset($_POST['presensi'])){

	// 		$dosen_penginput_presensi = $_SESSION['npk'];

	// 		$jenis_pertemuan = $_POST['jenis_pertemuan'];
	// 		$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
	// 		$nama_mk = $_POST['nama_mk'];
	// 		$semester = $_POST['semester'];

	// 		if($semester%2==1){
	// 			$semester = 'Ganjil';
	// 		}else{
	// 			$semester = 'Genap';
	// 		}

	// 		$tahun_ajaran = $_POST['tahun_ajaran'];
	// 		$pertemuan_ke = $_POST['pertemuan_ke'];
	// 		$tanggal_pertemuan_mulai = $_POST['tanggal_pertemuan_mulai'];
	// 		$jam_pertemuan_mulai = $_POST['jam_pertemuan_mulai'];
	// 		$tanggal_pertemuan_selesai = $_POST['tanggal_pertemuan_selesai'];
	// 		$jam_pertemuan_selesai = $_POST['jam_pertemuan_selesai'];
	// 		$jam_pertemuan_mulai_fiks =  date("H:i:s", strtotime($jam_pertemuan_mulai));
	// 		$jam_pertemuan_selesai_fiks =  date("H:i:s", strtotime($jam_pertemuan_selesai));
	// 		$kode_ruang = $_POST['kode_ruang'];
	// 		$mhs_hadir = $_POST['mhs_hadir'];

	// 		$materi = addslashes ($this->input->post('materi'));
	// 		$metode = addslashes ($this->input->post('metode'));

	// 		$media = $this->input->post('media');
	// 		if($media!=null){
	// 			$media2= implode(", ", $media);
	// 		}else{
	// 			$media2 = $media;
	// 		}



	// 		$nama_fotobaru = '';

	// 		if($id_terakhir = $this->m_presensi_pertemuan->presensi($id_jadwal_kelas_pertemuan, $pertemuan_ke, $tanggal_pertemuan_mulai, $jam_pertemuan_mulai_fiks, $tanggal_pertemuan_selesai, $jam_pertemuan_selesai_fiks, $kode_ruang, $materi, $metode, $mhs_hadir, $media2, $nama_fotobaru, $dosen_penginput_presensi)){
	// 				if($this->m_presensi_pertemuan->insert_ttd($id_terakhir, $pertemuan_ke, $nama_mk, $semester, $tahun_ajaran)){
	// 					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
	// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 						Presensi berhasil diisi dan silahkan tunggu verifikasi dari admin prodi!
	// 						</div>');
	// 					redirect('dosen/presensi_pertemuan');
	// 				}else{
	// 					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 						Ttd gagal diisi..!
	// 						</div>');
	// 					redirect('dosen/presensi_pertemuan');
	// 				}
	// 		}else{
	// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 				Presensi gagal diisi.. Silahkan coba lagi!
	// 				</div>');
	// 			redirect('dosen/presensi_pertemuan');
	// 		 }

	// 	}else{
	// 		redirect('dosen/presensi_pertemuan');
	// 	}

	// }

	function edit_presensi(){
		if(isset($_POST['edit_presensi'])){
	
			$id_presensi_pertemuan = $_POST['id_presensi_pertemuan'];
			$kode_ruang = $_POST['kode_ruang'];
			$materi = addslashes ($this->input->post('materi'));
			$metode = addslashes ($this->input->post('metode'));
			// $materi = $_POST['materi'];
			// $metode = $_POST['metode'];
			$mhs_hadir = $_POST['mhs_hadir'];
			$foto_lama = $_POST['foto_lama'];
			if($this->input->post('media')!=null){
				$media = $this->input->post('media');
				$media2= implode(", ", $media);
			}else{
				$media2= "";
			}
			
	
			$nama_foto = $_FILES['foto_bukti_pertemuan']['name'];
			if(empty($nama_foto)){
	
	
				if($this->m_presensi_pertemuan->edit_presensi_nophoto($id_presensi_pertemuan, $kode_ruang, $materi, $metode, $mhs_hadir, $media2)){
					$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Presensi berhasil di perbaharui, silahkan tunggu verifikasi dari admin prodi!
						</div>');
					redirect('dosen/presensi_pertemuan');
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Presensi gagal di perbaharui..
						</div>');
					redirect('dosen/presensi_pertemuan');
				 }
			}else{
				$tmp = $_FILES['foto_bukti_pertemuan']['tmp_name'];
	
				$nama_fotobaru = $_SESSION['npk'].date('dmYHis').$nama_foto;
	
				// Set path folder tempat menyimpan fotonya
				$path = "templates/img/bukti-pertemuan/".$nama_fotobaru;
				if(move_uploaded_file($tmp, $path)){
					if($this->m_presensi_pertemuan->edit_presensi_photo($id_presensi_pertemuan, $kode_ruang, $materi, $metode, $mhs_hadir, $media2, $nama_fotobaru)){
	
						unlink('templates/img/bukti-pertemuan/'.$foto_lama);
	
						$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Presensi berhasil di perbaharui, silahkan tunggu verifikasi dari admin prodi!
						</div>');
						redirect('dosen/presensi_pertemuan');
	
	
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Presensi gagal di perbaharui..
							</div>');
						redirect('dosen/presensi_pertemuan');
					 }
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, foto bukti terbaru anda gagal di upload!
						</div>');
					redirect('dosen/presensi_pertemuan');
				}
			}
	
		}else{
			redirect('dosen/presensi_pertemuan');
		}

	// 	function edit_presensi(){
	// 		if(isset($_POST['edit_presensi'])){

	// 			$id_presensi_pertemuan = $_POST['id_presensi_pertemuan'];
	// 			$kode_ruang = $_POST['kode_ruang'];
	// 			$materi = addslashes ($this->input->post('materi'));
	// 			$metode = addslashes ($this->input->post('metode'));
	// 			// $materi = $_POST['materi'];
	// 			// $metode = $_POST['metode'];
	// 			$mhs_hadir = $_POST['mhs_hadir'];
	// 			$foto_lama = $_POST['foto_lama'];
	// 			$media = $this->input->post('media');
	// 			$media2= implode(", ", $media);



	// 			if($this->m_presensi_pertemuan->edit_presensi_nophoto($id_presensi_pertemuan, $kode_ruang, $materi, $metode, $mhs_hadir, $media2)){
	// 				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
	// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 					Presensi berhasil di perbaharui, silahkan tunggu verifikasi dari admin prodi!
	// 					</div>');
	// 				redirect('dosen/presensi_pertemuan');
	// 			}else{
	// 				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 					Presensi gagal di perbaharui..
	// 					</div>');
	// 				redirect('dosen/presensi_pertemuan');
	// 			}
	// 		}else{
	// 			redirect('dosen/presensi_pertemuan');
	// 		}

	}

	// function hapus_presensi(){
	// 	if(isset($_POST['hapus_presensi'])){
	// 		$id_presensi_pertemuan = addslashes ($this->input->post('id_presensi_pertemuan'));



	// 		if($this->m_presensi_pertemuan->hapus_presensi($id_presensi_pertemuan)){
	// 			unlink('templates/file/user/dosen/presensi_pertemuan/'.$berkaslama);
	// 			$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 				Presensi berhasil dihapus
	// 				</div>');
	// 			redirect('dosen/presensi_pertemuan');
	// 		}else{
	// 			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
	// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	// 				Maaf, Presensi gagal dihapus
	// 				</div>');
	// 			redirect('dosen/presensi_pertemuan');
	// 		}

	// 	}else{
	// 		redirect('dosen/presensi_pertemuan');
	// 	}
	// }

	function ajukan_request_pertemuan(){
		if(isset($_POST['ajukan'])){
			date_default_timezone_set('Asia/Jakarta');
    		$now = date("Y-m-d");

    		$dosen_penginput_request = $_SESSION['npk'];

    		$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
			$pertemuan_ke = $_POST['pertemuan_ke'];
			$tanggal_pertemuan = $_POST['tanggal_pertemuan'];
			// echo substr($tanggal_pertemuan, 7,1); die();
			$bulan =  date("m", strtotime($tanggal_pertemuan));
			$jam_pertemuan_mulai = $_POST['jam_pertemuan_mulai'];
			$jam_pertemuan_selesai = $_POST['jam_pertemuan_selesai'];

			$jam_pertemuan_mulai_fiks =  date("H:i:s", strtotime($jam_pertemuan_mulai));
			$jam_pertemuan_selesai_fiks =  date("H:i:s", strtotime($jam_pertemuan_selesai));
			$alasan =  addslashes ($this->input->post('alasan'));

			if(strlen($tanggal_pertemuan)==10 && substr($tanggal_pertemuan, 4,1)=="-" && substr($tanggal_pertemuan, 7,1)){
				if($jam_pertemuan_mulai_fiks<$jam_pertemuan_selesai_fiks){
					// if($this->m_presensi_pertemuan->cekHariLibur($tanggal_pertemuan, $jam_pertemuan_fiks)==0){
						// if($this->m_presensi_pertemuan->cekJumlahPengajuanPerbulan($id_jadwal_kelas_pertemuan, $bulan)==0){
							if($now<=$tanggal_pertemuan){
				    			if($this->m_presensi_pertemuan->ajukan_request_pertemuan($id_jadwal_kelas_pertemuan, $dosen_penginput_request, $pertemuan_ke, $tanggal_pertemuan, $jam_pertemuan_mulai_fiks, $jam_pertemuan_selesai_fiks, $alasan)){
									$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Pengajuan ganti pertemuan berhasil dilakukan.. Pengajuan ini sekarang tidak membutuhkan konfirmasi dari prodi, namun tetap dapat dipantau oleh prodi.. Anda sudah dapat langsung melakukan presensi pada jadwal yang anda ajukan.
										</div>');
									redirect('dosen/presensi_pertemuan');
								}else{
									$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										Pengajuan pergantian pertemuan gagal dilakukan!
										</div>');
									redirect('dosen/presensi_pertemuan');
								 }
				    		}else{
				    			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									Maaf, tanggal yang diajukan minimal untuk hari ini (hari yang sama)..
									</div>');
								redirect('dosen/presensi_pertemuan');
				    		}
						// }else{
						// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						// 		Maaf, jumlah jadwal ganti anda pada bulan yang diajukan telah lebih dari 2 kali!
						// 		</div>');
						// 	redirect('dosen/presensi_pertemuan');
						// }
					// }else{
					// 	$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					// 		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					// 		Maaf, Tanggal yang anda ajukan adalah hari libur!
					// 		</div>');
					// 	redirect('dosen/presensi_pertemuan');

		   //  		}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, jam mulai harus lebih kecil dari jam selesai!
						</div>');
					redirect('dosen/presensi_pertemuan');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Maaf, format tanggal yang anda masukkan salah! (format benar: mm/dd/yyyy contoh : 10/30/2021)
						</div>');
			}


		}else{
			redirect('dosen/presensi_pertemuan');
		}

	}

	function batal_jadwal_ganti(){
		if(isset($_POST['batal_ajukan'])){
			$id_jadwal_kelas_pertemuan = $_POST['id_jadwal_kelas_pertemuan'];
			$pertemuan_ke = $_POST['pertemuan_ke'];

			if($this->m_presensi_pertemuan->batal_jadwal_ganti($id_jadwal_kelas_pertemuan, $pertemuan_ke)){
				$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Pengajuan jadwal ganti berhasil dibatalkan!
					</div>');
				redirect('dosen/presensi_pertemuan');
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Pembatalan pengajuan jadwal ganti gagal dilakukan!
					</div>');
				redirect('dosen/presensi_pertemuan');
			 }
			}else{
				redirect('dosen/presensi_pertemuan');
			}

	}

	function cetak_laporan_pertemuan($id_jadwal_kelas_pertemuan=null)
    {



       $this->data['id_jadwal_kelas_pertemuan'] = $id_jadwal_kelas_pertemuan;
       // $this->data

        // filename dari pdf ketika didownload
        $file_pdf = 'Monitoring Kehadiran Pengampu';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('dosen/v_cetak_laporan_pertemuan',$this->data, true);


        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf,$paper,$orientation);
        unlink("templates/img/qrcode/qrcode".$id_jadwal_kelas_pertemuan.".png");

    }

	function load_modal_detail()
    {
        // $user=$this->ajaxmodal_model->userGetById(array($this->input->post('id')));
        ?>


		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Understood</button>
			</div>
			</div>
		</div>
		</div>
        <?php
    }

}

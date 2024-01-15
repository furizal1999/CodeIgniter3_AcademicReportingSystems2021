<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Tahun_ajaran extends CI_Controller {

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

		$this->load->model('m_tahun_ajaran');
	}

	public function index()
	{
        $x['data']=$this->m_tahun_ajaran->show_tahun_ajaran();
		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('tu/v_tahun_ajaran', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	function tambah_tahun_ajaran(){
		if(isset($_POST['tahun_awal'])){
			$tahun_awal = addslashes ($this->input->post('tahun_awal'));
			$tahun_akhir = addslashes ($this->input->post('tahun_akhir'));

			if($tahun_akhir>=0 && $tahun_awal>=0){
				if(strlen($tahun_awal)==4 && strlen($tahun_akhir)==4){
					if(($tahun_akhir-$tahun_awal)==1){
						$tahun_ajaran = $tahun_awal.'/'.$tahun_akhir;
						if($this->m_tahun_ajaran->check_ketersediaan($tahun_ajaran)==-1){
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, data yang sama tersedia... Silahkan cek kembali!
								</div>');
							redirect('tu/tahun_ajaran');
						}
						else {
							$this->m_tahun_ajaran->tambah_tahun_ajaran($tahun_ajaran);
							$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Data berhasil ditambahkan!
								</div>');
							redirect('tu/tahun_ajaran');
						}
						
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Inputan tahun awal dan tahun akhir harus berurutan... contoh : 2021/2022
							</div>');
						redirect('tu/tahun_ajaran');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jumlah inputan karakter tahun harus 4 karakter... contoh : 2020
						</div>');
					redirect('tu/tahun_ajaran');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Inputan tahun tidak boleh negatif...
					</div>');
				redirect('tu/tahun_ajaran');
			}
		}else{
			redirect('tu/tahun_ajaran');
		}
	}

	function edit_tahun_ajaran(){
		if(isset($_POST['id_tahun_ajaran'])){
			$id_tahun_ajaran = addslashes ($this->input->post('id_tahun_ajaran'));
			$tahun_awal = addslashes ($this->input->post('tahun_awal'));
			$tahun_akhir = addslashes ($this->input->post('tahun_akhir'));

			if($tahun_akhir>=0 && $tahun_awal>=0){
				if(strlen($tahun_awal)==4 && strlen($tahun_akhir)==4){
					if(($tahun_akhir-$tahun_awal)==1){
						$tahun_ajaran = $tahun_awal.'/'.$tahun_akhir;
						if($this->m_tahun_ajaran->check_ketersediaan_edit($id_tahun_ajaran, $tahun_ajaran)==-1){
							$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Maaf, data yang sama tersedia... Silahkan cek kembali!
								</div>');
							redirect('tu/tahun_ajaran');
						}
						else {
							$this->m_tahun_ajaran->edit_tahun_ajaran($id_tahun_ajaran, $tahun_ajaran);
							$this->session->set_flashdata('messege','<div class="alert alert-success alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								Data berhasil diedit!
								</div>');
							redirect('tu/tahun_ajaran');
						}
						
					}else{
						$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							Inputan tahun awal dan tahun akhir harus berurutan... contoh : 2021/2022
							</div>');
						redirect('tu/tahun_ajaran');
					}
				}else{
					$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						Jumlah inputan karakter tahun harus 4 karakter... contoh : 2020
						</div>');
					redirect('tu/tahun_ajaran');
				}
			}else{
				$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Inputan tahun tidak boleh negatif...
					</div>');
				redirect('tu/tahun_ajaran');
			}
		}else{
			redirect('tu/tahun_ajaran');
		}
	}

	function hapus_tahun_ajaran(){
		if(isset($_POST['id_tahun_ajaran'])){
			$id_tahun_ajaran=addslashes ($this->input->post('id_tahun_ajaran'));
			$this->m_tahun_ajaran->hapus_tahun_ajaran($id_tahun_ajaran);
			$this->session->set_flashdata('messege','<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				Data berhasil dihapus!
				</div>');
			redirect('tu/tahun_ajaran');
		}else{
			redirect('tu/tahun_ajaran');
		}
	}

}

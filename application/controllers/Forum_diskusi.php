<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

#[AllowDynamicProperties]
class Forum_diskusi extends CI_controller{
	function __construct(){
		parent::__construct();
		//CEK SESSION
		if((!isset($_SESSION['login_smpu']))){
			redirect('halaman_tamu');
		}

		$this->load->model('m_forum_diskusi');
	}

	public function index()
	{
		
        $x['data_forum_diskusi']=$this->m_forum_diskusi->data_forum_diskusi();

		$this->load->view('public/part/header');
		$this->load->view('public/part/menu');
		$this->load->view('v_forum_diskusi', $x);
		$this->load->view('public/part/footer');
		unset($_SESSION['messege']);
	}

	public function insert_chat(){
		$isi_pesan_before = $_POST['isi_pesan'];
		$isi_pesan = addslashes($_POST['isi_pesan']);
		$status_pengirim = addslashes($_SESSION['status_login']);
		$username_pengirim = addslashes($_SESSION['username']);
		$nama_pengirim = addslashes($_SESSION['nama']);
		$foto_pengirim = addslashes($_SESSION['foto']);
		// $this->send_email();
		if($this->m_forum_diskusi->insert_chat($status_pengirim, $username_pengirim, $nama_pengirim, $foto_pengirim, $isi_pesan)){
			$this->send_email($status_pengirim, $nama_pengirim, $isi_pesan_before);
		}
	}

	public function send_email($status_pengirim, $nama_pengirim, $isi_pesan){

		// Load Composer's autoloader
		$this->load->library("php_mail");

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);


		try {
		    //Server settings
		    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
		    $mail->isSMTP();                                            // Set mailer to use SMTP
		    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'tkjfurizal@gmail.com';                       // SMTP username
		    $mail->Password   = '';                               // SMTP password
		    $mail->SMTPSecure = 'TLS';                                  // Enable TLS encryption, `ssl` also accepted
		    $mail->Port       = 587;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom('tkjfurizal@gmail.com', 'SiPA FAKULTAS TEKNIK UIR');
		    $mail->addAddress('furizal1999@gmail.com', 'FURIZAL');     // Add a recipient


		    // Attachments
		    // $mail->addStringAttachment(file_get_contents('https://cdn0-production-images-kly.akamaized.net/tAr72vTJCpF4IF9O5L493CD79kE=/640x360/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/2754932/original/005940800_1552970791-fotoHL_kucing.jpg'), 'filename.jpg');   // Optional name

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'Forum Diskusi SiPA-FT UIR';
		    $mail->Body    = 'Pesan dari <b>'.$nama_pengirim.'</b> (<b>'.$status_pengirim.'</b>) telah terkirim pada '.$this->tgl_indo(date('Y-m-d')).' pukul '.date("H:i:s").' dengan isi pesan : <b>'.$isi_pesan.'</b>';
		    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		    $mail->send();
		    echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

	function tgl_indo($tanggal){
		$bulan = array (
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$pecahkan = explode('-', $tanggal);
		
		// variabel pecahkan 0 = tanggal
		// variabel pecahkan 1 = bulan
		// variabel pecahkan 2 = tahun
	 
		return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
	}
	 

}


?>
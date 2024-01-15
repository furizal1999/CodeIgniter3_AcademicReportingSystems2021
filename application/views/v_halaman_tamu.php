<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login SiPA-FT</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" href="<?php echo base_url('templates/');?>img/logo/logo.png" type="image/x-icon"/>
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>fonts/iconic/css/material-design-iconic-font.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/animsition/css/animsition.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>vendor/daterangepicker/daterangepicker.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>css/util.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url('templates/assets/login/')?>css/main.css">
  <!--===============================================================================================-->
  <style type="text/css">
    html {
      height:100%;
    }

    body {
      margin:0;
    }

    .bg {
      animation:slide 3s ease-in-out infinite alternate;
      background-image: linear-gradient(-60deg, #1100BB 50%, #88AAFF 50%);
      bottom:0;
      left:-50%;
      opacity:.5;
      position:fixed;
      right:-50%;
      top:0;
      z-index:-1;
    }

    .bg2 {
      animation-direction:alternate-reverse;
      animation-duration:4s;
    }

    .bg3 {
      animation-duration:5s;
    }

    .content {
      background-color:rgba(255,255,255,.8);
      border-radius:.25em;
      box-shadow:0 0 .25em rgba(0,0,0,.25);
      box-sizing:border-box;
      left:50%;
      padding:10vmin;
      position:fixed;
      text-align:center;
      top:50%;
      transform:translate(-50%, -50%);
    }

    h1 {
      font-family:monospace;
    }

    @keyframes slide {
      0% {
        transform:translateX(-25%);
      }
      100% {
        transform:translateX(25%);
      }
    }


  </style>
</head>
<body>

  <div class="limiter">


    <!-- <div class="container-login100" style="background-color: whitesmoke;"> -->
    <div class="container-login100" style="background-image: URL(<?= base_url('templates/img/logo/gedung-a.png') ?>);">
    <!-- <div class="container-login100">
                <div class="bg"></div>
                <div class="bg bg2"></div>
                <div class="bg bg3"></div> -->

               <!--  <div class="content">
                  <h1>Sliding Diagonals Background Effect</h1>
                </div> -->

                <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                  <form class="login100-form validate-form" method="post" action="<?= base_url('halaman_tamu/user_login')?>">

                    <span class="login100-form-title" style="color: #3366FF;">
                      Login SiPA-FT

                    </span>
                    <div class="text-right p-b-30">
                      <a href="#">
                       <marquee style="">
                           <!--  <b style="color: red; font-size: 20px;">
                              Selamat melaksanakan Ujian Akhir Semester...---- 
                            </b> -->
                             <b style="color: #3366FF;">
                              Assalamu'alaikum, selamat datang di SISTEM PELAPORAN AKADEMIK FAKULTAS TEKNIK UNIVERSITAS ISLAM RIAU...
                            </b>
                            <!--  <b style="color: red;">
                              Pemberitahuan... Untuk dosen yang ingin melakukan pelaporan tatap muka, silahkan login dan lakukan pergantian jadwal. Setelah itu, pelaporan sudah bisa langsung dilaporkan. Mohon maaf atas ketidaknyamanannya selama maintenance sistem...
                            </b> -->
                            
                            <b style="color: #3366FF;">
                              <?php echo $this->m_halaman_tamu->ambilJumlahLogin(); ?> pengguna telah login hari ini.....
                            </b>

                          </marquee>

                        </a>

                      </div>
                      <?php echo $this->session->flashdata('messege'); ?>

                      <div class="wrap-input100 validate-input m-b-23" data-validate = "Username harus di isi">
                        <span class="label-input100">Username</span>
                        <input class="input100" type="text" name="npk" placeholder="Username" required>
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                      </div>

                      <div class="wrap-input100 validate-input m-b-23" data-validate="Password harus di isi">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" placeholder="Password" required>
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
                      </div>

                      <div class="wrap-input100 validate-input" data-validate="Status login harus di isi">
                        <span class="label-input100">Status Login</span>
                        <select name="status" class="input100" style="border:none; color: gray;" required>
                          <option value="">--Pilih--</option>
                          <option value="Developer">Developer</option>
                          <option value="Fakultas">Fakultas (Dekanat)</option>
                          <option value="UPM">UPM Fakultas</option>
                          <option value="Tata Usaha">Tata Usaha</option>
                          <option value="Prodi">Prodi</option>
                          <option value="Koordinator Prodi">Koordinator Prodi</option>
                          <option value="GKM Prodi">GKM Prodi</option>
                          <option value="Dosen">Dosen</option>
                          <option value="Pegawai">Pegawai</option>
                          <option value="Mahasiswa">Mahasiswa</option>
                          <option value="Pembimbing Lapangan KP">Pembimbing Lapangan KP</option>
                        </select>

                        <span class="focus-input100" data-symbol="&#xf209;"></span>
                      </div>
                      <small style="color: #3366FF;" align="right">
                        Perubahan terakhir sistem : 14 Februari 2023 12:30 WIB
                        <br>
                        Pengaduan akun mahasiswa klik di sini :
                        <a href="whatsapp://send?text=Assalamu'alaikum.Wr.Wb...&phone=+6285365018008" style="color: darkorange;">Di sini </a>(Chat only)
                        </small>

                      <br><br>



                      <div class="row">
                        <div class="col-md-10">
                          <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn" style="margin-bottom: 10px; background-color: red;">
                              <div class="login100-form-bgbtn"></div>
                              <button class="login100-form-btn">
                                Login
                              </button>
                            </div>
                          </div>
                        </div>
                        <style media="screen">
                        .blink_me {
                          animation: blinker 1s linear infinite;
                          }

                          @keyframes blinker {
                          50% {
                            opacity: 0;
                          }
                          }
                        </style>
                        <div class="col-md-2 ">
                          <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                              <div class="login100-form-bgbtn"></div>
                              <button class="login100-form-btn blink_me" type="button" data-toggle="modal" data-target="#staticBackdrop" style="background-color: #3366FF;">
                                <i class="fa fa-bars"></i>
                              </button>
                            </div>
                          </div>



                          <!-- Modal -->
                          <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="staticBackdropLabel">Menu</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="flex-c-m text-right">
                                      <div class="col-md-6">
                                        <div class="container-login100-form-btn">
                                          <div class="wrap-login100-form-btn">
                                            <div class="login100-form-bgbtn" style="background-color: darkorange;"></div>
                                            <a href="<?php echo base_url('seminar/index.php/register'); ?>" class="text-center login100-form-btn">Register Mahasiswa</a>
                                          </div>
                                        </div>
                                      </div>
                                      <a href="<?php echo base_url('templates/file/manual/ManualBookPengawas.pdf');?>" target="_BLANK" class="login100-social-item" style="background-color: #3366FF; ">
                                        <i class="fa fa-book"></i>
                                      </a>
                                      <a href="" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  class="login100-social-item" style="background-color: #3366FF;">
                                       <i class="fa fa-youtube"></i>
                                     </a>
                                     <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a href="https://youtu.be/JjNZ05EX27I" target="_BLANK" class="p-2"> <i class="fa fa-youtube"></i> Cara Melakukan Register Akun Mahasiswa
                                      </a><br>
                                      <a href="https://www.youtube.com/watch?v=gyrqarRtcb0" target="_BLANK" class="p-2"> <i class="fa fa-youtube"></i> Cara Melakukan Pelaporan Tatap Muka
                                      </a><br>
                                      <a href="https://www.youtube.com/watch?v=rKBHv-znboo" target="_BLANK" class="p-2"> <i class="fa fa-youtube"></i> Cara Melakukan Pelaporan Ujian
                                      </a>
                                    </div>
                                    <a href="whatsapp://send?text=Assalamu'alaikum.Wr.Wb...&phone=+6285365018008" class="login100-social-item" style="background-color: #3366FF;">
                                      <i class="fa fa-whatsapp"></i>
                                    </a>

                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                  <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </form>




                  </div>
                </div>
              </div>


              <div id="dropDownSelect1"></div>

              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/jquery/jquery-3.2.1.min.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/animsition/js/animsition.min.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/bootstrap/js/popper.js"></script>
              <script src="<?= base_url('templates/assets/login/')?>vendor/bootstrap/js/bootstrap.min.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/select2/select2.min.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/daterangepicker/moment.min.js"></script>
              <script src="<?= base_url('templates/assets/login/')?>vendor/daterangepicker/daterangepicker.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>vendor/countdowntime/countdowntime.js"></script>
              <!--===============================================================================================-->
              <script src="<?= base_url('templates/assets/login/')?>js/main.js"></script>

            </body>
            </html>

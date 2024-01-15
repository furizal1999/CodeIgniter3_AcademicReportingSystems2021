<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SISTEM PELAPORAN AKADEMIK FAKULTAS TEKNIK (SiPA-FT) UIR</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo base_url('templates/');?>img/logo/logo.png" type="image/x-icon"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<!-- Fonts and icons -->
	<script src="<?php echo base_url('templates/');?>assets/js/plugin/webfont/webfont.min.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?php echo base_url('templates/');?>assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?php echo base_url('templates/');?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('templates/');?>assets/css/atlantis.min.css">

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="<?php echo base_url('templates/');?>assets/css/demo.css">

  <!-- data table -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'templates/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'templates/plugins/datatables-responsive/css/responsive.bootstrap4.min.css'?>">

  <link rel="stylesheet" href="<?php echo base_url() ?>templates/plugins/fontawesome-free/css/all.min.css">
	<style>

      @media (min-width: 769px) {
       
        .absensi{
          display: none;
        }
      }

      @media (max-width: 769px) {
       
        .perintah{
          display: none;
        }
      }
      
      .button {
        border: 1px transparent;
        -webkit-border-radius: 10px;
        border-radius: 10px;
        color: #FFFFFF;
        cursor: pointer;
        display: inline-block;
        font-family: Arial;
        font-size: 12px;
        padding: 4px 15px;
        text-align: center;
        text-decoration: none;
        margin-left: 20px;
        -webkit-animation: glowing 1300ms infinite;
        -moz-animation: glowing 1300ms infinite;
        -o-animation: glowing 1300ms infinite;
        animation: glowing 1300ms infinite;
      }
      @-webkit-keyframes glowing {
        0% {
          background-color: ##0000FF;
          -webkit-box-shadow: 0 0 3px ##0000FF;
        }
        50% {
          background-color: #0000FF;
          -webkit-box-shadow: 0 0 15px #0000FF;
        }
        100% {
          background-color: ##0000FF;
          -webkit-box-shadow: 0 0 3px ##0000FF;
        }
      }
      @keyframes glowing {
        0% {
          background-color: ##0000FF;
          box-shadow: 0 0 3px ##0000FF;
        }
        50% {
          background-color: #0000FF;
          box-shadow: 0 0 15px #0000FF;
        }
        100% {
          background-color: ##0000FF;
          box-shadow: 0 0 3px ##0000FF;
        }
      }
	</style>

  <style>
.blink {
animation: blink-animation 1s steps(5, start) infinite;
-webkit-animation: blink-animation 1s steps(5, start) infinite;
}
@keyframes blink-animation {
to {
  visibility: hidden;
}
}
@-webkit-keyframes blink-animation {
to {
visibility: hidden;
}
}
</style>
 <style>
 
blink {
  -webkit-animation: 2s linear infinite kedip; /* for Safari 4.0 - 8.0 */
  animation: 2s linear infinite kedip;
}
/* for Safari 4.0 - 8.0 */
@-webkit-keyframes kedip { 
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}
@keyframes kedip {
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}</style>

  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  
</head>
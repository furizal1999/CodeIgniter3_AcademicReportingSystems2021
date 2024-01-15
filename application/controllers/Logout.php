<?php
defined('BASEPATH') OR exit('No direct script access allowed');

#[AllowDynamicProperties]
class Logout extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->library('session');
  }
  
  function index(){
    $_SESSION = [];
    session_unset();
    session_destroy();
    
    redirect('');
    exit;
  }
}

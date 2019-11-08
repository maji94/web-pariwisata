<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    if (empty($this->cek)) {
      $this->load->view('admin/login');
		}
    else {
      redirect('admin');
    }
	}

	public function index(){
		
	}

	public function getLogin() {
    $u = $this->security->xss_clean($this->input->post('user'));
    $p = md5($this->security->xss_clean($this->input->post('password')));
    $duser = array(
      'username'  => $u,
      'password'  => $p,
    );

    $q_cek_login = $this->m_admin->getLogin($duser);
    if (count($q_cek_login)>0) {
      foreach ($q_cek_login as $qck) {
        $sess_data['logged_in']  = 'yes';
        $sess_data['foto']  		 = $qck->foto;
        $sess_data['lvl_user']   = $qck->level;
        $sess_data['id_user']    = $qck->id_user;
        $sess_data['username']   = $qck->username;
        $this->session->set_userdata($sess_data);

        redirect('admin');
      }
    }
    else{
      // echo "<pre>";
      // echo print_r($_POST);
      echo "<script>alert('Username Atau Password Tidak Valid');</script>";
    }
  }

}

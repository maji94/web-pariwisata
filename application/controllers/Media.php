<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
	}

	public function all(){
		$data = array(
			'page'	=> "home/media",
		);
		$this->load->view('home/st_front', $data);
	}

	public function artikel(){
		$link = $this->uri->segment(3);

		if ($link == "all") {
			$data = array(
				'page'	=> "home/artikel",
			);
		}else{
			$data = array(
				'page'	=> "home/media",
			);
		}
		$this->load->view('home/st_front', $data);
	}

	public function galeri(){
		$data = array(
			'page'	=> "home/media",
		);
	}
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
		$data = array(
			'page'	=> "home/main",
			'headline' => $this->m_admin->getContent('tb_banner', array('jenis'=>"headline")),
			'foto_headline' => $this->m_admin->getContent('tb_banner', array('jenis'=>"foto")),
			'artikel' => $this->m_admin->getContent2('tb_media', array('jenis'=>"artikel"), 2),
		);
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($data);
	}
	
}
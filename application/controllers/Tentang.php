<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tentang extends CI_Controller {

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
			'page'	=> "home/tentang",
		);
		$this->load->view('home/st_front', $data);
	}

	public function struktur(){
		$links = $this->uri->segment(3);
    $tableName = "tb_tentang";

    $data = array(
    	'data' => $this->m_admin->getContent($tableName, array('jenis'=>"struktur")),
    	'page' => "home/detail_tentang",
    );

		$this->load->view('home/st_front', $data);
	}

	public function profil(){
		$links = $this->uri->segment(3);
    $tableName = "tb_tentang";

    $data = array(
    	'data' => $this->m_admin->getContent($tableName, array('jenis'=>"profil")),
    	'page' => "home/detail_tentang",
    );

		$this->load->view('home/st_front', $data);
	}

	public function galeri_dinas(){
		$links = $this->uri->segment(3);
    $tableName = "tb_tentang";

    if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_tentang` WHERE jenis = 'galeri'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getTentang('galeri',$akhir,$awal),
				'page'	=> "home/galeri_tentang",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("tentang/galeri_dinas/".$links));
    }else {
	    $data = array(
	    	'data' => $this->m_admin->getContent($tableName, array('jenis'=>"galeri")),
	    	'page' => "home/detail_tentang",
	    );    	
    }

		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($data);
	}
}
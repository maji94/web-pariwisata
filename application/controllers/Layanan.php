<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
		$this->load->helper('security');
		$this->load->helper('captcha');
    date_default_timezone_set('Asia/Jakarta');
	}

	public function index(){
	}

	public function all(){
		$data = array(
			'page'	=> "home/layanan",
		);
		$this->load->view('home/st_front', $data);
	}

	public function unduh(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
    $tableName = "tb_layanan";

		if ($links == "all") {
			$data = array(
				'data' => $this->m_admin->getContent($tableName, array('jenis'=>"unduh")),
				'page' => "home/unduh_arsip",
			);
		}else{
	    $this->load->helper('download');
	    if ($links2) {
				$unduh = $this->m_admin->getContent($tableName, array('id'=>$links));
				$upd = array('didownload'=>($unduh[0]->didownload + 1));
				$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));

	      force_download('assets/dokumen/unduh/'.$links2, NULL);
	    }else{
	      $this->session->set_flashdata('notif', "onload=\"alert('Maaf saat ini dokumen tidak tersedia')\"");
	      redirect('layanan/unduh/all');
	    }
		}
		$this->load->view('home/st_front', $data);
	}

	public function request(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
    $tableName = "tb_layanan";

		if ($links == "send") {
			$captcha = $this->security->xss_clean($this->input->post('captcha'));
			$data_request = array(
				'jenis' => "request",
				'nama'	=> $this->security->xss_clean($this->input->post('nama')),
				'email'	=> $this->security->xss_clean($this->input->post('email')),
				'nohp'	=> $this->security->xss_clean($this->input->post('nohp')),
				'konten'	=> $this->security->xss_clean($this->input->post('dokumen')),
				'keterangan'	=> $this->security->xss_clean($this->input->post('keterangan')),
				'status' => '1',
			);

			if ($captcha != $this->session->userdata('keycode')) {
				$this->session->set_flashdata('notif', "onload=\"alert('Terjadi Kesalahan. Mohon maaf permintaan dokumen gagal dikirin. Silahkan coba lagi nanti.')\"");
	      redirect('layanan/request');
			}else{
				$insert = $this->m_admin->InsertData($tableName, $data_request);
				if ($insert) {
					$this->session->set_flashdata('notif', "onload=\"alert('Terima kasih. Permintaan dokumen akan ditinjau oleh admin dan apabila telah disetujui dokumen akan dikirimkan via Email yang telah diisi pada kolom Emaol')\"");
		      redirect('layanan/request');
				}else {
					$this->session->set_flashdata('notif', "onload=\"alert('Terjadi Kesalahan. Mohon maaf permintaan dokumen gagal dikirin. Silahkan coba lagi nanti.')\"");
		      redirect('layanan/request');
				}
			}
		}else{
			$vals = array(
	      'img_path'      => './captcha/',
	      'img_url'       => '../captcha/',
	      'font_path'     => './path/to/fonts/texb.ttf',
	      'img_width'     => '150',
	      'img_height'    => '80',
	      'expiration'    => 7200,
	      'word_length'   => 6,
	      'font_size'     => 30,
	      'img_id'        => 'Imageid',
	      'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',

	      // White background and border, black text and red grid
	      'colors'	=> array(
	      'background' => array(255, 255, 255),
	      'border' => array(0, 0, 0),
	      'text' => array(0, 0, 0),
	      'grid' => array(180, 180, 180)
	      )
	    );

			$cap = create_captcha($vals);
			$this->session->set_userdata('keycode', $cap['word']);

			$data = array(
				'page' => "home/request",
				'captcha'	=> $cap['image'],
			);
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($data_request);
		// echo "<br>";
		// print_r($this->session->userdata());
	}
}
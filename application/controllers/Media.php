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
		$links = $this->uri->segment(3);
    $tableName = "tb_media";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_media` WHERE jenis = 'artikel'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getMedia('artikel',$akhir,$awal),
				'page'	=> "home/artikel",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("media/artikel/".$links));
		}else{
			$artikel = $this->m_admin->getContent($tableName, array('id'=>$links));
			$foto = $this->m_admin->getContent('tb_media', array('id'=>substr($artikel[0]->link_foto, (strpos($artikel[0]->link_foto, 'i/'))+2)));
			$other = $this->m_admin->getOther($tableName, $artikel[0]->jenis);
			$data = array(
				'data' => $artikel,
				'foto' => $foto,
				'other' => $other,
				'page'	=> "home/detail_artikel",
			);

			$upd = array('dilihat'=>($artikel[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($galeri);
	}

	public function galeri(){
		$links = $this->uri->segment(3);
    $tableName = "tb_media";

		if ($links == "foto") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_media` WHERE jenis = '$links'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getMedia($links,$akhir,$awal),
				'page'	=> "home/galeri_all",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("media/galeri/".$links));
		}else if ($links == "video") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_media` WHERE jenis = '$links'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getMedia($links),
				'page'	=> "home/galeri_all",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("media/galeri/".$links));
		}else {
			$galeri = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $galeri[0]->jenis);
			$data = array(
				'data' => $galeri,
				'other' => $other,
				'page'	=> "home/detail_galeri",
			);

			$upd = array('dilihat'=>($galeri[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($data);
		// echo "<br>";
		// print_r($total_row);
	}
}
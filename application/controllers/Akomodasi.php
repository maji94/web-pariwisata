<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akomodasi extends CI_Controller {

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
			'page'	=> "home/akomodasi",
		);
		$this->load->view('home/st_front', $data);
	}

	public function hotel(){
		$links = $this->uri->segment(3);
    $tableName = "tb_akomodasi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_akomodasi` WHERE jenis = 'hotel'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAkomodasi('hotel',$akhir,$awal),
				'page'	=> "home/akomodasi_all",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("akomodasi/hotel/".$links));
		}else{
			$hotel = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $hotel[0]->jenis);
			$data = array(
				'data' => $hotel,
				'other' => $other,
				'page'	=> "home/detail_akomodasi",
			);

			$upd = array('dilihat'=>($hotel[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
	}

	public function restoran(){
		$links = $this->uri->segment(3);
    $tableName = "tb_akomodasi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_akomodasi` WHERE jenis = 'restoran'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAkomodasi('restoran',$akhir,$awal),
				'page'	=> "home/akomodasi_all",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("akomodasi/restoran/".$links));
		}else{
			$restoran = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $restoran[0]->jenis);
			$data = array(
				'data' => $restoran,
				'other' => $other,
				'page'	=> "home/detail_akomodasi",
			);

			$upd = array('dilihat'=>($restoran[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
	}

	public function transportasi(){
		$links = $this->uri->segment(3);
    $tableName = "tb_akomodasi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_akomodasi` WHERE jenis = 'transportasi'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAkomodasi('transportasi',$akhir,$awal),
				'page'	=> "home/akomodasi_all",
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("akomodasi/transportasi/".$links));
		}else{
			$transportasi = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $transportasi[0]->jenis);
			$data = array(
				'data' => $transportasi,
				'other' => $other,
				'page'	=> "home/detail_akomodasi",
			);

			$upd = array('dilihat'=>($transportasi[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
	}
}
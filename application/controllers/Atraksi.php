<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atraksi extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    date_default_timezone_set('Asia/Jakarta');
    $this->dataPengunjung();
	}

	public function index(){
	}

	public function dataPengunjung(){
		$ip         = ip_user();
		$tanggal    = date("Y-m-d");
		$waktu      = time();
		$browser    = browser_user();
		$os         = os_user();

		$data = array(
			'tanggal' => $tanggal,
			'ip'      => $ip,
			'hits'    => 1,
			'online'   => $waktu,
			'browser' => $browser,
			'os'      => $os,
		);
		$where = array('ip'=>$ip,'tanggal'=>$tanggal);

            // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini
		$cekip = $this->m_admin->cekDataPengunjung('tb_pengunjung', $where);

            // Kalau belum ada, simpan data user tersebut ke database
		if($cekip == null){
			$this->m_admin->InsertData('tb_pengunjung', $data);
		}
            // Jika sudah ada, update
		else{
			$data['hits'] = $cekip[0]->hits+1;
			$this->m_admin->UpdateData('tb_pengunjung', $data, $where);
		}
	}

	public function pengunjung(){
		$set=$this->db;
		$batas = time()-300;
		$tanggal = date('Y-m-d');

		$data = array(
			'online'    => $this->m_admin->getPengunjung("*",$set->where('online > ',$batas)),
			'todayvisit'=> $this->m_admin->getPengunjung("*",$set->where('tanggal',$tanggal)),
			'todayhits' => $this->m_admin->getHits("SUM(hits) AS todayhits",$set->where('tanggal', $tanggal)),
			'totalhits' => $this->m_admin->getHits("SUM(hits) AS totalhits"),
			'totalvisit'=> $this->m_admin->getPengunjung(),
		);
		return $data;
	}

	public function all(){
		$data = array(
			'page'	=> "home/atraksi",
			'pengunjung'=> $this->pengunjung(),
		);
		$this->load->view('home/st_front', $data);
	}

	public function alam(){
		$links = $this->uri->segment(3);
    $tableName = "tb_atraksi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_atraksi` WHERE jenis = 'alam'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAtraksi('alam',$akhir,$awal),
				'page'	=> "home/atraksi_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("atraksi/alam/".$links));
		}else{
			$alam = $this->m_admin->getContent($tableName, array('id'=>$links));
			$foto = $this->m_admin->getContent('tb_media', array('id'=>substr($alam[0]->link_foto, (strpos($alam[0]->link_foto, 'i/'))+2)));
			$other = $this->m_admin->getOther($tableName, $alam[0]->jenis);
			$data = array(
				'data' => $alam,
				'foto' => $foto,
				'other' => $other,
				'page'	=> "home/detail_atraksi",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($alam[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($galeri);
	}

	public function budaya(){
		$links = $this->uri->segment(3);
    $tableName = "tb_atraksi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_atraksi` WHERE jenis = 'budaya'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAtraksi('budaya',$akhir,$awal),
				'page'	=> "home/atraksi_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("atraksi/budaya/".$links));
		}else{
			$budaya = $this->m_admin->getContent($tableName, array('id'=>$links));
			$foto = $this->m_admin->getContent('tb_media', array('id'=>substr($budaya[0]->link_foto, (strpos($budaya[0]->link_foto, 'i/'))+2)));
			$other = $this->m_admin->getOther($tableName, $budaya[0]->jenis);
			$data = array(
				'data' => $budaya,
				'foto' => $foto,
				'other' => $other,
				'page'	=> "home/detail_atraksi",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($budaya[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($galeri);
	}

	public function museum(){
		$links = $this->uri->segment(3);
    $tableName = "tb_atraksi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_atraksi` WHERE jenis = 'museum'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAtraksi('museum',$akhir,$awal),
				'page'	=> "home/atraksi_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("atraksi/museum/".$links));
		}else{
			$museum = $this->m_admin->getContent($tableName, array('id'=>$links));
			$foto = $this->m_admin->getContent('tb_media', array('id'=>substr($museum[0]->link_foto, (strpos($museum[0]->link_foto, 'i/'))+2)));
			$other = $this->m_admin->getOther($tableName, $museum[0]->jenis);
			$data = array(
				'data' => $museum,
				'foto' => $foto,
				'other' => $other,
				'page'	=> "home/detail_atraksi",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($museum[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($galeri);
	}

	public function kuliner(){
		$links = $this->uri->segment(3);
    $tableName = "tb_atraksi";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_atraksi` WHERE jenis = 'kuliner'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getAtraksi('kuliner',$akhir,$awal),
				'page'	=> "home/atraksi_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("atraksi/kuliner/".$links));
		}else{
			$kuliner = $this->m_admin->getContent($tableName, array('id'=>$links));
			$foto = $this->m_admin->getContent('tb_media', array('id'=>substr($kuliner[0]->link_foto, (strpos($kuliner[0]->link_foto, 'i/'))+2)));
			$other = $this->m_admin->getOther($tableName, $kuliner[0]->jenis);
			$data = array(
				'data' => $kuliner,
				'foto' => $foto,
				'other' => $other,
				'page'	=> "home/detail_atraksi",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($kuliner[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($galeri);
	}


}
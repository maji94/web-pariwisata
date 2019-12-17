<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kreatif extends CI_Controller {

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
			'page'	=> "home/kreatif",
			'pengunjung'=> $this->pengunjung(),
		);
		$this->load->view('home/st_front', $data);
	}

	public function komunitas(){
		$links = $this->uri->segment(3);
    $tableName = "tb_kreatif";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_kreatif` WHERE jenis = 'komunitas'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getKreatif('komunitas',$akhir,$awal),
				'page'	=> "home/kreatif_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("kreatif/komunitas/".$links));
		}else{
			$komunitas = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $komunitas[0]->jenis);
			$data = array(
				'data' => $komunitas,
				'other' => $other,
				'page'	=> "home/detail_kreatif",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($komunitas[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
		// echo "<pre>";
		// print_r($data);
	}

	public function event(){
		$links = $this->uri->segment(3);
    $tableName = "tb_kreatif";

		if ($links == "all") {
			/* pagination */	
			$total_row		= $this->db->query("SELECT * FROM `tb_kreatif` WHERE jenis = 'event'")->num_rows();
			$per_page		= 4;
			
			$awal	= $this->uri->segment(4); 
			$awal	= (empty($awal) || $awal == 1) ? 0 : $awal;
			
			//if (empty($awal) || $awal == 1) { $awal = 0; } { $awal = $awal; }
			$akhir	= $per_page;

			$data = array(
				'data' => $this->m_admin->getKreatif('event',$akhir,$awal),
				'page'	=> "home/kreatif_all",
				'pengunjung'=> $this->pengunjung(),
			);

			$data['pagi']	= _page($total_row, $per_page, 4, site_url("kreatif/event/".$links));
		}else{
			$event = $this->m_admin->getContent($tableName, array('id'=>$links));
			$other = $this->m_admin->getOther($tableName, $event[0]->jenis);
			$data = array(
				'data' => $event,
				'other' => $other,
				'page'	=> "home/detail_kreatif",
				'pengunjung'=> $this->pengunjung(),
			);

			$upd = array('dilihat'=>($event[0]->dilihat + 1));
			$this->m_admin->UpdateData($tableName, $upd, array('id'=>$links));
		}
		$this->load->view('home/st_front', $data);
	}
}
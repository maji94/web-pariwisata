<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('m_admin');
    $this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    date_default_timezone_set('Asia/Jakarta');
    $this->dataPengunjung();
  }

  public function index()
  {
    $data = array(
      'page'  => "home/main",
      'headline' => $this->m_admin->getContent('tb_banner', array('jenis' => "headline")),
      'foto_headline' => $this->m_admin->getBanner('foto', 5),
      'artikel' => $this->m_admin->getContent2('tb_media', array('jenis' => "artikel"), 2),
      'event' => $this->m_admin->getContent2('tb_kreatif', array('jenis' => "event"), 4),
      'foto' => $this->m_admin->getMedia('foto', 2, 0),
      'pengunjung' => $this->pengunjung(),
    );
    $this->load->view('home/st_front', $data);
  }

  public function dataPengunjung()
  {
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
    $where = array('ip' => $ip, 'tanggal' => $tanggal);

    // Mencek berdasarkan IPnya, apakah user sudah pernah mengakses hari ini
    $cekip = $this->m_admin->cekDataPengunjung('tb_pengunjung', $where);

    // Kalau belum ada, simpan data user tersebut ke database
    if ($cekip == null) {
      $this->m_admin->InsertData('tb_pengunjung', $data);
    }
    // Jika sudah ada, update
    else {
      $data['hits'] = $cekip[0]->hits + 1;
      $this->m_admin->UpdateData('tb_pengunjung', $data, $where);
    }
  }

  public function pengunjung()
  {
    $set = $this->db;
    $batas = time() - 300;
    $tanggal = date('Y-m-d');

    $data = array(
      'online'    => $this->m_admin->getPengunjung("*", $set->where('online > ', $batas)),
      'todayvisit' => $this->m_admin->getPengunjung("*", $set->where('tanggal', $tanggal)),
      'todayhits' => $this->m_admin->getHits("SUM(hits) AS todayhits", $set->where('tanggal', $tanggal)),
      'totalhits' => $this->m_admin->getHits("SUM(hits) AS totalhits"),
      'totalvisit' => $this->m_admin->getPengunjung(),
    );
    return $data;
  }
}

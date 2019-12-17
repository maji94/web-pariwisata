<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');  
    $this->dataPengunjung();  
	}

	public function index(){
    $data = array(
      'page'  => "home/login",
      'pengunjung'=> $this->pengunjung(),
    );
    $this->load->view('home/st_front', $data);
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
      'online'  => $waktu,
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
      $data['hits'] = ($cekip[0]->hits+1);
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
        $sess_data['nama']   = $qck->nama;
        $this->session->set_userdata($sess_data);

        redirect('admin');
      }
    }
    else{
      // echo "<pre>";
      // echo print_r($_POST);
      echo "<script>alert('Username Atau Password Tidak Valid');</script>";
      redirect('login');
    }
  }

}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_admin');
		$this->cek = $this->session->userdata('logged_in');
    $this->set = $this->session->userdata('lvl_user');
    date_default_timezone_set('Asia/Jakarta');
    if (empty($this->cek)) {
      redirect('login');
		}
	}

	public function index(){
		$data = array(
			// 'produknew' => $this->m_admin->getProdukNew(),
			// 'produk' => $this->m_admin->getProduk(),
			// 'tipe' => $this->m_admin->getTipeDokumen(),
			// 'berita' => $this->m_admin->getTotalBerita(),
			// 'anggota' => $this->m_admin->getTotalAnggota(),
			// 'galeri' => $this->m_admin->getTotalGaleri(),
			// 'dilihat' => $this->m_admin->getProdukRating('dilihat'),
			// 'didownload' => $this->m_admin->getProdukRating('didownload'),
			'title'	=> "BERANDA ".strtoupper($this->set),
			'page'	=> "admin/a_main",
		);
		$this->load->view('admin/dashboard', $data);
	}

	public function test(){
		$time = '1531537843';
		$where = array('waktu' => $time);
		$getAdd = $this->m_admin->getByTime('tb_dokumen', $where);

		echo "<pre>";
		print_r($getAdd);
		$baru = unserialize($getAdd[0]->status);
		print_r($baru);
		$baru2 = unserialize($baru[0]);
		echo "<br>baru 2<br>";
		print_r($baru2);

		if ($baru2['status'] == "mencabut") {
			$stat_add = "dicabut";
		}else if ($baru2['status'] == "mengubah") {
			$stat_add = "diubah";
		}

		$baru3 = unserialize($baru2['input_judul']);
		$n =sizeof($baru3);
		echo "<br>baru 3<br>";
		print_r($baru3);
		$add_data = array(
			'status' => $stat_add,
			'input_jenis' => $getAdd[0]->tipe_dokumen,
			'input_judul' => $getAdd[0]->id_dokumen,
		);	

		for ($i=0; $i < $n; $i++) { 

			$getDataLama = $this->m_admin->getContent('tb_dokumen', array('id_dokumen'=>$baru3[$i]));
			print_r($getDataLama);
			$baru5 = array(serialize($add_data));
			print_r($getDataLama[0]->status);
			echo "<br>";
			array_push($baru5, $getDataLama[0]->status);
			print_r($add_data);
			print_r($baru5);
			$baru6 = serialize($baru5);
			echo $baru6;
		}
	}

	public function profil(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_profil';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			$path = './assets/backend/dist/img/profil/';
			$config['upload_path']		= $path;
			$config['allowed_types']	= 'jpeg|jpg|png|bmp';
			$config['max_size']				= '150000';
			$config['file_name']			= time();

			if ($links == "gub") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('gub'),
				);
			}else if ($links == "wagub") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('wagub'),
				);
			}else if ($links == "visi_dan_misi") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('visi_dan_misi'),
				);
			}else if ($links == "struktur") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('struktur'),
				);
			}else if ($links == "tupoksi") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('tupoksi'),
				);
			}else if ($links == "profil") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('profil'),
				);
			}else if ($links == "sambutan") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('sambutan'),
				);
			}else if ($links == "edit") {
				if ($links2 == 'gub' OR $links2 == 'wagub' OR $links2 == 'sambutan') {

					$this->load->library('upload', $config);
					$get =  array('jenis_profil' => $links2);

					if ($_FILES['foto']['name'] == "") {
						$upd_data = array(
							'konten'	=> $this->input->post('editor1'),
						);
					}else{
						if ( ! $this->upload->do_upload('foto')){
							$error = array('error' => $this->upload->display_errors());

							show_404();
			      }else{
			      	$upd_data = array(
								'konten'	=> $this->input->post('editor1'),	
				      	'foto'		=> $this->upload->file_name,
			      	);

			      	$filefoto = $this->m_admin->getContent($tableName, $get);
							unlink($path.$filefoto[0]->foto);
			      }
					}
				}else if ($links2 == 'visi_dan_misi' OR $links2 == 'tupoksi') {

					$get =  array('jenis_profil' => $links2);
					$konten = array(
						'konten1'	=> $this->input->post('editor1'),
						'konten2'	=> $this->input->post('editor2'),
					);

					$upd_data = array(
						'konten'	=> serialize($konten),
					);

				}else if ($links2 == 'struktur') {

					$this->load->library('upload', $config);
					$get =  array('jenis_profil' => $links2);

					if ($_FILES['foto']['name'] == "") {
						redirect('admin/profil/struktur');
					}else{
						if ( ! $this->upload->do_upload('foto')){
							$error = array('error' => $this->upload->display_errors());

							show_404();
			      }else{
			      	$upd_data = array(
				      	'foto'		=> $this->upload->file_name,
			      	);

			      	$filefoto = $this->m_admin->getContent($tableName, $get);
							unlink($path.$filefoto[0]->foto);
			      }
					}
				}

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/profil/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/profil/'.$links2);
				}
			}else{
				show_404();
			}
		}

		$data['page'] = "admin/profil";
		$this->load->view('admin/dashboard',$data);
	}

	public function produk(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_dokumen';
		$tableName2 = 'tb_tipe_dokumen';
		$stat_add = "";

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "edit") {
				$get = array('id_dokumen'=>$links2);
				$getDataEdit = $this->m_admin->getContent($tableName, $get);

				$data = array(
					'field'	=> $this->m_admin->getTipeDokumen(),
					'form'	=> $this->m_admin->getTipeDokumen($getDataEdit[0]->tipe_dokumen),
					'produk' => $this->m_admin->getJudulProduk($getDataEdit[0]->tipe_dokumen),
					'data' => $getDataEdit,
					'data_stats' => array_reverse($this->m_admin->getContent('tb_status', array('id_dokawal'=>$links2))),
					'page' => "admin/crud-produk",
				);

				// echo "<pre>";
				// print_r($data);
			}else if ($links == "do_edit") {
				$time = time();
				$path = './assets/backend/dist/produk/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'pdf|jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$this->load->library('upload', $config);

				$id = $this->input->post('id');
				$tipedok = $this->input->post('tipedok');
				$field = $this->m_admin->getTipeDokumen($tipedok);
				$field2 = unserialize($field[0]->keterangan);
				$n = sizeof($field2)-1;
				$statusSet = "no";

				for ($i=0; $i < $n ; $i++) {
					if ($field2[$i] == "status") {

						$val_status = $this->input->post('status');
						$upd_data['status'] = end($val_status);
						$statusSet = "yes";

					}else{
						$upd_data[$field2[$i]] = $this->input->post($field2[$i]);
					}
				}

				$upd_data['thntetap'] = date('Y', strtotime($this->input->post('tgltetap')));
				$upd_data['tipe_dokumen'] = $tipedok;
				$upd_data['waktu'] = $time;

        if ($_FILES['lampiran']['name'] == "") {
				}else{
					if ( ! $this->upload->do_upload('lampiran')){
						$error = array('error' => $this->upload->display_errors());

						$pesan = $error['error'];
						echo $pesan;
		      }else{
		      	$upd_data['lampiran'] = $this->upload->file_name;
		      }
				}

				if ($_FILES['fileproduk']['name'] == "") {
      	}else {
      		if ( ! $this->upload->do_upload('fileproduk')){
						$error = array('error' => $this->upload->display_errors());

						$pesan = $error['error'];
		      }else{
		      	$upd_data['fileproduk'] = $this->upload->file_name;
		      }
		    }

				// echo "<pre>";
				// print_r($_POST);
				// print_r($upd_data);

				$res = $this->m_admin->UpdateData($tableName, $upd_data, array('id_dokumen'=>$id));
				if ($res) {
					if ($statusSet == "yes") {
						$getStatus = $this->m_admin->getContent('tb_status', array('id_dokawal' => $id));

						for ($l=0; $l < sizeof($getStatus); $l++) { 
							$where2 = array(
								'id_dokawal' => $getStatus[$l]->id_dokawal,
								'id_doktujuan' => $getStatus[$l]->id_doktujuan,
								'judul_doktujuan' => $getStatus[$l]->judul_doktujuan,
							);

							$where3 = array(
								'id_dokawal' => $getStatus[$l]->id_doktujuan,
								'id_doktujuan' => $getStatus[$l]->id_dokawal,
								'judul_doktujuan' => $getStatus[$l]->judul_doktujuan,
							);

							$this->m_admin->DeleteData('tb_status', $where2);
							$this->m_admin->DeleteData('tb_status', $where3);
						}

						$judul = $this->input->post('input_judul');
						$judul_lain = $this->input->post('input_lain');
						$batal = $this->input->post('input_batal');

						for ($j=0; $j < sizeof($val_status); $j++) {
							if ($judul_lain[$j] != "") {
								$judul[$j] = 0;
							}
							if ($val_status[$j] == 0 ) {
								$judul[$j] = null;
							}
							$array_stats[] = array(
								'id_dokawal'   		=> $id,
								'id_doktujuan' 		=> $judul[$j],
								'judul_doktujuan'	=> $judul_lain[$j],
								'status'       		=> $val_status[$j],
								'keterangan'   		=> $batal[$j],
							);
						}

						$this->m_admin->InsertBatch('tb_status', array_reverse($array_stats));

						for ($k=0; $k < sizeof($array_stats); $k++) { 
							if ($array_stats[$k]['status'] == 'diubah') {
								$stat_add = "mengubah";
							}else if ($array_stats[$k]['status'] == 'dicabut') {
								$stat_add = "mencabut";
							}else if ($array_stats[$k]['status'] == 'mengubah') {
								$stat_add = "diubah";
							}else if ($array_stats[$k]['status'] == 'mencabut') {
								$stat_add = "dicabut";
							}

							$stat_data[] = array(
								'id_dokawal' => $array_stats[$k]['id_doktujuan'],
								'id_doktujuan' => $array_stats[$k]['id_dokawal'],
								'judul_doktujuan' => $array_stats[$k]['judul_doktujuan'],
								'status'	=> $stat_add,
								'keterangan'	=> $array_stats[$k]['keterangan'],
							);

							$dok_data = array('status' => $stat_add);
							$this->m_admin->UpdateData('tb_dokumen', $dok_data, array('id_dokumen' => $array_stats[$k]['id_doktujuan']));
						}
						// echo "<pre>";
						// print_r($array_stats);
						// print_r($stat_data);

						$this->m_admin->InsertBatch('tb_status', array_reverse($stat_data));
						$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
						redirect('admin/produk/all');
					}else {
						// echo "else coy";
						$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
						redirect('admin/produk/all');						
					}
				}else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/produk/all');
				}
			}else if ($links == "add") {
				$data = array(
					'field'	=> $this->m_admin->getTipeDokumen(),
					'form'	=> $this->m_admin->getTipeDokumen($links2),
					'page' => "admin/crud-produk",
				);
			}else if ($links == "do_add") {
				$time = time();
				$path = './assets/backend/dist/produk/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'pdf|jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$this->load->library('upload', $config);

				$id = $this->input->post('id');
				$field = $this->m_admin->getTipeDokumen($id);
				$field2 = unserialize($field[0]->keterangan);
				$n = sizeof($field2)-1;
				$statusSet = "no";

				for ($i=0; $i < $n ; $i++) {
					if ($field2[$i] == "status") {

						$val_status = $this->input->post('status');
						$ins_data['status'] = end($val_status);
						$statusSet = "yes";

					}else{

						$ins_data[$field2[$i]] = $this->input->post($field2[$i]);

					}
				}


				$ins_data['thntetap'] = date('Y', strtotime($this->input->post('tgltetap')));
				$ins_data['tipe_dokumen'] = $id;
				$ins_data['waktu'] = $time;

        if ($_FILES['lampiran']['name'] == "") {
        	$ins_data['lampiran'] = "";
				}else{
					if ( ! $this->upload->do_upload('lampiran')){	
					$error = array('error' => $this->upload->display_errors());
					$pesan = $error['error'];
					echo $pesan;
		      }else{
		      	$ins_data['lampiran'] = $this->upload->file_name;
		      }
				}

				if ($_FILES['fileproduk']['name'] == "") {
        	$ins_data['fileproduk'] = "";
				}else{
					if ( ! $this->upload->do_upload('fileproduk')){
	      		$error = array('error' => $this->upload->display_errors());
						$pesan = $error['error'];
						echo $pesan;
		      }else{
		      	$ins_data['fileproduk'] = $this->upload->file_name;
		      	$ins_data['urldownload'] = base_url('assets/backend/dist/produk/'.$this->upload->file_name);
		      }
				}

				// echo "<pre>";
				// print_r($_POST);
				// print_r($array_stats);
				// print_r($ins_data);
				// print_r($getStatus);
				// print_r($stat_data);

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					if ($statusSet == "yes") {
						$getDokumen = $this->m_admin->getContent($tableName, array('waktu' => $time));

						$judul = $this->input->post('input_judul');
						$judul_lain = $this->input->post('input_lain');
						$batal = $this->input->post('input_batal');

						for ($j=0; $j < sizeof($val_status); $j++) {
							if ($judul_lain[$j] != "") {
								$judul[$j] = 0;
							}
							$array_stats[] = array(
								'id_dokawal'   		=> $getDokumen[0]->id_dokumen,
								'id_doktujuan' 		=> $judul[$j],
								'judul_doktujuan'	=> $judul_lain[$j],
								'status'       		=> $val_status[$j],
								'keterangan'   		=> $batal[$j],
							);
						}

						$this->m_admin->InsertBatch('tb_status', array_reverse($array_stats));

						for ($k=0; $k < sizeof($array_stats); $k++) { 
							if ($array_stats[$k]['status'] == 'diubah') {
								$stat_add = "mengubah";
							}else if ($array_stats[$k]['status'] == 'dicabut') {
								$stat_add = "mencabut";
							}else if ($array_stats[$k]['status'] == 'mengubah') {
								$stat_add = "diubah";
							}else if ($array_stats[$k]['status'] == 'mencabut') {
								$stat_add = "dicabut";
							}

							$stat_data[] = array(
								'id_dokawal' => $array_stats[$k]['id_doktujuan'],
								'id_doktujuan' => $array_stats[$k]['id_dokawal'],
								'judul_doktujuan' => $array_stats[$k]['judul_doktujuan'],
								'status'	=> $stat_add,
								'keterangan'	=> $array_stats[$k]['keterangan'],
							);

							$dok_data = array('status' => $stat_add);
							$this->m_admin->UpdateData('tb_dokumen', $dok_data, array('id_dokumen' => $array_stats[$k]['id_doktujuan']));
						}
						// echo "<pre>";
						// print_r($array_stats);
						// print_r($stat_data);

						$this->m_admin->InsertBatch('tb_status', array_reverse($stat_data));
						$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
						redirect('admin/produk/all');
					}else {
						// echo "else coy";
						$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
						redirect('admin/produk/all');						
					}
				}else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/produk/all');
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/produk/';
				$where = array('id_dokumen' => $links2);

				$delStatus = $this->m_admin->getContent('tb_status', array('id_dokawal'=>$links2));

				for ($l=0; $l < sizeof($delStatus); $l++) { 
					$where2 = array(
						'id_dokawal' => $delStatus[$l]->id_dokawal,
						'id_doktujuan' => $delStatus[$l]->id_doktujuan,
						'judul_doktujuan' => $delStatus[$l]->judul_doktujuan,
					);

					$where3 = array(
						'id_dokawal' => $delStatus[$l]->id_doktujuan,
						'id_doktujuan' => $delStatus[$l]->id_dokawal,
						'judul_doktujuan' => $delStatus[$l]->judul_doktujuan,
					);

					$this->m_admin->DeleteData('tb_status', $where2);
					$this->m_admin->DeleteData('tb_status', $where3);
				}

				$filefoto = $this->m_admin->getContent($tableName, $where);
				
				if($filefoto[0]->lampiran != ""){
    				unlink($path.$filefoto[0]->lampiran);
				}
				if($filefoto[0]->fileproduk != ""){
    				unlink($path.$filefoto[0]->fileproduk);
				}
				
				// echo "<pre>";
				// print_r($delStatus);

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/produk/all');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/produk/all');
				}
			}else if ($links == "tipeDokumen"){
				$data = array(
					'field'	=> $this->m_admin->getTipeDokumen(),
					'page' => "admin/tipe_dokumen",
				);
			}else if ($links == "addTipe"){
				$red = $this->input->post('link');
				$ins_data = array(
					'id_tipedokumen' => "",
					'nama' => $this->input->post('nama'),
					'color'	=> $this->input->post('color'),
					'keterangan' => serialize($this->input->post('formulir')),
				);

				$res = $this->m_admin->InsertData($tableName2, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/produk/'.$red);
				}else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/produk/'.$red);
				}
			}else if ($links == "editTipe") {
				$data = array(
					'form'	=> $this->m_admin->getTipeDokumen($links2),
					'page'	=> "admin/crud-tipedokumen",
				);
			}else if ($links == "do_editTipe") {
				$where = array('id_tipedokumen' => $this->input->post('id'));
				$upd_data = array(
					'color' => $this->input->post('color'),
					'keterangan' => serialize($this->input->post('formulir')),
				);

				// echo "<pre>";
				// print_r($upd_data);

				$res = $this->m_admin->UpdateData($tableName2, $upd_data, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/produk/tipeDokumen');
				}else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/produk/tipeDokumen');
				}	
			}else if ($links == "deleteTipe") {
				$where = array('id_tipedokumen' => $links2);

				$res = $this->m_admin->DeleteData($tableName2, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/produk/tipeDokumen');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/produk/tipeDokumen');
				}
			}else{
				$data = array(
					'id' => $links,
					'data'	=> $this->m_admin->getProduk($links,$links2),
					'field'	=> $this->m_admin->getTipeDokumen(),
					'tahun' => $this->m_admin->getTahunProduk($links),
					'page' => "admin/produk",
				);
			}
		}

		// echo "<pre>";
		// print_r($data);

		$this->load->view('admin/dashboard',$data);
	}

	public function ambil_data(){

		$modul=$this->input->post('modul');
		$id=$this->input->post('id');

		if($modul=="tahun"){
			echo $this->m_admin->getTahunProduk($id);
		}
		else if($modul=="subjek"){
			echo $this->m_admin->getSubjekProduk($id);
		}
		else if($modul=="judul"){
			echo $this->m_admin->getJudul($id);
		}
	}

	public function galeri(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_galeri';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "foto") {
				$data = array(
					'data'	=> $this->m_admin->getGaleri('foto'),
					'page' => "admin/galeri",
				);
			}else if ($links == "video") {
				$data = array(
					'data'	=> $this->m_admin->getGaleri('video'),
					'page' => "admin/galeri",
				);
			}else if ($links == "edit") {
				$get = array('id_galeri'=>$links3);
				$data = array(
					'data' => $this->m_admin->getContent($tableName, $get),
					'page' => "admin/crud-galeri",
				);
			}else if ($links == "do_edit") {
				$path = './assets/backend/dist/img/galeri/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();
				$this->load->library('upload', $config);

				$thumb['image_library']  = 'gd2';
        $thumb['create_thumb']   = TRUE;
        $thumb['maintain_ratio'] = TRUE;
        $thumb['width']          = 300;
        $thumb['height']         = 300;

				$get =  array('id_galeri' => $this->input->post('id'));

				if ($links2 == "foto") {

					$getData = $this->m_admin->getContent($tableName, $get);
					$getFoto = unserialize($getData[0]->konten);
					$n_getFoto = sizeof($getFoto);

					$input = sizeof($_FILES['foto']['tmp_name']);
					$files = $_FILES['foto'];
					for ($i=0; $i < $input ; $i++) {

		      	$_FILES['foto']['name'] = $files['name'][$i];
		      	$_FILES['foto']['type'] = $files['type'][$i];
		      	$_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
		      	$_FILES['foto']['error'] = $files['error'][$i];
		      	$_FILES['foto']['size'] = $files['size'][$i];
	          
	          if ($_FILES['foto']['name']) {
	          	$this->upload->do_upload('foto');
			      	$konten[] = $this->upload->file_name;
	          }else{
	          	$konten[] = $getFoto[$i];
	          }
		      	
		        $thumb['source_image'] = 'assets/backend/dist/img/galeri/'.$this->upload->file_name;
	          $this->load->library('image_lib');
	          $this->image_lib->initialize($thumb);
	          $this->image_lib->resize();

		      }

		      $upd_data = array(
		      	'judul'	=> $this->input->post('judul'),
		      	'konten' => serialize($konten),
		      );

					for ($i=0; $i < $n_getFoto ; $i++) { 
						if ($konten[$i] != $getFoto[$i] ) {
							unlink($path.$getFoto[$i]);
							unlink($path.str_replace('.', '_thumb.', $getFoto[$i]));
						}
					}

				}else if ($links2 == "video") {

					$upd_data = array(
						'judul' => $this->input->post('judul'),
						'konten' => $this->input->post('video'),
					);
					
				}

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/galeri/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/galeri/'.$links2);
				}
			}else if ($links == "add") {
				$data = array(
					'page' => "admin/crud-galeri",
				);
			}else if ($links == "do_add") {
				$path = './assets/backend/dist/img/galeri/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();
				$this->load->library('upload', $config);

				$thumb['image_library']  = 'gd2';
        $thumb['create_thumb']   = TRUE;
        $thumb['maintain_ratio'] = TRUE;
        $thumb['width']          = 300;
        $thumb['height']         = 300;

				$ins_data = array(
					'id_galeri'  =>	"",
					'judul'			 => $this->input->post('judul'),
					'tanggal' 	 => date('Y-m-d'),
				);

				if ($links2 == "foto") {

					$input = sizeof($_FILES['foto']['tmp_name']);
					$files = $_FILES['foto'];
					for ($i=0; $i < $input ; $i++) {
		      	$_FILES['foto']['name'] = $files['name'][$i];
		      	$_FILES['foto']['type'] = $files['type'][$i];
		      	$_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
		      	$_FILES['foto']['error'] = $files['error'][$i];
		      	$_FILES['foto']['size'] = $files['size'][$i];
	          
		      	$this->upload->do_upload('foto');

		        $thumb['source_image']   = 'assets/backend/dist/img/galeri/'.$this->upload->file_name;
	          $this->load->library('image_lib');
	          $this->image_lib->initialize($thumb);
	          $this->image_lib->resize();

		      	$konten[] = $this->upload->file_name;
					}

					$ins_data['jenis_media'] = 'foto';
					$ins_data['konten'] = serialize($konten);

				}else if ($links2 == "video") {

					$ins_data['jenis_media'] = 'video';
					$ins_data['konten'] = $this->input->post('video');

				}else{

					show_404();

				}

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/galeri/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/galeri/'.$links2);
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/img/galeri/';
				$where = array('id_galeri' => $links2);

				$filefoto = $this->m_admin->getContent($tableName, $where);
				if ($filefoto[0]->jenis_media == "foto") {
					$konten = unserialize($filefoto[0]->konten);
					$n = sizeof($konten);
					for ($i=0; $i < $n ; $i++) { 
						unlink($path.$konten[$i]);
						unlink($path.str_replace('.', '_thumb.', $konten[$i]));
					}
				}

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/galeri/'.$filefoto[0]->jenis_media);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/galeri/'.$filefoto[0]->jenis_media);
				}
			}else{
				show_404();
			}
		}

		// echo "<pre>";
		// print_r($data);

		$this->load->view('admin/dashboard',$data);
	}

	public function kontak(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_profil';
		$tableName2 = 'tb_pesan';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "pesan") {
				$data = array(
					'data'	=> $this->m_admin->getPesan(),
				);
			}else if ($links == "link") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('link'),
				);
			}else if ($links == "alamat") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('alamat'),
				);
			}else if ($links == "person") {
				$data = array(
					'data'	=> $this->m_admin->getProfil('person'),
				);
			}else if ($links == "edit") {
				if ($links2 == 'pesan') {
					$get = array('id_pesan' => $links3);
					$upd_data = array('status' => 0);
					$tableName3 = $tableName2;
				}else if ($links2 == 'alamat') {
					$get =  array('jenis_profil' => $links2);
					$tableName3 = $tableName;

					$konten = array(
						'alamat'	=> $this->input->post('nama'),
						'maps'	=> $this->input->post('maps'),
					);

					$upd_data = array(
						'konten'	=> serialize($konten),
					);
				}else if ($links2 == 'link') {
					$tableName3 = $tableName;
					$path = './assets/backend/dist/img/profil/';
					$config['upload_path']		= $path;
					$config['allowed_types']	= 'jpeg|jpg|png|bmp';
					$config['max_size']				= '150000';
					$config['file_name']			= time();

					$this->load->library('upload', $config);
					$get =  array('id_profil' => $this->input->post('id'));

					$konten = array(
						'nama'	=> $this->input->post('nama'),
						'link'	=> $this->input->post('link'),
					);

					if ($_FILES['gambar2']['name'] == "") {
						$upd_data = array(
							'konten' => serialize($konten),
						);
					}else{
						if ( ! $this->upload->do_upload('gambar2')){
							$error = array('error' => $this->upload->display_errors());

							show_404();
			      }else{
			      	$thumb['image_library']  = 'gd2';
		          $thumb['source_image']   = 'assets/backend/dist/img/profil/'.$this->upload->file_name;
		          $thumb['create_thumb']   = TRUE;
		          $thumb['maintain_ratio'] = TRUE;
		          $thumb['width']          = 50;
		          $thumb['height']         = 50;
		          $this->load->library('image_lib', $thumb);
		          $this->image_lib->resize();

			      	$upd_data = array(
			      		'konten'	=> serialize($konten),
				      	'foto'		=> $this->upload->file_name,
			      	);

			      	$filefoto = $this->m_admin->getContent($tableName, $get);
							unlink($path.$filefoto[0]->foto);
							unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));
			      }
					}
				}else if ($links2 == 'person') {
					$tableName3 = $tableName;
					$get =  array('id_profil' => $this->input->post('id'));

					$konten = array(
						'nama'	=> $this->input->post('nama'),
						'nohp'	=> $this->input->post('nohp'),
					);

					$upd_data = array(
						'konten'	=> serialize($konten),
					);
				}

				$res 	= $this->m_admin->UpdateData($tableName3, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
			}else if ($links == "add") {
				if ($links2 == "link") {
					$path = './assets/backend/dist/img/profil/';
					$config['upload_path']		= $path;
					$config['allowed_types']	= 'jpeg|jpg|png|bmp';
					$config['max_size']				= '150000';
					$config['file_name']			= time();
					$this->load->library('upload', $config);

					$konten = array(
						'nama' => $this->input->post('nama'),
						'link' => $this->input->post('link'),
					);


          if ($_FILES['gambar']['name'] == "") {
						$ins_data = array(
							'id_profil'	=> "",
							'jenis_profil' => "link",
							'konten'	=> serialize($konten),
							'foto'	=> "",
						);
					}else{
						if ( ! $this->upload->do_upload('gambar')){
							$error = array('error' => $this->upload->display_errors());

							show_404();
			      }else{
			      	$thumb['image_library']  = 'gd2';
		          $thumb['source_image']   = 'assets/backend/dist/img/profil/'.$this->upload->file_name;
		          $thumb['create_thumb']   = TRUE;
		          $thumb['maintain_ratio'] = TRUE;
		          $thumb['width']          = 50;
		          $thumb['height']         = 50;
		          $this->load->library('image_lib', $thumb);
		          $this->image_lib->resize();

			      	$ins_data = array(
								'id_profil'	=> "",
								'jenis_profil' => "link",
								'konten'	=> serialize($konten),
								'foto'	=> $this->upload->file_name,
							);
			      }
					}
				}else if ($links2 == "person") {
					$konten = array(
						'nama' => $this->input->post('nama'),
						'nohp' => $this->input->post('nohp'),
					);

					$ins_data = array(
						'id_profil'	=> "",
						'jenis_profil' => "person",
						'konten'	=> serialize($konten),
						'foto'	=> "",
					);
				}

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/img/profil/';

				if ($links2 == "pesan") {
					$where = array('id_pesan' => $links3);
					$tableName3 = "tb_pesan";
				}else {
					$where = array('id_profil' => $links3);
					$tableName3 = "tb_profil";
				}

				$filefoto = $this->m_admin->getContent($tableName3, $where);
				unlink($path.$filefoto[0]->foto);
				unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));

				$res = $this->m_admin->DeleteData($tableName3, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/kontak/'.$links2);
				}
			}else{
				show_404();
			}
		}

		$data['page'] = "admin/kontak";
		$this->load->view('admin/dashboard',$data);
	}

	public function anggota(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_anggota';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "") {
				$data = array(
					'data'	=> $this->m_admin->getAnggota(),
				);
			}else if ($links == "edit") {
				$path = './assets/backend/dist/img/anggota/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();

				$this->load->library('upload', $config);
				$get =  array('id_anggota' => $this->input->post('id'));

				if ($_FILES['gambar2']['name'] == "") {
					$upd_data = array(
						'nama' => $this->input->post('nama'),
						'link_anggota' => $this->input->post('link'),
						'keterangan'	=> $this->input->post('keterangan'),
					);
				}else{
					if ( ! $this->upload->do_upload('gambar2')){
						$error = array('error' => $this->upload->display_errors());

						show_404();
		      }else{
		      	$thumb['image_library']  = 'gd2';
	          $thumb['source_image']   = 'assets/backend/dist/img/anggota/'.$this->upload->file_name;
	          $thumb['create_thumb']   = TRUE;
	          $thumb['maintain_ratio'] = TRUE;
	          $thumb['width']          = 300;
	          $thumb['height']         = 300;
	          $this->load->library('image_lib', $thumb);
	          $this->image_lib->resize();

						$upd_data = array(
							'nama' => $this->input->post('nama'),
			      	'foto'		=> $this->upload->file_name,
							'link_anggota' => $this->input->post('link'),
							'keterangan'	=> $this->input->post('keterangan'),
						);

		      	$filefoto = $this->m_admin->getContent($tableName, $get);
						unlink($path.$filefoto[0]->foto);
						unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));
		      }
				}

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/anggota/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/anggota/'.$links2);
				}
			}else if ($links == "add") {
				$path = './assets/backend/dist/img/anggota/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();
				$this->load->library('upload', $config);

				$ins_data = array(
					'id_anggota' =>	"",
					'nama'	=> $this->input->post('nama'),
					'link_anggota'	=> $this->input->post('link'),
					'keterangan'	=> $this->input->post('keterangan'),
				);


        if ($_FILES['gambar']['name'] == "") {
        	$ins_data['foto'] = "";
				}else{
					if ( ! $this->upload->do_upload('gambar')){
						$error = array('error' => $this->upload->display_errors());

						show_404();
		      }else{
		      	$thumb['image_library']  = 'gd2';
	          $thumb['source_image']   = 'assets/backend/dist/img/anggota/'.$this->upload->file_name;
	          $thumb['create_thumb']   = TRUE;
	          $thumb['maintain_ratio'] = TRUE;
	          $thumb['width']          = 300;
	          $thumb['height']         = 300;
	          $this->load->library('image_lib', $thumb);
	          $this->image_lib->resize();

		      	$ins_data['foto'] = $this->upload->file_name;
		      }
				}

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/anggota/'.$links2);
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/anggota/'.$links2);
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/img/anggota/';
				$where = array('id_anggota' => $links2);

				$filefoto = $this->m_admin->getContent($tableName, $where);
				unlink($path.$filefoto[0]->foto);
				unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/anggota');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/anggota');
				}
			}else{
				show_404();
			}
		}

		// echo "<pre>";
		// print_r($data);

		$data['page'] = "admin/anggota";
		$this->load->view('admin/dashboard',$data);
	}

	public function berita(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_berita';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "") {
				$data = array(
					// 'data'	=> $this->m_admin->getBerita(),
					'title' => 'MANAJEMEN BERITA WEBSITE',
					'page' => "admin/berita",
				);
			}else if ($links == "edit") {
				$get = array('id_berita'=>$links2);
				$data = array(
					'data' => $this->m_admin->getContent($tableName, $get),
					'page' => "admin/crud-berita",
				);
			}else if ($links == "do_edit") {
				$path = './assets/backend/dist/img/berita/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();

				$this->load->library('upload', $config);
				$get =  array('id_berita' => $this->input->post('id'));

				if ($_FILES['foto']['name'] == "") {
					$upd_data = array(
						'judul'			 => $this->input->post('judul'),
						'isi'				 => $this->input->post('editor1'),
					);
				}else{
					if ( ! $this->upload->do_upload('foto')){
						$error = array('error' => $this->upload->display_errors());

						show_404();
		      }else{
		      	$thumb['image_library']  = 'gd2';
	          $thumb['source_image']   = 'assets/backend/dist/img/berita/'.$this->upload->file_name;
	          $thumb['create_thumb']   = TRUE;
	          $thumb['maintain_ratio'] = TRUE;
	          $thumb['width']          = 800;
	          $thumb['height']         = 800;
	          $this->load->library('image_lib', $thumb);
	          $this->image_lib->resize();

						$upd_data = array(
			      	'foto'		=> $this->upload->file_name,
							'judul'			 => $this->input->post('judul'),
							'isi'				 => $this->input->post('editor1'),
						);

		      	$filefoto = $this->m_admin->getContent($tableName, $get);
						unlink($path.$filefoto[0]->foto);
						unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));
		      }
				}

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/berita');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/berita');
				}
			}else if ($links == "add") {
				$data = array(
					'page' => "admin/crud-berita",
				);
			}else if ($links == "do_add") {
				$path = './assets/backend/dist/img/berita/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp';
				$config['max_size']				= '150000';
				$config['file_name']			= time();
				$this->load->library('upload', $config);

				$ins_data = array(
					'id_berita'  =>	"",
					'judul'			 => $this->input->post('judul'),
					'isi'				 => $this->input->post('editor1'),
					'penulis'		 => "admin",
					'tgl_terbit' => date('Y-m-d'),
				);

        if ($_FILES['foto']['name'] == "") {
        	$ins_data['foto'] = "";
				}else{
					if ( ! $this->upload->do_upload('foto')){
						$error = array('error' => $this->upload->display_errors());

						show_404();
		      }else{
		      	$thumb['image_library']  = 'gd2';
	          $thumb['source_image']   = 'assets/backend/dist/img/berita/'.$this->upload->file_name;
	          $thumb['create_thumb']   = TRUE;
	          $thumb['maintain_ratio'] = TRUE;
	          $thumb['width']          = 800;
	          $thumb['height']         = 800;
	          $this->load->library('image_lib', $thumb);
	          $this->image_lib->resize();

		      	$ins_data['foto'] = $this->upload->file_name;
		      }
				}

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/berita');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/berita');
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/img/berita/';
				$where = array('id_berita' => $links2);

				$filefoto = $this->m_admin->getContent($tableName, $where);
				unlink($path.$filefoto[0]->foto);
				unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/berita');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/berita');
				}
			}else{
				show_404();
			}
		}

		// echo "<pre>";
		// print_r($data);

		$this->load->view('admin/dashboard', $data);
	}

	public function kegiatan(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_kegiatan';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "") {
				$data = array(
					'data'	=> $this->m_admin->getKegiatan(),
				);
			}else if ($links == "edit") {

				$get =  array('id_kegiatan' => $this->input->post('id'));

				$upd_data = array(
					'waktu'	=> $this->input->post('waktu'),
					'tempat'	=> $this->input->post('tempat'),
					'kegiatan'	=> $this->input->post('nama'),
					'keterangan'	=> $this->input->post('keterangan'),
				);

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/kegiatan');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/kegiatan');
				}
			}else if ($links == "add") {

				$ins_data = array(
					'id_kegiatan' =>	"",
					'waktu'	=> $this->input->post('waktu'),
					'tempat'	=> $this->input->post('tempat'),
					'kegiatan'	=> $this->input->post('nama'),
					'keterangan'	=> $this->input->post('keterangan'),
				);

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/kegiatan');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/kegiatan');
				}
			}else if ($links == "delete") {

				$where = array('id_kegiatan' => $links2);

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/kegiatan');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/kegiatan');
				}
			}else{
				show_404();
			}
		}

		$data['page'] = "admin/kegiatan";
		$this->load->view('admin/dashboard',$data);
	}

	public function forum(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_forum';

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "") {
				$data = array(
					'data'	=> $this->m_admin->getForum(),
					'page' => "admin/forum",
				);
			}else if ($links == "edit") {
				$get = array('id_forum'=>$links2);
				$data = array(
					'data' => $this->m_admin->getContent($tableName, $get),
					'page' => "admin/crud-forum",
				);
			}else if ($links == "do_edit") {
				$path = './assets/backend/dist/forum/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp|docx|doc|pdf';
				$config['max_size']				= '150000';

				$this->load->library('upload', $config);
				$get =  array('id_forum' => $this->input->post('id'));

				if ($_FILES['userfile']['name'] == "") {
					$upd_data = array(
						'judul'			 => $this->input->post('judul'),
						'isi'				 => $this->input->post('editor1'),
					);
				}else{
					if ( ! $this->upload->do_upload('userfile')){
						$error = array('error' => $this->upload->display_errors());
						$pesan = $error['error'];
						echo $pesan;
		      }else{
						$upd_data = array(
			      	'file'		=> $this->upload->file_name,
							'judul'		=> $this->input->post('judul'),
							'isi'			=> $this->input->post('editor1'),
						);

		      	$filefoto = $this->m_admin->getContent($tableName, $get);
						unlink($path.$filefoto[0]->file);
		      }
				}

				$res 	= $this->m_admin->UpdateData($tableName, $upd_data, $get);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil diubah.</div></section>');
					redirect('admin/forum');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal diubah.</div></section>');
					redirect('admin/forum');
				}
			}else if ($links == "add") {
				$data = array(
					'page' => "admin/crud-forum",
				);
			}else if ($links == "do_add") {
				$path = './assets/backend/dist/forum/';
				$config['upload_path']		= $path;
				$config['allowed_types']	= 'jpeg|jpg|png|bmp|docx|doc|pdf';
				$config['max_size']				= '100000';
				$this->load->library('upload', $config);

				$ins_data = array(
					'id_forum'  =>	"",
					'judul'			 => $this->input->post('judul'),
					'isi'				 => $this->input->post('editor1'),
					'penulis'		 => "admin",
					'tgl_terbit' => date('Y-m-d'),
				);

        if ($_FILES['userfile']['name'] == "") {
        	$ins_data['file'] = "";
				}else{
					if ( ! $this->upload->do_upload('userfile')){
						$error = array('error' => $this->upload->display_errors());
						$pesan = $error['error'];
						echo $pesan;
		      }else{
		      	$ins_data['file'] = $this->upload->file_name;
		      }
				}

				$res = $this->m_admin->InsertData($tableName, $ins_data);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil disimpan.</div></section>');
					redirect('admin/forum');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal disimpan.</div></section>');
					redirect('admin/forum');
				}
			}else if ($links == "delete") {
				$path = './assets/backend/dist/forum/';
				$where = array('id_forum' => $links2);

				$filefoto = $this->m_admin->getContent($tableName, $where);
				unlink($path.$filefoto[0]->file);

				$res = $this->m_admin->DeleteData($tableName, $where);
				if ($res) {
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Sukses</h4>Data berhasil dihapus.</div></section>');
					redirect('admin/forum');
				}
				else{
					$this->session->set_flashdata('notif','<section class="content" style="min-height: auto;"><div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Terjadi Kesalahan</h4>Data gagal dihapus.</div></section>');
					redirect('admin/forum');
				}
			}else{
				show_404();
			}
		}

		// echo "<pre>";
		// print_r($data);

		$this->load->view('admin/dashboard',$data);
	}

	public function getLogout(){
		if (empty($this->cek)) {
			header('location:'.site_url());
		}else{
  		$this->session->sess_destroy();
			header('location:'.site_url());
    }
  }
}
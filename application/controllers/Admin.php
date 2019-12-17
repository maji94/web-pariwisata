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
			'request' => $this->m_admin->getRequest(),
			'title'	=> "BERANDA ".strtoupper($this->set),
			'page'	=> "admin/a_main",
		);
		$this->load->view('admin/dashboard', $data);
		// echo "<pre>";
		// print_r($data);
	}

	//Upload image summernote
	public function upload_image(){
		if(isset($_FILES["image"]["name"])){
			$config['upload_path'] = './assets/images/editor/';
			$config['allowed_types'] = 'jpg|jpeg|png|gif';
	    $this->load->library('upload', $config);
			// $this->upload->initialize($config);
			if(!$this->upload->do_upload('image')){
				$this->upload->display_errors();
				return FALSE;
			}else{
				$data = $this->upload->data();
				//Compress Image
				$config['image_library']='gd2';
				$config['source_image']='./assets/images/editor/'.$data['file_name'];
				$config['create_thumb']= FALSE;
				$config['maintain_ratio']= TRUE;
				$config['quality']= '60%';
				$config['width']= 800;
				$config['height']= 800;
				$config['new_image']= './assets/images/editor/'.$data['file_name'];
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				echo base_url().'assets/images/editor/'.$data['file_name'];
			}
		}
	}

	//Delete image summernote
	public function delete_image(){
		$src = $this->input->post('src');
		$file_name = str_replace(base_url(), '', $src);
		if(unlink($file_name))
		{
			echo 'File Delete Successfully';
		}
	}

	public function test(){
		$this->load->view('test');
	}

	public function banner(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$tableName = 'tb_banner';

		$time = time();
    $path = './assets/images/banner/';
    $config['upload_path']    = $path;
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				if ($links2 == "headline") {
					$data_headline = array(
						'sambutan' => $this->input->post('sambutan'),
						'tagline' => $this->input->post('tagline'),
					);

					$upd_data = array('konten'=>serialize($data_headline));
					$where = array('jenis'=>"headline");
				}else if ($links2 == "foto") {
					$data_banner = array(
						'oleh' => $this->input->post('edit_oleh'),
					);

					if ($_FILES['edit_foto']['name'] == "") {
	          $data_banner['konten'] = $this->input->post('oldFoto');
	        }else{
	          if ( ! $this->upload->do_upload('edit_foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else{
	          	$data_banner['konten'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/banner/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto')));
	          }
	        }

	        $upd_data = $data_banner;
	        $where = array('id'=>$this->input->post('id'));
				}

				$upd_banner = $this->m_admin->UpdateData($tableName, $upd_data, $where);
				if($upd_banner){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/banner');
				}else {
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/banner');
				}
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_banner = array(
					'jenis'=>"foto",
					'oleh'=>$this->input->post('oleh'),
				);

				if ($_FILES['foto']['name'] == "") {
          $data_banner['konten'] = "";
        }else{
          if ( ! $this->upload->do_upload('foto')){ 
          $error = array('error' => $this->upload->display_errors());
          $pesan = $error['error'];
          echo $pesan;
          }else{
          	$data_banner['konten'] = $this->upload->file_name;

            $thumb['source_image'] = 'assets/images/banner/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();
            unlink($path.$this->upload->file_name);
          }
        }

        $ins_banner = $this->m_admin->InsertData($tableName, $data_banner);
        if ($ins_banner) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/banner');
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/banner');
        }
			}else if ($links == "delete") {
				$where = array('id'=>$links2);
        $filefoto = $this->m_admin->getContent($tableName, $where);
        $path = './assets/images/banner/';
        unlink($path.str_replace('.', '_thumb.', $filefoto[0]->konten));

        $del_banner = $this->m_admin->DeleteData($tableName, $where);
        if ($del_banner) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/banner');
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/banner');
        }
			}else if ($links == "naik") {
				$data_banner = array(
					'tanggal_naik' => date('Y-m-d H:i:s'),
				);

				$where = array('id' => $links2);
				$upd_banner = $this->m_admin->UpdateData($tableName, $data_banner, $where);
				if($upd_banner){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dinaikkan', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/banner/');
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dinaikkan', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/banner/');
				}
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data' => $this->m_admin->getBanner('foto'),
					'headline' => $this->m_admin->getBanner('headline'),
					'title' => 'Manajemen Banner',
					'page' => "admin/banner",
				);				
			}
		}
		$this->load->view('admin/dashboard', $data);
		// echo "<pre>";
		// print_r($data);
	}

	public function media(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_media';

		$time = time();
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => 'Tambah Data Media',
					'page' => "admin/crud_media",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				if ($links2 == "artikel") {
					$path = './assets/images/artikel/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

					$data_artikel = array(
						'judul'      => $this->input->post('judul'),
						'tanggal'    => $this->input->post('tanggal'),
						'jenis'      => "artikel",
						'oleh'       => $this->session->userdata('nama'),
						'konten'     => $this->input->post('isi'),
						'link_foto'  => $this->input->post('link_foto'),
						'link_video' => $this->input->post('link_video'),
						'dilihat'    => 1,
					);

					if ($_FILES['foto']['name'] == "") {
	          $data_artikel['headline'] = "";
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else{
	          	$data_artikel['headline'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/artikel/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	          }
	        }

					$data_media = $data_artikel;
				}else if ($links2 == "foto") {
					$path = './assets/images/foto/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

			    $data_foto = array(
			    	'judul'   => $this->input->post('judul'),
			    	'tanggal' => $this->input->post('tanggal'),
			    	'jenis'   => "foto",
						'oleh'    => $this->input->post('oleh'),
			    );

			    $input = sizeof($_FILES['foto']['tmp_name']);
          $files = $_FILES['foto'];
          for ($i=0; $i < $input ; $i++) {
            $_FILES['foto']['name'] = $files['name'][$i];
            $_FILES['foto']['type'] = $files['type'][$i];
            $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['foto']['error'] = $files['error'][$i];
            $_FILES['foto']['size'] = $files['size'][$i];
            
            $this->upload->do_upload('foto');

            $thumb['source_image']   = 'assets/images/foto/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();

            $konten[] = $this->upload->file_name;
          }

          for ($j=0; $j < $input; $j++) { 
            unlink($path.$konten[$j]);
          }

          $data_foto['konten'] = serialize($konten);
          $data_media = $data_foto;
				}else if ($links2 == "video") {
					$path = './assets/images/video/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

					$data_video = array(
						'judul'      => $this->input->post('judul'),
						'tanggal'    => $this->input->post('tanggal'),
						'jenis'      => "video",
						'konten'     => $this->input->post('konten'),
					);

					if ($_FILES['foto']['name'] == "") {
	          $data_video['headline'] = "";
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else{
	          	$data_video['headline'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/video/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	          }
	        }

					$data_media = $data_video;
				}

				$ins_media = $this->m_admin->InsertData($tableName, $data_media);
        if ($ins_media) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/media/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/media/'.$links2);
        }
			}else  if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => 'Ubah Data Media',
					'page'  => 'admin/crud_media',
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				if ($links2 == "artikel") {
					$path = './assets/images/artikel/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

			    $data_artikel = array(
			    	'judul'      => $this->input->post('judul'),
			    	'tanggal'    => $this->input->post('tanggal'),
			    	'konten'     => $this->input->post('isi'),
			    	'link_foto'  => $this->input->post('link_foto'),
			    	'link_video' => $this->input->post('link_video'),
			    );

			    if ($_FILES['foto']['name'] == "") {
	          $data_artikel['headline'] = $this->input->post('oldFoto');
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else{
	          	$data_artikel['headline'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/artikel/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto')));
	          }
	        }

					$data_media = $data_artikel;
				}else if ($links2 == "foto") {
					$path = './assets/images/foto/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

			    $get =  array('id' => $this->input->post('id'));
          $getData = $this->m_admin->getContent($tableName, $get);
          $getFoto = unserialize($getData[0]->konten);
          $n_getFoto = sizeof($getFoto);

          $input = sizeof($_FILES['foto']['tmp_name']);
          $files = $_FILES['foto'];

          // echo "<pre>";
          // print_r($input);
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
              $konten[] = $this->input->post('oldFoto')[$i];
            }
            
            $thumb['source_image'] = 'assets/images/foto/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();
          }

          $data_foto = array(
            'judul'   => $this->input->post('judul'),
            'tanggal' => $this->input->post('tanggal'),
            'konten'  => serialize($konten),
            'oleh'    => $this->input->post('oleh'),
          );

          for ($i=0; $i < $n_getFoto; $i++) { 
            if (in_array($getFoto[$i], $konten) == FALSE) {
              unlink($path.str_replace('.', '_thumb.', $getFoto[$i]));
            }
          }

          for ($j=0; $j < $input; $j++) { 
            unlink($path.$konten[$j]);
          }

          $data_media = $data_foto;
				}else if ($links2 == "video") {
					$path = './assets/images/video/';
			    $config['upload_path']    = $path;
			    $this->load->library('upload', $config);

			    $data_video = array(
						'judul'      => $this->input->post('judul'),
						'tanggal'    => $this->input->post('tanggal'),
						'oleh'       => $this->input->post('oleh'),
						'konten'     => $this->input->post('konten'),
					);

			    if ($_FILES['foto']['name'] == "") {
	          $data_video['headline'] = $this->input->post('oldFoto');
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else{
	          	$data_video['headline'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/video/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto')));
	          }
	        }

					$data_media = $data_video;
				}

				$where = array('id' => $this->input->post('id'));
				$upd_media = $this->m_admin->UpdateData($tableName, $data_media, $where);
				if($upd_media){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/media/'.$links2);
				}else {
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/media/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);

        if ($links2 == "artikel") {
        	$explode = explode("img", $filefoto[0]->konten);
	        foreach ($explode as $d) {
	        	$cut_text = substr($d, strpos($d, "editor/"));
	        	$num_char = 2;
	        	$char     = $cut_text{$num_char-1};
						while($char != ' ') {
							$char = $cut_text{++$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
						}
						$cut_text2 = substr($cut_text, (strpos($cut_text, "editor/")+7), ($num_char-7));
										
						if (strpos($d, "editor/") != 0) {
		        	$carigambar[] = str_replace('"', "", $cut_text2);
						}
	        }

	        $path = './assets/images/artikel/';
	        $path2 = './assets/images/editor/';
	        unlink($path.str_replace('.', '_thumb.', $filefoto[0]->headline));
	        foreach ($carigambar as $c) {
		        unlink($path2.$c);
	        }
        }else if ($links2 == "video") {
        	$path = './assets/images/video/';
	        unlink($path.str_replace('.', '_thumb.', $filefoto[0]->headline));
        }else if ($links2 == "foto") {
            $path = './assets/images/foto/';
            $filefoto = $this->m_admin->getContent($tableName, $where);
            $konten = unserialize($filefoto[0]->konten);
            $n = sizeof($konten);
            for ($i=0; $i < $n ; $i++) {
              unlink($path.str_replace('.', '_thumb.', $konten[$i]));
            }
        }
        
        $del_media = $this->m_admin->DeleteData($tableName, $where);
        if ($del_media) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/media/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/media/'.$links2);
        }
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data' => $this->m_admin->getContent($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Media Website',
					'page' => "admin/media",
				);
			}
		}
		$this->load->view('admin/dashboard', $data);
		// echo "<pre>";
		// print_r($explode);
		// echo "<br>";
		// print_r($carigambar);
	}

	public function kreatif(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_kreatif';

		$time = time();
		$path = './assets/images/kreatif/';
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
    $config['upload_path']    = $path;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => "Tambah Data Kreatif",
					'page' => "admin/crud_kreatif",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_kreatif = array(
					'jenis'			   => $links2,
					'nama'         => $this->input->post('nama'),
					'konten'       => $this->input->post('konten'),
					'link_video'   => $this->input->post('link_video'),
					'link_maps'    => $this->input->post('link_maps'),
					'tanggal_naik' => date('Y-m-d H:i:s'),
				);

        $input = sizeof($_FILES['foto']['tmp_name']);
        $files = $_FILES['foto'];
        for ($i=0; $i < $input ; $i++) {
          $_FILES['foto']['name'] = $files['name'][$i];
          $_FILES['foto']['type'] = $files['type'][$i];
          $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['foto']['error'] = $files['error'][$i];
          $_FILES['foto']['size'] = $files['size'][$i];
          $this->upload->do_upload('foto');

          $thumb['source_image']   = 'assets/images/kreatif/'.$this->upload->file_name;
          $this->load->library('image_lib');
          $this->image_lib->initialize($thumb);
          $this->image_lib->resize();

          $foto_galeri[] = $this->upload->file_name;
        }

        for ($j=0; $j < $input; $j++) { 
          unlink($path.$foto_galeri[$j]);
        }

        $data_kreatif['foto_galeri'] = serialize($foto_galeri);
        $ins_kreatif = $this->m_admin->InsertData($tableName, $data_kreatif);
        if ($ins_kreatif) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/kreatif/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/kreatif/'.$links2);
        }
			}else if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => "Ubah Data Kreatif",
					'page'  => "admin/crud_kreatif",
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				$data_kreatif = array(
					'nama'       => $this->input->post('nama'),
					'konten'     => $this->input->post('konten'),
					'link_video' => $this->input->post('link_video'),
					'link_maps'  => $this->input->post('link_maps'),
				);

        $get =  array('id' => $this->input->post('id'));
        $getData = $this->m_admin->getContent($tableName, $get);
        $getFoto = unserialize($getData[0]->foto_galeri);
        $n_getFoto = sizeof($getFoto);

        $input = sizeof($_FILES['foto']['tmp_name']);
        $files = $_FILES['foto'];

        // echo "<pre>";
        // print_r($input);
        for ($i=0; $i < $input ; $i++) {

          $_FILES['foto']['name'] = $files['name'][$i];
          $_FILES['foto']['type'] = $files['type'][$i];
          $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['foto']['error'] = $files['error'][$i];
          $_FILES['foto']['size'] = $files['size'][$i];
          
          if ($_FILES['foto']['name']) {     	
            $this->upload->do_upload('foto');
            $foto_galeri[] = $this->upload->file_name;

            $thumb['source_image'] = 'assets/images/kreatif/'.$this->upload->file_name;
	          $this->load->library('image_lib');
	          $this->image_lib->initialize($thumb);
	          $this->image_lib->resize();
          }else{
            $foto_galeri[] = $this->input->post('oldFoto')[$i];
          }
        }

        $data_kreatif['foto_galeri'] = serialize($foto_galeri);

        for ($i=0; $i < $n_getFoto; $i++) { 
          if (in_array($getFoto[$i], $foto_galeri) == FALSE) {
            unlink($path.str_replace('.', '_thumb.', $getFoto[$i]));
          }
        }

        for ($j=0; $j < $input; $j++) { 
          unlink($path.$foto_galeri[$j]);
        }

        $where = array('id' => $this->input->post('id'));
				$upd_kreatif = $this->m_admin->UpdateData($tableName, $data_kreatif, $where);
				if($upd_kreatif){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/kreatif/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/kreatif/'.$links2);
				}
			}else if ($links == "naik") {
				$data_kreatif = array(
					'tanggal_naik' => date('Y-m-d H:i:s'),
				);

				$where = array('id' => $links3);
				$upd_kreatif = $this->m_admin->UpdateData($tableName, $data_kreatif, $where);
				if($upd_kreatif){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dinaikkan', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/kreatif/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dinaikkan', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/kreatif/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);

        //START - MENGHAPUS FOTO YANG ADA DI EDITOR        
      	$explode = explode("img", $filefoto[0]->konten);
        foreach ($explode as $d) {
        	$cut_text = substr($d, strpos($d, "editor/"));
        	$num_char = 2;
        	$char     = $cut_text{$num_char-1};
					while($char != ' ') {
						$char = $cut_text{++$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
					}
					$cut_text2 = substr($cut_text, (strpos($cut_text, "editor/")+7), ($num_char-7));
									
					if (strpos($d, "editor/") != 0) {
	        	$carigambar[] = str_replace('"', "", $cut_text2);
					}					
        }

        $path = './assets/images/kreatif/';
        $path2 = './assets/images/editor/';
        foreach ($carigambar as $c) {
	        unlink($path2.$c);
        }
        // END

        $foto_galeri = unserialize($filefoto[0]->foto_galeri);
        $n = sizeof($foto_galeri);
        for ($i=0; $i < $n ; $i++) {
          unlink($path.str_replace('.', '_thumb.', $foto_galeri[$i]));
        }
        
        $del_kreatif = $this->m_admin->DeleteData($tableName, $where);
        if ($del_kreatif) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/kreatif/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/kreatif/'.$links2);
        }
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent2($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Kreatif',
					'page'  => "admin/kreatif",
				);				
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	public function atraksi(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_atraksi';

		$time = time();
		$path = './assets/images/'.$links2.'/';
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
		$config['upload_path']    = $path;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => 'Tambah Data Atraksi',
					'page' => "admin/crud_atraksi",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_atraksi = array(
					'jenis'			 => $links2,
					'nama'       => $this->input->post('nama'),
					'konten'     => $this->input->post('konten'),
					'link_foto'	 => $this->input->post('link_foto'),
					'link_video' => $this->input->post('link_video'),
					'link_maps'  => $this->input->post('link_maps'),
				);

				if ($_FILES['headline']['name'] == "") {
          $data_atraksi['foto_headline'] = "";
        }else{
          if ( ! $this->upload->do_upload('headline')){
          $error = array('error' => $this->upload->display_errors());
          $pesan = $error['error'];
          echo $pesan;
          }else{
          	$data_atraksi['foto_headline'] = $this->upload->file_name;

            $thumb['source_image'] = 'assets/images/'.$links2.'/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();
            unlink($path.$this->upload->file_name);
          }
        }

        $ins_atraksi = $this->m_admin->InsertData($tableName, $data_atraksi);
        if ($ins_atraksi) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/atraksi/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/atraksi/'.$links2);
        }
			}else if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => "Ubah Data Atraksi",
					'page'  => "admin/crud_atraksi",
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				$data_atraksi = array(
					'nama'       => $this->input->post('nama'),
					'konten'     => $this->input->post('konten'),
					'link_foto'	 => $this->input->post('link_foto'),
					'link_video' => $this->input->post('link_video'),
					'link_maps'  => $this->input->post('link_maps'),
				);

				if ($_FILES['headline']['name'] == "") {
          $data_atraksi['foto_headline'] = $this->input->post('oldFoto_headline');
        }else{
          if ( ! $this->upload->do_upload('headline')){ 
          $error = array('error' => $this->upload->display_errors());
          $pesan = $error['error'];
          echo $pesan;
          }else{
          	$data_atraksi['foto_headline'] = $this->upload->file_name;

            $thumb['source_image'] = 'assets/images/'.$links2.'/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();
            unlink($path.$this->upload->file_name);
            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto_headline')));
          }
        }
				
        $where = array('id' => $this->input->post('id'));
				$upd_atraksi = $this->m_admin->UpdateData($tableName, $data_atraksi, $where);
				if($upd_atraksi){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/atraksi/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/atraksi/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);

        //START - MENGHAPUS FOTO YANG ADA DI EDITOR        
      	$explode = explode("img", $filefoto[0]->konten);
        foreach ($explode as $d) {
        	$cut_text = substr($d, strpos($d, "editor/"));
        	$num_char = 2;
        	$char     = $cut_text{$num_char-1};
					while($char != ' ') {
						$char = $cut_text{++$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
					}
					$cut_text2 = substr($cut_text, (strpos($cut_text, "editor/")+7), ($num_char-7));
									
					if (strpos($d, "editor/") != 0) {
	        	$carigambar[] = str_replace('"', "", $cut_text2);
					}					
        }

        $path = './assets/images/'.$links2.'/';
        $path2 = './assets/images/editor/';
        foreach ($carigambar as $c) {
	        unlink($path2.$c);
        }
        unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto_headline));
        // END

        $del_kreatif = $this->m_admin->DeleteData($tableName, $where);
        if ($del_kreatif) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/atraksi/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/atraksi/'.$links2);
        }
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Atrkasi',
					'page'  => "admin/atraksi",
				);
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	public function akomodasi(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_akomodasi';


		$time = time();
		$path = './assets/images/'.$links2.'/';
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
    $config['upload_path']    = $path;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => 'Tambah Data Akomodasi',
					'page' => "admin/crud_akomodasi",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_akomodasi = array(
					'jenis'			 => $links2,
					'nama'       => $this->input->post('nama'),
					'konten'     => $this->input->post('konten'),
				);

				if ($links2 != "transportasi") {
					$data_akomodasi['link_video'] = $this->input->post('link_video');
					$data_akomodasi['link_maps']  = $this->input->post('link_maps');
				}

        $input = sizeof($_FILES['foto']['tmp_name']);
        $files = $_FILES['foto'];
        for ($i=0; $i < $input ; $i++) {
          $_FILES['foto']['name'] = $files['name'][$i];
          $_FILES['foto']['type'] = $files['type'][$i];
          $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['foto']['error'] = $files['error'][$i];
          $_FILES['foto']['size'] = $files['size'][$i];
          $this->upload->do_upload('foto');

          $thumb['source_image']   = 'assets/images/'.$links2.'/'.$this->upload->file_name;
          $this->load->library('image_lib');
          $this->image_lib->initialize($thumb);
          $this->image_lib->resize();

          $foto_galeri[] = $this->upload->file_name;
        }

        for ($j=0; $j < $input; $j++) { 
          unlink($path.$foto_galeri[$j]);
        }

        $data_akomodasi['foto_galeri'] = serialize($foto_galeri);
        $ins_kreatif = $this->m_admin->InsertData($tableName, $data_akomodasi);
        if ($ins_kreatif) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/akomodasi/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/akomodasi/'.$links2);
        }
			}else if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => "Ubah Data Akomodasi",
					'page'  => "admin/crud_akomodasi",
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				$data_kreatif = array(
					'nama'       => $this->input->post('nama'),
					'konten'     => $this->input->post('konten'),
				);

				if ($links2 != "transportasi") {
					$data_akomodasi['link_video'] = $this->input->post('link_video');
					$data_akomodasi['link_maps']  = $this->input->post('link_maps');
				}

        $get =  array('id' => $this->input->post('id'));
        $getData = $this->m_admin->getContent($tableName, $get);
        $getFoto = unserialize($getData[0]->foto_galeri);
        $n_getFoto = sizeof($getFoto);

        $input = sizeof($_FILES['foto']['tmp_name']);
        $files = $_FILES['foto'];

        // echo "<pre>";
        // print_r($input);
        for ($i=0; $i < $input ; $i++) {

          $_FILES['foto']['name'] = $files['name'][$i];
          $_FILES['foto']['type'] = $files['type'][$i];
          $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['foto']['error'] = $files['error'][$i];
          $_FILES['foto']['size'] = $files['size'][$i];
          
          if ($_FILES['foto']['name']) {     	
            $this->upload->do_upload('foto');
            $foto_galeri[] = $this->upload->file_name;

            $thumb['source_image'] = 'assets/images/'.$links2.'/'.$this->upload->file_name;
	          $this->load->library('image_lib');
	          $this->image_lib->initialize($thumb);
	          $this->image_lib->resize();
          }else{
            $foto_galeri[] = $this->input->post('oldFoto')[$i];
          }
        }

        $data_kreatif['foto_galeri'] = serialize($foto_galeri);

        for ($i=0; $i < $n_getFoto; $i++) { 
          if (in_array($getFoto[$i], $foto_galeri) == FALSE) {
            unlink($path.str_replace('.', '_thumb.', $getFoto[$i]));
          }
        }

        for ($j=0; $j < $input; $j++) { 
          unlink($path.$foto_galeri[$j]);
        }

        $where = array('id' => $this->input->post('id'));
				$upd_kreatif = $this->m_admin->UpdateData($tableName, $data_kreatif, $where);
				if($upd_kreatif){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/akomodasi/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/akomodasi/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);

        //START - MENGHAPUS FOTO YANG ADA DI EDITOR        
      	$explode = explode("img", $filefoto[0]->konten);
        foreach ($explode as $d) {
        	$cut_text = substr($d, strpos($d, "editor/"));
        	$num_char = 2;
        	$char     = $cut_text{$num_char-1};
					while($char != ' ') {
						$char = $cut_text{++$num_char}; // Cari spasi pada posisi 49, 48, 47, dst...
					}
					$cut_text2 = substr($cut_text, (strpos($cut_text, "editor/")+7), ($num_char-7));
									
					if (strpos($d, "editor/") != 0) {
	        	$carigambar[] = str_replace('"', "", $cut_text2);
					}					
        }

        $path = './assets/images/'.$links2.'/';
        $path2 = './assets/images/editor/';
        foreach ($carigambar as $c) {
	        unlink($path2.$c);
        }
        // END

        $foto_galeri = unserialize($filefoto[0]->foto_galeri);
        $n = sizeof($foto_galeri);
        for ($i=0; $i < $n ; $i++) {
          unlink($path.str_replace('.', '_thumb.', $foto_galeri[$i]));
        }
        
        $del_kreatif = $this->m_admin->DeleteData($tableName, $where);
        if ($del_kreatif) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/akomodasi/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/akomodasi/'.$links2);
        }
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Akomodasi',
					'page'  => "admin/akomodasi",
				);
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	public function layanan(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_layanan';


		$time = time();
		$path = './assets/dokumen/'.$links2.'/';
    $config['allowed_types']  = 'pdf|doc|docx|xls|xlsx';
    $config['max_size']       = '150000';
    // $config['file_name']      = $time;
    $config['upload_path']    = $path;
    $this->load->library('upload', $config);

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => 'Tambah Data Layanan',
					'page' => "admin/crud_layanan",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_layanan = array(
					'jenis'			 => $links2,
					'nama'       => $this->input->post('nama'),
					'tahun'    	 => $this->input->post('tahun'),
					'keterangan' => $this->input->post('keterangan'),
				);

        if ($_FILES['dokumen']['name'] == "") {
          $data_layanan['konten'] = "";
        }else{
          if ( ! $this->upload->do_upload('dokumen')){ 
          $error = array('error' => $this->upload->display_errors());
          $pesan = $error['error'];
          echo $pesan;
          }else{
          	$data_layanan['konten'] = $this->upload->file_name;
          }
        }

        $ins_layanan = $this->m_admin->InsertData($tableName, $data_layanan);
        if ($ins_layanan) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/layanan/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/layanan/'.$links2);
        }
			}else if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => "Ubah Data Layanan",
					'page'  => "admin/crud_layanan",
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				$data_layanan = array(
					'nama'       => $this->input->post('nama'),
					'tahun'    	 => $this->input->post('tahun'),
					'keterangan' => $this->input->post('keterangan'),
				);

        if ($_FILES['dokumen']['name'] == "") {
          $data_layanan['konten'] = $this->input->post('oldDokumen');
        }else{
          if ( ! $this->upload->do_upload('dokumen')){ 
          $error = array('error' => $this->upload->display_errors());
          $pesan = $error['error'];
          echo $pesan;
          }else{
          	$data_layanan['konten'] = $this->upload->file_name;
            unlink($path.$this->input->post('oldDokumen'));
          }
        }

        $where = array('id' => $this->input->post('id'));
				$upd_layanan = $this->m_admin->UpdateData($tableName, $data_layanan, $where);
				if($upd_layanan){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/layanan/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/layanan/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);
        $path = './assets/dokumen/'.$links2.'/';
        unlink($path.$filefoto[0]->konten);
        
        $del_layanan = $this->m_admin->DeleteData($tableName, $where);
        if ($del_layanan) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/layanan/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/layanan/'.$links2);
        }
			}else if ($links == "tandai") {
				$data_layanan = array(
					'status'       => 0,
				);

				$where = array('id' => $links3);
				$upd_layanan = $this->m_admin->UpdateData($tableName, $data_layanan, $where);
				if($upd_layanan){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditandai sudah dibaca', 'success','icofont icofont-tick-mark');\"");
					redirect('admin/layanan/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal ditandai sudah dibaca', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/layanan/'.$links2);
				}
			}
			else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Layanan',
					'page'  => "admin/layanan",
				);
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	public function tentang(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_tentang';
		$pesan = "";
		$data_tentang = array();

		$time = time();
		$path = './assets/images/tentang/';
    $config['allowed_types']  = 'pdf|jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
    $config['upload_path']    = $path;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($links == "add") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'title' => "Tambah Data Tentang",
					'page' => "admin/crud_tentang",
				);
			}else if ($links == "do_add") {
				ini_set('memory_limit', '1024M');
				$data_tentang = array(
					'jenis'   => $links2,
					'nama'    => $this->input->post('nama'),
					'tanggal' => $this->input->post('tanggal'),
					'oleh'    => $this->input->post('oleh'),
				);

        $input = sizeof($_FILES['foto']['tmp_name']);
        $files = $_FILES['foto'];
        for ($i=0; $i < $input ; $i++) {
          $_FILES['foto']['name'] = $files['name'][$i];
          $_FILES['foto']['type'] = $files['type'][$i];
          $_FILES['foto']['tmp_name'] = $files['tmp_name'][$i];
          $_FILES['foto']['error'] = $files['error'][$i];
          $_FILES['foto']['size'] = $files['size'][$i];
          $this->upload->do_upload('foto');

          $thumb['source_image']   = 'assets/images/tentang/'.$this->upload->file_name;
          $this->load->library('image_lib');
          $this->image_lib->initialize($thumb);
          $this->image_lib->resize();

          $konten[] = $this->upload->file_name;
        }

        for ($j=0; $j < $input; $j++) { 
          unlink($path.$konten[$j]);
        }

        $data_tentang['konten'] = serialize($konten);
        $ins_tentang = $this->m_admin->InsertData($tableName, $data_tentang);
        if ($ins_tentang) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/tentang/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/tentang/'.$links2);
        }
			}else if ($links == "edit") {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('id'=>$links3)),
					'title' => "Ubah Data Tentang",
					'page'  => "admin/crud_tentang",
				);
			}else if ($links == "do_edit") {
				ini_set('memory_limit', '1024M');
				if ($links2 == "profil") {
					$data_tentang['konten'] = $this->input->post('konten');
				}else if ($links2 == "galeri") {
					$get =  array('id' => $this->input->post('id'));
          $getData = $this->m_admin->getContent($tableName, $get);
          $getFoto = unserialize($getData[0]->konten);
          $n_getFoto = sizeof($getFoto);

          $input = sizeof($_FILES['foto']['tmp_name']);
          $files = $_FILES['foto'];

          // echo "<pre>";
          // print_r($input);
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
              $konten[] = $this->input->post('oldFoto')[$i];
            }
            
            $thumb['source_image'] = 'assets/images/tentang/'.$this->upload->file_name;
            $this->load->library('image_lib');
            $this->image_lib->initialize($thumb);
            $this->image_lib->resize();
          }

          $data_tentang['nama'] = $this->input->post('nama');
					$data_tentang['tanggal'] = $this->input->post('tanggal');
					$data_tentang['oleh'] = $this->input->post('oleh');
					$data_tentang['konten'] = serialize($konten);

          for ($i=0; $i < $n_getFoto; $i++) { 
            if (in_array($getFoto[$i], $konten) == FALSE) {
              unlink($path.str_replace('.', '_thumb.', $getFoto[$i]));
            }
          }

          for ($j=0; $j < $input; $j++) { 
            unlink($path.$konten[$j]);
          }
				}else if ($links2 == "struktur") {
					if ($_FILES['foto']['name'] == "") {
	          $data_tentang['konten'] = $this->input->post('oldFoto');
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          }else {
	          	$data_tentang['konten'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/tentang/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto')));
	          }
	        }
				}

        $where = array('id'=>$this->input->post('id'));
				$upd_tentang = $this->m_admin->UpdateData($tableName, $data_tentang, $where);
				if($upd_tentang){
					$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
					$this->session->set_flashdata('pesan', $pesan);
					redirect('admin/tentang/'.$links2);
				}else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
					$this->session->set_flashdata('pesan', $pesan);
					redirect('admin/tentang/'.$links2);
				}
			}else if ($links == "delete") {
				$where = array('id'=>$links3);
        $filefoto = $this->m_admin->getContent($tableName, $where);
        $konten = unserialize($filefoto[0]->konten);
        $n = sizeof($konten);
        for ($i=0; $i < $n ; $i++) {
          unlink($path.str_replace('.', '_thumb.', $konten[$i]));
        }
        
        $del_konten = $this->m_admin->DeleteData($tableName, $where);
        if ($del_konten) {
        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
          redirect('admin/tentang/'.$links2);
        }else{
					$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
					redirect('admin/tentang/'.$links2);
        }
			}else {
				$data = array(
					'request' => $this->m_admin->getRequest(),
					'data'  => $this->m_admin->getContent($tableName, array('jenis'=>$links)),
					'title' => 'Manajemen Tentang',
				);
				if ($links == "struktur" OR $links == "profil") {
					$data['page']  = "admin/crud_tentang";
				}else{
					$data['page']  = "admin/tentang";
				}
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	public function operator(){
		$links = $this->uri->segment(3);
		$links2 = $this->uri->segment(4);
		$links3 = $this->uri->segment(5);
		$tableName = 'tb_user';

		$time = time();
		$path = './assets/images/user/';
    $config['allowed_types']  = 'jpeg|jpg|png|bmp';
    $config['max_size']       = '150000';
    $config['file_name']      = $time;
    $config['upload_path']    = $path;
    $this->load->library('upload', $config);

    $thumb['image_library']  = 'gd2';
    $thumb['create_thumb']   = TRUE;
    $thumb['maintain_ratio'] = TRUE;
    $thumb['width']          = 2000;

		if(!isset($_SESSION['logged_in'])){
			redirect('login');
		}else{
			if ($this->set == "operator") {
				redirect('admin');
			}else {
				if ($links == "ubah_psw") {
					$data_password = array(
						'password' => md5($this->security->xss_clean($this->input->post('konf_psw'))),
					);

					$where = array('id_user'=>$this->input->post('id'));
					$upd_password = $this->m_admin->UpdateData($tableName, $data_password, $where);
					if($upd_password){
						$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
						redirect('admin/operator/');
					}else{
						$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
						redirect('admin/operator/');
					}
				}else if ($links == "do_add") {
					ini_set('memory_limit', '1024M');
					$data_operator = array(
						'nama'    	=> $this->input->post('nama'),
						'username'  => $this->input->post('username'),
						'password'  => md5($this->input->post('username')),
						'level' 		=> $this->input->post('level'),
					);

	        if ($_FILES['foto']['name'] == "") {
	          $data_operator['foto'] = "";
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else {
	          	$data_operator['foto'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/user/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	          }
	        }

	        $ins_operator = $this->m_admin->InsertData($tableName, $data_operator);
	        if ($ins_operator) {
	        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil ditambahkan', 'success','icofont icofont-tick-mark');\"");
	          redirect('admin/operator/');
	        }else{
						$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
						redirect('admin/operator/');
	        }
				}else if ($links == "do_edit") {
					ini_set('memory_limit', '1024M');
					$data_operator = array(
						'nama'    	=> $this->input->post('nama'),
						'username'  => $this->input->post('username'),
						'level' 		=> $this->input->post('level'),
					);

					if ($_FILES['foto']['name'] == "") {
	          $data_operator['foto'] = $this->input->post('oldFoto');
	        }else{
	          if ( ! $this->upload->do_upload('foto')){ 
	          $error = array('error' => $this->upload->display_errors());
	          $pesan = $error['error'];
	          echo $pesan;
	          }else {
	          	$data_operator['foto'] = $this->upload->file_name;

	            $thumb['source_image'] = 'assets/images/user/'.$this->upload->file_name;
	            $this->load->library('image_lib');
	            $this->image_lib->initialize($thumb);
	            $this->image_lib->resize();
	            unlink($path.$this->upload->file_name);
	            unlink($path.str_replace('.', '_thumb.', $this->input->post('oldFoto')));
	          }
	        }

	        $where = array('id_user'=>$this->input->post('id'));
					$upd_operator = $this->m_admin->UpdateData($tableName, $data_operator, $where);
					if($upd_operator){
						$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil diubah', 'success','icofont icofont-tick-mark');\"");
						redirect('admin/operator/');
					}else{
						$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal diubah', 'danger','icofont icofont-warning-alt');\"");
						redirect('admin/operator/');
					}
				}else if ($links == "delete") {
					$where = array('id_user'=>$links2);
	        $filefoto = $this->m_admin->getContent($tableName, $where);
	        unlink($path.str_replace('.', '_thumb.', $filefoto[0]->foto));
	        
	        $del_operator = $this->m_admin->DeleteData($tableName, $where);
	        if ($del_operator) {
	        	$this->session->set_flashdata('notif', "onload=\"notify(' Sukses !!. ','Data berhasil dihapus', 'success','icofont icofont-tick-mark');\"");
	          redirect('admin/operator/'.$links2);
	        }else{
						$this->session->set_flashdata('notif', "onload=\"notify(' Terjadi Kesalahan !!. ','Data gagal dihapus', 'danger','icofont icofont-warning-alt');\"");
						redirect('admin/operator/'.$links2);
	        }
				}else {
					$data = array(
						'request' => $this->m_admin->getRequest(),
						'data'  => $this->m_admin->getContent($tableName, array('level'=>"operator")),
						'page'  => 'admin/operator',
						'title' => 'Manajemen Operator',
					);
				}
			}
		}

		$this->load->view('admin/dashboard', $data);
	}

	// ==========================
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
				ini_set('memory_limit', '1024M');
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
	// ==========================
		
	public function getLogout(){
		if (empty($this->cek)) {
			header('location:'.site_url());
		}else{
  		$this->session->sess_destroy();
			header('location:'.site_url());
    }
  }
}
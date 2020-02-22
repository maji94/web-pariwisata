<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function getLogin($data)
  {
    $data = $this->db->get_where('tb_user', $data);
    return $data->result();
  }

  public function getContent($tableName, $id = null, $where = null)
  {
    if ($where != null) {
      $this->db->where('status', $where);
    }
    $this->db->order_by('id','DESC');
    $data = $this->db->get_where($tableName, $id);
    return $data->result();
  }

  public function getContent2($tableName, $id = null, $limit = null)
  {
    if ($limit != null) {
      $this->db->limit($limit);
    }
    if ($tableName == "tb_kreatif") {
      $this->db->order_by('tanggal_naik', 'DESC');
      $this->db->order_by('id', 'DESC');
    } else {
      $this->db->order_by('id', 'DESC');
    }
    $data = $this->db->get_where($tableName, $id);
    return $data->result();
  }

  public function getBanner($jenis = null, $limit = null)
  {
    $this->db->select('*');
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($limit != null) {
      $this->db->limit($limit);
    }
    $this->db->order_by('tanggal_naik', 'DESC');
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_banner');
    return $data->result();
  }

  public function getMedia($jenis = null, $limit = null, $offset = null)
  {
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
      $this->db->where('status', "1");
    }
    if ($limit != null) {
      $this->db->limit($limit, $offset);
    }
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_media');
    return $data->result();
  }

  public function getAtraksi($jenis = null, $limit = null, $offset = null)
  {
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($limit != null) {
      $this->db->limit($limit, $offset);
    }
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_atraksi');
    return $data->result();
  }

  public function getKreatif($jenis = null, $limit = null, $offset = null)
  {
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($limit != null) {
      $this->db->limit($limit, $offset);
    }
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_kreatif');
    return $data->result();
  }

  public function getAkomodasi($jenis = null, $limit = null, $offset = null)
  {
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($limit != null) {
      $this->db->limit($limit, $offset);
    }
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_akomodasi');
    return $data->result();
  }

  public function getTentang($jenis = null, $limit = null, $offset = null)
  {
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($limit != null) {
      $this->db->limit($limit, $offset);
    }
    $this->db->order_by('id', 'DESC');
    $data = $this->db->get('tb_tentang');
    return $data->result();
  }

  public function getOther($tableName = null, $jenis = null, $status = null)
  {
    $this->db->order_by('id', 'RANDOM');
    if ($jenis != null) {
      $this->db->where('jenis', $jenis);
    }
    if ($status != null) {
      $this->db->where('status', $status);
    }
    $this->db->limit(2);
    $data = $this->db->get($tableName);
    return $data->result();
  }

  public function getRequest()
  {
    $this->db->where('jenis', 'request');
    $this->db->where('status', 1);
    $data = $this->db->get('tb_layanan');
    return $data->num_rows();
  }

  public function getPengunjung($select = "*", $where = null)
  {
    $this->db->select($select);
    $where;
    $data = $this->db->get('tb_pengunjung');
    return $data->num_rows();
  }

  public function getHits($select = "*", $where = null)
  {
    $this->db->select($select);
    $where;
    $data = $this->db->get('tb_pengunjung');
    return $data->row();
  }

  public function cekDataPengunjung($tableName, $where)
  {
    $data = $this->db->get_where($tableName, $where);
    return $data->result();
  }

  // =========================
  public function getByTime($tableName, $time)
  {
    $data = $this->db->get_where($tableName, $time);
    return $data->result();
  }

  public function getProfil($jenis)
  {
    $this->db->select('*');
    $this->db->where('jenis_profil', $jenis);
    $data = $this->db->get('tb_profil');
    return $data->result();
  }

  public function getProdukNew()
  {
    $this->db->limit(5);
    $this->db->join('tb_tipe_dokumen', 'tb_tipe_dokumen.id_tipedokumen = tb_dokumen.tipe_dokumen');
    $this->db->order_by('id_dokumen', 'DESC');
    $data = $this->db->get('tb_dokumen');
    return $data->result();
  }

  public function getProduk($tipe = "all", $tahun = null)
  {
    $this->db->select('*');
    if ($tipe != "all") {
      $this->db->where('tipe_dokumen', $tipe);
    }

    if ($tahun != null) {
      $this->db->where('thntetap', $tahun);
    }

    $this->db->join('tb_tipe_dokumen', 'tb_tipe_dokumen.id_tipedokumen = tb_dokumen.tipe_dokumen');
    $this->db->order_by('id_dokumen', 'DESC');
    $data = $this->db->get('tb_dokumen');
    return $data->result();
  }

  public function getProdukRating($order = null)
  {
    $this->db->select('*');
    $this->db->join('tb_tipe_dokumen', 'tb_tipe_dokumen.id_tipedokumen = tb_dokumen.tipe_dokumen');
    $this->db->order_by($order, 'DESC');
    $this->db->limit(10);
    $data = $this->db->get('tb_dokumen');
    return $data->result();
  }

  public function getJudulProduk($tipe = null)
  {
    $this->db->select('id_dokumen, judul');
    if ($tipe != null) {
      $this->db->where('tipe_dokumen', $tipe);
    }
    $this->db->order_by('judul', 'ASC');
    $data = $this->db->get('tb_dokumen');
    return $data->result();
  }

  public function getTipeDokumen($id = null)
  {
    $this->db->select('*');
    if ($id != null) {
      $this->db->where('id_tipedokumen', $id);
    }
    $data = $this->db->get('tb_tipe_dokumen');
    return $data->result();
  }

  public function getTahunProduk($idTipe = "all")
  {
    $this->db->select('thntetap');
    $this->db->order_by('thntetap', 'DESC');
    $this->db->distinct();
    if ($idTipe != "all") {
      $this->db->where('tipe_dokumen', $idTipe);
    }
    $data = $this->db->get('tb_dokumen');
    return $data->result();
  }

  public function getSubjekProduk($idTipe)
  {
    $tahun = '<option value="0">-- Subjek Peraturan --</option>';

    $this->db->select('subjek');
    $this->db->order_by('subjek', 'ASC');
    $this->db->distinct();
    $thn = $this->db->get_where('tb_dokumen', array('thntetap' => $idTipe));

    foreach ($thn->result_array() as $data) {
      $tahun .= "<option value='$data[subjek]'>$data[subjek]</option>";
    }

    return $tahun;
  }

  public function getJudul($idTipe)
  {
    $tahun = '';

    $this->db->select('id_dokumen, judul');
    $this->db->order_by('judul', 'ASC');
    $thn = $this->db->get_where('tb_dokumen', array('tipe_dokumen' => $idTipe));

    foreach ($thn->result_array() as $data) {
      $tahun .= "<option value='$data[id_dokumen]'>$data[judul]</option>";
    }

    return $tahun;
  }

  public function getPesan()
  {
    $this->db->select('*');
    $this->db->order_by('id_pesan', 'DESC');
    $data = $this->db->get('tb_pesan');
    return $data->result();
  }

  public function getAnggota()
  {
    $this->db->select('*');
    $data = $this->db->get('tb_anggota');
    return $data->result();
  }

  public function getTotalAnggota()
  {
    $this->db->select('*');
    $data = $this->db->get('tb_anggota');
    return $data->num_rows();
  }

  public function getBerita()
  {
    $this->db->select("*");
    $this->db->order_by('id_berita', 'DESC');
    $data = $this->db->get('tb_berita');
    return $data->result();
  }

  public function getTotalBerita()
  {
    $this->db->select("*");
    $this->db->order_by('id_berita', 'DESC');
    $data = $this->db->get('tb_berita');
    return $data->num_rows();
  }

  public function getForum()
  {
    $this->db->select("*");
    $this->db->order_by('id_forum', 'DESC');
    $data = $this->db->get('tb_forum');
    return $data->result();
  }

  public function getKegiatan()
  {
    $this->db->select("*");
    $this->db->order_by('id_kegiatan', 'DESC');
    $data = $this->db->get('tb_kegiatan');
    return $data->result();
  }

  public function getGaleri($jenis_media)
  {
    $this->db->select('*');
    $this->db->where('jenis_media', $jenis_media);
    $this->db->order_by('id_galeri', 'DESC');
    $data = $this->db->get('tb_galeri');
    return $data->result();
  }

  public function getTotalGaleri()
  {
    $video = $this->getGaleri('video');
    $getFoto = $this->getGaleri('foto');

    foreach ($getFoto as $d) {
      $foto[] = unserialize($d->konten);
    }

    $cf = 0;
    foreach ($foto as $f) {
      $n = sizeof($f);
      $cf = $cf + $n;
    }

    $cv = sizeof($video);
    $count = $cv + $cf;
    return $count;
  }
  // =========================

  // function untuk masukkan data
  public function InsertData($tabelName, $data)
  {
    $res = $this->db->insert($tabelName, $data);
    return $res;
  }

  // function untuk masukkan banyak data
  public function InsertBatch($tabelName, $data)
  {
    $res = $this->db->insert_batch($tabelName, $data);
    return $res;
  }

  // function untuk update data
  public function UpdateData($tabelName, $data, $where)
  {
    $res = $this->db->update($tabelName, $data, $where);
    return $res;
  }

  // function untuk hapus data
  public function DeleteData($tabelName, $where)
  {
    $res = $this->db->delete($tabelName, $where);
    return $res;
  }
}

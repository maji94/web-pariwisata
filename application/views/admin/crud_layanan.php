<?php 
  $links = $this->uri->segment(3);
  $links2 = $this->uri->segment(4);

  if ($links2 == "unduh") {
    $header = "Unduh Dokumen";
    $jenis = "unduh";
  }else if ($links2 == "request") {
    $header = "Permintaan Dokumen";
    $jenis = "request";
  }

  if ($links == "add") {
    $action = "do_add";
    $req = "required";
    $id = "";
    $nama = "";
    $email = "";
    $nohp = "";
    $konten = "";
    $tahun = date('Y');
    $keterangan = "";
  }else{
    $action = "do_edit";
    $req = "";
    $id = $data[0]->id;
    $nama = $data[0]->nama;
    $email = $data[0]->email;
    $nohp = $data[0]->nohp;
    $konten = $data[0]->konten;
    $tahun = $data[0]->tahun;
    $keterangan = $data[0]->keterangan;
  }
 ?>
<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <div class="container-fluid">

    <!-- Header Starts -->
    <div class="row">
      <div class="col-sm-12 p-0">
        <div class="main-header">
          <h4><?php echo $header; ?></h4>
          <ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('admin'); ?>">
                <i class="icofont icofont-home"></i> Dashboard
              </a>
            </li>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/layanan/'.$links2); ?>"> <?php echo $header; ?></a>
            </li>
            <li class="breadcrumb-item"><a href="#"> <?php echo 'Tambah Data '.$header; ?></a>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <!-- Header end -->

    <!-- Tables start -->
    <!-- Row start -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Tambah Data <?php echo $header; ?> </h5>
          </div>
          <div class="card-block">
            <?php echo  form_open_multipart('admin/layanan/'.$action.'/'.$jenis); ?>
              <div class="form-group row">
                <label for="nama" class="col-md-2 col-form-label form-control-label">Nama *</label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="SIlahkan masukkan nama <?php echo $jenis; ?>" required value="<?php echo $nama; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tahun" class="col-md-2 col-form-label form-control-label">Tahun Dokumen *</label>
                <div class="col-md-10">
                    <input type="number" id="tahun" name="tahun" class="form-control" placeholder="Tahun dokumen" value="<?php echo $tahun; ?>" <?php echo $req; ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="dokumen" class="col-md-2 col-form-label form-control-label">Unggah Dokumen *</label>
                <div class="col-md-10">
                    <input type="hidden" name="oldDokumen" value="<?php echo $konten; ?>">
                    <input type="file" id="dokumen" name="dokumen" class="form-control" <?php echo $req; ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="keterangan" class="col-md-2 col-form-label form-control-label">Deskripsi *</label>
                <div class="col-md-10">
                  <textarea class="form-control" name="keterangan" rows="10" placeholder="Masukkan deskripsi dokumen (Opsional)"><?php echo $keterangan; ?></textarea>
                </div>
              </div>
              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                  <a href="<?php echo site_url('admin/layanan/'.$this->uri->segment(4)); ?>" class="btn btn-primary waves-effect waves-light m-r-10"><i class="icofont icofont-arrow-left"></i><span class="m-l-10"> Kembali</a>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
        <!-- Hover effect table ends -->
      </div>
    </div>
  </div>
</div>


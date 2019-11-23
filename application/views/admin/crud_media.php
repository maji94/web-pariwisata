<?php 
  $links = $this->uri->segment(4);
  if ($links == "artikel") {
    $header = "Artikel";
    $add = "artikel";
  }else if ($links == "foto") {
    $header = "Galeri Foto";
    $add = "foto";
  }else if ($links == "video") {
    $header = "Galeri Video";
    $add = "video";
  }

  if ($this->uri->segment(3) == "add") {
    $action = "do_add";
    $req = "required";
  }else{
    $action = "do_edit";
    $req = "";
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
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/media/'.$links); ?>"> <?php echo $header; ?></a>
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
            <?php echo  form_open_multipart('admin/media/do_add/artikel'); ?>
              <div class="form-group row">
                <label for="judul" class="col-md-2 col-form-label form-control-label">Judul *</label>
                <div class="col-md-10">
                  <input type="text" id="judul" name="judul" class="form-control" placeholder="SIlahkan masukkan Judul artikel" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="tanggal" class="col-md-2 col-form-label form-control-label">Tanggal *</label>
                <div class="col-md-10">
                  <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="isi" class="col-md-2 col-form-label form-control-label">Isi Artikel </label>
                <div class="col-md-10">
                  <textarea class="form-control" id="isi" name="isi"></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="foto" class="col-md-2 col-form-label form-control-label">Foto Headline *</label>
                <div class="col-md-10">
                    <input type="file" id="foto" name="foto" class="form-control" <?php echo $req; ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="link_foto" class="col-md-2 col-form-label form-control-label">Link Foto </label>
                <div class="col-md-10">
                    <input type="text" id="link_foto" name="link_foto" class="form-control" placeholder="Copy dan paste link foto yang terdapat pada halaman galeri foto (opsional)">
                </div>
              </div>
              <div class="form-group row">
                <label for="link_video" class="col-md-2 col-form-label form-control-label">Link Video </label>
                <div class="col-md-10">
                    <input type="text" id="link_video" name="link_video" class="form-control" placeholder="Copy dan paste link video yang terdapat pada halaman galeri video (opsional)">
                </div>
              </div>
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-30"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                </div>
              </div>
            <?php echo form_close(); ?>
<?php 
  echo "<pre>";
  print_r($this->session->userdata());

 ?>
          </div>
        </div>
        <!-- Hover effect table ends -->
      </div>
    </div>
  </div>
</div>


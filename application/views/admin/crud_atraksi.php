<?php 
  $links = $this->uri->segment(3);
  $links2 = $this->uri->segment(4);

  if ($links2 == "alam") {
    $header = "Alam";
    $jenis = "alam";
  }else if ($links2 == "budaya") {
    $header = "Budaya";
    $jenis = "budaya";
  }else if ($links2 == "museum") {
    $header = "Museum";
    $jenis = "museum";
  }else if ($links2 == "kuliner") {
    $header = "Kuliner";
    $jenis = "kuliner";
  }

  if ($links == "add") {
    $action = "do_add";
    $req = "required";
    $id = "";
    $nama = "";
    $konten = "";
    $foto_galeri = "";
    $foto_galeri0 = "";
    $n_konten = "";
    $foto_headline = "";
    $link_foto = "";
    $link_video = "";
    $link_maps = "";
  }else{
    $action = "do_edit";
    $req = "";
    $id = $data[0]->id;
    $nama = $data[0]->nama;
    $konten = $data[0]->konten;
    $foto_galeri = unserialize($data[0]->foto_galeri);
    $foto_galeri0 = base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', $foto_galeri[0]));
    $n_konten = sizeof($foto_galeri);
    $foto_headline = $data[0]->foto_headline;
    $link_foto = $data[0]->link_foto;
    $link_video = $data[0]->link_video;
    $link_maps = $data[0]->link_maps;
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
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/atraksi/'.$links2); ?>"> <?php echo $header; ?></a>
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
            <?php echo  form_open_multipart('admin/atraksi/'.$action.'/'.$jenis); ?>
              <div class="form-group row">
                <label for="nama" class="col-md-2 col-form-label form-control-label">Nama *</label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="SIlahkan masukkan nama <?php echo $jenis; ?>" required value="<?php echo $nama; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="headline" class="col-md-2 col-form-label form-control-label">Foto Headline *</label>
                <div class="col-md-10">
                  <input type="hidden" name="oldFoto_headline" value="<?php echo $foto_headline; ?>">
                  <input type="file" id="headline" name="headline" class="form-control" <?php echo $req; ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="konten" class="col-md-2 col-form-label form-control-label">Deskripsi *</label>
                <div class="col-md-10">
                  <textarea class="form-control" id="isi" name="konten" required><?php echo $konten; ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="link_foto" class="col-md-2 col-form-label form-control-label">Link Foto </label>
                <div class="col-md-10">
                    <input type="text" id="link_foto" name="link_foto" class="form-control" placeholder="Copy dan paste link foto yang ada pada Galeri Foto" value="<?php echo $link_foto; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="link_video" class="col-md-2 col-form-label form-control-label">Link Video </label>
                <div class="col-md-10">
                    <input type="text" id="link_video" name="link_video" class="form-control" placeholder="Copy dan paste link video yang ada pada Youtube" value="<?php echo $link_video; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="link_maps" class="col-md-2 col-form-label form-control-label">Link Google Maps </label>
                <div class="col-md-10">
                    <input type="text" id="link_maps" name="link_maps" class="form-control" placeholder="Copy dan paste link peta yang ada di Google Maps " value="<?php echo $link_maps; ?>">
                </div>
              </div>

              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                  <a href="<?php echo site_url('admin/atraksi/'.$this->uri->segment(4)); ?>" class="btn btn-primary waves-effect waves-light m-r-10"><i class="icofont icofont-arrow-left"></i><span class="m-l-10"> Kembali</a>
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


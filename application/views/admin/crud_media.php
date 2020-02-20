<?php 
  $links = $this->uri->segment(3);
  $links2 = $this->uri->segment(4);

  if ($links2 == "artikel") {
    $header = "Artikel";
    $jenis = "artikel";
  }else if ($links2 == "foto") {
    $header = "Galeri Foto";
    $jenis = "foto";
  }else if ($links2 == "video") {
    $header = "Galeri Video";
    $jenis = "video";
  }

  if ($links == "add") {
      $header_2 = "Tambah Data ";
    $action = "do_add";
    $req = "required";
    $id = "";
    $judul = "";
    $tanggal = "";
    $oleh = "";
    $dilihat = "";
    if ($links2 == 'artikel') {
      $konten = "";
      $headline = "";
      $link_foto = "";
      $link_video = "";
    }else if ($links2 == 'foto') {
      $konten = "";
      $konten0 = "";
      $n_konten = "";
      $oleh = "";
    }else if ($links2 == 'video') {
      $konten = "";
      $headline = "";
    }
  }else{
    $action = "do_edit";
    $header_2 = "Edit Data ";
    $req = "";
    $id = $data[0]->id;
    $judul = $data[0]->judul;
    $tanggal = $data[0]->tanggal;
    $oleh = $data[0]->oleh;
    $dilihat = $data[0]->dilihat;
    if ($links2 == 'artikel') {
      $konten = $data[0]->konten;
      $headline = $data[0]->headline;
      $link_foto = $data[0]->link_foto;
      $link_video = $data[0]->link_video;
    }else if ($links2 == "foto") {
      $konten = unserialize($data[0]->konten);
      $konten0 = base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[0]));
      $n_konten = sizeof($konten);
    }else if ($links2 == "video") {
      $konten = $data[0]->konten;
      $headline = $data[0]->headline;
    }
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
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/media/'.$links2); ?>"> <?php echo $header; ?></a>
            </li>
            <li class="breadcrumb-item"><a href="#"> <?php echo $header_2.$header; ?></a>
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
            <h5 class="card-header-text"><?php echo $header_2.$header; ?> </h5>
          </div>
          <div class="card-block">
            <?php echo  form_open_multipart('admin/media/'.$action.'/'.$jenis); ?>
              <div class="form-group row">
                <label for="judul" class="col-md-2 col-form-label form-control-label">Judul *</label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="text" id="judul" name="judul" class="form-control" placeholder="SIlahkan masukkan Judul artikel" required value="<?php echo $judul; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tanggal" class="col-md-2 col-form-label form-control-label">Tanggal *</label>
                <div class="col-md-10">
                  <input type="date" id="tanggal" name="tanggal" class="form-control" required value="<?php echo $tanggal; ?>">
                </div>
              </div>

              <?php if ($links2 == "artikel") { ?>
              <div class="form-group row">
                <label for="isi" class="col-md-2 col-form-label form-control-label">Isi Artikel </label>
                <div class="col-md-10">
                  <textarea class="form-control" id="isi" name="isi"><?php echo $konten; ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="foto" class="col-md-2 col-form-label form-control-label">Foto Headline *</label>
                <div class="col-md-10">
                    <input type="hidden" name="oldFoto" value="<?php echo $headline; ?>">
                    <input type="file" id="foto" name="foto" class="form-control" <?php echo $req; ?>>
                </div>
              </div>
              <div class="form-group row">
                <label for="link_foto" class="col-md-2 col-form-label form-control-label">Link Foto </label>
                <div class="col-md-10">
                    <input type="text" id="link_foto" name="link_foto" class="form-control" placeholder="Copy dan paste link foto yang terdapat pada halaman galeri foto" value="<?php echo $link_foto; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="link_video" class="col-md-2 col-form-label form-control-label">Link Video </label>
                <div class="col-md-10">
                    <input type="text" id="link_video" name="link_video" class="form-control" placeholder="Copy dan paste link video yang ada pada Youtube" value="<?php echo $link_video; ?>">
                </div>
              </div>
              <?php }else if ($links2 == "foto") { ?>
              <input type="hidden" name="n_edit" id="n_edit" value="<?php echo $n_konten; ?>">
              <div class="row" style="margin-bottom: 1rem;">
                <div class="form-group">
                  <label for="tanggal" class="col-md-2 col-form-label form-control-label">Unggah Foto *</label>
                  <div class="col-md-10" id="itemlist" style="padding:0px">
                      <p style="color:red;padding-left:15px;font-weight:600;"><em>* Total ukuran/size keseluruhan foto tidak boleh melebihi 20 mb</em></p>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:5px;">
                      <input class="form-control" type="file" id="foto[0]" name="foto[]" onchange="PreviewImage('foto[0]','prevFoto[0]','#oldFoto0');">
                      <?php if ($links == "edit") { ?>
                      <input type="hidden" name="oldFoto[]" id="oldFoto0" value="<?php echo $konten[0]; ?>"><?php } ?>
                      <img src="<?php echo $konten0; ?>" class="form-control" id="prevFoto[0]" style="height: 200px; width: 100%;" alt="Foto Galeri">
                      <button type="button" class="btn btn-info btn-mini" onclick="additem(); return false" style="margin-top: 5px;"><i class="icofont icofont-plus"></i> Tambah Foto</button>
                    </div>

                    <?php if ($links == "edit") {
                    for ($i=1; $i <$n_konten ; $i++) { ?>
                      <div class="col-md-4 col-xs-12" id="<?php echo 'finput'.$i; ?>" style="margin-bottom:5px;">
                        <input class="form-control" type="file" id="<?php echo 'foto['.$i.']'; ?>" name="<?php echo 'foto[]'; ?>" onchange="PreviewImage('<?php echo "foto[".$i."]"; ?>','<?php echo "prevFoto[".$i."]"; ?>','<?php echo "#oldFoto".$i; ?>');">
                          <input type="hidden" name="<?php echo 'oldFoto[]'; ?>" id="<?php echo 'oldFoto'.$i; ?>" value="<?php echo $konten[$i]; ?>">
                          <img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[$i])); ?>" class="form-control" id="<?php echo 'prevFoto['.$i.']'; ?>" style="height: 200px; width: 100%;" alt="Foto Galeri">
                          <span><button class="btn btn-danger btn-mini" type="button" onclick="hapus('#finput<?php echo $i; ?>');" style="margin-top: 5px;"><i class="icofont icofont-close"></i> Hapus</button></span>
                      </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label for="oleh" class="col-md-2 col-form-label form-control-label">Oleh </label>
                <div class="col-md-10">
                    <input type="text" id="oleh" name="oleh" class="form-control" placeholder="Photo by .." value="<?php echo $oleh; ?>">
                </div>
              </div>
              <?php }else if ($links2 == "video") { ?>
              <div class="form-group row">
                <label for="konten" class="col-md-2 col-form-label form-control-label">Link Video Youtube *</label>
                <div class="col-md-10">
                    <input type="text" id="konten" name="konten" class="form-control" placeholder="Copy dan paste link video yang yang ada di Youtube " value="<?php echo $konten; ?>" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="foto" class="col-md-2 col-form-label form-control-label">Foto Headline *</label>
                <div class="col-md-10">
                    <input type="hidden" name="oldFoto" value="<?php echo $headline; ?>">
                    <input type="file" id="foto" name="foto" class="form-control" <?php echo $req; ?>>
                </div>
              </div>
              <?php } ?>

              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                  <a href="<?php echo site_url('admin/media/'.$this->uri->segment(4)); ?>" class="btn btn-primary waves-effect waves-light m-r-10"><i class="icofont icofont-arrow-left"></i><span class="m-l-10"> Kembali</a>
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


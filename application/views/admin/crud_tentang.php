<?php 
  $links = $this->uri->segment(3);
  $links2 = $this->uri->segment(4);

  if ($links == "struktur") {
    $id = $data[0]->id;
    $action = "do_edit";
    $konten = $data[0]->konten;
    $req = "";
    $header = "Struktur Organisasi";
    $jenis = "struktur";
  }else if ($links == "profil") {
    $id = $data[0]->id;
    $action = "do_edit";
    $konten = $data[0]->konten;
    $req = "";
    $header = "Profil Organisasi";
    $jenis = "profil";
  }else if ($links == "galeri" OR $links2 == "galeri") {
    $header = "Galeri Foto Organisasi";
    $jenis = "galeri";
  }

  if ($links == "add") {
    $action = "do_add";
    $req = "required";
    $id = "";
    $nama = "";
    $konten = "";
    $konten0 = "";
    $n_konten = "";
    $oleh = "";
    $tanggal = date('Y-m-d');
  }else if ($links == "edit") {
    $action = "do_edit";
    $req = "";
    $id = $data[0]->id;
    $nama = $data[0]->nama;
    $konten = unserialize($data[0]->konten);
    $konten0 = base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $konten[0]));
    $n_konten = sizeof($konten);
    $oleh = $data[0]->oleh;
    $tanggal = $data[0]->tanggal;
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
            <?php if ($links2 == "galeri") { ?>
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/tentang/'.$links2); ?>"> <?php echo $header; ?></a>
            </li>
            <li class="breadcrumb-item"><a href="#"> <?php echo 'Tambah Data '.$header; ?></a>
            </li>
            <?php }else { ?>
            <li class="breadcrumb-item"><a href="#"> <?php echo $header; ?></a>
            </li>
            <?php } ?>
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
            <?php if ($links2 == "galeri") { ?>
            <h5 class="card-header-text">Tambah Data <?php echo $header; ?> </h5>
            <?php }else { ?>
            <h5 class="card-header-text">Data <?php echo $header; ?> </h5>
            <?php } ?>
          </div>
          <div class="card-block">
            <?php echo  form_open_multipart('admin/tentang/'.$action.'/'.$jenis); ?>
            <?php if ($links == "galeri" OR $links2 == "galeri") { ?>
              <div class="form-group row">
                <label for="nama" class="col-md-2 col-form-label form-control-label">Judul *</label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="SIlahkan masukkan judul galeri" required value="<?php echo $nama; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tanggal" class="col-md-2 col-form-label form-control-label">Tanggal *</label>
                <div class="col-md-10">
                  <input type="date" id="tanggal" name="tanggal" class="form-control" required value="<?php echo $tanggal; ?>">
                </div>
              </div>
              <input type="hidden" name="n_edit" id="n_edit" value="<?php echo $n_konten; ?>">
              <div class="row" style="margin-bottom: 1rem;">
                <div class="form-group">
                  <label for="tanggal" class="col-md-2 col-form-label form-control-label">Unggah Foto *</label>
                  <div class="col-md-10" id="itemlist" style="padding:0px">
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
                          <img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $konten[$i])); ?>" class="form-control" id="<?php echo 'prevFoto['.$i.']'; ?>" style="height: 200px; width: 100%;" alt="Foto Galeri">
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
            <?php }else if ($links == "struktur") { ?>
              <div class="form-group row">
                <label for="dokumen" class="col-md-2 col-form-label form-control-label">Unggah Struktur </label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="oldFoto" id="oldFoto" value="<?php echo $konten; ?>">
                  <input class="form-control" type="file" id="foto" name="foto" onchange="PreviewImage('foto','prevFoto','#oldFoto');" <?php echo $req; ?>>
                  <label><?php echo str_replace('<p>', '<p style="color: red;font-weight: bold;">', $this->session->flashdata('pesan')); ?></label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-6 col-xs-12">
                  <img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $konten)); ?>" class="form-control" id="prevFoto" style="min-height: 200px; width: 100%;" alt="Foto Galeri">
                </div>
              </div>
            <?php }else if ($links == "profil") { ?>
              <div class="form-group row">
                <label for="dokumen" class="col-md-2 col-form-label form-control-label">Profil Organisasi </label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <textarea class="form-control" id="isi" name="konten" required><?php echo $konten; ?></textarea>
                </div>
              </div>
            <?php } ?>
              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                  <?php if ($links == "galeri") { ?>
                  <a href="<?php echo site_url('admin/layanan/'.$this->uri->segment(4)); ?>" class="btn btn-primary waves-effect waves-light m-r-10"><i class="icofont icofont-arrow-left"></i><span class="m-l-10"> Kembali</a>
                  <?php } ?>
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


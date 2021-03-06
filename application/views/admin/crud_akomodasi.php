<?php 
  $links = $this->uri->segment(3);
  $links2 = $this->uri->segment(4);

  if ($links2 == "hotel") {
    $header = "Hotel & Penginapan";
    $jenis = "hotel";
  }else if ($links2 == "restoran") {
    $header = "Restoran";
    $jenis = "restoran";
  }else if ($links2 == "transportasi") {
    $header = "Transportasi";
    $jenis = "transportasi";
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
            <li class="breadcrumb-item"><a href="<?php echo site_url('admin/akomodasi/'.$links2); ?>"> <?php echo $header; ?></a>
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
            <?php echo  form_open_multipart('admin/akomodasi/'.$action.'/'.$jenis); ?>
              <div class="form-group row">
                <label for="nama" class="col-md-2 col-form-label form-control-label">Nama/Judul *</label>
                <div class="col-md-10">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="text" id="nama" name="nama" class="form-control" placeholder="SIlahkan masukkan nama <?php echo $jenis; ?>" required value="<?php echo $nama; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="konten" class="col-md-2 col-form-label form-control-label">Deskripsi *</label>
                <div class="col-md-10">
                  <textarea class="form-control" id="isi" name="konten" required><?php echo $konten; ?></textarea>
                </div>
              </div>
              <?php if ($links2 != "transportasi") { ?>
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
              <?php } ?>
              <input type="hidden" name="n_edit" id="n_edit" value="<?php echo $n_konten; ?>">
              <div class="row" style="margin-bottom: 1rem;">
                <div class="form-group">
                  <label for="tanggal" class="col-md-2 col-form-label form-control-label">Unggah Foto *</label>
                  <div class="col-md-10" id="itemlist" style="padding:0px">
                      <p style="color:red;padding-left:15px;font-weight:600;"><em>* Total ukuran/size keseluruhan foto tidak boleh melebihi 20 mb</em></p>
                    <div class="col-md-4 col-xs-12" style="margin-bottom:5px;">
                      <input class="form-control" type="file" id="foto[0]" name="foto[]" onchange="PreviewImage('foto[0]','prevFoto[0]','#oldFoto0');" <?php echo $req; ?>>
                      <?php if ($links == "edit") { ?>
                      <input type="hidden" name="oldFoto[]" id="oldFoto0" value="<?php echo $foto_galeri[0]; ?>"><?php } ?>
                      <img src="<?php echo $foto_galeri0; ?>" class="form-control" id="prevFoto[0]" style="height: 200px; width: 100%;" alt="Foto Galeri">
                      <button type="button" class="btn btn-info btn-mini" onclick="additem(); return false" style="margin-top: 5px;"><i class="icofont icofont-plus"></i> Tambah Foto</button>
                    </div>

                    <?php if ($links == "edit") {
                    for ($i=1; $i <$n_konten ; $i++) { ?>
                      <div class="col-md-4 col-xs-12" id="<?php echo 'finput'.$i; ?>" style="margin-bottom:5px;">
                        <input class="form-control" type="file" id="<?php echo 'foto['.$i.']'; ?>" name="<?php echo 'foto[]'; ?>" onchange="PreviewImage('<?php echo "foto[".$i."]"; ?>','<?php echo "prevFoto[".$i."]"; ?>','<?php echo "#oldFoto".$i; ?>');">
                          <input type="hidden" name="<?php echo 'oldFoto[]'; ?>" id="<?php echo 'oldFoto'.$i; ?>" value="<?php echo $foto_galeri[$i]; ?>">
                          <img src="<?php echo base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', $foto_galeri[$i])); ?>" class="form-control" id="<?php echo 'prevFoto['.$i.']'; ?>" style="height: 200px; width: 100%;" alt="Foto Galeri">
                          <span><button class="btn btn-danger btn-mini" type="button" onclick="hapus('#finput<?php echo $i; ?>');" style="margin-top: 5px;"><i class="icofont icofont-close"></i> Hapus</button></span>
                      </div>
                    <?php } } ?>
                  </div>
                </div>
              </div>

              <div class="row" style="margin-top: 1rem;">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-10"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                  <a href="<?php echo site_url('admin/akomodasi/'.$this->uri->segment(4)); ?>" class="btn btn-primary waves-effect waves-light m-r-10"><i class="icofont icofont-arrow-left"></i><span class="m-l-10"> Kembali</a>
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


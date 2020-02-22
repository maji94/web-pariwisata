<?php
$links = $this->uri->segment(4);
$links2 = $this->uri->segment(5);
if ($links == "artikel") {
  $header = "Artikel";
  $jenis = "artikel";
  $konten = unserialize($foto[0]->konten);
  $link_video = $data[0]->link_video;
  $link_maps = $data[0]->link_maps;
} else if ($links == "foto") {
  $header = "Galeri Foto";
  $jenis = "foto";
} else if ($links == "video") {
  $header = "Galeri Video";
  $jenis = "video";
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
            <li class="breadcrumb-item"><a href="#"> <?php echo $header; ?></a>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <!-- Header end -->

    <!-- Tables of Media Publish -->
    <div class="card card-main">
      <div class="card-block">
        <div class="row search-result justify-content-center">
          <div class="col-lg-7 col-xs-12" style="float: unset;margin:auto">
            <div class="card">
              <img class="card-img-top" src=" <?= base_url('assets/images/artikel/' . str_replace('.', '_thumb.', $data[0]->headline)); ?> " alt="Card image cap">
              <div class="card-block">
                <h3 class="card-title"> <?= $data[0]->judul; ?></h3><br>
                <h6 class="card-subtitle mb-2 text-muted"><?= tgl_indo($data[0]->tanggal); ?></h6>
                <hr>
                <p class="card-text"><?= $data[0]->konten; ?></p>
              </div>
              <div class="card-block button-list">
                <a style="color:white;" href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[0])); ?>" data-lightbox="roadtrip" class="btn btn-tumblr" title="Lihat Foto">Lihat Foto</a>
                <?php for ($m=1; $m < count($konten); $m++) { ?>
                  <a href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[$m])); ?>" data-lightbox="roadtrip"></a>
                <?php } ?>
                <a style="color:white;" href="<?= $link_video; ?>" data-toggle="lightbox" data-gallery="mixedgallery" class="btn btn-tumblr" title="Lihat Video">Lihat Video</a>
                <a style="color: white;" href="<?= $link_maps; ?>" class="btn btn-tumblr" title="Lihat Maps" target="_blank">Lihat Maps</a>
              </div>
              <div class="card-footer text-right">
                <a href="<?= site_url('admin/media/verifikasi/artikel/'.$links2); ?>" class="btn btn-success" onclick="return confirm('Verifikasi data. Lanjutkan ?');" title="Verifikasi Data">Verifikasi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$links = $this->uri->segment(4);
$links2 = $this->uri->segment(5);

$links_foto = "";$links_video = "";$links_maps = "";
if ($links == "komunitas") {
  $header = "Komunitas";
  $jenis = "komunitas";
}else if ($links == "event") {
  $header = "Event";
  $jenis = "event";
  if (count($foto) > 0) {
    $links_foto = "href=\"".base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', $foto[0]))."\"";
  }
  if ($data[0]->link_video != "") {
    $links_video = "href=\"".$data[0]->link_video."\"";
  }
  if ($data[0]->link_maps != "") {
    $links_maps = "href=\"".$data[0]->link_maps."\"";
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
              <img class="card-img-top" src=" <?= base_url('assets/images/kreatif/' . str_replace('.', '_thumb.', $foto[0])); ?> " alt="Card image cap">
              <div class="card-block">
                <h3 class="card-title"> <?= $data[0]->nama; ?></h3>
                <hr>
                <p class="card-text"><?= $data[0]->konten; ?></p>
              </div>
              <div class="card-block button-list">
                <a style="color:white;" <?= $links_foto; ?> data-lightbox="roadtrip" class="btn btn-tumblr" title="Lihat Foto">Lihat Foto</a>
                <?php for ($m=1; $m < count($foto); $m++) { ?>
                  <a href="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', $foto[$m])); ?>" data-lightbox="roadtrip"></a>
                <?php } ?>
                <a style="color:white;" <?= $links_video; ?> data-toggle="lightbox" data-gallery="mixedgallery" class="btn btn-tumblr" title="Lihat Video">Lihat Video</a>
                <a style="color: white;" <?= $links_maps; ?> class="btn btn-tumblr" title="Lihat Maps" target="_blank">Lihat Maps</a>
              </div>
              <div class="card-footer text-right">
                <a href="<?= site_url('admin/kreatif/verifikasi/event/'.$links2); ?>" class="btn btn-success" onclick="return confirm('Verifikasi data. Lanjutkan ?');" title="Verifikasi Data">Verifikasi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
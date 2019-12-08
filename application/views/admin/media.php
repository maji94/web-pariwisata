<?php 
  $links = $this->uri->segment(3);
  if ($links == "artikel") {
    $header = "Artikel";
    $jenis = "artikel";
  }else if ($links == "foto") {
    $header = "Galeri Foto";
    $jenis = "foto";
  }else if ($links == "video") {
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

    <!-- Tables start -->
    <!-- Row start -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data Artikel </h5>
            <a href="<?php echo site_url('admin/media/add/'.$jenis); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
                      <th>Judul</th>
                      <th>Tanggal</th>
                      <th>Oleh</th>
                      <?php if ($jenis != "artikel") { ?>
                      <th>Link</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data as $d) { ?>
                    <tr>
                      <td width="5%"><?php echo $no; ?></td>
                      <td>
                        <?php if ($d->jenis == "foto") {?>
                        <img src="<?php echo base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="" style="width: 200px">
                        <?php }else{ ?>
                        <img src="<?php echo base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt="" style="width: 200px">
                        <?php } ?>
                      </td>
                      <td><?php echo $d->judul; ?></td>
                      <td><?php echo tgl_indo(date($d->tanggal)); ?></td>
                      <td><?php echo $d->oleh; ?></td>
                      <?php if ($jenis == "foto") { ?>
                      <td><?php echo site_url('media/galeri/'.$d->id); ?></td>
                      <?php }else if ($jenis == "video") { ?>
                      <td><?php echo $d->konten; ?></td>
                      <?php } ?>
                      <td align="center" width="5%">
                        <a href="<?php echo site_url('admin/media/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/media/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </a>
                      </td>
                    </tr>
                    <?php $no++; } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
                      <th>Judul</th>
                      <th>Tanggal</th>
                      <th>Oleh</th>
                      <?php if ($jenis != "artikel") { ?>
                      <th>Link</th>
                      <?php } ?>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Hover effect table ends -->
      </div>
    </div>
  </div>
</div>

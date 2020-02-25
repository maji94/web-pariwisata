<?php 
  $links = $this->uri->segment(3);
  if ($links == "komunitas") {
    $header = "Komunitas";
    $jenis = "komunitas";
  }else if ($links == "event") {
    $header = "Event";
    $jenis = "event";
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

    <!-- Tables Event Publis -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data <?php echo $header; ?> Publis</h5>
            <a href="<?php echo site_url('admin/kreatif/add/'.$jenis); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
                      <?php if ($links == "event") { ?>
                        <th>Tanggal</th>
                      <?php } ?>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data as $d) { ?>
                    <tr>
                      <td width="5%"><?php echo $no; ?></td>
                      <td>
                        <img src="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt="" style="width: 200px">
                      </td>
                      <?php if ($links == "event") { ?>
                        <td><?php echo tgl_indo(date('Y-m-d', strtotime($d->tanggal))); ?></td>
                      <?php } ?>
                      <td><?php echo $d->nama; ?></td>
                      <td><?php echo substr(strip_tags($d->konten), 0, 200); ?> ...</td>
                      <td align="center" width="5%">
                        <?php if ($links == "event") { ?>
                        <a href="<?php echo site_url('admin/kreatif/naik/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 170px;" class="btn btn-warning waves-effect waves-light" title="Jadikan Event Unggulan">
                          <i class="icofont icofont-arrow-up"></i><span class="m-l-10">Jadikan Unggulan</span>
                        </a><br>
                        <?php } ?>
                        <a href="<?php echo site_url('admin/kreatif/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 170px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/kreatif/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 170px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
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
                      <?php if ($links == "event") { ?>
                        <th>Tanggal</th>
                      <?php } ?>
                      <th>Nama</th>
                      <th>Deskripsi</th>
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
    
    <?php if ($links == "event") { ?>
    <!-- Tables Event Pending -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data <?php echo $header; ?> Pending</h5>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example1" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
                      <?php if ($links == "event") { ?>
                        <th>Tanggal</th>
                      <?php } ?>
                      <th>Nama</th>
                      <th>Deskripsi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data_pending as $d) { ?>
                    <tr>
                      <td width="5%"><?php echo $no; ?></td>
                      <td>
                        <img src="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt="" style="width: 200px">
                      </td>
                      <?php if ($links == "event") { ?>
                        <td><?php echo tgl_indo(date('Y-m-d', strtotime($d->tanggal))); ?></td>
                      <?php } ?>
                      <td><?php echo $d->nama; ?></td>
                      <td><?php echo substr(strip_tags($d->konten), 0, 200); ?> ...</td>
                      <td align="center" width="5%">
                        <?php if ($links == "event") {
                          if ($this->session->userdata('lvl_user') == "admin") {
                        ?>
                          <a href="<?php echo site_url('admin/kreatif/detail/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 100px;" class="btn btn-info waves-effect waves-light" title="Lihat Detail">
                            <i class="icofont icofont-search"></i><span class="m-l-10">Lihat Detail</span>
                          </a><br>
                          <a href="<?php echo site_url('admin/kreatif/verifikasi/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 100px;" class="btn btn-success waves-effect waves-light" title="Verifikasi Data" onclick="return confirm('Verifikasi data. Lanjutkan ?');">
                            <i class="icofont icofont-tick-mark"></i><span class="m-l-10">Verifikasi</span>
                          </a><br>
                        <?php } } ?>
                        <a href="<?php echo site_url('admin/kreatif/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 100px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/kreatif/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 100px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
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
                      <?php if ($links == "event") { ?>
                        <th>Tanggal</th>
                      <?php } ?>
                      <th>Nama</th>
                      <th>Deskripsi</th>
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
    <?php } ?>
  </div>
</div>

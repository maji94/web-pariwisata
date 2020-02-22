<?php 
  $links = $this->uri->segment(3);
  if ($links == "alam") {
    $header = "Alam";
    $jenis = "alam";
  }else if ($links == "budaya") {
    $header = "Budaya";
    $jenis = "budaya";
  }else if ($links == "buatan") {
    $header = "Buatan";
    $jenis = "buatan";
  }else if ($links == "kuliner") {
    $header = "Kuliner";
    $jenis = "kuliner";
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

    <!-- Table of Atraksi Publish -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data <?php echo $header; ?> </h5>
            <a href="<?php echo site_url('admin/atraksi/add/'.$jenis); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
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
                        <img src="<?php echo base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', $d->foto_headline)); ?>" alt="" style="width: 200px">
                      </td>
                      <td><?php echo $d->nama; ?></td>
                      <td><?php echo substr(strip_tags($d->konten), 0, 200); ?> ...</td>
                      <td align="center" width="5%">
                        <a href="<?php echo site_url('admin/atraksi/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/atraksi/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
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

    <!-- Table of Atraksi Pending -->
    <div class="row">
      <div class="col-sm-12">

        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data <?php echo $header; ?> Pending Publis</h5>
            <a href="<?php echo site_url('admin/atraksi/add/'.$jenis); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto Headline</th>
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
                        <img src="<?php echo base_url('assets/images/'.$jenis.'/'.str_replace('.', '_thumb.', $d->foto_headline)); ?>" alt="" style="width: 200px">
                      </td>
                      <td><?php echo $d->nama; ?></td>
                      <td><?php echo substr(strip_tags($d->konten), 0, 200); ?> ...</td>
                      <td align="center" width="5%">
                        <a href="<?php echo site_url('admin/atraksi/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/atraksi/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
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
  </div>
</div>

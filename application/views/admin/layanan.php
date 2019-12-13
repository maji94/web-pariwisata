<?php 
  $links = $this->uri->segment(3);
  if ($links == "unduh") {
    $header = "Unduh Dokumen";
    $jenis = "unduh";
  }else if ($links == "request") {
    $header = "Permintaan Dokumen";
    $jenis = "request";
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
            <h5 class="card-header-text">Data <?php echo $header; ?> </h5>
            <?php if ($links == "unduh") { ?>
            <a href="<?php echo site_url('admin/layanan/add/'.$jenis); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
            <?php } ?>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                    <?php if ($links == "unduh") { ?>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Tahun</th>
                      <th>Deskripsi</th>
                      <th>Link Download</th>
                      <th>Action</th>
                    <?php }else if ($links == "request") { ?>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Email/No Hp</th>
                      <th>Jenis Dokumen Yang Diminta</th>
                      <th>Action</th>
                    <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data as $d) { ?>
                      <?php if ($links == "unduh") { ?>
                      <tr>
                        <td width="5%"><?php echo $no; ?></td>
                        <td><?php echo $d->nama; ?></td>
                        <td><?php echo $d->tahun; ?></td>
                        <td width="40%"><?php echo substr(strip_tags($d->keterangan), 0, 200); ?> ...</td>
                        <td style="word-break: break-all;width: 30%;"><?php echo base_url('assets/dokumen/'.$links.'/'.$d->konten); ?></td>
                        <td align="center" width="5%">
                          <a href="<?php echo site_url('admin/layanan/edit/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                            <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                          </a><br>
                          <a href="<?php echo site_url('admin/layanan/delete/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 70px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                            <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                          </a>
                        </td>
                      </tr>
                      <?php }else if ($links == "request") { ?>
                      <tr <?php if ($d->status == 1) { echo 'style="background-color: #4CAF50 ;color:white;font-weight:bold;"';} ?>>
                        <td width="5%"><?php echo $no; ?></td>
                        <td><?php echo $d->nama; ?></td>
                        <td><?php echo $d->email.'<br>'.$d->nohp; ?></td>
                        <td width="30%"><?php echo $d->konten; ?></td>
                        <td align="center" width="5%">
                          <a href="<?php echo site_url('admin/layanan/tandai/'.$jenis.'/'.$d->id); ?>" style="margin-bottom: 5px;width: 200px;" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                            <i class="icofont icofont-checked"></i><span class="m-l-10">Tandai Sudah Dibaca</span>
                          </a><br>
                          <a href="#" style="margin-bottom: 5px;width: 200px;" class="btn btn-warning waves-effect waves-light" title="Tandai Pesan" 
                            data-toggle="modal" data-target="#detail_request" 
                            data-id="<?php echo $d->id; ?>" 
                            data-nama="<?php echo $d->nama; ?>" 
                            data-email="<?php echo $d->email; ?>"
                            data-nohp="<?php echo $d->nohp; ?>"
                            data-konten="<?php echo $d->konten; ?>"
                            data-keterangan='<?php echo $d->keterangan; ?>'>
                            <i class="icofont icofont-search"></i><span class="m-l-10">Lihat Detail</span>
                          </a>
                        </td>
                      </tr>
                      <?php } ?>
                    <?php $no++; } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                    <?php if ($links == "unduh") { ?>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Tahun</th>
                      <th>Deskripsi</th>
                      <th>Link Download</th>
                      <th>Action</th>
                    <?php }else if ($links == "request") { ?>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Email/No Hp</th>
                      <th>Jenis Dokumen Yang Diminta</th>
                      <th>Action</th>
                    <?php } ?>
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

<div class="modal fade modal-flex" id="detail_request" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Detail Permintaan Dokumen</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <form>
          <div class="form-group row">
            <label for="nama" class="col-md-2 col-form-label form-control-label" style="vertical-align: top;">Nama </label>
            <div class="col-md-10">
              : <label id="nama" class="col-form-label form-control-label"></label>
            </div>
          </div>
          <div class="form-group row">
            <label for="email" class="col-md-2 col-form-label form-control-label" style="vertical-align: top;">Email </label>
            <div class="col-md-10">
              : <label id="email" class="col-form-label form-control-label" style="text-transform: lowercase;"></label>
            </div>
          </div>
          <div class="form-group row">
            <label for="nohp" class="col-md-2 col-form-label form-control-label" style="vertical-align: top;">No.Hp </label>
            <div class="col-md-10">
              : <label id="nohp" class="col-form-label form-control-label"></label>
            </div>
          </div>
          <div class="form-group row">
            <label for="konten" class="col-md-2 col-form-label form-control-label" style="vertical-align: top;">Dokumen  </label>
            <div class="col-md-10">
              : <label id="konten" class="col-form-label form-control-label"></label>
            </div>
          </div>
          <div class="form-group row">
            <label for="keterangan" class="col-md-2 col-form-label form-control-label" style="vertical-align: top;">Deskripsi </label>
            <div class="col-md-10">
              : <label id="keterangan" class="col-form-label form-control-label"></label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <br>
      </div>
      <!-- end of modal body                    -->
    </div>
    <!-- end of modal-content -->
  </div>
  <!-- end of modal-dialog -->
</div>
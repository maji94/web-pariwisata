<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <div class="container-fluid">

    <!-- Header Starts -->
    <div class="row">
      <div class="col-sm-12 p-0">
        <div class="main-header">
          <h4>Banner</h4>
          <ol class="breadcrumb breadcrumb-title breadcrumb-arrow">
            <li class="breadcrumb-item">
              <a href="<?php echo site_url('admin'); ?>">
                <i class="icofont icofont-home"></i> Dashboard
              </a>
            </li>
            <li class="breadcrumb-item"><a href="#"> Banner</a>
            </li>
          </ol>
        </div>
      </div>
    </div>
    <!-- Header end -->

    <!-- Tables start -->
    <!-- Row start -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Kalimat Sambutan dan Headline Banner</h5>            
          </div>

          <div class="card-block">
            <?php echo  form_open('admin/banner/do_edit/headline'); ?>
              <div class="form-group row">
                <label for="sambutan" class="col-md-2 col-form-label form-control-label">Kalimat Sambutan</label>
                <div class="col-md-5">
                  <textarea class="form-control" rows="4" id="sambutan" name="sambutan" class="form-control" placeholder="Kalimat Sambutan Banner Website"><?php echo unserialize($headline[0]->konten)['sambutan']; ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="tagline" class="col-md-2 col-form-label form-control-label">Tagline Banner</label>
                <div class="col-md-5">
                  <input type="text" id="tagline" name="tagline" class="form-control" placeholder="Tagline Banner Website" value="<?php echo unserialize($headline[0]->konten)['tagline']; ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-5">
                  <button type="submit" class="btn btn-success waves-effect waves-light m-r-30"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <!-- Hover effect table starts -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-header-text">Data Banner </h5>
            <a href="#" class="btn btn-success waves-effect waves-light f-right" data-toggle="modal" data-target="#add_banner"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto</th>
                      <th>Oleh</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php for ($i=0; $i <count($data) ; $i++) { ?>
                    <tr>
                      <td width="5%"><?php echo ($i+1); ?></td>
                      <td><img src="<?php echo base_url('assets/images/banner/'.str_replace('.', '_thumb.', $data[$i]->konten)); ?>" alt="" style="width: 200px"></td>
                      <td><?php echo $data[$i]->oleh; ?></td>
                      <td align="center" width="15%">
                        <a href="<?php echo site_url('admin/banner/naik/'.$data[$i]->id); ?>" style="margin-bottom: 5px;width: 140px;" class="btn btn-warning waves-effect waves-light" title="Naikkan Banner">
                          <i class="icofont icofont-arrow-up"></i><span class="m-l-10">Naikkan Banner</span>
                        </a><br>
                        <a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#edit_banner" data-id="<?php echo $data[$i]->id; ?>" data-oleh="<?php echo $data[$i]->oleh; ?>" data-foto="<?php echo $data[$i]->konten; ?>" style="margin-bottom: 5px;width: 140px;" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/banner/delete/'.$data[$i]->id); ?>" style="margin-bottom: 5px;width: 140px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No.</th>
                      <th>Foto</th>
                      <th>Oleh</th>
                      <th class="text-center">Action</th>
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

<div class="modal fade modal-flex" id="add_banner" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Tambah Data</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <?php echo  form_open_multipart('admin/banner/do_add/foto'); ?>
          <div class="form-group row">
            <label for="oleh" class="col-md-2 col-form-label form-control-label">Oleh </label>
            <div class="col-md-10">
              <input type="text" id="oleh" name="oleh" class="form-control" placeholder="Photo by ..">
            </div>
          </div>
          <div class="form-group row">
            <label for="foto" class="col-md-2 col-form-label form-control-label">File foto</label>
            <div class="col-md-10">
                <input type="file" id="foto" name="foto" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <button type="submit" class="btn btn-success waves-effect waves-light m-r-30"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
            </div>
          </div>
        <?php echo form_close(); ?>
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

<div class="modal fade modal-flex" id="edit_banner" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Ubah Data</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <?php echo  form_open_multipart('admin/banner/do_edit/foto'); ?>
          <div class="form-group row">
            <label for="edit_oleh" class="col-md-2 col-form-label form-control-label">Oleh </label>
            <div class="col-md-10">
              <input type="hidden" id="id" name="id">
              <input type="text" id="edit_oleh" name="edit_oleh" class="form-control" placeholder="Photo by ..">
            </div>
          </div>
          <div class="form-group row">
            <label for="edit_foto" class="col-md-2 col-form-label form-control-label">File foto</label>
            <div class="col-md-10">
                <input type="hidden" id="oldFoto" name="oldFoto">
                <input type="file" id="edit_foto" name="edit_foto" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <button type="submit" class="btn btn-success waves-effect waves-light m-r-30"><i class="icofont icofont-tick-mark"></i><span class="m-l-10"> Simpan</button>
            </div>
          </div>
        <?php echo form_close(); ?>
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
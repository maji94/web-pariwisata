<?php 
  $links = $this->uri->segment(2);
  $links2 = $this->uri->segment(3);

  if ($links == "operator") {
    $header = "Operator";
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
            <!-- <a href="<?php echo site_url('admin/operator/add/'); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a> -->
            <a href="#" class="btn btn-success waves-effect waves-light f-right" data-toggle="modal" data-target="#tambah_operator" title="Tambah Data"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span>
            </a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Foto</th>
                      <th>Nama</th>
                      <th>Username</th>>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no=1; foreach ($data as $d) { ?>
                    <tr>
                      <td width="5%"><?php echo $no; ?></td>
                      <td width="15%" align="center"><img src="<?php echo base_url('assets/images/user/'.str_replace('.', '_thumb.', $d->foto)); ?>" alt="" style="max-width: 120px;text-align: center;"></td>
                      <td><?php echo $d->nama; ?></td>
                      <td><?php echo $d->username; ?></td>
                      <td align="center" width="5%">
                        <a href="#" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#ubah_psw" data-id="<?php echo $d->id_user; ?>" style="margin-bottom: 5px;width: 135px;" title="Ubah Data">
                          <i class="icofont icofont-lock "></i><span class="m-l-10">Ubah Password</span>
                        </a><br>
                        <a href="#" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#ubah_operator" 
                          data-id="<?php echo $d->id_user; ?>" 
                          data-foto="<?php echo $d->foto; ?>" 
                          data-nama="<?php echo $d->nama; ?>" 
                          data-username="<?php echo $d->username; ?>" 
                          data-password="<?php echo $d->password; ?>" 
                          data-level="<?php echo $d->level; ?>" style="margin-bottom: 5px;width: 135px;" 
                          title="Ubah Data"> 
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </a><br>
                        <a href="<?php echo site_url('admin/operator/delete/'.$d->id_user); ?>" style="margin-bottom: 5px;width: 135px;" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </a>
                      </td>
                    </tr>
                    <?php $no++; } ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>No.</th>
                      <th>Foto</th>
                      <th>Nama</th>
                      <th>Username</th>>
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

<div class="modal fade modal-flex" id="ubah_psw" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Ubah Password</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <?php echo form_open_multipart('admin/operator/ubah_psw/','onSubmit="return cek_ubh_psw();"'); ?>
          <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label form-control-label">Password Baru *</label>
            <div class="col-md-9">
              <input type="hidden" id="id" name="id">
              <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password baru" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="konf_psw" class="col-md-3 col-form-label form-control-label">Konfirmasi Password *</label>
            <div class="col-md-9">
                <input type="password" id="konf_psw" name="konf_psw" class="form-control" placeholder="Ulangi password baru" required onkeyup="cek_register();">
                <span class="error" id="pesan_konfir"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
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

<div class="modal fade modal-flex" id="ubah_operator" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Ubah Operator</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <?php echo  form_open_multipart('admin/operator/do_edit/'); ?>
          <div class="form-group row">
            <label for="username" class="col-md-3 col-form-label form-control-label">Username *</label>
            <div class="col-md-9">
              <input type="hidden" id="edit_id" name="id">
              <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="nama" class="col-md-3 col-form-label form-control-label">Nama *</label>
            <div class="col-md-9">
              <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama operator" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="level" class="col-md-3 col-form-label form-control-label">Level *</label>
            <div class="col-md-9">
              <select name="level" id="level" id="level" class="form-control">
                <option value="admin">Admin</option>
                <option value="operator">Operator</option>
              </select>
            </div>
          </div>          
          <div class="form-group row">
            <label for="foto" class="col-md-3 col-form-label form-control-label">Foto </label>
            <div class="col-md-9">
              <input type="hidden" id="oldFoto" name="oldFoto">
              <input type="file" id="foto" name="foto" class="form-control" placeholder="Masukkan nama operator">
            </div>
          </div>
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
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

<div class="modal fade modal-flex" id="tambah_operator" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Tambah Operator</h5>
      </div>
      <!-- end of modal-header -->
      <div class="modal-body">
        <?php echo  form_open_multipart('admin/operator/do_add/'); ?>
          <div class="form-group row">
            <label for="username" class="col-md-3 col-form-label form-control-label">Username *</label>
            <div class="col-md-9">
              <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="nama" class="col-md-3 col-form-label form-control-label">Nama *</label>
            <div class="col-md-9">
              <input type="text" name="nama" class="form-control" placeholder="Masukkan nama operator" required>
            </div>
          </div>
          <div class="form-group row">
            <label for="nama" class="col-md-3 col-form-label form-control-label">Level *</label>
            <div class="col-md-9">
              <select name="level" class="form-control">
                <option value="admin">Admin</option>
                <option value="operator">Operator</option>
              </select>
            </div>
          </div>          
          <div class="form-group row">
            <label for="foto" class="col-md-3 col-form-label form-control-label">Foto </label>
            <div class="col-md-9">
              <input type="file" name="foto" class="form-control" placeholder="Masukkan nama operator">
            </div>
          </div>
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-9">
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
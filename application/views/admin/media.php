<?php 
  $links = $this->uri->segment(3);
  if ($links == "artikel") {
    $header = "Artikel";
    $add = "artikel";
  }else if ($links == "foto") {
    $header = "Galeri Foto";
    $add = "foto";
  }else if ($links == "video") {
    $header = "Galeri Video";
    $add = "video";
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
            <a href="<?php echo site_url('admin/media/add/'.$add); ?>" class="btn btn-success waves-effect waves-light f-right"><i class="icofont icofont-plus"></i><span class="m-l-10"> Tambah Data</span></a>
          </div>
          <div class="card-block">
            <div class="row">
              <div class="col-sm-12 table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="10%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td align="center" width="5%">
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-primary waves-effect waves-light" title="Ubah Data">
                          <i class="icofont icofont-pencil "></i><span class="m-l-10">Edit</span>
                        </button><br>
                        <button style="margin-bottom: 5px;width: 70px;" type="button" class="btn btn-default waves-effect waves-light" title="Hapus Data" onclick="return confirm('Data ini akan terhapus. Lanjutkan ?');">
                          <i class="icofont icofont-bin "></i><span class="m-l-10">Hapus</span>
                        </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
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

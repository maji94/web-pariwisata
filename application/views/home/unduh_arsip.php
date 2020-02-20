<!-- Banner -->
<section id="One" class="wrapper style3" style="background-image: url('../images/header.jpg');">
  <div class="inner">
    <header class="align-center">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <p>#visitbengkulu</p>
      <h2>LAYANAN</h2>
    </header>
  </div>
</section>

<!-- Content -->
<section id="one" class="wrapper style2">
  <div class="inner">

    <!-- Intro -->
    <div class="box">
      <div class="content">
        <header class="align-center">
          <p>DINAS PARIWISATA PROVINSI BENGKULU</p>
          <h2>UNDUH ARSIP</h2>
        </header>
        <span class="image fit"><img src="images/pic01.jpg" alt="" /></span>
        </br>
        <p style="text-align:justify;">Halaman unduh arsip dapat digunakan pengunjung untuk mencari dan mendownload dokumen terkait Dinas Pariwisata Provinsi Bengkulu. Pengunjung bisa mencari dokumen dengan mengetikan nama dokumnen yang diinginkan pada kolom "Search". Jika dokumen yang diinginkan tidak ditemukan, pengunjung bisa mengirim pesan ke admin dengan cara mengisi formulir permintaan dokumen yang ada di halaman <strong><a href="<?php echo site_url('layanan/request'); ?>">PERMINTAAN DOKUMEN</a></strong> berikut.</p>

        <!-- Table-->
        <div class="table-wrapper">
          <table class="alt" id="table_id">
            <thead>
              <tr>
                <th>No.</th>
                <th>Deskripsi</th>
                <th class="align-center">Didownload</th>
                <th class="align-center">Unduh</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($data as $d) { ?>
                <tr>
                  <td class="align-center" width="5%"><?php echo $no; ?></td>
                  <td><?php echo $d->nama; ?></td>
                  <td class="align-center" width="5%"><?php echo $d->didownload; ?> kali</td>
                  <td class="align-center" width="10%"><a href="<?php echo site_url('layanan/unduh/' . $d->id . '/' . $d->konten); ?>" class="button icon fa-download">Download</a></td>
                </tr>
              <?php $no++;
              } ?>
            </tbody>
          </table>
          </br>
        </div>
      </div>
    </div>
  </div>
</section>
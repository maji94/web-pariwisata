<!-- Banner -->
<section id="One" class="wrapper style3" style="background-image: url('../images/banner.jpg');">
	<div class="inner">
		<header class="align-center"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
          <h2>PERMINTAAN DOKUMEN</h2>
        </header>
        <span class="image fit"><img src="images/pic01.jpg" alt=""></span>
        </br>
        <p style="text-align:justify;">Halaman permintaan dokumen dapat digunakan pengunjung untuk meminta dokumen yang diinginkan. Pengunjung bisa mengisi formulir yang disediakan dan mengirimnya ke admin. Apabila pengunjung sudah mengisi formulir dengan benar, admin akan memproses dokumen yang diminta secepatnya. <strong>NAMUN</strong> sebelum mengirim permintaan dokumen, sebaiknya pengunjung memeriksa dokumen yang diinginkan pada halaman <strong><a href="<?php echo site_url('layanan/unduh/all'); ?>">UNDUH ARSIP</a></strong> berikut terlebih dahulu.</p>


        <!-- Form -->
        <?php echo form_open('layanan/request/send'); ?>
        <!-- <form method="post" action="#"> -->
        <div class="row uniform">
          <div class="6u 12u$(xsmall)">
            <input type="text" name="nama" id="nama" value="" placeholder="Nama anda" required>
          </div>
          <div class="6u$ 12u$(xsmall)">
            <input type="email" name="email" id="email" value="" placeholder="Email anda (dokumen yang diinginkan akan dikirim via Email)" required>
          </div>
          <div class="6u 12u$(xsmall)">
            <input type="text" name="nohp" id="nohp" value="" placeholder="Nomor telpon/Hp" required>
          </div>
          <div class="6u$ 12u$(xsmall)">
            <input type="text" name="dokumen" id="dokumen" value="" placeholder="Nama dokumen yang diinginkan" required>
          </div>
          <!-- Break -->
          <div class="12u$">
            <textarea name="keterangan" id="keterangan" placeholder="Silahkan deskripsikan alasan anda membutuhkan dokumen tersebut (mohon untuk diisi sebagai bahan pertimbangan admin)." rows="6" required></textarea>
          </div>
          <!-- Break -->
          <div class="6u$ 12u$(xsmall)">
            <?php echo $captcha; ?>
          </div>
          <div class="6u$ 12u$(xsmall)">
            <input type="text" name="captcha" id="captcha" value="" placeholder="Mohon masukkan captcha di atas" required>
          </div>
          <!-- Break -->
          <div class="12u$">
            <ul class="actions">
              <li><input type="submit" value="Send Message" onclick="return vcaptcha();"></li>
              <li><input type="reset" value="Reset" class="alt"></li>
            </ul>
          </div>
        </div>
        <!-- </form> -->
        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</section>
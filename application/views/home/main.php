<!-- Banner -->
<section class="banner full">
	<?php foreach ($foto_headline as $d) { ?>
	<article>
		<img src="<?php echo base_url('assets/images/banner/'.str_replace('.', '_thumb.', $d->konten)); ?>" alt="" />
		<div class="inner">
			<header>
				<p><?php echo unserialize($headline[0]->konten)['sambutan']; ?></p>
				<h2><?php echo unserialize($headline[0]->konten)['tagline']; ?></h2>
			</header>
		</div>
	</article>
	<?php } ?>
</section>
<!-- Banner -->

<!-- Best Articles -->
<section id="one" class="wrapper style2" style="padding-bottom: 10px;">
	<div class="inner">
		<header class="align-center">
			<img style="max-width:100px" src="<?php echo base_url('assets/images/logo-provinsi-bengkulu.png') ?>" alt="Logo Provinsi Bengkulu">
			<p class="special">Artikel Pilihan oleh Dinas Pariwisata Bengkulu</p>
			<h2 href="https://disparprovbengkulu.com/artikel.html">Artikel</h2>
		</header>
		<div class="grid-style">

			<?php foreach ($artikel as $d) { ?>
			<!-- Artikel 1 1 -->
			<div>
				<div class="box">
					<div class="image fit">
						<img src="<?php echo base_url('assets/images/artikel/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt="" />
					</div>
					<div class="content">
						<header class="align-center">
							<h2><?php echo $d->judul; ?></h2>
						</header>
						<p><?php echo substr(strip_tags($d->konten), 0, 100); ?>...</p>
						<footer class="align-center">
							<a href="<?php echo site_url('media/artikel/'.$d->id) ?>" class="button alt">Lebih Lanjut</a>
						</footer>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
	<div class="align-center" class="inner">
		<ul class="actions"> 
			<li><a href="<?php echo site_url('media/artikel/all'); ?>" class="button special fit">Lihat Semua Artikel</a></li>
		</ul>
	</div>
</section>
<!-- Best Arcticles -->

<section id="two" class="wrapper style3" style="background-image: url('<?php echo base_url(); ?>assets/front/images/banner.jpg');">
	<div class="inner">
		<header class="align-center">
			<img src="<?php echo base_url('assets/images/Wonderful_Bengkulu_Putih.png'); ?>" style="float: left;width: 175px;">
			<img src="<?php echo base_url('assets/images/Wonderful_Indonesia_Putih.png'); ?>" style="float: right;width: 210px;padding-top: 9px;">
			<p>Selamat Datang di Bengkulu</p>
			<h2>Wonderful Bengkulu</h2>
		</header>
	</div>
</section>

<section id="one" class="wrapper style2" style="padding-bottom: 10px;">
	<div class="inner">
		<header class="align-center">
			<p class="special">Event Unggulan Dinas Pariwisata Provinsi Bengkulu</p>
			<h2 href="https://disparprovbengkulu.com/artikel.html">Event</h2>
		</header>
		<div class="grid-style">

			<?php foreach ($event as $d) { ?>
			<!-- Artikel 1 1 -->
			<div>
				<div class="box">
					<div class="image fit">
						<img src="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt="" />
					</div>
					<div class="content">
						<header class="align-center">
							<h2><?php echo $d->nama; ?></h2>
						</header>
						<p><?php echo substr(strip_tags($d->konten), 0, 100); ?>...</p>
						<footer class="align-center">
							<a href="<?php echo site_url('kreatif/event/'.$d->id) ?>" class="button alt">Lebih Lanjut</a>
						</footer>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
	<div class="align-center" class="inner">
		<ul class="actions"> 
			<li><a href="<?php echo site_url('kreatif/event/all'); ?>" class="button special fit">Lihat Semua Event</a></li>
		</ul>
	</div>
</section>

<section id="two" class="wrapper style3">
	<div class="inner">
		<header class="align-center">
			<p>Our Social Media</p>
		</header>
		<div class="grid-style">
			<div>
				<div class="box" style="background-color: transparent;">
					<div class="content">
						<header class="align-center">
							<h2>Instagram</h2>
						</header>
					</div>
				</div>
			</div>
			<div>
				<div class="box" style="background-color: transparent;">
					<div class="content">
						<header class="align-center">
							<a href="https://www.youtube.com/channel/UCQhSUR6rdzqf5ra55piuFNw" target="_blank" style="text-decoration: unset;"><h2>YouTube</h2></a>
						</header>
						<iframe width="100%" height="360" src="https://www.youtube.com/embed/videoseries?list=PLzdSjxlMA-IK2F0gwSO8NW7210eXo1uRA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Best Photos -->
<section id="three" class="wrapper style2" style="padding-bottom: 10px;">
	<div class="inner">
		<header class="align-center">
			<p class="special">Unggah foto terbaikmu di Bengkulu dengan #visitbengkulu</p>
			<h2>Galeri Foto</h2>
		</header>
		<div class="grid-style">

			<?php foreach ($foto as $d) { ?>
			<div>
				<div class="box">
					<div class="image fit">
						<a href="<?php echo site_url('media/galeri/'.$d->id); ?>">
							<img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="">
						</a>
					</div>
					<div class="content">
						<header class="align-center">
							<p style="text-align: left;"><i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?> <span style="float: right;"><i class="icofont-eye-alt"></i>Dilihat : <?php echo $d->dilihat; ?> kali</span></p>
							<a href="<?php echo site_url('media/galeri/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->judul; ?></h2></a>
						</header>
						<footer class="align-center">
							<a href="<?php echo site_url('media/galeri/'.$d->id); ?>" class="button alt">Lebih Lanjut</a>
						</footer>
					</div>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
	<div class="align-center" class="inner">
		<ul class="actions">
			<li><a href="<?php echo site_url('media/galeri/foto'); ?>" class="button special fit">Lihat Semua Galeri</a></li>
		</ul>
	</div>
</section>
<!-- Best Photo -->

<!-- Map -->
<div class="inner">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1044.6503280381876!2d102.29284643793673!3d-3.817814946490317!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x185a3947fd0afa4e!2sDinas%20Pariwisata%20Provinsi%20Bengkulu!5e1!3m2!1sen!2sid!4v1572656842148!5m2!1sen!2sid" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</div>
<!-- Map -->
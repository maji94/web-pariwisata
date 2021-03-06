<?php 
	$links = $this->uri->segment(3);
	if ($links == "foto") {
		$header = "GALERI FOTO";
	}else if ($links == "video") {
		$header = "GALERI VIDEO";
	}
 ?>
<!-- One -->
<section id="One" class="wrapper style3">
	<div class="inner">
		<header class="align-center">
			<p>#visitbengkulu</p>
			<h2><?php echo $header; ?></h2>
		</header>
	</div>
</section>

<!-- Two -->
<section id="one" class="wrapper style2">
	<div class="inner">
		<div class="grid-style">

			<?php foreach ($data as $d) { ?>
			<div>
				<div class="box">
					<div class="image fit">
						<a href="<?php echo site_url('media/galeri/'.$d->id); ?>">
						<?php if ($links == "foto") { ?>
							<img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="">
						<?php }else if ($links == "video") { ?>
							<img src="<?php echo base_url('assets/images/video/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt="">
						<?php } ?>
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
</section>

<section class="wrapper" style="padding:2em;">
	<div class="center">
		<div class="pagination">
			<?php echo $pagi; ?>
		</div>
	</div>
</section>
<?php 
	$links = $this->uri->segment(2);
	if ($links == "galeri_dinas") {
		$header = "GALERI FOTO DINAS";
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
						<a href="<?php echo site_url('tentang/galeri_dinas/'.$d->id); ?>">
							<img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="">
						</a>
					</div>
					<div class="content">
						<header class="align-center">
							<p style="text-align: left;"><i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?></p>
							<a href="<?php echo site_url('tentang/galeri_dinas/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->nama; ?></h2></a>
						</header>
						<footer class="align-center">
							<a href="<?php echo site_url('tentang/galeri_dinas/'.$d->id); ?>" class="button alt">Lebih Lanjut</a>
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
<?php 
	$konten = unserialize($foto[0]->konten);
 ?>
<!-- Banner -->
	<section id="One" class="wrapper style3">
		<div class="inner">
			<header class="align-center"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<p>#visitbengkulu</p>
				<h2>ARTIKEL</h2>
			</header>
		</div>
	</section>

<!-- Content -->
	<section id="two" class="wrapper style2">
		<div class="inner">
			<div class="box">
				<?php foreach ($data as $d) { ?>
				<div class="content" style="padding-bottom: 0px;">
					<header class="align-center">
						<h2><?php echo $d->judul; ?></h2>
					</header>
					<span class="image fit"><img src="<?php echo base_url('assets/images/artikel/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt=""></span>
					<br>
					<p style="text-align: left;"><span><i class="fa fa-user" aria-hidden="true"></i> <?php echo $d->oleh; ?></span> | <i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?> | <span><i class="icofont-eye-alt"></i> Dilihat : <?php echo ($d->dilihat+1); ?> kali</span></p>
					<br>
					<?php echo $d->konten; ?>
					<br>
					<a href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[0])); ?>" data-lightbox="mygallery" class="button special alt"><i class="fa fa-picture-o" aria-hidden="true"></i> Lihat Foto</a>
					<?php for ($m=1; $m < count($konten); $m++) { ?>
						<a href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[$m])); ?>" data-lightbox="mygallery">
					<?php } ?>
					<a id="video" video-url="<?php echo $d->link_video ?>" class="button special alt"><i class="fa fa-film" aria-hidden="true"></i> Lihat Video</a>
					<a href="https://goo.gl/maps/sEBduEGu7czKC9MW9" class="button special alt" target="_blank"><i class="fa fa-map-o" aria-hidden="true"></i> Lihat Maps</a>
					<br><hr>
					Share this : 
					<div class="sharethis-inline-share-buttons"></div>
				</div>
				<?php } ?>

				<!-- More Photos-->
				<div class="content">
					<header class="align-center">
						<h2>Artikel Lain</h2>
					</header>

					<div class="grid-style">
						<?php foreach ($other as $d) {
							if ($d->id != $this->uri->segment(3)) {
						 ?>
						<div>
							<div class="box">
								<div class="image fit">
									<a href="<?php echo site_url('media/artikel/'.$d->id); ?>">
										<img src="<?php echo base_url('assets/images/artikel/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt="">
									</a>
								</div>
								<div class="content">
									<header class="align-center">
										<p style="text-align: left;"><i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?> <span style="float: right;"><i class="icofont-eye-alt"></i>Dilihat : <?php echo $d->dilihat; ?> kali</span></p>
										<a href="<?php echo site_url('media/artikel/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->judul; ?></h2></a>
									</header>
								</div>
							</div>
						</div>
						<?php } } ?>
					</div>
				</div>

			</div>
		</div>
	</section>


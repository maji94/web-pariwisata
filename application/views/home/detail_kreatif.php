<?php 
	$foto_galeri = unserialize($data[0]->foto_galeri);
 ?>
<!-- Banner -->
	<section id="One" class="wrapper style3">
		<div class="inner">
			<header class="align-center"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<p>#visitbengkulu</p>
				<h2>KREATIF</h2>
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
						<h2><?php echo $d->nama; ?></h2>
					</header>
					<span class="image fit"><img src="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt=""></span>
					<br>
					<p style="text-align: left;"><span><i class="icofont-eye-alt"></i> Dilihat : <?php echo ($d->dilihat+1); ?> kali</span></p>
					<br>
					<?php echo $d->konten; ?>
					<br>
					<a href="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', $foto_galeri[0])); ?>" data-lightbox="mygallery" class="button special alt"><i class="fa fa-picture-o" aria-hidden="true"></i> Lihat Foto</a>
					<?php for ($m=1; $m < count($foto_galeri); $m++) { ?>
						<a href="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', $foto_galeri[$m])); ?>" data-lightbox="mygallery">
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
						<h2>Informasi Akomodasi Lainnya</h2>
					</header>

					<div class="grid-style">
						<?php foreach ($other as $d) {
							if ($d->id != $this->uri->segment(3)) {
						 ?>
						<div>
							<div class="box">
								<div class="image fit">
									<a href="<?php echo site_url('kreatif/'.$this->uri->segment(2).'/'.$d->id); ?>">
										<img src="<?php echo base_url('assets/images/kreatif/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt="">
									</a>
								</div>
								<div class="content">
									<header class="align-center">
										<p style="text-align: right;"><i class="icofont-eye-alt"></i>Dilihat : <?php echo $d->dilihat; ?> kali</p>
										<a href="<?php echo site_url('kreatif/'.$this->uri->segment(2).'/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->nama; ?></h2></a>
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


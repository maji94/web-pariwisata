<?php 
	if ($data[0]->jenis == "foto") {
		$header = "GALERI FOTO";
		$konten = unserialize($data[0]->konten);
	}else if ($data[0]->jenis == "video") {
		$header = "GALERI VIDEO";
	}
 ?>

<!-- Banner -->
	<section id="One" class="wrapper style3">
		<div class="inner">
			<header class="align-center">
				<p>#visitbengkulu</p>
				<h2><?php echo $header; ?></h2>
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
						<?php if ($d->jenis == "foto") { ?>
							<div class="image fit">
								<a href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" data-lightbox="mygallery">
									<img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="" />
								</a>
							</div>
						<?php } else if ($d->jenis == "video") { ?>
							<iframe style="width: 100%;min-height: 500px;" src="https://www.youtube.com/embed/<?php echo substr($d->konten, (strpos($d->konten, 'v='))+2); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
						<?php } ?>
						</br>
						<p style="text-align: left;"><span><i class="fa fa-user" aria-hidden="true"></i> <?php echo $d->oleh; ?></span> | <i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?> | <span><i class="icofont-eye-alt"></i> Dilihat : <?php echo ($d->dilihat+1); ?> kali</span></p>
						<?php if ($d->jenis == "foto") { ?>
							<div class="gallery">
							<?php for ($i=1; $i < count($konten); $i++) { ?>
								<div style="width: 10em;padding: 0px;">
									<div class="image fit">
										<a href="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[$i])); ?>" data-lightbox="mygallery">
											<img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', $konten[$i])); ?>" alt="" />
										</a>
									</div>
								</div>
							<?php } ?>
							</div>
						<?php } ?>
						<hr>
						Share this : 
					</div>
				<?php } ?>

				
	
				<!-- More Photos-->
				<div class="content">
					<header class="align-center">
						<h2>Galeri Lain</h2>
					</header>

					<div class="grid-style">
						<?php foreach ($other as $d) {
							if ($d->id != $this->uri->segment(3)) {
						 ?>
						<div>
							<div class="box">
								<div class="image fit">
									<a href="<?php echo site_url('media/galeri/'.$d->id); ?>">
									<?php if ($d->jenis == "foto") { ?>
										<img src="<?php echo base_url('assets/images/foto/'.str_replace('.', '_thumb.', unserialize($d->konten)[0])); ?>" alt="">
									<?php }else if ($d->jenis == "video") { ?>
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
						<?php } } ?>
					</div>
				</div>
			</div>
		</div>
	</section>
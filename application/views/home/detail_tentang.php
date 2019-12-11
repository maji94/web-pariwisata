<?php 
	$links = $this->uri->segment(2);
	if ($links == "galeri_dinas") {
		$konten = unserialize($data[0]->konten);
	}
 ?>
<!-- Banner -->
<section id="One" class="wrapper style3" style="background-image: url('../images/header.jpg');">
	<div class="inner">
		<header class="align-center">
			<p>#visitbengkulu</p>
			<h2>TENTANG</h2>
		</header>
	</div>
</section>

<!-- Content -->
<section id="one" class="wrapper style2">
	<div class="inner">

		<!-- Intro -->
		<div class="box">
			<div class="content">
				<?php if ($links == "struktur") { ?>
					<header class="align-center">
						<p>DINAS PARIWISATA PROVINSI BENGKULU</p>
						<h2>STUKTUR ORGANISASI</h2>
					</header>
					<span class="image fit"><img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $data[0]->konten)); ?>" alt=""></span>
					<br>
				<?php }else if ($links == "profil") { ?>
					<header class="align-center">
						<p>DINAS PARIWISATA PROVINSI BENGKULU</p>
						<h2>PROFIL ORGANISASI</h2>
					</header>
					<span class="image fit"><img src="<?php echo base_url('assets/images/tentang/'.$data[0]->nama); ?>" alt=""></span>
					<br>
					<?php echo $data[0]->konten; ?>
					<br>
				<?php }else if ($links == "galeri_dinas") { ?>
					<header class="align-center">
						<p>DINAS PARIWISATA PROVINSI BENGKULU</p>
						<h2><?php echo $data[0]->nama; ?></h2>
						<p><?php echo tgl_indo($data[0]->tanggal); ?></p>
					</header>
					<div class="image fit">
						<a href="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', unserialize($data[0]->konten)[0])); ?>" data-lightbox="mygallery">
							<img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', unserialize($data[0]->konten)[0])); ?>" alt="" />
						</a>
					</div>
					<br>
					<div class="gallery">
					<?php for ($i=1; $i < count($konten); $i++) { ?>
						<div style="width: 10em;padding: 0px;">
							<div class="image fit">
								<a href="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $konten[$i])); ?>" data-lightbox="mygallery">
									<img src="<?php echo base_url('assets/images/tentang/'.str_replace('.', '_thumb.', $konten[$i])); ?>" alt="" />
								</a>
							</div>
						</div>
					<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
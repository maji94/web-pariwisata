<!-- One -->
<section id="One" class="wrapper style3">
	<div class="inner">
		<header class="align-center">
			<p>#visitbengkulu</p>
			<h2>AKOMODASI</h2>
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
						<a href="<?php echo site_url('akomodasi/'.$this->uri->segment(2).'/'.$d->id); ?>">
							<img src="<?php echo base_url('assets/images/'.$this->uri->segment(2).'/'.str_replace('.', '_thumb.', unserialize($d->foto_galeri)[0])); ?>" alt="" />
						</a>
					</div>
					<div class="content">
						<header class="align-center">
							<p style="text-align: right;"><i class="icofont-eye-alt"></i>Dilihat : <?php echo $d->dilihat; ?> kali</p>
							<a href="<?php echo site_url('akomodasi/'.$this->uri->segment(2).'/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->nama; ?></h2></a>
						</header>
						<footer class="align-center">
							<a href="<?php echo site_url('akomodasi/'.$this->uri->segment(2).'/'.$d->id); ?>" class="button alt">Lebih Lanjut</a>
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
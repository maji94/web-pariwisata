<!-- One -->
<section id="One" class="wrapper style3">
	<div class="inner">
		<header class="align-center">
			<p>#visitbengkulu</p>
			<h2>ARTIKEL</h2>
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
						<a href="<?php echo site_url('media/artikel/'.$d->id); ?>">
							<img src="<?php echo base_url('assets/images/artikel/'.str_replace('.', '_thumb.', $d->headline)); ?>" alt="" />
						</a>
					</div>
					<div class="content">
						<header class="align-center">
							<p style="text-align: left;"><i class="icofont-calendar"></i> <?php echo tgl_indo($d->tanggal); ?> <span style="float: right;"><i class="icofont-eye-alt"></i>Dilihat : <?php echo $d->dilihat; ?> kali</span></p>
							<a href="<?php echo site_url('media/artikel/'.$d->id); ?>" style="text-decoration: unset;"><h2><?php echo $d->judul; ?></h2></a>
						</header>
						<footer class="align-center">
							<a href="<?php echo site_url('media/artikel/'.$d->id); ?>" class="button alt">Lebih Lanjut</a>
						</footer>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
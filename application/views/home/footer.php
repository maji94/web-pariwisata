<!-- Footer -->
<footer id="footer">
	<div class="container">
		<div class="grid-style">
			<div>
				<div class="alamat">
					<h3>Dinas Pariwisata Provinsi Bengkulu</h3>
					<p>
						<i class="fa fa-map-marker" aria-hidden="true"></i><span> Jl. Kapten Pierre Tendean No.KM 6,5, Jl. Gedang, Kec. Gading Cemp., Kota Bengkulu, Bengkulu 38225</span>
					</p>
					<p>
						<i class="fa fa-clock-o" aria-hidden="true"></i><span> Jam Pelayanan : 08.00 - 16.30 WIB</span>
					</p>
					<!-- <p>
						<i class="fa fa-phone" aria-hidden="true"></i><span> (022) 7271724</span>
					</p>
					<p>
						<i class="fa fa-whatsapp" aria-hidden="true"></i><span> 0811 2863 333</span>
					</p> -->
					<p>
						<i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:pariwisatabengkuluprov@gmail.com"> pariwisatabengkuluprov@gmail.com</a>
					</p>
					<h3>Link Terkait</h3>
					<p><a href="https://bengkuluprov.go.id" target="_blank">https://bengkuluprov.go.id</a></p>
					<p><a href="http://www.kemenpar.go.id" target="_blank">http://www.kemenpar.go.id</a></p>
					<p><a href="https://www.lapor.go.id" target="_blank">https://www.lapor.go.id</a></p>
					<ul class="icons" style="margin: 0">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-youtube-play"><span class="label">Email</span></a></li>
					</ul>
					&copy; <a href="<?php echo site_url(); ?>">DINAS PARIWISATA PROVINSI BENGKULU</a>. All rights reserved.
				</div>
			</div>
			<div>
				<div class="alamat">
					<h3>Informasi Dinas</h3>
					<p><a href="<?php echo site_url('tentang/struktur'); ?>">Struktur Organisasi</a></p>
					<p><a href="<?php echo site_url('tentang/geleri_dinas/all'); ?>">Galeri Foto Dinas</a></p>
					<p><a href="<?php echo site_url('tentang/profil'); ?>">Profil Dinas</a></p>
					<h3>Statistik Pengunjung</h3>
					<div class="pengunjung">
						<div class="row">
							<p>Pengunjung Online</p>
							<div style="float: right;">
								<p style="font-weight: 500;"><?php echo $pengunjung['online']; ?></p>
							</div>
						</div>
						<div class="row">
							<p>Pengunjung Hari ini</p>
							<div style="float: right;">
								<p style="font-weight: 500;"><?php echo $pengunjung['todayvisit']; ?></p>
							</div>
						</div>
						<div class="row">
							<p>Hits Hari ini</p>
							<div style="float: right;">
								<p style="font-weight: 500;"><?php echo $pengunjung['todayhits']->todayhits; ?></p>
							</div>
						</div>
						<div class="row">
							<p>Total Hits</p>
							<div style="float: right;">
								<p style="font-weight: 500;"><?php echo $pengunjung['totalhits']->totalhits; ?></p>
							</div>
						</div>
						<div class="row">
							<p>Total Pengunjung</p>
							<div style="float: right;">
								<p style="font-weight: 500;"><?php echo $pengunjung['totalvisit']; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="copyright">
	</div>
</footer>
<!-- Footer
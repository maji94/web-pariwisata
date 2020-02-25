<aside class="main-sidebar hidden-print ">
  <section class="sidebar" id="sidebar-scroll">

    <div class="user-panel">
      <div class="f-left image">
        <?php if ($this->session->userdata('foto') != "") { ?>
          <img style="height: 40px;width: 40px;" src="<?php echo base_url('assets/images/user/' . str_replace('.', '_thumb.', $this->session->userdata('foto'))); ?>" alt="User Image" class="img-circle">
        <?php } else { ?>
          <img style="height: 40px;width: 40px;" src="<?php echo base_url('assets/images/avatar-1.png'); ?>" alt="User Image" class="img-circle">
        <?php } ?>
      </div>
      <div class="f-left info">
        <p><?php echo $this->session->userdata('nama'); ?></p>
        <p class="designation"><?php echo $this->session->userdata('lvl_user'); ?></p>
      </div>
    </div>

    <?php
      $link = $this->uri->segment(2);
      $link2 = $this->uri->segment(3);
      $link3 = $this->uri->segment(4);
    ?>

    <!-- Sidebar Menu-->
    <ul class="sidebar-menu">
      <li class="<?php if ($link == '') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="<?php echo site_url('admin'); ?>">
          <i class="icon-speedometer"></i><span> Dashboard</span>
        </a>
      </li>
      <li class="nav-level">Manajemen Data</li>
      <li class="<?php if ($link == 'banner') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/banner'); ?>">
          <i class="icon-layers"></i>
          <span> Banner</span>
        </a>
      </li>
      <li class="<?php if ($link == 'media') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-picture"></i>
          <span> Media</span>
          <?php if ($count_artikel != 0) { ?>
            <span class="label label-success menu-caption">New</span>
          <?php } ?>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'artikel' or $link3 == 'artikel') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/artikel'); ?>">
              <i class="icon-arrow-right"></i>
              Artikel
              <?php if ($count_artikel != 0) { ?>
                <span class="label label-primary menu-caption"><?php echo $count_artikel; ?> pending</span>
              <?php } ?>
            </a>
          </li>
          <li class="<?php if ($link2 == 'foto' or $link3 == 'foto') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/foto'); ?>">
              <i class="icon-arrow-right"></i>
              Galeri Foto
            </a>
          </li>
          <li class="<?php if ($link2 == 'video' or $link3 == 'video') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/video'); ?>">
              <i class="icon-arrow-right"></i>
              Galeri Video
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'kreatif') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-cup"></i>
          <span> Kreatif</span>
          <?php if ($count_event != 0) { ?>
            <span class="label label-success menu-caption">New</span>
          <?php } ?>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'komunitas' or $link3 == 'komunitas') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/komunitas'); ?>">
              <i class="icon-arrow-right"></i>
              Komunitas
            </a>
          </li>
          <li class="<?php if ($link2 == 'event' or $link3 == 'event') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/event'); ?>">
              <i class="icon-arrow-right"></i>
              Event
              <?php if ($count_event != 0) { ?>
                <span class="label label-default menu-caption"><?php echo $count_artikel; ?> pending</span>
              <?php } ?>
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'atraksi') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-directions"></i>
          <span> Atraksi</span>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'alam' or $link3 == 'alam') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/alam'); ?>">
              <i class="icon-arrow-right"></i>
              Alam
            </a>
          </li>
          <li class="<?php if ($link2 == 'budaya' or $link3 == 'budaya') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/budaya'); ?>">
              <i class="icon-arrow-right"></i>
              Budaya
            </a>
          </li>
          <li class="<?php if ($link2 == 'museum' or $link3 == 'museum') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/buatan'); ?>">
              <i class="icon-arrow-right"></i>
              Buatan
            </a>
          </li>
          <li class="<?php if ($link2 == 'kuliner' or $link3 == 'kuliner') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/kuliner'); ?>">
              <i class="icon-arrow-right"></i>
              Kuliner
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'akomodasi') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-map"></i>
          <span> Akomodasi & Transportasi</span>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'hotel' or $link3 == 'hotel') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/hotel'); ?>">
              <i class="icon-arrow-right"></i>
              Hotel & Penginapan
            </a>
          </li>
          <li class="<?php if ($link2 == 'restoran' or $link3 == 'restoran') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/restoran'); ?>">
              <i class="icon-arrow-right"></i>
              Restoran
            </a>
          </li>
          <li class="<?php if ($link2 == 'transportasi' or $link3 == 'transportasi') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/transportasi'); ?>">
              <i class="icon-arrow-right"></i>
              Transportasi
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'layanan') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-speech"></i>
          <span> Layanan</span>
          <?php if ($count_request != 0) { ?>
            <span class="label label-success menu-caption">New</span>
          <?php } ?>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'unduh' or $link3 == 'unduh') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/unduh'); ?>">
              <i class="icon-arrow-right"></i>
              Unduh Arsip
            </a>
          </li>
          <li class="<?php if ($link2 == 'request' or $link3 == 'request') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/request'); ?>">
              <i class="icon-arrow-right"></i>
              Permintaan Dokumen
              <?php if ($count_request != 0) { ?>
                <span class="label label-warning menu-caption"><?php echo $count_request; ?></span>
              <?php } ?>
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'tentang') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-drawer"></i>
          <span> Tentang Kami</span>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li class="<?php if ($link2 == 'struktur' or $link3 == 'struktur') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/struktur'); ?>">
              <i class="icon-arrow-right"></i>
              Struktur Organisasi
            </a>
          </li>
          <li class="<?php if ($link2 == 'galeri' or $link3 == 'galeri') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/galeri'); ?>">
              <i class="icon-arrow-right"></i>
              Galeri Dinas
            </a>
          </li>
          <li class="<?php if ($link2 == 'profil' or $link3 == 'profil') {echo 'active';} ?>">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/profil'); ?>">
              <i class="icon-arrow-right"></i>
              Profil
            </a>
          </li>
        </ul>
      </li>
      <li class="<?php if ($link == 'operator') {echo "active";} ?> treeview">
        <a class="waves-effect waves-dark" href="<?php echo site_url('admin/operator'); ?>">
          <i class="icon-people"></i>
          <span> Operator</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
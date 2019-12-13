<aside class="main-sidebar hidden-print " >
   <section class="sidebar" id="sidebar-scroll">

      <div class="user-panel">
         <div class="f-left image">
            <img src="<?php echo base_url(); ?>assets/images/avatar-1.png" alt="User Image" class="img-circle">
         </div>
         <div class="f-left info">
            <p>John Doe</p>
            <p class="designation">Admin</p>
         </div>
      </div>

      <?php 
      $link = $this->uri->segment(2);
      $link2 = $this->uri->segment(3);
      $link3 = $this->uri->segment(4);
       ?>

      <!-- Sidebar Menu-->
      <ul class="sidebar-menu">
         <li class="<?php if($link == ''){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin'); ?>">
               <i class="icon-speedometer"></i><span> Dashboard</span>
            </a>
         </li>
         <li class="nav-level">Manajemen Data</li>
         <li class="<?php if($link == 'banner'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/banner'); ?>">
               <i class="icon-layers"></i>
               <span> Banner</span>
            </a>
         </li>
         <li class="<?php if($link == 'media'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-picture"></i>
               <span> Media</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'artikel' OR $link3 == 'artikel'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/artikel'); ?>">
                     <i class="icon-arrow-right"></i>
                     Artikel
                  </a>
               </li>
               <li class="<?php if($link2 == 'foto' OR $link3 == 'foto'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/foto'); ?>">
                     <i class="icon-arrow-right"></i>
                     Galeri Foto
                  </a>
               </li>
               <li class="<?php if($link2 == 'video' OR $link3 == 'video'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/video'); ?>">
                     <i class="icon-arrow-right"></i>
                     Galeri Video
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'kreatif'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-cup"></i>
               <span> Kreatif</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'komunitas' OR $link3 == 'komunitas'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/komunitas'); ?>">
                     <i class="icon-arrow-right"></i>
                     Komunitas
                  </a>
               </li>
               <li class="<?php if($link2 == 'event' OR $link3 == 'event'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/event'); ?>">
                     <i class="icon-arrow-right"></i>
                     Event
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'atraksi'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-directions"></i>
               <span> Atraksi</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'alam' OR $link3 == 'alam'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/alam'); ?>">
                     <i class="icon-arrow-right"></i>
                     Alam
                  </a>
               </li>
               <li class="<?php if($link2 == 'budaya' OR $link3 == 'budaya'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/budaya'); ?>">
                     <i class="icon-arrow-right"></i>
                     Budaya
                  </a>
               </li>
               <li class="<?php if($link2 == 'museum' OR $link3 == 'museum'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/museum'); ?>">
                     <i class="icon-arrow-right"></i>
                     Museum
                  </a>
               </li>
               <li class="<?php if($link2 == 'kuliner' OR $link3 == 'kuliner'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/atraksi/kuliner'); ?>">
                     <i class="icon-arrow-right"></i>
                     Kuliner
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'akomodasi'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-map"></i>
               <span> Akomodasi & Transportasi</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'hotel' OR $link3 == 'hotel'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/hotel'); ?>">
                     <i class="icon-arrow-right"></i>
                     Hotel & Penginapan
                  </a>
               </li>
               <li class="<?php if($link2 == 'restoran' OR $link3 == 'restoran'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/restoran'); ?>">
                     <i class="icon-arrow-right"></i>
                     Restoran
                  </a>
               </li>
               <li class="<?php if($link2 == 'transportasi' OR $link3 == 'transportasi'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/transportasi'); ?>">
                     <i class="icon-arrow-right"></i>
                     Transportasi
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'layanan'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-speech"></i>
               <span> Layanan</span>
               <span class="label label-success menu-caption">New</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'unduh' OR $link3 == 'unduh'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/unduh'); ?>">
                     <i class="icon-arrow-right"></i>
                     Unduh Arsip
                  </a>
               </li>
               <li class="<?php if($link2 == 'request' OR $link3 == 'request'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/request'); ?>">
                     <i class="icon-arrow-right"></i>
                     Permintaan Dokumen
                     <span class="label label-warning menu-caption">1</span>
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'tentang'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-drawer"></i>
               <span> Tentang Kami</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'struktur' OR $link3 == 'struktur'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/struktur'); ?>">
                     <i class="icon-arrow-right"></i>
                     Struktur Organisasi
                  </a>
               </li>
               <li class="<?php if($link2 == 'galeri' OR $link3 == 'galeri'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/galeri'); ?>">
                     <i class="icon-arrow-right"></i>
                     Galeri Dinas
                  </a>
               </li>
               <li class="<?php if($link2 == 'profil' OR $link3 == 'profil'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/profil'); ?>">
                     <i class="icon-arrow-right"></i>
                     Profil
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'operator'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/operator'); ?>">
               <i class="icon-people"></i>
               <span> Operator</span>
            </a>
         </li>
      </ul>
   </section>
</aside>
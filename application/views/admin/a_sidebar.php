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
               <li class="<?php if($link2 == 'artikel'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/artikel'); ?>">
                     <i class="icon-arrow-right"></i>
                     Artikel
                  </a>
               </li>
               <li class="<?php if($link2 == 'foto'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/media/foto'); ?>">
                     <i class="icon-arrow-right"></i>
                     Galeri Foto
                  </a>
               </li>
               <li class="<?php if($link2 == 'video'){echo 'active';} ?>">
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
               <li class="<?php if($link2 == 'komunitas'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/komunitas'); ?>">
                     <i class="icon-arrow-right"></i>
                     Komunitas
                  </a>
               </li>
               <li class="<?php if($link2 == 'event'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/kreatif/event'); ?>">
                     <i class="icon-arrow-right"></i>
                     Event
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'destinasi'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-directions"></i>
               <span> Destinasi</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'alam'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/destinasi/alam'); ?>">
                     <i class="icon-arrow-right"></i>
                     Alam
                  </a>
               </li>
               <li class="<?php if($link2 == 'budaya'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/destinasi/budaya'); ?>">
                     <i class="icon-arrow-right"></i>
                     Budaya
                  </a>
               </li>
               <li class="<?php if($link2 == 'museum'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/destinasi/museum'); ?>">
                     <i class="icon-arrow-right"></i>
                     Museum
                  </a>
               </li>
               <li class="<?php if($link2 == 'kuliner'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/destinasi/kuliner'); ?>">
                     <i class="icon-arrow-right"></i>
                     Kuliner
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'akomodasi'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-map"></i>
               <span> Akomodasi</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'hotel'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/hotel'); ?>">
                     <i class="icon-arrow-right"></i>
                     Hotel & Penginapan
                  </a>
               </li>
               <li class="<?php if($link2 == 'restoran'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/akomodasi/restoran'); ?>">
                     <i class="icon-arrow-right"></i>
                     Restoran
                  </a>
               </li>
            </ul>
         </li>
         <li class="<?php if($link == 'layanan'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icon-speech"></i>
               <span> Layanan</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li class="<?php if($link2 == 'unduh'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/unduh'); ?>">
                     <i class="icon-arrow-right"></i>
                     Unduh Arsip
                  </a>
               </li>
               <li class="<?php if($link2 == 'request'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/layanan/request'); ?>">
                     <i class="icon-arrow-right"></i>
                     Permintaan Dokumen
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
               <li class="<?php if($link2 == 'struktur'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/struktur'); ?>">
                     <i class="icon-arrow-right"></i>
                     Struktur Organisasi
                  </a>
               </li>
               <li class="<?php if($link2 == 'galeri_dinas'){echo 'active';} ?>">
                  <a class="waves-effect waves-dark" href="<?php echo site_url('admin/tentang/galeri_dinas'); ?>">
                     <i class="icon-arrow-right"></i>
                     Galeri Dinas
                  </a>
               </li>
               <li class="<?php if($link2 == 'profil'){echo 'active';} ?>">
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
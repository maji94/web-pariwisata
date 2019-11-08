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
       ?>

      <!-- Sidebar Menu-->
      <ul class="sidebar-menu">
         <li class="<?php if($link == ''){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin'); ?>">
               <i class="icon-speedometer"></i><span> Dashboard</span>
            </a>
         </li>
         <li class="nav-level">Manajemen Data</li>
         <li class="<?php if($link == 'berita'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/berita'); ?>">
               <i class="icon-list"></i>
               <span> Manajemen Berita</span>
            </a>
         </li>
         <li class="<?php if($link == 'berita'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/berita'); ?>">
               <i class="icon-list"></i>
               <span> Manajemen Berita</span>
            </a>
         </li>
         <li class="<?php if($link == 'berita'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/berita'); ?>">
               <i class="icon-list"></i>
               <span> Manajemen Berita</span>
            </a>
         </li>
         <li class="<?php if($link == 'berita'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/berita'); ?>">
               <i class="icon-list"></i>
               <span> Manajemen Berita</span>
            </a>
         </li>
         <li class="<?php if($link == 'berita'){echo "active";} ?> treeview">
            <a class="waves-effect waves-dark" href="<?php echo site_url('admin/berita'); ?>">
               <i class="icon-list"></i>
               <span> Manajemen Berita</span>
            </a>
         </li>
         <li class="treeview">
            <a class="waves-effect waves-dark" href="#!">
               <i class="icofont icofont-company"></i>
               <span>Menu Level 1</span>
               <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
               <li>
                  <a class="waves-effect waves-dark" href="#!">
                     <i class="icon-arrow-right"></i>
                     Level Two
                  </a>
               </li>
               <li class="treeview">
                  <a class="waves-effect waves-dark" href="#!">
                     <i class="icon-arrow-right"></i>
                     <span>Level Two</span>
                     <i class="icon-arrow-down"></i>
                  </a>
                  <ul class="treeview-menu">
                     <li>
                        <a class="waves-effect waves-dark" href="#!">
                           <i class="icon-arrow-right"></i>
                           Level Three
                        </a>
                     </li>
                     <li>
                        <a class="waves-effect waves-dark" href="#!">
                           <i class="icon-arrow-right"></i>
                           <span>Level Three</span>
                           <i class="icon-arrow-down"></i>
                        </a>
                     </li>
                     <ul class="treeview-menu">
                        <li>
                           <a class="waves-effect waves-dark" href="#!">
                              <i class="icon-arrow-right"></i>
                              Level Four
                           </a>
                        </li>
                        <li>
                           <a class="waves-effect waves-dark" href="#!">
                              <i class="icon-arrow-right"></i>
                              Level Four
                           </a>
                        </li>
                     </ul>
                  </ul>
               </li>
            </ul>
         </li>
      </ul>
   </section>
</aside>
<header class="main-header-top hidden-print">
   <a href="<?php echo site_url('admin'); ?>" class="logo">
      <strong>ADMIN AREA</strong>
      <!-- <img class="img-fluid able-logo" src="<?php echo base_url(); ?>assets/images/logo.png" alt="Theme-logo"> -->
   </a>
   <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
      <!-- Navbar Right Menu-->
      <div class="navbar-custom-menu f-right">

         <ul class="top-nav">
            <!--Notification Menu-->
            <li class="dropdown pc-rheader-submenu message-notification search-toggle">
               <a href="<?php echo site_url(); ?>" target="_blank" title="Halaman Website">
                  <i class="icon-home"></i>
               </a>
            </li>
            <!-- window screen -->
            <li class="pc-rheader-submenu">
               <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                  <i class="icon-size-fullscreen"></i>
               </a>
            </li>
            <!-- User Menu-->
            <li class="dropdown">
               <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                  <span><img class="img-circle " src="<?php echo base_url(); ?>assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                  <span>John <b>Doe</b> <i class=" icofont icofont-simple-down"></i></span>
               </a>
               <ul class="dropdown-menu settings-menu">
                  <li><a href="#"><i class="icon-lock"></i> Ubah Password</a></li>
                  <li><a href="<?php echo site_url('admin/getLogout'); ?>"><i class="icon-logout"></i> Logout</a></li>
               </ul>
            </li>
         </ul>

      </div>
   </nav>
</header>
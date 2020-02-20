<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Wonderful Bengkulu 2020</title>
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Wonderfull Bengkulu 2020. Website Resmi Dinas Pariwisata Provinsi Bengkulu dalam mewujudkan Wonderfull Bengkulu 2020">
		<meta name="author" content="Dinas Pariwisata Bengkulu">
		<meta name="keyword" content="dispar bengkulu, pariwisata bengkulu, wonderfull bengkulu, pantai panjang, tapak paderi bengkulu, benteng">
		
		<!-- Shareable -->
		<meta property="og:title" content="Wonderfull Bengkulu 2020 | Dinas Pariwisata Provinsi Bengkulu" />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?php echo site_url() ?>" />
		<meta property="og:image" content="<?php echo base_url() ?>assets/images/landmark.png" />

		<!-- Favicons -->
	  <link href="<?php echo base_url() ?>assets/images/landmark.png" rel="icon">
	  <link href="<?php echo base_url() ?>assets/images/landmark.png" rel="apple-touch-icon">

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/video.popup.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icofont/icofont.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/instafeed/css/magnific.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/owl-carousel2-2.3.4/dist/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/owl-carousel2-2.3.4/dist/assets/owl.theme.default.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
		
		<!--ShareThis -->
		<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5df84c97076ae6001453b6bf&product=inline-share-buttons&cms=sop' async='async'></script>
		
		<!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-115883445-5"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
        
          gtag('config', 'UA-115883445-5');
        </script>

	</head>
	<body <?php echo $this->session->flashdata('notif'); ?>>

		<?php $this->load->view('home/header'); ?>

		<?php $this->load->view($page); ?>

		<?php $this->load->view('home/footer'); ?>

		<!-- Scripts -->
		<script src="<?php echo base_url(); ?>assets/front/js/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/jquery.scrollex.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/skel.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/util.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/main.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/lightbox-plus-jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/js/video.popup.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/instafeed/js/instafeed.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/instafeed/js/magnific.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/instafeed/js/custom.js"></script>
		<script src="<?php echo base_url(); ?>assets/front/owl-carousel2-2.3.4/dist/owl.carousel.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
		<script>
			$(document).ready( function () {
				$('#table_id').DataTable( {
					responsive: true
				});
			});

			function vcaptcha(){
	      var captcha = '<?php echo $this->session->userdata('keycode') ?>';
	      var valid = $("#captcha").val();
	      if (valid != captcha) {
	        alert('Harap masukkan captcha dengan benar.');
	        $("#captcha").focus();
	        return false;
	      }else{
	        return true;
	      }
	    }

      $(function(){
        $("#video").videoPopup({
				  // autoplay on open
				  autoplay: true,
				  // shows video controls
				  showControls: true,
				  // colors of controls
				  controlsColor: null,
				  // infinite loop
				  loopVideo: false,
				  // shows video information
				  showVideoInformations: true,
				  // width
				  width: null
				});
      });
		</script>
	</body>
</html>

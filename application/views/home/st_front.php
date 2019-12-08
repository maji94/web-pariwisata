<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>Wonderful Bengkulu 2020</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/main.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/video.popup.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/icofont/icofont.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/css/font-awesome.min.css">
	</head>
	<body>

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
		<script>
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

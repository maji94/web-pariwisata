<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">

<head>
   <title>DASHBOARD | <?php echo $title; ?></title>
  <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <!-- Favicon icon -->
  <link rel="shortcut icon" href="<?php echo base_url();?>assets/images/logo-provinsi-bengkulu.png" type="image/x-icon">
  <link rel="icon" href="<?php echo base_url();?>assets/images/logo-provinsi-bengkulu.ico" type="image/x-icon">

  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

  <!-- iconfont -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/icofont/css/icofont.css">

  <!-- simple line icon -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/icon/simple-line-icons/css/simple-line-icons.css">

  <!-- Required Fremwork -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">

  <!-- Weather css -->
  <!-- <link href="<?php// echo base_url(); ?>assets/css/svg-weather.css" rel="stylesheet"> -->

  <!-- Echart js -->
  <!-- <script src="<?php// echo base_url(); ?>assets/plugins/charts/echarts/js/echarts-all.js"></script> -->

  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">

  <!-- Responsive.css-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.css">

  <!--color css-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/color/color-1.min.css" id="color"/>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/summernote/summernote-bs4.css';?>">

</head>

<body class="sidebar-mini fixed" <?php echo $this->session->flashdata('notif'); ?>>
   <div class="loader-bg">
      <div class="loader-bar"></div>
   </div>

   <div class="wrapper">
      <!-- Navbar-->
      <?php $this->load->view('admin/a_header'); ?>

      <!-- Side-Nav-->
      <?php $this->load->view('admin/a_sidebar'); ?>

      <?php $this->load->view($page); ?>
   </div>

   <!-- Required Jqurey -->
   <script src="<?php echo base_url(); ?>assets/plugins/jquery/dist/jquery.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/tether/dist/js/tether.min.js"></script>

   <!-- Required Fremwork -->
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- waves effects.js -->
   <script src="<?php echo base_url(); ?>assets/plugins/Waves/waves.min.js"></script>

   <!-- Scrollbar JS-->
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

   <!--classic JS-->
   <script src="<?php echo base_url(); ?>assets/plugins/classie/classie.js"></script>

   <!-- notification -->
   <script src="<?php echo base_url(); ?>assets/plugins/notification/js/bootstrap-growl.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/pages/notification.js"></script>

   <!-- Rickshaw Chart js -->
   <!-- <script src="<?php// echo base_url(); ?>assets/plugins/d3/d3.js"></script> -->
   <!-- <script src="<?php// echo base_url(); ?>assets/plugins/rickshaw/rickshaw.js"></script> -->

   <!-- Sparkline charts -->
   <!-- <script src="<?php// echo base_url(); ?>assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script> -->

   <!-- Counter js  -->
   <script src="<?php echo base_url(); ?>assets/plugins/waypoints/jquery.waypoints.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/countdown/js/jquery.counterup.js"></script>

   <!-- custom js -->
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.min.js"></script>
   <!-- <script type="text/javascript" src="<?php// echo base_url(); ?>assets/pages/dashboard.js"></script> -->
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/pages/elements.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/menu.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

   <!-- panggil summernote -->
   <script type="text/javascript" src="<?php echo base_url().'assets/summernote/summernote-bs4.js';?>"></script>
      
   <script type="text/javascript">

    
    $(document).ready(function() {
      var table = $('#example').DataTable();
      
      $('#isi').summernote({
        toolbar: [
          // [groupName, [list of button]]
          ['misc', ['undo', 'redo', 'fullscreen','codeview']],
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['color', ['color']],
          ['height', ['height']],
          ['fontsize', ['fontsize','fontname']],
          ['insert', ['picture', 'link', 'table', 'hr']],
        ],
        placeholder: 'Your text here ..',
        tabsize: 2,
        minHeight: 200,
        callbacks: {
          onImageUpload : function(image) {
            uploadImage(image[0]);
          },
          onMediaDelete : function(target) {
            deleteImage(target[0].src);
          }
        }
      });

      function uploadImage(image) {
        var data = new FormData();
        data.append("image", image);
        $.ajax({
          url: "<?php echo site_url('admin/upload_image')?>",
          cache: false,
          contentType: false,
          processData: false,
          data: data,
          type: "POST",
          success: function(url) {
            $('#isi').summernote("insertImage", url);
          },
          error: function(data) {
            console.log(data);
          }
        });
      }

      function deleteImage(src) {
        $.ajax({
          data: {src : src},
          type: "POST",
          url: "<?php echo site_url('admin/delete_image')?>",
          cache: false,
          success: function(response) {
            console.log(response);
          }
        });
      }
    });

    function hapus(id){
      $(id).remove();
    }

    function PreviewImage(upload,uploadPreview) {
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById(upload).files[0]);

      oFReader.onload = function (oFREvent) {
        document.getElementById(uploadPreview).src = oFREvent.target.result;
      }
    }

    <?php if ($this->uri->segment(3) == "add") { ?>
      var i = 1;
    <?php }else if ($this->uri->segment(3) == "edit") { ?>
      var i = parseInt($("#n_edit").val());
      if (i == 0) {
        i = 1;
      }
    <?php } ?>

    function additem() {
      //                menentukan target append
        var itemlist = document.getElementById('itemlist');
        
      //                membuat element
        var col = document.createElement('div');
        col.setAttribute('class', 'col-md-4 col-xs-12');
        col.style = "margin-bottom:5px";

      //                meng append element
        itemlist.appendChild(col);

      //                membuat element input
        var jenis_input = document.createElement('input');
        jenis_input.setAttribute('class', 'form-control');
        jenis_input.setAttribute('type', 'file');
        jenis_input.setAttribute('name', 'foto[]');
        jenis_input.setAttribute('id', 'foto[' + i + ']');
        jenis_input.setAttribute('onchange', 'PreviewImage("foto['+i+']","prevFoto['+i+']");');

        var preview = document.createElement('img');
        preview.setAttribute('id', 'prevFoto[' + i + ']');
        preview.setAttribute('class', 'form-control');
        preview.setAttribute('alt', 'Foto Galeri');
        preview.style = "width : 100%; height : 200px;";

        var hapus = document.createElement('span');

      //                meng append element input
        col.appendChild(jenis_input);
        col.appendChild(preview);
        col.appendChild(hapus);

        hapus.innerHTML = '<button class="btn btn-danger btn-mini" type="button" style="margin-top:5px;"><i class="icofont icofont-close"></i> Hapus</button><br>';
      //                membuat aksi delete element
        hapus.onclick = function () {
            col.parentNode.removeChild(col);
        };

        i++;
    }

    $('#edit_banner').on('show.bs.modal', function (event){
      var div = $(event.relatedTarget)
      var id = div.data('id')
      var edit_oleh = div.data('oleh')
      var oldFoto = div.data('foto')
      var modal = $(this)

      modal.find('#oldFoto').attr("value",oldFoto)
      modal.find('#edit_oleh').attr("value",edit_oleh)
      modal.find('#id').attr("value",id)
      
    });
   </script>

</body>

</html>

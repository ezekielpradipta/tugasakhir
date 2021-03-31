<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>TEST</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
    
  <!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
<body class="hold-transition layout-top-nav">
  <input type="hidden" name="mahasiswa_id" id="mahasiswa_id" value="{{ Auth::user()->mahasiswa->id }}">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <input type="hidden" id="tak_score">
    <div class="container">
      <a href="../../index3.html" class="navbar-brand">
        <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Test</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
  

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
       
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown dropdown-notif">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i data-count="0" class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge notif-count">0</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            
            <a href="" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<div class="modal hide fade" id="modal-sukses">
	<div class="modal-dialog text-center">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
        <input type="hidden" id="notif_val">
        <img src="https://i.pinimg.com/originals/c1/1d/05/c11d05415f5ff082abf5155fa6d98e1f.gif" style="width: 70%">
				<h4>SELAMAT!</h4>
        <p id="notif_text"></p>
        <button type="button" class="btn btn-primary" value="tambah" id="btn-read">Lanjutkan</button>    
			</div>
		</div>
	</div>
</div>
<!-- REQUIRED SCRIPTS -->


<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('adminlte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('adminlte/dist/js/demo.js')}}"></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
@include('sweet::alert') 
<script type="text/javascript">
  $(document).ready(function(){
    var notif = $('.dropdown-notif');
   var notif_Toggle =notif.find('a[data-toggle]');
   var notif_Count_Element = notif_Toggle.find('i[data-count]');
   var notificationsCount = parseInt(notif_Count_Element.data('count'));
   var notifications = notif.find('div.dropdown-menu');

   var pusher = new Pusher('9b0938eee923c6556e88', {
        cluster: 'ap1',
        encrypted: true
      });
      var channel = pusher.subscribe('takkonfirmasi'+$('#mahasiswa_id').val());
      channel.bind('App\\Events\\TakKonfirmasi', function(data) {
        var existingNotifications = notifications.html();
        var newNotificationHtml =  '<a href="javascript:void(0)" data-id="'+data.notif_id+'" class="dropdown-item btn-modal">' +
                  '<div class="media">' +
                  '<img src="../../img/'+data.dosen_image+'" alt="User Avatar" class="img-size-50 mr-3 img-circle">' +
                  '<div class="media-body">' +
                  '<h3 class="dropdown-item-title">'+ data.dosen_nama +
                  '<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>'+
                  '</h3>' +
                  '<p class="text-sm">Telah MengACC TAK</p>' +
                  '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Just Now</p>'+
                  '</div>' +
                  '</div>' +
                  '</a>' +
                  '<div class="dropdown-divider"></div>';
                  $('div.dropdown-menu').append(newNotificationHtml);
        
                  notificationsCount += 1;
                  notif_Count_Element.attr('data-count', notificationsCount);
                  notif.find('.notif-count').text(notificationsCount);
                  notif.show();
      });
   notif.ready(function(){
    var urlcoba = "{{route('mahasiswa.daftartak.index')}}";
        $.ajax({
                url: "{{ route('mahasiswa.notif') }}",
                type: "GET",
                dataType : "json",            
                success: function (data) {

                console.log(data);
                $('#tak_score').val(data.score);
                notif_Count_Element.attr('data-count', data.jumlah);
                notif.find('.notif-count').text(data.jumlah);
                for (var i = 0; i < data.jumlah; i++) {
                  var newNotificationHtml =  '<a href="javascript:void(0)" data-id="'+data.notif[i].id+'" class="dropdown-item btn-modal">' +
                  '<div class="media">' +
                  '<img src="../../img/'+data.notif[i].dosen_image+'" alt="User Avatar" class="img-size-50 mr-3 img-circle">' +
                  '<div class="media-body">' +
                  '<h3 class="dropdown-item-title">'+ data.notif[i].dosen_nama +
                  '<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>'+
                  '</h3>' +
                  '<p class="text-sm">Telah MengACC TAK</p>' +
                  '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '+  data.notif[i].updated_at +'</p>'+
                  '</div>' +
                  '</div>' +
                  '</a>' +
                  '<div class="dropdown-divider"></div>';
                  $('div.dropdown-menu').append(newNotificationHtml);
                  }
                }
              });
      });
      $('body').on('click','.btn-modal',function(){
        var notif_id = $(this).data('id');
        $('#notif_val').val(notif_id);
        var url = "{{route('mahasiswa.notif')}}".concat("/" + notif_id +"/detail");
        console.log(url);
             $.ajax({
                      url: url,
                      type: 'GET',
                      dataType : "json",
                      success: function(data){
                        console.log(data);
                        $('#modal-sukses').modal('show');
                        var text = 'TAK '+data.kegiatantak+' ('+data.partisipasitak+ ') '+
                        ' Berhasil Terkonfirmasi, Mendapatkan ' +data.skor+ ' Point' ;
                        $('#notif_text').html(text);
                      }
                    });
        
      });
      $('body').on('click','#btn-read',function(){
        var notif_id =  $('#notif_val').val();
        var url = "{{route('mahasiswa.notif')}}".concat("/" + notif_id +"/read");
        console.log(url);
                 $.ajax({
                      url: url,
                      type: 'GET',
                      dataType : "json",
                      success: function(data){
                        $('#modal-sukses').modal('hide');
                        location.reload();
                      }
                    });
      });




  });
  </script> 
</body>
</html>
@stack('scripts')
@stack('scripts2')

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard| Aplikasi TAK </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css')}}">
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <input type="hidden" name="dosen_id" id="dosen_id" value="{{ Auth::user()->dosen->id }}">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          <a href="javascript:void(0)" class="btn btn-danger" id="btn-coba">test</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown dropdown-notif">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i data-count="0" class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge notif-count">0</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <a href="{{route('dosen.takmasuk.index')}}" class="dropdown-item dropdown-footer">See All
              Messages</a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{Auth ::user()->dosen->image_url}}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->dosen->dosen_nama }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{route('dosen.dashboard.index')}}" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-header">DATA-DATA</li>
            @if(Auth::user()->dosen->dosen_status=='dosenwali')
            <li class="nav-item">
              <a href="{{route('dosen.daftarmahasiswa.index')}}" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Daftar Mahasiswa
                </p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="{{route('dosen.takmasuk.index')}}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Daftar TAK
                </p>
              </a>
            </li>
            @if(Auth::user()->dosen->dosen_status=='kemahasiswaan')
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>
                  Validasi TAK
                </p>
              </a>
            </li>
            @endif
            <li class="nav-item">
              <a href="{{ route('dosen.profile.index') }}" class="nav-link">
                <i class="nav-icon fas fa-wrench"></i>
                <p>
                  Ubah Pengguna
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('logout')}}" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  LogOut
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.0.4
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>

  <!-- JQVMap -->
  <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
  <!-- daterangepicker -->
  <script src="{{ asset('adminlte/plugins/moment/moment.min.js')}}"></script>
  <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>

  <!-- overlayScrollbars -->
  <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

  <!-- AdminLTE for demo purposes -->
  <script src="{{ asset('adminlte/dist/js/demo.js')}}"></script>
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script src="https://cdn.datatables.net/plug-ins/1.10.22/dataRender/ellipsis.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  @include('sweet::alert')
  <script type="text/javascript">
    $(document).ready(function () {
            var notif = $('.dropdown-notif');
            var notif_Toggle = notif.find('a[data-toggle]');
            var notif_Count_Element = notif_Toggle.find('i[data-count]');
            var notificationsCount = parseInt(notif_Count_Element.data('count'));
            var notifications = notif.find('div.dropdown-menu');

            var pusher = new Pusher('9b0938eee923c6556e88', {
                cluster: 'ap1',
                encrypted: true
            });

            // Subscribe to the channel we specified in our Laravel Event
            var channel = pusher.subscribe('takmasuk' + $('#dosen_id').val());
            channel.bind('App\\Events\\TakMasuk', function (data) {
                var existingNotifications = notifications.html();
                var url = "{{route('dosen.takmasuk.index')}}";
                var newNotificationHtml = `
                <a href="` + url + `" class="dropdown-item">
                      <!-- Message Start -->
                      <div class="media">
                        <img src="../../img/` + data.mahasiswa_image + `" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                          <h3 class="dropdown-item-title">
                            ` + data.user + `
                            <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                          </h3>
                          <p class="text-sm">Telah Mengupload TAK</p>
                          <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> Just Now</p>
                        </div>
                      </div>
                      <!-- Message End -->
                    </a>
                    <div class="dropdown-divider"></div>
                `;
                $('div.dropdown-menu').append(newNotificationHtml);

                notificationsCount += 1;
                notif_Count_Element.attr('data-count', notificationsCount);
                notif.find('.notif-count').text(notificationsCount);
                notif.show();
            });
            
            notif.ready(function () {
                var urlcoba = "{{route('dosen.takmasuk.index')}}";
                $.ajax({
                    url: "{{ route('dosen.notif') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);

                        notif_Count_Element.attr('data-count', data.jumlah);
                        notif.find('.notif-count').text(data.jumlah);
                        for (var i = 0; i < data.jumlah; i++) {
                            if (data.inputtak[i].updated_at == data.inputtak[i]
                                .created_at) {
                                var compare = 'Mengupload';
                            } else {
                                var compare = 'Mengupdate';
                            }
                            var newNotificationHtml = '<a href="' + urlcoba +
                                ' " class="dropdown-item">' +
                                '<div class="media">' +
                                '<img src="../../img/' + data.inputtak[i].mahasiswa_image +
                                '" alt="User Avatar" class="img-size-50 mr-3 img-circle">' +
                                '<div class="media-body">' +
                                '<h3 class="dropdown-item-title">' + data.inputtak[i]
                                .mahasiswa_nama +
                                '<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>' +
                                '</h3>' +
                                '<p class="text-sm">Telah ' + compare + ' TAK</p>' +
                                '<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> ' +
                                data.inputtak[i].updated_at + '</p>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '<div class="dropdown-divider"></div>';
                            $('div.dropdown-menu').append(newNotificationHtml);
                        }
                    }
                });
            });
        });

  </script>
</body>

</html>
@stack('scripts')
@stack('scripts2')
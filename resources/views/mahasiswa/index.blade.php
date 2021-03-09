@extends('layouts.mahasiswa')
@section('content')
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('mahasiswa.index')}} ">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-primary card-outline">
            <div class="card-header">
            <div class="row">
                <div class="col-sm-10">
                    <h5 class="card-title m-0"> {{ Auth::user()->mahasiswa->nama }}</h5>
                </div>
                <div class="col-sm-2">
                <h5 class="card-title m-0">Total TAK : </h5>
                </div>
            </div>
            </div>
            <div class="col text-center">
              <div class="card-body">
                <a href="{{ route('mahasiswa.inputtak.index') }} " class="btn-primary btn-lg" style="width: 200px; display:inline-block;">Input TAK</a>
              </div>
              <div class="card-body">
                <a href="{{ route('mahasiswa.daftartak.index') }}" class="btn-primary btn-lg" style="width: 200px; display:inline-block;">Daftar  TAK</a>
              </div>
              <div class="card-body">
                <a class="btn-primary btn-lg" style="width: 200px; display:inline-block;">Leaderboard</a>
              </div>
              <div class="card-body">
              <a class="btn-primary btn-lg" style="width: 200px; display:inline-block;" data-toggle="modal" href="#myModal" >Launch Modal</a>
              </div>
              <div class="card-body">
                <a href="{{ route('logout') }}" class="btn-primary btn-lg" style="width: 200px; display:inline-block;">Keluar</a>
              </div>
            </div>
            </div><!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Selamat Datang di Aplikasi TAK</h5>
          </div>
          <div class="modal-body">
            <div id="slidehome" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{asset('/img')}}/contoh.png" class="modal-content" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('/img')}}/contoh2.png" class="modal-content" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('/img')}}/contoh3.png" class="modal-content" alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" style="filter:invert(100%);" href="#slidehome" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </a>
              <a class="carousel-control-next" style="filter: invert(100%);" href="#slidehome" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </a>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Jangan Tampilkan Lagi</button>
            
          </div>
        </div>
      </div>
    </div>
    @endsection
    @push('scripts')
    <script type="text/javascript">
      
    var modal = document.getElementById("myModal");
    if (document.cookie.indexOf("visited=") >= 0) {
      modal.style.display = "none";
    } else {
      $(window).on('load',function(){
        $('#myModal').modal('show');
    });
      expiry = new Date();
          // expiry.setTime(expiry.getTime()+(1440*60*1000)); // 1440 minutes atau 1 day
          expiry.setTime(expiry.getTime()+(60*60*1000)); // 60 minutes atau 1 hour
      document.cookie = "visited=yes; expires=" + expiry.toGMTString();	
    }
  </script>

    @endpush
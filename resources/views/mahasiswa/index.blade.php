@extends('layouts.mahasiswa')
@section('content')
<style>
  .notif-badge {
    position: relative;
    width: 50px;
    top: -0.5rem;
    left: 1.5rem;

  }

  .next-badge {
    position: relative;
    width: 50px;
    top: -0.6rem;
    left: -0.5rem;

  }
</style>
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
    <div class="row ">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div>
              <img src="" class="notif-badge" alt="">
              <img class="profile-user-img img-fluid img-circle"
                src="../../img/{{ Auth::user()->mahasiswa->mahasiswa_image }}" alt="User profile picture">
            </div>

            <h3 class="profile-username text-center">{{ Auth::user()->mahasiswa->mahasiswa_nama }}</h3>
            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Total TAK</b> <a class="float-right score"></a>
              </li>
            </ul>
            <div class="row" style="margin-bottom: 10px">
              <div class="col-sm-10">
                <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p class="text-muted text-center selesai"> <span class="next_badge_point"></span> Poin Menuju <span
                    class="next_badge_nama"></span>
                </p>
              </div>
              <div class="col-sm-2">
                <img src="" class="next-badge" alt="">
              </div>
            </div>


            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-9">
        <div class="card card-primary card-outline">
          <div class="card-header">


          </div>
          <div class="col text-center">

            @if(Auth::user()->mahasiswa->mahasiswa_tutorial_status=='0')
            <div class="card-body">
              <a href="{{ route('mahasiswa.tutorial.index') }} " id="tutorial" class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Tutorial</a>
            </div>
            <div class="card-body">
              <a href="{{ route('logout') }}" class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Keluar</a>
            </div>
            @else
            <div class="card-body">
              <a href="{{ route('mahasiswa.inputtak.index') }} " class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Input TAK</a>
            </div>
            <div class="card-body">
              <a href="{{ route('mahasiswa.daftartak.index') }}" class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Daftar TAK</a>
            </div>
            <div class="card-body" id="validasi" style="display: none">
              <a href="{{ route('mahasiswa.validasi.index') }}" class="btn-primary  btn-lg"
                style="width: 200px; display:inline-block;">TEST</a>
            </div>
            <div class="card-body">
              <a href="{{ route('mahasiswa.leaderboard.index') }}" class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Leaderboard</a>
            </div>
            <div class="card-body">
              <a class="btn-primary btn-lg" style="width: 200px; display:inline-block;" data-toggle="modal"
                href="#myModal">Launch Modal</a>
            </div>
            <div class="card-body">
              <a href="{{ route('logout') }}" class="btn-primary btn-lg"
                style="width: 200px; display:inline-block;">Keluar</a>
            </div>
            @endif
          </div>
        </div><!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<div class="modal fade bd-example-modal-xl" id="myModal" tabindex="-1" role="dialog"
  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
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
          <a class="carousel-control-prev" style="filter:invert(100%);" href="#slidehome" role="button"
            data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          </a>
          <a class="carousel-control-next" style="filter: invert(100%);" href="#slidehome" role="button"
            data-slide="next">
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
<div class="modal fade bd-example-modal-sm" id="modal_tutorial" tabindex="-1" role="dialog"
  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Selamat Datang Pengguna Baru</h5>
      </div>
      <div class="modal-body">
        <P>Silahkan Ikuti Tutorial Untuk Menginputkan TAK</P>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Lanjutkan</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bd-example-modal-lg" id="modal_tutorial_selesai" tabindex="-1" role="dialog"
  aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
      </div>
      <div class="modal-body">
        <img class="d-block w-100" src="{{asset('/img')}}/notif.png" class="modal-content" alt="First slide">
        <P>Setelah selesai menginputkan TAK, langkah selanjutnya menunggu konfirmasi oleh Dosen Wali /
          Kemahasiswaan.
          <br>
          Apabila telah terkonfirmasi maka Notifikasi akan muncul.
        </P>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  $(document).ready(function () {
        $.ajax({
            url: "{{ route('mahasiswa.daftarmenu') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {

                console.log(data);
                if (data.validasi == "yes") {
                    $("#validasi").show();
                }

                if (data.tutorial_status == "1") {
                    var modal = document.getElementById("myModal");
                    if (document.cookie.indexOf("visited=") >= 0) {
                        modal.style.display = "none";
                    } else {

                        $('#myModal').modal('show');

                        expiry = new Date();
                        // expiry.setTime(expiry.getTime()+(1440*60*1000)); // 1440 minutes atau 1 day
                        expiry.setTime(expiry.getTime() + (60 * 60 *
                            1000)); // 60 minutes atau 1 hour
                        document.cookie = "visited=yes; expires=" + expiry.toGMTString();
                    }
                } else {
                    if (data.tutorial == "yes") {
                        $('#modal_tutorial').modal('hide');
                        $('#modal_tutorial_selesai').modal('show');
                        $('#tutorial').replaceWith(
                            '<button class="btn btn-primary btn-lg" style="width:200px;" disabled>Tutorial</button'
                        );

                    } else {
                        $('#modal_tutorial').modal('show');
                    }

                }


            }
        });
        

    });

</script>

@endpush
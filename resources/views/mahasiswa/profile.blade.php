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
                    <li class="breadcrumb-item active">Tutorial</li>
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
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <h5 class="card-title m-0">Ubah Pengguna</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <form method="post" id="form" name="form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="hidden_image" id="hidden_image">
                                <div class="card-body">
                                    <div id="error" style=" display:none; ">
                                        <div class="alert alert-danger ">
                                            <strong>Whoops!</strong> Data yang anda masukan tidak sesuai.<br><br>
                                            <ul class="list_error">

                                            </ul>
                                        </div>
                                    </div>
                                    <div>
                                        <form class="form-horizontal">
                                            <div class="box-profile">
                                                <div class="text-center" style="margin-bottom: 20px">
                                                    <img class="img-fluid" id="gambar" src="" style="width: 200px"
                                                        alt="User profile picture">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <p id="email"></p>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-2 col-form-label">Username</label>
                                                <div class="col-sm-10">
                                                    <span class="text-danger">Lewati jika tidak ingin mengganti
                                                        username</span>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username">
                                                    <label id="user_ok" class=" text-success "
                                                        style="display:none;">Username Tersedia</label>
                                                    <label id="user_used" class="text-danger"
                                                        style="display:none;">Username Sudah Digunakan</label>

                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">NIM</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="mahasiswa_nim"
                                                        name="mahasiswa_nim" minlength="8" maxlength="8">
                                                    <label id="nidn_ok" class=" text-success " style="display:none;">NIM
                                                        Tersedia</label>
                                                    <label id="nidn_used" class="text-danger" style="display:none;">NIDN
                                                        Sudah Digunakan</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName2" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="mahasiswa_nama"
                                                        name="mahasiswa_nama">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills"
                                                    class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password" class="form-control"
                                                        id="password">
                                                    <label class="text-danger" id="password_error"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="gridCheck"> Show Password
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Konfirmasi
                                                    Password</label>
                                                <div class="col-sm-10">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control" id="password_confirmation"
                                                        placeholder="Konfirmasi Password" autocomplete="new-password">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputSkills" class="col-sm-2 col-form-label">Upload
                                                    Foto</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="mahasiswa_image" class="form-control"
                                                        id="mahasiswa_image">
                                                </div>
                                            </div>
                                            <div class=" text-center">
                                                <button type="button" id="btn-save"
                                                    class=" btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#gridCheck').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
		    });
        $.ajax({
                url: "{{ route('mahasiswa.profile.data') }}",
                type: "GET",
                dataType : "json",            
                success: function (data) {
                  console.log(data);
                  $("#email").html(data.user.email);
                  $("#username").val(data.user.username);
                  $("#mahasiswa_nama").val(data.mahasiswa.mahasiswa_nama);
                  $("#mahasiswa_nim").val(data.mahasiswa.mahasiswa_nim);
                  $("#password").val(data.user.password_text);
                  $("#hidden_image").val(data.mahasiswa.mahasiswa_image);
                  $("#gambar").attr('src', '../' + '../' + 'img/' + data.mahasiswa.mahasiswa_image );
                  $("#error").hide();
                }
        });
        $('#btn-save').click(function (e) {
            e.preventDefault();
            var myForm = $("#form")[0];
            $(this).html('Sending..');
            $.ajax({
                data: new FormData(myForm),
                url: "{{ route('mahasiswa.profile.store') }}",
                type: "POST",

                contentType: false,
                processData: false,
                success: function (data) {
                    Command: swal("Sukses", "Berhasil ", "success");
                    $('#formProfile').trigger("reset");
                    location.reload();
                },
                error: function (data) {
                    $("#error").show();
                    var error_password = data.responseJSON.errors.password;
                    var nidn = data.responseJSON.errors.mahasiswa_nim;
                    var error_nama = data.responseJSON.errors.mahasiswa_nama;
                    if (error_password) {
                        for (var i = 0; i < error_password.length; i++) {
                            var obj = '<li>' + error_password[i] + '</li>';
                            $('.list_error').append(obj);
                        }
                    }
                    if (error_nama) {
                        for (var k = 0; k < error_nama.length; k++) {
                            var obj2 = '<li>' + error_nama[k] + '</li>';
                            $('.list_error').append(obj2);
                        }
                    }
                    if (nidn) {
                        for (var k = 0; k < nidn.length; k++) {
                            var obj2 = '<li>' + nidn[k] + '</li>';
                            $('.list_error').append(obj2);
                        }
                    }
                    Command: swal("Gagal", "Gagal", "error");
                    $('#btn-save').html('Save Changes');
                }
            });
        });
        $('#username').blur(function () {
            var error_uname = '';
            var username = $('#username').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('cekUsername') }}",
                method: "POST",
                data: {
                    username: username,
                    _token: _token
                },
                success: function (result) {
                    if (result == 'unique') {
                        $('#user_ok').show();
                        $('#user_used').hide();

                        $('#btn-save').attr('disabled', false);
                    } else {
                        $('#user_ok').hide();
                        $('#user_used').show();
                        $('#btn-save').attr('disabled', 'disabled');

                    }
                }
            })
        });
        $('#mahasiswa_nim').blur(function () {
            var error_uname = '';
            var nim = $('#mahasiswa_nim').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('cekNim') }}",
                method: "POST",
                data: {
                    nim: nim,
                    _token: _token
                },
                success: function (result) {
                    if (result == 'unique') {
                        $('#nidn_ok').show();
                        $('#nidn_used').hide();

                        $('#btn-save').attr('disabled', false);
                    } else {
                        $('#nidn_ok').hide();
                        $('#nidn_used').show();
                        $('#btn-save').attr('disabled', 'disabled');

                    }
                }
            })
        });
    });

</script>

@endpush
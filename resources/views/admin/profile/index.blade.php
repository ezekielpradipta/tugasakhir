@php
$judul ='Admin'
@endphp
@extends('layouts.admin')
@section('content')
@include('admin.header',[$judul=>'judul'])
<section class="content">
  @include('admin.alert')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit {{$judul}}</h3>
    </div>

    <form method="post" id="formProfile" enctype="multipart/form-data">
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
        <div class="form-group">
          <div class="col-sm-6">
            <label for="">Email</label>
            <span class="text-danger">Lewati jika tidak ingin mengganti email</span>
            <input type="email" name="email" class="form-control" id="email">
            <label id="cekemail" class="text-danger" style="display:none;">Bukan Email Institusi</label>
            <label id="email_ok" class=" text-success " style="display:none;">Email Tersedia</label>
            <label id="email_used" class="text-danger" style="display:none;">Email Sudah Digunakan</label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="">Username</label>
            <span class="text-danger">Lewati jika tidak ingin mengganti username</span>
            <input type="text" name="username" class="form-control" id="username">
            <label id="user_ok" class=" text-success " style="display:none;">Username Tersedia</label>
            <label id="user_used" class="text-danger" style="display:none;">Username Sudah Digunakan</label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="">Nama</label>
            <input type="text" name="admin_nama" class="form-control" id="admin_nama">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="inputPassword">Password</label>
            <input type="password" name="password" class="form-control" id="password">
            <label class="text-danger" id="password_error"></label>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck">
              <label class="form-check-label" for="gridCheck">
                Show Password
              </label>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="inputKonfirmasiPassword">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
              placeholder="Konfirmasi Password" autocomplete="new-password">

          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="" id="foto">Upload Foto</label>
            <img src="" class="gambar" id="gambar" width="60px" height="">
            <input type="file" name="admin_image" class="form-control" id="admin_image">
          </div>
        </div>
      </div>
      <div class="card-footer">

        <button type="button" class="btn btn-primary" value="tambah" id="btn-save">Save data</button>
      </div>
    </form>
  </div>
</section>
@endsection
@push('scripts')
<script>
  $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('admin.profile.data') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                $("#email").val(data.user.email);
                $("#username").val(data.user.username);
                $("#admin_nama").val(data.admin.admin_nama);
                $("#password").val(data.user.password_text);
                $("#hidden_image").val(data.admin.admin_image);
                $("#error").hide();
            }
        });
        $('#btn-save').click(function (e) {
            e.preventDefault();
            var myForm = $("#formProfile")[0];
            $(this).html('Sending..');
            $.ajax({
                data: new FormData(myForm),
                url: "{{ route('admin.profile.store') }}",
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
                    if (error_password) {
                        for (var i = 0; i < error_password.length; i++) {
                            var obj = '<li>' + error_password[i] + '</li>';
                            $('.list_error').append(obj);
                        }
                    }

                    Command: swal("Gagal", "Gagal", "error");
                    $('#btn-save').html('Save Changes');
                }
            });
        });
        $('#gridCheck').click(function () {
            if ($(this).is(':checked')) {
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
            }
        });
        $('#email').blur(function () {
            var error_email = '';
            var email = $('#email').val();
            var _token = $('input[name="_token"]').val();
            var filter = /^([a-zA-Z0-9_\.\-])+\@(st3telkom\.ac\.id|ittelkom-pwt\.ac\.id)+$/;
            if (!filter.test(email)) {
                $('#cekemail').show();
                $('#email_ok').hide();
                $('#email_used').hide();
                $('#btn-save').attr('disabled', 'disabled');
            } else {
                $.ajax({
                    url: "{{ route('admin.dosen.cekEmail') }}",
                    method: "POST",
                    data: {
                        email: email,
                        _token: _token
                    },
                    success: function (result) {
                        if (result == 'unique') {
                            $('#cekemail').hide();
                            $('#email_ok').show();
                            $('#email_used').hide();
                            $('#btn-save').attr('disabled', false);

                        } else {
                            $('#cekemail').hide();
                            $('#email_ok').hide();
                            $('#email_used').show();
                            $('#btn-save').attr('disabled', 'disabled');

                        }
                    }
                })
            }
        });

        $('#username').blur(function () {
            var error_uname = '';
            var username = $('#username').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('admin.dosen.cekUsername') }}",
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
    });

</script>
@endpush
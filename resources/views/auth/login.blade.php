@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card-body">
                            <h5 class="card-title">SELAMAT DATANG</h5>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="card-body">
                            @if (session('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>
                            @endif
                            @if(session('success'))
                            <div class="alert alert-success">
                                {!! session('success') !!}
                            </div>
                            @endif
                            @if(session('fail'))
                            <div class="alert alert-danger">
                                {!! session('fail') !!}
                            </div>
                            @endif

                            <nav class="mb-5">
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="login-form-link">Masuk</a>
                                </div>
                            </nav>
                            <form id="login-form" style="display: block;" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="username"
                                        class="col-md-4 col-form-label text-md-right">Username/Email</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Masuk') }}
                                        </button>


                                        <a class="btn btn-link" href="javascript:void(0)" id="tambah"
                                            data-toggle="modal">
                                            Belum Punya Akun?
                                        </a>

                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="card-footer bg-info text-white">
                    <small>Copyright &copy; 2020. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-mahasiswa" name="form-mahasiswa" enctype="multipart/form-data">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">
                    <input type="hidden" name="user_id" id="user_id">
                    <div id="error" style=" display:none; ">
                        <div class="alert alert-danger ">
                            <strong>Whoops!</strong> Data yang anda masukan tidak sesuai.<br><br>
                            <ul class="list_error">

                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputemail">Email</label>
                        <input type="email" name="email_register" class="form-control" id="email_register"
                            placeholder="Email">
                        <label id="cekemail" class="text-danger" style="display: none;">Bukan Email Institusi</label>
                        <label id="email_ok" class=" text-success " style="display:none;">Email Tersedia</label>
                        <label id="email_used" class="text-danger" style="display:none;">Email Sudah Digunakan</label>
                    </div>
                    <div class="form-group">
                        <label for="inputUsername">Username</label>
                        <input type="text" name="username_register" class="form-control" id="username_register"
                            placeholder="Username">
                        <label id="user_ok" class=" text-success " style="display:none;">Username Tersedia</label>
                        <label id="user_used" class="text-danger" style="display:none;">Username Sudah Digunakan</label>
                    </div>
                    <div class="form-group">
                        <label for="inputNamaDosen">Nama</label>
                        <input type="text" name="mahasiswa_nama" class="form-control" id="mahasiswa_nama"
                            placeholder="Nama">
                        <label class="text-danger" id="nama_error"></label>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" name="password_register" class="form-control" id="password_register">
                        <label class="text-danger" id="password_error"></label>
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Show Password
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputKonfirmasiPassword">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            id="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password">
                    </div>
                    <div class="form-group">
                        <label for="">Dosen</label>
                        <select name="dosen_id" id="dosen_id" style="width: 100%;" class="form-control" required>
                            <option value="">- Pilih Dosen -</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Prodi</label>
                        <select name="prodi_id" id="prodi_id" style="width: 100%;" class="form-control" required>
                            <option value="">- Pilih Prodi -</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Angkatan</label>
                        <select name="angkatan_id" id="angkatan_id" style="width: 100%;" class="form-control" required>
                            <option value="">- Pilih Angkatan -</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="inputImageDosen" id="fotoMahasiswa">Upload Foto Mahasiswa</label>
                        <img src="" class="gambar" id="gambar" width="60px" height="">
                        <label class="text-danger" id="mahasiswa_image_error"></label>
                        <input type="file" name="mahasiswa_image" class="form-control" id="mahasiswa_image">

                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" value="tambah" id="btn-save">Save data</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $('#password_confirmation').keyup(validate);

            $('#tambah').click(function () {
                $('#btn-save').val("tambah-data-dosen");
                $('#user_id').val('');
                $('#mahasiswa_id').val('');
                $('#form-mahasiswa').trigger("reset");
                $('.modal-title').html("Tambah Data Mahasiswa");
                $('#btn-save').show();
                $('.gambar').removeAttr('src');
                $('#cekemail').hide();
                $('#email_ok').hide();
                $('#email_used').hide();
                $('#user_ok').hide();
                $('#user_used').hide();
                $("#error").hide();
                $('#modaltambah').modal('show');
            });
            function validate(){
                var pass1 = $("#password_register").val();
                var pass2 = $("#password_confirmation").val();

                if(pass1 == pass2){
                    $('#btn-save').attr('disabled', false);
                } else {
                    $('#btn-save').attr('disabled', 'disabled');   
                }
            }
            $('#email_register').blur(function(){
               
                var email = $('#email_register').val();
                var _token = $('input[name="_token"]').val();
                var filter = /^([0-9]{8})+\@(st3telkom\.ac\.id|ittelkom-pwt\.ac\.id)+$/;
                if(!filter.test(email))
                {
                $('#cekemail').show();
                $('#email_ok').hide();
                $('#email_used').hide();
                $('#btn-save').attr('disabled', 'disabled');
                }
                else
                {
                $.ajax({
                url:"{{ route('cekEmail') }}",
                method:"POST",
                data:{email:email, _token:_token},
                success:function(result)
                {
                if(result == 'unique')
                {
                    $('#cekemail').hide();
                    $('#email_ok').show();
                    $('#email_used').hide();
                    $('#btn-save').attr('disabled', false);
                    
                }
                else
                {
                    $('#cekemail').hide();
                    $('#email_ok').hide();
                    $('#email_used').show();
                    $('#btn-save').attr('disabled', 'disabled');
                   
                }
                }
                })
                }
            });
            $('#username_register').blur(function(){
                var error_uname = '';
                var username = $('#username_register').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ route('cekUsername') }}",
                    method:"POST",
                    data:{username:username, _token:_token},
                    success:function(result)
                    {
                    if(result == 'unique')
                    {
                    $('#user_ok').show();
                    $('#user_used').hide();
                    
                    $('#btn-save').attr('disabled', false);
                    }
                    else
                    {
                    $('#user_ok').hide();
                    $('#user_used').show();
                    $('#btn-save').attr('disabled', 'disabled');
                   
                    }
                    }
                })
            });         
            $('#dosen_id').ready(function(){
                    $.ajax({
                        url: "{{ route('getDosen') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,dosen_nama){
                                $('select[name="dosen_id"]').append('<option value="'+ id +'">'+ dosen_nama +'</option>');
                            }); 
                        }
                    });
            });
            $('#angkatan_id').ready(function(){
                    $.ajax({
                        url: "{{ route('getAngkatan') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,angkatan_tahun){
                                $('select[name="angkatan_id"]').append('<option value="'+ id +'">'+ angkatan_tahun +'</option>');
                            }); 
                        }
                    });
            });
            $('#prodi_id').ready(function(){
                        $.ajax({
                            url: "{{ route('getProdi') }}",
                            type: "GET",
                            dataType : "json",
                            
                            success: function (data) {
                                
                                $.each(data, function(id,prodi_nama){
                                    $('select[name="prodi_id"]').append('<option value="'+ id +'">'+ prodi_nama +'</option>');
                                }); 
                            }
                        });
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-mahasiswa")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('daftar') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#form-mahasiswa').trigger("reset");
                            $('#modaltambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Mahasiswa", "success");
                            
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Mahasiswa", "error");
                            $("#error").show();
                            var error_password = data.responseJSON.errors.password_register;
                            var error_nama = data.responseJSON.errors.mahasiswa_nama;
                            var error_image = data.responseJSON.errors.mahasiswa_image;
                            if(error_password){
                              for (var i = 0; i < error_password.length; i++) {
                                var obj = '<li>'+error_password[i]+'</li>';
                                $('.list_error').append(obj);
                              }
                            }
                            if(error_nama){
                              for (var k = 0; k < error_nama.length; k++) {
                                var obj2 = '<li>'+error_nama[k]+'</li>';
                                $('.list_error').append(obj2);
                              }
                            }
                            if(error_image){
                              for (var j = 0; j < error_image.length; j++) {
                                var obj3 = '<li>'+error_image[j]+'</li>';
                                $('.list_error').append(obj3);
                              }
                            }
                            $('#btn-save').html('Save Changes');
                        }
                    });
            });
        });
</script>
@endpush
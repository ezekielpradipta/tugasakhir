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
                                <form id="register-form" style="display: block;" method="post" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="inputEmail">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-envelope text-muted"></i></span>
                                                </div>
                                                <input type="email" id="email" name="email" class="form-control" placeholder="Gunakan @st3telkom.ac.id / ittelkom-pwt.ac.id" value="{{old('email')}}">
                                                 <div id="statusEmail"></div>
                                            </div>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputUsername">Username</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user text-muted"></i></span>
                                                </div>
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="{{old('username')}}">
                                                 <div id="statusUname">
                                              </div>
                                            </div>
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="inputUsername">Nama</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-user text-muted"></i></span>
                                                </div>
                                                <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" value="{{old('nama')}}">     
                                            </div>
                                            
                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="inputPassword">Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
                                                </div>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="password" value="{{old('password')}}">
                                                 <div id="statusPassword">
                                              </div>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="inputConfirm">Confirm Password</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-lock text-muted"></i></span>
                                                </div>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                                <div id="statusConfirm"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                                    <label class="form-check-label" for="gridCheck">
                                                        Show Password
                                                    </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="InputAngkatan">Angkatan</label>
                                            <select name="angkatan_id" class="form-control" required>
                                              <option value="">- Pilih Angkatan -</option>
                                              @foreach($angkatans as $angkatan)
                                                  <option value="{{ $angkatan->id }}">
                                                  {{ $angkatan->tahun }}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="inputProdi">Prodi</label>
                                            <select name="prodi_id" class="form-control" required>
                                              <option value="">- Pilih Prodi -</option>
                                              @foreach($prodis as $prodi)
                                                  <option value="{{ $prodi->id }}">
                                                  {{ $prodi->nama }}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label for="inputDosen">Dosen Wali</label>
                                            <select name="dosen_id" id="pilihdosen" style="width: 100%;" class="form-control" required>
                                                <option></option>
                                                @foreach($dosens as $d)
                                                  <option value="{{ $d->id }}">
                                                  {{ $d->nama }}</option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col mb-3">
                                            <label>Upload Foto</label>
                                              <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                              </div>
                                        </div>
                                    </div>                                   
                                <button class="btn btn-primary mb-3" id="register" disabled name="register" type="submit">Submit form</button>
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
@endsection
@push('scripts2')
<script type="text/javascript">
    $(document).ready(function(){
        $('#email').blur(function(){
          var statusEmail = '';
          var email = $('#email').val();
          var _token = $('input[name="_token"]').val();
          var filter = /^([0-9]{8})+\@(st3telkom\.ac\.id|ittelkom-pwt\.ac\.id)+$/;
          if(!filter.test(email))
          {
            $('#statusEmail').removeClass('valid-feedback').html('');
            $('#email').removeClass('is-valid');
            $('#statusEmail').addClass('invalid-feedback').html('Bukan Email Institusi');
            $('#email').addClass('is-invalid');
            $('#register').attr('disabled', 'disabled');
          }
          else
          {
           $.ajax({
            url:"{{ route('register.cekEmail') }}",
            method:"POST",
            data:{email:email, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
                $('#statusEmail').removeClass('invalid-feedback').html('');
                $('#email').removeClass('is-invalid');
                $('#email').addClass('is-valid');
                $('#statusEmail').addClass('valid-feedback').html('Email Tersedia');
                $('#register').attr('disabled', false);
             }
             else
             {  
                $('#statusEmail').removeClass('valid-feedback').html('');
                $('#email').removeClass('is-valid');
                $('#email').addClass('is-invalid');
                $('#statusEmail').addClass('invalid-feedback').html('Email Sudah Digunakan');
                $('#register').attr('disabled', 'disabled');
             }
            }
           })
          }
        });

        $('#username').blur(function(){
          var statusUname = '';
          var username = $('#username').val();
          var _token = $('input[name="_token"]').val();
          
           $.ajax({
            url:"{{ route('register.cekUsername') }}",
            method:"POST",
            data:{username:username, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
                $('#statusUname').removeClass('invalid-feedback').html('');
                $('#username').removeClass('is-invalid');
                $('#username').addClass('is-valid');
                $('#statusUname').addClass('valid-feedback').html('Username Tersedia');
                $('#register').attr('disabled', false);
             }
             else
             {
                $('#statusUname').removeClass('valid-feedback').html('');
                $('#username').removeClass('is-valid');
                $('#username').addClass('is-invalid');
                $('#statusUname').addClass('invalid-feedback').html('Username Sudah Digunakan');
                $('#register').attr('disabled', 'disabled');
             }
            }
           })
        });
     });
</script>
@endpush
@push('scripts3')
<script type="text/javascript">
    $(document).ready(function(){
        bsCustomFileInput.init();
        $('#password_confirmation').keyup(validate);
        $('#gridCheck').click(function(){
            if($(this).is(':checked')){
                $('#password').attr('type','text');
            }else{
                $('#password').attr('type','password');
            }
        });
        $('#pilihdosen').select2({
        placeholder: 'Pilih Dosen Wail',
        theme: "classic"
      });
    });
    function validate(){
        var pass1 = $("#password").val();
        var pass2 = $("#password_confirmation").val();

        if(pass1 == pass2){
            $('#password_confirmation').removeClass('is-invalid').html('');
            $('#password').removeClass('is-invalid').html('');
            $('#password_confirmation').addClass('is-valid').html('');
            $('#password').addClass('is-valid').html('');
            $('#register').attr('disabled', false);
        } else {
            
            $('#password_confirmation').addClass('is-invalid').html('');
            $('#password').addClass('is-invalid').html('');
            $('#password_confirmation').removeClass('is-valid').html('');
            $('#password').removeClass('is-valid').html('');
            $('#register').attr('disabled', 'disabled');   
        }
    }
</script>
@endpush
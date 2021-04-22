@php
  $judul ='Admin'
@endphp
@extends('layouts.dosen')
@section('content')
@include('dosen.header',[$judul=>'judul'])
<section class="content">
  @include('dosen.alert')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit {{$judul}}</h3>
    </div>
   
    <form  method="post" id="formProfile" enctype="multipart/form-data">
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
            
            <input type="email" name="email" class="form-control" id="email" disabled>
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
            <input type="text" name="dosen_nama" class="form-control" id="dosen_nama">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="">NIDN</label>
            <input type="text" name="nidn" class="form-control" id="nidn">
            <label id="nidn_ok" class=" text-success " style="display:none;">NIDN Tersedia</label>
            <label id="nidn_used" class="text-danger" style="display:none;">NIDN Sudah Digunakan</label>
                
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
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password">
       
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6">
            <label for="" id="foto">Upload Foto</label>
            <img src="" class="gambar" id="gambar" width="60px" height="">
           <input type="file" name="dosen_image" class="form-control" id="dosen_image">
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
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
                url: "{{ route('dosen.profile.data') }}",
                type: "GET",
                dataType : "json",            
                success: function (data) {
                  console.log(data);
                  $("#email").val(data.user.email);
                  $("#username").val(data.user.username);
                  $("#dosen_nama").val(data.dosen.dosen_nama);
                  $("#nidn").val(data.dosen.nidn);
                  $("#password").val(data.user.password_text);
                  $("#hidden_image").val(data.dosen.dosen_image);
                  $("#gambar").attr('src', '../' + '../' + 'img/' + data.dosen.dosen_image );
                  $("#error").hide();
                }
        });
        $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#formProfile")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('dosen.profile.store') }}",
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
                            if(error_password){
                              for (var i = 0; i < error_password.length; i++) {
                                var obj = '<li>'+error_password[i]+'</li>';
                                $('.list_error').append(obj);
                              }
                            }
                            
                            Command: swal("Gagal", "Gagal", "error");
                            $('#btn-save').html('Save Changes');
                        }
                    });
          });
        $('#gridCheck').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
		    });
        
            
        $('#username').blur(function(){
                var error_uname = '';
                var username = $('#username').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ route('admin.dosen.cekUsername') }}",
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
      $('#nidn').blur(function(){
                var error_uname = '';
                var nidn = $('#nidn').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ route('admin.dosen.cekNIDN') }}",
                    method:"POST",
                    data:{nidn:nidn, _token:_token},
                    success:function(result)
                    {
                    if(result == 'unique')
                    {
                    $('#nidn_ok').show();
                    $('#nidn_used').hide();
                  
                    $('#btn-save').attr('disabled', false);
                    }
                    else
                    {
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
@php
$judul = 'Data Dosen'
@endphp
@extends('layouts.admin')
@section('content')
@include('admin.header',[$judul=>'judul'])
<section class="content">
    @include('admin.alert')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar {{$judul}}</h3>
            <a href="javascript:void(0)" id="tambah" data-toggle="modal" class="btn btn-primary float-right">
                <span class="fas fa-plus"> Tambah {{$judul}}</span>
            </a>
        </div>
        <div class="card-body">
            <table id="dt" class="table table-bordered table-striped">
                <thead>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIDN</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formDosen" name="formDosen" enctype="multipart/form-data">
                        @csrf
                        <div id="error" style=" display:none; ">
                            <div class="alert alert-danger ">
                                <strong>Whoops!</strong> Data yang anda masukan tidak sesuai.<br><br>
                                <ul class="list_error">

                                </ul>
                            </div>
                        </div>
                        <input type="hidden" name="dosen_id" id="dosen_id">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="hidden_image" id="hidden_image">
                        <div class="form-group">
                            <label for="inputemail">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                            <label id="cekemail" class="text-danger" style="display:none;">Bukan Email Institusi</label>
                            <label id="email_ok" class=" text-success " style="display:none;">Email Tersedia</label>
                            <label id="email_used" class="text-danger" style="display:none;">Email Sudah
                                Digunakan</label>
                        </div>
                        <div class="form-group">
                            <label for="inputUsername">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Username">
                            <label id="user_ok" class=" text-success " style="display:none;">Username Tersedia</label>
                            <label id="user_used" class="text-danger" style="display:none;">Username Sudah
                                Digunakan</label>
                        </div>
                        <div class="form-group">
                            <label for="inputNIDN">NIDN</label>
                            <input type="text" name="nidn" class="form-control" id="nidn" placeholder="NIDM">
                            <label id="nidn_ok" class=" text-success " style="display:none;">NIDN Tersedia</label>
                            <label id="nidn_used" class="text-danger" style="display:none;">NIDN Sudah Digunakan</label>
                        </div>
                        <div class="form-group">
                            <label for="inputNamaDosen">Nama</label>
                            <input type="text" name="dosen_nama" class="form-control" id="dosen_nama"
                                placeholder="Nama">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="password">

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
                                id="password_confirmation" placeholder="Konfirmasi Password"
                                autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="dosen_status" id="dosen_status" class="form-control" required>
                                <option value="dosenwali">Dosen Wali</option>
                                <option value="kemahasiswaan">Kemahasiswaan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputImageDosen" id="fotoDosen">Upload Foto Dosen</label>
                            <img src="" class="gambar" id="gambar" width="60px" height="">
                            <input type="file" name="dosen_image" class="form-control" id="dosen_image">

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
</section>
@endsection
@push('scripts')
<script>
    $(document).ready( function () {
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
            var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.dosen.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'nama',  name: 'nama' },
                    { data: 'user.email', name: 'user.email' },
                    { data: 'nidn', name: 'nidn' },
                    { data: 'dosen', name: 'dosen' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('#email').blur(function(){
                var error_email = '';
                var email = $('#email').val();
                var _token = $('input[name="_token"]').val();
                var filter = /^([a-zA-Z0-9_\.\-])+\@(st3telkom\.ac\.id|ittelkom-pwt\.ac\.id)+$/;
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
            
            $('#username').blur(function(){
                var error_uname = '';
                var username = $('#username').val();
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
            $('#nidn').blur(function(){
                var error_uname = '';
                var nidn = $('#nidn').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ route('cekNidn') }}",
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
            $('#tambah').click(function () {
                $('#btn-save').val("tambah-data-dosen");
                $('#dosen_id').val('');
                $('#user_id').val('');
                $('#formDosen').trigger("reset");
                $('.modal-title').html("Tambah Data Dosen");
                $('#hidden_image').val('');
                $('#btn-save').show();
                $('.gambar').removeAttr('src');
                $('#cekemail').hide();
                $('#email_ok').hide();
                $('#email_used').hide();
                $('#user_ok').hide();
                $('#user_used').hide();
                $('#nidn_ok').hide();
                $('#nidn_used').hide();
                $("#error").hide();
                $('#modal-default').modal('show');
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#formDosen")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.dosen.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#formDosen').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Dosen", "success");
                            table.draw();
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal menambahkan Data Dosen", "error");
                            $("#error").show();
                            var error_password = data.responseJSON.errors.password;
                            var error_nama = data.responseJSON.errors.dosen_nama;
                            var error_image = data.responseJSON.errors.dosen_image;
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
            
            $('body').on('click', '.editItem', function () {
                var dosen_id = $(this).data('id');
                var url = "{{route('admin.dosen.index')}}".concat("/" + dosen_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit Data Dosen");
                        $('#cekemail').hide();
                        $('#email_ok').hide();
                        $('#email_used').hide();
                        $('#user_ok').hide();
                        $('#user_used').hide();
                        $('#btn-save').val("edit-dosen");
                        $('#nidn_ok').hide();
                        $('#nidn_used').hide();
                        $('#modal-default').modal('show');
                        $('#dosen_id').val(dosen_id);
                        $('#user_id').val(data.user_id);
                        $('#dosen_nama').val(data.dosen_nama);
                        $('#username').val(data.user.username);
                        $('#dosen_status').val(data.dosen_status);
                        $('#password').val(data.user.password_text);
                        $('#email').val(data.user.email);
                        $('#nidn').val(data.nidn);
                        $('#hidden_image').val(data.dosen_image);
                        $("#gambar").attr('src', '../' + '../' + 'img/' + data.dosen_image );
                        
                     }
                  });          
            });
            $('body').on('click', '.deleteItem', function () {
                var dosen_id = $(this).data('id');
                swal({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
                }).then(function() {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.dosen.store') }}"+'/'+dosen_id,
                        success: function (data) {
                            table.draw();
                            swal(
                                'Terhapus!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            swal(
                                'Kesalahan!',
                                'Data Gagal Dihapus',
                                'warning'
                            );
                        }

                    });
                
                })
            });
            

        });
</script>
@endpush
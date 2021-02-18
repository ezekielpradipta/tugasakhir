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
				<a href="javascript:void(0)" id="tambah" data-toggle="modal"  class="btn btn-primary float-right">
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
                <div class="alert alert-danger" style="display:none"></div>
                <input type="hidden" name="dosen_id" id="dosen_id">
                <input type="hidden" name="user_id" id="user_id">
                 <div class="form-group">
                     <label for="inputemail">Email</label>
                     <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                     <label id="cekemail" class="text-danger">Bukan Email Institusi</label>
                     <label id="emailtersedia" class=" text-success ">Email Tersedia</label>
                     <label id="emailtidaktersedia" class="text-danger">Email Sudah Digunakan</label>
                 </div>
                 <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">                   
                     <label id="usertersedia" class=" text-success ">Username Tersedia</label>
                     <label id="usertidaktersedia" class="text-danger">Username Sudah Digunakan</label>
                </div>
                <div class="form-group">
                    <label for="inputNIDN">NIDN</label>
                    <input type="text" name="nidn" class="form-control" id="nidn" placeholder="NIDM">
                    <label id="nidntersedia" class=" text-success ">NIDN Tersedia</label>
                    <label id="nidntidaktersedia" class="text-danger">NIDN Sudah Digunakan</label>
                </div>
                <div class="form-group">
                    <label for="inputNamaDosen">Nama</label>
                    <input type="text" name="dosen_nama" class="form-control" id="dosen_nama" placeholder="Nama">
                    <label class="text-danger" id="nameDosenError"></label>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <label class="text-danger" id="passwordError"></label>
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
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="inputImageDosen" id="fotoDosen">Upload Foto Dosen</label>
                    <img src="" class="gambar" id="gambar" width="60px" height="">
                    <label class="text-danger" id="dosen_imageError"></label>
                   <input type="file" name="dosen_image" class="form-control" id="dosen_image">
                   
                </div>
              </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" value="tambah" id="btn-save">Save data</button>
              <button type="button" class="btn btn-primary" value="update" id="btn-update">Update data</button>
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
            
            
            $('#cekemail').hide();
            $('#emailtersedia').hide();
            $('#emailtidaktersedia').hide();
            $('#usertersedia').hide();
            $('#usertidaktersedia').hide();
            $('#nidntersedia').hide();
            $('#nidntidaktersedia').hide();
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
                $('#emailtersedia').hide();
                $('#emailtidaktersedia').hide();
                $('#btn-save').attr('disabled', 'disabled');
                }
                else
                {
                $.ajax({
                url:"{{ route('admin.dosen.cekEmail') }}",
                method:"POST",
                data:{email:email, _token:_token},
                success:function(result)
                {
                if(result == 'unique')
                {
                    $('#cekemail').hide();
                    $('#emailtersedia').show();
                    $('#emailtidaktersedia').hide();
                    $('#btn-save').attr('disabled', false);
                    $('#btn-update').attr('disabled', false);
                }
                else
                {
                    $('#cekemail').hide();
                    $('#emailtersedia').hide();
                    $('#emailtidaktersedia').show();
                    $('#btn-save').attr('disabled', 'disabled');
                    $('#btn-update').attr('disabled', 'disabled');
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
                    url:"{{ route('admin.dosen.cekUsername') }}",
                    method:"POST",
                    data:{username:username, _token:_token},
                    success:function(result)
                    {
                    if(result == 'unique')
                    {
                    $('#usertersedia').show();
                    $('#usertidaktersedia').hide();
                    $('#btn-update').attr('disabled', false);
                    $('#btn-save').attr('disabled', false);
                    }
                    else
                    {
                    $('#usertersedia').hide();
                    $('#usertidaktersedia').show();
                    $('#btn-save').attr('disabled', 'disabled');
                    $('#btn-update').attr('disabled', 'disabled');
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
                    $('#nidntersedia').show();
                    $('#nidntidaktersedia').hide();
                    $('#btn-update').attr('disabled', false);
                    $('#btn-save').attr('disabled', false);
                    }
                    else
                    {
                    $('#nidntersedia').hide();
                    $('#nidntidaktersedia').show();
                    $('#btn-save').attr('disabled', 'disabled');
                    $('#btn-update').attr('disabled', 'disabled');
                    }
                    }
                })
            });
            $('#tambah').click(function () {
                $('#btn-save').val("tambah-data-dosen");
                $('#dosen_id').val('');
                $('#formDosen').trigger("reset");
                $('.modal-title').html("Tambah Data Dosen");
                $('#btn-update').hide();
                $('#btn-save').show();
                $('.gambar').removeAttr('src');
                $('#cekemail').hide();
                $('#emailtersedia').hide();
                $('#emailtidaktersedia').hide();
                $('#usertersedia').hide();
                $('#usertidaktersedia').hide();
                $('#nidntersedia').hide();
                $('#nidntidaktersedia').hide();
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
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Dosen", "error");
                            
                            $('#nameDosenError').text(data.responseJSON.errors.dosen_nama);
                            $('#passwordError').text(data.responseJSON.errors.password);
                            $('#dosen_imageError').text(data.responseJSON.errors.dosen_image);
                            $('#saveBtn').html('Save Changes');
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
                        $('#btn-update').show();
                        $('#btn-save').hide();
                        $('#cekemail').hide();
                        $('#emailtersedia').hide();
                        $('#emailtidaktersedia').hide();
                        $('#usertersedia').hide();
                        $('#usertidaktersedia').hide();
                        $('#btn-save').val("edit-dosen");
                        $('#nidntersedia').hide();
                        $('#nidntidaktersedia').hide();
                        $('#modal-default').modal('show');
                        $('#dosen_id').val(dosen_id);
                        $('#user_id').val(data[0].user_id);
                        $('#dosen_nama').val(data[0].dosen_nama);
                        $('#username').val(data[0].username);
                        $('#password').val(data[0].password_text);
                        $('#email').val(data[0].email);
                        $('#nidn').val(data[0].nidn);
                        $("#gambar").attr('src', '../' + '../' + 'img/' + data[0].dosen_image );
                        
                     }
                  });          
            });
            $('#btn-update').click(function (e) {
                e.preventDefault();
                var myForm = $("#formDosen")[0];
                var dosen_id = $('#dosen_id').val();
                var urlUpdate ="{{route('admin.dosen.updateDong')}}";
                console.log(urlUpdate);
                $.ajax({
                        data: new FormData(myForm),
                        url: urlUpdate,
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
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Dosen", "error");
                            $('#nameDosenError').text(data.responseJSON.errors.dosen_nama);
                            $('#passwordError').text(data.responseJSON.errors.password);
                            $('#dosen_imageError').text(data.responseJSON.errors.dosen_image);
                            $('#saveBtn').html('Save Changes');
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
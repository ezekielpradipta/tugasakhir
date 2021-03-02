@php
	$judul = 'Data Mahasiswa'
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
						<th>NIM</th>
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
              <form method="post" id="form-mahasiswa" name="form-mahasiswa" enctype="multipart/form-data">
                @csrf
                <div class="alert alert-danger" style="display:none"></div>
                <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="dosen_val" id="dosen_val">
                <input type="hidden" name="prodi_val" id="prodi_val">
                <input type="hidden" name="angkatan_val" id="angkatan_val">
                <input type="hidden" name="hidden_image" id="hidden_image">
                 <div class="form-group">
                     <label for="inputemail">Email</label>
                     <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                     <label id="cekemail" class="text-danger" style="display: none;">Bukan Email Institusi</label>
                     <label id="email_ok" class=" text-success " style="display:none;">Email Tersedia</label>
                     <label id="email_used" class="text-danger" style="display:none;">Email Sudah Digunakan</label>
                 </div>
                 <div class="form-group">
                    <label for="inputUsername">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username">                   
                     <label id="user_ok" class=" text-success " style="display:none;">Username Tersedia</label>
                     <label id="user_used" class="text-danger" style="display:none;">Username Sudah Digunakan</label>
                </div>
                <div class="form-group">
                    <label for="inputNamaDosen">Nama</label>
                    <input type="text" name="mahasiswa_nama" class="form-control" id="mahasiswa_nama" placeholder="Nama">
                    <label class="text-danger" id="nama_error"></label>
                </div>
                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
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
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi Password" autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="">Dosen</label>
                    <select name="dosen_id" id="dosen_id" class="form-control" required>
                        <option value="">- Pilih Dosen -</option>
                      
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Prodi</label>
                    <select name="prodi_id" id="prodi_id" class="form-control" required>
                        <option value="">- Pilih Prodi -</option>
                       
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Angkatan</label>
                    <select name="angkatan_id" id="angkatan_id" class="form-control" required>
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
            $('#gridCheck').click(function(){
                if($(this).is(':checked')){
                    $('#password').attr('type','text');
                }else{
                    $('#password').attr('type','password');
                }
		    });
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
                url:"{{ route('admin.mahasiswa.cekEmail') }}",
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
                    url:"{{ route('admin.mahasiswa.cekUsername') }}",
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
        
        var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.mahasiswa.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'nama',  name: 'nama' },
                    { data: 'user.email', name: 'user.email' },
                    { data: 'mahasiswa_nim', name: 'mahasiswa_nim' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

        });
        $('#dosen_id').ready(function(){
                    $.ajax({
                        url: "{{ route('admin.mahasiswa.cekDosen') }}",
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
                        url: "{{ route('admin.mahasiswa.cekAngkatan') }}",
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
                        url: "{{ route('admin.mahasiswa.cekProdi') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,prodi_nama){
                                $('select[name="prodi_id"]').append('<option value="'+ id +'">'+ prodi_nama +'</option>');
                            }); 
                        }
                    });
        });
        $('#dosen_id').change(function(){
                var dosen_val = $(this).children("option:selected").val();
                $('#dosen_val').val(dosen_val);
        });
        $('#prodi_id').change(function(){
                var prodi_val = $(this).children("option:selected").val();
                $('#prodi_val').val(prodi_val);
        });
        $('#angkatan_id').change(function(){
                var angkatan_val = $(this).children("option:selected").val();
                $('#angkatan_val').val(angkatan_val);
        });
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
               
                $('#modal-default').modal('show');
        });
        $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-mahasiswa")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.mahasiswa.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#form-mahasiswa').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Mahasiswa", "success");
                            table.draw();
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Mahasiswa", "error");
                            
                            $('#nama_error').text(data.responseJSON.errors.mahasiswa_nama);
                            $('#password_error').text(data.responseJSON.errors.password);
                            $('#mahasiswa_image_error').text(data.responseJSON.errors.mahasiswa_image);
                            $('#saveBtn').html('Save Changes');
                        }
                    });
        });
        $('body').on('click', '.editItem', function () {
                var mahasiswa_id = $(this).data('id');
                var url = "{{route('admin.mahasiswa.index')}}".concat("/" + mahasiswa_id +"/edit");
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
                        $('#btn-save').val("edit-mahasiswa");
                        $('#modal-default').modal('show');
                        $('#mahasiswa_id').val(data.id);
                        $('#dosen_id').val(data.dosen_id);
                        $('#dosen_val').val(data.dosen_id);
                        $('#angkatan_id').val(data.angkatan_id);
                        $('#angkatan_val').val(data.angkatan_id);
                        $('#prodi_id').val(data.prodi_id);
                        $('#prodi_val').val(data.prodi_id);
                        $('#user_id').val(data.user_id);
                        $('#mahasiswa_nama').val(data.mahasiswa_nama);
                        $('#username').val(data.user.username);
                        $('#password').val(data.user.password_text);
                        $('#email').val(data.user.email);
                        $('#hidden_image').val(data.mahasiswa_image);
                        $("#gambar").attr('src', '../' + '../' + 'img/' + data.mahasiswa_image );
                        
                     }
                  });          
        });
        $('body').on('click', '.deleteItem', function () {
                var mahasiswa_id = $(this).data('id');
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
                        url: "{{ route('admin.mahasiswa.store') }}"+'/'+mahasiswa_id,
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
    </script>
@endpush
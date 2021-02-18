@php
	$judul = 'Data Prodi'
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
                    <th>Nama Prodi</th>
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
                    <form method="post" id="formProdi" name="formProdi" enctype="multipart/form-data">
                      @csrf
                      <div class="alert alert-danger" style="display:none"></div>
                      <input type="hidden" name="prodi_id" id="prodi_id">
                       <div class="form-group">
                           <label for="inputNamaProdi">Nama Prodi</label>
                           <input type="text" name="prodi_nama" class="form-control" id="prodi_nama" placeholder="Nama Prodi">
                           <label id="proditersedia" class=" text-success ">Prodi Tersedia</label>
                           <label id="proditidaktersedia" class="text-danger">Prodi Sudah Digunakan</label>
                       </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="tambah" id="btn-save">Save data</button>
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script>
        $(document).ready( function () {
            $('#proditersedia').hide();
            $('#proditidaktersedia').hide();
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.prodi.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'prodi_nama',  name: 'prodi_nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('#prodi_nama').blur(function(){
                var prodi_nama = $('#prodi_nama').val();
                var _token = $('input[name="_token"]').val();
                
                $.ajax({
                    url:"{{ route('admin.prodi.cekNamaProdi') }}",
                    method:"POST",
                    data:{prodi_nama:prodi_nama, _token:_token},
                    success:function(result)
                    {
                    if(result == 'unique')
                    {
                    $('#proditersedia').show();
                    $('#proditidaktersedia').hide();
                    
                    $('#btn-save').attr('disabled', false);
                    }
                    else
                    {
                    $('#proditersedia').hide();
                    $('#proditidaktersedia').show();
                    $('#btn-save').attr('disabled', 'disabled');
                    }
                    }
                })
            });
            $('#tambah').click(function(){
                $('#btn-save').val("tambah-data-prodi");
                $('#formProdi').trigger("reset");
                $('#prodi_id').val('');
                $('.modal-title').html("Tambah Data Prodi");
                
                $('#proditersedia').hide();
                $('#proditidaktersedia').hide();
                $('#modal-default').modal('show');
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#formProdi")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.prodi.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#formProdi').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Prodi", "success");
                            table.draw();
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Prodi", "error");
                            
                            $('#saveBtn').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.editItem', function () {
                var prodi_id = $(this).data('id');
                var url = "{{route('admin.prodi.index')}}".concat("/" + prodi_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit Data Prodi");
                       
                        $('#btn-save').val("Update-Prodi");
                        $('#proditersedia').hide();
                        $('#proditidaktersedia').hide();
                        $('#modal-default').modal('show');
                        $('#prodi_id').val(prodi_id);
                        
                        $('#prodi_nama').val(data.prodi_nama);
                        
                     }
                  });          
            });
            $('body').on('click', '.deleteItem', function () {
                var prodi_id = $(this).data('id');
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
                        url: "{{ route('admin.prodi.store') }}"+'/'+prodi_id,
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
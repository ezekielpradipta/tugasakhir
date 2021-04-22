@php
$judul = 'TAK Kumulatif'
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
                    <th>Prodi</th>
                    <th>Angkatan</th>
                    <th>Poin Minimal</th>
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
                    <form method="post" id="form" name="form" enctype="multipart/form-data">
                        @csrf
                        <div class="alert alert-danger" style="display:none"></div>
                        <input type="hidden" name="takkumulatif_id" id="takkumulatif_id">
                        <div class="form-group">
                            <label for="">Prodi</label>
                            <select id="prodi" name="prodi" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Angkatan</label>
                            <select id="angkatan" name="angkatan" class="form-control">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Poin Minimum</label>
                            <input type="text" id="poinminimum" class="form-control" name="poinminimum"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
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
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.takkumulatif.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'prodi.prodi_nama',  name: 'prodi.prodi_nama' },
                    { data: 'angkatan.angkatan_tahun',  name: 'angkatan.angkatan_tahun' },
                    { data: 'poinminimum',  name: 'poinminimum' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $.ajax({
            url: "{{ route('admin.takkumulatif.data') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                for (var k = 0; k < data.angkatan.length; k++) {
                    var angkatan =
                        '<option value="' + data.angkatan[k].id + '">' + data.angkatan[k]
                        .angkatan_tahun + '</option>';
                    $('select[name="angkatan"]').append(angkatan);
                }
                for (var k = 0; k < data.prodi.length; k++) {
                    var prodi =
                        '<option value="' + data.prodi[k].id + '">' + data.prodi[k]
                        .prodi_nama + '</option>';
                    $('select[name="prodi"]').append(prodi);
                }
               
            }
        });
            $('#tambah').click(function(){
                $('#btn-save').val("tambah-data");
                $('#form').trigger("reset");
                $('#takkumulatif_id').val('');
                $('.modal-title').html("Tambah Data");
                $('#modal-default').modal('show');
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#form")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.takkumulatif.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#form').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data", "success");
                            table.draw();
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data", "error");
                            $('#saveBtn').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.editItem', function () {
                var tak_id = $(this).data('id');
                var url = "{{route('admin.takkumulatif.index')}}".concat("/" + tak_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit Data");
                       
                        $('#btn-save').val("Update");
                        $('#modal-default').modal('show');
                        $('#takkumulatif_id').val(tak_id);
                        $('#prodi').val(data.prodi_id);
                        $('#angkatan').val(data.angkatan_id);
                        $('#poinminimum').val(data.poinminimum);
                        
                     }
                  });          
            });
            $('body').on('click', '.deleteItem', function () {
                var tak_id = $(this).data('id');
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
                        url: "{{ route('admin.takkumulatif.store') }}"+'/'+tak_id,
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
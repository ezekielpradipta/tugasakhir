@php
	$judul = 'Data Angkatan'
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
                    <th>Tahun Angkatan</th>
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
                      <input type="hidden" name="angkatan_id" id="angkatan_id">
                       <div class="form-group">
                           <label for="inputemail">Tahun Angkatan</label>
                           <input type="text" name="tahunAngkatan" class="form-control" id="tahunAngkatan" placeholder="Tahun Angkatan">
                           <label class="text-danger" id="tahunError"></label>
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
                ajax: "{{ route('admin.angkatan.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'tahunAngkatan',  name: 'tahunAngkatan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            
            $('#tambah').click(function(){
                $('#btn-save').val("tambah-data-Angkatan");
                $('#form').trigger("reset");
                $('#angkatan_id').val('');
                $('.modal-title').html("Tambah Data Angkatan");
                $('#modal-default').modal('show');
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#form")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.angkatan.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#form').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Angkatan", "success");
                            table.draw();
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Angkatan", "error");
                            $('#tahunError').text(data.responseJSON.errors.tahunAngkatan);
                            $('#saveBtn').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.editItem', function () {
                var angkatan_id = $(this).data('id');
                var url = "{{route('admin.angkatan.index')}}".concat("/" + angkatan_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit Data Angkatan");
                       
                        $('#btn-save').val("Update-Angkatan");
                        $('#modal-default').modal('show');
                        $('#angkatan_id').val(angkatan_id);
                        
                        $('#tahunAngkatan').val(data.tahunAngkatan);
                        
                     }
                  });          
            });
            $('body').on('click', '.deleteItem', function () {
                var angkatan_id = $(this).data('id');
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
                        url: "{{ route('admin.angkatan.store') }}"+'/'+angkatan_id,
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
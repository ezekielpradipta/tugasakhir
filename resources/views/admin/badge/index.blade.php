@php
$judul = 'Badge'
@endphp
@extends('layouts.admin')
@section('content')
@include('admin.header',[$judul=>'judul'])
<section class="content">
    @include('admin.alert')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$judul}}</h3>
            <a href="javascript:void(0)" id="tambah" data-toggle="modal" class="btn btn-primary float-right">
                <span class="fas fa-plus"> Tambah {{$judul}}</span>
            </a>
        </div>
        <div class="card-body">
            <table id="dt" class="table table-bordered table-striped">
                <thead>
                    <th>No.</th>
                    <th>Nama</th>

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
                        <input type="hidden" name="badge_id" id="badge_id">

                        <input type="hidden" name="hidden_image" id="hidden_image">
                        <div class="form-group">
                            <label for="" id="image_">Upload Foto </label>
                            <img src="" class="gambar" id="gambar" width="100%" height="">
                            <input type="file" name="badge_image" class="form-control" id="badge_image">

                        </div>

                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="badge_nama" id="badge_nama" class="form-control">
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
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#form').on('keyup keypress', function (e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        var table = $('#dt').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.badge.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]

        });
        $('#tambah').click(function () {
            $('#btn-save').val("tambah-data-modal");
            $('#form').trigger("reset");
            $('#badge_id').val('');
            $('#hidden_image').val('');
            $('.gambar').removeAttr('src');
            $('.modal-title').html("Tambah Badge");
            $('#modal-default').modal('show');
        });
        $('#btn-save').click(function (e) {
            e.preventDefault();
            var myForm = $("#form")[0];
            $(this).html('Sending..');
            $.ajax({
                data: new FormData(myForm),
                url: "{{ route('admin.badge.store') }}",
                type: "POST",

                contentType: false,
                processData: false,
                success: function (data) {

                    $('#form').trigger("reset");
                    $('#modal-default').modal('hide');
                    table.draw();
                    Command: swal("Sukses", "Berhasil ", "success");

                },
                error: function (data) {

                    Command: swal("Gagal", "Gagal", "error");
                    $('#btn-save').html('Save Changes');
                }
            });
        });
        $('body').on('click', '.btn-edit', function () {
            var badge_id = $(this).data('id');
            var url = "{{route('admin.badge.index')}}".concat("/" + badge_id + "/edit");
            console.log(url);
            jQuery.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $('.modal-title').html("Edit");
                    $('#btn-save').val("edit");
                    $('#modal-default').modal('show');
                    $('#badge_id').val(data.id);
                    $('#badge_nama').val(data.badge_nama);
                    $('#hidden_image').val(data.badge_image);
                    $("#gambar").attr('src', '../' + '../' + 'img/' + data.badge_image);
                }
            });
        });
        $('body').on('click', '.btn-delete', function () {
            var slider_id = $(this).data('id');
            swal({
                title: 'Apakah anda yakin?',
                text: "Data akan dihapus!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.badge.store') }}" + '/' +
                        slider_id,
                    success: function (data) {
                        table.draw();
                        swal(
                            'Terhapus!',
                            'Berhasil Dihapus',
                            'success'
                        );
                    },
                    error: function (data) {
                        console.log('Error:', data);
                        swal(
                            'Kesalahan!',
                            'Gagal Dihapus',
                            'warning'
                        );
                    }

                });

            })
        });
    });

</script>
@endpush
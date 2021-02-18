@php
	$judul = 'Data TAK'
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
<!-- Modal UTAMA -->
    <div class="modal hide fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formTak" name="formTak" enctype="multipart/form-data">
                      @csrf
                      <div class="alert alert-danger" style="display:none"></div>
                      <input type="hidden" name="tak_id" id="tak_id">
                       <div class="form-group">
                           <label for="inputemail">Kategori</label>
                           <div class="row">
                               <div class="col-sm-8">
                                    <select name="kategoritak_id" id="kategoritak_id" class="form-control" required>
                                        <option>--Pilih Kategori TAK--</option>  
                                     </select>
                               </div>
                               <div class=" col-sm-2 ">
                                <a href="javascript:void(0)" id="tambahKategoriTak" data-toggle="modaltambahkategori"  class="btn btn-primary btn-sm">
                                    <span class="fas fa-plus"></span>
                                </a>
                                <a href="javascript:void(0)" id="listKategoriTak" data-toggle="modal-kategori-tambah"  class="btn btn-secondary btn-sm">
                                    <span class="fas fa-cog"></span>
                                </a>
                               </div>
                           </div>
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
<!-- END Modal UTAMA -->
<!--MODAL Tambah Kategori -->
    <div class="modal hide fade" id="modal-kategori-tambah">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-kategori-tambah"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-kategori-tambah" name="form-kategori-tambah" enctype="multipart/form-data">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <input type="hidden" name="kategoritak_id" id="kategoritak_id">
                    <input type="hidden" name="kategori_id" id="kategori_id">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="inputNamaProdi">Nama Kategori</label>
                            <input type="text" name="kategoritak_nama" class="form-control" id="kategoritak_nama" placeholder="Nama Kategori">
                            <label id="kategoritersedia" class=" text-success " style="display:none">Kategori Tersedia</label>
                            <label id="kategoritidaktersedia" class="text-danger" style="display:none">Kategori Sudah Digunakan</label>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="tambah" id="save-kategori">Save data</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal Kategori TAK -->
<!--MODAL List Kategori -->
    <div class="modal hide fade" id="modal-kategori-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-kategori-data"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                            <table id="tableKategoriTak" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Kategori TAK</th>
                                    <th>Aksi</th>
                                </thead>
                            </table>
                </div>
            </div>
        </div>
    </div>
<!--END MODAL List Kategori -->
</section>
@endsection
@push('scripts')
<script>
    $(document).ready( function () {
        //Utama
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $('#tambah').click(function(){
                $('#btn-save').val("tambah-data-TAK");
                $('#formTAK').trigger("reset");
                $('#tak_id').val('');
                $('.modal-title').html("Tambah Data TAK");
                $('#modal-default').modal('show');
            });
        //End Utama
        //KategoriTak Script //
            $('#tambahKategoriTak').click(function(){
                $('#save-kategori').val("tambah-data-kategoriTAK");
                $('#form-kategori-tambah').trigger("reset");
                $('#kategoritak_id').val('');
                $('.judul-kategori-tambah').html("Tambah Data Kategori TAK");
                $('#modal-kategori-tambah').modal('show');
            });
            $('#listKategoriTak').click(function(){
                $('.judul-kategori-data').html("Data Kategori TAK");
                $('#modal-kategori-data').modal('show');
            });
            $('#save-kategori').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-kategori-tambah")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.tak.kategoritak.tambah') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            console.log(data);
                            $('#form-kategori-tambah').trigger("reset");
                            $('#modal-kategori-tambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Kategori TAK", "success");
                            kategoritak=true;
                            $('#kategoritak_id').find('option').remove();
                            tableKategoriTak.draw();
                        },
                        error: function (data) {
                            console.log(data);
                            Command: swal("Gagal", "Gagal menambahkan Data Kategori TAK", "error");
                            
                            $('#save-kategori').html('Save Changes');
                        }
                    });
            });
            var kategoritak=true;
            $('#kategoritak_id').click(function(){
                if(kategoritak){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            console.log(data);
                            $('#kategoritak_id').find('option').remove();
                            $('select[name="kategoritak_id"]').append('<option>--Pilih Kategori TAK--</option>');
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="kategoritak_id"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            }); 
                        }
                    });
                    kategoritak= false;
                }
            });
            var tableKategoriTak = $('#tableKategoriTak').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tak.kategoritak') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'kategoritak_nama',  name: 'kategoritak_nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('body').on('click', '.kategoritak-edit', function () {
                var kategoritak_id = $(this).data('id');
                var url = "{{route('admin.tak.kategoritak')}}".concat("/" + kategoritak_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.judul-kategori-tambah').html("Edit Data Kategori Tak");
                        $('#save-kategori').val("Update-Kategori");
                        $('#modal-kategori-data').modal('hide');
                        $('#modal-kategori-tambah').modal('show');
                        $('#kategori_id').val(data.id);
                        $('#kategoritak_nama').val(data.kategoritak_nama);   
                     }
                  });          
            });
            $('body').on('click', '.kategoritak-delete', function () {
                var kategoritak_id = $(this).data('id');
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
                        url: "{{ route('admin.tak.kategoritak.tambah') }}"+'/'+kategoritak_id,
                        success: function (data) {
                            tableKategoriTak.draw();
                            kategoritak=true;
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
        //End Kategori Script

    });          
</script>
@endpush
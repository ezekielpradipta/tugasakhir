@php
$judul = 'Slider'
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
            <div class="form-group">
                <label>Status:</label>
                <select id='jenis' class="form-control">
                    <option value="inputtak">Slider Input TAK Mahasiswa</option>
                    <option value="dashboard">Slider Dashboard Mahasiswa</option>
                </select>
            </div>
            <table id="dt" class="table table-bordered table-striped">
                <thead>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th>Urut</th>
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
                    <form method="post" id="formSlider" name="formSlider" enctype="multipart/form-data">
                        @csrf
                        <div class="alert alert-danger" style="display:none"></div>
                        <input type="hidden" name="slider_id" id="slider_id">
                        <input type="hidden" name="slider_jenis_val" id="slider_jenis_val">
                        <input type="hidden" name="hidden_image" id="hidden_image">
                        <div class="form-group">
                            <label for="" id="fotoSlider">Upload Foto Slider</label>
                            <img src="" class="gambar" id="gambar" width="100%" height="">
                            <input type="file" name="slider_image" class="form-control" id="slider_image">

                        </div>
                        <div class="form-group">
                            <label for="">Jenis</label>
                            <select id="slider_jenis" name="slider_jenis" class="form-control">
                                <option value="inputtak">Slider Input TAK Mahasiswa</option>
                                <option value="dashboard">Slider Dashboard Mahasiswa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea name="slider_caption" id="slider_caption" class="form-control" cols="30"
                                rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Urut</label>
                            <input type="text" id="slider_order" class="form-control" name="slider_order"
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
                ajax: {
                    url: "{{ route('admin.slider.index') }}",
                    data: function (d) {
                      d.jenis = $('#jenis').val() 
                      
                      }
                      },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  
                    { data: 'slider_caption',  name: 'slider_caption' },
                    { data: 'slider_order',  name: 'slider_order' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('#jenis').change(function(){
              table.draw();
            });
            $('#tambah').click(function(){
                $('#btn-save').val("tambah-data-modal");
                $('#formSlider').trigger("reset");
                $('#slider_id').val('');
                $('#slider_id').val('');
                $('#hidden_image').val('');
                $('.gambar').removeAttr('src');
                $('.modal-title').html("Tambah Slider");
                $('#modal-default').modal('show');
            });
            $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#formSlider")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.slider.inputtak.tambah') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                           
                            $('#formSlider').trigger("reset");
                            $('#modal-default').modal('hide');
                            table.draw();
                            Command: swal("Sukses", "Berhasil ", "success");
                            
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal ", "error");
                            $('#btn-save').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.btn-edit', function () {
                var slider_id = $(this).data('id');
                var url = "{{route('admin.slider.index')}}".concat("/" + slider_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit");
                        $('#btn-save').val("edit");
                        $('#modal-default').modal('show');
                        $('#slider_id').val(data.id);
                        $('#slider_order').val(data.slider_order);
                        $('#slider_caption').val(data.slider_caption);
                        $('#hidden_image').val(data.slider_image);
                        $("#gambar").attr('src', '../' + '../' + 'img/' + data.slider_image );
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
                }).then(function() {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.slider.inputtak.tambah') }}"+'/'+slider_id,
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
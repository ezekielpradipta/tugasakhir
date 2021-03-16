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
            <table id="tbTak" class="table table-bordered table-striped" style="width: 100%">
                <thead>
                    <th>No.</th>
                    <th>Kegiatan</th>
                    <th>Partisipasi</th>
                    <th>Skor</th>
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
                    <h4 class="modal-title judul-tak"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="formTak" name="formTak" enctype="multipart/form-data">
                      @csrf
                        <div class="alert alert-danger" style="display:none"></div>
                        <input type="hidden" name="tak_id" id="tak_id">
                        <input type="hidden" name="kategori_val" id="kategori_val">
                        <input type="hidden" name="pilar_val" id="pilar_val">
                        <input type="hidden" name="kegiatan_val" id="kegiatan_val">
                        
                        <input type="hidden" name="partisipasi_val" id="partisipasi_val">
                        
                        <div class="form-group">
                            <label for="inputemail">Kategori</label>
                            <div class="row">
                                <div class="col-sm-8">
                                    <select name="kategoritak" id="kategoritak" class="form-control" required>
                                        <option value="">--Pilih Kategori TAK--</option>  
                                     </select>
                                </div>
                                <div class=" col-sm-2 ">
                                    <a href="javascript:void(0)" id="kategoritak-tambah" data-toggle="modaltambahkategori"  class="btn btn-primary btn-sm">
                                        <span class="fas fa-plus"></span>
                                    </a>
                                    <a href="javascript:void(0)" id="kategoritak-data" data-toggle="modal-kategori-tambah"  class="btn btn-secondary btn-sm">
                                        <span class="fas fa-cog"></span>
                                    </a>
                               </div>
                           </div>
                        </div>
                        <div class="form-group">
                        <label for="inputemail">Pilar</label>
                        <div class="row">
                            <div class="col-sm-8">
                                 <select name="pilartak" id="pilartak" class="form-control" required>
                                     <option value="">--Pilih Pilar TAK--</option>  
                                  </select>
                            </div>
                            <div class=" col-sm-2 ">
                             <a href="javascript:void(0)" id="pilartak-tambah" data-toggle="modal-pilar-tambah"  class="btn btn-primary btn-sm">
                                 <span class="fas fa-plus"></span>
                             </a>
                             <a href="javascript:void(0)" id="pilartak-data" data-toggle="modal-pilar-data"  class="btn btn-secondary btn-sm">
                                 <span class="fas fa-cog"></span>
                             </a>
                            </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="inputemail">Kegiatan</label>
                            <div class="row">
                                <div class="col-sm-8">
                                     <select name="kegiatantak" id="kegiatantak" class="form-control" required>
                                         <option value="">--Pilih Kegiatan TAK--</option>  
                                      </select>
                                </div>
                                <div class=" col-sm-2 ">
                                 <a href="javascript:void(0)" id="kegiatantak-tambah" data-toggle="modal-kegiatan-data"  class="btn btn-primary btn-sm">
                                     <span class="fas fa-plus"></span>
                                 </a>
                                 <a href="javascript:void(0)" id="kegiatantak-data" data-toggle="modal-kegiatan-data"  class="btn btn-secondary btn-sm">
                                     <span class="fas fa-cog"></span>
                                 </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputemail">Partisipasi</label>
                            <div class="row">
                                <div class="col-sm-8">
                                     <select name="partisipasitak" id="partisipasitak" class="form-control" required>
                                         <option value="">--Pilih Partisipasi TAK--</option>  
                                      </select>
                                </div>
                                <div class=" col-sm-2 ">
                                 <a href="javascript:void(0)" id="partisipasitak-tambah" data-toggle="modal-partisipasi-tambah"  class="btn btn-primary btn-sm">
                                     <span class="fas fa-plus"></span>
                                 </a>
                                 <a href="javascript:void(0)" id="partisipasitak-data" data-toggle="modal-partisipasi-data"  class="btn btn-secondary btn-sm">
                                     <span class="fas fa-cog"></span>
                                 </a>
                                </div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="">Skor TAK</label>
                            <input type="text" name="tak_score" class="form-control" id="tak_score" placeholder="Skor Tak">
                            <label class="text-danger" id="tak_scoreError"></label>
                        </div> 
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="tambah" id="save-tak">Save data</button>
                   
                </div>
            </div>
        </div>
    </div>
<!-- END Modal UTAMA -->

<!--MODAL Tambah Kategori -->
    <div class="modal hide fade" id="modal-kategori-tambah">
        <div class="modal-dialog modal-xl">
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-kategori-data"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                            <table id="tbKategori" class="table table-bordered table-striped" style="width: 100%">
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

<!--MODAL List Pilar -->
    <div class="modal hide fade" id="modal-pilar-data">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-pilar-data"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tbPilar" class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                            <th>No.</th>
                            <th>Kategori TAK</th>
                            <th>Pilar TAK</th>
                            <th>Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!--END MODAL List Pilar -->

<!--MODAL Tambah Pilar -->
    <div class="modal hide fade" id="modal-pilar-tambah">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-pilar-tambah"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-pilar-tambah" name="form-pilar-tambah" enctype="multipart/form-data">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <input type="hidden" name="pilartak_id" id="pilartak_id">
                    <input type="hidden" name="pilar_id" id="pilar_id">
                    <input type="hidden" name="pilar_kategoriselected" id="pilar_kategoriselected">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="pilar_kategori" id="pilar_kategori" class="form-control" required>
                                <option disabled selected value>--Pilih Kategori TAK--</option>  
                             </select>
                        </div>
                        <div class="form-group">
                            <label for="pilar">Nama Pilar</label>
                            <input type="text" name="pilartak_nama" class="form-control" id="pilartak_nama" placeholder="Nama Pilar">
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="tambah" id="save-pilar">Save data</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal Pilar TAK -->

<!-- Modal  List Kegiatan -->
    <div class="modal hide fade" id="modal-kegiatan-data">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-kegiatan-data"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="tbKegiatan" class="table table-bordered table-striped" style="width: 100%">
                        <thead>
                            <th>No.</th>
                            <th>Kegiatan TAK</th>
                            <th>Aksi</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal  List Kegiatan -->

<!--MODAL Tambah Kegiatan -->
    <div class="modal hide fade" id="modal-kegiatan-tambah">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title judul-kegiatan-tambah"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form-kegiatan-tambah" name="form-kegiatan-tambah" enctype="multipart/form-data">
                    @csrf
                    <div class="alert alert-danger" style="display:none"></div>
                    <input type="hidden" name="kegiatantak_id" id="kegiatantak_id">
                    <input type="hidden" name="kegiatan_id" id="kegiatan_id">
                    <input type="hidden" name="kegiatan_pilarselected" id="kegiatan_pilarselected">
                    <input type="hidden" name="kegiatan_kategoriselected" id="kegiatan_kategoriselected">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="kegiatan_kategori" id="kegiatan_kategori" class="form-control" required>
                                <option disabled selected value>--Pilih Kategori TAK--</option>  
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pilar</label>
                            <select name="kegiatan_pilar" id="kegiatan_pilar" class="form-control" required>
                                <option disabled selected value>--Pilih Pilar TAK--</option>  
                            </select>
                            <label class="text-danger" id="kegiatan_pilarError"></label>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan">Nama Kegiatan</label>
                            <input type="text" name="kegiatantak_nama" class="form-control" id="kegiatantak_nama" placeholder="Nama Kegiatan">
                            <label class="text-danger" id="kegiatanNamaError"></label>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="tambah" id="save-kegiatan">Save data</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal Kegiatan TAK -->

<!-- Modal  List Partisipasi -->
<div class="modal hide fade" id="modal-partisipasi-data">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title judul-partisipasi-data"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbPartisipasi" class="table table-bordered table-striped" style="width: 100%">
                    
                    <thead>
                        <th>No.</th>
                        <th>Kegiatan TAK</th>
                        <th>Partisipasi TAK</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Modal  List Partisipasi -->

<!--MODAL Tambah Partisipasi -->
<div class="modal hide fade" id="modal-partisipasi-tambah">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title judul-partisipasi-tambah"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form-partisipasi-tambah" name="form-partisipasi-tambah" enctype="multipart/form-data">
                @csrf
                <div class="alert alert-danger" style="display:none"></div>
                <input type="hidden" name="partisipasi_id" id="partisipasi_id">
                <input type="hidden" name="partisipasi_kegiatanselected" id="partisipasi_kegiatanselected">
                 <div class="form-group">
                    <div class="form-group">
                        <label for="">Kegiatan</label>
                        <select name="partisipasi_kegiatan" id="partisipasi_kegiatan" class="form-control" required>
                            <option disabled selected value>--Pilih Kegiatan TAK--</option>  
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Nama Partisipasi</label>
                        <input type="text" name="partisipasitak_nama" class="form-control" id="partisipasitak_nama" placeholder="Nama Partisipasi">
                        <label class="text-danger" id="partisipasiNamaError"></label>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" value="tambah" id="save-partisipasi">Save data</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Kegiatan TAK -->

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
                $('.judul-tak').html("Tambah Data TAK");
                $('#modal-default').modal('show');
            });
            var tbTak = $('#tbTak').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('admin.tak.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'kegiatantak.kegiatantak_nama',  name: 'kegiatantak.kegiatantak_nama' },
                    
                    { data: 'partisipasitak.partisipasitak_nama',  name: 'partisipasitak.partisipasitak_nama' },
                    { data: 'tak_score',  name: 'tak_score' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                

            });
            
            $('#kategoritak').ready(function(){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="kategoritak"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            }); 
                        }
                    });
            });
            
            $('#kategoritak').change(function(){
                var kategori_val = $(this).children("option:selected").val();
                $('#kategori_val').val(kategori_val);
                var urlcoba = "{{route('admin.tak.adapilar')}}".concat("/" + kategori_val);
                    $.ajax({
                        url: urlcoba,
                        type: "GET",
                        dataType : "json", 
                        success: function (data) {
                            
                            $('select[name="pilartak"]').empty();
                            $('select[name="pilartak"]').append('<option selected disabled value="">--Pilih Pilar TAK--</option>');
                            $('select[name="kegiatantak"]').empty();
                            $('select[name="kegiatantak"]').append('<option selected disabled value="">--Pilih Kegiatan TAK--</option>');
                            $('select[name="partisipasitak"]').empty();
                            $('select[name="partisipasitak"]').append('<option selected disabled value="">--Pilih Partisipasi TAK--</option>');
                            
                            $.each(data, function(id,pilartak_nama){
                                $('select[name="pilartak"]').append('<option value="'+ id +'">'+ pilartak_nama +'</option>');
                            });

                        }
                    });
            });
            $('#pilartak').change(function(){
                var pilar_val = $(this).children("option:selected").val();
                $('#pilar_val').val(pilar_val);
                var urlcoba = "{{route('admin.tak.adakegiatan')}}".concat("/" + pilar_val);
                    $.ajax({
                        url: urlcoba,
                        type: "GET",
                        dataType : "json", 
                        success: function (data) {
                            $('select[name="kegiatantak"]').empty();
                            $('select[name="kegiatantak"]').append('<option selected disabled value="">--Pilih Kegiatan TAK--</option>');
                            $('select[name="partisipasitak"]').empty();
                            $('select[name="partisipasitak"]').append('<option selected disabled value="">--Pilih Partisipasi TAK--</option>');
                            
                            $.each(data, function(id,kegiatantak_nama){
                                $('select[name="kegiatantak"]').append('<option value="'+ id +'">'+ kegiatantak_nama +'</option>');
                            });

                        }
                    });
            });
            
            $('#kegiatantak').change(function(){
                var kegiatan_val = $(this).children("option:selected").val();
                $('#kegiatan_val').val(kegiatan_val);
                var urlcoba = "{{route('admin.tak.adapartisipasi')}}".concat("/" + kegiatan_val);
                    $.ajax({
                        url: urlcoba,
                        type: "GET",
                        dataType : "json", 
                        success: function (data) {
                            
                            $('select[name="partisipasitak"]').empty();
                            $('select[name="partisipasitak"]').append('<option selected disabled value="">--Pilih Partisipasi TAK--</option>');
                            $.each(data, function(id,partisipasitak_nama){
                                $('select[name="partisipasitak"]').append('<option value="'+ id +'">'+ partisipasitak_nama +'</option>');
                            });

                        }
                    });
            });
            $('#partisipasitak').change(function(){
                var partisipasi_val = $(this).children("option:selected").val();
                $('#partisipasi_val').val(partisipasi_val);
            });
            $('#save-tak').click(function (e) {
                e.preventDefault();
                var myForm = $("#formTak")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.tak.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#formTak').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data TAK", "success");
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            tbTak.draw();
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal menambahkan Data  TAK", "error");
                            
                            $('#save-tak').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.tak-edit', function () {
                var tak_id = $(this).data('id');
                var url = "{{route('admin.tak.index')}}".concat("/" + tak_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);  
                        $('.modal-title').html("Edit Data Kategori Tak");
                        $('#save-tak').val("Update-Kategori");
                        
                        $('#modal-default').modal('show');
                        $('#tak_id').val(data.taks.id);
                        $('#kategoritak').val(data.taks.kategoritak_id); 
                        $('#kategori_val').val(data.taks.kategoritak_id);

                        $('#pilartak').html('');
                        $.each(data.pilartaks, function(id, pilartak_nama) {
                            $('#pilartak').append($('<option>', {
                                value: id,
                                text: pilartak_nama,
                                selected: id == data.taks.pilartak_id
                            }));
                        });
                        $('#pilar_val').val(data.taks.pilartak_id); 
                        $('#kegiatantak').html('');
                        $.each(data.kegiatantaks, function(id, kegiatantak_nama) {
                            $('#kegiatantak').append($('<option>', {
                                value: id,
                                text: kegiatantak_nama,
                                selected: id == data.taks.kegiatantak_id
                            }));
                        });
                        $('#kegiatan_val').val(data.taks.kegiatantak_id); 
                        $('#partisipasitak').html('');
                        $.each(data.partisipasitaks, function(id, partisipasitak_nama) {
                            $('#partisipasitak').append($('<option>', {
                                value: id,
                                text: partisipasitak_nama,
                                selected: id == data.taks.partisipasitak_id
                            }));
                        });
                        $('#partisipasi_val').val(data.taks.partisipasitak_id);
                        
                        $('#tak_score').val(data.taks.tak_score);   
                     }
                  });          
            });
        //End Utama
        //KategoriTak Script //
            $('#kategoritak-tambah').click(function(){
                $('#save-kategori').val("tambah-data-kategoriTAK");
                $('#form-kategori-tambah').trigger("reset");
                $('.judul-kategori-tambah').html("Tambah Data Kategori TAK");
                $('#modal-kategori-tambah').modal('show');
                $('#kategori_id').val('');
            });
            $('#kategoritak-data').click(function(){
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
                            
                            $('#form-kategori-tambah').trigger("reset");
                            $('#modal-kategori-tambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Kategori TAK", "success");
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            tbKategori.draw();
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal menambahkan Data Kategori TAK", "error");
                            
                            $('#save-kategori').html('Save Changes');
                        }
                    });
            });
            
            var tbKategori = $('#tbKategori').DataTable({
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
                
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                         
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
                            tbKategori.draw();
                            tbPilar.draw();
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
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

        //PilarTak Script
            $('#pilartak-data').click(function(){
                $('.judul-pilar-data').html("Data Pilar TAK");
                $('#modal-pilar-data').modal('show');
            });
           

            $('#pilartak-tambah').click(function(){
                $('#save-pilar').val("tambah-data-pilarTAK");
                $('#form-pilar-tambah').trigger("reset");
                $('#pilartak_id').val('');
                $('.judul-pilar-tambah').html("Tambah Data Pilar TAK");
                $('#modal-pilar-tambah').modal('show');
            });
            var pilar_kategori=true;
            $('#pilar_kategori').click(function(){
                if(pilar_kategori){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $('select[name="pilar_kategori"]').empty();
                            $('select[name="pilar_kategori"]').append('<option selected disabled value="">--Pilih Kategori TAK--</option>');
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="pilar_kategori"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            });

                        }
                    });
                    pilar_kategori= false;
                }
            });
            $('#pilar_kategori').ready(function(){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="pilar_kategori"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            });

                        }
                    });
            });
            $('#pilar_kategori').change(function(){
                var pilar_kategoriselected = $(this).children("option:selected").val();
                $('#pilar_kategoriselected').val(pilar_kategoriselected);
            });
            $('#save-pilar').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-pilar-tambah")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.tak.pilartak.tambah') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#form-pilar-tambah').trigger("reset");
                            $('#modal-pilar-tambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Pilar TAK", "success");
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            tbPilar.draw();
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal menambahkan Data Pilar TAK", "error");
                            
                            $('#save-pilar').html('Save Changes');
                        }
                    });
            });
            var tbPilar = $('#tbPilar').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tak.pilartak') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'kategoritak.kategoritak_nama',  name: 'kategoritak_nama' },
                    { data: 'pilartak_nama',  name: 'pilartak_nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            $('body').on('click', '.pilartak-edit', function () {
                var pilartak_id = $(this).data('id');
                var url = "{{route('admin.tak.pilartak')}}".concat("/" + pilartak_id +"/edit");
               
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                          
                        $('.judul-pilar-tambah').html("Edit Data Pilar Tak");
                        $('#save-pilar').val("Update-Kategori");
                        $('#modal-pilar-data').modal('hide');
                        $('#modal-pilar-tambah').modal('show');
                        $('#pilar_id').val(data.id);
                        $('select[name="pilar_kategori"]').val(data.kategoritak_id);
                        $('#pilartak_nama').val(data.pilartak_nama);   
                        $('#pilar_kategoriselected').val(data.kategoritak_id);   
                     }
                  });

            });
            $('body').on('click', '.pilartak-delete', function () {
                var pilartak_id = $(this).data('id');
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
                        url: "{{ route('admin.tak.pilartak.tambah') }}"+'/'+pilartak_id,
                        success: function (data) {
                            tbPilar.draw();
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
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
        //End Pilar Script

        //KegiatanTak Script
            $('#kegiatantak-data').click(function(){
                $('.judul-kegiatan-data').html("Data Kegiatan TAK");
                $('#modal-kegiatan-data').modal('show');
            });
            $('#kegiatantak-tambah').click(function(){
                $('#save-kegiatan').val("tambah-data-kegiatanTak");
                $('#form-kegiatan-tambah').trigger("reset");
                $('#kegiatantak_id').val('');
                $('.judul-kegiatan-tambah').html("Tambah Data Kegiatan TAK");
                $('#modal-kegiatan-tambah').modal('show');
            });
            var tbKegiatan = $('#tbKegiatan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tak.kegiatantak') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'kegiatantak_nama',  name: 'kegiatantak_nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            var kegiatan_kategori=true;
            $('#kegiatan_kategori').click(function(){
                if(kegiatan_kategori){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $('select[name="kegiatan_kategori"]').empty();
                            $('select[name="kegiatan_kategori"]').append('<option selected disabled value="">--Pilih Kategori TAK--</option>');
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="kegiatan_kategori"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            });

                        }
                    });
                }
                kegiatan_kategori=false;
            });
            $('#kegiatan_kategori').ready(function(){
                    $.ajax({
                        url: "{{ route('admin.tak.kategoritak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,kategoritak_nama){
                                $('select[name="kegiatan_kategori"]').append('<option value="'+ id +'">'+ kategoritak_nama +'</option>');
                            });

                        }
                    });
            });
            $('#kegiatan_pilar').ready(function(){
                $.ajax({
                    url: "{{ route('admin.tak.pilartak.cek') }}",
                    type: "GET",
                    dataType : "json",
                    
                    success: function (data) {
                        
                        $.each(data, function(id,pilartak_nama){
                            $('select[name="kegiatan_pilar"]').append('<option value="'+ id +'">'+ pilartak_nama +'</option>');
                        });

                    }
                });
            });
            $('#kegiatan_pilar').change(function(){
                var kegiatan_pilarselected = $(this).children("option:selected").val();
                $('#kegiatan_pilarselected').val(kegiatan_pilarselected);
            });
            var kegiatan_pilar=true;
            $('#kegiatan_pilar').click(function(){
                var kegiatan_kategori = $("#kegiatan_kategori").val();
                    var urlcoba = "{{route('admin.tak.adapilar')}}".concat("/" + kegiatan_kategori);
                    
                    if(kegiatan_pilar){
                    $.ajax({
                        url: urlcoba,
                        type: "GET",
                        dataType : "json", 
                        success: function (data) {
                            
                            $('select[name="kegiatan_pilar"]').empty();
                            $('select[name="kegiatan_pilar"]').append('<option selected disabled value="">--Pilih Kategori TAK--</option>');
                            $.each(data, function(id,pilartak_nama){
                                $('select[name="kegiatan_pilar"]').append('<option value="'+ id +'">'+ pilartak_nama +'</option>');
                            });

                        }
                    });
                    }
                    kegiatan_pilar=false;
            });
            $('#kegiatan_kategori').change(function(){
                var kegiatan_kategori = $(this).val(); 
                if(kegiatan_kategori)
               {
                var url = "{{route('admin.tak.adapilar')}}".concat("/" + kegiatan_kategori);
              
                $.ajax({
                    url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        
                        $('select[name="kegiatan_pilar"]').empty();
                        $('select[name="kegiatan_pilar"]').append('<option selected disabled value="">--Pilih Pilar TAK--</option>');
                        $.each(data, function(id,nama){
                           $('select[name="kegiatan_pilar"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                });
               }
                
            });
            $('#save-kegiatan').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-kegiatan-tambah")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.tak.kegiatantak.tambah') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#form-kegiatan-tambah').trigger("reset");
                            $('#modal-kegiatan-tambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Kegiatan TAK", "success");
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            tbKegiatan.draw();
                        },
                        error: function (data) {
                           
                            Command: swal("Gagal", "Gagal menambahkan Data Kegiatan TAK", "error");
                            $('#kegiatan_pilarError').text(data.responseJSON.errors.pilartak_id);
                            $('#kegiatanNamaError').text(data.responseJSON.errors.kegiatantak_nama);
                            $('#save-kegiatan').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.kegiatantak-edit', function () {
                var kegiatantak_id = $(this).data('id');
                var url = "{{route('admin.tak.kegiatantak')}}".concat("/" + kegiatantak_id +"/edit");
                
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        var len = data.length;
                       
                        $('.judul-kegiatan-tambah').html("Edit Data Kegiatan Tak");
                        $('#save-kegiatan').val("Update-Kegiatan");
                        $('#modal-kegiatan-data').modal('hide');
                        $('#modal-kegiatan-tambah').modal('show');
                        $('#kegiatan_id').val(kegiatantak_id);
                        $('select[name="kegiatan_kategori"]').val(data.pilartak.kategoritak_id);
                        $('select[name="kegiatan_pilar"]').val(data.pilartak_id);
                        $('#kegiatantak_nama').val(data.kegiatantak_nama);   
                        $('#kegiatan_kategoriselected').val(data.pilartak.kategoritak_id);
                        $('#kegiatan_pilarselected').val(data.pilartak_id);   
                     }
                  });

            });
            $('body').on('click', '.kegiatantak-delete', function () {
                var kegiatantak_id = $(this).data('id');
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
                        url: "{{ route('admin.tak.kegiatantak.tambah') }}"+'/'+kegiatantak_id,
                        success: function (data) {
                            tbKegiatan.draw();
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            
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
        //End KegiatanTak Script

        
        //partisipas tak
            $('#partisipasitak-data').click(function(){
                $('.judul-partisipasi-data').html("Data Partisipasi TAK");
                $('#modal-partisipasi-data').modal('show');
            });
            $('#partisipasitak-tambah').click(function(){
                $('#save-partisipasi').val("tambah-data-kegiatanTak");
                $('#form-partisipasi-tambah').trigger("reset");
                $('#partisipasi_id').val('');
                $('.judul-partisipasi-tambah').html("Tambah Data Partisipasi TAK");
                $('#modal-partisipasi-tambah').modal('show');
            });
            var tbPartisipasi = $('#tbPartisipasi').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.tak.partisipasitak') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'kegiatantak_nama',  name: 'kegiatantak_nama' },
                    { data: 'partisipasitak_nama',  name: 'partisipasitak_nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                ]

            });
            var partisipasi_kegiatan=true;
            $('#partisipasi_kegiatan').click(function(){
                if(partisipasi_kegiatan){
                    $.ajax({
                        url: "{{ route('admin.tak.kegiatantak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $('select[name="partisipasi_kegiatan"]').empty();
                            $('select[name="partisipasi_kegiatan"]').append('<option selected disabled value="">--Pilih Kegiatan TAK--</option>');
                            $.each(data, function(id,kegiatantak_nama){
                                $('select[name="partisipasi_kegiatan"]').append('<option value="'+ id +'">'+ kegiatantak_nama +'</option>');
                            });

                        }
                    });
                }
                partisipasi_kegiatan=false;
            });
            $('#partisipasi_kegiatan').ready(function(){
                    $.ajax({
                        url: "{{ route('admin.tak.kegiatantak.cek') }}",
                        type: "GET",
                        dataType : "json",
                        
                        success: function (data) {
                            
                            $.each(data, function(id,kegiatantak_nama){
                                $('select[name="partisipasi_kegiatan"]').append('<option value="'+ id +'">'+ kegiatantak_nama +'</option>');
                            });

                        }
                    });
            });
           
            $('#partisipasi_kegiatan').change(function(){
                var partisipasi_kegiatanselected = $(this).children("option:selected").val();
                $('#partisipasi_kegiatanselected').val(partisipasi_kegiatanselected);
            });
            $('#save-partisipasi').click(function (e) {
                e.preventDefault();
                var myForm = $("#form-partisipasi-tambah")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('admin.tak.partisipasitak.tambah') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                           
                            $('#form-partisipasi-tambah').trigger("reset");
                            $('#modal-partisipasi-tambah').modal('hide');
                            Command: swal("Sukses", "Berhasil menambahkan Data Partisipasi TAK", "success");
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            partisipasi_kegiatan=true;
                            
                            tbPartisipasi.draw();
                        },
                        error: function (data) {
                           
                            Command: swal("Gagal", "Gagal menambahkan Data Kegiatan TAK", "error");
                            $('#kegiatan_pilarError').text(data.responseJSON.errors.pilartak_id);
                            $('#partisipasiNamaError').text(data.responseJSON.errors.partisipasitak_nama);
                            $('#save-kegiatan').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.partisipasitak-edit', function () {
                var partisipasitak_id = $(this).data('id');
                var url = "{{route('admin.tak.partisipasitak')}}".concat("/" + partisipasitak_id +"/edit");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        
                       console.log(data);
                        $('.judul-partisipasi-tambah').html("Edit Data Partisipasi Tak");
                        $('#save-partisipasi').val("Update-Kegiatan");
                        $('#modal-partisipasi-data').modal('hide');
                        $('#modal-partisipasi-tambah').modal('show');
                        $('#partisipasi_id').val(partisipasitak_id);
                        $('select[name="partisipasi_kegiatan"]').val(data.kegiatantak_id);
                       
                        $('#partisipasitak_nama').val(data.partisipasitak_nama);   
                        $('#partisipasi_kegiatanselected').val(data.kegiatantak_id);
                          
                     }
                  });

            });
            $('body').on('click', '.partisipasitak-delete', function () {
                var partisipasitak_id = $(this).data('id');
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
                        url: "{{ route('admin.tak.partisipasitak.tambah') }}"+'/'+partisipasitak_id,
                        success: function (data) {
                            pilar_kategori=true;
                            
                            kegiatan_kategori = true;
                            kegiatan_pilar= true;
                            partisipasi_kegiatan=true;
                            
                            tbPartisipasi.draw();
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
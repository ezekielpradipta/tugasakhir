@extends('layouts.mahasiswa')
@section('content')
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('mahasiswa.index')}} ">Home</a></li>
                    <li class="breadcrumb-item active">Tutorial</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <h5 class="card-title m-0"> Pengajuan TAK</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <input type="hidden" id="kategoritak_id">
                            <input type="hidden" id="pilartak_id">
                            <input type="hidden" id="kegiatantak_id">
                            <input type="hidden" id="partisipasitak_id">
                            <form method="post" id="formTak" name="formTak" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Tahun Ajaran</p>
                                    <div class="col-sm-10">
                                        <select name="tahunajaran" id="tahunajaran" class="form-control" required>
                                            <option value="2016/2017">2016/2017</option>
                                            <option value="2017/2018">2017/2018</option>
                                            <option value="2018/2019">2018/2019</option>
                                            <option value="2019/2020">2019/2020</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Kategori Kegiatan</p>
                                    <div class="col-sm-10">
                                        <select name="kategoritak_id" id="kategoritak_id" class="form-control">
                                            <option value="">-- Pilih Kategori --</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Pilar Kemahsiswaan</p>
                                    <div class="col-sm-10">
                                        <select name="pilartak_id" id="pilartak_id" class="form-control">
                                            <option value="">-- NA --</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Jenis Kegiatan</p>
                                    <div class="col-sm-10">
                                        <select name="kegiatantak_id" id="kegiatantak_id" class="form-control">
                                            <option value="">-- NA --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Jenis Partisipasi</p>
                                    <div class="col-sm-10">
                                        <select name="partisipasitak_id" id="partisipasitak_id" class="form-control">
                                            <option value="">-- NA --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Bukti Partisipasi</p>
                                    <a href="#" class=" btn btn-info addrow">Tambah Bukti <i class="fa fa-plus"
                                            aria-hidden="true"></i></a>
                                </div>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="custom-file">
                                                    <input type="file" name="bukti[]" class="form-control">

                                                </div>
                                            </td>
                                            <td><a href="#" class=" btn btn-danger remove"><i class="fa fa-minus"
                                                        aria-hidden="true"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Tanggal Kegiatan</p>
                                    <div class="input-group col-sm-10">
                                        <input type="text" name="tanggalawal" placeholder="YYYY-MM-DD" id="tanggalawal"
                                            class="form-control datepicker">
                                        <div class="input-group-append"><span class="input-group-text">s/d</span></div>
                                        <input type="text" name="tanggalakhir" id="tanggalakhir"
                                            placeholder="YYYY-MM-DD" class="form-control datepicker">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Nama Kegiatan</p>
                                    <div class="input-group col-sm-10">
                                        <input type="text" name="namaindo"
                                            placeholder="Contoh : ATVSI Peduli - Seminar Jurnalistik Dan Produksi Kreatif "
                                            id="namaindo" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Nama Kegiatan(Inggris)</p>
                                    <div class="input-group col-sm-10">
                                        <input type="text" name="namainggris"
                                            placeholder="Contoh : Seminar of Journalism And Creative Production "
                                            id="namainggris" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Penyelenggara</p>
                                    <div class="input-group col-sm-10">
                                        <input type="text" name="penyelenggara"
                                            placeholder="Nama Penyelenggara Kegiatan Tersebut" id="penyelenggara"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <p class="col-sm-2 col-form-label">Deskripsi</p>
                                    <div class="input-group col-sm-10">
                                        <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class=" text-right">
                                    <a class="btn-primary btn-lg" data-toggle="modal" href="#myModal"><span
                                            class="fa fa-question-circle" style="color: white"></span></a>
                                </div>
                                <div class=" text-center">
                                    <button type="button" id="btn-save" class=" btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
    aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bantuan....</h5>
            </div>
            <div class="modal-body">
                <div id="slidehome" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                    </div>
                    <a class="carousel-control-prev" style="filter:invert(100%);" href="#slidehome" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" style="filter: invert(100%);" href="#slidehome" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready( function () {
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $('.addrow').on('click',function(e){
            addrow();
            e.preventDefault();
        });
        function addrow(){
            var tr= '<tr>'+
            '<td>'+
                '<div class="custom-file">'+
                    '<input type="file" name="bukti[]" class="form-control">'+
                      
                  '</div>'+
            '</td>'+
            '<td><a href="#" class=" btn btn-danger remove"><i class="fa fa-minus" aria-hidden="true"></i></a></td>'+
            '</tr>';
            $('tbody').append(tr);
        };
        $('tbody').on('click','.remove',function(e){
            $(this).parent().parent().remove();
            e.preventDefault();
        });
        $(".datepicker").datepicker({
         format: 'yyyy-mm-dd',
         autoclose: true,
         todayHighlight: true,
         });
        $.ajax({
                url: "{{ route('mahasiswa.slider') }}",
                type: "GET",
                dataType : "json",            
                success: function (data) {
                console.log(data);
                $('#myModal').modal('show');
                var slider1 = '<div class="carousel-item active sliderBaru">'
                + ' <img class="d-block w-100" src="../../img/'+data.slider[0].slider_image+'" class="modal-content" alt="First slide">'
                + ' <div class="modal-body">'
                + ' <p>'+data.slider[0].slider_caption+'</p>'
                + '</div>'
                + ' </div>' 
                ;
                $('.carousel-inner').append(slider1);
                for (var i = 1; i < data.slider.length; i++) {
                  var slider2=  '<div class="carousel-item">'
                + ' <img class="d-block w-100" src="../../img/'+data.slider[i].slider_image+'" class="modal-content" alt="'+[i+1]+' slide">'
                + ' <div class="modal-body">'
                + ' <p>'+data.slider[i].slider_caption+'</p>'
                + '</div>'
                + ' </div>' ;
                $('.carousel-inner').append(slider2);
                }
                for(var k=0; k<data.kategoritak.length;k++){
                    var kategoritak =
                    '<option value="'+ data.kategoritak[k].id +'">'+ data.kategoritak[k].kategoritak_nama +'</option>'
                    ;
                    $('select[name="kategoritak_id"]').append(kategoritak);
                }
                
                
                }
        });
        jQuery('select[name="kategoritak_id"]').on('change',function(){
               var kategoritak_id = jQuery(this).val();
               $('#kategoritak_id').val(kategoritak_id);
               if(kategoritak_id)
               {
                var url = "{{route('mahasiswa.tak.cekPilar')}}".concat("/" + kategoritak_id);   
                console.log(url);
                  jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="pilartak_id"]').empty();
                        jQuery('select[name="pilartak_id"]').append('<option selected disabled value="">--Pilih Pilar--</option>');
                        jQuery('select[name="kegiatantak_id"]').empty();
                        jQuery('select[name="kegiatantak_id"]').append('<option>--NA--</option>');
                       
                        jQuery('select[name="partisipasitak_id"]').empty();
                        jQuery('select[name="partisipasitak_id"]').append('<option>--NA--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="pilartak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="pilartak_id"]').empty();
                  $('select[name="pilartak_id"]').append('<option>--N/A--</option>');
                  $('select[name="kegiatantak_id"]').empty();
                  $('select[name="kegiatantak_id"]').append('<option>--N/A--</option>');
                  
                  $('select[name="partisipasitak_id"]').empty();
                  $('select[name="partisipasitak_id"]').append('<option>--N/A--</option>');
               }
        });
        jQuery('select[name="pilartak_id"]').on('change',function(){
               var pilartak_id = jQuery(this).val();
               $('#pilartak_id').val(pilartak_id);
               if(pilartak_id)
               {
                var urlPilar = "{{route('mahasiswa.tak.cekKegiatan')}}".concat("/" + pilartak_id);   
                console.log(urlPilar);
                  jQuery.ajax({
                     url : urlPilar,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="kegiatantak_id"]').empty();
                        jQuery('select[name="kegiatantak_id"]').append('<option selected disabled value="">--Pilih Kegiatan--</option>');
                        
                        jQuery('select[name="partisipasitak_id"]').empty();
                        jQuery('select[name="partisipasitak_id"]').append('<option>--NA--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="kegiatantak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="kegiatantak_id"]').empty();
                  $('select[name="kegiatantak_id"]').append('<option>--N/A--</option>');
               }
        });
        jQuery('select[name="kegiatantak_id"]').on('change',function(){
               var kegiatantak_id = jQuery(this).val();
               $('#kegiatantak_id').val(kegiatantak_id);
               if(kegiatantak_id)
               {
                var urlKegiatan = "{{route('mahasiswa.tak.cekPartisipasi')}}".concat("/" + kegiatantak_id);   
                console.log(urlKegiatan);
                  jQuery.ajax({
                     url :    urlKegiatan,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                       jQuery('select[name="partisipasitak_id"]').empty();
                        jQuery('select[name="partisipasitak_id"]').append('<option selected disabled value="">--Pilih Partisipasi--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="partisipasitak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="partisipasitak_id"]').empty();
               }
        });
        jQuery('select[name="partisipasitak_id"]').on('change',function(){
                var partisipasitak_id = jQuery(this).val();
                $('#partisipasitak_id').val(partisipasitak_id);
        });
        $('#btn-save').click(function (e) {
                e.preventDefault();
                var myForm = $("#formTak")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('mahasiswa.tutorial.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#formTak').trigger("reset");
                           
                            Command: swal("Sukses", "Berhasil", "success");
                            
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal ", "error");
                            $('#btn-save').html('Save Changes');
                        }
                    });
        });
  });
</script>

@endpush
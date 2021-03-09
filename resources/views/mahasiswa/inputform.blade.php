@if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> Data yang anda masukan tidak sesuai.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
@endif

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
                @foreach($kategoritaks as $id => $kategoritak_nama)
                    <option value="{{ $id }}">
                    {{ $kategoritak_nama }}</option>
                @endforeach
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
    <a href="#" class=" btn btn-info addrow">Tambah Bukti <i class="fa fa-plus" aria-hidden="true"></i></a>
</div>
<table class="table table-borderless">
    <tbody>
        <tr>
            <td>
                <div class="custom-file">
                    <input type="file" name="bukti[]" class="form-control" >
                      
                  </div>
            </td>
            <td><a href="#" class=" btn btn-danger remove"><i class="fa fa-minus" aria-hidden="true"></i></a></td>
        </tr>
    </tbody>
</table>
<div class="form-group row">
    <p class="col-sm-2 col-form-label">Tanggal Kegiatan</p>
    <div class="input-group col-sm-10">
        <input type="text" name="tanggalawal" placeholder="YYYY-MM-DD" id="tanggalawal" class="form-control datepicker">
        <div class="input-group-append"><span class="input-group-text">s/d</span></div>
        <input type="text" name="tanggalakhir" id="tanggalakhir" placeholder="YYYY-MM-DD" class="form-control datepicker">
    </div>
</div>
<div class="form-group row">
    <p class="col-sm-2 col-form-label">Nama Kegiatan</p>
    <div  class="input-group col-sm-10">
        <input type="text" name="namaindo" placeholder="Contoh : ATVSI Peduli - Seminar Jurnalistik Dan Produksi Kreatif " id="namaindo" class="form-control">
    </div>
</div>
<div class="form-group row">
    <p class="col-sm-2 col-form-label">Nama Kegiatan(Inggris)</p>
    <div  class="input-group col-sm-10">
    <input type="text" name="namainggris" placeholder="Contoh : ATVSI Peduli - Seminar Jurnalistik Dan Produksi Kreatif " id="namainggris" class="form-control">
    </div>
</div>
<div class="form-group row">
    <p class="col-sm-2 col-form-label">Penyelenggara</p>
    <div  class="input-group col-sm-10">
    <input type="text" name="penyelenggara" placeholder="Nama Penyelenggara Kegiatan Tersebut" id="penyelenggara" class="form-control">
    </div>
</div>
<div class="form-group row">
    <p class="col-sm-2 col-form-label">Deskripsi</p>
    <div  class="input-group col-sm-10">
    <input type="text" name="deskripsi" id="deskripsi" placeholder="Deskripsi" class="form-control">
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function(){
        
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
    });
   </script>
@endpush
@push('scripts')
<script type="text/javascript">
    var host = window.location.href;  
    jQuery(document).ready(function ()
    {
            jQuery('select[name="kategoritak_id"]').on('change',function(){
               var kategoritak_id = jQuery(this).val();
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
    });
</script>
@endpush
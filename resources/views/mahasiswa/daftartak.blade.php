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
            <li class="breadcrumb-item active">Daftar TAK</li>
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
                    <h5 class="card-title m-0"> Daftar TAK</h5>
                </div>
            </div>
            </div>
            <div class="col">
              <div class="card-body">
                <div class="form-group">
                    <label>Status:</label>
                    <select id='status' class="form-control" style="width: 200px">
                       <option value="0">Belum diACC</option>
                            <option value="1">Sudah diACC</option>
                        </select>
                    </div>
                    <table class="table table-bordered" id="dt">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kegiatan</th>
                                <th>Point</th>
                                <th>Deskripsi</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
              </div>
            </div>
            </div><!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!--Modal LIST BUKTI-->
    <div class="modal hide fade" id="modal_bukti">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title judul-bukti-data"></h4>
                 
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              
              <div class="modal-body">
               
                <input type="hidden" name="input_id" id="input_id">
                <p class=" judul-kegiatan"></p>
                <table id="tBukti" class="table table-bordered table-striped">
                  <thead>
                    <th>No.</th>
                    <th>Bukti</th> 
                  </thead>
                  <tbody></tbody>
                </table>
                <label for="error" id="buktinotfound" class="text-danger"></label>
             </div>
             <div class="modal-footer" id="add_btn_bukti">
              <a href="javascript:void(0)"data-toggle="tooltip" class="btn btn-primary btn-unduh" id="btn-unduh">Unduh Bukti</a>
              <a href="javascript:void(0)"data-toggle="tooltip" class="btn btn-primary btn-edit-bukti" id="btn-edit-bukti">Ubah Bukti</a>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
          </div>
          </div>
      </div>
  </div>
  <!--Modal Bukti -->
  <div class="modal hide fade" id="modal_edit_bukti">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title judul-bukti"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form  method="post" id="formBukti" name="formBukti" enctype="multipart/form-data">
          @csrf
          <p class=" text-danger">Mengubah Data Bukti Akan Menghapus Bukti Yang Sudah Ada!</p>
          <div class="form-group row">
            <a href="javascript:void(0)" class=" btn btn-info addrow">Tambah Bukti <i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
          <input type="hidden" name="input_id2" id="input_id2">
          <table class="table table-borderless" id="tbEditBukti">
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
          </form>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" value="tambah" id="save-bukti">Save data</button> 
        </div>
      </div>
    </div>

  </div>
  <!-- Modal UTAMA -->
    <div class="modal hide fade" id="modal-default">
      <div class="modal-dialog ">
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
                      <input type="hidden" name="inputtak_id" id="inputtak_id">
                      <input type="hidden" name="kategori_val" id="kategori_val">
                      <input type="hidden" name="pilar_val" id="pilar_val">
                      <input type="hidden" name="kegiatan_val" id="kegiatan_val">
                      <input type="hidden" name="partisipasi_val" id="partisipasi_val">
                      <div class="form-group">
                        <label for="">Tahun Ajaran</label>                         
                          <select name="tahunajaran" id="tahunajaran" class="form-control" required>
                            <option value="2016/2017">2016/2017</option>
                            <option value="2017/2018">2017/2018</option>
                            <option value="2018/2019">2018/2019</option>
                            <option value="2019/2020">2019/2020</option>
                          </select>
                    </div>
                      <div class="form-group">
                          <label for="inputemail">Kategori</label>                         
                            <select name="kategoritak" id="kategoritak" class="form-control" required>
                              <option value="">--Pilih Kategori TAK--</option>  
                            </select>
                      </div>
                      <div class="form-group">
                      <label for="inputemail">Pilar</label>
                        <select name="pilartak" id="pilartak" class="form-control" required>
                          <option value="">--Pilih Pilar TAK--</option>  
                        </select>
                      </div>
                      <div class="form-group">
                          <label for="inputemail">Kegiatan</label>
                            <select name="kegiatantak" id="kegiatantak" class="form-control" required>
                              <option value="">--Pilih Kegiatan TAK--</option>  
                            </select>                           
                      </div>
                      <div class="form-group">
                          <label for="inputemail">Partisipasi</label>
                              <select name="partisipasitak" id="partisipasitak" class="form-control" required>
                                <option value="">--Pilih Partisipasi TAK--</option>  
                              </select>
                      </div>
                      <div class="form-group">
                        <label for="">Tanggal Kegiatan</label>
                        <div class="input-group">
                            <input type="text" name="tanggalawal" placeholder="YYYY-MM-DD" id="tanggalawal" class="form-control datepicker">
                            <div class="input-group-append"><span class="input-group-text">s/d</span></div>
                            <input type="text" name="tanggalakhir" id="tanggalakhir" placeholder="YYYY-MM-DD" class="form-control datepicker">
                        </div>
                      </div> 
                      <div class="form-group">
                          <label for="">Nama Kegiatan</label>
                          <input type="text" name="namaindo" class="form-control" id="namaindo" placeholder="Skor Tak">
                          <label class="text-danger" id="tak_scoreError"></label>
                      </div>
                      <div class="form-group">
                        <label for="">Nama Kegiatan (Inggris)</label>
                        <input type="text" name="namainggris" class="form-control" id="namainggris" placeholder="Skor Tak">
                        <label class="text-danger" id="tak_scoreError"></label>
                      </div>
                      <div class="form-group">
                        <label for="">Penyelenggara</label>
                        <input type="text" name="penyelenggara" class="form-control" id="penyelenggara" placeholder="Skor Tak">
                        <label class="text-danger" id="tak_scoreError"></label>
                      </div>
                      <div class="form-group">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5"></textarea>
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
@endsection
@push('scripts')
	<script>
        $(document).ready( function () {
             $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            });
            var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mahasiswa.daftartak.index') }}",
                    data: function (d) {
                      d.status = $('#status').val() 
                      
                      }
                      },
                columns: [
                    {data: 'DT_RowIndex', searchable: false, orderable: false ,"width": "10px"},
                    { data: 'nama', name: 'nama',"width": "30%" },
                    { data: 'tak_score',  name:'tak_score',"width": "10%"},
                    { data: 'inputtak_deskripsi',  name:'inputtak_deskripsi',"width": "30%"},
                    { data: 'bukti', name: 'bukti', orderable: false, searchable: false,"width": "10px"},
                    { data: 'action', name: 'action', orderable: false, searchable: false,"width": "10%"},
                   ]
            });
            $('#status').change(function(){
              table.draw();
            });
            $('#kategoritak').ready(function(){
                    $.ajax({
                        url: "{{ route('mahasiswa.daftartak.kategoritak.cek') }}",
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
                var urlcoba = "{{route('mahasiswa.daftartak.adapilar')}}".concat("/" + kategori_val);
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
                var urlcoba = "{{route('mahasiswa.daftartak.adakegiatan')}}".concat("/" + pilar_val);
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
                var urlcoba = "{{route('mahasiswa.daftartak.adapartisipasi')}}".concat("/" + kegiatan_val);
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

            $('body').on('click', '.edit-Input', function () {
              var inputtak_id = $(this).data('id');
              var url = "{{route('mahasiswa.daftartak.index')}}".concat("/" + inputtak_id +"/edit");
              console.log(url);
              jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                       
                      $('.modal-title').html("Ubah Data Input Tak");
                      $('#modal-default').modal('show');
                      $('#pilartak').html('');
                      $.each(data.pilartaks, function(id, pilartak_nama) {
                          $('#pilartak').append($('<option>', {
                              value: id,
                              text: pilartak_nama,
                              selected: id == data.inputtaks.tak.pilartak_id
                          }));
                      });
                      $('#kegiatantak').html('');
                      $.each(data.kegiatantaks, function(id, kegiatantak_nama) {
                        $('#kegiatantak').append($('<option>', {
                              value: id,
                              text: kegiatantak_nama,
                              selected: id == data.inputtaks.tak.kegiatantak_id
                          }));
                      });
                      $('#partisipasitak').html('');
                      $.each(data.partisipasitaks, function(id, partisipasitak_nama) {
                        $('#partisipasitak').append($('<option>', {
                              value: id,
                              text: partisipasitak_nama,
                              selected: id == data.inputtaks.tak.partisipasitak_id
                          }));
                      });
                      $('#kategoritak').val(data.inputtaks.tak.kategoritak_id); 
                      $('#kategori_val').val(data.inputtaks.tak.kategoritak_id);

                      $('#pilar_val').val(data.inputtaks.tak.pilartak_id); 
                      $('#kegiatan_val').val(data.inputtaks.tak.kegiatantak_id); 
                     
                      $('#partisipasi_val').val(data.inputtaks.tak.partisipasitak_id);
                      $('#inputtak_id').val(data.inputtaks.id);
                      $('#namaindo').val(data.inputtaks.inputtak_namaindo);
                      $('#namainggris').val(data.inputtaks.inputtak_namainggris);
                      $('#deskripsi').val(data.inputtaks.inputtak_deskripsi);
                      $('#penyelenggara').val(data.inputtaks.inputtak_penyelenggara);
                      $('#tanggalawal').val(data.inputtaks.inputtak_tanggalawal);
                      $('#tanggalakhir').val(data.inputtaks.inputtak_tanggalakhir);
                      $('#tahunajaran').val(data.inputtaks.inputtak_tahunajaran);
                      $("#save-tak").show();
                      $('textarea[name="deskripsi"]').prop('disabled', false);
                      $("#tahunajaran").prop('disabled', false);
                      $("#tanggalawal").prop('disabled', false);
                      $("#tanggalakhir").prop('disabled', false);
                      $("#namaindo").prop('disabled', false);
                      $("#namainggris").prop('disabled', false);
                      $("#penyelenggara").prop('disabled', false);
                      $("#kategoritak").prop('disabled', false);
                      $("#kegiatantak").prop('disabled', false);
                      $("#pilartak").prop('disabled', false);
                      $("#partisipasitak").prop('disabled', false);
                     }
              });
             
            });
            $('body').on('click', '.show-input', function () {
              var inputtak_id = $(this).data('id');
              var url = "{{route('mahasiswa.daftartak.index')}}".concat("/" + inputtak_id +"/edit");
              console.log(url);
              jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                       
                      $('.modal-title').html("Lihat Data Tak");
                      $('#modal-default').modal('show');
                      $('#pilartak').html('');
                      $.each(data.pilartaks, function(id, pilartak_nama) {
                          $('#pilartak').append($('<option>', {
                              value: id,
                              text: pilartak_nama,
                              selected: id == data.inputtaks.tak.pilartak_id
                          }));
                      });
                      $('#kegiatantak').html('');
                      $.each(data.kegiatantaks, function(id, kegiatantak_nama) {
                        $('#kegiatantak').append($('<option>', {
                              value: id,
                              text: kegiatantak_nama,
                              selected: id == data.inputtaks.tak.kegiatantak_id
                          }));
                      });
                      $('#partisipasitak').html('');
                      $.each(data.partisipasitaks, function(id, partisipasitak_nama) {
                        $('#partisipasitak').append($('<option>', {
                              value: id,
                              text: partisipasitak_nama,
                              selected: id == data.inputtaks.tak.partisipasitak_id
                          }));
                      });
                      $('#kategoritak').val(data.inputtaks.tak.kategoritak_id); 
                      $('#kategori_val').val(data.inputtaks.tak.kategoritak_id);

                      $('#pilar_val').val(data.inputtaks.tak.pilartak_id); 
                      $('#kegiatan_val').val(data.inputtaks.tak.kegiatantak_id); 
                     
                      $('#partisipasi_val').val(data.inputtaks.tak.partisipasitak_id);
                      $('#inputtak_id').val(data.inputtaks.id);
                      $('#namaindo').val(data.inputtaks.inputtak_namaindo);
                      $('#namainggris').val(data.inputtaks.inputtak_namainggris);
                      $('#deskripsi').val(data.inputtaks.inputtak_deskripsi);
                      $('#penyelenggara').val(data.inputtaks.inputtak_penyelenggara);
                      $('#tanggalawal').val(data.inputtaks.inputtak_tanggalawal);
                      $('#tanggalakhir').val(data.inputtaks.inputtak_tanggalakhir);
                      $('#tahunajaran').val(data.inputtaks.inputtak_tahunajaran);
                      $("#save-tak").hide();
                      $('textarea[name="deskripsi"]').prop('disabled', true);
                      $("#tahunajaran").prop('disabled', true);
                      $("#tanggalawal").prop('disabled', true);
                      $("#tanggalakhir").prop('disabled', true);
                      $("#namaindo").prop('disabled', true);
                      $("#namainggris").prop('disabled', true);
                      $("#penyelenggara").prop('disabled', true);
                      $("#kategoritak").prop('disabled', true);
                      $("#kegiatantak").prop('disabled', true);
                      $("#pilartak").prop('disabled', true);
                      $("#partisipasitak").prop('disabled', true);
                     }
              });
             
            });
            $('#save-tak').click(function (e) {
                e.preventDefault();
                var myForm = $("#formTak")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('mahasiswa.daftartak.store') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#formTak').trigger("reset");
                            $('#modal-default').modal('hide');
                            Command: swal("Sukses", "Berhasil Mengubah Data Input TAK", "success");
                            table.draw();
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal mengubah Data", "error");
                            $('#save-tak').html('Save Changes');
                        }
                    });
            });
            $('body').on('click', '.delete-input', function () {
                var inputtak_id = $(this).data('id');
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
                        url: "{{ route('mahasiswa.daftartak.store') }}"+'/'+inputtak_id,
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
            $('body').on('click','.show-Bukti',function(){
              $("#buktinotfound").html("");
              $('#tBukti>tbody>tr').remove();
              $("#btn-unduh").hide();
              $("#btn-edit-bukti").hide();
              var inputtak_id = $(this).data('id');
              var url = "{{route('mahasiswa.daftartak.index')}}".concat("/" + inputtak_id +"/bukti");
              console.log(url);
              jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                       console.log(data);
                      $('.judul-bukti-data').html("Data Bukti TAK");
                      $('.judul-kegiatan').html(data.inputtaks.tak.kegiatantak.kegiatantak_nama);
                      $('#input_id').val(data.inputtaks.id);
                      if(data.gambar === "ada"){
                        for (var i = 0; i < data.images.length; i++) {
                          var obj = ' <img src="../../img/bukti/'+data.images[i]+'" class="gambar" id="gambar" width="300px" height="300px"><br>';
                          var tr= '<tr>'+
                                    '<td>'+ [i+1] +'</td>'+
                                    '<td><img src="../../img/bukti/'+data.images[i]+'" class="gambar" id="gambar" width="300px" height="300px"></td>'+
                                '</tr>';
                          $('#tBukti>tbody').append(tr);
                      }
                      $("#btn-edit-bukti").show();
                      $("#btn-unduh").show();
                      }
                      if(data.gambar==="null"){
                        $("#buktinotfound").html("Anda Perlu Mengupload Bukti Terlebih Dahulu");
                        $("#btn-edit-bukti").show();
                      }
                      if(data.status==="true"){
                        $("#btn-edit-bukti").hide();
                      }
                      $('#modal_bukti').modal('show');
                    }
              });
             
            });
            $('body').on('click','.btn-unduh',function(){
              var inputtak_id = $("#input_id").val();
              var url = "{{route('mahasiswa.daftartak.index')}}".concat("/" + inputtak_id +"/cetakBukti");
              console.log(url);
              $.ajax({
                      url: url,
                      type: 'GET',
                      success: function(response){
                        window.location = url;
                      }
                    });
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
                $('#tbEditBukti>tbody').append(tr);
            };
            $('#tbEditBukti>tbody').on('click','.remove',function(e){
              $(this).parent().parent().remove();
              e.preventDefault();
            });
            $('body').on('click','.btn-edit-bukti',function(){
              var inputtak_id = $("#input_id").val();
              var url = "{{route('mahasiswa.daftartak.index')}}".concat("/" + inputtak_id +"/editBukti");
              console.log(url);
              $.ajax({
                      url: url,
                      type: 'GET',
                      dataType : "json",
                      success: function(data){
                        
                        $('#modal_bukti').modal('hide');
                        $('#modal_edit_bukti').modal('show');
                        $('.judul-bukti').html("Ubah Bukti TAK");
                        $('#input_id2').val(data.id);
                      }
                    });
             
            });
            $('#save-bukti').click(function (e) {
                e.preventDefault();
                var myForm = $("#formBukti")[0];
                $(this).html('Sending..');
                    $.ajax({
                        data: new FormData(myForm),
                        url: "{{ route('mahasiswa.tambahBukti') }}",
                        type: "POST",
                        
                        contentType: false,
                        processData: false,
                        success: function (data) {
                            
                            $('#formBukti').trigger("reset");
                            $('#modal_edit_bukti').modal('hide');
                            Command: swal("Sukses", "Berhasil Mengubah Data Bukti", "success");
                            
                        },
                        error: function (data) {
                            
                            Command: swal("Gagal", "Gagal mengubah Data", "error");
                            $('#save-bukti').html('Save Changes');
                        }
                    });
            });
        });
    </script>
@endpush
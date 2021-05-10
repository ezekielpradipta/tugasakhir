@php
$judul = 'Daftar Mahasiswa'
@endphp
@extends('layouts.dosen')
@section('content')
@include('dosen.header',[$judul=>'judul'])
<section class="content">
  @include('dosen.alert')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"> {{$judul}}</h3>
    </div>
    <input type="hidden" id="mahasiswa" class="mahasiswa">
    <div class="card-body">

      <table id="dt" class="table table-bordered table-striped">
        <thead>
          <th>No.</th>
          <th>NIM</th>
          <th>Nama</th>
          <th>Skor TAK</th>
          <th>Aksi</th>
        </thead>
      </table>
    </div>
  </div>
</section>
<div class="modal hide fade" id="modal-tak">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title judul-tak"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tbTak" class="table table-bordered table-striped" style="width: 100%">

          <thead>
            <th>No</th>
            <th>Kegiatan</th>
            <th>Point</th>
            <th>Deskripsi</th>
            <th>Bukti</th>
            <th>Aksi</th>
          </thead>
        </table>
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
            <select name="tahunajaran" id="tahunajaran" class="form-control" disabled required>
              <option value="2016/2017">2016/2017</option>
              <option value="2017/2018">2017/2018</option>
              <option value="2018/2019">2018/2019</option>
              <option value="2019/2020">2019/2020</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputemail">Kategori</label>
            <select name="kategoritak" id="kategoritak" class="form-control" disabled required>
              <option value="">--Pilih Kategori TAK--</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputemail">Pilar</label>
            <select name="pilartak" id="pilartak" class="form-control" disabled required>
              <option value="">--Pilih Pilar TAK--</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputemail">Kegiatan</label>
            <select name="kegiatantak" id="kegiatantak" class="form-control" disabled required>
              <option value="">--Pilih Kegiatan TAK--</option>
            </select>
          </div>
          <div class="form-group">
            <label for="inputemail">Partisipasi</label>
            <select name="partisipasitak" id="partisipasitak" class="form-control" disabled required>
              <option value="">--Pilih Partisipasi TAK--</option>
            </select>
          </div>
          <div class="form-group">
            <label for="">Tanggal Kegiatan</label>
            <div class="input-group">
              <input type="text" name="tanggalawal" placeholder="YYYY-MM-DD" id="tanggalawal"
                class="form-control datepicker" disabled>
              <div class="input-group-append"><span class="input-group-text">s/d</span></div>
              <input type="text" name="tanggalakhir" id="tanggalakhir" placeholder="YYYY-MM-DD"
                class="form-control datepicker" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="">Nama Kegiatan</label>
            <input type="text" name="namaindo" class="form-control" id="namaindo"
              placeholder="Nama Kegiatan (Indonesia)" disabled>
            <label class="text-danger" id="tak_scoreError"></label>
          </div>
          <div class="form-group">
            <label for="">Nama Kegiatan (Inggris)</label>
            <input type="text" name="namainggris" class="form-control" id="namainggris"
              placeholder="Nama Kegiatan (Inggris)" disabled>
            <label class="text-danger" id="tak_scoreError"></label>
          </div>
          <div class="form-group">
            <label for="">Penyelenggara</label>
            <input type="text" name="penyelenggara" class="form-control" id="penyelenggara" placeholder="Penyelenggara"
              disabled>
            <label class="text-danger" id="tak_scoreError"></label>
          </div>
          <div class="form-group">
            <label for="">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" disabled></textarea>
          </div>

        </form>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


      </div>
    </div>
  </div>
</div>
<!-- END Modal UTAMA -->
<!-- Modal Bukti-->
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
        <a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-primary btn-unduh" id="btn-unduh">Unduh
          Bukti</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
  $(document).ready(function(){
            var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dosen.daftarmahasiswa.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'mahasiswa_nim',  name: 'mahasiswa_nim' },
                    { data: 'mahasiswa_nama',  name: 'mahasiswa_nama' },
                    { data: 'score',  name: 'score' },
                    { data: 'action', name: 'action', orderable: false, searchable: false,"width": "10%"},
                ]

            });
            var tbtak = $('#tbTak').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dosen.daftarmahasiswa.tak') }}",
                    data: function (d) {
                      d.mahasiswa = $('#mahasiswa').val() 
                      
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
            $('body').on('click', '.show-Tak', function () {
              var inputtak_id = $(this).data('id');
              var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + inputtak_id +"/edit");
              console.log(url);
              jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        $("#mahasiswa").val(data.mahasiswa.id);
                        $('.judul-tak').html("Data TAK terACC");
                        $('#modal-tak').modal('show');
                        tbtak.draw();
                      
                     }
              });
             
            });
            $('body').on('click', '.btn-edit', function () {
                var inputtak_id = $(this).data('id');
                var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + inputtak_id +"/tak");
                console.log(url);
                jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                       console.log(data);
                      $('.modal-title').html("Lihat Data Tak");
                      $('#modal-default').modal('show');
                      $('#kategoritak').html('');
                      $.each(data.kategoritaks, function(id, kategoritak_nama) {
                          $('#kategoritak').append($('<option>', {
                              value: id,
                              text: kategoritak_nama,
                              selected: id == data.inputtaks.tak.kategoritak_id
                          }));
                      });
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
                     
                      
                     }
              });
            });
            $('body').on('click','.show-Bukti',function(){
              $("#buktinotfound").html("");
              $('#tBukti>tbody>tr').remove();
              $("#btn-unduh").hide();
              $("#btn-edit-bukti").hide();
              var inputtak_id = $(this).data('id');
              var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + inputtak_id +"/bukti");
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
              var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + inputtak_id +"/cetakBukti");
              console.log(url);
              $.ajax({
                      url: url,
                      type: 'GET',
                      success: function(response){
                        window.location = url;
                      }
                    });
            });
            $('body').on('click','.btn-status',function(){
              var inputtak_id = $(this).data('id');
              var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + inputtak_id +"/status");
              console.log(url);
              swal({
                title: 'Apakah anda yakin?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
                }).then(function() {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType : "json",
                        success: function (data) {
                          $('#modal-tak').modal('hide');
                          table.draw();
                            swal(
                                'Berhasil!',
                               
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            swal(
                                'Kesalahan!',
                                'warning'
                            );
                        }

                    });
                
                })
            });
            $('body').on('click','.btn-validasi',function(){
              var mahasiswa_id = $(this).data('id');
              var url = "{{route('dosen.daftarmahasiswa.index')}}".concat("/" + mahasiswa_id +"/validasi");
             
              swal({
                title: 'Apakah anda yakin?',
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Lanjut',
                cancelButtonText: 'Batal'
                }).then(function() {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType : "json",
                        success: function (data) {
                          $('#modal-tak').modal('hide');
                         
                            swal(
                                'Berhasil!',
                               
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            swal(
                                'Kesalahan!',
                                'warning'
                            );
                        }

                    });
                
                })
            });
        });
</script>

@endpush
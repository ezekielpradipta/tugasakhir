@php
$judul = 'Daftar Tak'
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
					<th>Aktivitas</th>
					<th>Deskripsi</th>
					<th>Skor</th>
					<th>Bukti</th>
					<th>Aksi</th>
				</thead>
			</table>
		</div>
	</div>
</section>
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
				<a href="javascript:void(0)" data-toggle="tooltip" class="btn btn-primary btn-unduh"
					id="btn-unduh">Unduh Bukti</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
						<select name="tahunajaran" id="tahunajaran" class="form-control"  required>
							<option value="2016/2017">2016/2017</option>
							<option value="2017/2018">2017/2018</option>
							<option value="2018/2019">2018/2019</option>
							<option value="2019/2020">2019/2020</option>
						</select>
					</div>
					<div class="form-group">
						<label for="inputemail">Kategori</label>
						<select name="kategoritak" id="kategoritak" class="form-control"  required>
							<option value="">--Pilih Kategori TAK--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="inputemail">Pilar</label>
						<select name="pilartak" id="pilartak" class="form-control"  required>
							<option value="">--Pilih Pilar TAK--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="inputemail">Kegiatan</label>
						<select name="kegiatantak" id="kegiatantak" class="form-control"  required>
							<option value="">--Pilih Kegiatan TAK--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="inputemail">Partisipasi</label>
						<select name="partisipasitak" id="partisipasitak" class="form-control"  required>
							<option value="">--Pilih Partisipasi TAK--</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">Tanggal Kegiatan</label>
						<div class="input-group">
							<input type="text" name="tanggalawal" placeholder="YYYY-MM-DD" id="tanggalawal"
								class="form-control datepicker" >
							<div class="input-group-append"><span class="input-group-text">s/d</span></div>
							<input type="text" name="tanggalakhir" id="tanggalakhir" placeholder="YYYY-MM-DD"
								class="form-control datepicker" >
						</div>
					</div>
					<div class="form-group">
						<label for="">Nama Kegiatan</label>
						<input type="text" name="namaindo" class="form-control" id="namaindo"
							placeholder="Nama Kegiatan (Indonesia)" >
						<label class="text-danger" id="tak_scoreError"></label>
					</div>
					<div class="form-group">
						<label for="">Nama Kegiatan (Inggris)</label>
						<input type="text" name="namainggris" class="form-control" id="namainggris"
							placeholder="Nama Kegiatan (Inggris)" >
						<label class="text-danger" id="tak_scoreError"></label>
					</div>
					<div class="form-group">
						<label for="">Penyelenggara</label>
						<input type="text" name="penyelenggara" class="form-control" id="penyelenggara"
							placeholder="Penyelenggara" >
						<label class="text-danger" id="tak_scoreError"></label>
					</div>
					<div class="form-group">
						<label for="">Deskripsi</label>
						<textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" ></textarea>
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
	$(document).ready(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
			var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dosen.takmasuk.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'mahasiswa_nim',  name: 'mahasiswa_nim' },
                    { data: 'nama',  name: 'nama' },
					{ data: 'inputtak_deskripsi',  name: 'inputtak_deskripsi' },
					{ data: 'tak_score',  name: 'tak_score' },
					{ data: 'bukti',  name: 'bukti',orderable: false, searchable: false, },
                    { data: 'action', name: 'action', orderable: false, searchable: false,"width": "10%"},
                ]

            });
			$('body').on('click','.show-Bukti',function(){
              $("#buktinotfound").html("");
              $('#tBukti>tbody>tr').remove();
              $("#btn-unduh").hide();
              $("#btn-edit-bukti").hide();
              var inputtak_id = $(this).data('id');
              var url = "{{route('dosen.takmasuk.index')}}".concat("/" + inputtak_id +"/bukti");
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
              var url = "{{route('dosen.takmasuk.index')}}".concat("/" + inputtak_id +"/cetakBukti");
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
              var url = "{{route('dosen.takmasuk.index')}}".concat("/" + inputtak_id +"/status");
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
                                'TAK Berhasil diACC',
                                'success'
                            );
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            swal(
                                'Kesalahan!',
                                'TAK Gagal diACC',
                                'warning'
                            );
                        }

                    });
                
                })
            });
			$('body').on('click', '.btn-edit', function () {
                var inputtak_id = $(this).data('id');
                var url = "{{route('dosen.takmasuk.index')}}".concat("/" + inputtak_id +"/edit");
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
            $('#kategoritak').ready(function(){
                    $.ajax({
                        url: "{{ route('dosen.takmasuk.kategoritak.cek') }}",
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
                var urlcoba = "{{route('dosen.takmasuk.adapilar')}}".concat("/" + kategori_val);
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
                var urlcoba = "{{route('dosen.takmasuk.adakegiatan')}}".concat("/" + pilar_val);
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
                var urlcoba = "{{route('dosen.takmasuk.adapartisipasi')}}".concat("/" + kegiatan_val);
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
                        url: "{{ route('dosen.takmasuk.store') }}",
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
            $('body').on('click', '.btn-delete', function () {
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
                        url: "{{ route('dosen.takmasuk.store') }}"+'/'+inputtak_id,
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
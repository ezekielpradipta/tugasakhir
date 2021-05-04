@extends('layouts.mahasiswa')
@section('content')
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black;
    }
</style>
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('mahasiswa.index')}} ">Home</a></li>
                    <li class="breadcrumb-item active">Validasi</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-10">
                                <h5 class="card-title m-0">Request Surat Keterangan</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <form method="post" id="form" name="form" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="hidden_image" id="hidden_image">

                                <div class="card-body">
                                    <p class="">Silahkan pilih maksimal 5 TAK untuk dimuat kedalam Surat
                                        Keterangan Lulus TAK</p>
                                    <select class="dropdowns form-control" name="taks[]" multiple="multiple">

                                    </select>

                                </div>

                                <div class=" text-center">
                                    <button type="button" id="btn-save" class=" btn btn-primary">Submit</button>
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
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".dropdowns").select2({
            tags: true,
           
            maximumSelectionLength: 5
        });
        $.ajax({
            url: "{{ route('mahasiswa.validasi') }}",
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data);
                for (var k = 0; k < data.data.length; k++) {
                    var tak =
                        '<option value="' + data.data[k].id + '">' + data.data[k]
                        .kegiatantak_nama +" (" +data.data[k]
                        .partisipasitak_nama+ ")"+ '</option>';
                    $('select[name="taks[]"]').append(tak);
                }
            }
        });
    });

</script>
@endpush
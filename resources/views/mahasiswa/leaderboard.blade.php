@extends('layouts.mahasiswa')
@section('content')
<style>
    .notif-badge {
        position: relative;
        width: 40px;
        top: -0.5rem;
        left: 0.5rem;

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
                    <li class="breadcrumb-item active">LeaderBoard</li>
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
                                <h5 class="card-title m-0"> LeaderBoard</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body">
                            <table class="table table-bordered" id="dt">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Point</th>
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

@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        var table = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false,
                "bAutoWidth": false,
                ajax: "{{ route('mahasiswa.leaderboard.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { data: 'nama',  name: 'nama' },
                    { data: 'score',  name: 'score' },
                ]

        });
    });
</script>
@endpush
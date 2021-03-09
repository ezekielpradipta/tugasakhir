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
              <li class="breadcrumb-item active">Input TAK</li>
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
                <form  method="post" enctype="multipart/form-data" action="{{route('mahasiswa.inputtak.store')}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  @include('mahasiswa.inputform')  
                <div class=" form-row">
                  <button type="submit" class=" btn btn-primary">Input TAK</button>
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
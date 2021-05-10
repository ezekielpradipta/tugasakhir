@php
$judul = 'Dashboard';
@endphp

@extends('layouts.dosen')

@section('judul') {{ $judul }} @endsection
@section('content')
@include('admin.header',['$judul'=>'judul'])

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
@php
$judul = 'Dashboard';
@endphp

@extends('layouts.admin')

@section('judul') {{ $judul }} @endsection
@section('content')
@include('admin.header',['$judul'=>'judul'])

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
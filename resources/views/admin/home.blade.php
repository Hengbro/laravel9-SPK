@extends('layouts.app')
@section('title', 'SPK Metode SAW')
@section('css')
<!-- Custom styles for this page -->
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')

<div class="container-fluid">

        <!-- Content Row -->
        <div class="row">

            <!-- List Karyawan Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('alternatif.index') }}">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah Karyawan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $alternatif }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('kriteria.index') }}">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Kriteria</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kriteria }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-code fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

           <!-- Earnings (Monthly) Card Example -->
           <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('penilaian.index') }}">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                
                                <div class="h5 mb-0 font-weight-bold text-gray-800">Penilaian</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-bell fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <a href="{{ route('perhitungan.index') }}">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Perhitungan SAW</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Page Heading -->
        <div class="text-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Selamat Datang di Halaman Utama</h1>
            <h2 class="h3 mb-0 text-gray-800">Sistem Pendukung Keputusan, Penilaian Kinerja Karyawan</h2>
        </div>
         <!-- Image Centered -->
    <div class="text-center mb-4">
        <img src="{{ asset('storage/karyawan.jpg') }}" alt="Karyawan" class="img-fluid" style="max-width: 600px; height: 400px;">
    </div>
</div>
@endsection

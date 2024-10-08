@extends('layouts.app')
@section('title', 'SPK Metode SAW')
@section('content')
        
        <div class="mb-4">
            <!-- Card Header - Accordion -->
            <div class="row">
                <div class="col">
                    <a href="{{ URL::to('download-perhitungan-pdf') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right"><i
                        class="fas fa-download fa-sm text-white-50"></i>Download Laporan</a>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tahap Analisa</h6>
                </a>

            <!-- Card Content - Collapse -->
            <div class="collapse show" id="listkriteria">
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Alternatif</th>
                                        @foreach ($kriteria as $key => $value)
                                            <th>{{ $value->nama_kriteria }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
    @foreach ($alternatif as $alt => $valt)
        <tr>
            <td>{{ $valt->nama_alternatif }}</td>
            @if (count($valt->penilaian) > 0)
                @foreach($valt->penilaian as $key => $value)
                    <td>{{ $value->nilai }}</td>
                @endforeach
            @else
                <td colspan="{{ count($kriteria) }}">Tidak ada penilaian</td>
            @endif
        </tr>
    @endforeach
    @if ($alternatif->isEmpty())
        <tr>
            <td colspan="{{ count($kriteria) + 1 }}">Tidak ada data!</td>
        </tr>
    @endif
</tbody>

                            </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Normalisasi</h6>
            </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="normalisasi">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif / Kriteria</th>
                            @foreach ($kriteria as $key => $value)
                                <th>{{ $value->nama_kriteria }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($normalisasi as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                @foreach($value as $key_1 => $value_1)
                                    <td>
                                        {{-- Tampilkan semua nilai, atau tambahkan logika khusus jika diperlukan --}}
                                        {{ $value_1 }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Card Header - Accordion -->
        <a href="#fuzzy" class="d-block card-header py-3" data-toggle="collapse"
                role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Perhitungan Fuzzy</h6>
                </a>
    <div class="card-body", id="fuzzy">
    <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Alternatif</th>
            <th>Detail Perhitungan</th>
            <th>Hasil Fuzzy</th>
        </tr>
    </thead>
    <tbody>
        @foreach($fuzzyValues as $namaAlternatif => $nilaiFuzzy)
            <tr>
                <td>{{ $namaAlternatif }}</td>
                <td>
                    @foreach($fuzzyDetails[$namaAlternatif] as $detail)
                        <p>{{ $detail }}</p>
                    @endforeach
                </td>
                <td>{{ number_format($nilaiFuzzy, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

    </div>


    </div>
</div>

        <div class="card shadow mb-4">
            <!-- Card Header - Accordion -->
            <a href="#rank" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Perangkingan</h6>
            </a>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="rank">
            <div class="card-body">
                <div class="table-responsive">
                @php
    $totals = []; // Array untuk menyimpan total
@endphp

@foreach($sortedData as $key => $value)
    @php 
        $total = 0;  // Inisialisasi total untuk setiap baris
    @endphp
    @foreach($value as $value_1)
        @php 
            $total += $value_1;  // Tambahkan nilai ke total
        @endphp
    @endforeach
    @php 
        $totals[$key] = $total; // Simpan total dalam array
    @endphp
@endforeach

<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2" style="text-align: center; padding-bottom: 40px">Nama / Bobot</th>
            @foreach ($kriteria as $value)
                <th>{{ $value->nama_kriteria }}</th>
            @endforeach
            <th rowspan="2" style="text-align: center; padding-bottom: 40px">Format</th>
            <th rowspan="2" style="text-align: center; padding-bottom: 40px">Total</th>
            <th rowspan="2" style="text-align: center; padding-bottom: 40px">Rank</th>
        </tr>
        <tr>
            @foreach ($kriteria as $key => $value)
                <th>{{ $value->bobot }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach($totals as $key => $total)
            <tr>
                <td>{{ $key }}</td>
                @foreach($sortedData[$key] as $value_1)
                    <td>{{ number_format($value_1, 1) }}</td>
                @endforeach
                <td>{{ number_format($total, 1) }}</td>  {{-- Tampilkan total --}}
                <td>{{ $no++ }}</td>  {{-- Tampilkan rank --}}
            </tr>
        @endforeach
    </tbody>
</table>

                </div>
            </div>
        </div>
    </div>

@stop
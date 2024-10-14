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
    <a href="#detailPerhitungan" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan Normalisasi Tahap 1</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="detailPerhitungan">
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
                        @foreach ($detailPerhitungan as $nama_alternatif => $nilai_kriteria)
                            <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @foreach($nilai_kriteria as $id_kriteria => $detail)
                                    <td>{{ $detail }}</td>
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
    <a href="#hasilNormalisasi" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Normalisasi Tahap 1</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="hasilNormalisasi">
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
                        @foreach ($fuzzyNormalisasi as $nama_alternatif => $nilai_kriteria)
                            <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @foreach($nilai_kriteria as $id_kriteria => $nilai)
                                    <td>{{ number_format($nilai, 2) }}</td>
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
    <a href="#detailPerhitunganTahapDua" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan Normalisasi Tahap 2</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="detailPerhitunganTahapDua">
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
                        @foreach ($detailPerhitunganTahapDua as $nama_alternatif => $nilai_kriteria)
                            <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @foreach($nilai_kriteria as $id_kriteria => $detail)
                                    <td>{{ $detail }}</td>
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
    <a href="#hasilNormalisasiTahapDua" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Hasil Normalisasi Tahap 2</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="hasilNormalisasiTahapDua">
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
                        @foreach ($normalisasiTahapDua as $nama_alternatif => $nilai_kriteria)
                            <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @foreach($nilai_kriteria as $id_kriteria => $nilai)
                                    <td>{{ number_format($nilai, 2) }}</td>
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
            <th>Detail Perhitungan Hasil</th>
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
            <td>
                {!! nl2br($nilaiFuzzy['detail']) !!} 
            </td>
            <td>{{ number_format($nilaiFuzzy['hasil'], 2) }}</td>
        </tr>
    @endforeach
</tbody>

</table>

    </div>


    </div>
</div>

<div class="card shadow mb-4">
    <!-- Card Header - Accordion -->
    <a href="#detailPerhitunganTahapTiga" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan Normalisasi Tahap 3</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="detailPerhitunganTahapTiga">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Alternatif / Kriteria</th>
                            @foreach ($kriteria as $value)
                                <th>{{ $value->nama_kriteria }}</th>
                            @endforeach
                            <th>Total</th> <!-- Menambahkan kolom untuk Total -->
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totals = []; // Array untuk menyimpan total
                        @endphp

                        @foreach ($detailPerhitunganTahapTiga as $nama_alternatif => $nilai_kriteria)
                            <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @php 
                                    $total = 0;
                                @endphp

                                @foreach($nilai_kriteria as $id_kriteria => $detail)
                                    <td>{{ $detail }}</td>
                                    @php
                                        // Tambahkan nilai ke total
                                        $total += $normalisasiTahapTiga[$nama_alternatif][$id_kriteria];
                                    @endphp
                                @endforeach
                                <td>{{ number_format($total, 4) }}</td> <!-- Tampilkan Total -->
                                @php
                                    $totals[$nama_alternatif] = $total; // Simpan total dalam array
                                @endphp
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
    <a href="#rank" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Tahap Perangkingan</h6>
    </a>

    <!-- Card Content - Collapse -->
    <div class="collapse show" id="rank">
        <div class="card-body">
            <div class="table-responsive">
                @php
                    // Urutkan total dari yang terbesar ke terkecil
                    arsort($totals);
                @endphp

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Alternatif</th>
                            <th>Total</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $rank = 1; @endphp
                        @foreach($totals as $key => $total)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ number_format($total, 4) }}</td>  {{-- Tampilkan total --}}
                                <td>{{ $rank++ }}</td> {{-- Tampilkan ranking --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




@stop
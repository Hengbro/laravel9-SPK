@extends('layouts.app')
@section('title', 'SPK Metode SAW')
@section('content')

<div class="mb-4">
    <div class="row">
        <div class="col">
            <form method="GET" action="{{ route('perhitungan.filter') }}">
                <div class="form-group">
                    <label for="periode">Pilih Periode:</label>
                    <select name="periode" id="periode" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Periode --</option>
                        @foreach ($periode as $periodeItem)
                            <option value="{{ $periodeItem->periode }}" {{ request('periode') == $periodeItem->periode ? 'selected' : '' }}>
                                {{ $periodeItem->periode }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="col">
            <a href="#" id="downloadLink" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right">
                <i class="fas fa-download fa-sm text-white-50"></i> Download Laporan
            </a>
        </div>
    </div>
</div>

<script>
    document.getElementById('downloadLink').addEventListener('click', function(event) {
        var periode = document.getElementById('periode').value;
        if (!periode) {
            // Tampilkan popup jika periode belum dipilih
            alert('Pilih periode dahulu sebelum mendownload laporan.');
            event.preventDefault(); // Mencegah tindakan default (navigasi link)
        } else {
            // Lanjutkan jika periode sudah dipilih
            window.location.href = "{{ URL::to('download-perhitungan-pdf') }}" + "?periode=" + encodeURIComponent(periode);
        }
    });
</script>



    <!-- Pesan Jika Tidak Ada Data -->
    @if(session('msg'))
        <div class="alert alert-warning">
            {{ session('msg') }}
        </div>
    @endif

    <!-- Cek jika $alternatif ada -->
    @if(isset($alternatif) && !$alternatif->isEmpty())
        <div class="card shadow mb-4">
            <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Tahap Analisa</h6>
            </a>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilan Detail Perhitungan dan Normalisasi -->
        <div class="card shadow mb-4">
            <a href="#hasilNormalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Detail Normalisasi Tahap 1</h6>
            </a>
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
                                @foreach ($detailPerhitungan as $nama_alternatif => $nilai_kriteria)
                                <tr>
                                <td>{{ $nama_alternatif }}</td>
                                @foreach($nilai_kriteria as $id_kriteria => $nilai)
                                    <td>{{ $nilai }}</td>
                                @endforeach
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilan Hasil Perhitungan dan Normalisasi -->
        <div class="card shadow mb-4">
            <a href="#hasilNormalisasi" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                <h6 class="m-0 font-weight-bold text-primary">Hasil Normalisasi Tahap 1</h6>
            </a>
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

        <div class="container-fluid">
    <!-- Detail Perhitungan Normalisasi Tahap 2 -->
    <div class="card shadow mb-4">
        <a href="#detailPerhitunganTahapDua" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="detailPerhitunganTahapDua">
            <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan Normalisasi Tahap 2</h6>
        </a>
        <div class="collapse show" id="detailPerhitunganTahapDua">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif / Kriteria</th>
                                @foreach ($kriteria as $value)
                                    <th>{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPerhitunganTahapDua as $nama_alternatif => $nilai_kriteria)
                                <tr>
                                    <td>{{ $nama_alternatif }}</td>
                                    @foreach($nilai_kriteria as $detail)
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

    <!-- Hasil Normalisasi Tahap 2 -->
    <div class="card shadow mb-4">
        <a href="#hasilNormalisasiTahapDua" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="hasilNormalisasiTahapDua">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Normalisasi Tahap 2</h6>
        </a>
        <div class="collapse show" id="hasilNormalisasiTahapDua">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif / Kriteria</th>
                                @foreach ($kriteria as $value)
                                    <th>{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalisasiTahapDua as $nama_alternatif => $nilai_kriteria)
                                <tr>
                                    <td>{{ $nama_alternatif }}</td>
                                    @foreach($nilai_kriteria as $nilai)
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

    <!-- Detail Perhitungan Normalisasi Tahap 3 -->
    <div class="card shadow mb-4">
        <a href="#detailPerhitunganTahapTiga" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="detailPerhitunganTahapTiga">
            <h6 class="m-0 font-weight-bold text-primary">Detail Perhitungan Normalisasi Tahap 3</h6>
        </a>
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
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totals = [];
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
                                            $total += $normalisasiTahapTiga[$nama_alternatif][$id_kriteria];
                                        @endphp
                                    @endforeach
                                    <td>{{ number_format($total, 4) }}</td>
                                    @php
                                        $totals[$nama_alternatif] = $total;
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tahap Perangkingan -->
    <div class="card shadow mb-4">
        <a href="#rank" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="rank">
            <h6 class="m-0 font-weight-bold text-primary">Tahap Perangkingan</h6>
        </a>
        <div class="collapse show" id="rank">
            <div class="card-body">
                <div class="table-responsive">
                    @php
                        arsort($totals);
                        $topAlternatifs = array_slice($totals, 0, 5, true);
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
                                    <td>{{ number_format($total, 4) }}</td>
                                    <td>{{ $rank++ }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Kesimpulan -->
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Kesimpulan:</h6>
                        <p>
                            Dari tabel di atas dapat disimpulkan bahwa peluang terbesar yang akan terpilih
                            menjadi Karyawan terbaik diperoleh oleh:
                            @foreach($topAlternatifs as $alt => $value)
                                {{ $alt }} dengan nilai {{ number_format($value, 4) }}{{ $loop->last ? '.' : ',' }}
                            @endforeach 
                            Untuk lebih jelasnya, dapat dilihat pada tabel di atas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    @else
        <div class="alert alert-info">
            Tidak ada data untuk periode yang dipilih.
        </div>
    @endif

@stop

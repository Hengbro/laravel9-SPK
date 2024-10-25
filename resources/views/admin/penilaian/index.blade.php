@extends('layouts.app')
@section('title', 'SPK Metode SAW')
@section('content')

<div class="mb-4">
    <div class="row">
        <div class="col">
            <a href="{{ URL::to('download-penilaian-pdf') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm float-right"><i
                class="fas fa-download fa-sm text-white-50"></i>Download Laporan</a>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse"
    role="button" aria-expanded="true" aria-controls="collapseCardExample">
        <h6 class="m-0 font-weight-bold text-primary">Penilaian Alternatif</h6>
    </a>

    <div class="collapse show" id="listkriteria">
        <div class="card-body">
            @if (Session::has('msg'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Info</strong> {{ Session::get('msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="table-responsive">
                <form action="{{ route('penilaian.store')}}" method="post">
                    @csrf
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan Periode:</label>
                        <select class="form-control" id="bulan" name="bulan" required style="width: 500px;"> <!-- Atur lebar menggunakan style -->
                            <option value="" disabled selected>Pilih bulan</option>
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="Agustus">Agustus</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun Periode:</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Masukkan tahun" required style="width: 500px;"> <!-- Atur lebar menggunakan style -->
                    </div>
                    <br><br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Alternatif</th>
                                @foreach ($kriteria as $key => $value)
                                    <th>{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alternatif as $alt => $valt)
                            <tr>
                            <td>{{ $valt->nama_alternatif }}</td>
                                @foreach($kriteria as $key => $value)
                                    <td>
                                        <input type="hidden" name="crips_id[{{$valt->id}}][{{$key}}][kriteria_id]" value="{{ $value->id }}">
                                        <input type="text" name="crips_id[{{$valt->id}}][{{$key}}][kriteria_value]" class="form-control" 
                                            value="{{ isset($valt->penilaian[$key]) ? $valt->penilaian[$key]->crips_id : '' }}">
                                    </td>
                                @endforeach

                            </tr>
                            @empty
                            <tr>
                                <td>Tidak ada data!</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@stop

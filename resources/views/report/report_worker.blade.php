@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/report/report_worker/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Laporan Pegawai</h4>
      <div class="d-flex justify-content-start">
        <div class="input-group">
          <input type="text" name="search" class="form-control search-barang" placeholder="Cari Pegawai">
          <div class="input-group-append">
            <button class="btn btn-search"><i class="mdi mdi-magnify"></i></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-custom">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Posisi</th>
                  <th>Aktivitas Pasok</th>
                  <th>Aktivitas Transaksi</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>
                    <img src="{{ asset('pictures/' . $user->foto) }}">
                    <span class="ml-2">{{ $user->nama }}</span>
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if($user->role == 'admin')
                    <span class="btn admin-span">{{ $user->role }}</span>
                    @else
                    <span class="btn kasir-span">{{ $user->role }}</span>
                    @endif
                  </td>
                  @php
                  $pasok = \App\Supply::where('id_user', $user->id)
                  ->count();
                  @endphp
                  <td class="pl-4"><span class="ammount-box bg-secondary"><i class="mdi mdi-import"></i></span>{{ $pasok
                    }} X</td>
                  @php
                  $transaksi = \App\Transaction::where('id_user', $user->id)
                  ->select('kode_transaksi')
                  ->distinct()
                  ->get();
                  @endphp
                  <td class="pl-4"><span class="ammount-box bg-secondary"><i
                        class="mdi mdi-swap-horizontal"></i></span>{{ $transaksi->count() }} X</td>
                  <td>
                    <a href="{{ url('/report/workers/detail/' . $user->id) }}" class="btn view-btn"><i
                        class="mdi mdi-eye"></i> Lihat</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/report/report_worker/script.js') }}"></script>
@endsection
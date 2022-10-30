@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/supply/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Riwayat Pasok</h4>
      <div class="d-flex justify-content-start">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i class="mdi mdi-export print-icon"></i>
          </div>
          <button class="btn btn-print" type="button" data-toggle="modal" data-target="#cetakModal">Export
            Laporan</button>
        </div>
        {{-- <a href="{{ url('/supply/statistics') }}"
          class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2">
          <i class="mdi mdi-poll"></i>
        </a> --}}
        <div class="dropdown dropdown-search">
          <button class="btn btn-icons btn-inverse-primary btn-filter shadow-sm ml-2" type="button"
            id="dropdownMenuIconButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="mdi mdi-magnify"></i>
          </button>
          <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuIconButton1">
            <div class="row">
              <div class="col-11">
                <input type="text" class="form-control" name="search" placeholder="Cari barang">
              </div>
            </div>
          </div>
        </div>
        <a href="{{ url('/supply/new') }}" class="btn btn-icons btn-inverse-primary btn-new ml-2">
          <i class="mdi mdi-plus"></i>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="modal fade" id="cetakModal" tabindex="-1" role="dialog" aria-labelledby="cetakModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cetakModalLabel">Export Laporan</h5>
          <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ url('/supply/statistics/export') }}" name="export_form" method="POST" target="_blank">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="form-group row" hidden="">
                  <div class="col-5 border rounded-left offset-col-1">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="period" checked>
                        Periode</label>
                    </div>
                  </div>
                  <div class="col-5 border rounded-right">
                    <div class="form-radio">
                      <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="jns_laporan" value="manual"> Manual</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 period-form">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih waktu dan periode</p>
                  </div>
                  <div class="col-4 p-0 offset-col-1">
                    <input type="number"
                      class="form-control form-control-lg time-input number-input dis-backspace input-notzero"
                      name="time" value="1" min="1" max="4">
                  </div>
                  <div class="col-6 p-0">
                    <select class="form-control form-control-lg period-select" name="period">
                      <option value="minggu" selected="">Minggu</option>
                      <option value="bulan">Bulan</option>
                      <option value="tahun">Tahun</option>
                    </select>
                  </div>
                </div>
              </div>
              {{-- <div class="col-12 manual-form" hidden="">
                <div class="form-group row">
                  <div class="col-10 p-0 offset-col-1">
                    <p>Pilih tanggal awal dan akhir</p>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group mb-2">
                    <input type="text" name="tgl_awal_export" class="form-control form-control-lg date"
                      placeholder="Tanggal awal">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                  <div class="col-10 p-0 offset-col-1 input-group">
                    <input type="text" name="tgl_akhir_export" class="form-control form-control-lg date"
                      placeholder="Tanggal akhir">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <i class="mdi mdi-calendar calendar-icon"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-export">Export</button>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 grid-margin">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <ul class="list-date">
              @foreach($dates as $date)
              <li class="txt-light">{{ date('d M, Y', strtotime($date)) }}</li>
              @php
              $supplies = \App\Supply::whereDate('pasok.created_at', $date)
              ->select('pasok.*')
              ->latest()
              ->get();
              @endphp
              <div class="table-responsive">
                <table class="table table-custom">
                  <tr>
                    <th>Waktu</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Pemasok</th>
                  </tr>
                  @foreach($supplies as $supply)
                  <tr>
                    <td>
                      {{-- <span class="d-block mt-2 txt-light">{{ date('d M, Y', strtotime($supply->created_at)) . '
                        pada '
                        . date('H:i', strtotime($supply->created_at)) }}</span> --}}
                      <span class="txt-light">{{ date('H:i', strtotime($supply->created_at)) }}</span>
                    </td>
                    <td class="font-weight-bold big-font">
                      {{ $supply->kode_barang }}
                    </td>
                    <td class="font-weight-bold">{{ $supply->nama_barang }}</td>
                    <td class="font-weight-bold"><span class="ammount-box bg-secondary"><i
                          class="mdi mdi-cube-outline"></i></span>{{ $supply->jumlah }}</td>
                    <td class="font-weight-bold">{{ $supply->pemasok }}</td>
                  </tr>
                  @endforeach
                </table>
              </div>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/datedropper.js') }}"></script>
<script src="{{ asset('plugins/js/Chart.min.js') }}"></script>
<script src="{{ asset('js/manage_product/supply_product/statistics_supply/script.js') }}"></script>
<script src="{{ asset('js/manage_product/supply_product/supply/script.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('import_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif
</script>
@endsection
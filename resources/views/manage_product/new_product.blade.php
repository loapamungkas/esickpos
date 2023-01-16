@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/new_product/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
	<div class="col-12">
		<div class="page-header d-flex justify-content-start align-items-center">
			<div class="quick-link-wrapper d-md-flex flex-md-wrap">
				<ul class="quick-links">
					<li><a href="{{ url('product') }}">Daftar Barang</a></li>
					<li><a href="{{ url('product/new') }}">Barang Baru</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{ url('/product/create') }}" method="post" name="create_form">
					@csrf
					<div class="form-group row">
						<label class="col-12 font-weight-bold col-form-label">Kode Barang <span
								class="text-danger">*</span></label>
						<div class="col-12">
							<div class="input-group">
								<input type="text" class="form-control number-input" name="kode_barang"
									placeholder="Masukkan Kode Barang">
							</div>
						</div>
						<div class="col-12 error-notice" id="kode_barang_error"></div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
							<div class="row">
								<label class="col-12 font-weight-bold col-form-label">Nama Barang <span
										class="text-danger">*</span></label>
								<div class="col-12">
									<input type="text" class="form-control" name="nama_barang"
										placeholder="Masukkan Nama Barang">
								</div>
								<div class="col-12 error-notice" id="nama_barang_error"></div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="row">
								<label class="col-12 font-weight-bold col-form-label">Kategori <span
										class="text-danger">*</span></label>
								<div class="col-12">
									<select class="form-control" name="id_kategori">
										<option value="">-- Pilih Kategori --</option>
										@foreach ($kategoris as $kategori)
										<option value="{{$kategori->id}}">{{$kategori->nama_kategori}}
										</option>
										@endforeach
									</select>
								</div>
								<div class="col-12 error-notice" id="id_kategori_error"></div>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-6 col-sm-12 space-bottom">
							<div class="row">
								<label class="col-12 font-weight-bold col-form-label">Stok Barang <span
										class="text-danger">*</span></label>
								<div class="col-12">
									<input type="text" class="form-control number-input" name="stok"
										placeholder="Masukkan Stok Barang">
								</div>
								<div class="col-12 error-notice" id="stok_error"></div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="row">
								<label class="col-12 font-weight-bold col-form-label">Harga Barang <span
										class="text-danger">*</span></label>
								<div class="col-12">
									<div class="input-group">
										<div class="input-group-prepend">
											<span class="input-group-text">Rp. </span>
										</div>
										<input type="text" class="form-control number-input" name="harga"
											placeholder="Masukkan Harga Barang">
									</div>
								</div>
								<div class="col-12 error-notice" id="harga_error"></div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 mt-2 d-flex justify-content-end">
							<button class="btn btn-simpan btn-sm" type="submit"><i class="mdi mdi-content-save"></i>
								Simpan</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/new_product/script.js') }}"></script>
<script type="text/javascript">
	@if ($message = Session::get('create_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif
</script>
@endsection
@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/supply_product/new_supply/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
	<div class="col-12">
		<div class="page-header d-flex justify-content-start align-items-center">
			<div class="quick-link-wrapper d-md-flex flex-md-wrap">
				<ul class="quick-links">
					<li><a href="{{ url('supply') }}">Riwayat Pasok</a></li>
					<li><a href="{{ url('supply/new') }}">Pasok Barang</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="row modal-group">
	<div class="modal fade" id="tableModal" tabindex="-1" role="dialog" aria-labelledby="tableModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="tableModalLabel">Daftar Barang</h5>
					<button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<input type="text" class="form-control" name="search" placeholder="Cari barang">
							</div>
						</div>
						<div class="col-12">
							<ul class="list-group product-list">
								@foreach($products as $product)
								<li
									class="list-group-item d-flex justify-content-between align-items-center active-list">
									<div class="text-group">
										<p class="m-0 txt-light">{{ $product->id }}</p>
										<p class="m-0">{{ $product->kode_barang }}</p>
										<p class="m-0 txt-light">{{ $product->nama_barang }}</p>
									</div>
									<div class="d-flex align-items-center">
										<span class="ammount-box bg-secondary mr-1"><i
												class="mdi mdi-cube-outline"></i></span>
										<p class="m-0">{{ $product->stok }}</p>
									</div>
									<a href="#"
										class="btn btn-icons btn-rounded btn-inverse-outline-primary font-weight-bold btn-pilih"
										role="button"><i class="mdi mdi-chevron-right"></i></a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-4 col-md-12 col-sm-12 mb-4">
		<div class="row">
			<div class="col-12">
				<div class="card card-noborder b-radius">
					<div class="card-body">
						<div class="row">
							<div class="col-12 d-flex">
								<h4>Tambah Barang</h4>
							</div>
							<div class="col-12 mt-3">
								<form method="post" name="manual_form">
									<div class="form-group row">
										<label class="col-12 font-weight-bold col-form-label">Kode Barang</label>
										<div class="col-12 d-flex">
											<input type="text" class="form-control mr-2" name="kode_barang" readonly=""
												hidden>
											<input type="text" class="form-control mr-2" name="kode" readonly="">
											<button class="btn btn-search" data-toggle="modal" data-target="#tableModal"
												type="button">
												<i class="mdi mdi-magnify"></i>
											</button>
										</div>
										<div class="col-12 error-notice" id="kode_barang_error"></div>
									</div>
									<div class="form-group row top-min">
										<label class="col-12 font-weight-bold col-form-label">Jumlah Barang</label>
										<div class="col-12">
											<input type="text" class="form-control number-input input-notzero"
												name="jumlah" placeholder="Masukkan Jumlah">
										</div>
										<div class="col-12 error-notice" id="jumlah_error"></div>
									</div>
									<div class="row">
										<div class="col-12 d-flex justify-content-end">
											<button class="btn font-weight-bold btn-tambah"
												type="button">Tambah</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-8 col-md-12 col-sm-12">
		<div class="card card-noborder b-radius">
			<div class="card-body">
				<form action="{{ url('/supply/create') }}" method="post">
					@csrf
					<div class="row">
						<div class="col-12 table-responsive mb-4">
							<table class="table table-custom">
								<thead>
									<tr>
										<th>Kode</th>
										<th>Nama Barang</th>
										<th>Jumlah</th>
										<th></th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
						<div class="col-12 d-flex justify-content-end">
							<button class="btn btn-simpan btn-sm" type="submit" hidden=""><i
									class="mdi mdi-content-save"></i> Simpan</button>
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
<script src="{{ asset('js/manage_product/supply_product/new_supply/script.js') }}"></script>
<script type="text/javascript">
	$(document).on('click', '.btn-tambah', function(e){
		e.preventDefault();
		$('form[name=manual_form]').valid();
		var kode_barang = $('input[name=kode_barang]').val();
		var jumlah = $('input[name=jumlah]').val();
		if(validator.valid() == true){
			$.ajax({
				url: "{{ url('/supply/data') }}/" + kode_barang,
				method: "GET",
				success:function(response){
					var check = $('.kd-barang-field:contains('+ response.product.id +')').length;
					if(check == 0){
						$('input[name=kode_barang]').val('');
						$('input[name=jumlah]').val('');
						$('tbody').append('<tr><td><span class="kd-barang-field">'+ response.product.id +'</span></td><td>'+ response.product.nama_barang 
								+'</td><td>'+ jumlah +'</td><td><button type="button" class="btn btn-icons btn-rounded btn-danger ml-1 btn-delete"><i class="mdi mdi-close"></i></button><div class="form-group" hidden=""><input type="text" class="form-control" name="kode_barang_supply[]" value="'+ response.product.id 
											+'"><input type="text" class="form-control" name="jumlah_supply[]" value="'+ jumlah 
											+'"></div></td></tr>');
						$('.btn-simpan').prop('hidden', false);
					}else{
						swal(
					        "",
					        "Barang telah ditambahkan",
					        "error"
					    );
					}
				}
			});
		}
	});
</script>
@endsection
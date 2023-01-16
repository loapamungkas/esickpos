@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/manage_product/product/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
    <div class="col-12">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h4 class="page-title">Daftar Kategori</h4>
            <div class="d-flex justify-content-start">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="mdi mdi-magnify"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="search" placeholder="Cari Kategori">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row modal-group">
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/kategori/update') }}" method="post" name="update_form">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                        <button type="button" class="close close-btn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="edit-modal-body">
                        @csrf
                        <div class="row" hidden="">
                            <div class="col-12">
                                <input type="text" name="id">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-12 col-form-label font-weight-bold">Nama
                                Kategori</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" class="form-control" name="nama_kategori_edit">
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-12 offset-lg-3 offset-md-3 error-notice"
                                id="nama_kategori_error">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" id="edit-modal-footer">
                        <button type="submit" class="btn btn-update"><i class="mdi mdi-content-save"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-7 grid-margin">
        <div class="card card-noborder b-radius">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nama Kategori</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoris as $kategori)
                                <tr>
                                    <td><span class="btn habis-span">{{ $kategori->id }}</span></td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td>
                                        <button type="button" class="btn btn-edit btn-icons btn-rounded btn-secondary"
                                            data-toggle="modal" data-target="#editModal"
                                            data-edit="{{ $kategori->id }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>
                                        <button type="button"
                                            class="btn btn-icons btn-rounded btn-secondary ml-1 btn-delete"
                                            data-delete="{{ $kategori->id }}">
                                            <i class="mdi mdi-close"></i>
                                        </button>
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
    <div class="col-5 grid-margin">
        <div class="card card-noborder b-radius">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ url('/kategori/create') }}" method="post" name="create_form">
                            @csrf
                            <div class="form-group row">
                                <label class="col-12 font-weight-bold col-form-label">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="nama_kategori"
                                        placeholder="Masukkan Nama Kategori">
                                </div>
                                <div class="col-12 error-notice" id="nama_kategori_error"></div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2 d-flex justify-content-end">
                                    <button class="btn btn-simpan btn-sm btn-new" type="submit"><i
                                            class="mdi mdi-content-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('plugins/js/quagga.min.js') }}"></script>
<script src="{{ asset('js/manage_product/product/script.js') }}"></script>
<script type="text/javascript">
    @if ($message = Session::get('create_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('update_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif

  @if ($message = Session::get('delete_success'))
    swal(
        "Berhasil!",
        "{{ $message }}",
        "success"
    );
  @endif  

  @if ($message = Session::get('create_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif
  @if ($message = Session::get('update_failed'))
    swal(
        "",
        "{{ $message }}",
        "error"
    );
  @endif

  $(document).on('click', '.btn-edit', function(){
    var data_edit = $(this).attr('data-edit');
    $.ajax({
      method: "GET",
      url: "{{ url('/kategori/edit') }}/" + data_edit,
      success:function(response)
      {
        $('input[name=id]').val(response.kategori.id);
        $('input[name=nama_kategori_edit]').val(response.kategori.nama_kategori);
        validator.resetForm();
      }
    });
  });

  $(document).on('click', '.btn-delete', function(e){
    e.preventDefault();
    var data_delete = $(this).attr('data-delete');
    swal({
      title: "Apa Anda Yakin?",
      text: "Data Kategori akan terhapus, klik oke untuk melanjutkan",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        window.open("{{ url('/kategori/delete') }}/" + data_delete, "_self");
      }
    });
  });
</script>
@endsection
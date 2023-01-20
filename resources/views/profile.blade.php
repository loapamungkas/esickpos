@extends('templates/main')
@section('css')
<link rel="stylesheet" href="{{ asset('css/profile/style.css') }}">
@endsection
@section('content')
<div class="row page-title-header">
  <div class="col-12">
    <div class="page-header d-flex justify-content-between align-items-center">
      <h4 class="page-title">Profile</h4>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-9 col-md-6 col-sm-6 col-12">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12 d-flex">
            <button class="btn-tab data_diri_tab_btn btn-tab-active">Ubah Data Diri</button>
            <button class="btn-tab password_tab_btn">Ubah Password</button>
            <div class="btn-tab-underline"></div>
          </div>
          <div class="col-12 mt-3">
            <form name="change_profile_form" method="POST" action="{{ url('/profile/update/data') }}">
              @csrf
              <div class="form-group row">
                <label class="col-12 font-weight-bold col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-12">
                  <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama"
                    value="{{ auth()->user()->nama }}">
                </div>
                <div class="col-12 error-notice" id="nama_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-12 font-weight-bold col-form-label">Email <span class="text-danger">*</span></label>
                <div class="col-12">
                  <input type="email" class="form-control" name="email" placeholder="Masukkan Email"
                    value="{{ auth()->user()->email }}">
                </div>
                <div class="col-12 error-notice" id="email_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-12 font-weight-bold col-form-label">Username <span
                    class="text-danger">*</span></label>
                <div class="col-12">
                  <input type="text" class="form-control" name="username" placeholder="Masukkan Username"
                    value="{{ auth()->user()->username }}">
                </div>
                <div class="col-12 error-notice" id="username_error"></div>
              </div>
              <div class="row mt-5">
                <div class="col-12 d-flex justify-content-end">
                  <button class="btn update-btn btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Simpan
                    Perubahan</button>
                </div>
              </div>
            </form>
            <form name="change_password_form" method="POST" action="{{ url('/profile/update/password') }}" hidden="">
              @csrf
              <div class="form-group row">
                <label class="col-12 font-weight-bold col-form-label">Password Lama <span
                    class="text-danger">*</span></label>
                <div class="col-12">
                  <input type="password" class="form-control" name="old_password" placeholder="Masukkan Password Lama">
                </div>
                <div class="col-12 error-notice" id="old_password_error"></div>
              </div>
              <div class="form-group row">
                <label class="col-12 font-weight-bold col-form-label">Password Baru <span
                    class="text-danger">*</span></label>
                <div class="col-12">
                  <input type="password" class="form-control" name="new_password" placeholder="Masukkan Password Baru">
                </div>
                <div class="col-12 error-notice" id="new_password_error"></div>
              </div>
              <div class="row mt-5">
                <div class="col-12 d-flex justify-content-end">
                  <button class="btn update-btn btn-sm" type="submit"><i class="mdi mdi-content-save"></i> Ubah
                    Password</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 account-detail mb-4 col-12">
    <div class="card card-noborder b-radius">
      <div class="card-body">
        <div class="row">
          <div class="col-12 text-center foto">
            <form name="change_picture_form" action="{{ url('/profile/update/picture') }}" method="POST"
              enctype="multipart/form-data">
              @csrf
              <img src="{{ asset('pictures/' . auth()->user()->foto) }}" class="foto-profil">
              <input type="file" name="foto" id="foto" hidden="" accept=".png, .jpg, .jpeg">
              <button class="btn-edit-img" type="button"><i class="mdi mdi-pencil"></i></button>
              <button class="btn-update-img" type="submit" hidden=""><i class="mdi mdi-content-save"></i></button>
            </form>
          </div>
          <div class="col-12 mt-3 text-center">
            <p class="nama-akun">{{ auth()->user()->nama }}</p>
            <p class="posisi-akun">{{ auth()->user()->role }}</p>
          </div>
          <div class="col-12 mt-3 d-flex justify-content-start align-items-start">
            <div class="icon mr-3">
              <i class="mdi mdi-account-outline"></i>
            </div>
            <div class="text-group">
              <p class="username-text">Username</p>
              <p class="username-akun">{{ auth()->user()->username }}</p>
            </div>
          </div>
          <div class="col-12 mt-3 d-flex justify-content-start align-items-start">
            <div class="icon mr-3">
              <i class="mdi mdi-email-outline"></i>
            </div>
            <div class="text-group">
              <p class="email-text">Email</p>
              <p class="email-akun">{{ auth()->user()->email }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/profile/script.js') }}"></script>
<script type="text/javascript">
  @if ($message = Session::get('update_success'))
    swal(
      "Berhasil!",
      "{{ $message }}",
      "success"
    );
  @endif

  @if ($message = Session::get('update_error'))
    swal(
      "",
      "{{ $message }}",
      "error"
    );
  @endif
</script>
@endsection
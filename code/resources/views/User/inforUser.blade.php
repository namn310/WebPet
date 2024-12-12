@extends('User.LayoutTrangChu')
@section('content')
<!-- user infor -->
@if (session('notice'))
<script>
  $.toast({
                          heading: 'Success',
                          text: '{{ session('notice') }}',
                          showHideTransition: 'slide',
                          icon: 'success',
                          position: 'bottom-right'
                          })
</script>
@endif
@if (session()->has('userGoogle'))
{{-- infor google user --}}
<div class="inforUserView">
  <form
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-3 align-items-center mx-auto">
      <div class=" col-3">
        <div class="card border-0 ">
          <img src="{{ asset('assets/img/avatar-trang-99.jpg') }}" class="card-img-top rounded-circle w-50 mx-auto"
            alt="">
        </div>
      </div>
      <div class="col-8">

        <h1 class="text-center mt-3">Thông tin cá nhân</h1>
        <div class="row g-3 align-items-center border-start border-end border-secondary  border-secondary-subtle">
          <div class="col">
            <p class="ms-2">Họ tên</p>
            <input type="text" name="name" class="form-control" value="{{ session('userGoogle.name') }}">
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          {{-- <div class="col-12">
            <p class="ms-2">Số điện thoại</p>
            <input type="text" class="form-control" name="phone" value="{{ Auth::guard('customer')->user()->phone }}">
            @error('phone')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div> --}}
          <div class="col-12">
            <p class="ms-2">Email</p>
            <input type="text" class="form-control" name="email" value="{{ session('userGoogle.email') }}">
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          {{-- <div class="col-12">
            <div class="d-grid gap-2 col-4 mx-auto">
              <button class="btn btn-outline-danger" name="updateInfor" type="submit">Lưu thông tin</button>
            </div>

          </div> --}}
        </div>

      </div>


    </div>
  </form>
</div>
@else
<div class="inforUserView">
  <form method="post" action="{{ route('user.updateInfor',['id'=>Auth('customer')->user()->id]) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row g-3 align-items-center mx-auto">
      <div class=" col-3">
        <div class="card border-0 ">
          @if (Auth('customer')->user()->image !='')
          <img src="{{ asset('assets/img-avt-customer/'.Auth('customer')->user()->image) }}"
            class="card-img-top rounded-circle w-50 mx-auto" alt="">
          @else
          <img src="{{ asset('assets/img/avatar-trang-99.jpg') }}" class="card-img-top rounded-circle w-50 mx-auto"
            alt="">
          @endif
          <div class="card-body text-center">
            <i class="fas fa-cloud-upload-alt"></i>
            <span>Thay đổi avatar</span>
            <input type="file" name="avtUser" class="form-control">

            {{-- <p class="text-header"><b>{{ Auth('customer')->user()->name }}</b></p> --}}

          </div>
        </div>
      </div>
      <div class="col-8">

        <h1 class="text-center mt-3">Thông tin cá nhân</h1>
        <div class="row g-3 align-items-center border-start border-end border-secondary  border-secondary-subtle">
          <div class="col">
            <p class="ms-2">Họ tên</p>
            <input type="text" name="name" class="form-control" value="{{ Auth::guard('customer')->user()->name }}">
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-12">
            <p class="ms-2">Số điện thoại</p>
            <input type="text" class="form-control" name="phone" value="{{ Auth::guard('customer')->user()->phone }}">
            @error('phone')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-12">
            <p class="ms-2">Email</p>
            <input type="text" class="form-control" name="email" value="{{ Auth::guard('customer')->user()->email }}">
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="col-12">
            <div class="d-grid gap-2 col-4 mx-auto">
              <button class="btn btn-outline-danger" name="updateInfor" type="submit">Lưu thông tin</button>
            </div>

          </div>
        </div>

      </div>


    </div>
  </form>
</div>
@endif

@endsection
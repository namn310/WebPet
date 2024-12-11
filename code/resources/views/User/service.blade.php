@extends('User.LayoutTrangChu')

@section('content')

<!-- Dịch vụ-->
<div class="cartView">
  @foreach ($service as $row )
  <div class=" service container text-center mb-2">
    <h2 style="font-size:1.3vw 1.3vh">
      {{ $row->name }}
    </h2>
    <i class="fa-solid fa-heart"></i>
    <h4 style="font-size:1.3vw 1.3vh">Bảng giá dịch vụ</h4>
    <img class="img-fluid" style="max-width:80%" src="{{ asset('assets/img-dichvu/'.$row->image) }}">
    <br>
    <button type="button" class="btn btn-danger mt-3"><a style="text-decoration: none;color:white;font-size:1.3vw 1.3vh"
        href="{{ route('user.book') }}">Đăng ký ngay</a></button>
    <hr>
  </div>

  @endforeach


</div>
<!--hẾT DỊCH VỤ-->
<script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
@extends('Admin.Layout')
@section('content')

<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 22px;">
            <li class="breadcrumb-item"><a href="{{ route('admin.banner') }}">Quản lý Banner</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm Banner</li>
        </ol>
    </nav>
    <div class="mt-3" style="width:60%">
        <form method="post" action="{{ route('admin.bannerStore') }}">
            @csrf
            @method('post')
            <div class="mb-2">
                <label style="font-weight: bolder" class="form-label">Banner Trang Chủ</label>
                <input class="form-control" type="file" name="home" required>
            </div>
            <div class="mb-2">
                <label style="font-weight: bolder" class="form-label">Banner Slide</label>
                <input class="form-control" type="file" multiple name="slide[]" required>
            </div>
            <div class="mb-2">
                <label style="font-weight: bolder" class="form-label">Banner Booking</label>
                <input class="form-control" type="file" name="book" required>
            </div>
            <div class="mb-2">
                <label style="font-weight: bolder" class="form-label">Banner Cart</label>
                <input class="form-control" type="file" name="cart" required>
            </div>
            <a href=""><button type="submit" class="btn btn-success">Thêm</button></a>
        </form>
    </div>
</div>


@endsection
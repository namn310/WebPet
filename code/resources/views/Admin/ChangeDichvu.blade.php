@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.service') }}">Quản lý dịch vụ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
        </ol>
    </nav>

</div><!-- End Page Title -->
<div class="container-fluid border border-primary rounded">
    @foreach ($service as $row )
    <form style="font-size:2vw;font-size:2vh" method="post" action="{{ route('admin.updateService',['id'=>$row->id]) }}" class="p-4">
        @csrf
        @method('POST')
        <div class="name">
            <label class="form-label"><b>Tên dịch vụ </b> </label>
            <input style="font-size:2vw;font-size:2vh" class="form-control" type="text" name="name" value="{{ $row->name }}">
        </div>
        <div class="mt-4">
            <label class="form-label"><b>Mô tả </b> </label>
            <br>
            <img class="mt-2 mb-2 img-fluid" src="{{ asset('assets/img-dichvu/'.$row->image) }}">
            <input style="font-size:2vw;font-size:2vh" class="form-control" type="file" name="hinhanh">
        </div>

        <button type="submit" style="font-size:2vw;font-size:2vh" class="btn btn-success mt-2">Xác nhận</button>
    </form>
    @endforeach
</div>


@endsection
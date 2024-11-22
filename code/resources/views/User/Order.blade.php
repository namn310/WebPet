@extends('User.LayoutTrangChu')
@section('content')
<style>
    .order {
        flex: 1;
    }

    .booking {
        flex: 1;
    }

    @media screen and (max-width: 860px) {
        .orderUser {
            margin-top: 200px;
        }
    }
</style>
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
@if (session('error'))
<script>
    $.toast({
                        heading: 'Error',
                        text: '{{ session('error') }}',
                        showHideTransition: 'slide',
                        icon: 'error',
                        position: 'bottom-right'
                        })
</script>
@endif
<div class="orderUser ms-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" style="font-size:2vw;font-size:2vh" data-bs-toggle="tab"
                data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                aria-selected="true">Giỏ hàng của bạn</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" style="font-size:2vw;font-size:2vh" data-bs-toggle="tab"
                data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                aria-selected="false">Lịch hẹn</button>
        </li>
        <div class="tab-content container-fluid d-flex align-items-center justify-content-center flex-column flex-wrap"
            id="myTabContent">
            {{-- cartSmallView --}}
            <div class="cartSmallView mt-2 tab-pane fade show active " id="home-tab-pane" role="tabpanel"
                aria-labelledby="home-tab" tabindex="0">
                @if ($OrderCount==0) <h3 class="mt-3">Bạn chưa có đơn hàng nào. Hãy quay lại trang chủ để mua sắm</h3>
                @else
                <section class="h-100" style="background-color: #d2c9ff;">
                    <div class="container py-5 h-100">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-12">
                                <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-lg-12">

                                                <div class="p-5">
                                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                                        <h2 style="font-size:2vw;font-size:2vh">Đơn hàng <i
                                                                class="fa-solid fa-cart-plus"></i></h2>
                                                        <h2 style="font-size:2vw;font-size:2vh" class="mb-0 ">{{
                                                            $OrderCount }}
                                                            đơn hàng</h2>
                                                    </div>
                                                    <hr class="my-4">
                                                    @foreach ( $Order as $order )
                                                    <div>
                                                        <div
                                                            class="row mb-0 d-flex justify-content-between align-items-center">
                                                            @foreach ( $order->getOrderDetail($order->id) as $row )
                                                            <div class="col-md-3 col-lg-3 col-xl-3 mb-4">
                                                                <img src="{{ asset('assets/img-add-pro/'.$row->getImgProduct($row->idPro)) }}"
                                                                    class="img-fluid rounded-3" alt="Cotton T-shirt">
                                                            </div>
                                                            <div class="col-md-3 col-lg-3 col-xl-3">
                                                                {{-- <h6 class="text-muted">Shirt</h6> --}}
                                                                <h6 style="font-size:3vw;font-size:3vh" class="mb-0">{{
                                                                    $row->getProductName($row->idPro) }}</h6>
                                                            </div>
                                                            <div class="col-md-1 col-lg-1 col-xl-1 d-flex">
                                                                <h5>x{{ $row->number }}</h5>
                                                            </div>
                                                            <div
                                                                class="col-md-3 col-lg-3 col-xl-3 offset-lg-1 text-danger">

                                                                @if ($row->getProductDiscount($row->idPro) !== '')
                                                                <h5>
                                                                    {{
                                                                    number_format((
                                                                    ($row->price - ($row->price *
                                                                    ($row->getProductDiscount($row->idPro) /
                                                                    100)))))
                                                                    }}đ
                                                                </h5>
                                                                @else
                                                                <h5><span class="text-danger">{{
                                                                        number_format($row->price)
                                                                        }}đ</span>
                                                                </h5>
                                                                @endif

                                                            </div>

                                                            @endforeach
                                                        </div>
                                                        <div class="text-end">
                                                            <h6 class="text-danger"><b> Tổng tiền : {{
                                                                    number_format($order->getTotalOrder($order->id))
                                                                    }}đ</b></h6>
                                                        </div>
                                                        <div>
                                                            <h6 class="text-end"> <i
                                                                    class="fa-solid fa-bag-shopping text-danger"></i>
                                                                Phương
                                                                thức thanh
                                                                toán: <span style="font-weight:bold"> {{
                                                                    $order->thanhtoan
                                                                    }}</span> </h6>
                                                            @if ($order->status==0)
                                                            <div class="text-end"><button class="btn btn-danger m-2">Chờ
                                                                    xác
                                                                    nhận</button> </div>
                                                            @else
                                                            <div class="text-end"><button
                                                                    class="btn btn-success m-2">Đơn hàng
                                                                    đang được giao</button> </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-end"></div>
                                                    <hr class="my-4">
                                                    @endforeach

                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @endif



            </div>
            <div class="booking mt-4 tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0" style="width:60%;font-size:2vh;font-size:2vw">
                <div class="text-center">
                    <button type="button" class="btn btn-white position-relative">
                        <h3 class="text-center" style="font-size:2vh;font-size:2vw">Lịch hẹn của bạn <i
                                class="fa-solid fa-calendar-days text-primary"></i></h3>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $bookingCount }}
                        </span>
                    </button>
                </div>
                @if ($bookingCount>0)

                @foreach ($bookingForm as $book )
                <div style="border:1px solid black" class="mb-3">
                    <p style="font-weight:bolder;font-size:1vh;font-size:1vw" class="text-start mt-3 ms-3"> ID Lịch hẹn:
                        {{
                        $book->id }}</p>
                    <p style="font-weight:bolder;font-size:1vh;font-size:1vw" class="text-start mt-3 ms-3"> Thời gian
                        tạo: {{
                        $book->created_at }}</p>
                    <div class=" align-items-center d-flex justify-content-center ms-3 me-3">
                        <form style="width:100%;font-size:1.5vh;font-size:1.5vw" method="post"
                            class="align-items-center" action="{{ route('user.updateBooking',['id'=>$book->id]) }}"
                            name=" booking_form">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <br>
                                <label for="Bossname">Tên của Boss</label>
                                <input type="text" class="form-control bossname" value="{{ $book->name }}" id="Bossname"
                                    name="name" placeholder="Nhập tên của boss" required>
                            </div>
                            <div class="form-group">
                                <label for="Bosstype">Boss là: </label>
                                <input type="text" class="form-control" id="Bosstype" required name="type"
                                    value="{{ $book->type }}" placeholder="Chó, mèo ">

                            </div>
                            <div class="form-group">
                                <label for="Bosstype">Tên dịch vụ: </label>
                                <input type="text" class="form-control" id="Bosstype" value="{{ $book->name_service }}"
                                    required name="dichvu" placeholder="Tên dịch vụ muốn đăng ký ">

                            </div>
                            <div class="form-group">
                                <label for="Bosstype">Tên gói: </label>
                                <input type="text" class="form-control" id="Bosstype" value="{{ $book->goi }}" required
                                    name="goi" placeholder="Tên gói muốn đăng ký ">

                            </div>
                            <div class="form-group">
                                <label for="Bossweight">Cân nặng(kg): </label>
                                <input type="text" class="form-control" id="Bossweight" value="{{ $book->weight }}"
                                    required name="weight" placeholder="Điền cân nặng của Boss">
                            </div>
                            <div class="Date">
                                <p>Chọn lịch</p>
                                <input name="date" class="form-control" placeholder="Nhập lịch"
                                    value="{{ $book->date }}" required type="text">
                            </div>
                            <div class="form-group">
                                <label for="Bossweight">Ghi chú (nếu có): </label>
                                <input type="text" class="form-control" id="Bossweight" value="{{ $book->note }}"
                                    name="note" style="height:100px">
                            </div>
                            @if ($book->status>0)
                            <button style="font-size:1vh;font-size:1vw" class="btn btn-success mt-3 mb-2">Cửa hàng đã
                                xác nhận
                                lịch hẹn của bạn !</button>
                            @else
                            <div class="align-items-center d-flex justify-content-center">
                                <button style="font-size:1vh;font-size:1vw" type="submit"
                                    class="btn btn-primary mt-3 submit_booking mb-2">
                                    Chỉnh sửa
                                </button>
                                {{-- cancel --}}
                                <button style="font-size:1vh;font-size:1vw" type="button" data-bs-toggle="modal"
                                    data-bs-target="#delete-book{{ $book->id }}"
                                    class="btn btn-danger mt-3 submit_booking mb-2 ms-2">
                                    Hủy lịch hẹn
                                </button>
                                <!-- Modal xóa -->
                                <div class="modal fade" id="delete-book{{ $book->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 style="font-size:1.5vh;font-size:1.5vw" class="modal-title fs-5"
                                                    id="exampleModalLabel">Thông báo
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body" style="font-size:1.5vh;font-size:1.5vw">
                                                Bạn có muốn hủy lịch hẹn không ?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                                    style="font-size:1.5vh;font-size:1.5vw">Close</button>

                                                <button type="submit" class="btn btn-primary"> @csrf<a
                                                        href="{{ route('user.destroyBook',['id'=>$book->id]) }}"
                                                        style="text-decoration:none;color:white;font-size:1.5vh;font-size:1.5vw">Đồng
                                                        ý</a></button>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                        </form>
                    </div>
                </div>
                @endforeach
                @else
                <p style="font-size:1.5vh;font-size:1.5vw" class="ms-3 mt-3">Hiện tại bạn chưa có lịch hẹn nào.<a
                        style="text-decoration:none" href="{{ route('user.book') }}">Đăng ký lịch hẹn để có được trải
                        nghiệm tốt
                        nhất</a></p>
                @endif
            </div>
        </div>
    </ul>



    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }

        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }
    </style>


</div>
@endsection
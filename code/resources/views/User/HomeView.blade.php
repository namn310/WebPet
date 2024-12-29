@extends('User.LayoutTrangChu')
@section('content')
@if (session('success'))
<script>
    $.toast({
                heading: 'Success',
                text: '{{ session('success') }}',
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
<div class="contentuser">
    <div class="container">
        <img style="width:100%" class="img-fluid" src="{{ asset('assets/img/banner_collection.webp') }}">
    </div>
    {{-- voucher --}}
    <div class="text-center mt-2">
        <h3 id="hotProductText" style="color: #ea9e1e;">Vouchers</h3>
        <div class="container">
            <div class="carouselVoucher">
                @foreach ($voucher as $row)
                {{-- voucherItem --}}
                <div style="max-width:450px;height:240px;background-color:red;color:white;border-radius:10px"
                    class="d-flex align-items-center me-3 text-center">
                    <div class="me-3 ms-2" style="font-size:30px">
                        <i class="fa-solid fa-ticket fa-xl" style="color: white;"></i>
                    </div>
                    <div class="p-2">
                        <h4 style="font-size:3vw;font-size:3vh">{{ $row->ma }}</h4>
                        <p>
                            Giảm {{ $row->discount }}% giá trị đơn hàng.
                            @if ($row->dk_hoadon != '')
                            <span style="font-size:2vw;font-size:2vh">Áp dụng cho hóa đơn tối thiểu
                                {{ number_format($row->dk_hoadon) }}đ</span>
                            @endif
                            @if ($row->dk_soluong != '')
                            <span style="font-size:2vw;font-size:2vh">Áp dụng với số lượng sản phẩm trong đơn
                                hàng là {{ $row->dk_soluong }}</span>
                            @endif
                            @if ($row->dk_hoadon == '' && $row->dk_soluong == '')
                            <span style="font-size:2vw;font-size:2vh">Áp dụng cho mọi đơn hàng</span>
                        </p>
                        @endif
                        <br>
                        <span> <i style="font-size:1.5vw;font-size:1.5vh">{{ $row->time_start }}->{{ $row->time_end
                                }}</i>
                        </span>
                        <div class="text-end mb-2">
                            @if ($row->id == $voucherDetail->getIdVoucherUser($row->id))
                            <button class="btn btn-light">Đã lưu</button>
                            @else
                            <a href="{{ route('user.saveVoucher', ['id' => $row->id]) }}"> <button
                                    class="btn btn-light saveVoucher">Lưu</button></a>
                            @endif

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--Hot product-->
    <div class="d-flex flex-column justify-content-center align-items-center mb-3">
        <span class="service text-center">
            <h3 id="hotProductText">Sản Phẩm Hot</h3>
        </span>
        {{-- <i class="fa-solid fa-heart" style="color: #de2121;align-items: center;"></i> --}}
    </div>

    <div class="wrapper container">
        <div class="carouselHome ">
            <!-- san pham 1 -->
            @foreach ($product as $row)
            <div class="col-xl-9 col-lg-9 col-md-6 mb-3 ps-3" style="position:relative">
                <div class="product-box">
                    <div class="product-inner-box ">
                        <div class="icons d-flex justify-content-end">
                            <a class="text-decoration-none text-dark"><i class="fa-solid fa-heart"
                                    style="color: #ec0e0e;"></i></a>

                        </div>
                        <div class="onsale">
                            @if ($row->discount > 0)
                            <span style="position: absolute;top:40px" class="badge rounded-2"><i
                                    class="fa-solid fa-arrow-down"></i>{{ $row->discount }}%</span>
                            @endif
                            <a href="{{ route('user.productDetail', ['id' => $row->idPro]) }}"><img
                                    src="{{ asset('assets/img-add-pro/' . $row->getImgProduct($row->idPro)) }}"
                                    class="img-fluid"></a>
                        </div>



                        <div class="cart" style="position:absolute;top:0px">
                            <a href="{{ route('user.add', ['id' => $row->idPro]) }}"
                                style="text-decoration:none"><button class=" btn btn-white shadow-sm rounded-pill"
                                    id="buy" class="btn btn-danger " data-bs-toggle="modal"
                                    data-bs-target="#modalbuyproduct"><i
                                        class="fa-solid fa-cart-shopping text-danger"></i>
                                    Mua</button></a>
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="product-name mt-2">
                            <h3><b>{{ $row->namePro }}</b></h3>
                        </div>
                        <span class="rating secondary-font">
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            <i class="fa-solid fa-star text-warning"></i>
                            5.0</span>
                        <div class="product-price">
                            @if ($row->discount > 0)
                            <p class=" text-secondary text-decoration-line-through mb-0">
                                {{ number_format($row->cost) }}đ
                            </p>
                            <p class=" text-danger fs-5">
                                {{ number_format($row->cost - ($row->cost * $row->discount) / 100) }}đ
                                @else
                            <p class=" text-danger mb-0">{{ number_format($row->cost) }}đ</p>
                            @endif

                            </p>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container mt-3">
        <div id="carouselExampleDark" class="carousel carousel-dark slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner" style="font-size:1.3vw">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="{{ asset('assets/img/banner.jpg') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Đa dạng cái loại đồ ăn</h5>
                        <p>Chúng tôi luôn đem đến da dạng các loại đồ ăn cho thú cưng</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="{{ asset('assets/img/slider_3.webp') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Dịch vụ tận tâm</h5>
                        <p>Chúng tôi luôn quan tâm đến trải nghiệm người dùng </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/img/Banner3-1.jpg') }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Uy tín, chất lượng</h5>
                        <p>Chúng tôi luôn đặt uy tín, chất lượng lên hàng đầu</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
            $(document).ready(function() {
                $('.carouselHome').slick({
                    slidesToShow: 6,
                    slideToScroll: 6,
                    dots: true,
                    arrows: true,
                    cssEase: 'linear',
                    accessibility: true,
                    autoplay: true,
                    autoplaySpeed: 600,
                    responsive: [{
                            breakpoint: 1400,
                            settings: {
                                slidesToShow: 4,
                                dots: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 600,
                            }
                        },

                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3,
                                dots: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 600,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                dots: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 600,
                            }
                        },

                    ]
                });

                // voucher
                $('.carouselVoucher').slick({
                    slidesToShow: 4,
                    slideToScroll: 4,
                    dots: true,
                    arrows: true,
                    cssEase: 'linear',
                    accessibility: true,
                    autoplay: true,
                    autoplaySpeed: 600,
                    responsive: [{
                            breakpoint: 1400,
                            settings: {
                                slidesToShow: 3,
                                dots: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 600,
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2,
                                dots: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 600,
                            }
                        },

                    ]
                });

            });
        }
</script>
@endsection
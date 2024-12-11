@extends('User.LayoutTrangChu')
@section('content')
<style>
  .img {
    width: 30%;
    height: 30%;
  }
</style>

@if (session('status'))
<script>
  $.toast({
                          heading: 'Success',
                          text: '{{ session('status') }}',
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
<div class="container-fluid cartView" style="height:max-height">
  {{-- cartSmallView --}}
  <div class="cartSmallView mt-2">
    <section class="h-100" style="background-color: #d2c9ff;margin-bottom:50px">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
              <div class="card-body p-0">
                <div class="row g-0">
                  <div class="col-lg-8">
                    <form method="post" action="{{ route('user.cartupdate') }}">
                      @csrf
                      <div class="p-5">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                          <h3 class="fw-bold mb-0">Shopping Cart <i class="fa-solid fa-cart-plus"></i></h3>
                          <h6 class="mb-0 text-muted">{{ $cartCount }} sản phẩm</h6>
                        </div>
                        <hr class="my-4">
                        @foreach ($cartItem as $row )
                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                          <div class="col-md-2 col-lg-2 col-xl-3">
                            <img src="{{ asset('assets/img-add-pro/'.$row['image']) }}" class="img-fluid rounded-3"
                              alt="Cotton T-shirt">
                          </div>
                          <div class="col-md-3 col-lg-3 col-xl-3">
                            {{-- <h6 class="text-muted">Shirt</h6> --}}
                            <h6 class="mb-0"><input value="{{ $row['idPro'] }}" name="id{{ $row['idPro'] }}" hidden>
                              {{ $row['name'] }}</h6>
                          </div>
                          <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                            <input style="width:30%" type="number" name="idPro{{ $row['idPro'] }}"
                              id="idPro{{ $row['idPro'] }}" min="1" value="{{ $row['count'] }}"
                              required="không để trống">

                          </div>
                          <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                            @if ($row['discount']>0)
                            <h6 class="mb-0">{{ number_format($row['count'] * ($row['cost'] - ($row['cost'] *
                              $row['discount']) / 100))
                              }}₫</h6>
                            @else
                            <h6 class="mb-0">{{ number_format($row['count'] * ($row['cost']))}}đ</h6>
                            @endif

                          </div>
                          <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                            <a href="{{ route('user.delete',['id'=>$row['idPro']]) }}" class="text-muted"><i
                                class="fas fa-times"></i></a>
                          </div>
                        </div>

                        <hr class="my-4">

                        @endforeach
                        <div class="pt-3 text-end">
                          <button type="submit" class="btn btn-dark"><i class="fa-solid fa-box-archive"></i> Cập nhật
                          </button>
                        </div>
                        <div class="pt-2">
                          <h6 class="mb-0"><a href="{{ route('user.home') }}" class="text-body"><i
                                class="fas fa-long-arrow-alt-left me-2"></i>Back
                              to shop</a></h6>

                        </div>
                      </div>
                    </form>
                  </div>
                  @if(session('cart'))
                  <div class="col-lg-4 bg-body-tertiary">
                    <div class="p-5">
                      <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                      <hr class="my-4">
                      <h5 class="text-uppercase mb-3">Voucher</h5>

                      <div class="mb-5">
                        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                          data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">Sử dụng
                          Voucher</button>

                        <div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1"
                          id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
                          <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Danh sách voucher của bạn</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                              aria-label="Close"></button>
                          </div>
                          <div class="offcanvas-body">
                            @foreach ( $voucher as $row )
                            <div class="mb-3 d-flex align-items-center justify-content-center"
                              style="height:200px;background-color:red;border-radius:10px">
                              <div class="ms-2" style="font-size:30px"><i class="fa-solid fa-ticket fa-xl"
                                  style="color:white;"></i></div>
                              <div style="color:white" class="p-3 text-center">
                                <h4 style="font-size:3vw;font-size:3vh">{{ $voucherDetail->getMa($row->id_voucher) }}
                                </h4>
                                <p>
                                  Giảm {{ $voucherDetail->getDiscount($row->id_voucher) }}% hóa đơn.
                                  @if ($voucherDetail->getOrderCon($row->id_voucher) != '')
                                  <span style="font-size:2vw;font-size:2vh">Áp dụng cho hóa đơn tối thiểu
                                    {{ number_format($voucherDetail->getOrderCon($row->id_voucher)) }}đ</span>
                                  @endif
                                  @if ($voucherDetail->getCountCon($row->id_voucher) != '')
                                  <span style="font-size:2vw;font-size:2vh">Áp dụng với số lượng sản phẩm trong đơn
                                    hàng là {{ $voucherDetail->getCountCon($row->id_voucher) }}</span>
                                  @endif
                                  @if ($voucherDetail->getCountCon($row->id_voucher) == '' &&
                                  $voucherDetail->getOrderCon($row->id_voucher) == '')
                                  <span style="font-size:2vw;font-size:2vh">Áp dụng cho mọi đơn hàng</span>
                                </p>
                                @endif
                                <br>
                                <span> <i style="font-size:1.5vw;font-size:1.5vh">{{
                                    $voucherDetail->getDateStart($row->id_voucher) }}->{{
                                    $voucherDetail->getDateEnd($row->id_voucher)
                                    }}</i>
                                </span>
                                <div>
                                  @if ($row->status==0)
                                  <button class="btn btn-light">Đã hết hạn</button>
                                  @else
                                  <button class="btn btn-light useVoucher" data-voucher="{{ $row->id }}">Sử
                                    dụng</button>
                                  @endif

                                </div>
                              </div>
                            </div>
                            @endforeach

                          </div>
                        </div>
                      </div>

                      <hr class="my-4">

                      <div class="mb-5 d-flex flex-column">
                        <div class="d-flex justify-content-between">
                          <h5>Tổng tiền</h5>
                          <h5 class="text-end">{{ number_format($cartTotal) }}đ</h5>
                        </div>
                        <div id="voucher">

                        </div>
                        <div class="discount">
                          <div class="d-flex justify-content-between">
                            <h5 class="">Giảm giá </h5>
                            <h5 id="discount" class="text-danger"></h5>
                          </div>
                        </div>
                        <div class="totalcost">
                          <div class="d-flex justify-content-between">
                            <h5 class="me-5">Thành tiền</h5>
                            <h5 id="totalcost" class="text-danger"></h5>
                          </div>
                        </div>
                      </div>

                      <a style="text-decoration:none;color:white"><button class="buttonThanhToan" type="button"><span
                            class="shadow"></span>
                          <span class="edge"></span>
                          <span class="front text"> Thanh toán
                          </span></button></a>

                    </div>
                  </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

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
<div id="pay-form">
  <div class="container mt-4 d-flex flex-column justify-content-center" id="pay-form">
    <div class="customer-detail bg-light" style="border:1px solid gray;border-radius:5px;padding:10px">
      <div class="mt-3"><strong>Thông tin khách hàng</strong></div>
      <form class="mt-4" method="post" action="{{ route('user.confirmCheckOut') }}">
        @csrf
        @method('POST')
        <input id="name" name="name" type="text" class="form-control mb-3" placeholder="Họ và tên" required>
        <input id="phonenumber" name="phone" type="text" class="form-control" placeholder="Số điện thoại" required>
        <input id="address" type="text" class="form-control mt-2" placeholder="Địa chỉ giao hàng" name="address"
          required>
        <p hidden><input id="idVoucher" name="idVoucher" value=""></p>
        {{-- <input onclick="checkCustomerDetailEmail()" onkeyup="checkCustomerDetailEmail()" id="email" type="email"
          class="form-control" placeholder="Email" required> --}}
        <p>Ghi chú (nếu có)</p>
        <input id="description" type="text" name="note" class="form-control"
          style="width:100%;resize:none;border-radius:5px;min-height:100px">

        <div class="payment mt-5 bg-light" id="payment" style=" border:1px solid gray;border-radius:5px;padding:10px">
          <div class="mb-2">
            <strong>
              Chọn phương thức thanh toán
            </strong>
          </div>
          <div class="payment-1">
            <input type="radio" checked value="Thanh toán bằng phương thức COD" name="payment" id="payment">
            <label style="font-weight: bolder;" for="payment-1">Thanh toán bằng phương thức COD</label>
            <div class="payment1-detail">
              <p>
                - Quý khách vui lòng thanh toán toàn bộ giá trị đơn hàng cho nhân viên giao hàng
              </p>
              <span>
                <strong>Lưu ý: </strong>
                <p>Trong trường hợp có bất cứ vấn đề gì về đơn hàng sau khi thanh toán quý khách vui lòng liên hệ qua
                  bên tổng đài qua số Hotline: <strong>0912345669</strong></p>
              </span>
            </div>
          </div>

          <div class="payment-2">
            <input type="radio" value="Thanh toán bằng phương thức chuyển khoản" name="payment" id="payment">
            <label style="font-weight: bolder;" for="payment-2">Thanh toán bằng phương thức chuyển khoản</label>
            <div class="payment2-detail">
              <p>

                Chủ tài khoản: NGUYEN PHUONG NAM

              </p>
              <p>Số tài khoản: 0123456789</p>
              <p>Nội dung chuyển khoản: <span class="text-danger"> [Họ tên khách hàng + số điện thoại] - Vui lòng nhập
                  thông tin đúng với thông tin đã điền ở phía trên</span></p>
              <span>
                <strong>Lưu ý: </strong>
                <p>Trong trường hợp có bất cứ vấn đề gì về đơn hàng sau khi thanh toán quý khách vui lòng liên hệ qua
                  bên tổng đài qua số Hotline: <strong>0912345669</strong></p>
              </span>
            </div>
          </div>
          <button type="submit" style="width:15%" id="confirm-payment" class="btn btn-danger mt-3">
            Xác nhận thanh toán
          </button>
        </div>
      </form>
    </div>
  </div>


</div>

<script>
  $(document).ready(function() {
    $('#pay-form').hide();
    $('.discount').hide();
    $('.totalcost').hide();
    $('.buttonThanhToan').click(function(){
      $('#pay-form').toggle()
    })
    $('.useVoucher').click(function(){
      
      var idVoucherUser=$(this).data('voucher');
      $.ajax({
        url:"{{ route('user.useVoucher') }}",
        method: 'get',
        data : {
          idVoucherUser: idVoucherUser
        },
        success: function(response){
        if(response.discountFormat){
          $('.discount').show();
            $('.totalcost').show();
       $('#discount').text(response.discountFormat);
       $('#totalcost').text(response.costFormat);
       $('#idVoucher').val(response.idVoucher)
        }
        else{
          alert(response.error);
        
}
}
})
})
})
</script>

<div class="container-fluid text-center">
  <img class="img-fluid" src="{{ asset('assets/img/618lwjSdN6L._AC_UF1000,1000_QL80_.jpg') }}">
</div>

<script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
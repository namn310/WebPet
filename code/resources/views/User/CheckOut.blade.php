@extends('User.LayoutTrangChu')
@section('content')
<style>
  .img {
    width: 30%;
    height: 30%;
  }
</style>
<script>
  function UpdateCart(count,id){
   $.get(
    'route('user.cartupdate')'
   )
  }
</script>
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
<div class="container-fluid" style="margin-top:150px" style="background-color:#C0C0C0;height:max-height">

  {{-- cartSmallView --}}
  <div class="cartSmallView mt-2">
    <section class="h-100" style="background-color: #d2c9ff;">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
              <div class="card-body p-0">
                <div class="row g-0">
                  <div class="col-lg-8" >
                    <form method="post" action="{{ route('user.cartupdate') }}">
                      @csrf
                      <div class="p-5">
                        <div class="d-flex justify-content-between align-items-center mb-5">
                          <h3 style="font-size:2vw;font-size:2vh" class="fw-bold mb-0">Shopping Cart <i class="fa-solid fa-cart-plus"></i></h3>
                          <h6 style="font-size:2vw;font-size:2vh" class="mb-0 text-muted">{{ $cartCount }} sản phẩm</h6>
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
                            <h6 style="font-size:2vw;font-size:2vh" class="mb-0"><input value="{{ $row['idPro'] }}" name="id{{ $row['idPro'] }}" hidden>
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
                  <div class="col-lg-4 bg-body-tertiary">
                    <div class="p-5">
                      <h3 style="font-size:2vw;font-size:2vh" class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                      <hr class="my-4">

                      {{-- <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">items 3</h5>
                        <h5>€ 132.00</h5>
                      </div> --}}

                      {{-- <h5 class="text-uppercase mb-3">Shipping</h5>

                      <div class="mb-4 pb-2">
                        <select data-mdb-select-init>
                          <option value="1">Standard-Delivery- €5.00</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                          <option value="4">Four</option>
                        </select>
                      </div> --}}

                      <h5 style="font-size:2vw;font-size:2vh" class="text-uppercase mb-3">Voucher</h5>

                      <div class="mb-5">
                        <div data-mdb-input-init class="form-outline">
                          <input type="text" id="form3Examplea2" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Examplea2">Enter your code</label>
                        </div>
                      </div>

                      <hr class="my-4">

                      <div class="d-flex justify-content-between mb-5">
                        <h5 class="text-uppercase">Tổng tiền</h5>
                        <h5>{{ number_format($cartTotal) }}đ</h5>
                      </div>

                      <a style="text-decoration:none;color:white" ><button class="buttonThanhToan" type="button"><span class="shadow"></span>
                        <span class="edge"></span>
                        <span class="front text"> Thanh toán
                        </span></button></a>

                    </div>
                  </div>
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


<style>
  .booking-detail input {
    border: none;

  }
</style>
<div id="pay-form">
  <div class="container mt-4 d-flex flex-column justify-content-center" id="pay-form">
    <div class="customer-detail bg-light" style="border:1px solid gray;border-radius:5px;padding:10px">
      <div class="mt-3"><strong>Thông tin khách hàng</strong></div>
      <form class="mt-4" method="post" action="{{ route('user.confirmCheckOut') }}">
        @csrf
        @method('POST')
        <input id="name" name="name" type="text" class="form-control mb-3" placeholder="Họ và tên" required>
        <input id="phonenumber" name="phone" type="text" class="form-control" placeholder="Số điện thoại" required>
        {{-- <div>
          <select onmouseenter="checkCity()" onmouseout="checkCity()" class="form-select form-select-sm mb-3" id="city"
            aria-label=".form-select-sm">
            <option value="" selected>Chọn tỉnh thành</option>
          </select>

          <select onmouseenter="checkDistrict()" onmouseout="checkDistrict()" class="form-select form-select-sm mb-3"
            id="district" aria-label=".form-select-sm">
            <option value="" selected>Chọn quận huyện</option>
          </select>

          <select onmouseenter="checkWard()" onmouseout="checkWard()" class="form-select form-select-sm" id="ward"
            aria-label=".form-select-sm">
            <option value="" selected>Chọn phường xã</option>
          </select>
        </div> --}}
        <input id="address" type="text" class="form-control mt-2" placeholder="Địa chỉ giao hàng" name="address"
          required>
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




<!--footer end-->
<script src="{{ asset('assets/js/script.js') }}"></script>

{{-- <script>
  $('.checkout').click(function() {
    if (confirm('Xử lý đơn hàng thành công')) {
      window.location.href = 'index.php?controller=cart&action=checkout';
    }
  })
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
  $(document).ready(function() {
    $("#thanhtoan").click(function() {
      $("#pay-form").toggle();
    })
  })
</script>
<script>
  var citis = document.getElementById("city");
  var districts = document.getElementById("district");
  var wards = document.getElementById("ward");
  var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "application/json",
  };
  var promise = axios(Parameter);
  promise.then(function(result) {
    renderCity(result.data);
  });

  function renderCity(data) {
    for (const x of data) {
      citis.options[citis.options.length] = new Option(x.Name, x.Id);
    }
    citis.onchange = function() {
      district.length = 1;
      ward.length = 1;
      if (this.value != "") {
        const result = data.filter(n => n.Id === this.value);

        for (const k of result[0].Districts) {
          district.options[district.options.length] = new Option(k.Name, k.Id);
        }
      }
    };
    district.onchange = function() {
      ward.length = 1;
      const dataCity = data.filter((n) => n.Id === citis.value);
      if (this.value != "") {
        const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

        for (const w of dataWards) {
          wards.options[wards.options.length] = new Option(w.Name, w.Id);
        }
      }
    };
  }
</script>
@endsection
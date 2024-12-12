@extends('User.LayoutTrangChu')
@section('content')
<div class="contentabout">
  <div class="service text-center text-capitalize">
    <h3 id="aboutText">GIỚI THIỆU</h3>
    <i class="fa-solid fa-heart"></i>
    <p>PET LIKE US AND SO WILL YOU</p>

  </div>
  <div class="about container d-flex justify-content-around mt-3">
    <div class="about-left d-flex flex-column justify-content-between">
      <div class="about-left-1 text-right">
        <span>
          <h3 style="font-size:1.3vw 1.3vh">Cung Cấp Sản Phẩm Với Mức Giá Phải Chăng <i class="fa-brands fa-shopify"
              style="color:red"></i></h3>
          <p style="font-size:1.3vw 1.3vh">Ngoài các yếu tố về chất lượng sản phẩm, cửa hàng uy tín, chuyên nghiệp cần
            mang đến sản phẩm với mức giá
            cả
            phải chăng</p>
        </span>
      </div>
      <div class="about-left-2 text-right">
        <span>
          <h3 style="font-size:1.3vw 1.3vh">Nhân Viên Tư Vấn Nhiệt Tình, Am Hiểu Về Thú Cưng <i
              class="fa-brands fa-shopify" style="color:red"></i>
          </h3>
          <p style="font-size:1.3vw 1.3vh">Bên cạnh các sản phẩm chất lượng, nhân viên của cửa hàng cũng có trình độ
            chuyên nghiệp về chuyên môn cũng
            như trong quá trình phục vụ khách hàng</p>
        </span>
      </div>
    </div>
    <div>
      <span><img class="img-fluid rounded-circle" src="{{ asset('assets/img/img-about.jpg') }}"></span>
    </div>
    <div class="about-right d-flex flex-column justify-content-between ms-3">
      <div class="about-right-1 text-left">
        <span>
          <h3 style="font-size:1.3vw 1.3vh">Cung Cấp Sản Phẩm Chất Lượng <i class="fa-brands fa-shopify"
              style="color:red"></i></h3>
          <p style="font-size:1.3vw 1.3vh">Một trong những tiêu chí quan trọng của cửa hàng là mang đến những sản phẩm
            uy tín chất lượng đến khách
            hàng
          </p>
        </span>
      </div>
      <div class="about-right-2 text-left">
        <span>
          <h3 style="font-size:1.3vw 1.3vh">Cung Cấp Sản Phẩm Đa Dạng, Phong Phú <i class="fa-brands fa-shopify"
              style="color:red"></i></h3>
          <p style="font-size:1.3vw 1.3vh">Mỗi loại thú cưng đều có nét riêng biệt của chúng nên cửa hàng chúng tôi có
            đầy đủ các mặt hàng để đáp ứng
            nhu cầu của từng loại thú cưng</p>
        </span>
      </div>
    </div>
  </div>

  <div class="mt-5 container">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.122426224508!2d105.79755507486252!3d21.02778688062129!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab438eec0343%3A0xb8e48975c13d48!2zNy8xNDEgTmcuIDExOTQgxJAuIEzDoW5nLCBMw6FuZyBUaMaw4bujbmcsIMSQ4buRbmcgxJBhLCBIw6AgTuG7mWkgMTE3MDAwLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1718264171983!5m2!1svi!2s"
      width="100%" height="450" style="border:0;" allowfullscreen=""></iframe>
  </div>
</div>

<script src="{{ asset('assets/js/script.js') }}"></script>
@endsection
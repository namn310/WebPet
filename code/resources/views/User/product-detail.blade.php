@extends('User.LayoutTrangChu')
@section('content')
<style>
  @media screen and (max-width:1030px) {
    .a {
      margin-top: 50px;
    }
  }

  @media screen and (max-width:1200px) {
    .product-detail {
      flex-direction: column;
    }
  }

  @media screen and (max-width:800px) {
    .img-slide {
      display: none
    }

    .img-slide-small {
      display: block
    }
  }

  @media screen and (min-width:801px) {
    .img-slide-small {
      display: none;
    }
  }

  @media screen and (max-width:750px) {
    .a {
      margin-top: 100px;
    }
  }

  .product-detail-img {
    flex: 1;
  }

  .product-detail-intro {
    flex: 1;
  }

  /* From Uiverse.io by Cybercom682 */
  .number-control {
    display: flex;
    align-items: center;
  }

  .number-left::before,
  .number-right::after {
    content: attr(data-content);
    background-color: #333333;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid black;
    width: 20px;
    color: white;
    transition: background-color 0.3s;
    cursor: pointer;
  }

  .number-left::before {
    content: "-";
  }

  .number-right::after {
    content: "+";
  }

  .number-quantity {
    padding: 0.25rem;
    border: 1px solid black;
    width: 50px;
    -moz-appearance: textfield;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
  }

  .number-left:hover::before,
  .number-right:hover::after {
    background-color: #666666;
  }
</style>
<script>
  $(document).ready(function() {}
            var listImage = document.querySelectorAll(".list-img");
            listImage.forEach(img => {
                var a = $(img).attr('src');
                $(img).click(function() {
                    $('.main-img-product').attr('src', a);
                })
            });
        })
</script>
<!-- Danh mục sản phẩm-->
<div class="container-fluid pdt productDetail">
  <div class="row a ">
    <div>
      <script>
        window.onload = function() {
                        $(document).ready(function() {
                            $('.img-slide').slick({
                                slidesToShow: 2,
                                slidesToScroll: 1,
                                infinite: true,
                                arrows: true,
                                centerMode: false,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 900,
                                vertical: true,
                            });
                            $('.img-slide-small').slick({
                                slidesToShow: 1,
                                slidesToScroll: 1,
                                infinite: true,
                                arrows: true,
                                cssEase: 'linear',
                                accessibility: true,
                                autoplay: true,
                                autoplaySpeed: 900,
                            });
                        });
                    }
      </script>

      @foreach ($productDetail as $row)
      <div class="d-flex">
        <p id="idPro" hidden>{{ $row->idPro }}</p>
        <div class="img-slide mt-3" style="max-height:550px;max-width:200px;overflow:hidden">
          @foreach ($productListImg as $result)
          <div style="max-width:140px;border-top:1px solid black;border-bottom:1px solid black"><img
              class="img-fluid p-2 list-img" src="{{ asset('assets/img-add-pro/' . $result->image) }}"></div>
          @endforeach

        </div>
        <div class="product-detail d-flex justify-content-around">
          <div class="product-detail-img ms-2">
            {{-- Ảnh sản phẩm --}}
            <img class="img-float main-img-product" id="main-img-product"
              style="max-width:800px;max-height:600px;border:1px solid  #EA9E1E;border-radius:5px"
              src="{{ asset('assets/img-add-pro/' . $productMainImg) }}">

            <div class="img-slide-small ms-2" style="max-width:140px">
              @foreach ($productListImg as $result)
              <div style="max-width:140px"><img class="img-fluid p-2 list-img"
                  src="{{ asset('assets/img-add-pro/' . $result->image) }}"></div>
              @endforeach
            </div>
          </div>
          <div class="product-detail-intro ms-5 text-break">
            <p>
              {{-- Tên sản phẩm --}}
            <h4 style="font-size:3vw;font-size:3vh">
              {{ $row->namePro }}
            </h4>
            </p>
            {{-- Mã sản phẩm --}}
            <p style="font-size:2vw;font-size:2vh"><strong>Mã sản phẩm : </strong>
              {{ $row->idPro }}
            </p>
            <p style="font-size:2vw;font-size:2vh"><strong>Số lượng khả dụng : </strong>
              {{ $row->count }}
            </p>
            <p style="font-size:2vw;font-size:2vh"><strong>Lượt mua: </strong>324</p>
            <span class="rating secondary-font" style="font-size:3vw;font-size:3vh">
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              5.0</span>
            @if (!$row->discount > 0)
            <p style="font-size:3vw;font-size:3vh"><span class="card-text text-danger">
                {{ number_format($row->cost) }}đ</span></p>
            @else
            <p style="font-size:3vw;font-size:3vh">
              <span>
                <b class="card-text text-black text-decoration-line-through"
                  style="border-right:solid black 1px;padding-right:5px">{{ number_format($row->cost) }}
                  đ</b>
                <b class="card-text text-danger">{{ number_format($row->cost - ($row->cost * $row->discount) / 100)
                  }}đ</b>
              </span>
            </p>
            @endif
            <div class="number-control">
              <div class="number-left me-2" id="buttonDown"></div>
              <input type="number" name="number" value="1" min="1" max="{{ $row->count }}" class="number-quantity">
              <div class="number-right ms-2" id="buttonUp"></div>
            </div>
            <!-- Button trigger modal -->
            @if (!Auth::guard('customer')->check())
            <button type="button" style="width:150px ;margin-left:10px;margin-bottom:20px" id="cartSuces"
              class="btn btn-danger mt-3">
              <a href="{{ route('user.login') }}" style="text-decoration:none;color:white;font-size:2vw;font-size:2vh">
                Mua
              </a></button>
            @elseif ($row->count > 0)
            <button type="button" style="width:150px ;margin-left:10px;margin-bottom:20px" id="cartSucess"
              class="btn btn-danger mt-3">
              <a style="text-decoration:none;color:white;font-size:2vw;font-size:2vh">
                Mua
              </a></button>
            @else
            <button type="button" style="width:150px ;margin-left:10px;margin-bottom:20px;font-size:2vw;font-size:2vh"
              id="cartSucess" class="btn btn-danger mt-3">
              Hàng tạm hết</button>
            @endif
          </div>
        </div>
      </div>

      <div class="mt-3">
        <ul class="nav nav-tabs" style="cursor:pointer">
          <li class="nav-item" style="font-weight:bold">
            <a class="nav-link" id="mota" style="text-decoration:none;color:black;font-size:2vw;font-size:2vh"
              aria-current="page">Mô
              tả
              sản
              phẩm</a>
          </li>
          <li class="nav-item" style="font-weight:bold">
            <a class="nav-link" id="comment" style="text-decoration:none;color:black;font-size:2vw;font-size:2vh">Bình
              luận</a>
          </li>
        </ul>
        <!-- Mô tả sản phẩm -->
        <div class="thongtinchitiet mt-3 ms-4" style="padding-bottom:50px;font-size:2vw;font-size:2vh">
          <?php echo $row->description; ?>

        </div>
        <!--  Bình luận sản phẩm -->
        <div class="comment container mt-3">
          <!--           <iframe style="width:100%" src="../../Project-petcare-php/user/Views/Comment.php"></iframe>
         -->
          @if (Auth::guard('customer')->check())
          <!-- box comment -->
          <form>
            {{-- @csrf
            @method('post') --}}
            <input value="{{ $row->idPro }}" name="idProductComment" hidden id="idProductComment">
            <input id="idUserComment" value="{{ Auth::guard('customer')->user()->id }}" hidden>
            <input placeholder="Nhập bình luận của bạn"
              style="width:100%;border-radius:10px;height:70px;font-size:2vw;font-size:2vh" name="commentTitle"
              id="commentTitle" required>
            <div>
              <button class="btn btn-primary mt-3 float-end" type="button" style="font-size:2vw;font-size:2vh"
                id="submitComment">Bình
                luận</button>
            </div>
          </form>
          @else
          <a style="font-size:2vw;font-size:2vh" href="{{ route('user.login') }}">Hãy đăng nhập để có
            thể bình luận</a>
          @endif
          <!-- Danh sách các bình luận -->
          {{-- @if (Auth::guard('customer')->check()) --}}
          <div style="width:100%;height:500px;margin-top:20px;overflow-y:auto;overflow-x:hidden;font-size:20px"
            id="list-comment">
            <div class="list-comment mt-5" style="background-color:#EEEEEE;border-radius:6px" width="80%">
              @foreach ($comment as $cmt)
              <div class="d-flex mt-3 ms-5">
                {{-- avt user --}}
                <div class="me-4">
                </div>
                <div class=""
                  style="margin-bottom:20px;box-shadow: 2px 2px 2px gray;margin-top:10px;background-color:#FFFFFF;border-radius:10px;width:60%">
                  <span style="font-weight:bold;font-size:1.5vw;font-size:1.5vh;color:blue" class="user-name">{{
                    $cmt->getNameUser($cmt->idCus) }}</span>
                  <span style="font-weight:lighter;font-size:2vw;font-size:2vh" class="comment-time">{{ $cmt->created_at
                    }}</span>
                  <div style="margin-left:40px;font-size:2vw;font-size:2vh" class="noidung">
                    {{ $cmt->title }}</div>
                  <br>
                </div>
              </div>
              @endforeach
            </div>
            <!-- end danh sách bình luận -->
          </div>
        </div>
      </div>
      <hr>
      {{-- sản phẩm tương tự --}}
      <div class="align-items-center">
        <div class="text-center">
          <h3>Các sản phẩm tương tự</h3>
        </div>
        {{-- danh sách sản phẩm --}}
        <div class="product-list d-flex flex-wrap ms-5">
          <!-- Lấy dữ liệu từ bảng product để xuất ra sản phẩm -->
          @foreach ($productRelated as $product)
          {{-- Thông tin sản phẩm --}}
          <div id="product-infor" class="card position-relative" style="max-width:15rem;height:27rem"
            style="border:0px">
            {{-- giảm giá sản phẩm --}}
            @if ($product->discount > 0)
            <div class="onsale position-absolute top-0 start-0">
              <span class="badge rounded-0 bg-danger"><i class="fa-solid fa-arrow-down"></i>
                {{ $product->discount }}%
              </span>
            </div>
            @endif
            <div>
              {{-- hình ảnh sản phẩm --}}
              <a id="img_pro" href="{{ route('user.productDetail', ['id' => $product->idPro]) }}">
                <img class="card-img-top img-fluid p-2" style="max-height:20rem"
                  src="{{ asset('assets/img-add-pro/' . $product->getImgProduct($product->idPro)) }}"
                  alt="Card image cap"></a>
            </div>
            <div class="card-body" id="card-body">
              <h6 id="name-product" class="card-title">
                {{ $product->namePro }}
              </h6>
              <span class="rating secondary-font">
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                5.0</span>
              @if ($product->discount <= 0) <p class="card-text text-danger">
                {{ number_format($product->cost) }}đ
                </p>
                <p hidden id="productCostHidden">{{ $product->cost }}</p>
                @else
                <p class="card-text text-danger text-decoration-line-through">
                  {{ number_format($product->cost) }}đ
                </p>
                <p class="card-text text-danger" style="margin-top:-15px">
                  {{ number_format($product->cost - ($product->cost * $product->discount) / 100) }}đ
                </p>
                <p hidden id="productCostHidden">
                  {{ $product->cost - ($product->cost * $product->discount) / 100 }}
                </p>
                @endif
                <a href="{{ route('user.add', ['id' => $product->idPro]) }}"
                  style="text-decoration:none;color:white"><button type="submit" style="position:absolute;top:0;right:0"
                    class="btn btn-white shadow-sm rounded-pill"><i style="color:black"
                      class="fa-solid fa-cart-shopping text-danger"></i></button></a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <script>
        $(document).ready(function() {
                            var CurrentCount = parseInt($(".number-quantity").val());
                            $(".number-quantity").change(function(){
                               CurrentCount = parseInt($(".number-quantity").val());
                            })
                            // tăng số lượng
                            $("#buttonUp").click(function(){
                              if(CurrentCount <= 1){
                                CurrentCount = 1
                              }
                              CurrentCount +=1;
                              $(".number-quantity").val(CurrentCount);
                            })
                            // giảm số lượng
                            $("#buttonDown").click(function(){
                            CurrentCount = CurrentCount - 1;
                            if(CurrentCount <= 1 ){
                              $(".number-quantity").val("1");
                            }
                            else{
                              $(".number-quantity").val(CurrentCount);
                            }
                            })
                            $(".comment").hide();
                            $("#comment").click(function() {
                                $(".thongtinchitiet").hide();
                                $(".comment").show();
                            })
                            $("#mota").click(function() {
                                $(".thongtinchitiet").show();
                                $(".comment").hide();
                            })
                            // comment
                            $("#submitComment").click(function(){
                              var commentTitle = $("#commentTitle").val();
                              var userId = $("#idUserComment").val();
                              var productId = $("#idProductComment").val();
                              var url = "/product/detail/" + productId;
                              console.log(commentTitle,userId,productId);
                              $.ajax({
                                url: url,
                                type:"POST",
                                data:{
                                  commentTitle: commentTitle,
                                  _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                // thêm mới bình luận vào danh sách bình luận
                                var newComment = `
                                <div class="d-flex mt-3 ms-5">
                                  <div
                                    style="margin-bottom:20px; box-shadow: 2px 2px 2px gray; margin-top:10px; background-color:#FFFFFF; border-radius:10px; width:60%">
                                    <span style="font-weight:bold; font-size:1.5vw; color:blue;font-size:1.5vh" class="user-name">${response.user_name}</span>
                                    <span style="font-weight:lighter; font-size:2vw;font-size:2vh" class="comment-time">${response.created_at}</span>
                                    <div style="margin-left:40px; font-size:2vw;font-size:2vh" class="noidung">${response.commentTitle}</div>
                                    <br>
                                  </div>
                                </div>
                                `;
                                $(".list-comment").append(newComment);
                                document.getElementById("commentTitle").value = "";
                                // tự động tua xuống comment mới nhất
                                const listComment = document.getElementById("list-comment");
                                listComment.scrollTo({
                                top: listComment.scrollHeight,
                                behavior: 'smooth' // Cuộn mượt
                                });
                                },
                                error: function(response){
                                  console.log(response);
                                }
                              })
                            })
                            $("#cartSucess").click(function(){
                              var CurrentCount = parseInt($(".number-quantity").val());
                              var productId = parseInt($("#idPro").text());
                              var url = "/cart/addPro/" + productId;
                              console.log(CurrentCount,productId,url)
                              $.ajax({
                                url: url,
                                type: "POST",
                                data:{
                                  idPro: productId,
                                  count: CurrentCount,
                                  _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response){
                                  // console.log(response)
                                  if(response.success && response.success !== ""){
                                    $.toast({
                                    heading: 'Thông báo',
                                    text: response.success,
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right'
                                    })
                                  }
                                  else if(response.error !==""){
                                    $.toast({
                                    heading: 'Thông báo',
                                    text: response.error,
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    position: 'bottom-right'
                                    })
                                  }
                                },
                                error: function(){
                                  console.log("có lỗi xảy ra")
                                }
                              })
                            })
                        })
      </script>
      <!-- modal thông báo thêm hàng vào giỏ  -->
      <div class="modal fade" id="modalbuyproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Đã thêm sản phẩm vào giỏ hàng !
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Hủy</button>
              <button type="button" class="btn btn-success" data-bs-dismiss="modal">Xác
                nhận</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End mục sản phẩm-->
@endforeach
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="cartSuccess" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>

<!--footer end-->
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
  const toastTrigger = document.getElementById('liveToastBtn');
        const toastLiveExample = document.getElementById('liveToast');

        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            toastTrigger.addEventListener('click', () => {
                toastBootstrap.show()
            })
        }
</script>
@endsection
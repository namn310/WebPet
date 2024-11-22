@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1 style="font-size:2.5vw;font-size:2.5vh">Danh Sách Đơn Hàng</h1>

</div><!-- End Page Title -->
@if (session('status'))
<script>
  // $.toast({
  //                       heading: 'Success',
  //                       text: '{{ session('status') }}',
  //                       showHideTransition: 'slide',
  //                       icon: 'success',
  //                       position: 'bottom-right'
  //                       })
  $.toast({
    heading: 'Success',
    text: '{{ session('status') }}',
    showHideTransition: 'slide',
    icon: 'success',
    position: 'bottom-right'
  })
</script>

@endif
<section class="section">
  <div class="row">
    <div class="search mt-4 mb-4 input-group" style="width:50%">
      <button class="input-group-text btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
      <input style="font-size:2vw;font-size:2vh" class="form-control" type="text" id="searchOrders">
    </div>
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body table-responsive">

          <!-- Table with stripped rows -->
          <table style="font-size:2vw;font-size:2vh" class="table text-center">
            <thead>
              <tr>
                <th>
                  <b>I</b>D đơn hàng
                </th>
                <th>Khách Hàng </th>
                <th>Số điện thoại</th>
                <th>Ngày đặt</th>
                <th>Tình trạng</th>
                <th>Tính năng</th>
              </tr>
            </thead>

            <tbody id="table-order">
              @foreach ($Order as $order )
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->getCus($order->idCus) }}</td>
                <td>{{ $order->getPhone($order->idCus) }}</td>
                <td>{{ $order->created_at }}</td>
                @if ($order->status > 0)
                <td><button style="font-size:2vw;font-size:2vh" class=" btn btn-success">Đã giao hàng</button> </td>
                @else
                <td><button style="font-size:2vw;font-size:2vh" class="btn btn-danger">Chưa giao hàng</button> </td>
                @endif

                <td>
                  <a style="color:white;text-decoration:none"> <button style="font-size:2vw;font-size:2vh" data-bs-toggle="modal"
                      data-bs-target="#deleteOrder{{ $order->id }}" class="btn btn-danger"> <i
                        class="bi bi-trash"></i></button></a>
                  <!-- Modal xóa order -->
                  <div class="modal fade" id="deleteOrder{{ $order->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <h5>Bạn có chắc chắn muốn xóa đơn hàng này không ?</h5>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                          <a href="{{ route('admin.deleteOrder',['id'=>$order->id]) }}"> <button type="button"
                              class="btn btn-primary">Xác
                              nhận</button></a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <a> <button style="font-size:2vw;font-size:2vh" data-bs-toggle="modal" data-bs-target="#delivery{{ $order->id }}"
                      class="btn btn-success"><i class="fa-solid fa-truck"></i></button></a>
                  <!-- Modal giao hàng -->

                  <div class="modal fade" id="delivery{{ $order->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <h5>Xác nhận giao hàng</h5>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                          <a href="{{ route('admin.delivery',['id'=>$order->id]) }}">@csrf <button type="submit"
                              class="btn btn-primary">Xác
                              nhận</button></a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button style="font-size:2vw;font-size:2vh" class="btn btn-primary"><a style="color:white;text-decoration:none"
                      href="{{ route('admin.detail',['id'=>$order->id]) }}">Xem </a></button>

                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
          <!-- End Table with stripped rows -->

          <ul class="pagination">
            <li style="font-size:2vw;font-size:2vh" class="page-item disabled"><a href="#" class="page-link">Trang</a></li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- Button trigger modal -->


<!-- ===== Footer ===== -->



<script>
  const toastTrigger = document.getElementById('liveToastBtn')
  const toastLiveExample = document.getElementById('liveToast')

  if (toastTrigger) {
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
    toastTrigger.addEventListener('click', () => {
      toastBootstrap.show()
    })
  }
</script>
<script>
  $(document).ready(function() {
    $("#searchOrders").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#table-order tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>
@endsection
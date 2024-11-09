@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <h1 style="font-size:2.5vw;font-size:2.5vh">Quản lý Vouchers</h1>
    <!-- End Page Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
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
                    <div class="button-function d-flex justify-content-between mt-3 mb-4" style="width:70%">

                        <button style="font-size:2vw;font-size:2vh" id="uploadfile" class="btn btn-success"
                            type="button" title="Nhập"><a id="addnhanvien" href="{{ route('admin.createVoucher') }}"><i
                                    class="fas fa-plus"></i>>
                                Tạo mới Voucher</a></button>

                    </div>
                    <div class="search mt-4 mb-4 input-group" style="width:50%">
                        <button style="font-size:2vw;font-size:2vh" class="input-group-text btn btn-success"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="form-control" type="text" id="searchNV">
                    </div>



                    <table style="font-size:2vw;font-size:2vh" class="table table-hover table-bordered text-center"
                        cellpadding="0" cellspacing="0" border="0" id="sampleTable">
                        <thead>

                            <tr class="table-primary">

                                <th>
                                    Mã Voucher
                                </th>
                                <th>
                                    Giảm giá
                                </th>
                                <th>Số lượng</th>
                                <th>Điều kiện áp dụng</th>
                                <th>
                                    Thời gian bắt đầu
                                </th>
                                <th>Thời gian kết thúc</th>
                                <th>
                                    Tình trạng
                                </th>
                                <th>
                                    Tính năng
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table-nv">
                            @foreach ($voucher as $row )

                            <tr>
                                <td>{{ $row->ma }}</td>
                                <td>{{ $row->discount }}%</td>
                                <td>{{ $row->soluong }}
                                </td>
                                <td>
                                    @if ($row->dk_hoadon !='')
                                    <p>Áp dụng cho hóa đơn tối thiểu {{ number_format($row->dk_hoadon) }}đ</p>
                                    @endif
                                    @if($row->dk_soluong !='')
                                    <p>Áp dụng với số lượng sản phẩm trong đơn hàng là {{ $row->dk_soluong }}</p>
                                    @endif
                                    @if($row->dk_hoadon =='' && $row->dk_soluong =='')
                                    <p>Áp dụng cho mọi đơn hàng</p>
                                    @endif
                                </td>
                                <td>{{ $row->time_start }}</td>
                                <td>{{ $row->time_end }}</td>

                                @if ($row->status==2)
                                <td>
                                    <p class="text-secondary">Voucher chưa khả dụng</p>
                                </td>
                                @elseif ($row->status==1)
                                <td>
                                    <p class="text-success">Voucher khả dụng</p>
                                </td>
                                @elseif ($row->soluong<=0)
                                <td>
                                    <p class="text-success">Voucher đã hết</p>
                                </td>
                                @else
                                <td>
                                    <p class="text-danger">Voucher đã hết hạn</p>
                                </td>
                                @endif
                                <td class="table-td-center">
                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-danger btn-sm trash"
                                        data-bs-target="#delete{{ $row->id }}" data-bs-toggle="modal" type="button">
                                        <a style="color:white"> <i class="fas fa-trash-alt"></i></a>
                                    </button>
                                    <!-- Modal xóa -->
                                    <div class="modal fade" id="delete{{ $row->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có muốn xóa chương trình này không ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    @csrf
                                                    @method('delete')
                                                    <button type="button" class="btn btn-primary"><a
                                                            style="text-decoration:none;color:white"
                                                            href="{{ route('admin.destroyVoucher',['id'=>$row->id]) }}">Đồng
                                                            ý</a></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- button sửa voucher --}}
                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-success btn-sm edit"
                                        type="button" title="Sửa" id="show-emp" data-bs-toggle="modal"
                                        data-bs-target="#update">
                                        <a style="text-decoration:none;color:white"
                                            href="{{ route('admin.changeVoucher',['id'=>$row->id]) }}"> <i
                                                class="fas fa-edit"></i></a>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $voucher->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ======= Footer ======= -->
<script>
    $(document).ready(function() {
            $("#searchNV").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table-nv tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
</script>
@endsection
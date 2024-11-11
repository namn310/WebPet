@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
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
    <h1 style="font-size:2.5vw;font-size:2.5vh">Quản lý nhân viên</h1>
    <!-- End Page Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="button-function d-flex justify-content-between mt-3 mb-4" style="width:70%">

                        <button style="font-size:2vw;font-size:2vh" id="uploadfile" class="btn btn-success" type="button" title="Nhập"><a id="addnhanvien"
                                href="{{ route('admin.staffCreate') }}"><i class="fas fa-plus"></i>>
                                Tạo mới nhân viên</a></button>

                    </div>
                    <div  class="search mt-4 mb-4 input-group" style="width:50%">
                        <button style="font-size:2vw;font-size:2vh" class="input-group-text btn btn-success"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="form-control" type="text" id="searchNV">
                    </div>



                    <table style="font-size:2vw;font-size:2vh" class="table table-hover table-bordered text-center" cellpadding="0" cellspacing="0"
                        border="0" id="sampleTable">
                        <thead>
                            <tr class="table-primary">

                                <th>
                                    ID nhân viên
                                </th>
                                <th>
                                    Họ và tên
                                </th>
                                <th>
                                    Ảnh thẻ
                                </th>
                                <th>Ngày sinh</th>
                                <th>CMND</th>
                                <th>SĐT</th>
                                <th>email</th>
                                <th>Chức vụ</th>
                                <th>
                                    Tính năng
                                </th>
                            </tr>
                        </thead>
                        <tbody id="table-nv">
                            @foreach ($staff as $row )
                            <tr>

                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>
                                    <img class="img-fluid" style="max-width:150px"
                                        src="{{ asset('assets/img-nhanvien/'.$row->image) }}" alt="" />
                                </td>

                                <td>{{ $row->date }}</td>
                                <td>{{ $row->CMND }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->chucvu }}</td>
                                <td class="table-td-center">
                                    {{-- button xóa --}}
                                    <button style="font-size:2vw;font-size:2vh" class="btn btn-danger btn-sm trash" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $row->id }}" type="button" title="Xóa">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="delete{{ $row->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Bạn có muốn xóa không ?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <a style="text-decoration:none;color:white"
                                                        href="{{ route('admin.staffDestroy',['id'=>$row->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="button" class="btn btn-primary">Xác nhận</button>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Button sửa --}}
                                    <a href="{{ route('admin.staffEdit',['id'=>$row->id]) }}"><button style="font-size:2vw;font-size:2vh"
                                            class="btn btn-success btn-sm edit" type="button" title="Sửa" id="show-emp"
                                            data-bs-toggle="modal">
                                            <i class="fas fa-edit"></i>
                                        </button></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal xóa -->
<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Bạn có muốn xóa không ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <a style="text-decoration:none;color:white" href="index.php?controller=nhanvien&action=delete&id">
                    <button type="button" class="btn btn-primary">Xác nhận</button> </a>

            </div>
        </div>
    </div>
</div>



<!-- ======= Footer ======= -->



<script type="text/javascript">
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
        $("#searchNV").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table-nv tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $("#searchProduct").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table-product tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
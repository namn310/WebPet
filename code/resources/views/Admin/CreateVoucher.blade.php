@extends('Admin.Layout')
@section('content')

<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.voucher') }}">Quản lý Vouchers</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm Voucher</li>
        </ol>
    </nav>
    <div style="background-color: white;padding:20px;border-radius:20px;box-shadow: 2px 2px 2px #FFCC99;">
        <!-- End Page Title -->
        <form style="font-size:2vw;font-size:2vh" method="post" id="AddProForm"
            action="{{ route('admin.storeVoucher') }}" enctype="multipart/form-data" class="row mt-4">
            @csrf
            @method('POST')
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Mã Voucher</label>
                <input style="font-size:2vw;font-size:2vh" type="text" class="form-control" id="namepro" name="ma"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Số lượng</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" name="count" id="countpro" type="text"
                    required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Giảm giá</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" name="discount" id="countpro"
                    type="text" required>
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Điều kiện áp dụng cho hóa đơn</label>
                <input style="font-size:2vw;font-size:2vh" placeholder="Nhập giá trị tối thiểu của hóa đơn"
                    class="form-control" name="dk_hoadon" id="countpro" type="text">
            </div>
            <div class="form-group col-md-4">
                <label style="font-weight: bolder;" class="control-label">Điều kiện áp dụng với số lượng</label>
                <input style="font-size:2vw;font-size:2vh" placeholder="Nhập số lượng sản phẩm tối thiểu"
                    class="form-control" name="dk_soluong" id="countpro" type="text">
            </div>

            <div class="form-group  col-md-4">
                <label style="font-weight: bolder;" class="control-label mt-3">Ngày áp dụng</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" id="giavonpro" name="dateStart"
                    type="date" required>
            </div>
            <div class="form-group  col-md-4">
                <label style="font-weight: bolder;" class="control-label mt-3">Ngày kết thúc</label>
                <input style="font-size:2vw;font-size:2vh" class="form-control" id="giavonpro" name="dateEnd"
                    type="date" required>
            </div>
            <div class="form-group ">
                <label style="font-weight: bolder;" class="control-label mt-3">Mô tả</label>
                <textarea style="font-size:2vw;font-size:2vh" id="mota" name="mota" class="form-control"> </textarea>
                <script type="text/javascript">
                    CKEDITOR.replace("mota");
                </script>
            </div>
            <div>
                <button class="btn btn-success mt-4 ms-2" type="submit" id="buttonAddPro"
                    style="width:10%;font-size:2vw;font-size:2vh" value="Thêm" name="addproduct"> Thêm
                </button>
            </div>
        </form>

    </div>
</div>






<!-- ======= Footer ======= -->



<script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/31.0.0/classic/translations/vi.js"> </script>
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
        max-height: 450px;
    }
</style>
<script>
    ClassicEditor.create(document.querySelector('#mota'), {
            language: 'vi'
        })
        .then(editor => {})
        .catch(error => {
            console.error(error)
        });
</script>
@endsection
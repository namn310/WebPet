@extends('Admin.Layout')
@section('content')

<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size:2vw;font-size:2vh">
            <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Quản lý danh mục</a></li>
            <li class="breadcrumb-item active" aria-current="page">Thêm danh mục</li>
        </ol>
    </nav>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible" style="width:20%;position: absolute;right:20px;top:100px">
        <p>{{ session('error') }}</p>
        <button class="btn btn-close"  data-bs-dismiss="alert"></button>
    </div>
    @endif
    <!-- End Page Title -->
    <form style="font-size:2vw;font-size:2vh" id="AddForm" method="post" class="AddForm row mt-4" action="{{ route('admin.createCat') }}"
        enctype="multipart/form-data"
        style="background-color: white;padding:20px;border-radius:20px;box-shadow: 2px 2px 2px #FFCC99;">
        @csrf

        <div class="form-group col-md-4">
            <label style="font-weight: bolder;" class="control-label">Tên danh mục</label>
            <input style="font-size:2vw;font-size:2vh" class="form-control" id="nameDM" name="nameDM" onclick="checkName()" onchange="checkName()"
                type="text">
        </div>
        <button class="btn btn-success mt-4" type="submit" href="" id="addbutton" style="width:10%;font-size:2vw;font-size:2vh">Thêm</button>
    </form>
</div>



<!-- ======= Footer ======= -->




<script>
    function checkName() {
        var name_correct =
            /^[A-Za-z\sAÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬBCDĐEÈẺẼÉẸÊỀỂỄẾỆFGHIÌỈĨÍỊJKLMNOÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢPQRSTUÙỦŨÚỤƯỪỬỮỨỰVWXYỲỶỸÝỴZaàảãáạăằẳẵắặâầẩẫấậbcdđeèẻẽéẹêềểễếệfghiìỉĩíịjklmnoòỏõóọôồổỗốộơờởỡớợpqrstuùủũúụưừửữứựvwxyỳỷỹýỵz]+$/;
        var name = document.getElementById("nameDM");
        var name_val = document.getElementById("nameDM").value;
        if (name_val == "" || name_correct.test(name_val) == false) {
            name.classList.add("is-invalid");
            return false;
        } else {
            name.classList.remove("is-invalid");
            name.classList.add("is-valid");
            return true;
        }
    }

    function checkID() {
        var id = document.getElementById("idNV");
        var id_val = id.value;
        if (id_val == "") {
            id.classList.add("is-invalid");
            return false;
        } else {
            id.classList.remove("is-invalid");
            id.classList.add("is-valid");
            return true;
        }
    }

    function checkPhone() {
        var correct_phone =
            /^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/;
        var phone = document.getElementById("phoneNV");
        var phone_val = parseInt(phone.value);
        if (phone_val == "" || correct_phone.test(phone_val) == false) {
            phone.classList.add("is-invalid");
            return false;
        } else {
            phone.classList.remove("is-invalid");
            phone.classList.add("is-valid");
            return true;
        }
    }

    function checkEmail() {
        var correct_email =
            /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var email = document.getElementById("emailNV");
        var email_val = email.value;
        if (email_val == "" || correct_email.test(email_val) == false) {
            email.classList.add("is-invalid");
            return false;
        } else {
            email.classList.remove("is-invalid");
            email.classList.add("is-valid");
            return true;
        }
    }

    function checkLocalNV() {
        var locate_cus = document.getElementById("localNV");
        var locate_val = locate_cus.value;
        if (locate_val == "") {
            locate_cus.classList.add("is-invalid");
            return false;
        } else {
            locate_cus.classList.remove("is-invalid");
            locate_cus.classList.add("is-valid");
            return true;
        }
    }

    function checkNoiSinhNV() {
        var locate_cus = document.getElementById("noisinhNV");
        var locate_val = locate_cus.value;
        if (locate_val == "") {
            locate_cus.classList.add("is-invalid");
            return false;
        } else {
            locate_cus.classList.remove("is-invalid");
            locate_cus.classList.add("is-valid");
            return true;
        }
    }

    function checkDateNV() {
        var a = $("#dateNV").val();
        var b = new Date(a);
        if (!b.getTime()) {
            $("#dateNV").addClass("is-invalid")
            return false;
        } else {
            $("#dateNV").removeClass("is-invalid");
            $("#dateNV").addClass("is-valid");
            return true;
        }

    }

    function checkDateCMND() {
        var a = $("#date_cmnd").val();
        var b = new Date(a);
        if (!b.getTime()) {
            $("#date_cmnd").addClass("is-invalid")
            return false;
        } else {
            $("#date_cmnd").removeClass("is-invalid");
            $("#date_cmnd").addClass("is-valid");
            return true;
        }

    }

    function checkLocalCMND() {
        var locate_cus = document.getElementById("local_cmnd");
        var locate_val = locate_cus.value;
        if (locate_val == "") {
            locate_cus.classList.add("is-invalid");
            return false;
        } else {
            locate_cus.classList.remove("is-invalid");
            locate_cus.classList.add("is-valid");
            return true;
        }
    }

    function checkSex() {
        var city = document.getElementById("sex");
        var city_val = city.value;
        if (city_val === "Chọn giới tính") {
            city.classList.add("is-invalid");
            return false;
        } else {
            city.classList.remove("is-invalid");
            city.classList.add("is-valid");
            return true;
        }
    }

    function checkChucVuNV() {
        var city = document.getElementById("chucvuNV");
        var city_val = city.value;
        if (city_val === "Chọn chức vụ") {
            city.classList.add("is-invalid");
            return false;
        } else {
            city.classList.remove("is-invalid");
            city.classList.add("is-valid");
            return true;
        }
    }

    function checkBangCapNV() {
        var city = document.getElementById("bangcapNV");
        var city_val = city.value;
        if (city_val === "Chọn bằng cấp") {
            city.classList.add("is-invalid");
            return false;
        } else {
            city.classList.remove("is-invalid");
            city.classList.add("is-valid");
            return true;
        }
    }

    function checkHonNhanNV() {
        var city = document.getElementById("honnhanNV");
        var city_val = city.value;
        if (city_val === "Chọn tình trạng hôn nhân") {
            city.classList.add("is-invalid");
            return false;
        } else {
            city.classList.remove("is-invalid");
            city.classList.add("is-valid");
            return true;
        }
    }

    function checkImgNV() {
        var a = $("#uploadImgNV").val();
        if (a.length <= 0) {
            $("#uploadImgNV").addClass("is-invalid");
        } else {
            $("#uploadImgNV").removeClass("is-invalid");
            $("#uploadImgNV").addClass("is-valid");
        }
    }

    function checkCMND() {
        var locate_cus = document.getElementById("CMND");
        var locate_val = locate_cus.value;
        if (locate_val.length <= 8 || locate_val.length > 11 || locate_val.length == 10 || !parseInt(locate_val)) {
            locate_cus.classList.add("is-invalid");
            return false;
        } else {
            locate_cus.classList.remove("is-invalid");
            locate_cus.classList.add("is-valid");
            return true;
        }
    }

    function checkFormAddNV() {
        if (checkName() == false) {
            alert("Vui lòng kiểm tra lại thông tin");
        } else {
            confirm("Đã thêm thành công");

        }
    }
</script>
@endsection
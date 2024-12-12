@extends('User.LayoutTrangChu')

@section('content')
<!-- user infor -->
<div class="inforUserView">
    @if (session('notice'))
    <script>
        $.toast({
                          heading: 'Success',
                          text: '{{ session('notice') }}',
                          showHideTransition: 'slide',
                          icon: 'success',
                          position: 'bottom-right',
                          })
    </script>
    @endif
    <div class="row g-3 align-items-center mx-auto ">
        <div class="col-3">
            <div class="card border-0 ">
                @if (Auth('customer')->user()->image !='')
                <img src="{{ asset('assets/img-avt-customer/'.Auth('customer')->user()->image) }}"
                    class="card-img-top rounded-circle w-50 mx-auto" alt="">
                @else
                <img src="{{ asset('assets/img/avatar-trang-99.jpg') }}"
                    class="card-img-top rounded-circle w-50 mx-auto" alt="">
                @endif
            </div>
        </div>
        <div class="col-6">
            <div class="container">
                <form name="frmChange" method="post" action="{{ route('user.changePass') }}">
                    @csrf
                    @method('PUT')
                    <h2 class="text-center" style="color:#EA9E1E">Đổi mật khẩu</h2>
                    <div>
                        <div class="row">
                            <label class="form-label">Mật khẩu hiện tại</label>
                            <span id="currentPassword" class="validation-message"></span> <input type="password"
                                placeholder="Nhập mật khẩu" name="currentPass" class="form-control" required>
                            @if (session('errorPass'))
                            <p id="pass_error" class="text-danger">{{ session('errorPass') }} </p>
                            @endif


                        </div>
                        <div class="row">
                            <label class="form-label">Mật khẩu mới</label> <span id="newPassword"
                                class="validation-message"></span><input class="form-control" required type="password"
                                name="newPass" placeholder="Nhập mật khẩu mới" class="full-width">
                            @error('newPass')
                            <p id="pass_error" class="text-danger">{{ $message }} </p>
                            @enderror

                        </div>
                        <div class="row mt-2">
                            <label class="form-label">Xác nhận mật khẩu</label>
                            <span id="confirmPassword" class="validation-message"></span><input class="form-control"
                                type="password" required name="confirmPass" class="full-width"
                                placeholder="Nhập lại mật khẩu">
                            @error('confirmPass')
                            <p id="pass_error" class="text-danger">{{ $message }} </p>
                            @enderror

                        </div>
                        <div class="row mt-3">
                            <button type="submit" id="submit" name="submit" class="btn btn-primary"
                                class="full-width">Xác
                                nhận</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>
</div>
<script>
    $(document).ready(function() {

        $("#confirm_pass_error").hide();
    })
</script>
<!--footer end-->
@endsection
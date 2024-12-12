<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/user-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user1.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    {{-- toast message --}}
    <script src="
        https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.js
        "></script>
    <link href="
        https://cdn.jsdelivr.net/npm/jquery-toast-plugin@1.3.2/dist/jquery.toast.min.css
        " rel="stylesheet">
</head>
</head>

<body>
    @if (session('status'))
    <script>
        $.toast({
                                heading: 'Thông báo',
                                text: '{{ session('status') }}',
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right'
                                })
    </script>
    @endif
    @if (session('notice'))
    <script>
        $.toast({
                                heading: 'Thông báo',
                                text: '{{ session('notice') }}',
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right'
                                })
    </script>
    @endif
    @if (session('statusSuccess'))
    <script>
        $.toast({
                                    heading: 'Thông báo',
                                    text: '{{ session('statusSuccess') }}',
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    position: 'bottom-right'
                                    })
    </script>
    @endif
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                style="background: #FFE4DA;">
                <div class="featured-image mb-3">
                    <img src="{{ asset('assets/img/PetCARE.png') }}" class="img-fluid mt-3" style="width:100%">
                </div>
            </div>
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h3 class="text-center"
                            style="font-family: 'Courier New', Courier, monospace;font-weight: 600;">Đăng Nhập</h3>
                    </div>

                    <form id="loginForm" method="post" action="{{ route('user.checkLogin') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg bg-light fs-6" id="email_login"
                                name="email" placeholder="Nhập Email của bạn">
                            <p class="emailError text-danger"></p>
                        </div>
                        <div class="form-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" name="password"
                                id="password" placeholder="Nhập mật khẩu">
                            <p class="passwordError text-danger"></p>
                        </div>

                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Nhớ tài
                                        khoản!</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="{{ route('user.forgetPass') }}">Quên Mật Khẩu?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-warning w-100 fs-6" type="submit" id="submit"><a
                                    style="text-decoration: none;color:white">Đăng Nhập</a></button>
                        </div>
                    </form>
                    <div class="input-group mb-3 align-items-center d-flex justify-content-center">
                        <img src="{{ asset('assets/img/google_logo-google_icongoogle-512.webp') }}"
                            class="img-fluid me-3" style="width:5%;height:5%">
                        <a style="text-decoration: none;color:black" href="{{ route('loginGoogle') }}">Đăng nhập bằng
                            Google</a>
                    </div>

                    <div class="row">
                        <small>Bạn chưa có tài khoản? <a href="{{ route('user.register') }}">Đăng Ký</a></small>
                    </div>

                </div>
            </div>


        </div>
    </div>
    <script>
        function isEmail(inputEmail) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(inputEmail);
        }

        function validatePassword(inputPassword) {
            return inputPassword.length > 4;
        }

        $(document).ready(function() {
            $('#email_login').change(function() {
                var email = $(this).val().trim();
                // alert(`email = ${JSON.stringify(email)}`)
                if (!isEmail(email)) {
                    //Error ?
                    $(".emailError").html("Địa chỉ email không hợp lệ!");
                } else {
                    $(".emailError").html("");
                }
            });
            $('#password_login').change(function() {
                var password = $(this).val();
                if (!validatePassword(password)) {
                    $(".passwordError").html("Mật khẩu phải có ít nhất 8 ký tự, có ít nhất 1 chữ thường và 1 chữ in");
                } else {
                    $(".passwordError").html("");
                }
            });
        });
    </script>


</body>

</html>
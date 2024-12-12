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
    @if (session('success'))
    <script>
        $.toast({
                                    heading: 'Thông báo',
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
                                        heading: 'Thông báo',
                                        text: '{{ session('error') }}',
                                        showHideTransition: 'slide',
                                        icon: 'error',
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
                            style="font-family: 'Courier New', Courier, monospace;font-weight: 600;">Quên mật khẩu</h3>
                    </div>
                    <div class="text-center">
                        <h5>Điền Email đã đăng ký tài khoản của bạn</h5>
                        <form method="post" action="{{ route('user.sendEmail') }}">
                            @csrf
                            <input type="email" name="email" placeholder="Email" class="form-control">
                            <button class="btn btn-primary mt-3" type="submit">Gửi mã</button>
                        </form>
                    </div>
                    <div class="row mt-4">
                        <small> <a style="text-decoration:none;color:blue" href="{{ route('user.login') }}">Đăng
                                Nhập</a></small>
                    </div>

                </div>
            </div>


        </div>
    </div>

</body>

</html>
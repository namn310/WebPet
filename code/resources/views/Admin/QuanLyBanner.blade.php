@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <h1>Quản lý Banner</h1>
    <!-- End Page Title -->
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('admin.bannerCreate') }}"> <button class="btn btn-success mt-3"><i
                        class="fa-solid fa-plus"></i> Thêm banner</button></a>
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
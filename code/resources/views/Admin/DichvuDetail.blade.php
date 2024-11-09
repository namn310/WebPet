@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="font-size: 22px;">
            <li class="breadcrumb-item"><a href="index.php?controller=dichvu">Quản lý dịch vụ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Xem chi tiết</li>
        </ol>
    </nav>

</div><!-- End Page Title -->
<div class="container-fluid border border-primary rounded">
    <div class="p-4">
        <?php
        foreach ($data as $row) {
        ?>
            <div class="name d-inline-block">
                <span>
                    <b>ID dịch vụ: </b>
                    <i><?php echo $row->id_dichvu  ?></i>

                </span>
            </div>
            <div class="local mt-4 ">
                <span>
                    <b>Tên dịch vụ:</b>
                    <i><?php echo $row->ten_dichvu ?></i>

                </span>
            </div>
            <div class="phone mt-4">
                <span>
                    <b>Chi tiết</b>
                </span>
                <img class="img-fluid mt-3" src="../assets/img-dichvu/<?php echo $row->hinhanh ?>">
            </div>

        <?php } ?>
    </div>
</div>
<!--
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                     Table with stripped rows
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    <b>I</b>D đơn hàng
                                </th>
                                <th>Khách Hàng </th>
                                <th>Đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Tình trạng</th>
                                <th>Tính năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>HD1</td>
                                <td>Bùi An Khang</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-primary">Chờ Thanh Toán</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD2</td>
                                <td>Hoàng Kim Tấn</td>
                                <td>Dụng cụ cắt móng chó</td>
                                <td>1</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-primary">Chờ Thanh Toán</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD3</td>
                                <td>Nguyễn Phương Nam</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD4</td>
                                <td>Bùi An Tấn</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD5</td>
                                <td>Hoàng Kim Nam</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD6</td>
                                <td>Nguyễn Phương Tấn</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD7</td>
                                <td>Trần Văn Tấn</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD8</td>
                                <td>Nguyễn Thị Tấn</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>5</td>
                                <td>500.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD9</td>
                                <td>Bùi An Khang</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD10</td>
                                <td>Bùi An Khang</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD11</td>
                                <td>Bùi An Khang</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-success">Hoàn thành</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>
                            <tr>
                                <td>HD12</td>
                                <td>Bùi An Khang</td>
                                <td>Dụng cụ cắt móng mèo</td>
                                <td>2</td>
                                <td>400.000đ</td>
                                <td>
                                    <button class="disabled btn btn-primary">Chờ Thanh Toán</button>
                                </td>
                                <td>
                                    <button class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                     End Table with stripped rows

                </div>
            </div>

        </div>
    </div>
</section>
-->


<!-- ======= Footer ======= -->
@endsection
@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <h1 style="font-size:2.5vw;font-size:2.5vh">Quản lý khách hàng</h1>
    <!-- End Page Title -->
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="search mt-4 mb-4 input-group" style="width:50%">
                        <button style="font-size:2vw;font-size:2vh" class="input-group-text btn btn-success"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                        <input class="form-control" type="text" id="searchCustomer">
                    </div>
                    <table style="font-size:2vw;font-size:2vh"
                        class="table table-hover table-responsive table-bordered text-center" cellpadding="0"
                        cellspacing="0" border="1" id="sampleTable">
                        <thead>
                            <tr class="table-primary">
                                <th>ID khách hàng</th>
                                <th>Họ và tên</th>
                                <th>SĐT</th>
                                <th>Gmail</th>
                            </tr>
                        </thead>
                        <tbody id="table-customer">
                            @foreach ($customer as $row )
                            <tr>

                                <td>{{ $row->id }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>{{ $row->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $customer->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#searchCustomer").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#table-customer tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
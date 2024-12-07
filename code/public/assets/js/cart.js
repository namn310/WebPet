// $(document).ready(function () {
$("#pay-form").hide();
$(".discount").hide();
$(".totalcost").hide();
$(".buttonThanhToan").click(function () {
    // ẩn hiện form thanh toán
    $("#pay-form").toggle();
    // cập nhật giá trị đơn hàng vào form thanh toán
    var totalCost = $(".CountTotalCostNoFormat").text();
    var totalCostWithDiscount = $("#totalcostNoFormat").text();
    if (totalCost !== "" || totalCostWithDiscount !== "") {
        if (totalCostWithDiscount !== "") {
            $("#totalCostPaymentHidden").val(totalCostWithDiscount);
        } else {
            $("#totalCostPaymentHidden").val(totalCost);
        }
    }
});
$(".useVoucher").click(function () {
    var idVoucherUser = $(this).data("voucher");
    $.ajax({
        url: "/cart/voucher",
        method: "GET",
        data: {
            idVoucherUser: idVoucherUser,
        },
        success: function (response) {
            if (response.discountFormat) {
                $(".discount").show();
                $(".totalcost").show();
                $("#discount").text(response.discountFormat);
                $("#totalcost").text(response.costFormat);
                $("#idVoucher").val(response.idVoucher);
            } else {
                alert(response.error);
            }
        },
    });
});
$(".payment1-detail , .payment2-detail, .payment3-detail").hide();
// toogle phương thức thanh toán
var payment_COD = document.getElementById("payment1");
var payment_banking = document.getElementById("payment2");
var payment_vnpay = document.getElementById("payment3");
if (payment_COD.checked) {
    $(".payment3-detail").hide();
    $(".payment2-detail").hide();
    $(".payment1-detail").show();
}
if (payment_banking.checked) {
    $(".payment1-detail").hide();
    $(".payment2-detail").show();
    $(".payment3-detail").hide();
}
if (payment_vnpay.checked) {
    $(".payment1-detail").hide();
    $(".payment3-detail").show();
    $(".payment2-detail").hide();
}
// Lắng nghe sự kiện thay đổi lựa chọn phương thức thanh toán
$("input[name='payment']").change(function () {
    // Ẩn tất cả các chi tiết thanh toán trước khi hiển thị chi tiết của phương thức thanh toán được chọn
    $(".payment1-detail, .payment2-detail").hide();

    // Kiểm tra phương thức thanh toán được chọn và hiển thị chi tiết tương ứng
    if ($("#payment1").prop("checked")) {
        $(".payment1-detail").show();
    } else if ($("#payment2").prop("checked")) {
        $(".payment2-detail").show();
    } else if ($("#payment3").prop("checked")) {
        $(".payment3-detail").show();
    }
});
function ChangeCount(id) {
    var CurrentCount = parseInt($("#idPro" + id).val());
    // tăng số lượng
    $("#buttonUp" + id).click(function () {
        if (CurrentCount <= 1) {
            CurrentCount = 1;
        }
        CurrentCount += 1;
        $("#idPro" + id).val(CurrentCount);
        var cost = parseInt($("#InputCostHidden" + id).val());
        var discount = parseInt($("#InputDiscountHidden" + id).val());
        if (discount && discount !== "NaN" && discount > 0) {
            var totalCost = CurrentCount * (cost - (cost * discount) / 100);
        } else {
            var totalCost = CurrentCount * cost;
        }
        var totalCostFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(totalCost);
        // cập nhật lại giá trị tiền
        $("#CostCartProductHidden" + id).val(totalCost);
        $("#CostCartProduct" + id).text(totalCostFormat);
        var listCostProduct = document.querySelectorAll(".costProduct");
        var TotalCostCart = 0;
        listCostProduct.forEach(function (element) {
            TotalCostCart += parseInt(element.value);
            // console.log(element.value); //
        });
        var TotalCostCartFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(TotalCostCart);
        $(".CountTotalCost").text(TotalCostCartFormat);
        $(".CountTotalCostNoFormat").text(TotalCostCart);
        // console.log(TotalCostCart)
        // nếu có dùng voucher thì cập nhật lại voucher
        var disountVoucher = $("#discount").text();
        if (disountVoucher !== "NaN") {
            disountVoucher = parseInt(disountVoucher.replace("%", ""));
            $("#totalcost").text(
                new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                }).format(
                    TotalCostCart - (disountVoucher / 100) * TotalCostCart,
                ),
            );
            var TotalCostCartFormatWithVoucher =
                TotalCostCart - (disountVoucher / 100) * TotalCostCart;
            $("#totalcostNoFormat").text(TotalCostCartFormatWithVoucher);
            // console.log(disountVoucher);
        }
        // cập nhật lại tổng tiền trong form thanh toán để gửi đi
        var totalCostNoFormat = $(".CountTotalCostNoFormat").text();
        var totalCostWithDiscountNoFormat = $("#totalcostNoFormat").text();
        if (totalCostNoFormat !== "" || totalCostWithDiscountNoFormat !== "") {
            if (
                totalCostWithDiscountNoFormat !== "" &&
                totalCostWithDiscountNoFormat !== "NaN"
            ) {
                $("#totalCostPaymentHidden").val(totalCostWithDiscountNoFormat);
            } else {
                $("#totalCostPaymentHidden").val(totalCostNoFormat);
            }
        }

        $.ajax({
            url: "/cart/update",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                idPro: id,
                count: CurrentCount,
            },
            success: function (response) {},
        });
    });
    // giảm số lượng
    $("#buttonDown" + id).click(function () {
        if (CurrentCount <= 1) {
            $("#idPro" + id).val("1");
        } else {
            CurrentCount = CurrentCount - 1;
            $("#idPro" + id).val(CurrentCount);
        }
        var cost = parseInt($("#InputCostHidden" + id).val());
        var discount = parseInt($("#InputDiscountHidden" + id).val());
        if (discount && discount !== "NaN" && discount > 0) {
            var totalCost = CurrentCount * (cost - (cost * discount) / 100);
        } else {
            var totalCost = CurrentCount * cost;
        }
        var totalCostFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(totalCost);
        $("#CostCartProduct" + id).text(totalCostFormat);
        // cập nhật lại giá trị tiền
        $("#CostCartProductHidden" + id).val(totalCost);
        $("#CostCartProduct" + id).text(totalCostFormat);
        var listCostProduct = document.querySelectorAll(".costProduct");
        var TotalCostCart = 0;
        listCostProduct.forEach(function (element) {
            TotalCostCart += parseInt(element.value);
            // console.log(element.value); //
        });
        var TotalCostCartFormat = new Intl.NumberFormat("vi-VN", {
            style: "currency",
            currency: "VND",
        }).format(TotalCostCart);
        $(".CountTotalCost").text(TotalCostCartFormat);
        $(".CountTotalCostNoFormat").text(TotalCostCart);
        // nếu có dùng voucher thì cập nhật lại voucher
        var disountVoucher = $("#discount").text();
        if (disountVoucher !== "NaN") {
            disountVoucher = parseInt(disountVoucher.replace("%", ""));
            $("#totalcost").text(
                new Intl.NumberFormat("vi-VN", {
                    style: "currency",
                    currency: "VND",
                }).format(
                    TotalCostCart - (disountVoucher / 100) * TotalCostCart,
                ),
            );
            var TotalCostCartFormatWithVoucher =
                TotalCostCart - (disountVoucher / 100) * TotalCostCart;
            $("#totalcostNoFormat").text(TotalCostCartFormatWithVoucher);
            // console.log(disountVoucher);
        }
        // cập nhật lại tổng tiền trong form thanh toán để gửi đi
        var totalCostNoFormat = $(".CountTotalCostNoFormat").text();
        var totalCostWithDiscountNoFormat = $("#totalcostNoFormat").text();
        if (totalCostNoFormat !== "" || totalCostWithDiscountNoFormat !== "") {
            if (
                totalCostWithDiscountNoFormat !== "" &&
                totalCostWithDiscountNoFormat !== "NaN"
            ) {
                $("#totalCostPaymentHidden").val(totalCostWithDiscountNoFormat);
            } else {
                $("#totalCostPaymentHidden").val(totalCostNoFormat);
            }
        }

        $.ajax({
            url: "/cart/update",
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                idPro: id,
                count: CurrentCount,
            },
            success: function (response) {},
        });
    });
}
// });

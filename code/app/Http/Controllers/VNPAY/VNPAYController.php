<?php

namespace App\Http\Controllers\VNPAY;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;

class VNPAYController extends Controller
{
    public function createPayment(Request $request)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        try {
            // địa chỉ giao hàng
            $address = $request->input('address');
            // ghi chú của khách hàng
            $note = $request->input('note');

            $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
            $vnp_Amount = $request->input('totalCostPaymentHidden'); // Số tiền thanh toán
            $vnp_Locale = $request->input('language'); //Ngôn ngữ chuyển hướng thanh toán
            $vnp_BankCode = $request->input('bankCode'); //Mã phương thức thanh toán
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => config('vnpay.vnp_TmnCode'),
                "vnp_Amount" => $vnp_Amount * 100,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => config('vnpay.vnp_Returnurl'),
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate" => config('vnpay.expire'),
                // "vnp_address" => $address,
                // "vnp_note" => $note,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }

            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }
            // $query .= "address=" . $address;
            // $query .= "&note=" . $note . "&";
            $vnp_Url = config('vnpay.vnp_Url') . "?" . $query;
            if (null !== (config('vnpay.vnp_HashSecret'))) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, config('vnpay.vnp_HashSecret')); //  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }

            // echo $vnp_Url;
            header('Location: ' . $vnp_Url);
            die();
        } catch (Throwable $e) {
            echo $e;
        }
    }
    // public function vnpay_ipn()
    // {
    //     $inputData = array();
    //     $returnData = array();
    //     foreach ($_GET as $key => $value) {
    //         if (substr($key, 0, 4) == "vnp_") {
    //             $inputData[$key] = $value;
    //         }
    //     }

    //     $vnp_SecureHash = $inputData['vnp_SecureHash'];
    //     unset($inputData['vnp_SecureHash']);
    //     ksort($inputData);
    //     $i = 0;
    //     $hashData = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
    //         } else {
    //             $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
    //             $i = 1;
    //         }
    //     }

    //     $secureHash = hash_hmac('sha512', $hashData, config('vnpay.vnp_HashSecret'));
    //     $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
    //     $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
    //     $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

    //     $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
    //     $orderId = $inputData['vnp_TxnRef'];

    //     try {
    //         //Check Orderid    
    //         //Kiểm tra checksum của dữ liệu
    //         if ($secureHash == $vnp_SecureHash) {
    //             //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
    //             //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
    //             //Giả sử: $order = mysqli_fetch_assoc($result);   

    //             $order = NULL;
    //             if ($order != NULL) {
    //                 if ($order["Amount"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
    //                 {
    //                     if ($order["Status"] != NULL && $order["Status"] == 0) {
    //                         if ($inputData['vnp_ResponseCode'] == '00' && $inputData['vnp_TransactionStatus'] == '00') {
    //                             $Status = 1; // Trạng thái thanh toán thành công
    //                         } else {
    //                             $Status = 2; // Trạng thái thanh toán thất bại / lỗi
    //                         }
    //                         //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
    //                         //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
    //                         $returnData['RspCode'] = '00';
    //                         $returnData['Message'] = 'Confirm Success';
    //                     } else {
    //                         $returnData['RspCode'] = '02';
    //                         $returnData['Message'] = 'Order already confirmed';
    //                     }
    //                 } else {
    //                     $returnData['RspCode'] = '04';
    //                     $returnData['Message'] = 'invalid amount';
    //                 }
    //             } else {
    //                 $returnData['RspCode'] = '01';
    //                 $returnData['Message'] = 'Order not found';
    //             }
    //         } else {
    //             $returnData['RspCode'] = '97';
    //             $returnData['Message'] = 'Invalid signature';
    //         }
    //     } catch (Throwable $e) {
    //         $returnData['RspCode'] = '99';
    //         $returnData['Message'] = 'Unknow error';
    //     }
    //     //Trả lại VNPAY theo định dạng JSON
    //     return response()->json($returnData);
    //     // echo json_encode($returnData);
    // }
}

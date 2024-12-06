<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor. 
 */


return [
    'vnp_TmnCode' => '1NZDKURE', // Mã định danh merchant kết nối (Terminal Id)
    'vnp_HashSecret' => 'O3CAKBWODH5OCZRDPNKXX8F4C8W787CN', // Secret key
    'vnp_Url' => "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html",
    'vnp_Returnurl' => "http://127.0.0.1:8000/vn_pay/vnpay_return",
    'vnp_apiUrl' => "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html",
    'apiUrl' => "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction",
    'startTime' => date("YmdHis"),
    'expire' => date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis"))))
];

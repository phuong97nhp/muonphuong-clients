<?php
namespace App\Library;
class General 
{
    public static $arrTypeShip = [
        'CPN' => 'Chuyển phát nhanh',
        // 'PTN' => 'Phát trong ngày',
    ];

    public static $arrStatusOrder = [
        1 => 'Chờ xữ lý', 
        2 => 'Yêu cầu phát', 
        3 => 'Đang chờ phát phát', 
        4 => 'Đã phát thành công', 
        5 => 'Hoàn lại đơn hàng'
    ];
}
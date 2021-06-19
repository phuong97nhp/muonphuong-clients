<?php
namespace App\Library\Payment;
class IntoMoney 
{
    public static function getPayment($type, $city, $weight){
        switch ($type) {
            case 'CPN':
                $price = IntoMoney::cpn($city, $weight);
                if(strlen($city) > 3){
                    $price_hx = $price*20/100;
                    $price    = $price +$price_hx;
                }
                
                $pp_xd = 15;
                if($pp_xd > 0){
                    $subcharge  = ($price * $pp_xd)/100;
                }

                $vat = ($price + $subcharge)*10/100;
                $totalcharge = $price +$subcharge;
                break;
            
            default:
                break;
        }

        return [
            'charge' => number_format($price),
            'tax_amount' => number_format($vat),
            'subcharge' => number_format($subcharge),
            'totalcharge' => number_format($totalcharge),
        ];
    }

    private static function cpn($city, $weight){

        $noitinh = ['HCM'];
        $BhaDni = [ 'DNI2', 'DNI21', 'DNI', 'BDG21', 'BDG2', 'BDG'];
        $HniDng = ['HNI', 'DNG'];
        $duoi300 = ['TGG', 'TGG', 'TVH', 'BTE', 'STG', 'HGG1', 'DTP', 'TGG1', 'LAN1', 'TVH1', 'STG1', 'BTE1', 'DTP1', 'HGG11', 'AGG', 'AGG1', 'BLU', 'BLU1', 'BTE1', 'VLG', 'VLG1', 'KGG', 'KGG1', 'CTO1', 'CTO', 'CTO2', 'LAN', 'CMU', 'CMU1', 'NTN', 'NTN1', 'BTN', 'BTN1', 'BPC', 'BPC1', 'VTU', 'TNH', 'TNH1', 'VTU21', 'VTU2', 'BDH', 'BDH1', 'PYN', 'PYN1', 'KHA', 'KHA1', 'PYN', 'HCM1', 'HCM2'];
        $tren300 = ['DKG', 'DKG1', 'QNM', 'QNM', 'QNI', 'QNI1', 'HUE', 'HUE1', 'DKG', 'DKG1', 'HTH', 'HTH1', 'QBH', 'QBH1', 'NAN', 'NAN1', 'QTI', 'QTI1', 'THA', 'THA1', 'QNG', 'QNG1', 'BKN', 'BKN1', 'BGG', 'BGG1', 'BNH', 'BNH1', 'CBG', 'CBG1', 'DBN', 'DBN1', 'HGG', 'HGG1*', 'HNM', 'HNM1', 'HDG', 'HDG1', 'HPG', 'HPG1', 'HBH', 'HBH1', 'HYN', 'HYN1', 'LCU', 'LCU1', 'LCI', 'LCI1', 'LSN', 'LSN1', 'NDH', 'NDH1', 'NBH', 'NBH1', 'PTO', 'PTO1', 'QNH', 'QNH1', 'SLA', 'SLA1', 'TBH', 'TBH1', 'TNN', 'TNN1', 'TQG', 'TQG1', 'VPC', 'VPC1', 'YBI', 'YBI1', 'NBH', 'NBH1', 'KTM', 'KTM1', 'GLI', 'GLI1', 'DLK', 'DLK1', 'DKG', 'DKG1', 'LDG', 'LDG1', 'HCM3'];
        $price = 0;
        if(in_array($city, $noitinh)){
            if(0 < $weight && $weight <= 50) $price = 8000;
            if(51 < $weight && $weight <= 100) $price = 8500;
            if(101 < $weight && $weight <= 250) $price = 9000;
            if(250 < $weight && $weight <= 500) $price = 10500;
            if(501 < $weight && $weight <= 1000) $price = 12000;
            if(1001 < $weight && $weight <= 1500) $price = 15000;
            if(1501 < $weight && $weight <= 2000) $price = 22000;
        }
        if(in_array($city, $BhaDni)){
            if(0 < $weight && $weight <= 50) $price = 8000;
            if(51 < $weight && $weight <= 100) $price = 8900;
            if(101 < $weight && $weight <= 250) $price = 10900;
            if(250 < $weight && $weight <= 500) $price = 14400;
            if(501 < $weight && $weight <= 1000) $price = 20000;
            if(1001 < $weight && $weight <= 1500) $price = 34900;
            if(1501 < $weight && $weight <= 2000) $price = 39700;
        }
        if(in_array($city, $HniDng)){
            if(0 < $weight && $weight <= 50) $price = 8000;
            if(51 < $weight && $weight <= 100) $price = 11000;
            if(101 < $weight && $weight <= 250) $price = 22000;
            if(250 < $weight && $weight <= 500) $price = 28400;
            if(501 < $weight && $weight <= 1000) $price = 41800;
            if(1001 < $weight && $weight <= 1500) $price = 53900;
            if(1501 < $weight && $weight <= 2000) $price = 60500;
        }
        if(in_array($city, $duoi300)){
            if(0 < $weight && $weight <= 50) $price = 8500;
            if(51 < $weight && $weight <= 100) $price = 10500;
            if(101 < $weight && $weight <= 250) $price = 16500;
            if(250 < $weight && $weight <= 500) $price = 23500;
            if(501 < $weight && $weight <= 1000) $price = 33000;
            if(1001 < $weight && $weight <= 1500) $price = 40000;
            if(1501 < $weight && $weight <= 2000) $price = 48500;
        }
        if(in_array($city, $tren300)){
            if(0 < $weight && $weight <= 50) $price = 9500;
            if(51 < $weight && $weight <= 100) $price = 13000;
            if(101 < $weight && $weight <= 250) $price = 22000;
            if(250 < $weight && $weight <= 500) $price = 28600;
            if(501 < $weight && $weight <= 1000) $price = 41800;
            if(1001 < $weight && $weight <= 1500) $price = 53900;
            if(1501 < $weight && $weight <= 2000) $price = 63500;
        }
        return $price;
    }
}

<?php

namespace App\Imports\Excel;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Order;
use App\Library\Address\ReadAddress;
use App\Library\Payment\IntoMoney;
use App\Library\General;
use Auth;

class ImportOrders implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // $arrCity  =  ReadAddress::readFileName('city_md5'); 
        // $arrDistrict  =  ReadAddress::readFileName('district_md5'); 
        // $arrWard  =  ReadAddress::readFileName('ward_md5'); 
        // $arrDistrictState  =  ReadAddress::readFileName('district_state'); 
        foreach ($collection as $key => $value) {
            if($key >= 6 ){
                // $intCity = $arrCity[md5(General::getSlug($value[8]))]['code'];
                // $intDistrict = $arrDistrict[md5(General::getSlug($value[9]))]['code'];
                // $intWard = $arrWard[md5(General::getSlug($value[10]))]['code'];
                // $strState = $arrDistrictState[$intDistrict]['state'];
                // $intWeight =  $value[3]; 
                // $strType = array_search($value[11], General::$arrTypeShip);
                // $strPayments = array_search($value[12], General::$arrPayments); 
                // $intIntoMony = IntoMoney::getPayment($strType, $strState, $intWeight)["totalcharge"];

                $intCity = $value[8];
                $intDistrict = $value[9];
                $intWard = $value[10];
                $intWeight =  $value[3]; 
                $strType = $value[11];
                $strPayments = $value[12]; 
                $intIntoMony = 0;
                $arrData =  [
                    'code_az'          => (string) time().$value[0],
                    'code_customer'    => (string) Auth::user()["code_customer"],
                    'code_b2b'         => null,
                    'code_b2c'         => $value[1],
                    'enter_date'       => date('Y-m-d H:i:s'),
                    'request_date'     => null,
                    'confrim_date'     => null,
                    'get_date'         => null,
                    'phone_b2c'        => (string) $value[6],
                    'name_from'        => null,
                    'code_product'     => null,
                    'full_name_b2c'    => $value[5],
                    'address'          => (string)  $value[7],
                    'city'             => (string) $intCity,
                    'ward'             => (string) $intWard,
                    'district'         => (string) $intDistrict,
                    'weight'           => (int) $intWeight,
                    'total'            => null,
                    'packages'         => (int) 1,
                    'address_id'       => (int) Auth::user()["address_id"],
                    'collection_money' => (int) $value[4],
                    'into_money'       => (string) $intIntoMony,
                    'type'             => (string) $strType,
                    'name_get'         => null,
                    'name_confrim'     => null,
                    'content'          => (string) $value[14].$value[2],
                    'status'           => 1,
                    'is_deleted'       => 0,
                    'create_user'      => Auth::id(),
                    'update_user'      => Auth::id(),
                    'created_at'       => date('Y-m-d H:i:s'),
                    'updated_at'       => null,
                    'payments'         => $strPayments,
                ];

                Order::insert($arrData);
            }
        }
    }
}

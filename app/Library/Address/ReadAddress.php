<?php
namespace App\Library\Address;
class ReadAddress 
{
    public static function getCity($id,$strKey = 'name'){
        if(empty($id)){
            return false;
        }

        $path = storage_path() . "/json/tinh_tp.json";
        $arrDate = json_decode(file_get_contents($path), true); 
        $result =  empty($arrDate[$id][$strKey])?'Không xác định':$arrDate[$id][$strKey];
        return $result;
    }

    public static function getDistrict($id,$strKey = 'name'){
        if(empty($id)){
            return false;
        }

        $path = storage_path() . "/json/quan_huyen.json";
        $arrDate = json_decode(file_get_contents($path), true); 
        $result =  empty($arrDate[$id][$strKey])?'Không xác định':$arrDate[$id][$strKey];
        return $result;
    }

    public static function getDistrictState($id,$strKey = 'state'){
        if(empty($id)){
            return false;
        }

        $path = storage_path() . "/json/district_state.json";
        $arrDate = json_decode(file_get_contents($path), true); 
        $result =  empty($arrDate[$id][$strKey])?'Không xác định':$arrDate[$id][$strKey];
        return $result;
    }

    public static function getWard($id,$strKey = 'name'){
        if(empty($id)){
            return false;
        }

        $path = storage_path() . "/json/xa_phuong.json";
        $arrDate = json_decode(file_get_contents($path), true); 
        $strResult = (!empty($arrDate[$id][$strKey]))?$arrDate[$id][$strKey]:'';
        $result =  empty($arrDate[$id][$strKey])?'Không xác định':$arrDate[$id][$strKey];
        return $result;
    }

    public static function getAddress($arrAddress,$strKey = 'name'){
        if(empty($arrAddress) || !is_array($arrAddress)){
            return false;
        }
        $strAddress = ReadAddress::getWard($arrAddress[0], $strKey). ', '.ReadAddress::getDistrict($arrAddress[1], $strKey). ', '.ReadAddress::getCity($arrAddress[2], $strKey);
        $result =  empty($strAddress)?'Không xác định':$strAddress;
        return $result;
    }

    public static function test(){
        $path = storage_path() . "/json/quan_huyen.json";
        $arrDate = json_decode(file_get_contents($path), true);
        
        $pathCity = storage_path() . "/json/tinh_tp.json";
        $arrDateCity = json_decode(file_get_contents($pathCity), true); 

        // "02197": {
        //     "name": "Liêm Thuỷ",
        //     "type": "xa",
        //     "slug": "liem-thuy",
        //     "name_with_type": "Xã Liêm Thuỷ",
        //     "path": "Liêm Thuỷ, Na Rì, Bắc Kạn",
        //     "path_with_type": "Xã Liêm Thuỷ, Huyện Na Rì, Tỉnh Bắc Kạn",
        //     "code": "02197",
        //     "parent_code": "066"
        // }

        // "name": "Từ Sơn",
        // "type": "thi-xa",
        // "slug": "tu-son",
        // "name_with_type": "Thị xã Từ Sơn",
        // "path": "Từ Sơn, Bắc Ninh",
        // "path_with_type": "Thị xã Từ Sơn, Tỉnh Bắc Ninh",
        // "code": "261",
        // "parent_code": "27"
        $arrJson = [];
        foreach ($arrDate as $key => $value) {
            $arrPrent = $arrDateCity[$value["parent_code"]]; 
            $arrJson[$value['code']] = [
                'id' => $key,
                "name" => $value['name'],
                "state" => ReadAddress::creatCodeAddressCity($arrPrent['slug'], $value['type']),
                "type" => $value['type'],
                "slug" => $value['slug'],
                "name_with_type" => $value['name_with_type'],
                "path" => $value['path'],
                "path_with_type" => $value['path_with_type'],
                "code" => $value['code'],
                "parent_code" => $value['parent_code']
            ];
        }

        $pathWard = storage_path() . "/json/district_state.json";
        $fp = fopen($pathWard, 'w');
        fwrite($fp, json_encode($arrJson, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        fclose($fp);
        die;
    }

    private static function creatCodeAddress($str) {
        $ret = '';
        $arrText = explode('-', $str); 
        foreach ($arrText as $word) {
            $ret .= substr($word, 0, 1); 
        }
        return strtoupper($ret.substr(end($arrText), -1));
    }

    private static function creatCodeAddressDistrict($str, $type) {
        $ret = '';
        $arrText = explode('-', $str); 
        foreach ($arrText as $word) {
            $ret .= substr($word, 0, 1); 
        }
        $result = $ret.substr(end($arrText), -1);
        if ($type == 'thanh-pho' || $type == 'quan') 
        {
            $result =  $result;
        }else {
            $result =  $result;
        }
        return strtoupper($result);
    }

    private static function creatCodeAddressCity($str, $type) {
        $ret = '';
        $arrText = explode('-', $str); 
        foreach ($arrText as $word) {
            $ret .= substr($word, 0, 1); 
        }
        $result = $ret.substr(end($arrText), -1);
        if ($type == 'huyen' || $type == "thi-xa") 
        {
            $result =  $result.'1';
        }
        return strtoupper($result);
    }
}

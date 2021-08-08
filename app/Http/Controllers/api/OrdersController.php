<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\General;
use App\Library\Address\ReadAddress;
use App\Models\Order;
use Illuminate\Routing\Route;
use App\Library\Tracking\Tracking;

class OrdersController extends Controller
{
    public function exportDetailTracking(Request $request){
        try {
            if (!$request->isMethod('get')) {
                $arrReponse = [
                    'success' => false,
                    'code' => -10,
                    'messenger' => 'Chúng tôi không hỗ trợ phương thư GET.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if ($request->input('key_access') !== 'Iay9TFsj9Je5lOewtiQK4p5Qx3Vjo') {
                $arrReponse = [
                    'success' => false,
                    'code' => -10,
                    'messenger' => 'Bạn cần nhập vào KEY.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if (empty($request->input('code'))) {
                $arrReponse = [
                    'success' => false,
                    'code' => -10,
                    'messenger' => 'Bạn cần nhập vào code trước khi xem đơn vận này.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            $strCodeBill = $request->input('code');

            $strUrlApi247 = "https://tracking.247post.vn/api/Order/v1/Tracking?ordercode=$strCodeBill&apikey=B3059854-5366-4250-A2CD-F66F0A4018DF";
            $jsonApi247 = file_get_contents($strUrlApi247); 
            $arrApi247 = json_decode($jsonApi247, true);
            
            // $arrReponse = [
            //     'success' => true,
            //     'code' => 200,
            //     'messenger' => 'Lấy ra dữ liệu thành công.',
            //     'data' => $arrApi247,
            //     'error' => []
            // ];
            return response()->json($arrApi247, 200);

        } catch (\Throwable $th) {
            $arrReponse = [
                'success' => false,
                'code' => -10,
                'messenger' => 'Error.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
    }

    public function search()
    {
        $category = Input::get('category', 'default category');
        $term = Input::get('term', false);

        // do things with them...
    }

    public function exportListTracking(){
        try {
            if ($_GET['key_access'] !== 'Xsf0HB85TemQH76R4hc1YyEUCyI') {
                $arrReponse = [
                    'success' => false,
                    'code' => -10,
                    'messenger' => 'Bạn cần nhập vào KEY.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
            
            $intLimit =  50; 
            $intPage = empty($_GET['page'])? 1: $_GET['page'];

            $serviveQueryOrder = Order::query(); 

            $serviveQueryOrder->where('code_customer_b2b', 'BVIET');
            $serviveQueryOrder->where('is_deleted', 0);

            if (!empty($_GET['status'])) {
                $status = trim($_GET['status']);
                $serviveQueryOrder->where('status', $status);
            }

            if (!empty($_GET['date_begin']) && !empty($_GET['date_end'])) {
                $dateBegin = $_GET['date_begin'];
                $dateEnd = $_GET['date_end'];
                $strDateBegin = date("Y-m-d H:i:s", $dateBegin);
                $strDateEnd = date("Y-m-d H:i:s", $dateEnd);
                $serviveQueryOrder->where("enter_date", ">=", $strDateBegin);
                $serviveQueryOrder->where("enter_date", "<=", $strDateEnd);
            }

            $serviveQueryOrder->orderBy('id', 'DESC');
            $serviveQueryOrder->offset(($intPage - 1)*$intLimit);
            $serviveQueryOrder->limit($intLimit);
            $getListOrder = $serviveQueryOrder->get();

            $arrData = []; 
            foreach ($getListOrder as $key => $value) {
                $arrData[] = [
                    'code' => $value['code_az'],
                    'code_b2b' => $value['code_customer_b2b'], // mã đơn hàng của chính khách
                    'code_b2c' => $value['code_b2c'], // mã đơn vận của khách hàng
                    'enter_date' => $value['enter_date'], // ngày cập nhật dữ liệu
                    'request_date' => $value['request_date'],
                    'confrim_date' => $value['confrim_date'],
                    'phone_b2c' => $value['phone_b2c'], // số điện thoại của khách hàng
                    'fullname_b2c' => $value['full_name_b2c'], // tên của người nhận hàng
                    'address_b2c' => $value['address'], // địa chỉ ngươi nhận nhàng
                    'payments' => $value['payments'], 
                    'city' => ReadAddress::getCity($value['city']),
                    'district' => ReadAddress::getDistrict($value['district']),
                    'ward' => ReadAddress::getWard($value['ward']),
                    'weight' => $value['weight'],
                    'packages' => $value['packages'],
                    'type' => $value['type'],
                    'total_money' => (int) $value['into_money'], // thành tiền tạm tính
                    'status' => General::$arrStatusOrder[$value['status']], 
                ];
            }


            $arrReponse = [
                'success' => true,
                'code' => 200,
                'messenger' => 'Lấy ra dữ liệu thành công.',
                'data' => $arrData,
                'error' => []
            ];
            return response()->json($arrReponse, 200);

        } catch (\Throwable $th) {
            $arrReponse = [
                'success' => false,
                'code' => -10,
                'messenger' => 'Error.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
    }
}

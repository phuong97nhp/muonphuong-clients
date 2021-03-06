<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Address;
use App\Library\Address\ReadAddress;
use App\Library\Payment\IntoMoney;
use App\Models\Order;
use App\Library\Pusher\MyEvent;
use App\Library\General;

class OrdersController extends Controller
{
    // 1. Chờ xữ lý, 2. Yêu Cầu phát, 3. Chờ phát, 4 Đã phát thành công, 5. Hoàn lại đơn hàng
    public function index (){
        $intLimit =  30;
        $strCodeCustomer = Auth::user()["code_customer_b2b"];
        $arrListAddress = Address::where('code_customer_b2b', $strCodeCustomer)->get();
        $arrData = [];
        $arrData['address'] = [];
        if(!empty($arrListAddress)){
            foreach ($arrListAddress as $item) {
                $strAddress = $item->address.', '.ReadAddress::getAddress([$item->ward, $item->district, $item->city], 'name_with_type').' - '.$item->phone;
                if(!empty($strAddress)) $arrData['address'][$item->id] = $strAddress;
            }
        }
        $param = [];

        // CHƯƠNG TRÌNH QUERY ORDER
        $serviveQueryOrder = Order::query(); 
        $param['code_az'] = '';
        if (!empty($_GET['code_az'])) {
            $param['code_az'] =  $_GET['code_az'];
            $serviveQueryOrder->where('code_az', 'LIKE', '%' .$_GET['code_az']. '%');
        }

        $param['city'] = '';
        if (!empty($_GET['city'])) {
            $param['city'] =  $_GET['city'];
            $serviveQueryOrder->where('city', $_GET['city']);
        }

        $param['district'] = '';
        if (!empty($_GET['district'])) {
            $param['district'] =  $_GET['district'];
            $serviveQueryOrder->where('district', $_GET['district']);
        }

        $param['ward'] = '';
        if (!empty($_GET['ward'])) {
            $param['ward'] =  $_GET['ward'];
            $serviveQueryOrder->where('ward', $_GET['ward']);
        }
        
        $param['dateBegin'] = '';
        $param['dateEnd'] = '';
        if (!empty($_GET['dateEnd']) && !empty($_GET['dateBegin'])) {
            $param['dateEnd'] =  $_GET['dateEnd'];
            $param['dateBegin'] =  $_GET['dateBegin'];
            $strDateBegin = date("Y-m-d H:i:s", strtotime($_GET['dateBegin']." 00:00:00"));
            $strDateEnd = date("Y-m-d H:i:s", strtotime($_GET['dateEnd']." 23:59:59"));
            $serviveQueryOrder->where("enter_date", ">=", $strDateBegin);
            $serviveQueryOrder->where("enter_date", "<=", $strDateEnd);
        }

        $param['type'] = '';
        if (!empty($_GET['type'])) {
            $param['type'] =  $_GET['type'];
            $serviveQueryOrder->where('type', $_GET['type']);
        }

        $param['status'] = '';
        if (!empty($_GET['status'])) {
            $param['status'] =  $_GET['status'];
            $serviveQueryOrder->where('status', $_GET['status']);
        }

        $param['address_id'] = '';
        if (!empty($_GET['address_id'])) {
            $param['address_id'] =  $_GET['address_id'];
            $serviveQueryOrder->where('address_id', $_GET['address_id']);
        }

        $strCodeCustomer = Auth::user()["code_customer_b2b"];
        $param['code_customer_b2b'] = '';
        if (!empty($_GET['code_customer_b2b'])) {
            $param['code_customer_b2b'] =  $_GET['code_customer_b2b'];
            $serviveQueryOrder->where('code_customer_b2b', $strCodeCustomer);
        }
        
        $serviveQueryOrder->where('is_deleted', 0);
        $arrListOrders = $serviveQueryOrder->get();
        $arrData['orders'] = $arrListOrders;
        $arrData['param'] = $param;
        return view('clients.orders.index')->with('arrData', $arrData);
    }

    public function postImport(Request $request){
        set_time_limit(0);
        $rules = [
            'fileExcel' => 'required|max:5|mimes:xlsx,xls,csv'
        ];

        $messages = [
            'fileExcel.' => 'Cần chọn file excel',
            'fileExcel.max' => 'Kích thước file excel không hợp lệ',
            'fileExcel.mimes' => 'Đinh dạng file excel của bạn không chính xác',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('order-add')->withErrors($validator)->withInput();
        }

        if($validator->passes()){
            $fileExcel = $request->file('fileExcel');
            $arrExcel = Excel::import(new IProjectNames, $fileExcel);
            return redirect()->back()->with(['message' => 'Upload dữ liệu thành công.']);
        }else{
            return redirect()->back()->with(['message' => $validator->errors()->all()]);
        }
    }

    public function yeuCauPhat(Request $request){
        $intStatus = $request->input('status');
        if(empty($intStatus) || $intStatus != 2 ){
            $arrReponse = [
                'success' => false,
                'code' => 200,
                'messenger' => 'Cần chọn trạng thái là yêu cầu phát trước khi thực thi lệnh này.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
        $strCodeCustomer = Auth::user()["code_customer_b2b"];
        $statusCheck = Order::where('status', 1)
                        ->where('is_deleted', 0)
                        ->where('code_customer_b2b', $strCodeCustomer)
                        ->update(['status' => 2]);
        if($statusCheck){
            $arrReponse = [
                'success' => true,
                'code' => 200,
                'messenger' => 'Cập nhật đơn vận thành công.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        } 

        $arrReponse = [
            'success' => false,
            'code' => 200,
            'messenger' => 'Kiểm tra lại bạn không có đơn hàng nào đang chờ phát.',
            'data' => [],
            'error' => []
        ];
        return response()->json($arrReponse, 200);
    }
    
    public function add(){
        event(new MyEvent('Nguyễn HOàng Phương 1'));
        $intLimit =  30;
        $strCodeCustomer = Auth::user()["code_customer_b2b"];
        $arrListAddress = Address::where('code_customer_b2b', $strCodeCustomer)->get();
        $arrListOrders = Order::where(['status' => 1, 'is_deleted' => 0, 'code_customer_b2b' => $strCodeCustomer])->paginate($intLimit);
        $arrData = [];
        $arrData['address'] = [];
        if(!empty($arrListAddress)){
            foreach ($arrListAddress as $item) {
                $strAddress = $item->address.', '.ReadAddress::getAddress([$item->ward, $item->district, $item->city], 'name_with_type').' - '.$item->phone;
                if(!empty($strAddress)) $arrData['address'][$item->id] = $strAddress;
            }
        }
        $arrData['orders'] = $arrListOrders;

        $intAddressID = Auth::user()["address_id"];
        $arrListAddress = Address::where('id', $intAddressID)->first();
        $arrData['strAddress'] = $item->address.', '.ReadAddress::getAddress([$arrListAddress->ward, $arrListAddress->district, $arrListAddress->city], 'name_with_type');

        // phân trang
        return view('clients.orders.add')->with('arrData', $arrData);
    }

    public function postAddByMapAPI(Request $request){
        set_time_limit(0);
        // try {            
            $intCity = empty($request->input('city'))?'':trim($request->input('city'));
            $intDistrict = empty($request->input('district'))?'':trim($request->input('district'));
            $intWard = empty($request->input('ward'))?'':trim($request->input('ward'));
            $strAddress = empty($request->input('address'))?'':trim($request->input('address'));
            $intWeight = empty($request->input('weight'))?'':trim($request->input('weight'));
            $strFullNameB2C = empty($request->input('full_name_b2c'))?'':trim($request->input('full_name_b2c'));
            $intPhoneB2C = empty($request->input('phone_b2c'))?'':trim($request->input('phone_b2c'));
            $intCollectionMoney = empty($request->input('collection_money'))?'':trim($request->input('collection_money'));
            $strCodeB2C = empty($request->input('code_b2c'))?'':trim($request->input('code_b2c'));
            $intIntoMoney = empty($request->input('into_money'))?'':trim($request->input('into_money'));
            $strContent = empty($request->input('content'))?'':trim($request->input('content'));

            if(empty($intCity)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần phải chọn tỉnh/thành phố.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($intDistrict)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần phải chọn quận/huyện.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($intWard)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần phải chọn xã/phương.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($strAddress)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần nhập vào địa chỉ.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($intWeight)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần nhập vào trọng lượng.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(!is_numeric($intWeight)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Trọng lượng không hợp lệ.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($strFullNameB2C)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cần nhập vào tên người nhận.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($intPhoneB2C)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cận nhập vào số điện thoại người nhận.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(!is_numeric($intPhoneB2C)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Số điện thoại không hợp lệ cần nhập lại.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(empty($strCodeB2C)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cập nhập vào mã hóa đơn phía khách hàng.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            if(!is_numeric($intIntoMoney) || $intIntoMoney <= 0 || empty($intIntoMoney)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Tổng cước tạm tính không hợp lệ.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            $intCodeAz = Order::where(['is_deleted' => 0])->orderBy('id', 'desc')->first()['code_az'];
            if(100000000 < $intCodeAz){
                $intCodeAz++;
            }else{
                $intCodeAz = 100000000 + 1;
            }

            $arrData =  [
                'code_az'          => (string) $intCodeAz,
                'code_customer_b2b'    => (string) Auth::user()["code_customer_b2b"],
                'code_b2b'         => (string) Auth::user()["code_customer_b2b"],
                'code_b2c'         => $strCodeB2C,
                'enter_date'       => date('Y-m-d H:i:s'),
                'request_date'     => null,
                'confrim_date'     => null,
                'get_date'         => null,
                'phone_b2c'        => (string) $intPhoneB2C,
                'full_name_b2c'        => (string)$strFullNameB2C,
                'code_product_b2b'     => null,
                'address_b2c'          => (string) $strAddress,
                'city'             => (string) $intCity,
                'ward'             => (string) $intWard,
                'district'         => (string) $intDistrict,
                'weight'           => (int) $intWeight,
                'total'            => null,
                'packages'         => (int) 1,
                'address_id'       => (int) Auth::user()["address_id"],
                'collection_money' => (int) $intCollectionMoney,
                'into_money'       => (int) $intIntoMoney,
                'type'             => '',
                'name_get'         => null,
                'name_confrim'     => null,
                'content'          => $strContent,
                'is_deleted'       => 0,
                'create_user'      => Auth::id(),
                'status'           => 2,
                'update_user'      => Auth::id(),
                'created_at'       => date('Y-m-d H:i:s'),
                'updated_at'       => null
            ];
            if(Order::insert($arrData)){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Thêm đơn vận mới thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }else {
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Thêm đơn vận mới không thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
        // } catch (\Throwable $th) {
        //     $arrReponse = [
        //         'success' => false,
        //         'code' => 500,
        //         'messenger' => 'Đã có lỗi xẫy ra.',
        //         'data' => [],
        //         'error' => []
        //     ];
        //     return response()->json($arrReponse, 200);
        // }
    }

    public function postAdd(Request $request){
        set_time_limit(0);
        $rules = [
            'address_customer' => 'required|numeric',
            'address' => 'required',
            'city' => 'required|numeric',
            'district' => 'required|numeric',
            'ward' => 'required|numeric',
            'type' => 'required',
            'weight' => 'required|numeric',
            'full_name_b2c' => 'required',
            'phone_b2c' => 'required|numeric'
        ];

        $messages = [
            'address_customer.required' => 'Cần chọn địa chỉ tạo đơn vận',
            'address_customer.numeric' => 'Địa chỉ nhập vào không hợp lệ',
            'address.required' => 'Cần nhập vào địa chỉ',
            'city.required' => 'Cần chọn thành phố',
            'city.numeric' => 'Địa chỉ thành phố được lưu dưới dạng số',
            'district.required' => 'Cần chọn quận huyện',
            'district.numeric' => 'Địa chỉ quận huyện không hợp lệ',
            'ward.required' => 'Cần chọn xã phường',
            'ward.numeric' => 'Địa chỉ xã phường không hợp lệ',
            'type.required' => 'Cần nhập chọn hình thức chuyển phát',
            'weight.required' => 'Cần nhập vào trọng lượng đơn vận',
            'weight.numeric' => 'Cần nhập trọng lượng là số',
            'full_name_b2c.required' => 'Cần nhập vào thên người nhận',
            'phone_b2c.required' => 'Cần nhập vào số điện thoại',
            'phone_b2c.numeric' => 'Bạn chỉ nền nhập số'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('order-add')->withErrors($validator)->withInput();
        }

            
        $intAddressCustomer = empty($request->input('address_customer'))?'':trim($request->input('address_customer'));
        $strAddress = empty($request->input('address'))?'':trim($request->input('address'));
        $intCity = empty($request->input('city'))?'':trim($request->input('city'));
        $intDistrict = empty($request->input('district'))?'':trim($request->input('district'));
        $intWard = empty($request->input('ward'))?'':trim($request->input('ward'));
        $strType = empty($request->input('type'))?'':trim($request->input('type'));
        $strPayments = empty($request->input('payments'))?'':trim($request->input('payments'));
        $intWeight = empty($request->input('weight'))?'':trim($request->input('weight'));
        $strFullNameB2C = empty($request->input('full_name_b2c'))?'':trim($request->input('full_name_b2c'));
        $intPhoneB2C = empty($request->input('phone_b2c'))?'':trim($request->input('phone_b2c'));
        $strCodeB2C = empty($request->input('code_b2c'))?'':trim($request->input('code_b2c'));
        $intCollectionMoney = empty($request->input('collection_money'))?'':trim($request->input('collection_money'));
        $strContent = empty($request->input('content'))?'':trim($request->input('content'));

        $strState = ReadAddress::getDistrictState($intDistrict);
        $intIntoMony = IntoMoney::getPayment($strType, $strState, $intWeight)["totalcharge"];

        $arrData =  [
            'code_az'          => (string) time(),
            'code_customer_b2b'    => (string) Auth::user()["code_customer_b2b"],
            'code_b2b'         => (string) Auth::user()["code_customer_b2b"],
            'code_b2c'         => $strCodeB2C,
            'enter_date'       => date('Y-m-d H:i:s'),
            'request_date'     => null,
            'confrim_date'     => null,
            'get_date'         => null,
            'phone_b2c'        => (string) $intPhoneB2C,
            'name_from'        => (string)$strFullNameB2C,
            'code_product_b2b'     => null,
            'full_name_b2c'    => $strFullNameB2C,
            'address'          => (string) $strAddress,
            'city'             => (string) $intCity,
            'ward'             => (string) $intWard,
            'district'         => (string) $intDistrict,
            'weight'           => (int) $intWeight,
            'total'            => null,
            'packages'         => (int) 1,
            'address_id'       => (int) $intAddressCustomer,
            'collection_money' => (int) $intCollectionMoney,
            'into_money'       => (string) $intIntoMony,
            'type'             => (string) $strType,
            'name_get'         => null,
            'name_confrim'     => null,
            'content'          => $strContent,
            'is_deleted'       => 0,
            'create_user'      => Auth::id(),
            'update_user'      => Auth::id(),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => null,
            'payments'         => $strPayments,
        ];
        // echo '<pre>';
        // var_dump($arrData); die;
        // echo '</pre>';
        if(Order::insert($arrData)){
            return redirect()->route('order-add')->with('message','Thêm đơn vận thành công');
        }else {
            return redirect()->route('order-add')->with('message','Thêm đơn vận không thành công');
        }
    }


    public function postAddExcel(Request $request){
        $intAddressCustomer = empty($request->input('address_customer'))?'':trim($request->input('address_customer'));
        $strAddress = empty($request->input('address'))?'':trim($request->input('address'));
        $intCity = empty($request->input('city'))?'':trim($request->input('city'));
        $intDistrict = empty($request->input('district'))?'':trim($request->input('district'));
        $intWard = empty($request->input('ward'))?'':trim($request->input('ward'));
        $strType = empty($request->input('type'))?'':trim($request->input('type'));
        $strPayments = empty($request->input('payments'))?'':trim($request->input('payments'));
        $intWeight = empty($request->input('weight'))?'':trim($request->input('weight'));
        $strFullNameB2C = empty($request->input('full_name_b2c'))?'':trim($request->input('full_name_b2c'));
        $intPhoneB2C = empty($request->input('phone_b2c'))?'':trim($request->input('phone_b2c'));
        $strCodeB2C = empty($request->input('code_b2c'))?'':trim($request->input('code_b2c'));
        $intCollectionMoney = empty($request->input('collection_money'))?'':trim($request->input('collection_money'));
        $strContent = empty($request->input('content'))?'':trim($request->input('content'));

        if(empty($intAddressCustomer)){
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Địa chỉ giao hàng không được để trống.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }

        if(empty($strAddress)){
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Cần nhập vào địa chỉ.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }

        $strState = ReadAddress::getDistrictState($intDistrict);
        $intIntoMony = IntoMoney::getPayment($strType, $strState, $intWeight)["totalcharge"];

        $arrData =  [
            'code_az'          => (string) time(),
            'code_customer_b2b'    => (string) Auth::user()["code_customer_b2b"],
            'code_b2b'         => (string) Auth::user()["code_customer_b2b"],
            'code_b2c'         => $strCodeB2C,
            'enter_date'       => date('Y-m-d H:i:s'),
            'request_date'     => null,
            'confrim_date'     => null,
            'get_date'         => null,
            'phone_b2c'        => (string) $intPhoneB2C,
            'name_from'        => (string)$strFullNameB2C,
            'code_product_b2b'     => null,
            'full_name_b2c'    => $strFullNameB2C,
            'address'          => (string) $strAddress,
            'city'             => (string) $intCity,
            'ward'             => (string) $intWard,
            'district'         => (string) $intDistrict,
            'weight'           => (int) $intWeight,
            'total'            => null,
            'packages'         => (int) 1,
            'address_id'       => (int) $intAddressCustomer,
            'collection_money' => (int) $intCollectionMoney,
            'into_money'       => (string) $intIntoMony,
            'type'             => (string) $strType,
            'name_get'         => null,
            'name_confrim'     => null,
            'content'          => $strContent,
            'status'           => 1,
            'is_deleted'       => 0,
            'create_user'      => Auth::id(),
            'update_user'      => Auth::id(),
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => null,
            'payments'         => $strPayments,
        ];
        
        if(Order::insert($arrData)){
            if(empty($strAddress)){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Thêm đơn vận thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
        }else {
            if(empty($strAddress)){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Thêm đơn vận không thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
        }
    }

    public function postPayment(Request $request){
        $strType = trim($request->input('type')); 
        $intDistrict = trim($request->input('district')); 
        $intWeight = trim($request->input('weight'));

        if(empty($strType)){
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Không bỏ trống loại dịch vụ.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
        if(empty($intDistrict) || !is_numeric($intDistrict)){
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Cần chọng địa chỉ đến.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
        if(empty($intWeight) || !is_numeric($intWeight)){
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Cần nhập vào trọng lượng.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
        
        $strState = ReadAddress::getDistrictState($intDistrict);
        $result = IntoMoney::getPayment($strType, $strState, $intWeight);
        $arrReponse = [
            'success' => true,
            'code' => 500,
            'messenger' => 'Cập nhật giá thành công.',
            'data' => $result,
            'error' => []
        ];
        return response()->json($arrReponse, 200);
    }

    public function import(Request $request){
        set_time_limit(0);
        $validator = Validator::make($request->all(), [
            'fileExcel' => 'required|max:5000|mimes:xlsx,xls,csv'
        ]);
        
        if($validator->passes()){
            $fileExcel = $request->file('fileExcel');
            $arrExcel = Excel::import(new IProjectNames, $fileExcel);
            return redirect()->back()->with(['success' => 'Upload dữ liệu thành công.']);
        }else{
            return redirect()->back()->with(['errors' => $validator->errors()->all()]);
        }
    }
}

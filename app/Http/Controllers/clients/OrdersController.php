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

class OrdersController extends Controller
{
    // 1. Chờ xữ lý, 2. Yêu Cầu phát, 3. Chờ phát, 4 Đã phát thành công, 5. Hoàn lại đơn hàng
    public function index (){
        return view('clients.orders.index');
    }
    
    public function add(){
        $intLimit =  30;
        $strCodeCustomer = Auth::user()["code_customer"];
        $arrListAddress = Address::where('code_customer', $strCodeCustomer)->get();
        $arrListOrders = Order::where(['status' => 1, 'is_deleted' => 0, 'code_customer' => $strCodeCustomer])->paginate($intLimit);
        $arrData = [];
        if(!empty($arrListAddress)){
            foreach ($arrListAddress as $item) {
                $strAddress = $item->address.', '.ReadAddress::getAddress([$item->ward, $item->district, $item->city], 'name_with_type').' - '.$item->phone;
                if(!empty($strAddress)) $arrData['address'][$item->id] = $strAddress;
            }
        }
        $arrData['orders'] = $arrListOrders;

        // phân trang
        return view('clients.orders.add')->with('arrData', $arrData);
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
            'address.required' => 'Cần nhập vào địa chỉ',
            'city.required' => 'Cần chọn thành phố',
            'city.numeric' => 'Địa chỉ thành phố được lưu dưới dạng số',
            'district.required' => 'Cần chọn quận huyện',
            'district.numeric' => 'Địa chỉ quận huyện không hợp lệ',
            'ward.required' => 'Cần chọn xã phường',
            'ward.numeric' => 'Địa chỉ xã phường không hợp lệ',
            'type.required' => 'Cần nhập vào lại đơn hàng',
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
            'code_customer'    => (string) Auth::user()["code_customer"],
            'code_b2b'         => (string) Auth::user()["code_customer"],
            'code_b2c'         => $strCodeB2C,
            'enter_date'       => date('Y-m-d H:i:s'),
            'request_date'     => null,
            'confrim_date'     => null,
            'get_date'         => null,
            'phone_b2c'        => (string) $intPhoneB2C,
            'name_from'        => (string)$strFullNameB2C,
            'code_product'     => null,
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
            'into_money'       => (float) $intIntoMony,
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
        // echo '<pre>';
        // var_dump($arrData); die;
        // echo '</pre>';
        if(Order::insert($arrData)){
            return redirect()->route('order-add')->with('message','Thêm đơn vận thành công');
        }else {
            return redirect()->route('order-add')->with('message','Thêm đơn vận không thành công');
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

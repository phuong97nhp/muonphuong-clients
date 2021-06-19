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
        $strCodeCustomer = Auth::user()["code_customer"];
        $arrListAddress = Address::where('code_customer', $strCodeCustomer)->get();
        $arrListOrders = Order::where(['status' => 1, 'code_customer' => $strCodeCustomer])->get();
        $arrData = [];
        if(!empty($arrListAddress)){
            foreach ($arrListAddress as $item) {
                $strAddress = $item->address.', '.ReadAddress::getAddress([$item->ward, $item->district, $item->city], 'name_with_type').' - '.$item->phone;
                if(!empty($strAddress)) $arrData['address'][$item->id] = $strAddress;
            }
        }
        $arrData['orders'] = $arrListOrders;
        return view('clients.orders.add')->with('arrData', $arrData);
    }

    public function postAdd(Request $request){

    }

    public function postPayment(Request $request){
        $strType = trim($request->type); 
        $intDistrict = trim($request->district); 
        $intWeight = trim($request->weight); 

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

<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Models\Address;
use App\Library\Address\ReadAddress;

class AddressController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){
        try {
            $intID = $request->id;

            if(empty($intID)){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Không được để trống địa chỉ cầm xóa.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

            $intAddress = Address::where(['id' => $intID, 'is_deleted' => 0])->count();
            if($intAddress != 1){
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Địa chỉ không tồn tại.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
            
            if(Address::where(['id' => $intID])->update(['is_deleted' => 1])){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Cập nhật địa chỉ thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }else{
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cập nhật địa chỉ không thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }

        } catch (\Throwable $th) {
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Trạng thái truy cập đang bị lỗi.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
    }

    public function add()
    {
        $intLimit = 30;
        $strCodeCustomer = Auth::user()["code_customer_b2b"];
        $arrListAddress = Address::where(['code_customer_b2b' => $strCodeCustomer, 'is_deleted' => 0])->paginate($intLimit);        
        $arrData['address'] = $arrListAddress;
        return view('clients.address.add')->with('arrData', $arrData);
    }

    public function edit(Request $request){
        set_time_limit(0);
        $rules = [
            // 'address_customer' => 'required',
            'name_address_b2b' => 'required',
            'address' => 'required',
            'city' => 'required|numeric',
            'district' => 'required|numeric',
            'ward' => 'required|numeric',
            'address_of' => 'required',
            'phone' => 'required'
        ];

        $messages = [
            // 'address_customer.required' => 'Cần chọn địa chỉ tạo đơn vận',
            'address.required' => 'Cần nhập vào địa chỉ',
            'name_address_b2b.required' => 'Cần nhập vào tên địa chỉ',
            'city.required' => 'Cần chọn thành phố',
            'city.numeric' => 'Địa chỉ tỉnh thành phố không hợp lệ',
            'district.required' => 'Cần chọn quận huyện',
            'district.numeric' => 'Địa chỉ quận huyện không hợp lệ',
            'ward.required' => 'Cần chọn xã phường',
            'ward.numeric' => 'Địa chỉ xã phường không hợp lệ',
            'address_of.required' => 'Cần chọn loại khách hàng',
            'phone.required' => 'Cần nhập vào số điện thoại'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('address-add')->withErrors($validator)->withInput();
        }

            
        // $intAddressCustomer = empty($request->input('address_customer'))?'':trim($request->input('address_customer'));
        $strAddress = empty($request->input('address'))?'':trim($request->input('address'));
        $strAddressOf = empty($request->input('address_of'))?'':trim($request->input('address_of'));
        $intCity = empty($request->input('city'))?'':trim($request->input('city'));
        $intDistrict = empty($request->input('district'))?'':trim($request->input('district'));
        $intWard = empty($request->input('ward'))?'':trim($request->input('ward'));
        $strNameAddress = empty($request->input('name_address_b2b'))?'':trim($request->input('name_address_b2b'));
        $intPhone = empty($request->input('phone'))?'':trim($request->input('phone'));
        $strWebsite = empty($request->input('website'))?'':trim($request->input('website'));

        $arrData =  [
            'code_customer_b2b'    => (string) Auth::user()["code_customer_b2b"],
            'phone'             => (string) $intPhone,
            'name_address_b2b'        => (string) $strNameAddress,
            'address_of'        => (string) $strAddressOf,
            'address'          => (string) $strAddress,
            'city'             => (string) $intCity,
            'ward'             => (string) $intWard,
            'district'         => (string) $intDistrict,
            'website'          => (string) $strWebsite,
            'status'           => 1,
            'is_deleted'       => 0,
            'create_user'      => Auth::id(),
            'update_user'      => date('Y-m-d H:i:s'),
            'updated_at'       => null
        ];
        if(Address::where(['id' => $intID])->update($arrData)){
            return redirect()->route('address-add')->with('message','Thêm địa chỉ thành công');
        }else {
            return redirect()->route('address-add')->with('message','Thêm địa chỉ không thành công');
        }
    }

    public function postAdd(Request $request){
        set_time_limit(0);
        $rules = [
            // 'address_customer' => 'required',
            'name_address_b2b' => 'required',
            'address' => 'required',
            'city' => 'required|numeric',
            'district' => 'required|numeric',
            'ward' => 'required|numeric',
            'address_of' => 'required',
            'phone' => 'required'
        ];

        $messages = [
            // 'address_customer.required' => 'Cần chọn địa chỉ tạo đơn vận',
            'address.required' => 'Cần nhập vào địa chỉ',
            'name_address_b2b.required' => 'Cần nhập vào tên địa chỉ',
            'city.required' => 'Cần chọn thành phố',
            'city.numeric' => 'Địa chỉ tỉnh thành phố không hợp lệ',
            'district.required' => 'Cần chọn quận huyện',
            'district.numeric' => 'Địa chỉ quận huyện không hợp lệ',
            'ward.required' => 'Cần chọn xã phường',
            'ward.numeric' => 'Địa chỉ xã phường không hợp lệ',
            'address_of.required' => 'Cần chọn loại khách hàng',
            'phone.required' => 'Cần nhập vào số điện thoại'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('address-add')->withErrors($validator)->withInput();
        }

            
        // $intAddressCustomer = empty($request->input('address_customer'))?'':trim($request->input('address_customer'));
        $strAddress = empty($request->input('address'))?'':trim($request->input('address'));
        $strAddressOf = empty($request->input('address_of'))?'':trim($request->input('address_of'));
        $intCity = empty($request->input('city'))?'':trim($request->input('city'));
        $intDistrict = empty($request->input('district'))?'':trim($request->input('district'));
        $intWard = empty($request->input('ward'))?'':trim($request->input('ward'));
        $strNameAddress = empty($request->input('name_address_b2b'))?'':trim($request->input('name_address_b2b'));
        $intPhone = empty($request->input('phone'))?'':trim($request->input('phone'));
        $strWebsite = empty($request->input('website'))?'':trim($request->input('website'));

        $arrData =  [
            'code_customer_b2b'    => (string) Auth::user()["code_customer_b2b"],
            'phone'             => (string) $intPhone,
            'name_address_b2b'        => (string) $strNameAddress,
            'address_of'        => (string) $strAddressOf,
            'address'          => (string) $strAddress,
            'city'             => (string) $intCity,
            'ward'             => (string) $intWard,
            'district'         => (string) $intDistrict,
            'website'          => (string) $strWebsite,
            'status'           => 1,
            'is_deleted'       => 0,
            'create_user'      => Auth::id(),
            'update_user'      => null,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => null,
        ];
        if(Address::insert($arrData)){
            return redirect()->route('address-add')->with('message','Thêm địa chỉ thành công');
        }else {
            return redirect()->route('address-add')->with('message','Thêm địa chỉ không thành công');
        }
    }
}

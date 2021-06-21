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
    public function add()
    {
        $intLimit = 30;
        $strCodeCustomer = Auth::user()["code_customer"];
        $arrListAddress = Address::where('code_customer', $strCodeCustomer)->paginate($intLimit);        
        $arrData['address'] = $arrListAddress;

        return view('clients.address.add')->with('arrData', $arrData);
    }

    public function postAdd(Request $request){
        set_time_limit(0);
        $rules = [
            // 'address_customer' => 'required',
            'name_address' => 'required',
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
            'name_address.required' => 'Cần nhập vào tên địa chỉ',
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
        $strNameAddress = empty($request->input('name_address'))?'':trim($request->input('name_address'));
        $intPhone = empty($request->input('phone'))?'':trim($request->input('phone'));
        $strWebsite = empty($request->input('website'))?'':trim($request->input('website'));

        $arrData =  [
            'code_customer'    => (string) Auth::user()["code_customer"],
            'phone'             => (string) $intPhone,
            'name_address'        => (string) $strNameAddress,
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
        // echo '<pre>';
        // var_dump($arrData); die;
        // echo '</pre>';
        if(Address::insert($arrData)){
            return redirect()->route('address-add')->with('message','Thêm địa chỉ thành công');
        }else {
            return redirect()->route('address-add')->with('message','Thêm địa chỉ không thành công');
        }
    }
}

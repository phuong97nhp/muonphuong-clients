<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function login(){
        return view('clients.users.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function updateAddressId(Request $request)
    {
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
            
            if(User::where(['id' => Auth::id()])->update(['address_id' => $intID])){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Cập nhật địa chỉ thành công cho tài khoản.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }else{
                $arrReponse = [
                    'success' => false,
                    'code' => 500,
                    'messenger' => 'Cập nhật địa chỉ cho tài khoản không thành công.',
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

    public function postLogin(Request $request){
        $strEmail = (empty($request->input('email'))) ? '' : trim($request->input('email'));
        $strPassword = (empty($request->input('password'))) ? '' : trim($request->input('password'));
        $intRemember = (empty($request->boolean('password'))) ? '' : trim($request->boolean('password'));

        if (empty($strEmail)) {
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Cần nhập vào địa chỉ email.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }

        if (!filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Địa chỉ email không đúng định dạng.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }

        if (empty($strPassword)) {
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Cần nhập vào mật khẩu.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
        
        if (Auth::attempt(array('email' => $strEmail, 'password' => $strPassword), $intRemember)) {
            if(Auth::check()){
                $arrReponse = [
                    'success' => true,
                    'code' => 200,
                    'messenger' => 'Đăng nhập thành công.',
                    'data' => [],
                    'error' => []
                ];
                return response()->json($arrReponse, 200);
            }
        } else {
            $arrReponse = [
                'success' => false,
                'code' => 500,
                'messenger' => 'Tài khoản hoặc mật khẩu không chính xác.',
                'data' => [],
                'error' => []
            ];
            return response()->json($arrReponse, 200);
        }
    }
}

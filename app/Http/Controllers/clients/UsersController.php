<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
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

    public function postLogin(Request $request){
        $strEmail = (empty($request->input('email'))) ? '' : trim($request->input('email'));
        $strPassword = (empty($request->input('password'))) ? '' : trim($request->input('password'));
        $intRemember = (empty($request->input('password'))) ? '' : trim($request->input('password'));

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

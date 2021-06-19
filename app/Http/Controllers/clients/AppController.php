<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectNames as IProjectNames;
use App\Exports\ProjectNames as EProjectNames;
use App\Models\ProjectNames as MProjectNames;
use App\Models\BaoPhat as MBaoPhat;
use App\Models\Project as MProject;
use Validator;
use Carbon\Carbon;
use DB;

class AppController extends Controller
{

    public function index()
    { 
        return view('clients.index');
    }

    public function add(Request $request){
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

    public function export(Request $request)
    {
        set_time_limit(0);
        $exportExcel= [];
        $exportExcel[] = ["STT", 'Ngày gửi BO giao', 'Ngày nhận thẻ từ HDBANK', 'Số bill gửi', 'Mã khách hàng', 'Họ và tên người nhận', 'Địa chỉ nhận', 'Số điện thoại người nhận', 'Số bill gửi', 'Kết quả', 'Ngày nhận', 'Tình Trạng', 'Thời gian gửi lần 1', 'Thời gian gửi lần 2', 'Thời gian gửi lần 3', 'Thời gian gửi lần 4', 'Lý do gửi không thành công', 'Dịch vụ chuyển phát', 'Ghi chú'];

        $strDateFirst = trim($request->input('dateFirst'));
        $strDateEnd = trim($request->input('dateEnd')); 
        $strCode = trim($request->input('code'));
        $strNameExcel = $strDateFirst.'_'.$strDateEnd.'_'.$strCode.'_'.date('Y-m-d H:i:s');

        if(empty($strCode)){
            return redirect()->back()->with(['success' => 'Cần nhập vào mã khách hàng.']);
        }
        if(empty($strDateFirst) && empty($strDateEnd)){
            return redirect()->back()->with(['success' => 'Cần nhập vào thời gian.']);
        }
        if(strtotime($strDateFirst) > strtotime($strDateEnd)){
            return redirect()->back()->with(['success' => 'Ngày bạn nhập không hợp lệ.']);
        }
        if(strtotime($strDateFirst) > strtotime(date('Y-m-d H:i:s'))){
            return redirect()->back()->with(['success' => 'Ngày bắt đầu không được lớn hơn ngày hiện thời.']);
        }
        if(strtotime($strDateEnd) > strtotime(date('Y-m-d H:i:s'))){
            return redirect()->back()->with(['success' => 'Ngày kết thúc không được lớn hơn ngày hiện thời.']);
        }
        $strDateFirst = $strDateFirst.' 00:00:00'; 
        $strDateEnd = $strDateEnd.' 23:59:59'; 
        $startDate = (string) Carbon::createFromFormat('Y-m-d H:i:s', $strDateFirst)->toDateTimeString();
        $endDate = (string) Carbon::createFromFormat('Y-m-d H:i:s', $strDateEnd)->toDateTimeString();
        $arrStatus = [
            'Chờ nhận', 
            'Đã nhận', 
            'Phát lại',
            'Hoàn lại'
        ];

        $arrResult = [
            'Đang đi phát',
            'Phát thành công'
        ];

        $arrType = [
            'CPN' =>    'Chuyển phát nhanh',
            'PTN' =>    'Phát trong ngày',
            'PT9H' =>   'Phát trước 9 giờ',
            'ĐB' =>     'Đường bộ',
            'HCPN' =>   'Chuyển bưu kiện',
        ];
        
        $strSQLCodition  = "SELECT 
                                    p.date_entered                       AS date_entered,
                                    bp.name                              AS name,
                                    bp.receiver_name                     AS receiver_name,
                                    bp.address_street                    AS address_street,
                                    p.tel                                AS tel,
                                    p.accounts_code                      AS accounts_code,
                                    pn.status                            AS status,
                                    bp.date_receive                      AS date_receive,
                                    bp.connected                         AS lydo,
                                    p.type                               AS type
                            FROM baophat bp
                            INNER JOIN project p on bp.name = p.name
                            INNER JOIN project_name pn on bp.name = pn.name
                            where p.deleted = 0
                                AND p.accounts_code = '$strCode'
                                AND p.date_entered BETWEEN '$startDate' AND '$endDate'
                            ORDER BY bp.date_receive DESC;";
        $arrData = DB::select($strSQLCodition);

        $ojectCarbon = Carbon::now('Asia/Ho_Chi_Minh');
        foreach ($arrData as $key => $item) {
            $strDateEntered =  $ojectCarbon->parse($item->date_entered)->format('d/m/Y');
            $strDateReceive =  $ojectCarbon->parse($item->date_receive)->format('d/m/Y');
            $strStatus = $arrStatus[$item->status];
            $strType = $arrType[$item->type];
            $strResult = $arrResult[$item->status];
            $exportExcel[] = [
                $key+1,
                $strDateEntered, 
                $strDateEntered,
                $item->name, 
                $item->accounts_code, 
                ucwords($item->receiver_name), 
                $item->address_street, 
                $item->tel, 
                $item->name, 
                $strResult,
                $strDateReceive, 
                $strStatus, 
                '', 
                '',
                '', 
                '', 
                $item->lydo, 
                $strType, 
                ''
            ];
        }

        $export = new EProjectNames($exportExcel);
        return Excel::download($export, $strNameExcel.'.xlsx');
    }
    
}

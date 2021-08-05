<?php

namespace App\Http\Controllers\cpn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project as MProject;
use DB;

class AppController extends Controller
{
    public function edit(){
        $strSQLCondition  = "select * from project where name='6533680';";
        $arrData = DB::select($strSQLCondition);
        echo '<pre>';
        var_dump($arrData);
        echo '</pre>';
    }
}

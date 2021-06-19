
<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Order; 

class OrderImports implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        $arrOrder = Order::get();
        // foreach ($collection as $key => $time) { 
        //     if($key != 0){
        //         $value = [
        //             'name' => $time[0],
        //             'deleted' => 0,
        //             'date_enter' => date('Y-m-d H:i:s'),
        //             'date_get' => date('Y-m-d H:i:s'),
        //             'times_get' => 0,
        //             'status' => 0,
        //         ];
        //         if(MProjectNames::where('name', (string) $time[0])->count() == 0) MProjectNames::insert($value);
        //     }
        // } 
    }
}

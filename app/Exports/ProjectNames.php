<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
class ProjectNames implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $arrExcel;

    public function __construct($arrExcel)
    {
        $this->invoices = $arrExcel;
    }
    
    public function array(): array
    {
        return $this->invoices;
    }
}


			 													

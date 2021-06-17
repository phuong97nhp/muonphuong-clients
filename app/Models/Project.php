<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'project';
    protected $fillable = [
        'id',
        'date_entered',
        'date_modified',
        'assigned_user_id',
        'modified_user_id',
        'created_by',
        'name',
        'description',
        'deleted',
        'date_start',
        'status',
        'add_service',
        'employee_last_name',
        'centre_code',
        'type',
        'weight',
        'package',
        'doc' ,
        'charge',
        'subcharge',
        'totalcharge',
        'address_street',
        'address_city',
        'address_state',
        'zipcode',
        'address_tp' ,
        'country',
        'tel' ,
        'partner',
        'detail',
        'dai',
        'rong',
        'cao',
        'weight_h',
        'shipping',
        'accounts_code',
        'bill_code',
        'district_from',
        'servicecharge',
        'tax_amount',
        'province_from',
        'confirm' ,
        'extracharge',
        'shipper',
        'receiver',
        'delivery_address',
        'distance' ,
        'department'  ,
        'pos_receive' ,
        'line',
        'bill_type',
        'date_receive',
        'acc_order',
        'estimated_start_date',
        'bill_partner' ,
        'bill_status',
        'reason',
        'area_from',
        'district_to',
        'area_to',
        'date_return',
        'packing_fee',
        'add_day'  
    ]; 
}


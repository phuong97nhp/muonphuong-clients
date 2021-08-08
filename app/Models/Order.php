<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'id',
        'primarykey',
        'code_az',
        'code_customer',
        'code_b2b',
        'code_b2c',
        'create_enter',
        'request_date',
        'confrim_date',
        'get_date',
        'phone',
        'name_from',
        'code_product_b2b',
        'full_name_b2c_b2b',
        'address',
        'city',
        'ward',
        'district',
        'weight',
        'payments',
        'total',
        'address_id',
        'collection_money',
        'into_money',
        'type',
        'name_get',
        'name_confrim',
        'content',
        'status',
        'is_deleted',
        'create_user',
        'update_user',
        'created_at',
        'updated_at',
    ]; 
}

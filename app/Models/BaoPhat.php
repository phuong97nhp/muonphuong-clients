<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoPhat extends Model
{
    use HasFactory;
    protected $table = 'baophat';
    protected $fillable = [
        'id', 
        'name', 
        'date_entered', 
        'date_modified', 
        'modified_user_id', 
        'created_by', 
        'description', 
        'deleted', 
        'assigned_user_id', 
        'account_name', 
        'user_code', 
        'tel', 
        'date_start', 
        'weight', 
        'package', 
        'address_street', 
        'address_tp', 
        'transit', 
        'doc', 
        'type', 
        'status', 
        'reason', 
        'date_receive', 
        'receiver_name', 
        'centre_send', 
        'employee_last_name', 
        'sent', 
        'connected', 
        'date_return', 
        'bill_image', 
        'pod_source', 
    ]; 
}
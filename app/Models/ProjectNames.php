<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectNames extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'project_name';
    protected $fillable = [
        'id', 
        'name',
        'deleted',
        'date_enter',
        'date_get',
        'times_get',
        'status',
    ];  
}
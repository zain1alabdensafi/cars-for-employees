<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public $table ='cars';
    use HasFactory;
    protected $fillable =[
        'type',
        'license_plate',
        'employee_id',
    ];
}

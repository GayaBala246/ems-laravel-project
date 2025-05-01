<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'emp_id',
        'phone',
        'image',
        'password',
        'dob',
        'address',
        'pay_rate',
        'status',
    ];

    public function shifts(){
        return $this->hasMany(Shift::class);
    }

    public function payrolls(){
        return $this->hasMany(Payroll::class);
    }
}

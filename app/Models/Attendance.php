<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['employee_name', 'attendance_date', 'clock_in', 'clock_out','note'];

    protected $casts = [
        'attendance_date' => 'date',
    ];
}

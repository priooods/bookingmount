<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TClimbersTab extends Model
{
    protected $fillable = [
        'created_by',
        'realname',
        'nik',
        'phone',
        'email',
        'address',
        'gender',
        'age',
        'start_climb',
        'end_climb',
        'file_ktp',
        'emergency_name',
        'emergency_phone',
        'm_status_tabs',
        'file_payment',
        'count_friend',
        'comment',
    ];

    public function status()
    {
        return $this->hasOne(MStatusTab::class, 'id', 'm_status_tabs');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MKuotaTabs extends Model
{
    protected $fillable = [
        'kuota',
        'dates',
        'm_status_tabs_id'
    ];

    public function status()
    {
        return $this->hasOne(MStatusTab::class, 'id', 'm_status_tabs_id');
    }
}

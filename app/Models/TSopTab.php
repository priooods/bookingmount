<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TSopTab extends Model
{
    protected $fillable = [
        'file_path',
        'filename',
        'm_status_tabs',
    ];

    public function status()
    {
        return $this->hasOne(MStatusTab::class, 'id', 'm_status_tabs');
    }
}

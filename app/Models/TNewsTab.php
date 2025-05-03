<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TNewsTab extends Model
{
    protected $fillable = [
        'file_path',
        'filename',
        'title',
        'description',
        'm_status_tabs',
    ];

    public function status()
    {
        return $this->hasOne(MStatusTab::class, 'id', 'm_status_tabs');
    }
}

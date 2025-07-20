<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'm_user_role_tabs_id'
    ];

    public function role()
    {
        return $this->hasOne(MUserRoleTabs::class, 'id', 'm_user_role_tabs_id');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getFilamentName(): string
    {
        return "{$this->fullname}";
    }
}

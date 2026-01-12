<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Contracts\Activity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeOnlyBasicFields($query)
    {
        return $query->select('id', 'name', 'email');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'usuario_id');
    }

    /**
     * Configuración de auditoría con Spatie
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('usuario')
            ->logOnly(['name', 'email']) // no logueamos password por seguridad
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

 
}

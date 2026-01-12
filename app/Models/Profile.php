<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'account_id',
        'name',
        'status',
        'current_holder',
        'telefono',
        'assigned_since',
        'notes'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function assignments()
    {
        return $this->hasMany(ProfileAssignment::class);
    }
    protected $casts = [
        'assigned_since' => 'datetime',
    ];
}


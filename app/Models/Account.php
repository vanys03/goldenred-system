<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['platform_id', 'email', 'password_encrypted',  'password_plain', 'notes'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}

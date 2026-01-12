<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'logo_url'];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}

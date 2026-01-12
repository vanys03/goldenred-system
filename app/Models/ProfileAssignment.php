<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileAssignment extends Model
{
    protected $fillable = [
        'profile_id', 'customer_name','telefono', 'sold_by_user_id', 'type',
        'started_at', 'ended_at', 'price', 'notes'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sold_by_user_id');
    }

    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $primaryKey = 'user_id';

    protected $guarded  = [];
    //
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

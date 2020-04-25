<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = "user_roles";
    protected $fillable = [
        "user_id",
        "role_id",
    ];

    function user(){
        return $this->belongsTo('App\Models\User');
    }
    function role(){
        return $this->belongsTo('App\Models\Role');
    }
}

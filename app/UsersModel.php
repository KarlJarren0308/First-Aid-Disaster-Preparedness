<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'id', 'id');
    }
}

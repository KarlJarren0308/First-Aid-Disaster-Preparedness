<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class UsersModel extends Model
{
    protected $table = 'users';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'id', 'id');
    }

    public function elapsedCreatedAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffForHumans();
    }

    public function elapsedUpdatedAt()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->diffForHumans();
    }
}

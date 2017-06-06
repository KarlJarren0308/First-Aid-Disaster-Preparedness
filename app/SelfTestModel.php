<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class SelfTestModel extends Model
{
    protected $table = 'self_test';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'username', 'username');
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

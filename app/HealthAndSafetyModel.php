<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class HealthAndSafetyModel extends Model
{
    protected $table = 'health_and_safety';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'username', 'username');
    }

    public function media()
    {
        return $this->hasMany('App\HealthAndSafetyMediaModel', 'health_and_safety_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\HealthAndSafetyCommentsModel', 'health_and_safety_id', 'id');
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

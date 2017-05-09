<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class HealthAndSafetyCommentsModel extends Model
{
    protected $table = 'health_and_safety_comments';
    public $timestamps = true;

    public function healthAndSafetyInfo()
    {
        return $this->belongsTo('App\HealthAndSafetyModel', 'health_and_safety_id', 'id');
    }

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

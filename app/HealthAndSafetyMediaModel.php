<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class HealthAndSafetyMediaModel extends Model
{
    protected $table = 'health_and_safety_media';
    public $timestamps = true;

    public function healthAndSafetyInfo()
    {
        return $this->belongsTo('App\HealthAndSafetyModel', 'health_adn_safety_id', 'id');
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

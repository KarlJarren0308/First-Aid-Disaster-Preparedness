<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class MediaModel extends Model
{
    protected $table = 'media';
    public $timestamps = true;

    public function newsInfo()
    {
        return $this->belongsTo('App\NewsModel', 'news_id', 'id');
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

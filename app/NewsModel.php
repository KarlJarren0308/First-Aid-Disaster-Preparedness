<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class NewsModel extends Model
{
    protected $table = 'news';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'username', 'username');
    }

    public function media()
    {
        return $this->hasMany('App\MediaModel', 'news_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\CommentsModel', 'news_id', 'id');
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

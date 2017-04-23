<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    public $timestamps = true;

    public function newsInfo()
    {
        return $this->belongsTo('App\NewsModel', 'news_id', 'id');
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

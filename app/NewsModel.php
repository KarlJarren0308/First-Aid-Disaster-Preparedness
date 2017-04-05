<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = 'news';
    public $timestamps = true;

    public function accountInfo()
    {
        return $this->belongsTo('App\AccountsModel', 'username', 'username');
    }
}

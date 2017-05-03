<?php

namespace App\Http\Controllers;

use DB;

trait UtilityHelpers
{
    public function setFlash($status, $message)
    {
        session()->flash('flash_status', $status);
        session()->flash('flash_message', $message);
    }

    public function generateCode($text) {
        $salt = substr(md5($text), mt_rand(0, 27), 5);

        return sha1($salt . $text);
    }
}

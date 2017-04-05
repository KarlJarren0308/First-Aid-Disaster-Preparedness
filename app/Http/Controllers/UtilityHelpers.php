<?php

namespace App\Http\Controllers;

use DB;
use App\AccountsModel;
use App\NewsModel;
use App\UsersModel;

trait UtilityHelpers
{
    public function setFlash($status, $message)
    {
        session()->flash('flash_status', $status);
        session()->flash('flash_message', $message);
    }

    public function getAccounts($id = null)
    {
        return ($id==null ? AccountsModel::all() : AccountsModel::findOrFail($id));
    }

    public function getNews($id = null)
    {
        return ($id==null ? NewsModel::all() : NewsModel::findOrFail($id));
    }

    public function insertRecord($table, $record)
    {
        $record['created_at'] = date('Y-m-d H:i:s');

        return DB::table($table)->insertGetId($record);
    }

    public function updateRecord($table, $id, $recordToUpdate)
    {
        $record['updated_at'] = date('Y-m-d H:i:s');

        return DB::table($table)->where('id', id)->update($recordToUpdate);
    }

    public function deleteRecord($table, $id)
    {
        return DB::table($table)->where('id', $id)->delete();
    }
}

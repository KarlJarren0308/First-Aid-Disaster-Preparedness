<?php

use Illuminate\Database\Seeder;

use App\AccountsModel;
use App\UsersModel;

class AccountsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = AccountsModel::insertGetId([
            'username' => 'admin',
            'email_address' => 'pata.tim@gmail.com',
            'password' => bcrypt('admin'),
            'type' => 'administrator',
            'image' => 'karlmacz.png'
        ]);

        UsersModel::insert([
            'id' => $id,
            'first_name' => 'Pata',
            'middle_name' => 'Tita',
            'last_name' => 'Tim'
        ]);
    }
}

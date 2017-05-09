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
            'email_address' => 'fadp.system@gmail.com',
            'password' => bcrypt('admin'),
            'type' => 'administrator',
            'image' => 'admin.jpg',
            'is_verified' => true,
            'is_banned' => false
        ]);

        UsersModel::insert([
            'id' => $id,
            'first_name' => 'Juan',
            'middle_name' => '',
            'last_name' => 'Dela Cruz',
            'gender' => 'Male'
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

use App\NewsModel;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewsModel::insert([
            'headline' => 'Lorem ipsum',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore asperiores tenetur voluptatum et impedit perspiciatis aspernatur ducimus sunt dicta ea saepe delectus libero esse inventore, quibusdam nulla fugit, nam quo?

            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vero eaque deleniti, cupiditate culpa velit, libero autem qui, inventore atque quis incidunt placeat. Aut modi, quidem placeat beatae velit sunt ut.

            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas corrupti illum quaerat ducimus commodi reiciendis doloribus aliquid officiis dolorum soluta unde numquam neque odio cum a, adipisci consectetur minima magnam?',
            'username' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}

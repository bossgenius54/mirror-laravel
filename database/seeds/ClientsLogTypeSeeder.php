<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsLogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients_log_types')->insert([
            'id' => 1,
            'name' => 'создан',
        ]);
        DB::table('clients_log_types')->insert([
            'id' => 2,
            'name' => 'выписан рецепт',
        ]);
        DB::table('clients_log_types')->insert([
            'id' => 3,
            'name' => 'совершил заказ ',
        ]);
        DB::table('clients_log_types')->insert([
            'id' => 4,
            'name' => 'совершил возврат',
        ]);
    }
}

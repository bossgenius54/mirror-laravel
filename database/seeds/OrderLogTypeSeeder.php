<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderLogTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_log_types')->insert([
            'id' => 1,
            'name' => 'создал элемент',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 2,
            'name' => 'добавил услугу',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 3,
            'name' => 'удалил услугу ',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 4,
            'name' => 'добавил продукцию',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 5,
            'name' => 'удалил продукцию',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 6,
            'name' => 'изменил статус заказа на ',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 7,
            'name' => 'присвоил статус',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 8,
            'name' => 'указал/изменил предоплату',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 9,
            'name' => 'добавил/изменил заметку',
        ]);
        DB::table('order_log_types')->insert([
            'id' => 10,
            'name' => 'указал дату/изменил изготовления',
        ]);
    }
}

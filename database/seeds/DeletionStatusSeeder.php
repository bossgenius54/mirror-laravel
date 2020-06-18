<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeletionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('deletion_statuses')->insert([
            'id' => 1,
            'name' => 'В работе',
        ]);

        DB::table('deletion_statuses')->insert([
            'id' => 2,
            'name' => 'На подтверждении',
        ]);

        DB::table('deletion_statuses')->insert([
            'id' => 3,
            'name' => 'Подтвержден',
        ]);

        DB::table('deletion_statuses')->insert([
            'id' => 4,
            'name' => 'Отменен',
        ]);
    }
}
